<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Housing;
use App\Models\Offer;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{

    public function index()
    {
        $offers = Offer::where("user_id", auth()->user()->parent_id ?? auth()->user()->id)->get();
        return view('institutional.offers.index', compact('offers'));
    }

    public function create()
    {
        $projects = Project::where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->get();
        $housings = Housing::where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->get();
        return view('institutional.offers.create', compact('projects', 'housings'));
    }

    public function edit(Request $request, $id)
    {
        $projects = Project::where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->get();
        $housings = Housing::where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->get();
        $offer = Offer::find($id);
        return view('institutional.offers.edit', compact('projects', 'housings', 'id', 'offer'));
    }

    public function store(Request $request)
    {
        Offer::create(
            array_merge($request->all(),
                [
                    'user_id' => auth()->user()->parent_id ?? auth()->user()->id,
                    'project_housings' => json_encode($request->input('project_housings', [])),
                ]
            )
        );
        return redirect()->route('institutional.offers.index')->with('success', 'Kampanya Başarıyla Oluşturuldu');
    }

    public function update(Request $request, Offer $offer)
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
        return redirect()->route('institutional.offers.index')->with('success', 'Kampanya Başarıyla Güncellendi');
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();
        return redirect()->route('institutional.offers.index')->with('success', 'Kampanya Başarıyla Silindi');
    }

    public function getProjectHousingList(Request $request)
    {

        $data = DB::select('SELECT
        DISTINCT(project_id) AS pid,
        room_order AS _ROOM_ORDER,
        CONCAT(
            (SELECT MAX(value) FROM project_housings WHERE project_id = ? AND room_order = _ROOM_ORDER AND `name` = "room_count[]"),
            " Odalı ",
            (SELECT MAX(value) FROM project_housings WHERE project_id = ? AND room_order = _ROOM_ORDER AND `name` = "squaremeters[]"),
            " Metrekare ",
            (SELECT MAX(value) FROM project_housings WHERE project_id = ? AND room_order = _ROOM_ORDER AND `name` = "price[]"),
            " Fiyatlı"
        ) AS label
    FROM
        project_housings
    WHERE room_order > 0 AND project_id = ?', [$request->input('id'), $request->input('id'), $request->input('id'), $request->input('id')]);
    
        return response()->json($data);
    }

}
