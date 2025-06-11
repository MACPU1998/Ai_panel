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
        'admin_id',
        'balance',
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
}
