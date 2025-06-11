<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletTransaction extends Model
{
    use HasFactory,softDeletes;
    protected $table = 'wallet_transactions';
    protected $fillable = [
        'admin_id',
        'wallet_id',
        'type',
        'amount',
        'description'
    ];

    public function wallet(){
        return $this->belongsTo(Wallet::class);
    }
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
