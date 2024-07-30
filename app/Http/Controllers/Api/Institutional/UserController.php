<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Chat;
use App\Models\Collection;
use App\Models\HousingFavorite;
use App\Models\ProjectFavorite;
use App\Models\Role;
use App\Models\SharerPrice;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create()
    {
        $userLog = User::where('id', auth()->user()->id)->with('plan.subscriptionPlan', 'parent')->first();
        $roles = Role::where('parent_id', auth()->user()->parent_id ?? auth()->user()->id)->get();
        return response()->json([
            'userLog' => $userLog,
            'roles' => $roles
        ]);
    }

    public function show(Request $request, User $user)
    {
        // Erişim izinlerini alın
        $permissions = [];
        if ($user->role && $user->role->rolePermissions) {
            $permissions = $user->role->rolePermissions->flatMap(function ($rolePermission) {
                return $rolePermission->permissions ? $rolePermission->permissions->pluck('key') : collect();
            })->unique()->toArray();
        }
    
        // Kullanıcı türüne bağlı izinleri filtreleyin
        if ($user->type != "1" && $user->type != "3") {
            if ($user->corporate_type) {
                if ($user->corporate_type == 'Emlak Ofisi') {
                    $permissions = array_diff($permissions, [
                        'Projects', 'CreateProject', 'GetProjects', 'GetReceivedOffers', 'DeleteProject', 'UpdateProject', 'GetProjectById'
                    ]);
                }
    
                if ($user->corporate_type == 'İnşaat Ofisi') {
                    $permissions = array_diff($permissions, [
                        'Offers', 'CreateOffer', 'DeleteOffer', 'GetOfferById', 'UpdateOffer', 'GetOffers'
                    ]);
                }
    
                if ($user->corporate_type == 'Turizm Amaçlı Kiralama') {
                    $permissions = array_diff($permissions, [
                        'GetReservations', 'CreateReservation', 'DeleteReservation', 'UpdateReservation', 'GetReservationById'
                    ]);
                }
            }
        }
    
        // Balance ve Collections bilgilerini getir
        $balanceStatus0 = SharerPrice::where("user_id", $user->id)->where("status", "0")->sum('balance');
        $balanceStatus1Lists = SharerPrice::where("user_id", $user->id)->where("status", "1");
        $balanceStatus1 = $balanceStatus1Lists->sum('balance');
        $balanceStatus2 = SharerPrice::where("user_id", $user->id)->where("status", "2")->sum('balance');
    
        $totalStatus1Count = $balanceStatus1Lists->count();
        $successPercentage = $totalStatus1Count > 0 
            ? ($totalStatus1Count / ($totalStatus1Count + SharerPrice::where("user_id", $user->id)->where("status", "0")->count() + SharerPrice::where("user_id", $user->id)->where("status", "2")->count())) * 100 
            : 0;
    
        $collections = Collection::with("links.project", "links.housing", "clicks")
                        ->where("user_id", $user->id)
                        ->orderBy("id", "desc")
                        ->limit(6)
                        ->get();
    
        $housingFavorites = HousingFavorite::where("user_id", $user->id)->count();
        $projectFavorites = ProjectFavorite::where("user_id", $user->id)->count();
        $cartItem = CartItem::where('user_id', $user->id)->latest()->first();
    
        // Kullanıcı verilerini bir diziye aktar
        $userData = [
            'status' => 200,
            'success' => true,
            'id' => $user->id,
            'facebook_id' => $user->facebook_id,
            'is_show' => $user->is_show,
            'name' => $user->name,
            'type' => $user->type,
            'status' => $user->status,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'password' => $user->password,
            'remember_token' => $user->remember_token,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'deleted_at' => $user->deleted_at,
            'phone' => $user->phone,
            'phone_verification_status' => $user->phone_verification_status,
            'phone_verification_code' => $user->phone_verification_code,
            'birthday' => $user->birthday,
            'city_id' => $user->city_id,
            'email_verification_token' => $user->email_verification_token,
            'activity' => $user->activity,
            'county_id' => $user->county_id,
            'account_type' => $user->account_type,
            'taxOfficeCity' => $user->taxOfficeCity,
            'taxOffice' => $user->taxOffice,
            'taxNumber' => $user->taxNumber,
            'idNumber' => $user->idNumber,
            'plan_id' => $user->plan_id,
            'subscription_plan_id' => $user->subscription_plan_id,
            'profile_image' => $user->profile_image,
            'banner_hex_code' => $user->banner_hex_code,
            'parent_id' => $user->parent_id,
            'neighborhood_id' => $user->neighborhood_id,
            'corporate_type' => $user->corporate_type,
            'corporate_account_status' => $user->corporate_account_status,
            'tax_document' => $user->tax_document,
            'record_document' => $user->record_document,
            'corporate_account_note' => $user->corporate_account_note,
            'tax_document_approve' => $user->tax_document_approve,
            'record_document_approve' => $user->record_document_approve,
            'identity_document' => $user->identity_document,
            'identity_document_approve' => $user->identity_document_approve,
            'company_document' => $user->company_document,
            'company_document_approve' => $user->company_document_approve,
            'is_blocked' => $user->is_blocked,
            'username' => $user->username,
            'institutional_awaiting_approval' => $user->institutional_awaiting_approval,
            'commercial_title' => $user->commercial_title,
            'last_login' => $user->last_login,
            'instagramusername' => $user->instagramusername,
            'iban' => $user->iban,
            'year' => $user->year,
            'code' => $user->code,
            'has_club' => $user->has_club,
            'bank_name' => $user->bank_name,
            'mobile_phone' => $user->mobile_phone,
            'latitude' => $user->latitude,
            'longitude' => $user->longitude,
            'order' => $user->order,
            'title' => $user->title,
            'website' => $user->website,
            'store_name' => $user->store_name,
            'is_called' => $user->is_called,
            'is_show_files' => $user->is_show_files,
            'authority_licence' => $user->authority_licence,
            'approve_website' => $user->approve_website,
            'approve_website_approve' => $user->approve_website_approve,
            'role' => $user->role ? $user->role->name : null,
            'role_id' => $user->role ? $user->role->id : null,
            'slug' => $user->role ? $user->role->slug : null,
            'buyerStatus' => $user->status,
            'cartItem' => $cartItem ? $cartItem : null,
            'housingFavoritesCount' => $housingFavorites,
            'projectFavoritesCount' => $projectFavorites,
            'corporateAccountStatus' => $user->corporate_account_status,
            'email' => $user->email,
            'mobile_phone' => $user->mobile_phone,
            'rolePermissions' => $user->role ? $user->role->rolePermissions : null,
            'permissions' => $permissions,
            'works' => $user->works,
            'token_type' => 'Bearer',
            'balanceStatus1Lists' => $balanceStatus1Lists,
            'balanceStatus0' => $balanceStatus0,
            'balanceStatus2' => $balanceStatus2,
            'successPercentage' => $successPercentage,
            'collections' => $collections
        ];
    
        return response()->json([
            'user' => $userData,
            "balanceStatus1" => $balanceStatus1,
            "balanceStatus0" => $balanceStatus0,
            "balanceStatus2" => $balanceStatus2,
            "successPercentage" => $successPercentage,
            "collections" => $collections,
            "permissions" => $permissions,
        ]);
    }
    
    

    public function index()
    {
        $users = User::with('role')->where('parent_id', auth()->user()->parent_id ?? auth()->user()->id)->orderBy("order", "asc")->get();
        return response()->json([
            'users' => $users
        ]);
    }

    public function edit($id)
    {
        $roles = Role::where('parent_id', auth()->user()->parent_id ?? auth()->user()->id)->get();
        $subUser = User::findOrFail($id);
        return response()->json([
            'subUser' => $subUser,
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'İsim alanı zorunludur.',
            'mobile_phone.required' => 'Cep no alanı zorunludur.',
            'name.string' => 'İsim alanı metin türünde olmalıdır.',
            'name.max' => 'İsim alanı en fazla 255 karakter olmalıdır.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi zaten kullanılıyor.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az 3 karakterden oluşmalıdır.',
            'type.required' => 'Tip alanı zorunludur.',
            'title.required' => 'Unvan alanı zorunludur.',
        ];

        $rules = [
            'name' => 'required|string|max:255',
            'mobile_phone' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'type' => 'required',
            'title' => 'required',
        ];

        try {
            $validatedData = $request->validate($rules, $messages);

            $mainUser = User::where('id', auth()->user()->parent_id ?? auth()->user()->id)->with('plan')->first();
            $countUser = UserPlan::where('user_id', $mainUser->id)->first();
            $users = User::where('parent_id', auth()->user()->parent_id ?? auth()->user()->id)->get();
            $userCount = User::all();
            $lastUser = User::latest()->first();

            $user = new User();
            $user->name = $validatedData['name'];
            $user->title = $validatedData['title'];
            $user->email = $validatedData['email'];
            $user->mobile_phone = $validatedData['mobile_phone'];
            $user->profile_image = 'indir.png';
            $user->password = bcrypt($validatedData['password']); // Şifreyi şifreleyin
            $user->type = $validatedData['type'];
            $user->status = 0;
            $user->corporate_account_status = 1;
            $user->parent_id = (auth()->user()->parent_id ?? auth()->user()->id) != 3 ? (auth()->user()->parent_id ?? auth()->user()->id) : null;
            $user->code = $lastUser->id + auth()->user()->id + 1000000;
            $user->subscription_plan_id = $mainUser->subscription_plan_id;

            $user->save();

            if ($countUser && $user->save()) {
                $countUser->user_limit = $countUser->user_limit - 1;
                $countUser->save();
            }

            Chat::create([
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => "Kullanıcı başarıyla oluşturuldu."
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Beklenmedik bir hata oluştu.'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'type' => 'required',
            'mobile_phone' => 'required',
            'title' => 'required',
            'is_active' => 'nullable',
        ];

        try {
            // Form doğrulama işlemini gerçekleştirin
            $validatedData = $request->validate($rules);

            // Kullanıcıyı bulun veya hata döndürün
            $user = User::findOrFail($id);

            // Kullanıcıyı güncelleyin
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->title = $validatedData['title'];
            $user->mobile_phone = $validatedData['mobile_phone'];
            $user->type = $validatedData['type'];
            $user->status = $request->has('is_active') ? 5 : 0;

            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imageFileName = 'profile_image_' . time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('profile_images', $imageFileName, 'public');
                $user->profile_image = $imageFileName;
            }

            // Şifre güncelleme işlemini kontrol edin
            if ($request->filled('password')) {
                $user->password = bcrypt($request->input('password'));
            }

            // Kullanıcıyı veritabanına kaydedin
            $user->save();

            // Başarılı bir işlem sonrası JSON yanıtı
            return response()->json([
                'success' => true,
                'message' => 'Kullanıcı başarıyla güncellendi.',
                'data' => $user
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Beklenmedik bir hata oluştu.'
            ], 500);
        }
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id); // Kullanıcıyı bulun veya hata döndürün
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => "Kullanıcı başarıyla silindi."
        ]);
    }


    public function deleteSubUsers(Request $request)
    {

        $userIds = $request->input('user_ids',[]);
        
         $deletedRows = User::whereIn('id', $userIds)->where('parent_id', auth()->user()->id)->delete();

         if ($deletedRows === 0) {
             return response()->json([
                 'status' => "no_sub_users",
                 'message' => "Bu parent_id ile alt kullanıcı bulunamadı."
             ]);
         }
 
         return response()->json([
             'status' => "deleted",
             'message' => "Alt kullanıcılar başarıyla silindi.",
             'deleted_count' => $deletedRows
         ]);


    }

    public function getCurrentUser()
    {
        $user = User::where('id', auth()->user()->id)->first();

        return json_encode([
            "user" => $user
        ]);
    }
}
