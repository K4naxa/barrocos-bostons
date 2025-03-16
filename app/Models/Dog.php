<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nickname',
        'birthday',
        'gender',
        'breed',
        'pedigree_url',
        'group_id',
        'primary_image_id'
    ];

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

    public function fatheredLitters()
    {
        return $this->hasMany(Litter::class, 'father_id', 'id');
    }

    public function motheredLitters()
    {
        return $this->hasMany(Litter::class, 'mother_id', 'id');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(Image::class, 'id', 'primary_image_id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'dog_images')
            ->using(DogImage::class)
            ->withPivot(['is_secondary'])
            ->withTimestamps();
    }

    public function secondaryImages()
    {
        return $this->images()->wherePivot('is_secondary', true);
    }
}
