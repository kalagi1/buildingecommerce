<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function getBankAccount($id){
        $bankAccount = BankAccount::where('id',$id)->first();

        return $bankAccount;
    }
}
