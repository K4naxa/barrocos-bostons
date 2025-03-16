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
        Schema::create('medical_examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dog_id')->constrained()->onDelete('cascade');
            $table->foreignId('examination_type_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->text('result');
            $table->date('valid_until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_examinations');
    }
};
