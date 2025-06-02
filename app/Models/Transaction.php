<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = ['wallet_id', 'type', 'amount', 'description'];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

}
