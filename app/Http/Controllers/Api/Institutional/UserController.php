<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Collection;
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
        
        $permissions = $user->role->rolePermissions->pluck('permissions')->flatten();

        $specialPermissions = [
            'Projects',
            'CreateProject',
            'GetProjects',
            'DeleteProject',
            'UpdateProject',
            'GetProjectById',
        ];

        $reservationPermissions = [
            'Reservations',
            'CreateReservation',
            'GetReservations',
            'DeleteReservation',
            'UpdateReservation',
            'GetReservationById',
        ];

        $offerPermissions = [
            "Offers",
            "CreateOffer",
            "Offers",
            "DeleteOffer",
            "GetOfferById",
            "UpdateOffer",
            "GetOffers"
        ];

        $specialPermissionKeys = [
            'ChangePassword',
            'EditProfile',
            'ViewDashboard',
            'ShowCartOrders',
            'GetMyCollection',
            'GetMyEarnings',
            'neighborView',
            'GetOrders',
            'GetReceivedOffers',
            'GetGivenOffers',
            'GetSwapApplications',
            'MyReservations',
            'Reservations',
            'Orders'
        ];

        $filteredPermissions  = $permissions;

        // Başlangıçta orijinal izinleri kullanarak bir kopya oluşturun
        if ($user->corporate_type == 'Emlak Ofisi') {

            $filteredPermissions = $permissions->reject(function ($permission) use ($specialPermissions) {
                return in_array($permission->key, $specialPermissions);
            });
        }

        // Eğer 'Turizm Amaçlı Kiralama' değilse, 'reservationPermissions'ı çıkartın
        if ($user->corporate_type !== 'Turizm Amaçlı Kiralama') {
            $filteredPermissions = $filteredPermissions->reject(function ($permission) use ($reservationPermissions) {
                return in_array($permission->key, $reservationPermissions);
            });
        }


        if ($user->corporate_type !== 'İnşaat Ofisi') {
            $filteredPermissions = $filteredPermissions->reject(function ($permission) use ($offerPermissions) {
                return in_array($permission->key, $offerPermissions);
            });
        }

        $filteredPermissions = $filteredPermissions->reject(function ($permission) use ($specialPermissionKeys) {
            return in_array($permission->key, $specialPermissionKeys);
        });

        $balanceStatus0Lists = SharerPrice::where("user_id", $user->id)
            ->where("status", "0")->get();

        $balanceStatus0 = SharerPrice::where("user_id", $user->id)
            ->where("status", "0")
            ->sum('balance');

        $balanceStatus1Lists = SharerPrice::where("user_id", $user->id)
            ->where("status", "1")->get();

        $balanceStatus1 = SharerPrice::where("user_id", $user->id)
            ->where("status", "1")
            ->sum('balance');


        $balanceStatus2Lists = SharerPrice::where("user_id", $user->id)
            ->where("status", "2")->get();

        $balanceStatus2 = SharerPrice::where("user_id", $user->id)
            ->where("status", "2")
            ->sum('balance');

        $collections = Collection::with("links.project", "links.housing","clicks")->where("user_id",  $user->id)->orderBy("id", "desc")->limit(6)->get();
        $totalStatus1Count = $balanceStatus1Lists->count();
        $successPercentage = $totalStatus1Count > 0 ? ($totalStatus1Count / ($totalStatus1Count + $balanceStatus0Lists->count() + $balanceStatus2Lists->count())) * 100 : 0;

        return response()->json([
            'user' => $user,
            "balanceStatus1" => $balanceStatus1,
            "balanceStatus0" => $balanceStatus0,
            "balanceStatus2" => $balanceStatus2,
            "successPercentage" => $successPercentage,
            "collections" => $collections,
            "permissions" => $filteredPermissions,

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

            if ($user->save()) {
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
}
