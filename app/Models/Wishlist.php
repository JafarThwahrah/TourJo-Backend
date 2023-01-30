<?php

namespace App\Models;

use App\Models\Tour;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'user_id'
    ];

    public function User()
    {
        return $this->hasMany(User::class);
    }

    public function Tour()
    {
        return $this->hasMany(Tour::class);
    }
}
