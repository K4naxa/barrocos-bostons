<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExaminationType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function medicalExaminations()
    {
        return $this->hasMany(MedicalExamination::class);
    }
}
