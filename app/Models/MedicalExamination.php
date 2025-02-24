<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalExamination extends Model
{
    use HasFactory;

    protected $fillable = ['dog_id', 'examination_type_id', 'date', 'result', 'valid_until'];

    protected $dates = ['date', 'valid_until'];

    public function dog()
    {
        return $this->belongsTo(Dog::class);
    }

    public function examinationType()
    {
        return $this->belongsTo(ExaminationType::class);
    }
}
