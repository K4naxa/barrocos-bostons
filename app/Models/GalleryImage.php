<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = ['is_public', 'title', 'alt_text'];

    public function dogs()
    {
        return $this->belongsToMany(Dog::class)
            ->withPivot('is_secondary')
            ->withTimestamps();
    }

    public function registerMediaConversions($media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300);

        $this->addMediaConversion('medium')
            ->width(800)
            ->height(600);
    }
}
