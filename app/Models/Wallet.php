<?php


namespace App\Models;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Wallet\WalletTransaction;

class Wallet extends Model
{
    protected $fillable = ['admin_id', 'balance', 'user_id'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }
}

