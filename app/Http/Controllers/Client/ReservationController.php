<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function store(Request $request) {
    $validator = Validator::make($request->all(), [
        'housing_id' => 'required|exists:housings,id',
        'check_in_date' => 'required|date',
        'check_out_date' => 'required|date|after_or_equal:check_in_date',
        'person_count' => 'required|integer|min:1',
        'owner_id' => 'required',
        'price' => 'required|numeric|min:0',
        'key' => 'required',
        'fullName' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'tc' => 'required|numeric',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:500',
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => 'Geçersiz istek.', 'errors' => $validator->errors()]);
    }

    $existingReservation = Reservation::where('housing_id', $request->input('housing_id'))
        ->where(function ($query) use ($request) {
            $query->whereBetween('check_in_date', [$request->input('check_in_date'), $request->input('check_out_date')])
                  ->orWhereBetween('check_out_date', [$request->input('check_in_date'), $request->input('check_out_date')]);
        })
        ->first();

    if ($existingReservation) {
        return response()->json(['success' => false, 'message' => 'Bu tarih aralığında rezervasyon yapılamaz.']);
    }

    $reservation = new Reservation;
    $reservation->user_id = auth()->user()->id;
    $reservation->housing_id = $request->input('housing_id');
    $reservation->check_in_date = $request->input('check_in_date');
    $reservation->check_out_date = $request->input('check_out_date');
    $reservation->person_count = $request->input('person_count');
    $reservation->owner_id = $request->input('owner_id');
    $reservation->status = 0; 
    if($request->input('money_trusted')){
        $reservation->total_price = intval($request->input('price')) + 1000;
    }else{
        $reservation->total_price = $request->input('price');
    }
    $reservation->key = $request->input('key');
    $reservation->full_name = $request->input('fullName');
    $reservation->email = $request->input('email');
    $reservation->tc = $request->input('tc');
    $reservation->phone = $request->input('phone');
    $reservation->address = $request->input('address');
    $reservation->notes = $request->input("notes");
    
    $reservation->save();

    return response()->json(['success' => true, 'message' => 'Rezervasyon başarıyla kaydedildi.']);
    }
}
