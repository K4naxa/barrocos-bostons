<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DogOwner extends Model
{
    protected $fillable = ['dog_id', 'owner_name'];
}
