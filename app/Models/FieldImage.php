<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldImage extends Model
{
    protected $fillable = [
        'field_id',
        'image_path',
        'is_primary',
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
