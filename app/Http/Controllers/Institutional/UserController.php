<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Chat;

use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {
    public function index() {
        $users = User::with( 'role' )->where( 'parent_id', auth()->user()->parent_id ?? auth()->user()->id )->orderBy("order","asc")->get();
        return view( 'institutional.users.index', compact( 'users' ) );
    }

    public function getTaxDocument() {
        $user = auth()->user();
        $tax_document = $user->tax_document;

        if ( is_null( $tax_document ) ) {
            die( 'Belge yok.' );
        }

        $file = file_get_contents( storage_path( "/app/{$tax_document}" ) );
        preg_match( '@\.(\w+)$@', $tax_document, $match );
        $extension = $match[ 1 ] ?? 'png';

        header( 'Content-Type: image/' . $extension );
        echo $file;
    }

    public function getRecordDocument() {
        $user = auth()->user();
        $record_document = $user->record_document;

        if ( is_null( $record_document ) ) {
            die( 'Belge yok.' );
        }

        $file = file_get_contents( storage_path( "/app/{$record_document}" ) );
        preg_match( '@\.(\w+)$@', $record_document, $match );
        $extension = $match[ 1 ] ?? 'png';

        header( 'Content-Type: image/' . $extension );
        echo $file;
    }

    public function getIdentityDocument() {
        $user = auth()->user();
        $identity_document = $user->identity_document;

        if ( is_null( $identity_document ) ) {
            die( 'Belge yok.' );
        }

        $file = file_get_contents( storage_path( "/app/{$identity_document}" ) );
        preg_match( '@\.(\w+)$@', $identity_document, $match );
        $extension = $match[ 1 ] ?? 'png';

        header( 'Content-Type: image/' . $extension );
        echo $file;
    }

    public function getCompanyDocument() {
        $user = auth()->user();
        $company_document = $user->company_document;

        if ( is_null( $company_document ) ) {
            die( 'Belge yok.' );
        }

        $file = file_get_contents( storage_path( "/app/{$company_document}" ) );
        preg_match( '@\.(\w+)$@', $company_document, $match );
        $extension = $match[ 1 ] ?? 'png';

        header( 'Content-Type: image/' . $extension );
        echo $file;
    }

    public function create() {
        $userLog = User::where( 'id', auth()->user()->id )->with( 'plan.subscriptionPlan', 'parent' )->first();
        $roles = Role::where( 'parent_id', auth()->user()->parent_id ?? auth()->user()->id )->get();
        return view( 'institutional.users.create', compact( 'roles', 'userLog' ) );
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
        $user->status =0;
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

        session()->flash( 'success', 'Kullanıcı başarıyla oluşturuldu.' );

        return redirect()->route( 'institutional.users.index' );

    }

    public function edit( $id ) {
        $roles = Role::where( 'parent_id', auth()->user()->parent_id ?? auth()->user()->id )->get();
        $subUser = User::findOrFail( $id );
        // Kullanıcıyı bulun veya hata döndürün
        return view( 'institutional.users.edit', compact( 'subUser', 'roles' ) );
    }

    public function update( Request $request, $id ) {
        // Form doğrulama kurallarını tanımlayın
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'type' => 'required',
            'mobile_phone' => 'required',
            'title' => 'required',
            'is_active' => 'nullable',
        ];

        // Form doğrulama işlemini gerçekleştirin
        $validatedData = $request->validate( $rules );

        // Kullanıcıyı güncelleyin
        $user = User::findOrFail( $id );
        // Kullanıcıyı bulun veya hata döndürün
        $user->name = $validatedData[ 'name' ];
        $user->email = $validatedData[ 'email' ];
        $user->title = $validatedData[ 'title' ];
        $user->mobile_phone = $validatedData[ 'mobile_phone' ];

        $user->type = $validatedData[ 'type' ];
        $user->status = $request->has( 'is_active' ) ? 5 : 0;
        
            
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageFileName = 'profile_image_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('profile_images', $imageFileName, 'public');
            $user->profile_image = $imageFileName; 
        }
        

        // Şifre güncelleme işlemini kontrol edin
        if ( $request->filled( 'password' ) ) {
            $user->password = bcrypt( $request->input( 'password' ) );
        }

        // Kullanıcıyı veritabanına kaydedin
        $user->save();

        // Başarılı bir işlem sonrası mesajı ayarlayın
        session()->flash( 'success', 'Kullanıcı başarıyla güncellendi.' );

        // Kullanıcıları listeleme sayfasına yönlendirme yapabilirsiniz
        return redirect()->route( 'institutional.users.index' );
        // index route'unu kullanarak kullanıcıları listeleme sayfasına yönlendirme
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id); // Kullanıcıyı bulun veya hata döndürün
        $user->delete();

        // Kullanıcı başarıyla silindiğine dair bir mesaj ayarlayın
        session()->flash('success', 'Kullanıcı başarıyla silindi.');

        // Kullanıcıları listeleme sayfasına yönlendirme yapabilirsiniz
        return redirect()->route('institutional.users.index'); // index route'unu kullanarak kullanıcıları listeleme sayfasına yönlendirme
    }

    public function updateUserOrder(Request $request){
        foreach ($request->input('orders') as $key => $order) {
            User::where('id', $order['id'])->update(['order' => $key +1]);
        }

        return response()->json(['message' => 'Order updated successfully']);
    }//End
}
