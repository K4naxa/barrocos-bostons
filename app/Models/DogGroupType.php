<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DogGroupType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function dogs()
    {
        return $this->hasMany(Dog::class, 'group_id');
    }
}
