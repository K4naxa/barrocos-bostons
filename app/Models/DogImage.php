<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DogImage extends Pivot
{
    protected $table = 'dog_images';
    protected $fillable = [
        'dog_id',
        'image_id',
        'is_secondary'
    ];

    protected $casts = [
        'is_secondary' => 'boolean',
    ];
}
