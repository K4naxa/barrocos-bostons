<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Litter extends Model
{
    use HasFactory;

    protected $fillable = ['father_id', 'mother_id', 'breeding_date', 'birth_date', 'description'];

    protected $dates = ['breeding_date', 'birth_date'];

    public function father()
    {
        return $this->belongsTo(Dog::class, 'father_id');
    }

    public function mother()
    {
        return $this->belongsTo(Dog::class, 'mother_id');
    }

    public function puppies()
    {
        return $this->belongsToMany(Dog::class, 'litter_puppies');
    }
}
