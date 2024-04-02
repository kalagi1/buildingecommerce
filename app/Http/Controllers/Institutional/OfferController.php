<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Housing;
use App\Models\Offer;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller {

    public function index() {
        $offers = Offer::with( 'project', 'housing' )->where( 'user_id', auth()->user()->parent_id ?? auth()->user()->id )->get();
        return view( 'institutional.offers.index', compact( 'offers' ) );
    }

    public function create() {
        $projects = Project::where( 'user_id', auth()->user()->parent_id ?? auth()->user()->id )->where( 'status', '1' )->get();
        $housings = Housing::where( 'user_id', auth()->user()->parent_id ?? auth()->user()->id )->get();
        return view( 'institutional.offers.create', compact( 'projects', 'housings' ) );
    }

    public function edit( Request $request, $id ) {
        $projects = Project::where( 'user_id', auth()->user()->parent_id ?? auth()->user()->id )->get();
        $housings = Housing::where( 'user_id', auth()->user()->parent_id ?? auth()->user()->id )->get();
        $offer = Offer::find( $id );
        return view( 'institutional.offers.edit', compact( 'projects', 'housings', 'id', 'offer' ) );
    }

    public function store( Request $request ) {
        $request->validate( [
            'discount_amount' => 'required|numeric',
            'type' => 'required|in:housing,project',
            'housing_id' => 'required_if:type,housing',
            'project_id' => 'required_if:type,project',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'housing_ids' => 'required_if:type,project'
        ] );

        $offer = new Offer();
        $discount_amount = str_replace( '.', '', $request->input( 'discount_amount' ) );
        $offer->discount_amount = ( float ) $discount_amount;
        $offer->type = $request->input( 'type' );
        $offer->start_date = $request->input( 'start_date' );
        $offer->end_date = $request->input( 'end_date' );
        $offer->user_id = auth()->user()->parent_id ?? auth()->user()->id;

        if ( $request->input( 'type' ) === 'housing' ) {
            $offer->housing_id = $request->input( 'housing_id' );
        } else {
            $offer->project_id = $request->input( 'project_id' );
            $offer->project_housings = $request->input( 'housing_ids' );
        }

        $offer->save();

        return redirect()->route( 'institutional.offers.index' )->with( 'success', 'Kampanya Başarıyla Oluşturuldu' );
    }

    public function update( Request $request, Offer $offer ) {
        $offer->update(
            [
                'discount_amount' => $request->input( 'discount_amount' ),
                'project_id' => $request->input( 'project_id' ),
                'project_housings' => json_encode( $request->input( 'checkCampaigns' ) ),
                'start_date' => $request->input( 'start_date' ),
                'end_date' => $request->input( 'end_date' ),
            ]
        );
        return redirect()->route( 'institutional.offers.index' )->with( 'success', 'Kampanya Başarıyla Güncellendi' );
    }

    public function destroy( Offer $offer ) {
        $offer->delete();
        return redirect()->route( 'institutional.offers.index' )->with( 'success', 'Kampanya Başarıyla Silindi' );
    }

    public function getProjectHousingList( Request $request ) {

        $project = Project::where( 'id', $request->input( 'id' ) )
        ->where( 'status', 1 )
        ->with( 'brand', 'blocks', 'listItemValues', 'neighbourhood', 'roomInfo', 'housingType', 'county', 'city', 'user.brands', 'user.housings', 'images' )
        ->first();

        $offers = Offer::where( 'project_id', $request->input( 'id' ) )->get();

        $selectedHousings = [];
        $allSelectedHousings = [];
        if (isset($request->offerID)) {
            $selectedHousings    = Offer::where( 'id', $request->offerID )->where( 'project_id', $request->input( 'id' ) )->value( 'project_housings' );

        }


        foreach ( $offers as $offer ) {

            $projectHousings = json_decode( $offer->project_housings );
            $allSelectedHousings = array_merge( $allSelectedHousings, $projectHousings );
        }
        $selectedHousings = json_decode( $selectedHousings );
        $differentHousings = [];

        foreach ( $allSelectedHousings as $housing ) {
            if ( !in_array( $housing, $selectedHousings ) ) {
                $differentHousings[] = $housing;
            }
        }

        return response()->json( [
            'data' => [
                'room_count' => isset( $project->room_count ) && $project->room_count ? $project->room_count : 0,
                'selected_housings'   => $selectedHousings,
                'allSelectedHousings' => $allSelectedHousings,
                'differentHousings'   => $differentHousings
            ]
        ] );
    }

}
