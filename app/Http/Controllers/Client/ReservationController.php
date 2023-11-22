<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function store(Request $request) {
    $reservation = new Reservation;
    $reservation->user_id = auth()->user()->id;
    $reservation->housing_id =  $request->input('housing_id');
    $reservation->check_in_date = $request->input('check_in_date');
    $reservation->check_out_date = $request->input('check_out_date');
    $reservation->person_count = $request->input('person_count');
    $reservation->status = 0; 
    $reservation->total_price = $request->input('price');
    $reservation->key = $request->input('key');

    $reservation->save();

    return response()->json(['success' => true, 'message' => 'Rezervasyon başarıyla kaydedildi.']);

    }
}
