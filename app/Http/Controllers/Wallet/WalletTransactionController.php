<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

use App\Models\Wallet\WalletTransaction;
class WalletTransactionController extends Controller
{
    //
    public function index(Customer $customer)
    {
        $transactions = $customer->wallet?->transactions()->latest()->get();
        return view('admin.wallet.transactions.index', compact('customer', 'transactions'));
    }

}
