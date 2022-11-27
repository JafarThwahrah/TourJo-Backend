<?php

namespace App\Models;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Destination extends Model
{
    use HasFactory;

    public function tour()
    {
        return $this->hasMany(Tour::class, 'foreign_key', 'destination_id');
    }
}
