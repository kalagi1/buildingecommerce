<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\AcceptedBid;
use App\Models\Bid;
use App\Models\Housing;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BidController extends Controller {
    public function store(Request $request, $housingId) {
        $user = auth()->user();
        $todayBidsCount = Bid::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        if ($todayBidsCount >= 40) {
            return back()->with('error', 'Günlük teklif hakkınız doldu.');
        }

        $request->validate([
            'bid_amount' => 'required|numeric|min:1'
        ]);

        Bid::create([
            'user_id' => $user->id,
            'housing_id' => $housingId,
            'bid_amount' => $request->bid_amount
        ]);

        return back()->with('success', 'Teklifiniz başarıyla gönderildi.');
    }

    public function accept($bidId) {
        $bid = Bid::findOrFail($bidId);
        $housing = Housing::findOrFail($bid->housing_id);

        // Geçerli bir teklif olup olmadığını kontrol edin
        if ($housing->user_id != auth()->id()) {
            return back()->with('error', 'Bu teklifi kabul etme yetkiniz yok.');
        }

        // Mevcut kabul edilen teklif varsa, yeni teklifi kabul etmeden önce eskiyi sil
        $existingAcceptedBid = AcceptedBid::where('housing_id', $housing->id)->first();
        if ($existingAcceptedBid) {
            $existingAcceptedBid->delete();
        }

        // Kabul edilen teklifin kaydını oluşturun
        AcceptedBid::create([
            'housing_id' => $bid->housing_id,
            'bid_id' => $bid->id,
            'expires_at' => now()->addHours(12)
        ]);

        $bid->status = 'accepted';
        $bid->save();

        return back()->with('success', 'Teklif kabul edildi ve fiyat güncellendi.');
    }

    public function reject($bidId) {
        $bid = Bid::findOrFail($bidId);

        // Geçerli bir teklif olup olmadığını kontrol edin
        if ($bid->housing->user_id != auth()->id()) {
            return back()->with('error', 'Bu teklifi reddetme yetkiniz yok.');
        }

        $bid->status = 'rejected';
        $bid->save();

        return back()->with('success', 'Teklif reddedildi.');
    }

    public function index($hashedId) {
        $housingId = decode_id( $hashedId );

        $housing = Housing::with('bids.user')->findOrFail($housingId);
        return view('client.panel.bids.index', compact('housing'));
    }
}
