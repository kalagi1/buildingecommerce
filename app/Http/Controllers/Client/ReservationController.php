<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CartPrice;
use App\Models\Click;
use App\Models\Collection;
use App\Models\Housing;
use App\Models\Rate;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\SharerPrice;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
   

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'housing_id' => 'required|exists:housings,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'person_count' => 'required|integer|min:1',
            'owner_id' => 'required',
            'price' => 'required|numeric|min:0',
            'key' => 'required',
            // 'fullName' => 'required|string|max:255',
            // 'email' => 'required|email|max:255',
            // 'tc' => 'required|numeric',
            // 'phone' => 'required|string|max:20',
            // 'address' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Geçersiz istek.', 'errors' => $validator->errors()]);
        }

        $existingReservation = Reservation::where('housing_id', $request->input('housing_id'))
            ->where("status", "!=", "3")
            ->where(
                function ($query) use ($request) {
                    $query->whereBetween('check_in_date', [$request->input('check_in_date'), $request->input('check_out_date')])
                        ->orWhereBetween('check_out_date', [$request->input('check_in_date'), $request->input('check_out_date')]);
                }
            )
            ->first();

        if ($existingReservation) {
            return response()->json(['success' => false, 'message' => 'Bu tarih aralığında rezervasyon yapılamaz.']);
        }

        $lastClick = Click::where('user_id', auth()->user()->id)
            ->where('created_at', '>=', now()->subDays(24))
            ->latest('created_at')
            ->first();
        $shareOpen = isset(
            json_decode(Housing::find($request->input('housing_id') ?? 0)->housing_type_data ?? '[]')->{'share-open1'}
        ) ? json_decode(Housing::find($request->input('housing_id') ?? 0)->housing_type_data ?? '[]')->{'share-open1'}
            : null;

        $reservation = new Reservation;
        $reservation->user_id = auth()->user()->id;
        $reservation->housing_id = $request->input('housing_id');
        $reservation->check_in_date = $request->input('check_in_date');
        $reservation->check_out_date = $request->input('check_out_date');
        $reservation->person_count = $request->input('person_count');
        $reservation->owner_id = $request->input('owner_id');
        $reservation->status = 0;

        if ($request->input('money_trusted')) {
            $reservation->money_trusted = 1;
        }
        $reservation->total_price = $request->input('price');
        $reservation->key = $request->input('key');
        // $reservation->full_name = $request->input('fullName');
        // $reservation->email = $request->input('email');
        // $reservation->tc = $request->input('tc');
        // $reservation->phone = $request->input('phone');
        // $reservation->address = $request->input('address');
        // $reservation->notes = $request->input('notes');

        $reservation->save();

        $earnMoney = intval($request->input('price')) / 2;
        if ($lastClick) {
            $collection = Collection::where('id', $lastClick->collection_id)->first();
            $rates = Rate::where("housing_id", $request->input('housing_id'))->get();
            $housing = Housing::where('id', $request->input('housing_id'))->first();


            $sales_rate_club = null; // Başlangıçta boş veya null değer

            foreach ($rates as $rate) {
                if ($collection->user->corporate_type == $rate->institution->name) {
                    // Eğer kullanıcı kurumsal türü ile oranlar eşleşirse, `sales_rate_club` değerini atayın
                    $sales_rate_club = $rate->sales_rate_club;
                }
                if ($housing->user->corporate_type == $rate->institution->name) {
                    $share_percent_earn =  $rate->default_deposit_rate;
                    $share_percent_balance = 1.0 - $share_percent_earn;
                }
            }

            // Eşleşme yoksa, son oran kaydının `sales_rate_club` değerini kullanın
            if ($sales_rate_club === null && count($rates) > 0) {
                $sales_rate_club = $rates->last()->sales_rate_club;
            }

            $estateclubrate = $earnMoney * $sales_rate_club;
            $remaining = $earnMoney - $estateclubrate;

            SharerPrice::create([
                'collection_id' => $lastClick->collection_id,
                'user_id' => $collection->user_id,
                'status' => '0',
                'balance' => $estateclubrate,
                'earn' => $earnMoney * $share_percent_balance,
                'earn2' => $remaining,
                'is_reservation' => 1,
                'reservation_id' => $reservation->id,
            ]);
        } else {
            $housing = Housing::where('id', $request->input('housing_id'))->first();
            $rates = Rate::where("housing_id", $request->input('housing_id'))->get();

            foreach ($rates as $key => $rate) {
                if ($housing->user->corporate_type == $rate->institution->name) {
                    $share_percent_earn =  $rate->default_deposit_rate;
                    $share_percent_balance = 1.0 - $share_percent_earn;
                }
            }

            CartPrice::create([
                'user_id' => $housing->user_id,
                'status' => '0',
                'earn' =>  $earnMoney * $share_percent_balance,
                'earn2' =>  $earnMoney * $share_percent_earn,
                'is_reservation' => 1,
                'reservation_id' => $reservation->id,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Rezervasyon başarıyla kaydedildi.']);
    }
}
