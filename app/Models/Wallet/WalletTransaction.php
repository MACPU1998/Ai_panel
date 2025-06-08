<?php

namespace App\Models\Wallet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    protected $fillable = ['wallet_id', 'type', 'amount', 'description','created_by'];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Wallet::class);
    }
    public function creator()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'created_by');
    }


}

