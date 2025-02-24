<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function dogs()
    {
        return $this->belongsToMany(Dog::class, 'dog_titles')
            ->withPivot('date_achieved')
            ->withTimestamps();
    }
}
