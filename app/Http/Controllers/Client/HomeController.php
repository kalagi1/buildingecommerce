<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\FooterSlider;
use App\Models\Housing;
use App\Models\HousingFavorite;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\HousingTypeParent;
use App\Models\Menu;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Slider;
use App\Models\StandOutUser;
use App\Models\User;
use App\Models\CartPrice;
use App\Models\CartOrder;
use App\Models\City;
use App\Models\Collection;
use App\Models\District;
use App\Models\Filter;
use App\Models\HousingTypeParentConnection;
use App\Models\Neighborhood;
use App\Models\ProjectHouseSetting;
use App\Models\ProjectHousing;
use App\Models\ProjectListItem;
use App\Models\ShareLink;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class HomeController extends Controller
{

    public function kesfet()
    {
        return view("client.kesfet");
    }

    public function previewHousing(Request $request)
    {
        $fillFormData = $request->input('fillFormData');
        $projectData = $request->input('projectData');
        $selectedTypes = $request->input('selectedTypes');
        $blocks = $request->input("blocks");

        $housingTypeParent1 = null;
        $housingTypeParent2 = null;
        $labels = [];

        if (isset($selectedTypes) && count($selectedTypes) >= 3) {
            $housingTypeParent1 = HousingTypeParent::findOrFail($selectedTypes[0]);
            $housingTypeParent2 = HousingTypeParent::findOrFail($selectedTypes[1]);
            $housingTypeParentConnection = HousingTypeParentConnection::find($selectedTypes[2]);

            if ($housingTypeParentConnection && isset($blocks)) {
                $housingType = HousingType::find($housingTypeParentConnection->housing_type_id);

                if ($housingType) {
                    $formJsonItems = json_decode($housingType->form_json, true) ?? [];

                    foreach ($blocks as $block) {
                        if (!empty($block['rooms'])) {
                            foreach ($block['rooms'] as $room) {
                                foreach ($room as $key => $value) {
                                    foreach ($formJsonItems as $formJsonItem) {
                                        if (is_array($formJsonItem) && isset($formJsonItem['name'])) {
                                            $formJsonItemName = rtrim($formJsonItem['name'], '[]');
                                            $keyWithoutLastCharacter = rtrim($key, '1');

                                            // Normalize the key to match the form JSON item name
                                            $keyNormalized = rtrim($key, '[]');


                                            if ($formJsonItemName == $keyNormalized) {
                                                if (isset($formJsonItem['label']) && !empty($value)) {
                                                    $labels[$formJsonItem['label']] = $value;
                                                }
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }



        $city = null;
        $county = null;
        $neighbour = null;

        if (isset($projectData)) {
            if (isset($projectData['city_id'])) {
                $city = City::where("id", $projectData['city_id'])->firstOrFail();
            }
            if (isset($projectData['county_id'])) {
                $county = District::where("ilce_key", $projectData['county_id'])->firstOrFail();
            }
            if (isset($projectData['neighbour_id'])) {
                $neighbour = Neighborhood::where('mahalle_key', $projectData['neighbourhood_id'])->firstOrFail();
            }
        }

        // Retrieve the latest housing data
        $latestHousing = Housing::latest('id')->first();
        $newHousingId = 0;

        if ($latestHousing) {
            $newHousingId = $latestHousing->id + 2000000;
        }

        $user = null;

        if (Auth::check()) {
            $user = User::where("id", auth()->user()->id)->firstOrFail();
        }
        // Check if cover_image is a string
        if (is_string($projectData['cover_image'])) {
            $coverImageBinary = base64_encode(file_get_contents($projectData['cover_image']));
            $projectData['cover_image_imagex'] = "data:image/jpeg;base64," . $coverImageBinary;
        }

        // Process gallery images
        foreach ($projectData['gallery_imagesx'] as &$imagePath) {
            if (is_string($imagePath)) {
                $imageBinary = base64_encode(file_get_contents($imagePath));
                $imagePath = "data:image/jpeg;base64," . $imageBinary;
            }
        }
        return view("preview", compact("fillFormData", "projectData", "city", "county", "neighbour", "newHousingId", "user", "housingTypeParent1", "housingTypeParent2", "blocks", "labels"));
    }
    public function previewProject(Request $request)
    {

        $fillFormData = $request->input('fillFormData');
        $projectData = $request->input('projectData');
        $selectedTypes = $request->input('selectedTypes');
        $blocks = $request->input("blocks");
        $totalRoomCount = $request->input("totalRoomCount");
        $haveBlocks = $request->input("haveBlocks");
        $roomCount = 0;
        if (isset($blocks) && is_array($blocks)) {
            foreach ($blocks as $block) {
                $roomCount += isset($block['roomCount']) ? (int) $block['roomCount'] : 0;
            }
        }


        $housingTypeParent1 = null;
        $housingTypeParent2 = null;
        $housingType = null;
        $labels = [];

        if (isset($selectedTypes) && count($selectedTypes) >= 3) {
            $housingTypeParent1 = HousingTypeParent::findOrFail($selectedTypes[1]);
            $housingTypeParent2 = HousingTypeParent::findOrFail($selectedTypes[2]);
            $housingTypeParentConnection = HousingTypeParentConnection::find($selectedTypes[3]);

            if ($housingTypeParentConnection && isset($blocks)) {
                $housingType = HousingType::find($housingTypeParentConnection->housing_type_id);


                if ($housingType) {
                    $formJsonItems = json_decode($housingType->form_json, true) ?? [];

                    foreach ($blocks as $block) {
                        if (!empty($block['rooms'])) {
                            foreach ($block['rooms'] as $room) {
                                foreach ($room as $key => $value) {
                                    foreach ($formJsonItems as $formJsonItem) {
                                        if (is_array($formJsonItem) && isset($formJsonItem['name'])) {
                                            $formJsonItemName = rtrim($formJsonItem['name'], '[]');
                                            $keyWithoutLastCharacter = rtrim($key, '1');

                                            // Normalize the key to match the form JSON item name
                                            $keyNormalized = rtrim($key, '[]');


                                            if ($formJsonItemName == $keyNormalized) {
                                                if (isset($formJsonItem['label']) && !empty($value)) {
                                                    $labels[$formJsonItem['label']] = $value;
                                                }
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $city = null;
        $county = null;
        $neighbour = null;

        if (isset($projectData)) {
            if (isset($projectData['city_id'])) {
                $city = City::where("id", $projectData['city_id'])->firstOrFail();
            }
            if (isset($projectData['county_id'])) {
                $county = District::where("ilce_key", $projectData['county_id'])->firstOrFail();
            }
            if (isset($projectData['neighbourhood_id'])) {
                $neighbour = Neighborhood::where('mahalle_id', $projectData['neighbourhood_id'])->firstOrFail();
            }
        }

        // Retrieve the latest housing data
        $latestHousing = Housing::latest('id')->first();
        $newHousingId = 0;

        if ($latestHousing) {
            $newHousingId = $latestHousing->id + 2000000;
        }

        $user = null;

        if (Auth::check()) {
            $user = User::where("id", auth()->user()->id)->firstOrFail();
        }
        // Check if cover_image is a string
        if (is_string($projectData['cover_image'])) {
            $coverImageBinary = base64_encode(file_get_contents($projectData['cover_image']));
            $projectData['cover_image_imagex'] = "data:image/jpeg;base64," . $coverImageBinary;
        }

        // Process gallery images
        foreach ($projectData['gallery_imagesx'] as &$imagePath) {
            if (is_string($imagePath)) {
                $imageBinary = base64_encode(file_get_contents($imagePath));
                $imagePath = "data:image/jpeg;base64," . $imageBinary;
            }
        }

        $projectListItems = ProjectListItem::where('housing_type_id', $housingType->id)->get();

        return view("preview-project", compact("fillFormData", "projectListItems", "haveBlocks", "roomCount", "totalRoomCount", "projectData", "city", "county", "neighbour", "newHousingId", "user", "housingTypeParent1", "housingTypeParent2", "blocks", "labels"));
    }

    public function updateBrandStatus(Request $request)
    {
        $brandId = $request->input('brandId');
        $isShow = $request->input('isShow');

        try {
            // Find the brand by ID
            $brand = User::findOrFail($brandId);

            // Update the 'is_show' field
            $brand->is_show = $isShow;
            $brand->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Handle any errors, log or return an error response
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function updateCollectionStatus(Request $request)
    {
        $collectionID = $request->input('collectionID');
        $status = $request->input('status');

        try {

            $brand = Collection::findOrFail($collectionID);
            $brand->status = $status;
            $brand->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Handle any errors, log or return an error response
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function index()
    {

        // $start = microtime(true);
        // $menu = Cache::rememberForever('menu', function () {
        //     return Menu::getMenuItems();
        // });
        $dashboardProjects = Project::with([
            "city",
            "county",
            'user',
            'brand',
            'roomInfo',
            'listItemValues',
            'housingType'
        ])
            ->where('status', 1)
            ->orderBy("created_at", "desc")
            ->paginate(12);

        $soilProjects = Project::with("city", "county", 'user', 'brand', 'roomInfo', 'housingType')
            ->whereHas('housingStatus', function ($query) {
                $query->where('housing_type_id', '5');
            })
            ->where('status', 1)
            ->orderBy("created_at", "desc")
            ->get();

        $dashboardStatuses = HousingStatus::where('in_dashboard', 1)->orderBy("dashboard_order")->where("status", "1")->get();

        $brands = User::where("type", "2")->where('corporate_type', "İnşaat Ofisi")->where("status", "1")->where("is_show", "yes")->where("corporate_account_status", "1")->orderBy("order", "asc")->get();
        $housingBrands = User::where("type", "2")->where('corporate_type', 'Emlak Ofisi')->where("status", "1")->where("is_show", "yes")->where("corporate_account_status", "1")->orderBy("order", "asc")->get();

        $sliders = Slider::all();

        $footerSlider = FooterSlider::all();

        $finishProjects = Project::with([
            "city", "county", 'user', 'brand', 'roomInfo', 'listItemValues', 'housingType'
        ])
            ->whereHas('housingStatus', function ($query) {
                $query->where('housing_type_id', '2');
            })
            ->where('status', 1)
            ->orderBy("created_at", "desc")
            ->get();

        $continueProjects = Project::select(\Illuminate\Support\Facades\DB::raw('(SELECT created_at FROM stand_out_users WHERE item_type = 1 AND item_id = projects.id AND housing_type_id = 0) as doping_time'), 'projects.*')
            ->with("city", "county", 'user', 'brand', 'roomInfo', 'housingType')
            ->whereHas('housingStatus', function ($query) {
                $query->where('housing_type_id', '3');
            })
            ->where('status', 1)
            ->orderBy("created_at", "desc")
            ->get();

        $sharerLinks = auth()->user() ? ShareLink::where('user_id', auth()->user()->id)->where('item_type', 2)->pluck('item_id')->toArray() : [];

        // $housing = Housing::with('images',
        //     'housing_type',
        //     'listItems',
        //     'city',
        //     'district',
        //     'neighborhood')
        // ->select(
        //     'housings.id',
        //     'housings.slug',
        //     'housings.title AS housing_title',
        //     'housings.created_at',
        //     'housings.step1_slug',
        //     'housings.step2_slug',
        //     'housing_types.title as housing_type_title',
        //     'housings.housing_type_data',
        //     'project_list_items.column1_name as column1_name',
        //     'project_list_items.column2_name as column2_name',
        //     'project_list_items.column3_name as column3_name',
        //     'project_list_items.column4_name as column4_name',
        //     'project_list_items.column1_additional as column1_additional',
        //     'project_list_items.column2_additional as column2_additional',
        //     'project_list_items.column3_additional as column3_additional',
        //     'project_list_items.column4_additional as column4_additional',
        //     'housings.address',
        //     DB::raw('(SELECT status FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing" AND JSON_EXTRACT(cart, "$.item.id") = housings.id ORDER BY created_at DESC LIMIT 1) AS sold'),
        //     'cities.title AS city_title',
        //     'districts.ilce_title AS county_title',
        //     'neighborhoods.mahalle_title AS neighborhood_title',
        //     DB::raw('(SELECT discount_amount FROM offers WHERE housing_id = housings.id AND type = "housing" AND start_date <= "' . date('Y-m-d H:i:s') . '" AND end_date >= "' . date('Y-m-d H:i:s') . '" LIMIT 1) as discount_amount'),
        // )
        // ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
        // ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
        // ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
        // ->leftJoin('cities', 'cities.id', '=', 'housings.city_id')
        // ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id')
        // ->leftJoin('neighborhoods', 'neighborhoods.mahalle_id', '=', 'housings.neighborhood_id')
        // ->where('housings.status', 1)
        // ->where('project_list_items.item_type', 2)
        // ->orderByDesc('housings.created_at')
        // ->paginate(5);
        // ->get();



        $housings = Housing::with([
            'images',
            'housing_type',
            'listItems',
            'city',
            'district',
            'neighborhood'
        ])
            ->where('status', 1)
            ->whereNull('is_sold')
            ->whereHas('listItems', function ($query) {
                $query->where('item_type', 2);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('client.home.index', compact('sharerLinks', "soilProjects", 'finishProjects', 'continueProjects', 'sliders', 'housings', 'brands', 'dashboardProjects', 'dashboardStatuses', 'footerSlider', 'housingBrands'));
    }


    public function satKirala()
    {
        return view("client.satkirala");
    }

    public function getRenderedProjects(Request $request)
    {
        $parameters = ["slug", "type", "optional", "title"];
        $secondhandHousings = [];
        $projects = [];
        $slug = [];
        $slugType = null;
        $slugName = [];

        $housingTypeSlug = [];
        $housingTypeSlugName = [];

        $housingType = [];
        $housingTypeName = [];

        $opt = null;
        $is_project = null;

        $optName = [];

        foreach ($parameters as $paramValue) {
            if ($paramValue) {
                if ($request->input($paramValue) == "satilik" || $request->input($paramValue) == "kiralik") {
                    $opt = $request->input($paramValue);
                    if ($opt) {
                        $opt = $opt;
                        if ($opt == "satilik") {
                            $optName = "Satılık";
                        } else {
                            $optName = "Kiralık";
                        }
                    }
                } else {
                    $item1 = HousingStatus::where('id', $request->input($paramValue))->first();
                    $housingTypeParent = HousingTypeParent::where('slug', $request->input($paramValue))->first();
                    $housingType = HousingType::where('slug', $request->input($paramValue))->first();
                    if ($item1) {
                        $slugName = $item1->name;
                        $slug = $item1->id;
                    }

                    if ($housingTypeParent) {
                        $housingTypeSlugName = $housingTypeParent->title;
                        $housingTypeSlug = $housingTypeParent->slug;
                    }

                    if ($housingType) {
                        $housingTypeName = $housingType->title;
                        $housingType = $housingType->id;
                    }
                }
            }
        }

        $query = Project::query()->where('projects.status', 1);

        if ($request->input('city') &&  $request->input('city') != "#") {
            $query->where('city_id', $request->input('city'));
        }

        if ($request->input('county') && $request->input('county') != "#") {
            $query->where('county_id', $request->input('county'));
        }
        if ($request->input('listing_date') == 24) {
            $query = $query->where('projects.created_at', '>=', now()->subDay());
        }

        if ($request->input('listing_date')) {

            $query = $query->where('projects.created_at', '>=', now()->subDays($request->input('listing_date')));
        }

        if ($request->has('corporateType') && $request->input('corporateType') !== null) {
            $query->join('users', 'users.id', '=', 'projects.user_id')
                ->where('users.corporate_type', $request->input('corporateType'))
                ->select('projects.*', 'users.corporate_type'); // İlgili sütunları seçin
        }

        if ($request->input('filterDate')) {
            $filterDate = $request->input('filterDate');

            switch ($filterDate) {
                case 'last3Days':
                    $query->where('created_at', '>=', now()->subDays(3));
                    break;

                case 'lastWeek':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;

                case 'lastMonth':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;

                default:
                    break;
            }
        }

        if ($request->input('project_type')) {
            $slug = $request->input('project_type');
            $query->whereHas('housingTypes', function ($query) use ($slug) {
                $query->where('housing_type_id', $slug);
            });
        }

        if ($slug && $slug != "1") {
            $query->whereHas('housingTypes', function ($query) use ($slug) {
                $query->where('housing_type_id', $slug);
            });
        }

        if ($housingTypeSlug) {
            $query->where("step1_slug", $housingTypeSlug);
        }

        if ($opt) {
            $query->where("step2_slug", $opt);
        }

        if (empty($housingType) && !empty($housingTypeParentSlug)) {
            $connections = HousingTypeParent::where("slug", $housingTypeParentSlug)->with("parents.connections.housingType")->first();


            // HousingTypeParent içindeki bağlantıları al
            $parentConnections = $connections->parents->pluck('connections')->flatten();

            // Benzersiz housing_type_id değerlerini bul
            $uniqueHousingTypeIds = $parentConnections->pluck('housingType.id')->unique();
            $filtersDb = Filter::where('item_type', 2)->whereIn('housing_type_id', $uniqueHousingTypeIds)->get()->keyBy('filter_name')->toArray();
            $filtersDbx = array_keys($filtersDb);
            foreach ($filtersDb as $data) {
                if ($data['filter_type'] == "select" || $data['filter_type'] == "checkbox-group") {
                    $inputName = $data['filter_name'];
                    if ($request->input($inputName)) {
                        $query->whereHas('roomInfo', function ($query) use ($inputName, $request, $data) {
                            $query->where([
                                ['name', $data->name],
                            ])->whereIn('value', $request->input($inputName))->groupBy('project_id');
                        }, '>=', 1);
                    }
                } else if ($data['filter_type'] == 'text') {
                    if ($filtersDb[$data['filter_name']]['text_style'] == 'min-max') {
                        $inputName = str_replace('[]', '', $data['filter_name']);
                        if ($request->input($inputName . '-min')) {
                            $query->whereHas('roomInfo', function ($query) use ($inputName, $request, $data) {
                                $query->where([
                                    ['name', $data->name],
                                ])->where('value', '>=', intval($request->input($inputName . '-min')))->groupBy('project_id');
                            }, '>=', 1);
                        }

                        if ($request->input($inputName . '-max')) {
                            $query->whereHas('roomInfo', function ($query) use ($inputName, $request, $data) {
                                $query->where([
                                    ['name', $data->name],
                                ])->where('value', '<=', intval($request->input($inputName . '-max')))->groupBy('project_id');
                            }, '>=', 1);
                        }
                    } else {
                        $inputName = str_replace('[]', '', $data->name);
                        if ($request->input($inputName)) {
                            $query->whereHas('roomInfo', function ($query) use ($inputName, $request, $data) {
                                $query->where([
                                    ['name', $data->name],
                                ])->where('value', 'LIKE', '%' . $request->input($inputName) . '%')->groupBy('project_id');
                            }, '>=', 1);
                        }
                    }
                }
            }
        }

        if (!empty($housingType)) {
            $query->where('housing_type_id', $housingType);
            $housingTypeData = HousingType::where('id', $housingType)->first();
            $tempFilter = 0;

            $formData = json_decode($housingTypeData->form_json);
            if (isset($formData)) {
                foreach ($formData as $key => $data) {
                    if ($data->type == "select" || $data->type == "checkbox-group") {
                        $inputName = str_replace('[]', '', $data->name);
                        if ($request->input($inputName)) {
                            $tempFilter = $tempFilter + 1;
                        }
                    }
                }
            }

            // Yeni bir dizi oluşturarak selectedCheckboxes ve textInputs değerlerini birleştir
            $combinedFilters = array_merge($request->input('selectedCheckboxes', []), $request->input('textInputs', []));

            $filtersDb = Filter::where('item_type', 1)
                ->where('housing_type_id', $housingType)
                ->get()
                ->keyBy('filter_name')->toArray();

            $filtersDbx = array_keys($filtersDb);
            if ($formData) {
                foreach ($formData as $key => $data) {
                    if (in_array(str_replace('[]', '', $data->name), $filtersDbx)) {
                        if (isset($combinedFilters[$data->name])) {
                            if ($data->type == "select" || $data->type == "checkbox-group") {
                                $inputName = str_replace('[]', '', $data->name);
                                if ($request->input($inputName)) {
                                    $query->whereHas('roomInfo', function ($query) use ($inputName, $request, $data) {
                                        $query->where([
                                            ['name', $data->name],
                                        ])->whereIn('value', $request->input($inputName))->groupBy('project_id');
                                    }, '>=', 1);
                                }
                            } elseif ($data->type == 'text') {
                                if ($filtersDb[str_replace('[]', '', $data->name)]['text_style'] == 'min-max') {
                                    $inputName = str_replace('[]', '', $data->name);
                                    if ($request->input($inputName . '-min')) {
                                        $query->whereHas('roomInfo', function ($query) use ($inputName, $request, $data) {
                                            $query->where([
                                                ['name', $data->name],
                                            ])->where('value', '>=', intval($request->input($inputName . '-min')))->groupBy('project_id');
                                        }, '>=', 1);
                                    }

                                    if ($request->input($inputName . '-max')) {
                                        $query->whereHas('roomInfo', function ($query) use ($inputName, $request, $data) {
                                            $query->where([
                                                ['name', $data->name],
                                            ])->where('value', '<=', intval($request->input($inputName . '-max')))->groupBy('project_id');
                                        }, '>=', 1);
                                    }
                                } else {
                                    $inputName = str_replace('[]', '', $data->name);
                                    if ($request->input($inputName)) {
                                        $query->whereHas('roomInfo', function ($query) use ($inputName, $request, $data) {
                                            $query->where([
                                                ['name', $data->name],
                                            ])->where('value', 'LIKE', '%' . $request->input($inputName) . '%')->groupBy('project_id');
                                        }, '>=', 1);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }


        if ($request->input('neighborhood') && $request->input('neighborhood') != "#") {
            $query->where('neighbourhood_id', $request->input('neighborhood'));
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

        if ($request->input('term')) {
            $term = $request->input('term');
            $query->where(function ($queryf) use ($term) {
                $queryf->where('project_title', 'LIKE', "%{$term}%")
                    ->orWhere('step1_slug', 'LIKE', "%{$term}%")
                    ->orWhere('step2_slug', 'LIKE', "%{$term}%")
                    ->orWhere('description', 'LIKE', "%{$term}%")
                    ->orWhere('id', '=', (int)$term - 1000000)
                    ->orWhereHas('city', function ($queryf) use ($term) {
                        $queryf->where('title', 'LIKE', "%{$term}%");
                    })
                    ->orWhereHas('county', function ($queryf) use ($term) {
                        $queryf->where('ilce_title', 'LIKE', "%{$term}%");
                    });
            })->where("projects.status", 1);
        }
        $itemPerPage = 12;
        $projects = $query->paginate($itemPerPage);
        $term = $request->input('term') ?? null;

        $renderedProjects = $projects->through(function ($item) {

            $statusID = $item->housingStatus->where('housing_type_id', '<>', 1)->first()->housing_type_id ?? 1;
            $status = HousingStatus::find($statusID);

            return [
                'image' => url(str_replace('public/', 'storage/', $item->image)),
                'url' => route('project.detail', ['slug' => $item->slug . "-" . $status->slug . "-" . $item->step2_slug . "-" . $item->housingtype->slug, "id" => $item->id + 1000000]),
                'city' => $item->city,
                'county' => $item->county,
                'neighborhood' => $item->neighborhood,
                'profile_user_image' => URL::to('/') . '/storage/profile_images/' . $item->user->profile_image,
                "title" => $item->project_title,
                'created_at' => $item->created_at,
            ];
        });



        return response()->json([
            'data' => $renderedProjects,
            'totalCount' => $projects->total(),
            'term' => $term, // Toplam öğe sayısını JSON yanıta ekle
        ]);
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
            if (isset($housing_type_data->$key)) {
                $a = $housing_type_data->$key;
                return $a[0];
            } else {
                return false;
            }
        }

        function getImage($housing, $key)
        {
            $housing_type_data = json_decode($housing->housing_type_data);
            $a = $housing_type_data->$key;
            return $a;
        }



        $term = $request->input('term');

        $parameters = ["slug", "type", "optional", "title", "checkTitle"];
        $secondhandHousings = [];
        $projects = [];
        $slug = [];
        $slugName = [];

        $housingTypeSlug = [];
        $housingTypeSlugName = [];

        $housingType = [];
        $housingTypeName = [];
        $housingTypeParentSlug = [];
        $opt = null;
        $is_project = null;
        $checkTitle = null;
        $newId = null;

        $optName = [];

        $housingTypet = null;
        $housingType = null;



        foreach ($parameters as $index => $paramValue) {
            $housingTypet = null;
            if ($paramValue) {
                if ($request->input($paramValue) == "satilik" || $request->input($paramValue) == "kiralik" || $request->input($paramValue) == "gunluk-kiralik" || $request->input($paramValue) == "devren-satilik" || $request->input($paramValue) == "devren-kiralik") {
                    $opt = $request->input($paramValue);
                    if ($opt) {
                        $opt = $opt;
                        if ($opt == "kiralik") {
                            $optName = "Kiralık";
                        } elseif ($opt == "satilik") {
                            $optName = "Satılık";
                        }elseif ($opt == "gunluk-kiralik") {
                            $optName = "devren Kiralık";
                        }elseif ($opt == "gunluk-kiralik") {
                            $optName = "Devren Kiralık";
                        } else {
                            $optName = "Devren Satılık";
                        }
                    }
                } else {
                    $item1 = HousingStatus::where('id', $request->input($paramValue))->first();
                    $housingTypeParent = HousingTypeParent::where('slug', $request->input($paramValue))->first();


                    if ($item1) {
                        $is_project = $item1->is_project;
                        $slugName = $item1->name;
                        $slug = $item1->id;
                    }

                    if ($housingTypeParent) {
                        $housingTypeSlugName = $housingTypeParent->title;
                        $housingTypeParentSlug = $housingTypeParent->slug;
                    }
                    $housingTypex = HousingType::where('slug', $request->input($paramValue))->first();
                    if ($housingTypex) {
                        $housingTypet = HousingType::where('slug', $request->input($paramValue))->first();
                    }
                    if ($housingTypet != null) {
                        if (isset($housingTypet->title) && $housingTypet->title) {
                            $housingTypeName = $housingTypet->title;
                            $housingTypeSlug = $housingTypet->slug;
                            $housingType = $housingTypet->id;
                        }
                    }
                }
            }


            $lastParameter = $parameters[count($parameters) - 1];

            if ($request->has($lastParameter)) {
                $inputValue = $request->input($lastParameter);

                if ($housingTypeParent && $housingTypeParent->slug === "arsa") {
                    $checkTitle = $inputValue;
                }
            }
        }

        $obj =  Housing::with('images', "city", "county")
            ->select(
                'housings.*',
                'housing_types.title as housing_type_title',
                'project_list_items.column1_name as column1_name',
                'project_list_items.column2_name as column2_name',
                'project_list_items.column3_name as column3_name',
                'project_list_items.column4_name as column4_name',
                'project_list_items.column1_additional as column1_additional',
                'project_list_items.column2_additional as column2_additional',
                'project_list_items.column3_additional as column3_additional',
                'project_list_items.column4_additional as column4_additional',
                \Illuminate\Support\Facades\DB::raw('(SELECT cart FROM cart_orders WHERE JSON_EXTRACT(housing_type_data, "$.type") = "housing" AND JSON_EXTRACT(housing_type_data, "$.item.id") = housings.id) AS sold'),
            )
            ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
            ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
            ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
            ->where('housings.status', 1)
            ->where('project_list_items.item_type', 2)
            ->with(['city', 'county']);

        if ($request->input("slug") == "al-sat-acil") {
            $obj = $obj->whereJsonContains('housing_type_data->buysellurgent1', "Evet");
        }



        if ($request->input("slug") == "paylasimli-ilanlar") {
            $obj = $obj->whereNotNull('housings.owner_id');
            // $obj = $obj->whereJsonContains('housing_type_data->open_sharing1', "Evet");
        }

        if ($housingTypeParentSlug) {
            $obj->where("step1_slug", $housingTypeParentSlug);
        }

        if ($housingType) {
            $obj->where('housings.housing_type_id', $housingType);
        }


        if ($checkTitle) {
            $obj->where(function ($q) use ($checkTitle) {
                $q->orWhereJsonContains('housing_type_data->room_count', $checkTitle)
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, '$.room_count[0]')) = ?", [$checkTitle]);
            });
        }


        if ($opt) {
            $obj->where('step2_slug', $opt);
        }

        if ($slug) {
            $obj->whereHas('housingStatus', function ($query) use ($slug) {
                $query->where('housing_status_id', $slug);
            });
        }

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
                        ->where('subscription_plans.plan_type', 'Emlak Ofisi');
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
                        ->where('subscription_plans.plan_type', 'İnşaat Ofisi');
                    break;
            }
        }

        if ($request->input('city') && $request->input('city') != "#") {
            $obj = $obj->where('housings.city_id', $request->input('city'));
        }

        if ($request->input('county') && $request->input('county') != "#") {
            $obj = $obj->where('housings.county_id', $request->input('county'));
        }

        if ($request->input('neighborhood') && $request->input('neighborhood') != "#") {
            $obj = $obj->where('housings.neighborhood_id', $request->input('neighborhood'));
        }

        if ($request->input('term')) {
            $term = $request->input('term');

            $obj = $obj->where(function ($query) use ($term) {
                $query->where('housings.title', 'LIKE', "%{$term}%")
                    ->orWhere('housings.description', 'LIKE', "%{$term}%")
                    ->orWhereRaw('JSON_EXTRACT(housings.housing_type_data, "$.room_count[0]") = ?', $term)
                    ->orWhereHas('city', function ($cityQuery) use ($term) {
                        $cityQuery->where('title', 'LIKE', "%{$term}%");
                    })
                    ->orWhereHas('county', function ($countyQuery) use ($term) {
                        $countyQuery->where('title', 'LIKE', "%{$term}%");
                    })
                    ->orWhere('housings.id', '=', (int)$term - 2000000);
            });
        }

        if ($request->input('listing_date') == 24) {
            $obj = $obj->where('housings.created_at', '>=', now()->subDay());
        }

        if ($request->input('listing_date')) {

            $obj = $obj->where('housings.created_at', '>=', now()->subDays($request->input('listing_date')));
        }


        if ($request->has('corporateType') && $request->input('corporateType') !== null && $request->input('corporateType') !== "all") {

            if ($request->input('corporateType') != "Sahibinden") {
                $obj = $obj->join('users', 'users.id', '=', 'housings.user_id')
                    ->where('users.corporate_type', $request->input('corporateType'));
            } else {
                $obj = $obj->join('users', 'users.id', '=', 'housings.user_id')
                    ->where('users.type', 1);
            }
        }


        if (empty($housingType) && !empty($housingTypeParentSlug)) {

            $connections = HousingTypeParent::where("slug", $housingTypeParentSlug)->with("parents.connections.housingType")->first();


            // HousingTypeParent içindeki bağlantıları al
            $parentConnections = $connections->parents->pluck('connections')->flatten();

            // Benzersiz housing_type_id değerlerini bul
            $uniqueHousingTypeIds = $parentConnections->pluck('housingType.id')->unique();
            $filtersDb = Filter::where('item_type', 2)->whereIn('housing_type_id', $uniqueHousingTypeIds)->get()->keyBy('filter_name')->toArray();
            $filtersDbx = array_keys($filtersDb);
            foreach ($filtersDb as $data) {
                if ($data['filter_type'] && $data['filter_type'] == "select" || $data['filter_type'] == "checkbox-group") {
                    $inputName = $data['filter_name'];
                    if ($request->input($inputName) && is_array($request->input($inputName))) {
                        $obj = $obj->where(function ($query) use ($obj, $request, $inputName) {
                            $query->whereJsonContains('housing_type_data->' . $inputName, [$request->input($inputName)[0]]);
                            $e = 0;
                            foreach ($request->input($inputName) as $input) {
                                if ($e == 0) {
                                    $e = 1;
                                    continue;
                                }
                                $query->orWhereJsonContains('housing_type_data->' . $inputName, [$input]);
                            }
                        });
                    }
                } else if ($data['filter_type'] && $data['filter_type'] == 'text') {
                    if ($filtersDb[$data['filter_name']]['text_style'] == 'min-max') {
                        $inputName = str_replace('[]', '', $data['filter_name']);
                        if ($request->input($inputName . '-min')) {
                            $obj = $obj->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.' . $inputName . '[0]")) AS FLOAT) >= ?', [$request->input($inputName . '-min')]);
                        }

                        if ($request->input($inputName . '-max')) {
                            $obj = $obj->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.' . $inputName . '[0]")) AS FLOAT) <= ?', [$request->input($inputName . '-max')]);
                        }
                    } else {
                        $inputName = $data['filter_name'];
                        if ($request->input($inputName)) {
                            $obj = $obj->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.' . $inputName . '[0]"))) = ?', $request->input($inputName));
                        }
                    }
                }
            }
        }

        if (!empty($housingType)) {

            $housingTypeData = HousingType::where('id', $housingType)->first();

            if ($housingTypeData) {
                $formData = json_decode($housingTypeData->form_json);
                $filtersDb = Filter::where('item_type', 2)->where('housing_type_id', $housingType)->get()->keyBy('filter_name')->toArray();
                $filtersDbx = array_keys($filtersDb);
                foreach ($formData as $key => $data) {
                    if (in_array(str_replace('[]', '', $data->name), $filtersDbx)) {
                        if ($data->type == "select" || $data->type == "checkbox-group") {
                            $inputName = str_replace('[]', '', $data->name);
                            if ($request->input($inputName)) {
                                $obj = $obj->where(function ($query) use ($obj, $request, $inputName) {
                                    $query->whereJsonContains('housing_type_data->' . $inputName, [$request->input($inputName)[0]]);
                                    $e = 0;
                                    foreach ($request->input($inputName) as $input) {
                                        if ($e == 0) {
                                            $e = 1;
                                            continue;
                                        }
                                        $query->orWhereJsonContains('housing_type_data->' . $inputName, [$input]);
                                    }
                                });
                            }
                        } else if ($data->type == 'text') {
                            if ($filtersDb[str_replace('[]', '', $data->name)]['text_style'] == 'min-max') {
                                $inputName = str_replace('[]', '', $data->name);
                                if ($request->input($inputName . '-min')) {
                                    $obj = $obj->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.' . $inputName . '[0]")) AS FLOAT) >= ?', [$request->input($inputName . '-min')]);
                                }

                                if ($request->input($inputName . '-max')) {
                                    $obj = $obj->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.' . $inputName . '[0]")) AS FLOAT) <= ?', [$request->input($inputName . '-max')]);
                                }
                            } else {
                                $inputName = str_replace('[]', '', $data->name);
                                if ($request->input($inputName)) {
                                    $obj = $obj->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.' . $inputName . '[0]"))) = ?', $request->input($inputName));
                                }
                            }
                        }
                    }
                }
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

        if ($request->has('sort')) {
            switch ($request->input('sort')) {
                case 'date-asc':
                    $obj = $obj->orderBy('created_at', 'asc');
                    break;
                case 'date-desc':
                    $obj = $obj->orderBy('created_at', 'desc');
                    break;
                case 'price-asc':
                    $obj = $obj->orderByRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housings.housing_type_data, "$.price[0]")) AS FLOAT) ASC');
                    break;
                case 'price-desc':
                    $obj = $obj->orderByRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housings.housing_type_data, "$.price[0]")) AS FLOAT) DESC');
                    break;
            }
        } else {
            $obj = $obj->orderBy('created_at', 'desc');
        }


        $itemPerPage = 15;

        $objPaginated = $obj->paginate($itemPerPage);


        $transformedData = $objPaginated->through(function ($item) use ($request) {
            $discount_amount = Offer::where('type', 'housing')->where('housing_id', $item->id)->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d Hi:i:s'))->first()->discount_amount ?? 0;
            $isFavorite = 0;
            if (Auth::check()) {
                $isFavorite = HousingFavorite::where("housing_id", $item->id)->where("user_id", Auth::user()->id)->first();
            }

            $cartStatus = CartOrder::whereRaw("JSON_UNQUOTE(json_extract(cart, '$.type')) = 'housing'")
                ->whereRaw("JSON_UNQUOTE(json_extract(cart, '$.item.id')) = ?", [$item->id])
                ->value('status');

            $action = $cartStatus != null ? (($cartStatus == 0) ? 'payment_await' : (($cartStatus == 1) ? 'sold' : (($cartStatus == 2) ? 'tryBuy' : ''))) : "noCart";
            $housingTypeData = json_decode($item->housing_type_data, true);
            $offSale = isset($housingTypeData['off_sale1']);
            $share = isset($housingTypeData['share-open1']);
            $open_share1 = isset($housingTypeData['open_sharing1']);
            $buysellurgent1 = isset($housingTypeData['buysellurgent1']);



            return [
                'image' => asset('housing_images/' . getImage($item, 'image')),
                'housing_type_title' => $item->housing_type_title,
                'id' => $item->id,
                'in_cart' => $request->session()->get('cart') && $request->session()->get('cart')['type'] == 'housing' && $request->session()->get('cart')['item']['id'] == $item->id,
                'is_favorite' => $isFavorite ? 1 : 0,
                'housing_url' => route('housing.show', [$item->step1_slug . "-" . $item->step2_slug . "-" . $item->slug, 'housingID' => $item->id + 2000000]),
                'slug' => $item->slug,
                'title' => $item->title,
                'step1_slug' => $item->step1_slug,
                'housing_address' => $item->address,
                'doping_time' => $item->doping_time,
                'step2_slug' => $item->step2_slug,
                'city' => $item->city->title,
                'county' => $item->county->title,
                'neighborhood' => $item->neighborhood->mahalle_title,
                'created_at' => $item->created_at,
                "action" => $action,
                'checkIfUserCanAddHousings' => $this->checkIfUserCanAddToCart($item->id),
                'route' => $this->checkIfUserCanAddToCart($item->id) ? false : route('institutional.housing.edit', ['id' => $item->id]),
                'offSale' => $offSale,
                'share' => $share,
                'sold' => $item->sold,
                "buysellurgent1" => $buysellurgent1,
                "column1_additional" => $item->column1_additional ?? null,
                "column2_additional" => $item->column2_additional ?? null,
                "column3_additional" => $item->column3_additional ?? null,
                "column1" => json_decode($item->housing_type_data)->{$item->column1_name}[0] ?? null,
                "column2" => json_decode($item->housing_type_data)->{$item->column2_name}[0] ?? null,
                "column3" => json_decode($item->housing_type_data)->{$item->column3_name}[0] ?? null,
                'housing_type' =>
                [
                    "housingTypeData" => $housingTypeData,
                    'has_discount' => $discount_amount > 0,
                    'open_share1' => $open_share1 ? true : false,
                    // 'room_count' => getData($item, 'room_count') ? getData($item, 'room_count') : null,
                    'daily_rent' => ($item->step2_slug == "gunluk-kiralik" && getData($item, 'daily_rent')) ? getData($item, 'daily_rent') : null,
                    // 'squaremeters' => getData($item, 'squaremeters') ? getData($item, 'squaremeters') : null,
                    'price' => $item->step2_slug != "gunluk-kiralik" ? getData($item, 'price') - $discount_amount : null,
                    'share_open' => $share ? true : 0,
                    'housing_date' => date('j', strtotime($item->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($item->created_at))),
                ]

            ];
        });

        $result = [
            'totalCount' => $objPaginated->total(), // Toplam öğe sayısını alın
            'data' => $transformedData,
            'term' => $term,
        ];



        // JSON yanıtını döndürün
        return response()->json($result);
    }

    private function checkIfUserCanAddToCart($housingId)
    {
        $user = auth()->user();

        // Check if the user is logged in
        if ($user) {
            // Check if there exists a housing record with the given $housingId and user_id matching the logged-in user
            $exists = $user->housings()->where('id', $housingId)->exists();
            return !$exists; // Return true if the user can add to cart (housing not found), false otherwise
        }

        return true; // Return false if user is not logged in
    }

    public function getSearchList(Request $request)
    {
        $request->validate(
            [
                'searchTerm' => 'required|string',
            ]
        );

        $term = $request->input('searchTerm');
        $housingOrder = null;
        $projectIdNumber = null;
        $project = null;
        $projects = null;


        if (strpos($term, '-') !== false) {
            $parts = explode('-', $term);

            $projectId = (int)$parts[0];
            $housingOrder = (int)$parts[1];


            $projectIdNumber = $projectId - 1000000;
            $project = Project::where("id", $projectIdNumber)->first();
        } else {
            $projects =  Project::where('status', 1)
                ->where(function ($query) use ($term) {
                    $query->where('project_title', 'LIKE', "%{$term}%")
                        ->orWhere('step1_slug', 'LIKE', "%{$term}%")
                        ->orWhere('step2_slug', 'LIKE', "%{$term}%")
                        ->orWhere('description', 'LIKE', "%{$term}%")
                        ->orWhere('id', '=', (int)$term - 1000000)
                        ->orWhereHas('city', function ($query) use ($term) {
                            $query->where('title', 'LIKE', "%{$term}%");
                        })
                        ->orWhereHas('county', function ($query) use ($term) {
                            $query->where('ilce_title', 'LIKE', "%{$term}%");
                        });
                })->where('projects.status', 1)

                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'photo' => $item->image,
                        'name' => $item->project_title,
                        'slug' => $item->slug,
                    ];
                });
        }

        return response()->json(
            [
                'housingOrder' => $housingOrder,
                'projectIdNumber' => $projectIdNumber,
                "project" => $project,
                'housings' => Housing::with(['city', 'county'])
                    ->where('status', 1)
                    ->where(function ($query) use ($term) {
                        $query->where('title', 'LIKE', "%{$term}%");
                        $query->where('description', 'LIKE', "%{$term}%");
                        $query->orWhereRaw('JSON_EXTRACT(housing_type_data, "$.room_count[0]") = ?', $term);
                        $query->orWhereHas('city', function ($cityQuery) use ($term) {
                            $cityQuery->where('title', 'LIKE', "%{$term}%");
                        });
                        $query->orWhereHas('county', function ($countyQuery) use ($term) {
                            $countyQuery->where('title', 'LIKE', "%{$term}%");
                        });
                        $query->orWhere('id', '=', (int)$term - 2000000);
                    })
                    ->orderByDesc('housings.created_at')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'photo' => json_decode($item->housing_type_data)->image,
                            'name' => $item->title,
                            'slug' => $item->slug,
                        ];
                    }),



                'projects' => $projects,

                'merchants' => User::where('type', '2')->where("corporate_account_status", "1")->where('name', 'LIKE', "%{$term}%")->get()->map(function ($item) {
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

    public function searchResults(Request $request)
    {
        $request->validate([
            'searchTerm' => 'required|string',
            'type' => 'required|string',
        ]);

        $term = $request->input('searchTerm');
        $results = [];

        // "title" parametresine göre sorguyu belirle
        $title = $request->input('type');
        if ($title === 'housing') {
            // Housing sorgusu
            $results['housings'] =  Housing::with('images')
                ->select(
                    'housings.id',
                    'housings.title AS housing_title',
                    'housings.created_at',
                    'housings.step1_slug',
                    'housings.step2_slug',
                    'housings.slug',
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
                    \Illuminate\Support\Facades\DB::raw('(SELECT cart FROM cart_orders WHERE JSON_EXTRACT(housing_type_data, "$.type") = "housing" AND JSON_EXTRACT(housing_type_data, "$.item.id") = housings.id) AS sold'),
                    'cities.title AS city_title', // city tablosundan veri çekme
                    'districts.ilce_title AS county_title' // district tablosundan veri çekme
                )
                ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
                ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
                ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
                ->where('housings.status', 1)
                ->leftJoin('cities', 'cities.id', '=', 'housings.city_id')
                ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id')
                ->where('project_list_items.item_type', 2)
                ->where(function ($query) use ($term) {
                    $query->where('housings.title', 'LIKE', "%{$term}%");
                    $query->orWhere('housings.description', 'LIKE', "%{$term}%");
                    $query->orWhereRaw('JSON_EXTRACT(housings.housing_type_data, "$.room_count[0]") = ?', $term);
                    $query->orWhereHas('city', function ($cityQuery) use ($term) {
                        $cityQuery->where('title', 'LIKE', "%{$term}%");
                    });
                    $query->orWhereHas('county', function ($countyQuery) use ($term) {
                        $countyQuery->where('title', 'LIKE', "%{$term}%");
                    });
                    $query->orWhere('housings.id', '=', (int)$term - 2000000);
                })
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('cart_orders')
                        ->whereRaw('JSON_EXTRACT(cart, "$.type") = "housing"')
                        ->whereRaw('JSON_EXTRACT(cart, "$.item.id") = housings.id')
                        ->where('status', "!=", 1);
                })
                ->orderByDesc('housings.created_at')
                ->paginate(12);
        } elseif ($title === 'project') {
            // Project sorgusu
            $results['projects'] = Project::with("user")
                ->where('status', 1)
                ->where(function ($query) use ($term) {
                    $query->where('project_title', 'LIKE', "%{$term}%")
                        ->orWhere('step1_slug', 'LIKE', "%{$term}%")
                        ->orWhere('step2_slug', 'LIKE', "%{$term}%")
                        ->orWhere('description', 'LIKE', "%{$term}%")
                        ->orWhere('id', '=', (int)$term - 1000000);
                })
                ->orWhereHas('city', function ($query) use ($term) {
                    $query->where('title', 'LIKE', "%{$term}%");
                })
                ->orWhereHas('county', function ($query) use ($term) {
                    $query->where('ilce_title', 'LIKE', "%{$term}%");
                })
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'photo' => $item->image,
                        'name' => $item->project_title,
                        'slug' => $item->slug,
                        'city' => $item->city->title,
                        'county' => $item->county->ilce_title,
                        "profile_image" => $item->user->profile_image

                    ];
                });
        } elseif ($title === 'merchant') {
            // Merchants sorgusu
            $results['merchants'] = User::where('type', '2')->where("corporate_account_status", "1")->where('name', 'LIKE', "%{$term}%")
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'photo' => $item->profile_image,
                        'name' => $item->name,
                        'slug' => Str::slug($item->name),
                    ];
                });
        } else {
            // Geçersiz bir "title" değeri varsa burası çalışır
            // Hata mesajı oluşturulabilir veya ana sayfaya yönlendirme yapılabilir
        }

        // $results = [
        //     'project_housings' => [],
        //     'housings' =>
        //     Housing::with('images')
        //         ->select(
        //             'housings.id',
        //             'housings.title AS housing_title',
        //             'housings.created_at',
        //             'housings.step1_slug',
        //             'housings.step2_slug',
        //             'housings.slug',
        //             'housing_types.title as housing_type_title',
        //             'housings.housing_type_data',
        //             'project_list_items.column1_name as column1_name',
        //             'project_list_items.column2_name as column2_name',
        //             'project_list_items.column3_name as column3_name',
        //             'project_list_items.column4_name as column4_name',
        //             'project_list_items.column1_additional as column1_additional',
        //             'project_list_items.column2_additional as column2_additional',
        //             'project_list_items.column3_additional as column3_additional',
        //             'project_list_items.column4_additional as column4_additional',
        //             'housings.address',
        //             \Illuminate\Support\Facades\DB::raw('(SELECT cart FROM cart_orders WHERE JSON_EXTRACT(housing_type_data, "$.type") = "housing" AND JSON_EXTRACT(housing_type_data, "$.item.id") = housings.id) AS sold'),
        //             'cities.title AS city_title', // city tablosundan veri çekme
        //             'districts.ilce_title AS county_title' // district tablosundan veri çekme
        //         )
        //         ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
        //         ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
        //         ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
        //         ->where('housings.status', 1)
        //         ->leftJoin('cities', 'cities.id', '=', 'housings.city_id')
        //         ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id')
        //         ->where('project_list_items.item_type', 2)
        //         ->where(function ($query) use ($term) {
        //             $query->where('housings.title', 'LIKE', "%{$term}%");
        //             $query->orWhere('housings.description', 'LIKE', "%{$term}%");
        //             $query->orWhereRaw('JSON_EXTRACT(housings.housing_type_data, "$.room_count[0]") = ?', $term);
        //             $query->orWhereHas('city', function ($cityQuery) use ($term) {
        //                 $cityQuery->where('title', 'LIKE', "%{$term}%");
        //             });
        //             $query->orWhereHas('county', function ($countyQuery) use ($term) {
        //                 $countyQuery->where('title', 'LIKE', "%{$term}%");
        //             });
        //             $query->orWhere('housings.id', '=', (int)$term - 2000000);
        //         })
        //         ->whereNotExists(function ($query) {
        //             $query->select(DB::raw(1))
        //                 ->from('cart_orders')
        //                 ->whereRaw('JSON_EXTRACT(cart, "$.type") = "housing"')
        //                 ->whereRaw('JSON_EXTRACT(cart, "$.item.id") = housings.id')
        //                 ->where('status', "!=", 1);
        //         })
        //         ->orderByDesc('housings.created_at')
        //         ->paginate(12),

        //     'projects' => Project::where('status', 1)
        //         ->where(function ($query) use ($term) {
        //             $query->where('project_title', 'LIKE', "%{$term}%")
        //                 ->orWhere('step1_slug', 'LIKE', "%{$term}%")
        //                 ->orWhere('step2_slug', 'LIKE', "%{$term}%")
        //                 ->orWhere('description', 'LIKE', "%{$term}%")
        //                 ->orWhere('id', '=', (int)$term - 1000000);
        //         })
        //         ->orWhereHas('city', function ($query) use ($term) {
        //             $query->where('title', 'LIKE', "%{$term}%");
        //         })
        //         ->orWhereHas('county', function ($query) use ($term) {
        //             $query->where('ilce_title', 'LIKE', "%{$term}%");
        //         })
        //         ->get()
        //         ->map(function ($item) {
        //             return [
        //                 'id' => $item->id,
        //                 'photo' => $item->image,
        //                 'name' => $item->project_title,
        //                 'slug' => $item->slug,
        //             ];
        //         }),

        //     'merchants' => User::where('type', '2')->where("corporate_account_status", "1")->where('name', 'LIKE', "%{$term}%")
        //         ->get()
        //         ->map(function ($item) {
        //             return [
        //                 'id' => $item->id,
        //                 'photo' => $item->profile_image,
        //                 'name' => $item->name,
        //                 'slug' => Str::slug($item->name),
        //             ];
        //         }),
        // ];


        return view("client.search.result", compact('results', 'term'));
    }


    public function search(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'searchTerm' => 'required|string',
            ]
        );


        $term = $request->input('searchTerm');

        if (is_numeric($term)) {
            $housing = Housing::find((int)$term - 2000000); // Konut ID'sini bul
            if ($housing) {
                return redirect()->route('housing.show', [
                    'housingSlug' => $housing->slug,
                    'housingID' => $housing->id,
                ]);
            }
        }

        if (strpos($term, '-') !== false) {
            // Terimi tire işaretinden (-) ayırın
            $parts = explode('-', $term);

            if (count($parts) == 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
                $projectId = (int)$parts[0];
                $housingOrder = (int)$parts[1];

                // Proje bulunuyor mu kontrol edin
                $project = Project::find($projectId - 1000000);

                if ($project && $project->slug) {
                    // İlgili yönlendirmeyi yapın
                    return redirect()->route('project.housings.detail', [
                        'projectSlug' => $project->slug,
                        'projectID' => $projectId,
                        'housingOrder' => $housingOrder  // Konut sırasını da iletebilirsiniz
                    ]);
                }
            }
        } else {
            // "-" işareti bulunmuyorsa, sadece tek bir proje ID'si olduğunu varsayabilirsiniz
            $projectId = (int)$term;

            // Proje bulunuyor mu kontrol edin
            $project = Project::find($projectId - 1000000);

            if ($project && $project->slug) {
                // İlgili yönlendirmeyi yapın
                return redirect()->route('project.detail', [
                    'slug' => $project->slug,
                    'id' => $projectId
                ]);
            }
        }


        $housings = Housing::select(
            'housings.step1_slug',
            'housings.step2_slug',
            DB::raw('COUNT(DISTINCT housings.id) as total_count'),
            DB::raw('COUNT(*) as count')
        )

            ->with(['city', 'county'])
            ->where('housings.status', 1)
            ->where(function ($query) use ($term) {
                $query->where('housings.title', 'LIKE', "%{$term}%")
                    ->orWhere('housings.description', 'LIKE', "%{$term}%")
                    ->orWhereRaw('JSON_EXTRACT(housings.housing_type_data, "$.room_count[0]") = ?', $term)
                    ->orWhereHas('city', function ($cityQuery) use ($term) {
                        $cityQuery->where('title', 'LIKE', "%{$term}%");
                    })
                    ->orWhereHas('county', function ($countyQuery) use ($term) {
                        $countyQuery->where('title', 'LIKE', "%{$term}%");
                    })
                    ->orWhere('housings.id', '=', (int)$term - 2000000);
            })
            ->where('status', 1)
            ->orderByDesc('housings.created_at')
            ->groupBy('housings.step1_slug', 'housings.step2_slug')
            ->get();

        // Tüm sayıların toplamını hesapla
        $housingTotalCount = $housings->sum('count');

        $housings = $housings->groupBy('step1_slug')->map(function ($group) {
            return $group->mapToGroups(function ($item) {
                // Retrieve HousingTypeParent objects for step1_slug and step2_slug
                $parent = HousingTypeParent::where('slug', $item->step1_slug)->first();
                $parent2 = HousingTypeParent::where('slug', $item->step2_slug)->first();

                return [
                    $item->step2_slug => [
                        'count' => $item->count,
                        'step1_title' => $parent ? $parent->title : null, // Check if $parent exists before accessing title
                        'step2_title' => $parent2 ? $parent2->title : null, // Check if $parent2 exists before accessing title
                    ]
                ];
            });
        });







        // projects'i status ve step1_slug'a göre gruplayalım
        // Projeleri sorgula
        $projectsQuery = Project::where('status', 1)
            ->where(function ($query) use ($term) {
                $query->where('project_title', 'LIKE', "%{$term}%")
                    ->orWhere('step1_slug', 'LIKE', "%{$term}%")
                    ->orWhere('step2_slug', 'LIKE', "%{$term}%")
                    ->orWhere('description', 'LIKE', "%{$term}%")
                    ->orWhere('id', '=', (int)$term - 1000000)
                    ->orWhereHas('city', function ($query) use ($term) {
                        $query->where('title', 'LIKE', "%{$term}%");
                    })
                    ->orWhereHas('county', function ($query) use ($term) {
                        $query->where('ilce_title', 'LIKE', "%{$term}%");
                    });
            })->where('projects.status', 1);

        // Toplam proje sayısını al
        $projectTotalCount = $projectsQuery->count();

        // Projeleri grupla ve işle
        $projects = $projectsQuery->get()->groupBy(function ($item) {
            $statusID = $item->housingStatus->where('housing_type_id', '<>', 1)->first()->housing_type_id ?? 1;
            $status = HousingStatus::find($statusID);
            return $status->name;
        })->map(function ($group, $statusName) {
            $count = count($group);
            $status = HousingStatus::where('name', $statusName)->first(); // Status ismine göre status slug bulunuyor
            $slug = $status ? $status->slug : null; // Status varsa slug değeri alınıyor, yoksa null
            return [
                'name' => $status->name,
                'count' => $count,
                'status_slug' => $slug,
            ];
        });


        $merchants = User::where('type', '2')
            ->where("corporate_account_status", "1")
            ->where('name', 'LIKE', "%{$term}%")
            ->get();

        $merchant_count = $merchants->count();





        return view("client.search.index", compact('term', 'housings', 'housingTotalCount', 'projects', 'projectTotalCount', 'merchants', 'merchant_count'));
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
}
