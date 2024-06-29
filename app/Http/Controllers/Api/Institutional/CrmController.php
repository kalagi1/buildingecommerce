<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AssignedUser;
use App\Models\Customer;
use App\Models\CustomerCall;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CrmController extends Controller
{
    public function index(Request $request){
        $customers = Customer::with("project")->where('was_meeting',$request->input('was_meeting'))->where(function($query) {
            $query->where('user',auth()->guard()->user()->id)
                  ->orWhereNull('user');
        });

        if($request->input('selected_meet_type')){
            $customers = $customers->where('meet_type',$request->input('selected_meet_type'));
        }

        if($request->input('selected_rating')){
            $customers = $customers->where('rating',$request->input('selected_rating'));
        }

        if($request->input('selected_customer_status')){
            $customers = $customers->where('customer_status',$request->input('selected_customer_status'));
        }

        if($request->input('selected_conclusion')){
            $customers = $customers->where('conclusion',$request->input('selected_conclusion'));
        }

        $customers = $customers->get();

        $user = auth()->guard()->user();


        if(auth()->guard()->user()->parent){
            $parentProjects = Project::select(DB::raw('project_title as label , id as value'))->where('user_id',$user->parent->id)->get();
        }else{
            $parentProjects = Project::select(DB::raw('project_title as label , id as value'))->where('user_id',$user->id)->get();
        }
        

        return json_encode([
            "data" => $customers,
            "projects" => $parentProjects
        ]);
    }

    public function update(Request $request,$id){
        $request->validate([
            "key" => "required",
            "value" => "required" 
        ]);

        Customer::where('id',$id)->update([
            $request->input('key') => $request->input('value') 
        ]);

        return json_encode([
            "status" => true
        ]);
    }

    public function newCallRecord(Request $request){

        $validatedData = $request->validate([
            'customer_id'      => 'required|exists:customers,id',
            'meet_date'        => 'required|date',
            'note'             => 'nullable|string',
            'meet_type'        => 'nullable|in:1,2,3,4',
            'presentation'     => 'nullable|boolean',
            'conclusion'       => 'nullable|in:1,2,3',
            'appointment_date' => 'nullable',
            'appointment_info' => 'nullable',
            'name'             => 'nullable'  
        ]);

        // Save the call record
        $callRecord = CustomerCall::create([
            'customer_id'  => $validatedData['customer_id'],
            'meeting_date' => $validatedData['meet_date'],
            'note'         => $validatedData['note'],
            'presentation' => $validatedData['presentation'],
            'conclusion'   => $validatedData['conclusion'],
            'meet_type'    => $validatedData['meet_type']
        ]);

        return response()->json(['message' => 'Call record saved successfully', 'data' => $callRecord], 201);
    }//End

    public function newAppointment(Request $request){
        $validatedData = $request->validate([
            'customer_id'      => 'required|exists:customers,id',
            'appointment_date' => 'nullable|required_if:conclusion,1|date',
            'appointment_info' => 'nullable|required_if:conclusion,1|string',
        ]);
        $appointmentData = [
            'customer_id'      => $validatedData['customer_id'],
            'appointment_date' => $validatedData['appointment_date'],
            'appointment_info' => $validatedData['appointment_info'],
        ];

        Appointment::create($appointmentData);
    

        return response()->json(['message' => 'Call record saved successfully', 'data' => $appointmentData]);
    }//End

    public function fetchCustomers($customerId){
        $customers = DB::table('customer_calls')->where('customer_id',$customerId)->get();
        if($customers){
            return response()->json(['message' => 'Customer found', 'data' => $customers],
            200);
        }else{
            return response()->json(['message' => 'customers not found']);
        }

    }//End

    public function allAppointments(){
        $appointments = DB::table('appointments')->get();
        if($appointments){
            return response()->json(['message' => 'Appointments found', 'data' => $appointments], 200);
        }else{
            return response()->json(['message' => 'Appointments not found']);
            }
    }//End

    public function getByDate($date){
        $formattedDate = Carbon::parse($date)->format('Y-m-d');

        $appointments = Appointment::whereDate('appointment_date', $formattedDate)->get();
        // $appointments = Appointment::whereDate('appointment_date', $date)->get();

        return response()->json($appointments);
    }//End

    public function getByCustomer($id){
        $customer = Customer::find($id);
        $project  = Project::where('id', $customer->interested_project)->first();

        return response()->json([
            'message'  => 'customer found',
            'data'     => $customer,
            'project'  => $project
        ]);
    }//End

    public function getByProject($id){
        $project = Project::find($id);

        return response()->json([
            'message'  => 'customer found',
            'data'     => $project
        ]);
    }//End
    public function show($id){
        $customer = Customer::with("meets","project")->where('id',$id)->first();

        return json_encode([
            "customer" => $customer
        ]);
    }//End

    public function getAllUsers(){
        $users = AssignedUser::all();
        return response()->json([
           'data' => $users   
        ]);
    }//End

    public function getAllProjects(){
        $projects = Project::all();
        return response()->json([
           'data' => $projects   
        ]);
    }//End

    public function addProjectAssigment(Request $request){

        $projectIds = $request->projectIds;
        $userId = $request->userId;

        foreach ($projectIds as $projectId) {
            DB::table('project_assigment')->insert([
                'user_id'    => $userId,
                'project_id' => $projectId,
                'created_at' => now()
            ]);
        }

        return response()->json([
            'message' => 'Başarıyla kaydedildi'
        ]);
    }//End

    public function getUserProjects($userId){
        try {
            $userProjects = DB::table('project_assigment')->where('user_id', $userId)
                ->join('projects', 'project_assigment.project_id', '=', 'projects.id')
                ->select('projects.*', 'project_assigment.created_at')
                ->get();

            return response()->json([
                'data' => $userProjects,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
            ], 500);
        }
    }//End

    public function getAssignedProjectDetails($userId){
        try {
            // Belirli kullanıcının atanmış projelerini getir
            $assignedProjects = DB::table('project_assigment')->where('user_id', $userId)->pluck('project_id');

            // Projelerin detaylarını getir
            $projects = Project::whereIn('id', $assignedProjects)->get();

            return response()->json([
                'success' => true,
                'data' => $projects,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching assigned project details.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function fetchProjectAssigments(){
        try {
            $assignments = DB::table('project_assigment')
                ->join('assigned_users', 'project_assigment.user_id', '=', 'assigned_users.id')
                ->join('projects', 'project_assigment.project_id', '=', 'projects.id')
                ->select('project_assigment.*', 'assigned_users.name as user_name', 'assigned_users.email as user_email', 'projects.project_title as project_title')
                ->get();

            return response()->json([
                'data' => $assignments,
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching project assignments',
                'error' => $e->getMessage()
            ], 500);
        }
    }//End

    public function removeProjectAssignment(Request $request){
        try {
            DB::table('project_assigment')
                ->where('user_id', $request->input('userId'))
                ->where('project_id', $request->input('projectId'))
                ->delete();

            return response()->json([
                'message' => 'Project assignment removed successfully',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error removing project assignment',
                'error' => $e->getMessage()
            ], 500);
        }
    }//End

    public function addUser(Request $request){
           // Create a new user
           $user = new AssignedUser();
           $user->name      = $request->name;
           $user->email     = $request->email;
           $user->phone     = $request->phone;
           $user->job_title = $request->job_title;
           $user->save();

           return response()->json(['message' => 'User added successfully', 'data' => $user], 201);

    }//End
}
