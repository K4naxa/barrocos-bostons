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
        Schema::create('dogs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nickname');
            $table->date('birthday');
            $table->string('breed');
            $table->enum('gender', ['male', 'female']);
            $table->foreignId('primary_image_id')->nullable()->constrained('images')->nullOnDelete();
            $table->string('pedigree_url')->nullable();
            $table->foreignId('group_id')->constrained('dog_group_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('dogs');


        Schema::enableForeignKeyConstraints();
    }
};
