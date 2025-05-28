<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
    ];

    public static function getValue(string $key, $default = null)
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function setValue(string $key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
