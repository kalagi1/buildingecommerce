<?php

namespace App\Http\Controllers\ClientPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\CartOrder;
use App\Models\DocumentNotification;
use App\Models\Reservation;
use App\Models\SubscriptionPlan;
use App\Models\UpgradeLog;
use App\Models\User;
use App\Models\UserPlan;
use App\Rules\SubscriptionPlanToUpgradeBireysel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CartOrderRefund;
use App\Models\reservationRefund;

class ProfileController extends Controller
{
    public function getReservations() {
        $housingReservations = Reservation::with("user", "housing")
        ->where("user_id",auth()->user()->id)
        ->get();

        return view('client.client-panel.profile.reservations', compact('housingReservations'));
    }
    public function cartOrders()
    {
        $cartOrders = CartOrder::where('user_id', auth()->user()->id)->with("invoice")
        ->where("is_disabled", NULL)->orderBy("id", "desc")->get();
            return view('institutional.orders.get', compact('cartOrders'));

    
        
    }

    public function orderDetail($id)
    {
        $order = CartOrder::where('id', $id)->first();

        return view('institutional.orders.detail', compact('order'));
    }

    public function reservationDetail($id)
    {
        $order = Reservation::where('id', $id)->first();

        return view('institutional.Reservations.detail', compact('order'));
    }

    public function upload(Request $request)
    {

        // dd($request->all());
        // PDF dosyasını al
        $pdfFile = $request->file('pdf_file');
        // Gelen requestten order_id'yi alın
        $order_id = $request->order_id;

        // İlgili CartOrder'ı bulun
        $cartOrder = CartOrder::find($order_id);

        // Dosya yüklendiyse devam et
        if ($pdfFile && $cartOrder) {
            // Dosyayı belirtilen dizine kaydet (örneğin: storage/app/pdf)
            $newFileName = now()->format('H-i-s') . '.' . $pdfFile->getClientOriginalExtension();
            $folderName = 'contract-pdf/' . $cartOrder->id;
            $newFilePath = public_path($folderName);
            $pdfFile->move($newFilePath, $newFileName);

            // Dosyanın yeni yolunu alın
            $pdfPath = $folderName . '/' . $newFileName; // Dosya yolu ve adını birleştirin

            // Veritabanında bir kayıt oluşturmak isterseniz
            $cartOrder->filename = $pdfFile->getClientOriginalName(); // Dosya adını alabilirsiniz
            $cartOrder->path = $pdfPath; // Dosya yolunu kaydedin
            $cartOrder->save();


            return redirect()->back()->with('success', 'PDF dosyası başarıyla yüklendi.');
        } else {
            return redirect()->back()->with('error', 'PDF dosyası yüklenirken bir hata oluştu.');
        }
    }

    public function reservationUpload(Request $request)
    {

        // dd($request->all());
        // PDF dosyasını al
        $pdfFile = $request->file('pdf_file');
        // Gelen requestten order_id'yi alın
        $reservation_id = $request->reservation_id;

        // İlgili CartOrder'ı bulun
        $reservation = Reservation::find($reservation_id);

        // Dosya yüklendiyse devam et
        if ($pdfFile && $reservation) {
            // Dosyayı belirtilen dizine kaydet (örneğin: storage/app/pdf)
            $newFileName = now()->format('H-i-s') . '.' . $pdfFile->getClientOriginalExtension();
            $folderName = 'contract-pdf/' . $reservation->id;
            $newFilePath = public_path($folderName);
            $pdfFile->move($newFilePath, $newFileName);

            // Dosyanın yeni yolunu alın
            $pdfPath = $folderName . '/' . $newFileName; // Dosya yolu ve adını birleştirin

            // Veritabanında bir kayıt oluşturmak isterseniz
            $reservation->filename = $pdfFile->getClientOriginalName(); // Dosya adını alabilirsiniz
            $reservation->path = $pdfPath; // Dosya yolunu kaydedin
            $reservation->save();


            return redirect()->back()->with('success', 'PDF dosyası başarıyla yüklendi.');
        } else {
            return redirect()->back()->with('error', 'PDF dosyası yüklenirken bir hata oluştu.');
        }
    }

  
    public function cartOrderDetail(CartOrder $order)
    {
        $cartOrders = CartOrder::where('user_id', auth()->user()->id)->where("id",$order->id)->with("invoice")->orderBy("id", "desc")->get();
        
        return view('institutional.orders.get', compact('cartOrders'));

    }



    public function verify()
    {
        return view('client.client-panel.home.verification');
    }

    public function verifyAccount(Request $request)
    {
        $request->validate(
            [
                'kimlik_belgesi' => 'required|image|mimes:jpg,jpeg,png',
            ]
        );

        $array = [];

        $file = $request->kimlik_belgesi->store('individual_identity_documents');
        $array = array_merge($array, ['identity_document' => $file]);

        auth()->user()->update($array);

        DocumentNotification::create([
            'user_id' => auth()->user()->parent_id ?? auth()->user()->id,
            'text' => 'Hesap onayı için yeni bir belge gönderildi. Kullanıcı: ' . auth()->user()->email,
            'item_id' => auth()->user()->parent_id ?? auth()->user()->id,
            'link' => route('admin.user.show-corporate-account', ['user' => auth()->user()->parent_id ?? auth()->user()->id]),
            'owner_id' => 4,
            'is_visible' => true,
        ]);

        return redirect()->back();
    }

    public function getIdentityDocument()
    {
        $user = auth()->user();
        $identity_document = $user->identity_document;

        if (is_null($identity_document)) {
            die('Belge yok.');
        }

        $file = file_get_contents(storage_path("/app/{$identity_document}"));
        preg_match('@\.(\w+)$@', $identity_document, $match);
        $extension = $match[1] ?? 'png';

        header('Content-Type: image/' . $extension);
        echo $file;
    }

    public function upgrade()
    {
        $plans = SubscriptionPlan::where('plan_type', 'Bireysel')->get();
        $current = UserPlan::with("subscriptionPlan")->where('user_id', auth()->user()->id)->first() ?? false;
        return view('client.client-panel.profile.upgrade', compact('plans', 'current'));
    }

    public function upgradeProfile(Request $request, $id)
    {
        $request->validate(['id' => $id],
            [
                'id' =>
                [
                    'required',
                    new SubscriptionPlanToUpgradeBireysel(),
                ],
            ]
        );

        $plan = SubscriptionPlan::find($id);
        $before = UserPlan::where('user_id', auth()->user()->id)->where("status", "1")->first();
        $user = User::where('id', auth()->user()->id)->first();
        $user->update([
            'subscription_plan_id' => $plan->id,
        ]);

        if (!$before) {
            $before = new \stdClass();
            $before->housing_limit = 0;
        }

        $data =
            ['subscription_plan_id' => $plan->id,
            'housing_limit' => $before->housing_limit + $plan->housing_limit,
            'user_id' => auth()->user()->id,
            'subscription_plan_id' => $id,
            'project_limit' => 0,
            'user_limit' => 0,
        ];

        DB::beginTransaction();
        UpgradeLog::create(
            [
                'user_id' => auth()->user()->id,
                'plan_id' => $plan->id,
            ]
        );
        UserPlan::updateOrCreate(['user_id' => auth()->user()->id], $data);
        DB::commit();

        return redirect()->back()->with('success', 'Abonelik Planı Güncellendi.');
    }

    public function edit()
    {
        $user = auth()->user();
        return view('client.client-panel.profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = User::where("id", auth()->user()->id)->first();
        $user->update($request->all());
        return redirect()->route('client.profile.edit')->with('success', 'Profiliniz başarıyla güncellendi.');
    }


    public function refund(Request $request) 
    {
        $validatedData = $request->validate([
            'terms' => 'required|boolean',
            'name' => 'required|string|max:255',
            'phone' => 'required',
            'email' => 'required|string|email|max:255',
            'content' => 'required|string',
            'cart_order_id' =>'required',
            'return_bank' => 'required',
            'return_iban' => 'required',
        ]);

        $userId = auth()->id();
        
        // Eğer cart_order_id ile ilişkili bir iade talebi varsa, bu talebi güncelle. Yoksa yeni bir kayıt oluştur.
        $existingRefund = CartOrderRefund::where('cart_order_id', $validatedData['cart_order_id'])->first();

        if ($existingRefund) {
            // İade talebi zaten var, güncelle
            $existingRefund->update([
                'terms'       => $validatedData['terms'],
                'name'        => $validatedData['name'],
                'phone'       => $validatedData['phone'],
                'email'       => $validatedData['email'],
                'return_bank' => $validatedData['return_bank'],
                'return_iban' => $validatedData['return_iban'],
                'content'     => $validatedData['content'],
                'status'      => '0',
                'user_id'     => $userId
            ]);
        } else {
            // İade talebi yok, yeni kayıt oluştur
            $refund = new CartOrderRefund([
                'terms'         => $validatedData['terms'],
                'name'          => $validatedData['name'],
                'phone'         => $validatedData['phone'],
                'email'         => $validatedData['email'],
                'return_bank'   => $validatedData['return_bank'],
                'return_iban'   => $validatedData['return_iban'],
                'content'       => $validatedData['content'],
                'status'        => '0',
                'user_id'       => $userId,
                'cart_order_id' => $validatedData['cart_order_id']
            ]);
            $refund->save();
        }

        // İade talebi başarıyla kaydedildi mesajını döndür
        return response()->json(['message' => 'İade talebi başarıyla kaydedildi'], 200);
    }

    

    public function reservationRefund(Request $request) 
    {
        
        $validatedData = $request->validate([
            'terms' => 'required|boolean',
            'name' => 'required|string|max:255',
            'phone' => 'required',
            'email' => 'required|string|email|max:255',
            'content' => 'required|string',
            'reservation_id' =>'required',
            'return_bank' => 'required',
            'return_iban' => 'required',
        ]);

        $userId = auth()->id();
        
        // Eğer cart_order_id ile ilişkili bir iade talebi varsa, bu talebi güncelle. Yoksa yeni bir kayıt oluştur.
        $existingRefund = reservationRefund::where('reservation_id', $validatedData['reservation_id'])->first();

        if ($existingRefund) {
            // İade talebi zaten var, güncelle
            $existingRefund->update([
                'terms'       => $validatedData['terms'],
                'name'        => $validatedData['name'],
                'phone'       => $validatedData['phone'],
                'email'       => $validatedData['email'],
                'return_bank' => $validatedData['return_bank'],
                'return_iban' => $validatedData['return_iban'],
                'content'     => $validatedData['content'],
                'status'      => '0',
                'user_id'     => $userId
            ]);
        } else {
            // İade talebi yok, yeni kayıt oluştur
            $refund = new reservationRefund([
                'terms'         => $validatedData['terms'],
                'name'          => $validatedData['name'],
                'phone'         => $validatedData['phone'],
                'email'         => $validatedData['email'],
                'return_bank'   => $validatedData['return_bank'],
                'return_iban'   => $validatedData['return_iban'],
                'content'       => $validatedData['content'],
                'status'        => '0',
                'user_id'       => $userId,
                'reservation_id' => $validatedData['reservation_id']
            ]);
            $refund->save();
        }

        // İade talebi başarıyla kaydedildi mesajını döndür
        return response()->json(['message' => 'İade talebi başarıyla kaydedildi'], 200);
    }

}
