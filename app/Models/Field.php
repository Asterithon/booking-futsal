<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price_per_hour',
        'status',
    ];

    public function images()
    {
        return $this->hasMany(FieldImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(FieldImage::class)->where('is_primary', true);
    }

    public function bookings()
{
    return $this->hasMany(Booking::class);
}

}

