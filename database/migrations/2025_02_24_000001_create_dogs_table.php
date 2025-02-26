<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dogs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nickname');
            $table->date('birthday');
            $table->enum('gender', ['male', 'female']);
            $table->string('pedigree_url')->nullable();
            $table->foreignId('primary_image_id')->nullable()->constrained('gallery_images');
            $table->foreignId('group_id')->constrained('dog_group_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dogs', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
        });
        Schema::dropIfExists('dogs');
    }
};
