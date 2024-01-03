<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\CartOrder;
use App\Models\EmailTemplate;
use App\Models\Housing;
use App\Models\HousingComment;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Reservation;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller {
    public function index() {
        $countUser = User::where( 'status', '1' )->get()->count();
        $comments = HousingComment::with( 'user', 'housing' )->get();
        $clients = User::where( 'type', '1' )->get();
        $institutionals = User::where( 'type', '2' )->get();
        $projects = Project::where( 'status', '1' )->get();
        $passiveProjects = Project::where( 'status', '0' )->get();
        $descProjects = Project::orderBy( 'id', 'desc' )->with( 'user', 'city', 'county' )->limit( 4 )->get();
        $secondhandHousings = Housing::all();
        return view( 'admin.home.index', compact( 'comments', 'countUser', 'passiveProjects', 'clients', 'institutionals', 'projects', 'secondhandHousings', 'descProjects' ) );
    }

    public function getPackageOrders() {
        $cartOrders = UserPlan::with( 'user', 'subscriptionPlan' )->where( 'subscription_plan_id', '!=', NULL )->get();
        return view( 'admin.package-orders.index', compact( 'cartOrders' ) );
    }

    public function getOrders() {
        $cartOrders = CartOrder::with( 'user' )->orderByDesc('created_at')->get();
        return view( 'admin.orders.index', compact( 'cartOrders' ) );
    }

    public function getReservations() {
        $housingReservations = Reservation::with( 'user', 'housing',"owner" )
        ->get();

        return view( 'admin.reservations.index', compact( 'housingReservations' ) );
    }

    public function approveOrder( CartOrder $cartOrder ) {
        $cartOrder->update( [ 'status' => '1' ] );
        $cart = json_decode( $cartOrder->cart );
        $fatura = new Invoice();
        $fatura->order_id = $cartOrder->id;
        $fatura->total_amount = $cart->item->price;
        $fatura->invoice_number = 'FTR-' . time() . $cartOrder->id;
        // Fatura numarası oluşturabilirsiniz.
        $fatura->save();

        $project = Project::where( 'id', $cart->item->id )->with( 'user' )->first();

        $user = User::where( 'id', $cartOrder->user_id )->first();
        $newSeller = EmailTemplate::where( 'slug', 'new-seller' )->first();

        if ( !$newSeller ) {
            return response()->json( [
                'message' => 'Email template not found.',
                'status' => 203,
                'success' => true,
            ], 203 );
        }

        $newSellerContent = $newSeller->body;

        $newSellerVariables = [
            'customerName' => $user->name,
            'customerEmail' => $user->email,
            'salesAmount' => $cartOrder->amount,
            'salesDate' => $cartOrder->created_at,
            'companyName' => 'Emlak Sepette',
            'email' => $user->email,
            'token' => $user->email_verification_token,
            'storeOwnerName' => $project ? $project->user->name : '',
            'invoiceLink' => route( 'institutional.invoice.show', $cartOrder->id ),
        ];

        foreach ( $newSellerVariables as $key => $value ) {
            $newSellerContent = str_replace( '{{' . $key . '}}', $value, $newSellerContent );
        }

        Mail::to( $user->email )->send( new CustomMail( $newSeller->subject, $newSellerContent ) );

        $newSeller = EmailTemplate::where( 'slug', 'new-seller' )->first();

        if ( !$newSeller ) {
            return response()->json( [
                'message' => 'Email template not found.',
                'status' => 203,
                'success' => true,
            ], 203 );
        }

        $newSellerContent = $newSeller->body;

        $newSellerVariables = [
            'customerName' => $user->name,
            'customerEmail' => $user->email,
            'salesAmount' => $cartOrder->amount,
            'salesDate' => $cartOrder->created_at,
            'companyName' => 'Emlak Sepette',
            'email' => $user->email,
            'token' => $user->email_verification_token,
            'storeOwnerName' => $project ? $project->user->name : '',
            'invoiceLink' => route( 'institutional.invoice.show', $cartOrder->id ),
        ];

        foreach ( $newSellerVariables as $key => $value ) {
            $newSellerContent = str_replace( '{{' . $key . '}}', $value, $newSellerContent );
        }

        Mail::to( $user->email )->send( new CustomMail( $newSeller->subject, $newSellerContent ) );

        return redirect()->back();
    }

    public function unapproveOrder( CartOrder $cartOrder ) {
        $cartOrder->update( [ 'status' => '2' ] );
        return redirect()->back();
    }

    public function approvePackageOrder( UserPlan $userPlan ) {
        $userPlan->update( [ 'status' => '1' ] );
        return redirect()->back();
    }

    public function unapprovePackageOrder( UserPlan $userPlan ) {
        $userPlan->update( [ 'status' => '2' ] );
        return redirect()->back();
    }

    public function approveReservation( Reservation $reservation ) {
        $reservation->update( [ 'status' => '1' ] );
        return redirect()->back();
    }

    public function unapproveReservation( Reservation $reservation ) {
        $reservation->update( [ 'status' => '2' ] );
        return redirect()->back();
    }

}
