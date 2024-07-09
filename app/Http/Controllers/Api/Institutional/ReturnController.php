<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use App\Models\CartOrderRefund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ReturnController extends Controller
{
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'terms' => 'required|boolean',
                'name' => 'required|string|max:255',
                'phone' => 'required',
                'email' => 'required|string|email|max:255',
                'content' => 'required|string',
                'cart_order_id' =>'required',
                'return_bank' => 'required',
                'return_iban' => 'required',
            ],
            [
                "terms.required" => "Sözleşme onayı zorunludur",
                "terms.boolean" => "Sözleşme onayı boolean bir değer olmalıdır",
                "name.required" => "İsim Soyisim zorunludur",
                "name.string" => "İsim soyisim string olmak zorundadır",
                "name.max" => "İsim Soyisim maksimum 255 karakter olabilir", 
                "phone.required" => "Telefon numarası zorunludur",
                "email.required" => "Email zorunludur",
                "email.string" => "Email string olmak zorundadır",
                "email.email" => "Email adresiniz düzgün formatta olmalıdır",
                "email.max" => "Email adresiniz maksimum 255 karakter olabilir",
                "content.required" => "Sipariş İptal Sebebi zorunludur",
                "content.string" => "Sipariş İptal Sebebi string olmak zorundadır",
                "cart_order_id.required" => "Sipariş ID'si zorunludur",
                "return_bank.required" => "İade edilecek banka adı zorunludur",
                "return_iban.required" => "İade edilecek iban bilgisi zorunludur",
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 404);
            }
    
            $userId = auth()->guard("api")->user()->id;
    
            $validatedData = $request->all();
    
            $existingRefund = CartOrderRefund::where('cart_order_id', $validatedData['cart_order_id'])->first();
    
            if ($existingRefund) {
                // İade talebi zaten var, güncelle
                $existingRefund->update([
                    'terms'       => $validatedData['terms'],
                    'name'        => $validatedData['name'],
                    'phone'       => $validatedData['phone'],
                    'email'       => $validatedData['email'],
                    'return_bank' => $validatedData['return_bank'],
                    'return_iban' => $validatedData['return_iban'],
                    'content'     => $validatedData['content'],
                    'status'      => '0',
                    'user_id'     => $userId,
                    'return_amount' => '0',
                ]);
            } else {
                // İade talebi yok, yeni kayıt oluştur
                $refund = new CartOrderRefund([
                    'terms'         => $validatedData['terms'],
                    'name'          => $validatedData['name'],
                    'phone'         => $validatedData['phone'],
                    'email'         => $validatedData['email'],
                    'return_bank'   => $validatedData['return_bank'],
                    'return_iban'   => $validatedData['return_iban'],
                    'content'       => $validatedData['content'],
                    'status'        => '0',
                    'user_id'       => $userId,
                    'cart_order_id' => $validatedData['cart_order_id'],
                    'return_amount' => '0',
                ]);
    
                $refund->save();
            }
    
            echo  json_encode([
                "status" => true
            ]);

            exit();
        }catch(Throwable $e){
            echo json_encode([
                "status" => false,
                "message" => $e->getMessage()
            ]);

            exit();
        }
    }
}
