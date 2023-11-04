<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with("role")->where("parent_id", auth()->user()->parent_id ?? auth()->user()->id)->get();
        return view('institutional.users.index', compact('users'));
    }

    public function getTaxDocument()
    {
        $user = auth()->user();
        $tax_document = $user->tax_document;

        if (is_null($tax_document)) {
            die('Belge yok.');
        }

        $file = file_get_contents(storage_path("/app/{$tax_document}"));
        preg_match('@\.(\w+)$@', $tax_document, $match);
        $extension = $match[1] ?? 'png';

        header('Content-Type: image/' . $extension);
        echo $file;
    }

    public function getRecordDocument()
    {
        $user = auth()->user();
        $record_document = $user->record_document;

        if (is_null($record_document)) {
            die('Belge yok.');
        }

        $file = file_get_contents(storage_path("/app/{$record_document}"));
        preg_match('@\.(\w+)$@', $record_document, $match);
        $extension = $match[1] ?? 'png';

        header('Content-Type: image/' . $extension);
        echo $file;
    }

    public function getIdentityDocument()
    {
        $user = auth()->user();
        $identity_document = $user->identity_document;

        if (is_null($identity_document)) {
            die('Belge yok.');
        }

        $file = file_get_contents(storage_path("/app/{$identity_document}"));
        preg_match('@\.(\w+)$@', $identity_document, $match);
        $extension = $match[1] ?? 'png';

        header('Content-Type: image/' . $extension);
        echo $file;
    }

    public function getCompanyDocument()
    {
        $user = auth()->user();
        $company_document = $user->company_document;

        if (is_null($company_document)) {
            die('Belge yok.');
        }

        $file = file_get_contents(storage_path("/app/{$company_document}"));
        preg_match('@\.(\w+)$@', $company_document, $match);
        $extension = $match[1] ?? 'png';

        header('Content-Type: image/' . $extension);
        echo $file;
    }

    public function create()
    {
        $roles = Role::where("parent_id", auth()->user()->parent_id ?? auth()->user()->id)->get();
        return view('institutional.users.create', compact("roles"));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'type' => 'required',
        ];

        // Form doğrulama işlemini gerçekleştirin
        $validatedData = $request->validate($rules);
        $mainUser = User::where("id", auth()->user()->parent_id ?? auth()->user()->id)->with("plan")->first();
        $countUser = UserPlan::where("user_id", $mainUser->id)->first();

        // Yeni kullanıcıyı oluşturun
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->profile_image = "indir.png";
        $user->password = bcrypt($validatedData['password']); // Şifreyi şifreleyin
        $user->type = $validatedData['type'];
        $user->status = $request->has('is_active') ? 1 : 5;
        $user->corporate_account_status = 1;
        $user->parent_id = (auth()->user()->parent_id ?? auth()->user()->id) != 3 ? (auth()->user()->parent_id ?? auth()->user()->id) : null;
        $user->subscription_plan_id = $mainUser->subscription_plan_id;

        // Kullanıcıyı veritabanına kaydedin
        $user->save();

        if ($user->save()) {
            $countUser->user_limit = $countUser->user_limit - 1;
            $countUser->save();
        }

        // Başarılı bir işlem sonrası mesajı ayarlayın
        session()->flash('success', 'Kullanıcı başarıyla oluşturuldu.');

        // Yönlendirme yapabilirsiniz, örneğin kullanıcıları listeleme sayfasına yönlendirme
        return redirect()->route('institutional.users.index'); // index route'unu kullanarak kullanıcıları listeleme sayfasına yönlendirme
    }

    public function edit($id)
    {
        $roles = Role::where("parent_id", auth()->user()->parent_id ?? auth()->user()->id)->get();
        $subUser = User::findOrFail($id); // Kullanıcıyı bulun veya hata döndürün
        return view('institutional.users.edit', compact('subUser', 'roles'));
    }

    public function update(Request $request, $id)
    {
        // Form doğrulama kurallarını tanımlayın
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'type' => 'required',
            'is_active' => 'nullable',
        ];

        // Form doğrulama işlemini gerçekleştirin
        $validatedData = $request->validate($rules);

        // Kullanıcıyı güncelleyin
        $user = User::findOrFail($id); // Kullanıcıyı bulun veya hata döndürün
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->type = $validatedData['type'];
        $user->status = $request->has('is_active') ? 1 : 5;

        // Şifre güncelleme işlemini kontrol edin
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Kullanıcıyı veritabanına kaydedin
        $user->save();

        // Başarılı bir işlem sonrası mesajı ayarlayın
        session()->flash('success', 'Kullanıcı başarıyla güncellendi.');

        // Kullanıcıları listeleme sayfasına yönlendirme yapabilirsiniz
        return redirect()->route('institutional.users.index'); // index route'unu kullanarak kullanıcıları listeleme sayfasına yönlendirme
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
}
