<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DefaultMessage;
use App\Models\DocumentNotification;
use App\Models\DopingOrder;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\Log;
use App\Models\Project;
use App\Models\ProjectHousing;
use App\Models\ProjectHousings;
use App\Models\StandOutUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function index() {
        $projectStatuses = [
            1 => 'Aktif',
            0 => 'Pasif',
            2 => 'Admin Onayı Bekliyor',
            3 => 'Admin Tarafından Reddedildi',
        ];
        $projects = Project::orderByDesc( 'updated_at' )->get();
        return view( 'admin.projects.index', compact( 'projects', 'projectStatuses' ) );
    }

    /**
    * Show the form for creating a new resource.
    */

    public function create() {
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        return view( 'admin.projects.create', [ 'housing_types' => $housing_types, 'housing_status' => $housing_status ] );
    }

    /**
    * Store a newly created resource in storage.
    */

    public function store( Request $request ) {
        $allDatas = $request->all();
        return $allDatas;
        $vData = $request->validate( [
            'projectData.project_title' => 'required|string',
            'projectData.address' => 'required|string|max:128',
            'projectData.housing_type' => 'required|integer',
            'projectData.status' => 'required|in:1,2,3',
        ] );
        $dynamicDatas = $request->dynamicData;
        $projectId = Project::create( $vData );
        foreach ( $dynamicDatas as $data ) {
            $data[] = [ 'project_id' => $projectId ];
        }
        ProjectHousings::insert( $dynamicDatas );
        return redirect()->route( 'admin.projects.create' )->with( 'success', 'Project and housings created successfully' );
    }

    public function detail( $id ) {
        $startTime = microtime(true);
        $defaultMessages = DefaultMessage::get();
        $project = Project::where( 'id', $id )->first();
        $projectHousings = ProjectHousing::where('project_id',$id)->get();
        $projectHousingsList = [];
        $combinedValues = $projectHousings->map(function ($item) use(&$projectHousingsList) {
            $projectHousingsList[$item->room_order][$item->name] = $item->value;
        });
        $housingTypeData = HousingType::where( 'id', $project->housing_type_id )->first();
        $housingTypeData = json_decode( $housingTypeData->form_json );
        $housingData = $project->roomInfo;
        return view( 'admin.projects.detail', compact( 'startTime','project','projectHousingsList', 'housingTypeData', 'housingData', 'defaultMessages' ) );
    }

    public function setStatus( $projectId, Request $request ) {
        $project = Project::where( 'id', $projectId )->with( 'user' )->firstOrFail();
        $reason = '';
        $isRejected = 0;

        if ( $request->input( 'status' ) == 3 ) {
            $isRejected = 1;
            $reason = $request->input( 'reason' );

            $notificationText = 'Üzgünüz, Proje #' . $projectId . ' "' . $reason . '" sebebinden dolayı reddedildi.';
            $notificationLink = route( 'institutional.project.edit.v2', [ 'projectSlug' => $project->slug ] );

            DocumentNotification::create( [
                'user_id' => auth()->user()->id,
                'text' => $notificationText,
                'item_id' => $projectId,
                'link' => $notificationLink,
                'owner_id' => $project->user->id,
                'is_visible' => true,
            ] );
        } else if ( $request->input( 'status' ) == 1 ) {
            $reason = 'Başarıyla projeniz aktife alındı';

            $notificationText = 'Proje #' . $projectId . ' şu anda yayında! Tebrikler! Daha fazla detay için [Proje Detay Sayfası](' . route( 'project.detail', [ 'slug' => $project->slug ] ) . ').';

            DocumentNotification::create( [
                'user_id' => auth()->user()->id,
                'text' => $notificationText,
                'item_id' => $project->id,
                'link' => null,
                'owner_id' => $project->user->id,
                'is_visible' => true,
            ] );

            if ( $project->status == 2 ) {
                foreach ( $project->dopingOrder as $doping ) {
                    $startDate = Carbon::createFromFormat( 'Y-m-d', $doping->standOut->start_date );
                    $endDate = Carbon::createFromFormat( 'Y-m-d', $doping->standOut->end_date );
                    $dayCount = $startDate->diffInDays( $endDate );
                    $now = Carbon::now();
                    $endDate = Carbon::now()->addDays( $dayCount );

                    DopingOrder::where( 'id', $doping->id )->update( [
                        'status' => 1,
                        'admin_id' => Auth::user()->id
                    ] );

                    StandOutUser::where( 'id', $doping->standOut->id )->update( [
                        'start_date' => $now->format( 'y-m-d' ),
                        'end_date' => $endDate->format( 'y-m-d' ),
                    ] );
                }
            }
        } else {
            $notificationText = 'Proje #' . $projectId . ' pasife alındı. Proje detaylarını güncellemek için [Buraya Tıklayınız](' . route( 'institutional.project.edit.v2', [ 'projectSlug' => $project->slug ] ) . ').';

            DocumentNotification::create( [
                'user_id' => auth()->user()->id,
                'text' => $notificationText,
                'item_id' => $project->id,
                'link' => null,
                'owner_id' => $project->user->id,
                'is_visible' => true,
            ] );
        }

        $project = Project::where( 'id', $projectId )->firstOrFail();
        Project::where( 'id', $projectId )->update( [
            'status' => $request->input( 'status' ),
        ] );

        Log::create( [
            'item_type' => 1,
            'item_id' => $projectId,
            'reason' => $reason,
            'is_rejected' => $isRejected,
            'user_id' => auth()->user()->id,
        ] );

        return json_encode( [
            'status' => true,
        ] );
    }

    public function setStatusGet( $projectId ) {
        $project = Project::where( 'id', $projectId )->with( 'user' )->firstOrFail();
        if ( $project->status == 0 || $project->status == 2 || $project->status == 3 ) {
            Project::where( 'id', $projectId )->update( [
                'status' => 1,
            ] );
        }else{
            Project::where( 'id', $projectId )->update( [
                'status' => 0,
            ] );
        }

        DocumentNotification::create(
            [
                'user_id' => auth()->user()->id,
                'text' => '#'.$projectId." No'lu projeniz şu anda yayında!",
                'item_id' => $project->id,
                'link' => route( 'project.detail', [ 'slug' => $project->slug ] ),
                'owner_id' => $project->user->id,
                'is_visible' => true,
            ]
        );

        if ( $project->status == 2 ) {
            foreach ( $project->dopingOrder as $doping ) {
                $startDate = Carbon::createFromFormat( 'Y-m-d', $doping->standOut->start_date );
                $endDate = Carbon::createFromFormat( 'Y-m-d', $doping->standOut->end_date );
                $dayCount = $startDate->diffInDays( $endDate );
                $now = Carbon::now();
                $endDate = Carbon::now()->addDays( $dayCount );
                DopingOrder::where( 'id', $doping->id )->update( [
                    'status' => 1,
                    'admin_id' => Auth::user()->id
                ] );

                StandOutUser::where( 'id', $doping->standOut->id )->update( [
                    'start_date' => $now->format( 'y-m-d' ),
                    'end_date' => $endDate->format( 'y-m-d' ),
                ] );
            }

        } else {
            DocumentNotification::create(
                [
                    'user_id' => auth()->user()->id,
                    'text' => "#".$projectId." No'lu projeniz pasife alındı!",
                    'item_id' => $project->id,
                    'link' => route( 'institutional.project.edit.v2', [ 'projectSlug' => $project->slug ] ),
                    'owner_id' => $project->user->id,
                    'is_visible' => true,
                ]
            );

        }

        if ( $project->status == 1 ) {
            Log::create( [
                'item_type' => 1,
                'item_id' => $projectId,
                'reason' => "#".$projectId." No'lu projeniz admin tarafından pasife alındı.",
                'is_rejected' => 0,
                'user_id' => auth()->user()->id,
            ] );
        } else {
            Log::create( [
                'item_type' => 1,
                'item_id' => $projectId,
                'reason' => "#".$projectId." No'lu projeniz admin tarafından aktif edildi.",
                'is_rejected' => 0,
                'user_id' => auth()->user()->id,
            ] );
        }

        return redirect()->route( 'admin.projects.detail', $projectId );
    }

    public function logs( $projectId ) {
        $logs = Log::where( 'item_type', 1 )->where( 'item_id', $projectId )->orderByDesc( 'created_at' )->with( 'user' )->get();
        return view( 'admin.projects.logs', compact( 'logs' ) );
    }
}
