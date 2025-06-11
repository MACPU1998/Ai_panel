<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory,softDeletes;
    protected $table = 'transactions';
    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'description'
    ];

    public function wallet(){
        return $this->belongsTo(Wallet::class);
    }
}
