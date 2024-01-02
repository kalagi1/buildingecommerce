<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BankAccountController extends Controller
{
    public function index()
    {
        $bankAccounts = BankAccount::all();
        return view('admin.bank_account.index', compact('bankAccounts'));
    }

    public function create()
    {
        return view('admin.bank_account.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'image.required' => 'Resim alanı gereklidir.',
            'image.image' => 'Resim alanı geçerli bir resim dosyası olmalıdır.',
            'image.mimes' => 'Resim dosyası sadece jpeg, png, jpg veya gif formatında olmalıdır.',
            'iban.required' => 'IBAN alanı gereklidir.',
            'iban.unique' => 'Bu IBAN zaten kullanılıyor.',
            'recipient_full_name.required' => 'Alıcı adı alanı gereklidir.',
        ];

        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'iban' => 'required|unique:bank_accounts',
            'recipient_full_name' => 'required',
        ], $messages);

        $image = $request->file('image');
        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('bank_accounts'), $imageName);

        $bankAccount = new BankAccount;
        $bankAccount->image = 'bank_accounts/' . $imageName;
        $bankAccount->iban = $request->iban;
        $bankAccount->receipent_full_name = $request->recipient_full_name;
        $bankAccount->save();

        return redirect()->route('admin.bank_account.index')->with('success', 'Başarıyla banka hesabı oluşturdunuz');
    }

    public function edit($id)
    {
        $bankAccount = BankAccount::findOrFail($id);
        return view('admin.bank_account.edit', compact('bankAccount'));
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'image.image' => 'Resim alanı geçerli bir resim dosyası olmalıdır.',
            'image.mimes' => 'Resim dosyası sadece jpeg, png, jpg veya gif formatında olmalıdır.',
            'iban.required' => 'IBAN alanı gereklidir.',
            'iban.unique' => 'Bu IBAN zaten kullanılıyor.',
            'recipient_full_name.required' => 'Alıcı adı alanı gereklidir.',
        ];
        
        $attributes = [
            'image' => 'Resim',
            'iban' => 'IBAN',
            'recipient_full_name' => 'Alıcı Adı',
        ];
        
        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'iban' => 'required|unique:bank_accounts,iban,' . $id,
            'recipient_full_name' => 'required',
        ], $messages, $attributes);
        

        $bankAccount = BankAccount::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('bank_accounts'), $imageName);

            // Eski resmi sil (isteğe bağlı)
            if (File::exists(public_path($bankAccount->image))) {
                File::delete(public_path($bankAccount->image));
            }

            $bankAccount->image = 'bank_accounts/' . $imageName;
        }

        $bankAccount->iban = $request->iban;
        $bankAccount->receipent_full_name = $request->recipient_full_name;
        $bankAccount->save();

        return redirect()->route('admin.bank_account.index')->with('success', 'Başarıyla banka hesabı eklediniz');
    }

    public function destroy($id)
    {
        $bankAccount = BankAccount::findOrFail($id);

        $imagePath = public_path($bankAccount->image);

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $bankAccount->delete();

        return redirect()->route('admin.bank_account.index')->with('success', 'Başarıyla banka hesabını sildiniz');
    }
}
