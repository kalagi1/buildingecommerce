<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BankAccount;
class PayController extends Controller
{

    public function index($userId)
    {
        $user = User::find($userId);
        $cart = session()->get('cart', []);
        $bankAccounts = BankAccount::all();
        return view('payment.index', compact('user','cart','bankAccounts'));
    }
}
