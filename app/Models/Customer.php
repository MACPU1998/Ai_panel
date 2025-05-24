<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Customer extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $table = 'customers';
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'national_id',
        'birth_date',
        'country_id',
        'state_id',
        'city_id',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('customer_images')->singleFile();
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
