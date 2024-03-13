<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\CartOrder;
use App\Models\EmailTemplate;
use App\Models\Housing;
use App\Models\NeighborView;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NeighborViewController extends Controller {
    public function store( Request $request ) {
        
        $userId = $request->input( 'user_id' );
        $orderId = $request->input( 'order_id' );

        $cartOrder = CartOrder::where( 'id', $request->input( 'order_id' ) )->first();

        $user =  User::where( 'id', $userId )->first();
        $order = CartOrder::where( 'id', $orderId )->first();
        $cart = json_decode( $order->cart );
        $project = null;
        $roomOrder = null;

        if ( $cart->type == 'project' ) {
            $project = Project::where( 'id', $cart->item->id )->with( 'brand', 'roomInfo', 'housingType', 'county', 'city', 'user.projects.housings', 'user.brands', 'user.housings', 'images' )->first();
            $roomOrder = $cart->item->housing;
        } else {
            $project = Housing::where( 'id', $cart->item->id )->with( 'user' )->first();
        }

        $existingRecord = NeighborView::where( 'user_id', $userId )
        ->where( 'project_id', $project->id )
        ->where( 'housing', $roomOrder )
        ->first();

        return  $project->id . $roomOrder . $userId;
        if ( !$existingRecord ) {

            NeighborView::create( [
                'user_id' => $userId,
                'owner_id' => $cartOrder->user_id,
                "order_id" => $orderId,
                'housing' => $roomOrder,
                'project_id' => $project->id,
                'status' => $request->input( 'status' ),
                'key' => $request->input( 'key' ),
                'amount' => $request->input( 'amount' ),
            ] );

            $applyPaymentOrder = EmailTemplate::where( 'slug', 'neighbor-payment-confirmation' )->first();

            if ( !$applyPaymentOrder ) {
                return response()->json( [
                    'message' => 'Apply Payment Order email template not found.',
                    'status' => 203,
                    'success' => true,
                ], 203 );
            }

            $applyPaymentOrderContent = $applyPaymentOrder->body;

            $applyPaymentOrderVariables = [
                'username' => $user->name,
                'project' => $project->project_title,
                'housingNo' => $roomOrder,
                'companyName' => 'Emlak Sepette'
            ];

            foreach ( $applyPaymentOrderVariables as $key => $value ) {
                $applyPaymentOrderContent = str_replace( '{{' . $key . '}}', $value, $applyPaymentOrderContent );
            }

            Mail::to( $user->email )->send( new CustomMail( $applyPaymentOrder->subject, $applyPaymentOrderContent ) );

            return response()->json( [ 'success' => true, 'message' => 'Successfully saved.' ], 200 );
        } else {
            return response()->json( [ 'success' => false, 'message' => 'Record already exists.' ], 400 );
        }
    }
}
