<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    protected $fillable = ['admin_id', 'balance'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }




}

