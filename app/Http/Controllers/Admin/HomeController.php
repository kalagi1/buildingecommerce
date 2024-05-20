<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\CancelRequest;
use App\Models\CartOrder;
use App\Models\CartPrice;
use App\Models\DocumentNotification;
use App\Models\EmailTemplate;
use App\Models\Housing;
use App\Models\HousingComment;
use App\Models\Invoice;
use App\Models\NeighborPayment;
use App\Models\NeighborView;
use App\Models\Order;
use App\Models\Project;
use App\Models\Reservation;
use App\Models\SharerPrice;
use App\Models\User;
use App\Models\UserPlan;
use App\Models\CartOrderRefund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Services\SmsService;
use App\Models\ReservationRefund;

class HomeController extends Controller {
    protected $smsService;

    public function __construct( SmsService $smsService ) {
        $this->smsService = $smsService;
    }

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

    public function orderDetail( $id ) {
        $order = CartOrder::where( 'id', $id )->first();

        return view( 'admin.orders.detail', compact( 'order' ) );
    }

    public function getPackageOrders() {
        $cartOrders = UserPlan::with( 'user', 'subscriptionPlan' )->where( 'subscription_plan_id', '!=', NULL )->get();
        return view( 'admin.package-orders.index', compact( 'cartOrders' ) );
    }

    public function getOrders() {
        $cartOrders = CartOrder::with( 'user', 'share', 'price', 'isReference' )
        ->whereNull( 'is_disabled' )
        ->orderByDesc( 'created_at' )
        ->get();

        return view( 'admin.orders.index', compact( 'cartOrders' ) );
    }

    public function getReservations() {
        $housingReservations = Reservation::select( 'reservations.*' )->with( 'user', 'housing', 'owner' )->where( 'status', '=', 1 )->leftJoin( 'cancel_requests', 'cancel_requests.reservation_id', '=', 'reservations.id' )->whereNull( 'cancel_requests.id' )
        ->orderBy('created_at', 'desc')
        ->get();
        $confirmReservations = Reservation::select( 'reservations.*' )->with( 'user', 'housing', 'owner' )->where( 'status', '!=', 3 )->where( 'status', '!=', 1 )->where( 'check_in_date', '>=', date( 'Y-m-d' ) )->where( 'status', '!=', 3 )->leftJoin( 'cancel_requests', 'cancel_requests.reservation_id', '=', 'reservations.id' )->whereNull( 'cancel_requests.id' )
        ->orderBy('created_at', 'desc')
        ->get();

        $expiredReservations = Reservation::select( 'reservations.*' )->with( 'user', 'housing', 'owner' )->where( 'check_in_date', '<=', date( 'Y-m-d' ) )->where( 'status', '!=', 3 )
        ->orderBy('created_at', 'desc')
        ->get();

        $cancelReservations = Reservation::select( 'reservations.*' )->with( 'user', 'housing', 'owner' )->where( 'status', '=', 3 )
        ->orderBy('created_at', 'desc')
        ->get();

        $cancelRequestReservations = Reservation::select( 'reservations.*' )->with( 'user', 'housing', 'owner' )->leftJoin( 'cancel_requests', 'cancel_requests.reservation_id', '=', 'reservations.id' )->where( 'status', '!=', 3 )->whereNotNull( 'cancel_requests.id' )
        ->orderBy('created_at', 'desc')
        ->get();

        $refundedReservations = Reservation::whereHas('refund')
        ->with('user', 'housing', 'owner', 'refund')
        ->orderBy('created_at', 'desc')
        ->get();

        return view( 'admin.reservations.index', compact( 'refundedReservations','housingReservations', 'cancelReservations', 'expiredReservations', 'confirmReservations', 'cancelRequestReservations' ) );
    }

    public function ReservationDetail( $id ) {
        $order = Reservation::where( 'id', $id )->first();
     
        return view( 'admin.reservations.detail', compact( 'order' ) );
    }
    

    public function deleteCancelRequest( $id ) {
        $reservation = Reservation::where( 'id', $id )->first();
        $cancelRequest = $reservation->cancelRequest;
        $cancelRequest->delete();

        return redirect()->route( 'admin.reservations', [ 'status' => 'cancel_cancel_request' ] );
    }

    public function reservationInfo( $id ) {
        $reservation = Reservation::with( 'user', 'owner', 'cancelRequest' )->where( 'id', $id )->first();

        return json_encode( [
            'reservation' => $reservation
        ] );
    }

    public function approveShare( $share ) {
        $sharePrice = SharerPrice::where( 'id', $share )->first();
        $sharePrice->update( [
            'status' => '1'
        ] );
        return redirect()->back();
    }

    public function unapproveShare( $share ) {
        $sharePrice = SharerPrice::where( 'id', $share )->first();
        $sharePrice->update( [
            'status' => '2'
        ] );
        return redirect()->back();
    }

    public function approvePrice( $price ) {
        $sharePrice = CartPrice::where( 'id', $price )->first();
        $sharePrice->update( [
            'status' => '1'
        ] );
        return redirect()->back();
    }

    public function unapprovePrice( $price ) {
        $sharePrice = CartPrice::where( 'id', $price )->first();
        $sharePrice->update( [
            'status' => '2'
        ] );
        return redirect()->back();
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

        if ( $cart->type == 'housing' ) {
            $estate  = Housing::where( 'id', $cart->item->id )->with( 'user' )->first();
            $is_sold = Housing::where( 'id', $cart->item->id )->first();
            $is_sold->update( [
                'is_sold' => 1] );
                
        } else {
            $estate = Project::where( 'id', $cart->item->id )->with( 'user' )->first();
            $isNeighbor = NeighborView::where( 'owner_id', $cartOrder->is_reference )
            ->where( 'project_id', $estate->id )
            ->where( 'user_id', $cartOrder->user_id )
            ->where( 'status', 1 )
            ->first();

            $neighborPaymentData = [
                'user_id' => $cartOrder->is_reference,
                'payment' => '125', // Ödeme miktarını uygun bir şekilde güncelleyin
                'neighborview_id' => $isNeighbor ? $isNeighbor->id : null,
            ];

            NeighborPayment::create( $neighborPaymentData );
        }

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
            'salesDate' => $cartOrder->created_at->format( 'd/m/Y' ),
            'companyName' => 'Emlak Sepette',
            'orderNo' =>  $cartOrder->id,
            'housingNo' => $cartOrder->key,
            'email' => $user->email,
            'token' => $user->email_verification_token,
            'storeOwnerName' => $estate ? $estate->user->name : '',
            'invoiceLink' => route( 'institutional.invoice.show', $cartOrder->id ),
        ];

        foreach ( $newSellerVariables as $key => $value ) {
            $newSellerContent = str_replace( '{{' . $key . '}}', $value, $newSellerContent );
        }

        Mail::to( $estate->user->email )->send( new CustomMail( $newSeller->subject, $newSellerContent ) );

        DocumentNotification::create( [
            'user_id' => $user->id,
            'text' => '#' . $cartOrder->id . " No'lu siparişiniz onaylandı. Fatura detayları için tıklayın.",
            'item_id' => $cartOrder->id,
            'link' => $user->type == '1' ? route( 'institutional.invoice.show', $cartOrder->id ) : route( 'institutional.invoice.show', $cartOrder->id ),
            'owner_id' => $user->id,
            'is_visible' => true,
        ] );

        // Apply Payment Order Email to User
        $applyPaymentOrder = EmailTemplate::where( 'slug', 'apply-payment-order' )->first();

        if ( !$applyPaymentOrder ) {
            return response()->json( [
                'message' => 'Apply Payment Order email template not found.',
                'status' => 203,
                'success' => true,
            ], 203 );
        }

        $applyPaymentOrderContent = $applyPaymentOrder->body;

        $applyPaymentOrderVariables = [
            'salesAmount' => $cartOrder->amount  . ' ₺',
            'orderNo' => $cartOrder->id,
            'username' => $user->name,
            'salesDate' => $cartOrder->created_at->format( 'd/m/Y' ),
            'companyName' => 'Emlak Sepette',
            'email' => $user->email,
            'invoiceLink' =>   route( 'institutional.invoice.show', $cartOrder->id ),
            'token' => $user->email_verification_token,
            'invoiceLink' => route( 'institutional.invoice.show', $cartOrder->id ),
        ];

        foreach ( $applyPaymentOrderVariables as $key => $value ) {
            $applyPaymentOrderContent = str_replace( '{{' . $key . '}}', $value, $applyPaymentOrderContent );
        }

        Mail::to( $user->email )->send( new CustomMail( $applyPaymentOrder->subject, $applyPaymentOrderContent ) );

        $admins = User::where( 'type', '3' )->get();
        foreach ( $admins as $admin ) {
            DocumentNotification::create( [
                'user_id' => $admin->id,
                'text' => '#' . $cartOrder->id . " No'lu emlak siparişi onaylandı.",
                'item_id' => $cartOrder->id,
                'link' => route( 'admin.orders' ),
                'owner_id' => 4,
                'is_visible' => true,
            ] );
        }

        return redirect()->back();
    }

    public function unapproveOrder( CartOrder $cartOrder ) {
        $cartOrder->update( [ 'status' => '2' ] );
        $user = User::where( 'id', $cartOrder->user_id )->first();

        DocumentNotification::create( [
            'user_id' => $user->id,
            'text' => '#' . $cartOrder->id . " No'lu siparişiniz maalesef onaylanmadı. Ödeme alınamadı ve ilan tekrar satışa çıkarılacaktır. ",
            'item_id' => $cartOrder->id,
            'link' => '#',
            'owner_id' => $user->id,
            'is_visible' => true,
        ] );

        // Apply Payment Order Email to User
        $applyPaymentOrder = EmailTemplate::where( 'slug', 'reject-payment-order' )->first();

        if ( !$applyPaymentOrder ) {
            return response()->json( [
                'message' => 'Apply Payment Order email template not found.',
                'status' => 203,
                'success' => true,
            ], 203 );
        }

        $applyPaymentOrderContent = $applyPaymentOrder->body;

        $applyPaymentOrderVariables = [
            'salesAmount' => $cartOrder->amount  . ' ₺',
            'orderNo' => $cartOrder->id,
            'username' => $user->name,
            'salesDate' => $cartOrder->created_at->format( 'd/m/Y' ),
            'companyName' => 'Emlak Sepette',
            'email' => $user->email,
            'invoiceLink' =>   route( 'institutional.invoice.show', $cartOrder->id ),
            'token' => $user->email_verification_token,
            'invoiceLink' => route( 'institutional.invoice.show', $cartOrder->id ),
        ];

        foreach ( $applyPaymentOrderVariables as $key => $value ) {
            $applyPaymentOrderContent = str_replace( '{{' . $key . '}}', $value, $applyPaymentOrderContent );
        }

        Mail::to( $user->email )->send( new CustomMail( $applyPaymentOrder->subject, $applyPaymentOrderContent ) );

        $admins = User::where( 'type', '3' )->get();
        foreach ( $admins as $admin ) {
            DocumentNotification::create( [
                'user_id' => $admin->id,
                'text' => '#' . $cartOrder->id . " No'lu sipariş onaylanmadı. Ödeme alınamadı. İlan tekrar satışa çıkarılacak.",
                'item_id' => $cartOrder->id,
                'link' => route( 'admin.orders' ),
                'owner_id' => 4,
                'is_visible' => true,
            ] );
        }
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
        $reservation->update( [ 'status' => '3' ] );
        CancelRequest::where( 'reservation_id', $reservation->id )->delete();
        return redirect()->back();
    }

    public function upload( Request $request ) {
        // PDF dosyasını al
        $pdfFile = $request->file( 'pdf_file' );
        // Gelen requestten refund_id'yi alın
        $refund_id = $request->refund_id;

        // İlgili CartOrderRefund'ı bulun
        $refund = CartOrderRefund::find( $refund_id );

        // Dosya yüklendiyse ve refund bulunduysa devam et
        if ( $pdfFile && $refund ) {
            // Dosyayı belirtilen dizine kaydet ( örneğin: storage/app/pdf )
            $newFileName = now()->format( 'H-i-s' ) . '.' . $pdfFile->getClientOriginalExtension();
            $folderName = 'refund-receipt-pdf/' . $refund->id;
            $newFilePath = public_path( $folderName );
            $pdfFile->move( $newFilePath, $newFileName );

            // Dosyanın yeni yolunu alın
            $pdfPath = $folderName . '/' . $newFileName;
            // Dosya yolu ve adını birleştirin

            // Veritabanında bir kayıt oluşturmak isterseniz
            $refund->filename = $pdfFile->getClientOriginalName();
            // Dosya adını alabilirsiniz
            $refund->path = $pdfPath;
            $refund->status = '3';
            // Dosya yolunu kaydedin
            $refund->save();

            $this->sendEmail( $refund );

            $this->sendSMS( $refund );

            return redirect()->back()->with( 'success', 'PDF dosyası başarıyla yüklendi.' );
        } else {
            return redirect()->back()->with( 'error', 'PDF dosyası yüklenirken bir hata oluştu.' );
        }
    }

     public function reservationUpload( Request $request ) {
        // PDF dosyasını al
        $pdfFile = $request->file( 'pdf_file' );
        // Gelen requestten refund_id'yi alın
        $refund_id = $request->refund_id;

        // İlgili CartOrderRefund'ı bulun
        $refund = ReservationRefund::find( $refund_id );

        // Dosya yüklendiyse ve refund bulunduysa devam et
        if ( $pdfFile && $refund ) {
            // Dosyayı belirtilen dizine kaydet ( örneğin: storage/app/pdf )
            $newFileName = now()->format( 'H-i-s' ) . '.' . $pdfFile->getClientOriginalExtension();
            $folderName = 'refund-receipt-pdf/' . $refund->id;
            $newFilePath = public_path( $folderName );
            $pdfFile->move( $newFilePath, $newFileName );

            // Dosyanın yeni yolunu alın
            $pdfPath = $folderName . '/' . $newFileName;
            // Dosya yolu ve adını birleştirin

            // Veritabanında bir kayıt oluşturmak isterseniz
            $refund->filename = $pdfFile->getClientOriginalName();
            // Dosya adını alabilirsiniz
            $refund->path = $pdfPath;
            $refund->status = '3';
            // Dosya yolunu kaydedin
            $refund->save();

            $this->reservationSendEmail( $refund );

            $this->reservationSendSMS( $refund );

            return redirect()->back()->with( 'success', 'PDF dosyası başarıyla yüklendi.' );
        } else {
            return redirect()->back()->with( 'error', 'PDF dosyası yüklenirken bir hata oluştu.' );
        }
    }
    

    

    private function reservationSendEmail( $refund ) {
        $pdfDownloadLink = asset( $refund->path );
        $name = $refund->user->name;
        $cartID = $refund->reservation->key;

        $content = '

        <p>Merhaba '. $name .' , '. $cartID .' nolu rezervasyonunuza ait geri ödeme tarafınıza iletilmiştir.</p>
        <p>Aşağıdaki butona basarak dekontu indirebilirsiniz</p>
        
        
        <a href="' . $pdfDownloadLink . '" onclick="downloadPDF()" style="background-color: #4CAF50; /* Green */
          border: none;
          color: white;
          padding: 15px 32px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 16px;
          margin: 4px 2px;
          cursor: pointer;">Dekont İndir</a>
        
        <!-- JavaScript fonksiyonu -->
        <script>
        function downloadPDF() {
            window.location.href = "' . $pdfDownloadLink . '";
        }
        </script>
        ';

        // E-posta gönderme işlemi
        $subject = 'İade Talebi';

        // E-posta gönder
        Mail::to( $refund->user->email )->send( new CustomMail( $subject, $content ) );
    }

    private function reservationSendSMS( $refund ) {
        // Kullanıcının telefon numarasını al
        $userPhoneNumber = $refund->user->mobile_phone;

        // Kullanıcının adını ve soyadını al
        $name = $refund->user->name;
        $cartID = $refund->reservation->key;

        // SMS metni oluştur
        $message = "Merhaba $name , $cartID no'lu rezervasyonunuza ait geri ödeme tarafınıza iletilmiştir. Dekontunuzu mail adresinize gönderdik, kontrol edebilirsiniz.";

        // SMS gönderme işlemi
        $smsService = new SmsService();
        $source_addr = 'Emlkspette';

        $smsService->sendSms( $source_addr, $message, $userPhoneNumber );
    }



    private function sendEmail( $refund ) {
        $pdfDownloadLink = asset( $refund->path );
        $name = $refund->user->name;
        $cartID = $refund->cart_order_id;

        $content = '

        <p>Merhaba '. $name .' , '. $cartID .' nolu siparişinize ait geri ödeme tarafınıza iletilmiştir.</p>
        <p>Aşağıdaki butona basarak dekontu indirebilirsiniz</p>
        
        
        <a href="' . $pdfDownloadLink . '" onclick="downloadPDF()" style="background-color: #4CAF50; /* Green */
          border: none;
          color: white;
          padding: 15px 32px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 16px;
          margin: 4px 2px;
          cursor: pointer;">Dekont İndir</a>
        
        <!-- JavaScript fonksiyonu -->
        <script>
        function downloadPDF() {
            window.location.href = "' . $pdfDownloadLink . '";
        }
        </script>
        ';

        // E-posta gönderme işlemi
        $subject = 'İade Talebi';

        // E-posta gönder
        Mail::to( $refund->user->email )->send( new CustomMail( $subject, $content ) );
    }

    private function sendSMS( $refund ) {
        // Kullanıcının telefon numarasını al
        $userPhoneNumber = $refund->user->mobile_phone;

        // Kullanıcının adını ve soyadını al
        $name = $refund->user->name;
        $cartID = $refund->cart_order_id;

        // SMS metni oluştur
        $message = "Merhaba $name , $cartID no'lu siparişinize ait geri ödeme tarafınıza iletilmiştir. Dekontunuzu mail adresinize gönderdik, kontrol edebilirsiniz.";

        // SMS gönderme işlemi
        $smsService = new SmsService();
        $source_addr = 'Emlkspette';

        $smsService->sendSms( $source_addr, $message, $userPhoneNumber );
    }

    public function updateStatus( Request $request, $refundId ) {
        $refund = CartOrderRefund::find( $refundId );
        $userId = $refund->user_id;
        $now = Carbon::now();

        if ( !$refund ) {
            return redirect()->back()->with( 'error', 'İlgili iade talebi bulunamadı.' );
        }

        $validatedData = $request->validate( [
            'status' => 'required|in:1,2,3',
        ] );

        $refund->status = $validatedData[ 'status' ];
        $refund->save();

        if ( $refund->status == 1 ) {
            if ( $refund->cartOrder->status != 2 ) {
                $refund->cartOrder->status = '2';
                // Sipariş durumunu 2 olarak güncelle
                $refund->cartOrder->save();
            }
        }

        if ( $refund->status == 3 ) {
            $createdAt = Carbon::parse( $refund->cartorder->created_at );
            $differenceInDays = $createdAt->diffInDays( $now );
            $amount = $refund->cartorder->amount;

            if ( $differenceInDays <= 14 ) {
                $amountFloat = ( float ) str_replace( ',', '.', str_replace( '.', '', $amount ) );
                $refundAmount = $amountFloat * 0.10;
            } else {
                $refundAmount = $amount;
            }
            
            // SharerPrice tablosundaki ilgili kayıtları güncelle
            SharerPrice::where('cart_id', $refund->cartOrder->id)->update(['status' => '2']);
            // CartPrice tablosundaki ilgili kayıtları al ve güncelle
            $cartPrices = CartPrice::where( [
                [ 'user_id', $refund->user_id ],
                [ 'cart_id', $refund->cartOrder->id ],
                [ 'status', 1 ],
            ] )->get();
            foreach ( $cartPrices as $cartPrice ) {
                $cartPrice->earn = $refundAmount;
                $cartPrice->earn2 = '0';
                $cartPrice->save();
            }
        }

        return redirect()->back()->with( 'success', 'İade durumu başarıyla güncellendi.' );
    }

    public function  reservationUpdateStatus( Request $request, $refundId ) {
        $refund = reservationRefund::find( $refundId );
        $userId = $refund->user_id;
        $now = Carbon::now();

        if ( !$refund ) {
            return redirect()->back()->with( 'error', 'İlgili iade talebi bulunamadı.' );
        }

        $validatedData = $request->validate( [
            'status' => 'required|in:1,2,3',
        ] );

        $refund->status = $validatedData[ 'status' ];
        $refund->save();

        if ( $refund->status == 1 ) {
            if ( $refund->reservation->status != 2 ) {
                $refund->reservation->status = '2';
                // Sipariş durumunu 2 olarak güncelle
                $refund->reservation->save();
            }
        }

        if ( $refund->status == 3 ) {
            $createdAt = Carbon::parse( $refund->reservation->created_at );
            $differenceInDays = $createdAt->diffInDays( $now );
            $amount = $refund->reservation->amount;

            if ( $differenceInDays <= 14 ) {
                $amountFloat = ( float ) str_replace( ',', '.', str_replace( '.', '', $amount ) );
                $refundAmount = $amountFloat * 0.10;
            } else {
                $refundAmount = $amount;
            }
            
            // SharerPrice tablosundaki ilgili kayıtları güncelle
            SharerPrice::where('cart_id', $refund->reservation->id)->update(['status' => '2']);
            // CartPrice tablosundaki ilgili kayıtları al ve güncelle
            $cartPrices = CartPrice::where( [
                [ 'user_id', $refund->user_id ],
                [ 'cart_id', $refund->reservation->id ],
                [ 'status', 1 ],
            ] )->get();
            foreach ( $cartPrices as $cartPrice ) {
                $cartPrice->earn = $refundAmount;
                $cartPrice->earn2 = '0';
                $cartPrice->save();
            }
        }

        return redirect()->back()->with( 'success', 'İade durumu başarıyla güncellendi.' );
    }

   
}
