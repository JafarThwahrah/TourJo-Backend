<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookedtour extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_id2',
        'tour_price',
        'tour_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
