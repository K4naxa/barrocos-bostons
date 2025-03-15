<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Image;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function PHPUnit\Framework\isArray;

class MediaController extends Controller
{

    public function create(Request $request)
    {
        $dogs = Dog::select('id', 'name', 'nickname')->get();
        return Inertia::render('Management/MediaCreate', [
            'dogs' => $dogs
        ]);
    }
    public function upload(Request $request)
    {
        try {
            $validated = $request->validate([

                'images' => 'required|array',
                'images.*.image' => 'required|image|max:10240',
                'images.*.title' => 'required|string|max:255',
                'images.*.alt_text' => 'required|string|max:255',
                'images.*.dog_relationships' => 'array',
                'images.*.dog_relationships.*' => 'exists:dogs,id',
                'images.*.dog_relationships.*.is_secondary' => 'boolean',
                'images.*.dog_relationships.*.is_primary' => 'boolean',
                'images.*.dog_relationships.*.is_public' => 'boolean',
            ]);

            $uploadedImages = [];

            foreach ($validated['images'] as $item) {

                // create application model
                $image = Image::create([
                    'title' => $item['title'],
                    'alt_text' => $item['alt_text'],
                    'is_public' => $item['is_public'] ?? false,
                ]);

                if (isset($item['image']) && $item['image']) {
                    $image->addMedia($item['image'])
                        ->toMediaCollection('gallery');
                }

                $uploadedImages[] = [
                    'id' => $image->id,
                    'title' => $image->title,
                    'alt_text' => $image->alt_text,
                    'is_public' => $image->is_public,
                    'urls' => [
                        'original' => $image->getFirstMediaUrl('gallery'),
                        'thumb' => $image->getFirstMediaUrl('gallery', 'thumb'),
                        'medium' => $image->getFirstMediaUrl('gallery', 'medium'),
                    ]
                ];




                // Check dog assosiations
                // if (isset($item['dog_relationships']) && isArray($item['dog_relationships'])) {

                //     foreach ($item['dog_relationships'] as $relationship) {

                //         $dogId = $relationship['dog_id'];
                //         $dog = Dog::find($dogId);

                //         // Create the relationship in the pivot table
                //         $dog->galleryImages()->attach($galleryImage->id, [
                //             'is_secondary' => $relationship['is_secondary'] ?? false,
                //         ]);

                //         // If this is marked as a primary image, update the dog record
                //         if ($relationship['is_primary']) {
                //             $dog->update(['primary_image_id' => $galleryImage->id]);
                //         }
                //     }
                // }
            };

            return response()->json([
                'success' => true,
                'images' => $uploadedImages
            ]);
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
