<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\FooterSlider;
use App\Models\Housing;
use App\Models\HousingStatus;
use App\Models\Menu;
use App\Models\Project;
use App\Models\Slider;
use App\Models\StandOutUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $menu = Menu::getMenuItems();

        $secondhandHousings = Housing::with('images')->select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.created_at',
            'housing_types.title as housing_type_title',
            'housings.housing_type_data',
            'housings.address',
        )->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
            ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
            ->where('housings.status', 1)
            ->get();

        $dashboardProjects = StandOutUser::where('start_date', "<=", date("Y-m-d"))->where('end_date', ">=", date("Y-m-d"))->orderBy("item_order")->get();
        $dashboardStatuses = HousingStatus::where('in_dashboard', 1)->orderBy("dashboard_order")->where("status", "1")->get();
        $brands = User::where("type", "2")->where("status", "1")->get();
        $sliders = Slider::all();
        $footerSlider = FooterSlider::all();

        $finishProjects = Project::whereHas('housingStatus', function ($query) {
            $query->where('housing_type_id', '2');
        })->with("housings", 'brand', 'roomInfo', 'housingType')->orderBy("created_at", "desc")->where('status', 1)->get();

        $continueProjects = Project::whereHas('housingStatus', function ($query) {
            $query->where('housing_type_id', '3');
        })->with("housings", 'brand', 'roomInfo', 'housingType')->where('status', 1)->orderBy("created_at", "desc")->get();

        return view('client.home.index', compact('menu', 'finishProjects', 'continueProjects', 'sliders', 'secondhandHousings', 'brands', 'dashboardProjects', 'dashboardStatuses', 'footerSlider'));
    }

    public function getRenderedProjects(Request $request)
    {
        $query = Project::query();

        if ($request->input('city')) {
            $query->where('city_id', $request->input('city'));
        }

        if ($request->input('county')) {
            $query->where('county_id', $request->input('county'));
        }

        // Sıralama seçeneğini kontrol et
        if ($request->input('sort')) {
            switch ($request->input('sort')) {
                case 'date-asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'date-desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        $itemPerPage = 12;
        $projects = $query->paginate($itemPerPage);

        $renderedProjects = $projects->through(function ($item) {
            return [
                'image' => url(str_replace('public/', 'storage/', $item->image)),
                'url' => route('project.detail', $item->slug),
                // İlanın diğer özelliklerini burada ekleyebilirsiniz
            ];
        });

        return response()->json($renderedProjects);
    }
    public function getRenderedSecondhandHousings(Request $request)
    {
        function convertMonthToTurkishCharacter($date)
        {
            $aylar = [
                'January' => 'Ocak',
                'February' => 'Şubat',
                'March' => 'Mart',
                'April' => 'Nisan',
                'May' => 'Mayıs',
                'June' => 'Haziran',
                'July' => 'Temmuz',
                'August' => 'Ağustos',
                'September' => 'Eylül',
                'October' => 'Ekim',
                'November' => 'Kasım',
                'December' => 'Aralık',
                'Monday' => 'Pazartesi',
                'Tuesday' => 'Salı',
                'Wednesday' => 'Çarşamba',
                'Thursday' => 'Perşembe',
                'Friday' => 'Cuma',
                'Saturday' => 'Cumartesi',
                'Sunday' => 'Pazar',
                'Jan' => 'Oca',
                'Feb' => 'Şub',
                'Mar' => 'Mar',
                'Apr' => 'Nis',
                'May' => 'May',
                'Jun' => 'Haz',
                'Jul' => 'Tem',
                'Aug' => 'Ağu',
                'Sep' => 'Eyl',
                'Oct' => 'Eki',
                'Nov' => 'Kas',
                'Dec' => 'Ara',
            ];
            return strtr($date, $aylar);
        }

        function getData($housing, $key)
        {
            $housing_type_data = json_decode($housing->housing_type_data);
            $a = $housing_type_data->$key;
            return $a[0];
        }

        function getImage($housing, $key)
        {
            $housing_type_data = json_decode($housing->housing_type_data);
            $a = $housing_type_data->$key;
            return $a;
        }

        $obj = Housing::with('images');

        if ($request->input('from_owner')) {
            switch ($request->input('from_owner')) {
                case 'from_owner':
                    $obj = $obj->join('users', 'users.id', '=', 'housings.user_id')
                        ->where('users.type', '1');
                    break;

                case 'from_office':
                    $obj = $obj->join('users', 'users.id', '=', 'housings.user_id')
                        ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                        ->join('subscription_plans', 'subscription_plans.id', '=', 'user_plans.subscription_plan_id')
                        ->where('users.type', '2')
                        ->where('subscription_plans.plan_type', 'Emlakçı');
                    break;

                case 'from_bank':
                    $obj = $obj->join('users', 'users.id', '=', 'housings.user_id')
                        ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                        ->join('subscription_plans', 'subscription_plans.id', '=', 'user_plans.subscription_plan_id')
                        ->where('users.type', '2')
                        ->where('subscription_plans.plan_type', 'Banka');
                    break;

                case 'from_company':
                    $obj = $obj->join('users', 'users.id', '=', 'housings.user_id')
                        ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                        ->join('subscription_plans', 'subscription_plans.id', '=', 'user_plans.subscription_plan_id')
                        ->where('users.type', '2')
                        ->where('subscription_plans.plan_type', 'İnşaat');
                    break;
            }
        }

        if ($request->input('city')) {
            $obj = $obj->where('city_id', $request->input('city'));
        }

        if ($request->input('county')) {
            $obj = $obj->where('county_id', $request->input('county'));
        }

        if ($request->input('price_min')) {
            $obj = $obj->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.price[0]")) AS DECIMAL(10, 2)) >= ?', [$request->input('price_min')]);
        }

        if ($request->input('price_max')) {
            $obj = $obj->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.price[0]")) AS DECIMAL(10, 2)) <= ?', [$request->input('price_max')]);
        }

        if ($request->input('msq_min')) {
            $obj = $obj->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.squaremeters[0]")) AS DECIMAL(10, 2)) >= ?', [$request->input('msq_min')]);
        }

        if ($request->input('msq_max')) {
            $obj = $obj->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.squaremeters[0]")) AS DECIMAL(10, 2)) <= ?', [$request->input('msq_max')]);
        }

        if ($request->input('room_count')) {
            $obj = $obj->whereJsonContains('housing_type_data->room_count', [$request->input('room_count')[0]]);
            $e = 0;
            foreach ($request->input('room_count') as $room_count) {
                if ($e == 0) {
                    $e = 1;
                    continue;
                }
                $obj = $obj->orWhereJsonContains('housing_type_data->room_count', [$room_count]);
            }
        }

        if ($request->input('post_date')) {
            switch ($request->input('post_date')) {
                case 'recent_day':
                    $obj = $obj->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime('-1 Days')));
                    break;

                case 'last_3_day':
                    $obj = $obj->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime('-3 Days')));
                    break;

                case 'last_7_day':
                    $obj = $obj->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime('-7 Days')));
                    break;

                case 'last_15_day':
                    $obj = $obj->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime('-15 Days')));
                    break;

                case 'last_30_day':
                    $obj = $obj->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime('-30 Days')));
                    break;
            }
        }

        if ($request->input('sort')) {
            switch ($request->input('sort')) {
                case 'date-asc':
                    $obj = $obj->orderBy('created_at', 'asc');
                    break;
                case 'date-desc':
                    $obj = $obj->orderBy('created_at', 'desc');
                    break;
                case 'price-asc':
                    $obj = $obj->orderByRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.price[0]")) AS DECIMAL(10, 2)) ASC');
                    break;
                case 'price-desc':
                    $obj = $obj->orderByRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.price[0]")) AS DECIMAL(10, 2)) DESC');
                    break;
            }
        }
        

        $itemPerPage = 12;
        $obj = $obj->paginate($itemPerPage);

        return response()->json($obj->through(function($item) use($request)
        {
            return [
                'image' => asset('housing_images/' . getImage($item, 'image')),
                'housing_type_title' => $item->housing_type_title,
                'id' => $item->id,
                'in_cart' => $request->session()->get('cart')['type'] == 'housing' && $request->session()->get('cart')['item']['id'] == $item->id,
                'housing_url' => route('housing.show', $item->id),
                'title' => $item->title,
                'housing_address' => $item->address,
                'created_at' => $item->created_at,
                'housing_type' =>
                [
                    'title' => $item->housing_type->title,
                    'room_count' => getData($item, 'room_count'),
                    'squaremeters' => getData($item, 'squaremeters'),
                    'price' => getData($item, 'price'),
                    'housing_date' => date('j', strtotime($item->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($item->created_at))),
                ],
            ];
        }));
    }

    public function getSearchList(Request $request)
    {
        $request->validate(
            [
                'searchTerm' => 'required|string',
            ]
        );

        $term = $request->input('searchTerm');

        return response()->json(
            [
                'housings' => Housing::where('title', 'LIKE', "%{$term}%")->get()->map(function ($item) {
                    $housingData = json_decode($item->housing_type_data);
                    return [
                        'id' => $item->id,
                        'photo' => $housingData->image,
                        'name' => $item->title,
                    ];
                }),
                'projects' => Project::where('project_title', 'LIKE', "%{$term}%")->get()->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'photo' => $item->image,
                        'name' => $item->project_title,
                        'slug' => $item->slug,

                    ];
                }),
                'merchants' => User::where('type', '2')->where('name', 'LIKE', "%{$term}%")->get()->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'photo' => $item->profile_image,
                        'name' => $item->name,
                        'slug' => Str::slug($item->name),
                    ];
                }),
            ]
        );
    }

}
