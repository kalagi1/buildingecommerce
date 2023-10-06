<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateOfferRequest;
use App\Http\Requests\UpdateOfferRequest;

class OfferController extends Controller
{
    
    function index()
    {
        $offers = Offer::where("user_id", auth()->user()->id)->with(['project' => function($query)
        {
            $query->select('id', 'project_title');   
        }])->get();
        return view('institutional.offers.index', compact('offers'));
    }

    function create()
    {
        $projects = Project::where('user_id', auth()->user()->id)->get();
        return view('institutional.offers.create', compact('projects'));
    }

    function edit(Request $request, $id)
    {
        $projects = Project::where('user_id', auth()->user()->id)->get();
        $offer = Offer::find($id);
        return view('institutional.offers.edit', compact('projects', 'id', 'offer'));
    }

    function store(CreateOfferRequest $request)
    {
        Offer::create(array_merge($request->all(), ['user_id' => auth()->user()->id, 'project_housings' => json_encode($request->input('project_housings'))]));
        return redirect()->route('institutional.offers.index')->with('success', 'Offer updated successfully');
    }

    function update(UpdateOfferRequest $request, Offer $offer)
    {
        $offer->update(
            [
                'discount_amount' => $request->input('discount_amount'),
                'project_id' => $request->input('project_id'),
                'project_housings' => json_encode($request->input('project_housings')),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ]
        );
        return redirect()->route('institutional.offers.index')->with('success', 'Offer updated successfully');
    }

    function destroy(Offer $offer)
    {
        $offer->delete();
        return redirect()->route('institutional.offers.index')->with('success', 'Offer deleted successfully');
    }

    function getProjectHousingList(Request $request)
    {
        
        $data = DB::select('SELECT
            DISTINCT(project_id) AS pid,
            room_order AS _ROOM_ORDER,
            CONCAT(
                room_order,
                ". ", 
                (SELECT value FROM project_housings WHERE project_id = ? AND room_order = _ROOM_ORDER AND `key` = "Oda Sayısı"),
                " Odalı ",
                (SELECT value FROM project_housings WHERE project_id = ? AND room_order = _ROOM_ORDER AND `key` = "Metrekare"),
                " Metrekare ",
                (SELECT value FROM project_housings WHERE project_id = ? AND room_order = _ROOM_ORDER AND `key` = "Fiyat"),
                " Fiyatlı Daire"
            ) AS label
        FROM
            project_housings
        WHERE room_order > 0 AND project_id = ?', [$request->input('id'), $request->input('id'), $request->input('id'), $request->input('id')]);

        return response()->json($data);
    }

}
