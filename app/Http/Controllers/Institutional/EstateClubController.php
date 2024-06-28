<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponItem;
use App\Models\Housing;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class EstateClubController extends Controller
{
    public function index(){
        $estateClubUsers = User::where('type','21')->where('status',1)->get();

        return view('institutional.estate_club.index',compact('estateClubUsers'));
    }

    public function createCoupon($userId){
        $projects = Project::where('user_id',auth()->guard()->user()->id)->where('status',1)->get();
        $housings = Housing::where('user_id',auth()->guard()->user()->id)->where('status',1)->get();
        $estateClubUser = User::wherE('type',21)->where('status',1)->where('id',$userId)->first();
        return view('institutional.estate_club.create_coupon',compact('estateClubUser','projects','housings'));
    }

    public function createCouponStore(Request $request,$userId){
        $coupon = Coupon::create([
            "coupon_code" => $request->input('code'),
            "use_count" => $request->input('use_count'),
            "discount_type" => $request->input('discount_type'),
            "amount" => str_replace('.','',$request->input('buyer_amount')),
            "estate_club_user_amount_type" => $request->input('estate_club_user_amount_type'),
            "estate_club_user_amount" => str_replace('.','',$request->input('estate_club_user_amount')),
            "time_type" => $request->input('date_fix'),
            "start_date" => $request->input('start_date'),
            "end_date" => $request->input('end_date'),
            "select_projects_type" => $request->input('select_project_check'),
            "select_housings_type" => $request->input('select_housing_check'),
            "user_id" => $userId,
            "estate_id" => auth()->guard()->user()->id,
        ]);

        if($request->input('select_project_check') == 2){
            for($i = 0; $i < count($request->input('projects')); $i++){
                CouponItem::create([
                    "item_id" => $request->input('projects')[$i],
                    "item_type" => 1,
                    "coupon_id" => $coupon->id,
                ]);
            }
        }

        if($request->input('select_housing_check') == 2){
            for($i = 0; $i < count($request->input('housings')); $i++){
                CouponItem::create([
                    "item_id" => $request->input('housings')[$i],
                    "item_type" => 2,
                    "coupon_id" => $coupon->id,
                ]);
            }
        }

        return redirect()->route('institutional.estate.coupons');
    }


    public function coupons(){
        $coupons = Coupon::where('estate_id',auth()->guard()->user()->id)->get();

        return view('institutional.estate_club.coupons',compact('coupons'));
    }

    public function editCoupon($id){
        $coupon = Coupon::where('id',$id)->first();
        $projects = Project::where('user_id',auth()->guard()->user()->id)->where('status',1)->get();
        $housings = Housing::where('user_id',auth()->guard()->user()->id)->where('status',1)->get();
        $estateClubUser = User::wherE('type',21)->where('status',1)->where('id',$coupon->user_id)->first();

        return view('institutional.estate_club.edit_coupon',compact('coupon','estateClubUser','projects','housings'));
    }

    public function destroy($id){
        Coupon::where('estate_id',auth()->guard()->user()->id)->where('id',$id)->delete();

        return redirect()->route('institutional.estate.coupons')->with('success', 'Başarıyla kuponu kaldırdınız');
    }
}
