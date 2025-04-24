<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';
    protected $fillable = ['title', 'icon', 'parent_id', 'link', 'status'];

    protected array $dates
        = [
            'created_at',
            'updated_at',
        ];

    protected $casts = [
        "parent_id" => "int",
        "status" => "integer"
    ];

    //رابطه منو با parent
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

}
