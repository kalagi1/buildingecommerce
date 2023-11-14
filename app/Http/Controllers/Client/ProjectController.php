<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\City;
use App\Models\Housing;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\HousingTypeParent;
use App\Models\Menu;
use App\Models\Offer;
use App\Models\Project;
use App\Models\ProjectHouseSetting;
use App\Models\ProjectImage;
use App\Models\StandOutUser;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index($slug)
    {
        // Cache::forget('project_'.$slug);
        // if(Cache::get('project_'.$slug)){
        //     $cachedHtml = Cache::get('project_'.$slug);
        //     return response($cachedHtml);
        // }else{
        $menu = Menu::getMenuItems();
        $project = Project::where('slug', $slug)->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->firstOrFail();
        $project->roomInfo = $project->roomInfo;
        $project->brand = $project->brand;
        $project->housingType = $project->housingType;
        $project->county = $project->county;
        $project->city = $project->city;
        $project->user = $project->user;
        $project->user->housings = $project->user->housings;
        $project->user->brands = $project->user->brands;
        $project->images = $project->images;
        $offer = Offer::where('project_id', $project->id)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();

        return view('client.projects.index', compact('menu', "offer", 'project'));

        // Cache::rememberForever('project_'.$slug ,  function () use($offer,$project,$menu) {
        //     return view('client.projects.index', compact('menu', "offer",'project'))->render();
        // });
        // }

    }

    public function detail($slug)
    {
        $menu = Menu::getMenuItems();
        $project = Project::where('slug', $slug)->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->firstOrFail();
        $project->roomInfo = $project->roomInfo;
        $project->brand = $project->brand;
        $project->housingType = $project->housingType;
        $project->county = $project->county;
        $project->city = $project->city;
        $project->user = $project->user;
        $project->user->housings = $project->user->housings;
        $project->user->brands = $project->user->brands;
        $project->images = $project->images;

        $offer = Offer::where('project_id', $project->id)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();
        if ($project->status == 0) {
            return view('client.projects.product_not_found', compact('menu', 'project'));
        }
        return view('client.projects.detail', compact('menu', 'project', 'offer'));
    }

    public function projectPaymentPlan(Request $request)
    {
        $project = Project::with("roomInfo")->where('id', $request->input('project_id'))->first();
        return $project;
    }

    public function brandProjects($id)
    {
        $menu = Menu::getMenuItems();
        $brand = Brand::where('id', $id)->with("user", "projects", "housings")->first();
        return view('client.projects.brand_projects', compact('menu', 'brand'));
    }

    public function projectList(Request $request)
    {
        $projects = Project::where('status', 1)->orderBy('view_count');
        if ($request->input("search")) {
            $projects = $projects->where('project_title', 'LIKE', '%' . $request->input('search') . '%');
        }

        if ($request->input("city_id")) {
            $projects = $projects->where('city_id', $request->input("city_id"));
        }

        if ($request->input("housing_type_id")) {
            $projects = $projects->where('housing_type_id', $request->input("housing_type_id"));
        }

        $housingTypes = HousingType::where('active', 1)->get();
        $housingStatus = HousingStatus::get();
        $cities = City::get();
        $projects = $projects->get();
        $menu = Menu::getMenuItems();
        return view('client.projects.list', compact('menu', 'projects', 'housingTypes', 'housingStatus', 'cities'));
    }

    public function allMenuProjects($slug = null, $type = null, $optional = null, $title = null)
    {
        $deneme = null;
        if ($slug == "al-sat-acil") {
            $deneme = "al-sat-acil";
        }

        $parameters = [$slug, $type, $optional, $title];
        $secondhandHousings = [];
        $projects = [];
        $slug = [];
        $slugName = [];

        $housingTypeSlug = [];
        $housingTypeSlugName = [];

        $housingType = [];
        $housingTypeName = [];
        $housingTypeSlug = [];

        $opt = null;
        $is_project = null;

        $optName = [];

        if ($deneme) {
            $slug = "al-sat-acil";
            $slugName = "Al Sat Acil";
            $secondhandHousings = Housing::with('images')
                ->select(
                    'housings.id',
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
                    \Illuminate\Support\Facades\DB::raw('(SELECT cart FROM cart_orders WHERE JSON_EXTRACT(housing_type_data, "$.type") = "housings" AND JSON_EXTRACT(housing_type_data, "$.item.id") = housings.id) AS sold'),
                    'cities.title AS city_title', // city tablosundan veri çekme
                    'districts.ilce_title AS county_title' // district tablosundan veri çekme
                )
                ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
                ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
                ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
                ->leftJoin('cities', 'cities.id', '=', 'housings.city_id') // city tablosunu join etme
                ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id') // district tablosunu join etme
                ->where('housings.status', 1)
                ->whereJsonContains('housings.housing_type_data->buysellurgent1', 'Evet')
                ->where('project_list_items.item_type', 2)
                ->orderByDesc('housings.created_at')
                ->get();

        }

        foreach ($parameters as $paramValue) {
            if ($paramValue) {

                if ($paramValue == "satilik" || $paramValue == "kiralik") {
                    $opt = $paramValue;
                    if ($opt) {
                        $opt = $opt;
                        if ($opt == "satilik") {
                            $optName = "Satılık";
                        } else {
                            $optName = "Kiralık";
                        }
                    }
                } else {
                    $item1 = HousingStatus::where('slug', $paramValue)->first();
                    $housingTypeParent = HousingTypeParent::where('slug', $paramValue)->first();
                    $housingType = HousingType::where('slug', $paramValue)->first();

                    if ($item1) {
                        $is_project = $item1->is_project;
                        $slugName = $item1->name;
                        $slug = $item1->id;
                    }

                    if ($housingTypeParent) {
                        $housingTypeSlugName = $housingTypeParent->title;
                        $housingTypeSlug = $housingTypeParent->slug;
                    }

                    if ($housingType) {
                        $housingTypeName = $housingType->title;
                        $housingTypeSlug = $housingType->slug;
                        $housingType = $housingType->id;
                    }
                }

            }
        }

        if ($slug) {
            if ($is_project) {
                $oncelikliProjeler = StandOutUser::where('housing_status_id', $slug)->pluck('project_id')->toArray();
                $firstProjects = Project::with("city", "county")->whereIn('id', $oncelikliProjeler)->get();

                $query = Project::query()->where('status', 1)->whereNotIn('id', $oncelikliProjeler)->orderBy('created_at', 'desc');

                if ($housingTypeSlug) {
                    $query->where("step1_slug", $housingTypeSlug);
                }

                if ($opt) {
                    $query->where("step2_slug", $opt);
                }

                if ($housingType) {
                    $query->where('housing_type_id', $housingType);
                }

                $query->whereHas('housingTypes', function ($query) use ($slug) {
                    $query->where('housing_type_id', $slug);
                });

                $anotherProjects = $query->get();
                $projects = StandOutUser::join("projects", 'projects.id', '=', 'stand_out_users.project_id')->select("projects.*")->whereIn('project_id', $oncelikliProjeler)
                    ->orderBy('item_order', 'asc')
                    ->get()
                    ->concat($anotherProjects);

            } else {
                $query = Housing::with('images', "city", "county");

                if ($housingTypeSlug) {
                    $query->where("step1_slug", $housingTypeSlug);
                }

                if ($housingType) {
                    $query->where('housing_type_id', $housingType);
                }

                if ($opt) {
                    $query->where('step2_slug', $opt);
                }

                $query->whereHas('housingStatus', function ($query) use ($slug) {
                    $query->where('housing_status_id', $slug);
                });
                $secondhandHousings = $query->get();
            }

        } else {
            $query = Housing::with('images', "city", "county");

            if ($housingTypeSlug) {
                $query->where("step1_slug", $housingTypeSlug);
            }

            if ($housingType) {
                $query->where('housing_type_id', $housingType);
            }

            if ($opt) {
                $query->where('step2_slug', $opt);
            }
            $secondhandHousings = $query->get();
        }


        $housingStatuses = HousingStatus::get();
        $cities = City::get();
        $menu = Menu::getMenuItems();

        return view('client.all-projects.menu-list', compact('menu', "opt", "housingTypeSlug", "optional", "optName", "housingTypeName", "housingTypeSlug", "housingTypeSlugName", "slugName", "housingTypeParent", "housingType", 'projects', "slug", 'secondhandHousings', 'housingStatuses', 'cities', 'title', 'type'));
    }

    public function allProjects($slug)
    {

        // HousingStatus modelini kullanarak slug'a göre durumu bulun
        $status = HousingStatus::where('slug', $slug)->first();
        $secondhandHousings = [];
        $projects = [];

        // HousingStatus bulunamazsa hata sayfasına yönlendirin
        if (!$status) {
            $type = HousingType::where('slug', $slug)->first();
            if (!$type) {
                abort(404); // Eğer HousingType bulunamazsa 404 hatası döndürün veya başka bir işlem yapabilirsiniz.
            }
            $title = $type->title;
            $projects = Project::with("city", "county")->where("housing_type_id", $type->id)->get();

        } else {
            if (!$status) {
                abort(404); // Eğer HousingType bulunamazsa 404 hatası döndürün veya başka bir işlem yapabilirsiniz.
            }
            $title = $status->name;
            if ($status->id == 1) {
                $projects = Project::all();
            } elseif ($status->id == 4) {
                $projects = [];
                $secondhandHousings = Housing::with('images', "city", "county")->get();
            } else {
                $oncelikliProjeler = StandOutUser::where('housing_status_id', $status->id)->pluck('project_id')->toArray();
                $firstProjects = Project::with("city", "county")->whereIn('id', $oncelikliProjeler)->get();

                $anotherProjects = Project::with("city", "county")->whereNotIn('id', $oncelikliProjeler)
                    ->orderBy('created_at', 'desc') // Eklenme tarihine göre sırala (en son eklenenler en üstte olur)
                    ->get();

                $projects = StandOutUser::join("projects", 'projects.id', '=', 'stand_out_users.project_id')->select("projects.*")->whereIn('project_id', $oncelikliProjeler)
                    ->orderBy('item_order', 'asc') // Öne çıkarılma sırasına göre sırala
                    ->get()
                    ->concat($anotherProjects);
            }
        }

        $housingTypes = HousingType::where('active', 1)->get();
        $housingStatuses = HousingStatus::get();
        $cities = City::get();
        $menu = Menu::getMenuItems();

        return view('client.all-projects.list', compact('menu', 'projects', 'secondhandHousings', 'housingTypes', 'housingStatuses', 'cities', 'title'));
    }

    public function projectHousingDetail($projectSlug, $housingOrder)
    {
        $menu = Menu::getMenuItems();
        $project = Project::where('slug', $projectSlug)->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->firstOrFail();
        $projectHousing = $project->roomInfo->keyBy('name');
        $projectImages = ProjectImage::where('project_id', $project->id)->get();
        $projectHousingSetting = ProjectHouseSetting::where('house_type', $project->housing_type_id)->orderBy('order')->get();
        return view('client.projects.project_housing', compact('menu', 'project', 'housingOrder', 'projectHousingSetting', 'projectHousing'));
    }

    public function propertyProjects(Request $request, $property)
    {
        $housingStatus = HousingStatus::where('slug', $property)->first();
        $projects = Project::whereHas('housingStatus', function ($query) use ($housingStatus) {
            $query->where('housing_type_id', $housingStatus->id);
        })->orderBy('view_count');
        if ($request->input("search")) {
            $projects = $projects->where('project_title', 'LIKE', '%' . $request->input('search') . '%');
        }

        if ($request->input("city_id")) {
            $projects = $projects->where('city_id', $request->input("city_id"));
        }

        if ($request->input("housing_type_id")) {
            $projects = $projects->where('housing_type_id', $request->input("housing_type_id"));
        }

        $housingTypes = HousingType::where('active', 1)->get();
        $housingStatus = HousingStatus::get();
        $cities = City::get();
        $projects = $projects->get();
        $menu = Menu::getMenuItems();
        return view('client.projects.list', compact('menu', 'projects', 'housingTypes', 'housingStatus', 'cities'));
    }
}
