<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dog_gallery_images', function (Blueprint $table) {
            $table->foreignId('dog_id')->constrained('dogs');
            $table->foreignId('gallery_image_id')->constrained('gallery_images');
            $table->boolean('is_secondary')->default(false);
            $table->primary(['dog_id', 'gallery_image_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dog_gallery_images');
    }
};
