<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name', 'slug', 'country', 'established_year', 'website_url', 'logo_theme', 'status'
    ];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
