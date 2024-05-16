<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Role;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;

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

    public function index() {
        $users = User::with( 'role' )->where( 'parent_id', auth()->user()->parent_id ?? auth()->user()->id )->orderBy("order","asc")->get();
        return response()->json([
            'users' => $users
        ]);
    }

    public function edit( $id ) {
        $roles = Role::where( 'parent_id', auth()->user()->parent_id ?? auth()->user()->id )->get();
        $subUser = User::findOrFail( $id );
        return response()->json([
            'subUser' => $subUser,
            'roles' => $roles
        ]);
    }

    public function store( Request $request ) {
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

        $validatedData = $request->validate( $rules, $messages );
        $mainUser = User::where( 'id', auth()->user()->parent_id ?? auth()->user()->id )->with( 'plan' )->first();
        $countUser = UserPlan::where( 'user_id', $mainUser->id )->first();
        $users = User::where( 'parent_id', auth()->user()->parent_id ?? auth()->user()->id )->get();
        $userCount = User::all();
        $lastUser = User::latest()->first();

        $user = new User();
        $user->name = $validatedData[ 'name' ];
        $user->title = $validatedData[ 'title' ];

        $user->email = $validatedData[ 'email' ];
        $user->mobile_phone = $validatedData[ 'mobile_phone' ];

        $user->profile_image = 'indir.png';
        $user->password = bcrypt( $validatedData[ 'password' ] );
        // Şifreyi şifreleyin
        $user->type = $validatedData[ 'type' ];
        $user->status = $request->has( 'is_active' ) ? 1 : 5;
        $user->corporate_account_status = 1;
        $user->parent_id = ( auth()->user()->parent_id ?? auth()->user()->id ) != 3 ? ( auth()->user()->parent_id ?? auth()->user()->id ) : null;
        $user->code = $lastUser->id + auth()->user()->id  + 1000000;
        $user->subscription_plan_id = $mainUser->subscription_plan_id;

        $user->save();

        if ( $user->save() ) {
            $countUser->user_limit = $countUser->user_limit - 1;
            $countUser->save();
        }

        Chat::create( [
            'user_id' => $user->id
        ] );

        return response()->json([
            'success' => true,
            'message' => "Kullanıcı başarıyla oluşturuldu."
        ]);

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
