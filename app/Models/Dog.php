<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'nickname', 'birthday', 'gender', 'pedigree_url', 'group_id'];

    protected $dates = ['birthday', 'created_at', 'updated_at'];

    public function group()
    {
        return $this->belongsTo(DogGroupType::class, 'group_id');
    }
    public function owners()
    {
        return $this->hasMany(DogOwner::class);
    }

    public function medicalExaminations()
    {
        return $this->hasMany(MedicalExamination::class);
    }

    public function titles()
    {
        return $this->belongsToMany(Title::class, 'dog_titles')
            ->withPivot('date_achieved')
            ->withTimestamps();
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function fatheredLitters()
    {
        return $this->hasMany(Litter::class, 'father_id');
    }

    public function motheredLitters()
    {
        return $this->hasMany(Litter::class, 'mother_id');
    }
}
