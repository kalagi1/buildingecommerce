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
use App\Models\BankAccount;
use App\Models\CartItem;
use App\Models\ProjectHousing;
use Illuminate\Support\Facades\Auth;
use App\Models\HousingStatus;
use App\Models\DocumentNotification;
use Illuminate\Support\Facades\DB;

class NeighborViewController extends Controller
{

    public function index()
    {

        if (Auth::check()) {
            $userId = Auth::id(); // Kullanıcının user_id'sini al
            $neighborViews = NeighborView::with(['user', 'owner', 'order', 'project'])
                ->where('user_id', $userId)
                ->where('status', 1)
                ->get();

            return view('neighbor.index', compact('neighborViews'));
        } else {

            return redirect()->route('client.login');
        }
    }

    public function store(Request $request)
    {

        $userId = $request->input('user_id');
        $orderId = $request->input('order_id');

        $cartOrder = CartOrder::where('id', $request->input('order_id'))->first();

        $user =  User::where('id', $userId)->first();
        $order = CartOrder::where('id', $orderId)->first();
        $cart = json_decode($order->cart);
        $project = null;
        $roomOrder = null;

        if ($cart->type == 'project') {
            $project = Project::where('id', $cart->item->id)->with('brand', 'roomInfo', 'housingType', 'county', 'city', 'user.projects.housings', 'user.brands', 'user.housings', 'images')->first();
            $roomOrder = $cart->item->housing;
        } else {
            $project = Housing::where('id', $cart->item->id)->with('user')->first();
        }

        $existingRecord = NeighborView::where('user_id', $userId)
            ->where('project_id', $project->id)
            ->where('housing', $roomOrder)
            ->first();

        if (!$existingRecord) {

            NeighborView::create([
                'user_id' => $userId,
                'owner_id' => $cartOrder->user_id,
                "order_id" => $orderId,
                'housing' => $roomOrder,
                'project_id' => $project->id,
                'status' => $request->input('status'),
                'key' => $request->input('key'),
                'amount' => $request->input('amount'),
                'full_name' => $request->has('fullName') ? $request->input('fullName') : null,
                'tc' => $request->has('tc') ? $request->input('tc') : null,
                'phone' => $request->has('phone') ? $request->input('phone') : null,
                'address' => $request->has('address') ? $request->input('address') : null,
                'email' => $request->has('email') ? $request->input('email') : null,
                'notes' => $request->has('notes') ? $request->input('notes') : null,
            ]);

            $applyPaymentOrder = EmailTemplate::where('slug', 'neighbor-payment-confirmation')->first();

            if (!$applyPaymentOrder) {
                return response()->json([
                    'message' => 'Apply Payment Order email template not found.',
                    'status' => 203,
                    'success' => true,
                ], 203);
            }

            $applyPaymentOrderContent = $applyPaymentOrder->body;

            $applyPaymentOrderVariables = [
                'username' => $user->name,
                'project' => $project->project_title,
                'housingNo' => $roomOrder,
                'companyName' => 'Emlak Sepette'
            ];

            foreach ($applyPaymentOrderVariables as $key => $value) {
                $applyPaymentOrderContent = str_replace('{{' . $key . '}}', $value, $applyPaymentOrderContent);
            }

            Mail::to($user->email)->send(new CustomMail($applyPaymentOrder->subject, $applyPaymentOrderContent));

            return response()->json(['success' => true, 'message' => 'Successfully saved.'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Record already exists.'], 400);
        }
    }


    public function initiate3DPayment(Request $request)
    {
        $requestData = $request->all();



        $userId = $request->input('user_id');
        $orderId = $request->input('order_id');

        $cartOrder = CartOrder::where('id', $request->input('order_id'))->first();

        $user =  User::where('id', $userId)->first();
        $order = CartOrder::where('id', $orderId)->first();

        $cart = json_decode($order->cart);
        $project = null;
        $roomOrder = null;

        if ($cart->type == 'project') {
            $project = Project::where('id', $cart->item->id)->with('brand', 'roomInfo', 'housingType', 'county', 'city', 'user.projects.housings', 'user.brands', 'user.housings', 'images')->first();
            $roomOrder = $cart->item->housing;
        } else {
            $project = Housing::where('id', $cart->item->id)->with('user')->first();
        }

        $existingRecord = NeighborView::where('user_id', $userId)
            ->where('project_id', $project->id)
            ->where('housing', $roomOrder)
            ->where('status', 1)
            ->first();

        if (!$existingRecord) {

            NeighborView::create([
                'user_id' => $userId,
                'owner_id' => $cartOrder->user_id,
                "order_id" => $orderId,
                'housing' => $roomOrder,
                'project_id' => $project->id,
                'status' => $request->input('status'),
                'key' => $request->input('key'),
                'amount' => '250',
                'full_name' => $request->input('fullName'),
                'tc' => $request->input('tc'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'notes' => $request->input('notes'),
            ]);
        }

        // $clientId = '190100000';
        // $storeKey = '123456';
        $clientId = '190933121';
        $storeKey = 'MasteR3457';
        $expDateMonth = $requestData['month'];
        $expDateYear = $requestData['year'];
        $okUrl = url('/neighbor/resultpaymentsuccess');
        $failUrl = url('/neighbor/resultpaymentfail');
        $callbackUrl = url('/neighbor/resultpaymentsuccess');
        // $url = url('/resultpayment');
        $transactionType = 'Auth';
        $rnd = '5';
        $storetype = '3d_pay_hosting';
        $hashAlgorithm = 'ver3';
        $currency = '949';
        $lang = 'tr';

        $data = [
            'amount' => '250',
            'callbackurl' =>  $callbackUrl,
            'clientid' => $clientId,
            'currency' => $currency,
            'Ecom_Payment_Card_ExpDate_Year' =>  $expDateYear,
            'Ecom_Payment_Card_ExpDate_Month' => $expDateMonth,
            'failurl' =>  $failUrl,
            'hashAlgorithm' => $hashAlgorithm,
            'islemtipi' => $transactionType,
            'lang' => $lang,
            'oid' => $requestData['key'],
            'okurl' => $okUrl,
            'pan' => $requestData['creditcard'],
            'rnd' => $rnd,
            'storetype' => $storetype,
            'taksit'  => '',
        ];

        $order = [
            'amount', 'callbackurl', 'clientid', 'currency', 'Ecom_Payment_Card_ExpDate_Month', 'Ecom_Payment_Card_ExpDate_Year', 'failurl', 'hashAlgorithm',
            'islemtipi', 'lang', 'oid', 'okurl', 'pan', 'rnd', 'storetype', 'taksit'
        ];

        $sortedValues = array_map(function ($key) use ($data) {
            return $data[$key];
        }, $order);

        $hashString = implode('|', $sortedValues) . '|';
        $hashString .= str_replace('|', '\\|', str_replace('\\', '\\\\', $storeKey));
        $calculatedHashValue = hash('sha512', $hashString);
        $actualHash = base64_encode(pack('H*', $calculatedHashValue));
        $data['hash'] = $actualHash;

        return view('payment.pay', $data);
    }

    public function resultPaymentSuccess(Request $request)
    {
        $data = $request->all();


        $neighbor = NeighborView::where('key', $data['ReturnOid'])->first();

        if ($neighbor) {

            $user = $neighbor->user;
            if ($user) {
                Auth::login($user);
                $emailTemplateSlug = '';
                $statusText = '';
                $emailSubject = '';

                $statusID = $neighbor->project->housingStatus->where('housing_type_id', '<>', 1)->first()->housing_type_id ?? 1;
                $status = HousingStatus::find($statusID);

                $neighbor->update(['status' => 1]);
                $message = 'Kullanıcının başvurusu onaylandı.';
                $emailTemplateSlug = 'approve-neighbor-confirmation';
                $statusText = 'onaylandı';
                $emailSubject = 'Emlak Sepette | Komşumu Gör Ödemeniz Onaylandı';
                DocumentNotification::create([
                    'user_id' => 4,
                    'text' => $neighbor->project->project_title . ' projesindeki ' . $neighbor->housing . ' numaralı ilan için "Komşumu Gör" başvurunuz onaylandı!',
                    'item_id' => $neighbor->parent_id ?? $neighbor->id,
                    'link' => route('project.housings.detail', ['projectSlug' => $neighbor->project->slug . "-" . $status->slug . "-" . $neighbor->project->step2_slug . "-" . $neighbor->project->housingtype->slug, "projectID" => $neighbor->project->id + 1000000, "housingOrder" => $neighbor->housing]),
                    'owner_id' => $neighbor->parent_id ?? $neighbor->id,
                    'is_visible' => true,
                ]);


                $emailTemplate = EmailTemplate::where('slug', $emailTemplateSlug)->first();

                if ($emailTemplate) {

                    $content = $emailTemplate->body;

                    $variables = [
                        'username' => $neighbor->user->name,
                        'project' => $neighbor->project->project_title,
                        'housingNo' => $neighbor->housing,
                        "neighborName" => $neighbor->order->user->name,
                        "neighborPhone" => $neighbor->order->user->phone,
                        'companyName' => 'Emlak Sepette'
                    ];

                    foreach ($variables as $key => $value) {
                        $content = str_replace("{{" . $key . "}}", $value, $content);
                    }

                    Mail::to($neighbor->user->email)->send(new CustomMail($emailSubject, $content));
                }
            }
            return redirect()->route('neighbors.index');
        }

        return redirect()->route('client.login');
    }


    public function resultPaymentFail(Request $request)
    {
        $data = $request->all();

        $neighbor = NeighborView::where('key', $data['oid'])->first();


        if ($neighbor) {
            // Siparişi bulduysanız, bu siparişe ait kullanıcıyı alın
            $user = $neighbor->user;

            if ($user) {
                // Kullanıcıyı oturum açın
                Auth::login($user);
                $neighbor->delete();
                // Kullanıcıyı oturum açtıktan sonra hata mesajı ile birlikte ödeme sayfasına yönlendirin
                return redirect()->route('neighbors.index')->with('error', 'Satın alma işleminde bir hata oluştu. Tekrar deneyiniz.');
            }
        }

        // Kullanıcı veya sipariş bulunamazsa, giriş sayfasına yönlendirin veya başka bir işlem yapın
        return redirect()->route('client.login');
    }



    public function neighborView(Request $request)
    {
        $bankAccounts = BankAccount::all();
        $order = CartOrder::where('id', $request->order_id)->first();

        $cartItem = CartItem::where('user_id', Auth::user()->id)->latest()->first();
        $cart = json_decode($cartItem->cart, true);
        if ($cart) {


            $saleType = null;
            $column_name = null;
            $project = null;
            $projectHousingsList = [];
            $projectHousings = null;

            $housing = null;

            if (isset($cart) && !empty($cart)) {
                if ($cart['type'] == 'housing') {
                    $housing = Housing::with('images')
                        ->select(
                            'housings.id',
                            'housings.slug',
                            'housings.title AS housing_title',
                            'housings.created_at',
                            'housings.step1_slug',
                            'housings.step2_slug',
                            'housing_types.title as housing_type_title',
                            'housings.housing_type_data',
                            'project_list_items.column1_name as column1_name',
                            'project_list_items.column2_name as column2_name',
                            'project_list_items.column3_name as column3_name',
                            'project_list_items.column4_name as column4_name',
                            'project_list_items.column1_additional as column1_additional',
                            'project_list_items.column2_additional as column2_additional',
                            'project_list_items.column3_additional as column3_additional',
                            'project_list_items.column4_additional as column4_additional',
                            'housings.address',
                            \Illuminate\Support\Facades\DB::raw('(SELECT status FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing" AND JSON_EXTRACT(cart, "$.item.id") = housings.id) AS sold'),
                            'cities.title AS city_title',
                            'districts.ilce_title AS county_title',
                            'neighborhoods.mahalle_title AS neighborhood_title',
                            DB::raw('(SELECT discount_amount FROM offers WHERE housing_id = housings.id AND type = "housing" AND start_date <= "' . date('Y-m-d H:i:s') . '" AND end_date >= "' . date('Y-m-d H:i:s') . '") as discount_amount'),
                        )
                        ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
                        ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
                        ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
                        ->leftJoin('cities', 'cities.id', '=', 'housings.city_id')
                        ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id')
                        ->leftJoin('neighborhoods', 'neighborhoods.mahalle_id', '=', 'housings.neighborhood_id')
                        ->where('housings.status', 1)
                        ->where("housings.id", $cart['item']['id'])
                        ->where('project_list_items.item_type', 2)
                        ->orderByDesc('housings.created_at')
                        ->first();

                    $saleType = $housing->step2_slug;
                } else {
                    $project = Project::where('id', $cart['item']['id'])->first();
                    $saleType = $project->step2_slug;
                    $projectHousings = ProjectHousing::where('project_id', $project->id)->get();

                    $combinedValues = $projectHousings->map(function ($item) use (&$projectHousingsList) {
                        $projectHousingsList[$item->room_order][$item->name] = $item->value;
                    });
                }
            }

            return view('payment.neighbor.index', compact('order', 'bankAccounts', 'cart', 'saleType', 'project', 'projectHousingsList', 'projectHousings', 'housing'));
        }

        return view('payment.neighbor.index');
    }
}
