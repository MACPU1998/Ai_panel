<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'wallets';
    protected $fillable = [
        'customer_id',
        'balance',
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function walletTransactions(){
        return $this->hasMany(WalletTransaction::class);
    }
}
