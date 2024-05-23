<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartOrder;
use App\Models\DefaultMessage;
use App\Models\DocumentNotification;
use App\Models\DopingOrder;
use App\Models\Housing;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\Invoice;
use App\Models\Log;
use App\Models\Menu;
use App\Models\NeighborView;
use App\Models\Offer;
use App\Models\Project;
use App\Models\ProjectHousing;
use App\Models\ProjectHousings;
use App\Models\ShareLink;
use App\Models\StandOutUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function clubRateUpdate(Request $request, Project $project)
    {
        $request->validate([
            'club_rate' => 'required|numeric|min:0',
        ]);

        $project->club_rate = $request->input('club_rate');
        $project->save();

        return redirect()->back()->with('success', 'Emlakçı oranı başarıyla güncellendi.');
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'deposit_rate' => 'required|numeric|min:0',
        ]);

        $project->deposit_rate = $request->input('deposit_rate');
        $project->save();

        return redirect()->back()->with('success', 'Kapora oranı başarıyla güncellendi.');
    }

    public function index()
    {
        $projectStatuses = [
            1 => 'Aktif',
            0 => 'Pasif',
            2 => 'Onay Bekliyor',
            3 => 'Yönetim Tarafından Reddedildi',
        ];

        $activeProjects = Project::where('status', 1)->orderByDesc('updated_at')->get();
        $inactiveProjects = Project::where('status', 0)->orderByDesc('updated_at')->get();
        $disabledProjects = Project::where('status', 3)->orderByDesc('updated_at')->get();
        $pendingProjects = Project::where('status', 2)->orderByDesc('updated_at')->get();
        $deletedProjects = Project::onlyTrashed()->get();

        // Hesaplamaları yapan bir fonksiyon
        $calculateOrderCount = function ($projects) {
            return $projects->map(function ($project) {
                $orderCount = \App\Models\CartOrder::where('status', '0')
                    ->whereJsonContains('cart->item->id', $project->id)
                    ->count();

                return [
                    'project' => $project,
                    'orderCount' => $orderCount,
                ];
            });
        };

        $activeProjects = $calculateOrderCount($activeProjects)->sortByDesc('orderCount');
        $inactiveProjects = $calculateOrderCount($inactiveProjects)->sortByDesc('orderCount');
        $disabledProjects = $calculateOrderCount($disabledProjects)->sortByDesc('orderCount');
        $pendingProjects = $calculateOrderCount($pendingProjects)->sortByDesc('orderCount');
        $deletedProjects = $calculateOrderCount($deletedProjects)->sortByDesc('orderCount');

        return view('admin.projects.index', compact(
            'activeProjects',
            'inactiveProjects',
            'disabledProjects',
            'pendingProjects',
            'deletedProjects',
            'projectStatuses'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        return view('admin.projects.create', ['housing_types' => $housing_types, 'housing_status' => $housing_status]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $allDatas = $request->all();
        return $allDatas;
        $vData = $request->validate([
            'projectData.project_title' => 'required|string',
            'projectData.address' => 'required|string|max:128',
            'projectData.housing_type' => 'required|integer',
            'projectData.status' => 'required|in:1,2,3',
        ]);
        $dynamicDatas = $request->dynamicData;
        $projectId = Project::create($vData);
        foreach ($dynamicDatas as $data) {
            $data[] = ['project_id' => $projectId];
        }
        ProjectHousings::insert($dynamicDatas);
        return redirect()->route('admin.projects.create')->with('success', 'Project and housings created successfully');
    }

    public function detail($id)
    {
        $startTime = microtime(true);
        $defaultMessages = DefaultMessage::get();
        $project = Project::where('id', $id)->first();
        $projectHousings = ProjectHousing::where('project_id', $id)->get();
        $projectHousingsList = [];
        $combinedValues = $projectHousings->map(function ($item) use (&$projectHousingsList) {
            $projectHousingsList[$item->room_order][$item->name] = $item->value;
        });
        $housingTypeData = HousingType::where('id', $project->housing_type_id)->first();
        $housingTypeData = json_decode($housingTypeData->form_json);
        $housingData = $project->roomInfo;
        $statusID = $project->housingStatus->where('housing_type_id', '<>', 1)->first()->housing_type_id ?? 1;
        $status = HousingStatus::find($statusID);
        $projectHousings = ProjectHousing::where('project_id', $project->id)->get();

        $salesCloseProjectHousingCount = ProjectHousing::where('name', 'off_sale[]')->where('project_id', $project->id)->where('value', '!=', '[]')->count();
        return view('admin.projects.detail', compact('startTime', "projectHousingsList", "status", "salesCloseProjectHousingCount", 'project', 'projectHousingsList', 'housingTypeData', 'housingData', 'defaultMessages'));
    }

    public function setStatus($projectId, Request $request)
    {
        $project = Project::where('id', $projectId)->with('user')->firstOrFail();
        $reason = '';
        $isRejected = 0;

        if ($request->input('status') == 3) {
            $isRejected = 1;
            $reason = $request->input('reason');

            $notificationText = 'Üzgünüz, Proje #' . $projectId . ' "' . $reason . '" sebebinden dolayı reddedildi.';
            $notificationLink = route('institutional.project.edit.v2', ['projectSlug' => $project->slug,  'project_id' => $project->id]);

            DocumentNotification::create([
                'user_id' => auth()->user()->id,
                'text' => $notificationText,
                'item_id' => $projectId,
                'link' => $notificationLink,
                'owner_id' => $project->user->id,
                'is_visible' => true,
            ]);

            ShareLink::where('item_type', "1")->where('item_id', $project->id)->delete();
        } else if ($request->input('status') == 1) {
            $reason = 'Başarıyla projeniz aktife alındı';


            $statusID = $project->housingStatus->where('housing_type_id', '<>', 1)->first()->housing_type_id ?? 1;
            $status = HousingStatus::find($statusID);

            $notificationText = 'Proje #' . $projectId + 1000000 . ' şu anda yayında! Tebrikler! Daha fazla detay için [Proje Detay Sayfası]
            (' . route('project.detail', [
                'slug' => $project->slug . "-" . $status->slug . "-" . $project->step2_slug . "-" . $project->housingtype->slug, 'id' => $project->id + 1000000
            ]) . ').';

            DocumentNotification::create([
                'user_id' => auth()->user()->id,
                'text' => $notificationText,
                'item_id' => $project->id,
                'link' => null,
                'owner_id' => $project->user->id,
                'is_visible' => true,
            ]);

            if ($project->status == 2) {
                foreach ($project->dopingOrder as $doping) {
                    $startDate = Carbon::createFromFormat('Y-m-d', $doping->standOut->start_date);
                    $endDate = Carbon::createFromFormat('Y-m-d', $doping->standOut->end_date);
                    $dayCount = $startDate->diffInDays($endDate);
                    $now = Carbon::now();
                    $endDate = Carbon::now()->addDays($dayCount);

                    DopingOrder::where('id', $doping->id)->update([
                        'status' => 1,
                        'admin_id' => Auth::user()->id
                    ]);

                    StandOutUser::where('id', $doping->standOut->id)->update([
                        'start_date' => $now->format('y-m-d'),
                        'end_date' => $endDate->format('y-m-d'),
                    ]);
                }
            }
        } else {
            $notificationText = 'Proje #' . $projectId . ' pasife alındı. Proje detaylarını güncellemek için [Buraya Tıklayınız](' . route('institutional.project.edit.v2', ['projectSlug' => $project->slug,  'project_id' => $project->id]) . ').';

            DocumentNotification::create([
                'user_id' => auth()->user()->id,
                'text' => $notificationText,
                'item_id' => $project->id,
                'link' => null,
                'owner_id' => $project->user->id,
                'is_visible' => true,
            ]);
        }

        $project = Project::where('id', $projectId)->firstOrFail();
        $projectUpdate = Project::where('id', $projectId)->update([
            'status' => $request->input('status'),
        ]);


        if ($projectUpdate && $request->input('status') != 1) {
            ShareLink::where('item_type', "1")->where('item_id', $project->id)->delete();
        }

        Log::create([
            'item_type' => 1,
            'item_id' => $projectId,
            'reason' => $reason,
            'is_rejected' => $isRejected,
            'user_id' => auth()->user()->id,
        ]);

        return json_encode([
            'status' => true,
        ]);
    }

    public function setStatusGet($projectId)
    {
        $project = Project::where('id', $projectId)->with('user')->firstOrFail();
        if ($project->status == 0 || $project->status == 2 || $project->status == 3) {
            Project::where('id', $projectId)->update([
                'status' => 1,
            ]);
        } else {
            Project::where('id', $projectId)->update([
                'status' => 0,
            ]);
        }

        $statusID = $project->housingStatus->where('housing_type_id', '<>', 1)->first()->housing_type_id ?? 1;
        $status = HousingStatus::find($statusID);
        DocumentNotification::create(
            [
                'user_id' => auth()->user()->id,
                'text' => '#' . $projectId + 1000000 . " No'lu projeniz şu anda yayında!",
                'item_id' => $project->id,
                'link' => route('project.detail', ['slug' => $project->slug . "-" . $status->slug . "-" . $project->step2_slug . "-" . $project->housingtype->slug, 'id' => $project->id + 1000000]),
                'owner_id' => $project->user->id,
                'is_visible' => true,
            ]
        );

        if ($project->status == 2) {
            foreach ($project->dopingOrder as $doping) {
                $startDate = Carbon::createFromFormat('Y-m-d', $doping->standOut->start_date);
                $endDate = Carbon::createFromFormat('Y-m-d', $doping->standOut->end_date);
                $dayCount = $startDate->diffInDays($endDate);
                $now = Carbon::now();
                $endDate = Carbon::now()->addDays($dayCount);
                DopingOrder::where('id', $doping->id)->update([
                    'status' => 1,
                    'admin_id' => Auth::user()->id
                ]);

                StandOutUser::where('id', $doping->standOut->id)->update([
                    'start_date' => $now->format('y-m-d'),
                    'end_date' => $endDate->format('y-m-d'),
                ]);
            }
        } else {
            DocumentNotification::create(
                [
                    'user_id' => auth()->user()->id,
                    'text' => "#" . $projectId + 1000000 . " No'lu projeniz pasife alındı!",
                    'item_id' => $project->id,
                    'link' => route('institutional.project.edit.v2', ['projectSlug' => $project->slug, 'project_id' => $project->id]),
                    'owner_id' => $project->user->id,
                    'is_visible' => true,
                ]
            );
        }

        if ($project->status == 1) {
            Log::create([
                'item_type' => 1,
                'item_id' => $projectId,
                'reason' => "#" . $projectId + 1000000  . " No'lu projeniz admin tarafından pasife alındı.",
                'is_rejected' => 0,
                'user_id' => auth()->user()->id,
            ]);
            ShareLink::where('item_type', "1")->where('item_id', $projectId)->delete();
        } else {
            Log::create([
                'item_type' => 1,
                'item_id' => $projectId,
                'reason' => "#" . $projectId + 1000000 . " No'lu projeniz admin tarafından aktif edildi.",
                'is_rejected' => 0,
                'user_id' => auth()->user()->id,
            ]);
        }

        return redirect()->route('admin.projects.detail', $projectId);
    }

    public function logs($projectId)
    {
        $logs = Log::where('item_type', 1)->where('item_id', $projectId)->orderByDesc('created_at')->with('user')->get();
        return view('admin.projects.logs', compact('logs'));
    }

    public function housings($project_id)
    {
        $menu = Menu::getMenuItems();
        $project = Project::where('id', $project_id)->with("brand", "blocks", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->firstOrFail();
        $project->roomInfo = $project->roomInfo;
        $project->brand = $project->brand;
        $project->housingType = $project->housingType;
        $project->county = $project->county;
        $project->city = $project->city;
        $project->user = $project->user;
        $project->user->housings = $project->user->housings;
        $project->user->brands = $project->user->brands;
        $project->images = $project->images;


        $sumCartOrderQt = DB::table('cart_orders')
            ->select(
                DB::raw('JSON_EXTRACT(cart, "$.item.housing") as housing_id'),
                DB::raw('JSON_EXTRACT(cart, "$.item.qt") as qt')
            )
            ->leftJoin('users', 'cart_orders.user_id', '=', 'users.id')
            ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
            ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $project->id)
            ->orderByRaw('CAST(housing_id AS SIGNED) ASC')
            ->get();


        $sumCartOrderQt = $sumCartOrderQt->groupBy('housing_id')
            ->mapWithKeys(function ($group) {
                return [
                    $group->first()->housing_id => [
                        'housing_id' => $group->first()->housing_id,
                        'qt_total' => $group->sum('qt'),
                    ]
                ];
            })
            ->all();

        $projectHousings = ProjectHousing::where('project_id', $project->id)->get();
        $projectHousingsList = [];
        $combinedValues = $projectHousings->map(function ($item) use (&$projectHousingsList) {
            $projectHousingsList[$item->room_order][$item->name] = $item->value;
        });

        $offer = Offer::where('project_id', $project->id)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();


        return view('admin.projects.housings2', compact('menu', "sumCartOrderQt", "projectHousingsList", "offer", 'project'));
    }

    public function komsumuGorInfo2(Request $request)
    {
        $housingID = $request->no;
        $projectID = $request->projectID;
        $city_id = Project::where('id', $projectID)->value('city_id');
        $county_id = Project::where('id', $projectID)->value('county_id');
        $hisse_payi = (int)$request->hisse_payi;
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $userData = [
                'is_show' => 'no',
                'type' => 1,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt('komsumugor123'),
                'status' => 1,
                'is_blocked' => 0,
                'has_club' => '0',
            ];

            $user = User::create($userData);
        }

        //CartORders'a ekle
        $order = new CartOrder();

        $order->user_id      = $user->id;
        $order->status       = '1';
        $order->key          = 1000000 + $projectID + $housingID;
        $order->full_name    = $user->name;
        $order->email        = $user->email;
        $order->tc           = $request->tc;
        $order->is_swap      = 0;
        $order->is_reference = 0;
        $order->is_show_user = "on";
        $order->amount       = 0;
        $order->is_disabled  = 1; // sonradan eklenen konutlar için
        $order->store_id     = Project::where('id', $projectID)->value('user_id');
        $order->phone        = $request->phone;
        $order->address      = $request->address;

        $user->update([
            "name" => $request->name,
            "idNumber" => $request->tc,
            "mobile_phone"  => $request->phone,
            "phone" => $request->phone,
        ]);

        $cartJson['item']['id'] = (int)$projectID;
        $cartJson['item']['housing'] = (int)$housingID;
        $cartJson['item']['qt'] = (int)$hisse_payi;

        $neighborProjects  = [];
        $neighborProjects = NeighborView::with('user', 'owner', 'project')->where('project_id', $projectID)->where('user_id', $user->id)->get();
        $cartJson['item']['neighborProjects'] = $neighborProjects;
        function getHouse($project, $key, $roomOrder)
        {
            foreach ($project->roomInfo as $room) {
                if ($room->room_order == $roomOrder && $room->name == $key) {
                    return $room;
                }
            }
        }
        $project = Project::where('id', $projectID)->with('brand', 'roomInfo', 'housingType', 'county', 'city', 'user.projects.housings', 'user.brands', 'user.housings', 'images')->first();

        $cartJson['item']['city_id'] = $city_id;
        $cartJson['item']['county_id'] = $county_id;
        $cartJson['item']['image'] =  URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $housingID)->value;

        $cartJson['type'] = 'project';
        $cartJson['hasCounter'] = false;
        $order->cart = json_encode($cartJson);

        $order->save();

        $fatura = new Invoice();
        $fatura->order_id = $order->id;
        $fatura->total_amount = $request->price;
        $fatura->invoice_number = 'FTR-' . time() . $order->id;
        // Fatura numarası oluşturabilirsiniz.
        $fatura->save();

        return back()->with('message', 'Kaydedildi.');
    } //End

    public function komsumuGorInfo2Edit(Request $request)
    {
        // print_r("yunus");die;

        $email = $request->email;
        $userFirst = User::where('email', $email)->first();

        if (isset($userFirst)) {
            $updatedData = [
                'email'     => $request->email,
                'full_name' => $request->name,
                'phone'     => $request->phone,
                'tc'        => $request->tc,
                'address'   => $request->address,
                "is_show_user" => "on",
                "user_id"   => $userFirst->id
            ];


            $userFirst->update([
                "name" => $request->name,
                "idNumber" => $request->tc,
                "mobile_phone"  => $request->phone,
                "phone" => $request->phone,
            ]);

            $update = CartOrder::where('id', $request->cartOrderID)->update($updatedData);

            return redirect()->back()->with('success', 'Başarıyla düzenlendi');
        } else {

            $addedData = [
                'email'     => $request->email,
                'name'      => $request->name,
                'phone'     => $request->phone,
                'idNumber'  => $request->tc,
                'type'      => 1,
                "status"    => 1,
                'password'  => Hash::make("komsumugor123"),
            ];

            $user = User::create($addedData);

            $updatedData = [
                'email'     => $request->email,
                'full_name' => $request->name,
                'phone'     => $request->phone,
                'tc'        => $request->tc,
                'address'   => $request->address,
                "is_show_user" => "on",
                "user_id"   => $user->id
            ];


            $update = CartOrder::where('id', $request->cartOrderID)->update($updatedData);

            return redirect()->back()->with('success', 'Başarıyla düzenlendi');
        }
    } //End

    public function getUserInfo(Request $request)
    {
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if ($user) {
            return response()->json([
                'name' => $user->name,
                'phone' => $user->phone,
                'tc' => $user->idNumber,
                'address' => $user->address,
            ]);
        } else {
            // Kullanıcı bulunamazsa boş JSON döndür
            return response()->json([]);
        }
    } //End

    public function show($order)
    {
        $order = CartOrder::where("id", $order)->first();
        $cart = json_decode($order->cart);
        $project = null;

        if ($cart->type == "project") {
            $project = Project::where("id", $cart->item->id)->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->first();
        } else {
            $project = Housing::where("id", $cart->item->id)->with("user")->first();
        }

        $invoice = Invoice::where("order_id", $order->id)->with("order.user", "order.bank")->first();
        $data = [
            'invoice' => $invoice,
            'project' => $project,
        ];
        return view('admin.invoice.index', compact("data"));
    } //End

    public function komsumuSil($id)
    {

        $cartOrder = CartOrder::find($id);
        if ($cartOrder && $cartOrder->delete()) {
            return redirect()->back()->with('success', 'Başarıyla Silindi');
        }

        return redirect()->back()->with('error', 'Silme işlemi yapılırken hata!');
    } //End

    public function soldInvoiceDetail($id)
    {
        $order = CartOrder::where('cart->item->id', $id)->latest()->first();

        $project = Housing::where("id", $id)->with("user")->first();
        $invoice = Invoice::where('order_id', $order->id)->first();

        $data = [
            'invoice' => $invoice,
            'project' => $project,
        ];

        return view('admin.invoice.index', compact('data'));
    } //End

    public function soldOrderDetail($id)
    {
        $order = CartOrder::where('cart->item->id', $id)->latest()->first();
        return view('admin.orders.detail', compact('order'));
    } //End
}
