<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nickname',
        'birthday',
        'gender',
        'pedigree_url',
        'group_id',
        'primary_image_id'
    ];

    protected $dates = ['birthday', 'created_at', 'updated_at'];

    public function primaryImage()
    {
        return $this->hasOne(GalleryImage::class, 'id', 'primary_image_id');
    }

    public function secondaryImages()
    {
        return $this->belongsToMany(GalleryImage::class)->withPivot('is_secondary');
    }
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
        return $this->hasMany(Litter::class, 'father_id');
    }

    public function motheredLitters()
    {
        return $this->hasMany(Litter::class, 'mother_id');
    }

    /**
     * Get all gallery images for the dog.
     */
    public function galleryImages()
    {
        return $this->belongsToMany(GalleryImage::class, 'dog_gallery_image')
            ->withPivot('is_secondary')
            ->withTimestamps();
    }

    /**
     * Get a URL for the dog's primary image.
     */
    public function getPrimaryImageUrlAttribute()
    {
        if ($this->primaryImage && $this->primaryImage->getFirstMedia('gallery')) {
            return $this->primaryImage->getFirstMedia('gallery')->getUrl();
        }

        return null; // Return default image URL or null
    }

    /**
     * Get thumbnail URLs for the dog's gallery images.
     */
    public function getGalleryThumbnailsAttribute()
    {
        return $this->secondaryImages->map(function ($image) {
            if ($image->getFirstMedia('gallery')) {
                return [
                    'id' => $image->id,
                    'url' => $image->getFirstMedia('gallery')->getUrl('thumbnail'),
                    'title' => $image->getFirstMedia('gallery')->getCustomProperty('title'),
                ];
            }
            return null;
        })->filter();
    }
}
