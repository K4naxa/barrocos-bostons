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
        Schema::create('dog_titles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dog_id')->constrained()->onDelete('cascade');
            $table->foreignId('title_type_id')->constrained()->onDelete('cascade');
            $table->date('date_achieved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dog_titles');
    }
};
