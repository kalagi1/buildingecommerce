<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\CartOrder;
use App\Models\Housing;
use App\Models\HousingStatus;
use App\Models\HousingTypeParent;
use App\Models\Invoice;
use App\Models\Offer;
use App\Models\Project;
use App\Models\ProjectComment;
use App\Models\ProjectFavorite;
use App\Models\ProjectHouseSetting;
use App\Models\ProjectHousing;
use App\Models\ProjectImage;
use App\Models\ProjectOffers;
use App\Models\ProjectSituation;
use App\Models\TempOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function give_offer(Request $request)
    {

        $data = [
            'user_id'           => Auth::check() ? auth()->id() : 4,
            'store_id'          => $request->projectUserId,
            'project_id'        => $request->projectId,
            'room_id'           => $request->roomId,
            'email'             => $request->email,
            'name'             => $request->name,
            'phone'             => $request->phone,
            'city_id'             => $request->city_id,
            'county_id'             => $request->county_id,
            'title'             => $request->title,
            'offer_description' => $request->offer_description,
            'approval_status'   => 0,
            'response_status'   => 0,
            'sales_status'      => 0,
            'offer_response'    => 0,
            'created_at'        => now()
        ];

        ProjectOffers::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Başvurunuz başarıyla alındı !'
        ]);
    }

    public function giveOfferByUser()
    {
        $userId = auth()->guard('api')->user()->id;
        $offers = ProjectOffers::with('project','store')->where('user_id', $userId)->get();

        return response()->json([
            'success' => true,
            'offers' => $offers
        ], 200);
    }

    public function getFeaturedProjects()
    {

        $featuredProjects = Project::with([
            "city",
            "county",
            'user',
            'brand',
            'neighbourhood',
            'roomInfo',
            'listItemValues',
            'housingType'
        ])
            ->where('status', 1)
            ->orderBy("created_at", "desc")
            ->paginate(12);

        return response()->json($featuredProjects);
    }

    public function getMyProject($projectId)
    {
        $project = Project::where('id', $projectId)->with("neighbourhood", "housingType", "county", "city", 'images', 'situations')->first();


        return json_encode([
            "project" => $project,
        ]);
    }

    public function show($projectID)
    {
        $project = Project::where('id', $projectID)->where("status", 1)->with("brand", "situations", "blocks", "neighbourhood", "housingType", "county", "city", 'listItemValues', 'user.brands', 'user.housings', 'images')->first();
        if (!$project) {
            return Response::json([
                'error' => "Proje yayından kaldırılmıştır"
            ], 201); // Status code here
        }

        $turkishAlphabet = [
            'A', 'B', 'C', 'Ç', 'D', 'E', 'F', 'G', 'Ğ', 'H', 'I', 'İ', 'J', 'K', 'L',
            'M', 'N', 'O', 'Ö', 'P', 'R', 'S', 'Ş', 'T', 'U', 'Ü', 'V', 'Y', 'Z'
        ];


        if ($project) {
            $projectHousingSetting = ProjectHouseSetting::orderBy('order')->get();


            $projectCartOrders = DB::table('cart_orders')
                ->select(
                    DB::raw('JSON_EXTRACT(cart, "$.item.housing") as housing_id'),
                    DB::raw('JSON_EXTRACT(cart, "$.item.qt") as qt'),
                    DB::raw('JSON_EXTRACT(cart, "$.item.qt") as qt_total'), // Added for total qt
                    'cart_orders.status',
                    'cart_orders.user_id',
                    'cart_orders.store_id',
                    'cart_orders.is_show_user',
                    'cart_orders.id',
                    'users.name',
                    'users.mobile_phone',
                    'users.phone'
                )
                ->leftJoin('users', 'cart_orders.user_id', '=', 'users.id')
                ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
                ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $project->id)
                ->orderByRaw('CAST(housing_id AS SIGNED) ASC')
                ->get()
                ->keyBy("housing_id");

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

            $offer = Offer::where('project_id', $project->id)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();

            $projectHousings = ProjectHousing::where('project_id', $project->id)->where('room_order', '>', 0)->where('room_order', '<=', 10)->get();
            $projectHousingsList = [];
            $projectHousings->map(function ($item) use (&$projectHousingsList) {
                $projectHousingsList[$item->room_order][$item->name] = $item->value;
            });
            if(auth()->guard("api")->check()){
                $projectFavorites = ProjectFavorite::where('user_id',auth()->guard("api")->user()->id)->where('project_id',$project->id)->get()->keyBy('housing_id')->toArray();
                $projectFavorites = array_keys($projectFavorites);
            }else{
                $projectFavorites = [];
            }

            $parent = HousingTypeParent::where("slug", $project->step1_slug)->first();
        } else {
            return redirect('/')
                ->with('error', 'İlan yayından kaldırıldı veya bulunamadı.');
        }

        return json_encode([
            "project" => $project,
            "offer" => $offer,
            "projectCartOrders" => $projectCartOrders,
            "projectHousingsList" => $projectHousingsList,
            "sumCartOrderQt" => $sumCartOrderQt,
            "parent" => $parent,
            "projectHousingSetting" => $projectHousingSetting,
            "projectFavorites" => $projectFavorites
        ]);
    }

    public function getRooms($projectId, Request $request)
    {
        $projectHousings = ProjectHousing::where('project_id', $projectId)->where('room_order', '>', $request->input('start'))->where('room_order', '<=', $request->input('end'))->get();
        $projectHousingsList = [];
        $projectHousings->map(function ($item) use (&$projectHousingsList) {
            $projectHousingsList[$item->room_order][$item->name] = $item->value;
        });
        return json_encode([
            "housings" => $projectHousingsList
        ]);
    }

    public function getFullProjects(Request $request)
    {
        $request->validate([
            "start" => "required",
            "end" => "required"
        ]);

        $projectCount = Project::count();

        $projects = Project::query();

        if ($request->input('start')) {
            $projects = $projects->skip($request->input('start'));
        }

        if ($request->input('end')) {
            $projects = $projects->take($request->input('end') - $request->input('start'));
        }

        $projects = $projects->get();

        return json_encode([
            "data" => $projects,
            "count" => $projectCount
        ]);
    }



    public function getMyProjects(Request $request)
    {
        $user = auth()->guard('api')->user();

        if (!$user) {
            return response()->json([
                "message" => "Unauthorized"
            ], 401); // Return a 401 Unauthorized response
        }

        $userId = $user->id;

        $orderBy = $request->input('order', 'desc');

        $fullProjectsCount = Project::where('user_id', $userId)
            ->where('status', $request->input('status'))
            ->count();

        $projects = Project::select(DB::raw('*, (select count(*) from project_housings WHERE name = "off_sale[]" AND value != "[]" AND project_id = projects.id) as offSale'))
            ->where('user_id', $userId)
            ->with([
                "housingType", 
                "county", 
                "city", 
                "neighbourhood", 
                "standOut", 
                "standOut.dopingPricePaymentWait", 
                'standOut.dopingPricePaymentCancel', 
                'favorites', // Ensure favorites relationship is loaded
                'sharerLinks' // Ensure sharerLinks relationship is loaded
            ])
            ->orderBy('created_at',$orderBy)
            ->where('status', $request->input('status'))
            ->take($request->input('take', 10)) // Default take to 10 if not provided
            ->skip($request->input('start', 0)) // Default skip to 0 if not provided
            ->get();

        $userProjectIds = $projects->pluck('id');

        $projectCounts = $this->getProjectCounts($userProjectIds, '1');
        $paymentPendingCounts = $this->getProjectCounts($userProjectIds, '0');

        $projects = $this->mapProjectCounts($projects, $projectCounts, 'cartOrders');
        $projects = $this->mapProjectCounts($projects, $paymentPendingCounts, 'paymentPending');

        // Add favorite counts to each project
        $projects = $projects->map(function ($project) {
            $project->favorite_count = $project->favorites->count();
            $project->sharer_links_count = $project->sharerLinks->count();
            return $project;
        });

        return response()->json([
            "data" => $projects,
            "total_projects_count" => $fullProjectsCount,
            "total_projects_count" => $fullProjectsCount
        ]);
    }

    
    

    protected function getProjectCounts($userProjectIds, $status)
    {
        return CartOrder::selectRaw('COUNT(*) as count, JSON_UNQUOTE(json_extract(cart, "$.item.id")) as project_id, MAX(status) as status')
            ->whereIn(DB::raw('JSON_UNQUOTE(json_extract(cart, "$.item.id"))'), $userProjectIds)
            ->groupBy('project_id')
            ->where('status', $status)
            ->get();
    }


    protected function mapProjectCounts($projects, $counts, $propertyName)
    {
        return $projects->map(function ($project) use ($counts, $propertyName) {
            $project->$propertyName = $counts->where('project_id', $project->id)->first()->count ?? 0;

            if ($propertyName == 'cartOrders') {
                $totalAmount = CartOrder::where(DB::raw('JSON_UNQUOTE(json_extract(cart, "$.item.id"))'), $project->id)
                    ->where("status", "1")->sum("amount");

                $project->totalAmount = number_format($totalAmount, 3, '.', '');
            }

            return $project;
        });
    }

    public function updatePrice(Request $request, $projectID, $roomID)
    {
        $project = Project::findOrFail($projectID);

        if (Auth::check() && Auth::user()->id == $project->user_id) {
            $newPrice = $request->input('new_price');
            $newPrice = str_replace('.', '', $newPrice);

            $fieldName = $project->step2_slug === 'gunluk-kiralik' ? 'daily_rent[]' : 'price[]';

            $projectHousing = ProjectHousing::where('project_id', $projectID)
                ->where('room_order', $roomID)
                ->where('name', $fieldName)
                ->first();

             
            if (!$projectHousing) {
                return redirect()->back()->with('error', 'Proje Bulunamadı');
            }

            $projectHousing->value = $newPrice;
            $projectHousing->save();
            $project->save();

            return redirect()->back()->with('success', 'Fiyat başarıyla güncellendi. Projeniz onay süreci için emlak sepette yönetimine iletilmiştir.');
        } else {
            return redirect()->back()->with('error', 'Fiyat güncellenirken bir hata oluştu.');
        }
    }

    public function deleteProjectGalleryImage($id)
    {
        ProjectImage::where('id', $id)->delete();

        return json_encode([
            "status" => true
        ]);
    }

    public function updateProject()
    {
        $tempOrder = TempOrder::where('item_type', 3)->where('user_id', auth()->guard("api")->user()->id)->first();
        $tempData = json_decode($tempOrder->data);

        Project::where('id', $tempData->id)->update([
            "project_title" => $tempData->project_title,
            "create_company" => $tempData->create_company,
            "total_project_area" => str_replace('.', '', $tempData->total_project_area),
            "island" => str_replace('.', '', $tempData->island),
            "parcel" => str_replace('.', '', $tempData->parcel),
            "start_date" => $tempData->start_date,
            "project_end_date" => $tempData->project_end_date,
            "slug" => Str::slug($tempData->project_title),
            "description" => $tempData->description,
            "location" => $tempData->location,
            "image" => $tempData->image,
            "city_id" => $tempData->city_id,
            "county_id" => $tempData->county_id,
            "neighbourhood_id" => $tempData->neighbourhood_id,
            "status" => "2",
        ]);


        ProjectImage::where('project_id', $tempData->id)->delete();
        foreach ($tempData->images as $key => $image) {
            $projectImage = new ProjectImage(); // Eğer model kullanıyorsanız
            $projectImage->image = 'public/project_images/' . str_replace('storage/project_images/', '', str_replace('public/project_images/', '', $image->image));
            $projectImage->project_id = $tempData->id;
            $projectImage->save();
        }

        ProjectSituation::where('project_id', $tempData->id)->delete();
        foreach ($tempData->situations as $key => $image) {
            $projectImage = new ProjectSituation(); // Eğer model kullanıyorsanız
            $projectImage->situation = 'public/situation_images/' . str_replace('public/situation_images/', '', $image->situation);
            $projectImage->project_id = $tempData->id;
            $projectImage->save();
        }

        $tempOrder->delete();

        return json_encode([
            "status" => true,
        ]);
    }

    public function getCommentsByProject($projectId){
        // Verilen proje ID'sine ait yorumları al
        $comments = ProjectComment::where('project_id', $projectId)->get();
        return response()->json($comments);
    }//End

    public function projectCommentPost(Request $request,$projectId){
               // Yorum eklemek için gerekli validation kurallarını tanımla
               $validator = Validator::make($request->all(), [
                'user_id'    => 'required|exists:users,id',
                'comment'    => 'required',
                'project_id' => 'required',
            ]);
    
            // Validation hata varsa dön
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
            }

                // Resimleri işle
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('public/project-comment-images');
                    $imagePaths[] = $path;
                }
            }
            
            // Yorum verilerini al
            $data = $request->only('user_id', 'comment', 'rate', 'owner_id');
            $data['project_id'] = $projectId;
            $data['status'] = 0;
            $data['images'] = json_encode($imagePaths); 
    
           // Yeni yorumu oluştur
            $comment = ProjectComment::create($data);
    
            // Başarı mesajı döndür
            return response()->json([
                'status' => 'success',
                'message' => 'Comment added successfully',
                'data' => $comment
            ], 201);
    }//End    

    public function userComments(Request $request, $userId){
    
        $userComments = ProjectComment::where('user_id', $userId)->where('status', 1)->get();

    
        // Yorumlardaki project_id değerlerini al
        $projectIds = $userComments->pluck('project_id')->unique();
    
        // Eğer project_id'ler varsa, projeleri al
        $projects = [];
        if ($projectIds->isNotEmpty()) {
            $projects = DB::table('projects')
                          ->whereIn('id', $projectIds)
                          ->get();
        }
    
        // Yorumları ve projeleri birleştir
        $commentsWithProjects = $userComments->map(function ($comment) use ($projects) {
            $project = $projects->firstWhere('id', $comment->project_id);
            return [
                'comment' => $comment,
                'project' => $project
            ];
        });
    
        return response()->json($commentsWithProjects);
    }//End
       

    public function userCommentUpdate(Request $request, $userId, $projectId, $commentId)
    {
        // İstekten gelen verileri al
        $validatedData = $request->validate([
            'comment' => 'required|string|max:255',
            'rate' => 'nullable|integer|min:1|max:5',
        ]);
    
        // Kullanıcının belirttiği proje ve kullanıcı kimliği ile yorumu bul
        $userComment = ProjectComment::where('user_id', $userId)
                                     ->where('project_id', $projectId)
                                     ->where('id', $commentId)
                                     ->where('status', 1)
                                     ->first();
    
        // Eğer yorum bulunamazsa, hata mesajı döndür
        if (!$userComment) {
            return response()->json(['error' => 'Yorum bulunamadı veya bu yorumu düzenleme yetkiniz yok.'], 404);
        }
    
        // Yorum verilerini güncelle
        $userComment->comment = $validatedData['comment'];
        $userComment->rate = $validatedData['rate'] ?? $userComment->rate;
        $userComment->save();
    
        // Güncellenmiş yorumu döndür
        return response()->json(['message' => 'Yorum başarıyla güncellendi.', 'comment' => $userComment]);
    }
     
}
