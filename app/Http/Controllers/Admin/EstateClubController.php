<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\Coupon;
use App\Models\CouponItem;
use App\Models\DocumentNotification;
use App\Models\EmailTemplate;
use App\Models\Housing;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EstateClubController extends Controller {
    public function index() {
        $estateClubUsers = User::with( 'collections', 'shares' )->where( 'type', '21' )->where( 'status', 1 )->get();

        return view( 'admin.estate_club.index', compact( 'estateClubUsers' ) );
    }

    public function createCoupon( $userId ) {
        $projects = Project::where( 'status', 1 )->get();
        $housings = Housing::where( 'status', 1 )->get();
        $estateClubUser = User::wherE( 'type', 21 )->where( 'status', 1 )->where( 'id', $userId )->first();
        return view( 'admin.estate_club.create_coupon', compact( 'estateClubUser', 'projects', 'housings' ) );
    }

    public function createCouponStore( Request $request, $userId ) {
        $coupon = Coupon::create( [
            'coupon_code' => $request->input( 'code' ),
            'use_count' => $request->input( 'use_count' ),
            'discount_type' => $request->input( 'discount_type' ),
            'amount' => str_replace( '.', '', $request->input( 'buyer_amount' ) ),
            'estate_club_user_amount_type' => $request->input( 'estate_club_user_amount_type' ),
            'estate_club_user_amount' => str_replace( '.', '', $request->input( 'estate_club_user_amount' ) ),
            'time_type' => $request->input( 'date_fix' ),
            'start_date' => $request->input( 'start_date' ),
            'end_date' => $request->input( 'end_date' ),
            'select_projects_type' => $request->input( 'select_project_check' ),
            'select_housings_type' => $request->input( 'select_housing_check' ),
            'user_id' => $userId,
            'estate_id' => auth()->guard()->user()->id,
        ] );

        $clubUser = User::where( 'id', $userId )->first();

        if ( $request->input( 'select_project_check' ) == 2 ) {
            for ( $i = 0; $i < count( $request->input( 'projects' ) );
            $i++ ) {
                CouponItem::create( [
                    'item_id' => $request->input( 'projects' )[ $i ],
                    'item_type' => 1,
                    'coupon_id' => $coupon->id,
                ] );
            }
        }

        if ( $request->input( 'select_housing_check' ) == 2 ) {
            for ( $i = 0; $i < count( $request->input( 'housings' ) );
            $i++ ) {
                CouponItem::create( [
                    'item_id' => $request->input( 'housings' )[ $i ],
                    'item_type' => 2,
                    'coupon_id' => $coupon->id,
                ] );
            }
        }

        $emailTemplate = EmailTemplate::where( 'slug', 'send-code' )->first();

        if ( !$emailTemplate ) {
            return response()->json( [
                'message' => 'Email template not found.',
                'status' => 203,
                'success' => true,
            ], 203 );
        }

        $content = $emailTemplate->body;
        $discountType = $request->input( 'discount_type' );
        $buyerAmount = str_replace( '.', '', $request->input( 'buyer_amount' ) );
        $date = null;
        $date = null;

        if ($request->input('date_fix') == 1) {
            $date = 'Sınırsız';
        } else {
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
            $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
        
            $date = $startDate->isoFormat('LL') . ' - ' . $endDate->isoFormat('LL');
        }
        

        $discount = null;

        if ( $discountType == 1 ) {
            $discount = '%' . $buyerAmount ;
        } elseif ( $discountType == 2 ) {
            $discount = $buyerAmount .  '₺';
        }

        $variables = [
            'username' => $clubUser->name,
            'companyName' => 'Emlak Sepette',
            'code' => $request->input( 'code' ),
            'discount' => $discount,
            'maxUsageCount' => $request->input( 'use_count' ),
            'date' => $date
        ];

        foreach ( $variables as $key => $value ) {
            $content = str_replace( '{{' . $key . '}}', $value, $content );
        }

        Mail::to( $clubUser->email )->send( new CustomMail( $emailTemplate->subject, $content ) );
        DocumentNotification::create( [
            'user_id' => 4,
            'text' => '🏡 Özel Teklif! Emlak Sepette İndirim Kuponu Sizi Bekliyor!',
            'item_id' => $clubUser->parent_id ?? $clubUser->id,
            'link' => route( 'institutional.index' ),
            'owner_id' => $clubUser->parent_id ?? $clubUser->id,
            'is_visible' => true,
        ] );

        return redirect()->route( 'admin.estate.coupons' );
    }

    public function coupons() {
        $activeCoupons = Coupon::where('estate_id', auth()->guard()->user()->id)
            ->where(function ($query) {
                $query->where('end_date', '>=', now())
                    ->orWhere(function ($query) {
                        $query->whereNull('end_date')
                            ->whereNull('start_date')
                            ->where('time_type', 1);
                    });
            })
            ->get();
    
        $expiredCoupons = Coupon::where('estate_id', auth()->guard()->user()->id)
            ->where('end_date', '<', now()) 
            ->get();

    
        return view('admin.estate_club.coupons', compact('activeCoupons', 'expiredCoupons'));
    }
    
    

    public function editCoupon( $id ) {
        $coupon = Coupon::where( 'id', $id )->first();
        $projects = Project::where( 'status', 1 )->get();
        $housings = Housing::where( 'status', 1 )->get();
        $estateClubUser = User::wherE( 'type', 21 )->where( 'status', 1 )->where( 'id', $coupon->user_id )->first();

        return view( 'admin.estate_club.edit_coupon', compact( 'coupon', 'estateClubUser', 'projects', 'housings' ) );
    }

    public function destroy( $id ) {
        Coupon::where( 'estate_id', auth()->guard()->user()->id )->where( 'id', $id )->delete();

        return redirect()->route( 'admin.estate.coupons' )->with( 'success', 'Başarıyla kuponu kaldırdınız' );
    }
}
