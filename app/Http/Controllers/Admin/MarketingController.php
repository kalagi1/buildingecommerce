<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketedProject;
use App\Models\Project;
use App\Models\ProjectMarketing;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function marketing()
    {
        $projects = Project::select()->join('marketed_projects', 'marketed_projects.project_id', '<>', 'projects.id')->get();
        $avaliableMarketings = ProjectMarketing::where();
        $marketings = ProjectMarketing::all();
        return view('admin.marketing.index', compact('marketings', 'avaliableMarketings', 'projects'));
    }
    public function market(Request $req)
    {
        $postData = $req->validate([
            'project_id' => 'required|integer',
            //veritabanında veri var mı kontrolü eklenecek
            'marketing_id' => 'required|integer',
            'months' => 'required|integer'
        ]);
        $month = $postData['months'];
        $date_end = date('Y-m-d', strtotime('+' . $month . ' months'));
        $date_start = date('Y-m-d');

        MarketedProject::create([
            'project_id' => $postData['project_id'],
            'marketing_id' => $postData['marketing_id'],
            'date_start' => $date_start,
            'date_end' => $date_end
        ]);
        return redirect()->route('admin.marketing.project.index')->with('success', 'Project marketed succesfully');
    }
    public function storeMarketing(Request $request)
    {
        $postData = $request->validate([
            'order' => 'required|integer|unique:projects_marketing',
            'price' => 'required|integer'
        ]);
        ProjectMarketing::create($postData);
        return redirect()->route('admin.marketing.project.index')->with('success', 'Marketing created successfully');
    }
    public function updateMarketing(Request $request)
    {
        $postData = $request->validate(([
            'order' => 'required|integer',
            'price' => 'required|integer'
        ]));
        $marketing = ProjectMarketing::where('order', $postData['order']);
        $marketing->update($postData);
        return redirect()->route('admin.marketing.project.index')->with('success', 'Marketing updated successfully');
    }
    public function getMarketing(Request $req)
    {
        $order = $req->order;
        $marketing = ProjectMarketing::where('order', $order);
        return $marketing;
    }

    public function marketedProjects()
    {

        $marketedProjects = MarketedProject::select(
            'projects.project_title',
            'projects_marketing.order',
            'marketed_projects.date_start',
            'marketed_projects.date_end'
        )->join('projects', 'projects.id', '=', 'marketed_projects.project_id')
            ->join('projects_marketing', 'projects_marketing.order', '=', 'projects.order')
            ->get();
        return view('admin.marketing.marketed', compact('marketedProjects'));
    }

}