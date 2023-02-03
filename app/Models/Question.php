<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',
        'user_email',
        'subject',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
