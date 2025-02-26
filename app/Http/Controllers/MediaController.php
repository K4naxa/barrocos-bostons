<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function PHPUnit\Framework\isArray;

class MediaController extends Controller
{

    public function create(Request $request)
    {
        return Inertia::render('Management/MediaCreate');
    }
    public function upload(Request $request)
    {
        try {
            $validated = $request->validate([

                'images' => 'requred' | 'array',
                'images.*.image' => 'requred' | 'image' | 'max:10240',
                'images.*.title' => 'required' | 'string' | 'max:255',
                'images.*.alt_text' => 'required' | 'string' | 'max:255',
                'images.*.dog_relationships' => 'array',
                'images.*.dog_relationships.*' => 'exists:dogs,id',
                'images.*.dog_relationships.*.is_secondary' => 'boolean',
                'images.*.dog_relationships.*.is_primary' => 'boolean',
                'images.*.dog_relationships.*.is_public' => 'boolean',
            ]);


            foreach ($validated['images'] as $item) {

                // create application model
                $galleryImage = GalleryImage::create([
                    'is_public' => $item['is_public'] ?? false,
                ]);

                // Attach media to the model
                $media = $galleryImage->addMedia($item['image'])->withCustomProperties([
                    'title' => $item['title'],
                    'alt_text' => $item['alt_text'],
                ])->toMediaGallery('gallery');

                // Check dog assosiations
                if (isset($items['dog_relationships']) && isArray($items['dog_relationships'])) {

                    foreach ($items['dog_relationships'] as $relationship) {

                        $dogId = $relationship['dog_id'];
                        $dog = Dog::find($dogId);

                        // Create the relationship in the pivot table
                        $dog->galleryImages()->attach($galleryImage->id, [
                            'is_secondary' => $relationship['is_secondary'] ?? false,
                        ]);

                        // If this is marked as a primary image, update the dog record
                        if ($relationship['is_primary']) {
                            $dog->update(['primary_image_id' => $galleryImage->id]);
                        }
                    }
                }
            };
        } catch (\Throwable $th) {
            error_log($th);
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload media',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
