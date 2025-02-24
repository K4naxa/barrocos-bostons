<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // create_litter_puppies_table.php
    public function up()
    {
        Schema::create('litter_puppies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('litter_id')->constrained()->onDelete('cascade');
            $table->foreignId('dog_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
