<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function blockUser(User $user)
    {
        if ($user->is_blocked) {
            $user->update(['is_blocked' => false]);
            return redirect()->back()->with('success', 'Kullanıcı engellemesi kaldırıldı.');
        } else {
            $user->update(['is_blocked' => true]);

            foreach ($user->projects as $value) {
                $value->update([
                    "status" => 0,
                ]);
            }
            return redirect()->back()->with('success', 'Kullanıcı engellendi.');
        }
    }

    public function index(Request $request)
    {
        $query = User::with("role");

        if ($request->input('name') !== null) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->input('role') !== null) {
            $query->where('type', 'like', '%' . $request->input('role') . '%');
        }

        if ($request->input('email') !== null) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
        }

        $users = $query->orderByDesc('created_at')->get();

        if ($request->ajax()) {
            return view('admin.users.table', compact('users'));
        }

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::where("parent_id", "4")->get();
        return view('admin.users.create', compact("roles"));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'type' => 'required|in:1,2',
        ];

        // Form doğrulama işlemini gerçekleştirin
        $validatedData = $request->validate($rules);

        // Yeni kullanıcıyı oluşturun
        $user = new User();
        $user->name = $validatedData['name'];
        $user->profile_image = "indir.png";
        $user->banner_hex_code = "black";
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']); // Şifreyi şifreleyin
        $user->type = $validatedData['type'];
        $user->status = $request->has('is_active'); // Aktiflik durumunu kontrol edin

        // Kullanıcıyı veritabanına kaydedin
        $user->save();

        // Başarılı bir işlem sonrası mesajı ayarlayın
        session()->flash('success', 'Kullanıcı başarıyla oluşturuldu.');

        // Yönlendirme yapabilirsiniz, örneğin kullanıcıları listeleme sayfasına yönlendirme
        return redirect()->route('admin.users.index'); // index route'unu kullanarak kullanıcıları listeleme sayfasına yönlendirme
    }

    public function getTaxDocument(User $user)
    {
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

    public function getRecordDocument(User $user)
    {
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

    public function getIdentityDocument(User $user)
    {
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

    public function getCompanyDocument(User $user)
    {
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

    public function updateCorporateStatus(Request $request, User $user)
    {
        $request->validate(
            [
                'tax_document_approve' => 'nullable|in:0,1',
                'record_document_approve' => 'nullable|in:0,1',
                'identity_document_approve' => 'required|in:0,1',
                'company_document_approve' => 'nullable|in:0,1',
                'note' => 'required|string',
                'status' => 'required|in:0,1',
            ],
            [
                'note.required' => 'Not alanı gereklidir.',
            ]
        );

        $company = [];
        if (!is_null($request->input('company_document_approve'))) {
            $company =
                [
                'company_document_approve' => $request->input('company_document_approve'),
            ];
        }

        $user->update(
            array_merge(
                [
                    'tax_document_approve' => $request->input('tax_document_approve') ?? '0',
                    'record_document_approve' => $request->input('record_document_approve') ?? '0',
                    'identity_document_approve' => $request->input('identity_document_approve'),
                    'corporate_account_note' => $request->input('note'),
                    'corporate_account_status' => $request->input('status'),
                ], $company)
        );

        return redirect()->back();
    }

    public function showCorporateAccount($id)
    {
        $user_e = User::findOrFail($id);
        return view('admin.users.showCorporateStatus', compact('user_e'));
    }

    public function edit($id)
    {
        $roles = Role::all();
        $userDetail = User::with("comments", "owners", "parent", "town", "child", "role", "projects", "city", "district", "neighborhood", "housings", "plan")->findOrFail($id);
        return view('admin.users.edit', compact('userDetail', 'roles'));
    }

    public function update(Request $request, $id)
    {
        // Form doğrulama kurallarını tanımlayın
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'type' => 'required|in:1,2',
            'is_active' => 'nullable',
        ];

        // Form doğrulama işlemini gerçekleştirin
        $validatedData = $request->validate($rules);

        // Kullanıcıyı güncelleyin
        $user = User::findOrFail($id); // Kullanıcıyı bulun veya hata döndürün
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->type = $validatedData['type'];
        $user->status = $request->has('is_active') ? 1 : 0;

        // Şifre güncelleme işlemini kontrol edin
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Kullanıcıyı veritabanına kaydedin
        $user->save();

        // Başarılı bir işlem sonrası mesajı ayarlayın
        session()->flash('success', 'Kullanıcı başarıyla güncellendi.');

        // Kullanıcıları listeleme sayfasına yönlendirme yapabilirsiniz
        return redirect()->route('admin.users.index'); // index route'unu kullanarak kullanıcıları listeleme sayfasına yönlendirme
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id); // Kullanıcıyı bulun veya hata döndürün
        $user->delete();

        // Kullanıcı başarıyla silindiğine dair bir mesaj ayarlayın
        session()->flash('success', 'Kullanıcı başarıyla silindi.');

        // Kullanıcıları listeleme sayfasına yönlendirme yapabilirsiniz
        return redirect()->route('admin.users.index'); // index route'unu kullanarak kullanıcıları listeleme sayfasına yönlendirme
    }
}
