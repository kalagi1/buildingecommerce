<?php

namespace App\Http\Controllers;

use App\Models\Housing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class MarkerController extends Controller
{
    public function index()
    {   function convertMonthToTurkishCharacter($date)
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
                if ($request->input($paramValue) == "satilik" || $request->input($paramValue) == "kiralik" || $request->input($paramValue) == "gunluk-kiralik") {
                    $opt = $request->input($paramValue);
                    if ($opt) {
                        $opt = $opt;
                        if ($opt == "kiralik") {
                            $optName = "Kiralık";
                        } elseif ($opt == "satilik") {
                            $optName = "Satılık";
                        } else {
                            $optName = "Günlük Kiralık";
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

        $obj =  Housing::with('images', "city", "county","district","neighborhood")
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
            ->whereNull('housings.is_sold')
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


        $objPaginated = $obj->get();

        $markers = $objPaginated->through(function ($housing) use ($request) {
            $housingTypeData = json_decode($housing->housing_type_data);
    
            // Fiyatları belirle
            $price = getData($item, 'price') ?  getData($item, 'price') : 0;
            $dailyRent = getData($item, 'daily_rent') ? getData($item, 'daily_rent') : 0;
    
            $finalPrice = $housing->step2_slug == 'gunluk-kiralik' ? $dailyRent : $price;
    
            if ($housing->discount_amount) {
                $finalPrice -= $housing->discount_amount;
            }
    


        // Açıklamayı oluştur
        $desc = '';
        if ($housing->city) {
            $desc .= $housing->city->title;
        }
        if ($housing->district) {
            $desc .= ($desc ? '/ ' : '') . $housing->district->ilce_title;
        }
        if ($housing->neighborhood) {
            $desc .= ($desc ? '/ ' : '') . $housing->neighborhood->mahalle_title;
        }  


            return [
                'id' => 'marker-' . $housing->id,
                'center' => [$housing->latitude, $housing->longitude], // Bu alanın var olduğunu varsayıyorum
                'icon' => "<i class='fa fa-home'></i>",
                'title' => $housing->title, // veya uygun bir başlık
                'desc' => $desc,
                'price' => number_format($finalPrice, 0, ',', '.'),
                'image' => URL::to('/') . '/housing_images/' .  getImage($housing, 'image') ,
                'link' =>  route('housing.show', ['housingSlug' => $housing->step1_slug . '-' . $housing->step2_slug . '-' . $housing->slug, 'housingID' => $housing->id + 2000000]) 
            ];
        });
    
        return response()->json(['data' => $markers]);
    }
    
}
