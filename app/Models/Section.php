<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'content', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
