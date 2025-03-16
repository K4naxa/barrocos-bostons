<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Image extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['is_public', 'title', 'alt_text'];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('gallery');
    }

    public function registerMediaConversions($media = null): void
    {
        // Thumbnail version
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200)
            ->optimize()
            ->nonQueued();

        // Medium version
        $this->addMediaConversion('medium')
            ->width(800)
            ->height(600)
            ->optimize()
            ->nonQueued();
    }

    public function dogs()
    {
        return $this->belongsToMany(Dog::class, 'dog_images')
            ->using(DogImage::class)
            ->withTimestamps();
    }

    public function primaryFor()
    {
        return $this->hasMany(Dog::class, 'primary_image_id');
    }
}
