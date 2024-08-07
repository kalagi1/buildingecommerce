<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Jobs\SendCustomMail;
use App\Mail\CustomMail;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::all();
        return view('admin.email-templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.email-templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:email_templates',
            'subject' => 'required',
            'body' => 'required',
        ]);

        $template = new EmailTemplate();
        $template->name = $request->input('name');
        $template->subject = $request->input('subject');
        $template->body = $request->input('body');
        $template->slug = Str::slug($request->input('name'));
        $template->save();

        return redirect()->route('admin.email-templates.index');
    }

    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return view('admin.email-templates.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('email_templates')->ignore($id),
            ],
            'subject' => 'required',
            'body' => 'required',
        ]);

        $template = EmailTemplate::findOrFail($id);
        $template->name = $request->input('name');
        $template->subject = $request->input('subject');
        $template->body = $request->input('body');
        $template->slug = Str::slug($request->input('name'));
        $template->save();

        return redirect()->route('admin.email-templates.index');
    }

    public function destroy($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $template->delete();
        return redirect()->route('admin.email-templates.index');
    }

    public function MultipleMail(){
        // $users = User::all();
        // foreach($users  as $user){
            
        //     Subscription::create([
        //         'user_id' => $user->id
        //     ]);
        // }
        return view('admin.multiple_mail.create');
    }

    public function MultipleMailStore(Request $request){
        $title = $request->title;
        $content = htmlspecialchars($request->content, ENT_QUOTES, 'UTF-8');
        $userIds = $request->selectedUsers;
    
        foreach ($userIds as $userId) {
            $user = User::find($userId);
            if ($user) {
                SendCustomMail::dispatch($user->email, $content, $title);
            }
        }    
        return redirect()->back()->with('success','Sms Başarıyla Gönderildi.');
    }

    public function MultipleMailGetUsers(){
        // $users = User::all(['id', 'name','email']);

        $user_ids = Subscription::pluck('user_id');

        $users = [];

        foreach ($user_ids as $user_id) {
            $user = User::find($user_id);

            if ($user) {
                $users[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ];
            }
        }
        return response()->json($users);
    }

    public function MultipleMailGetUsersBireysel(){
        // $users = User::where('type',1)->get(); 
        $user_ids = Subscription::pluck('user_id');

        $users = [];

        foreach ($user_ids as $user_id) {
            $user = User::where('id',$user_id)->where('type',1)->first();

            if ($user) {
                $users[] = $user;
            }
        }
        return response()->json($users);
    }//End

    public function MultipleMailGetUsersKurumsal(){
        // $users = User::whereNotIn('type', [1, 3])->get();
        $user_ids = Subscription::pluck('user_id');

        $users = [];

        foreach ($user_ids as $user_id) {
            $user = User::where('id',$user_id)->whereNotIn('type', [1, 3])->first();

            if ($user) {
                $users[] = $user;
            }
        }
        return response()->json($users);
    }//End
}
