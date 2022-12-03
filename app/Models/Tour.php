<?php

namespace App\Models;

use App\Models\User;
use App\Models\Destination;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tour extends Model
{
    use HasFactory;
    use SoftDeletes;



    protected $fillable = [
        'destination_id',
        'user_id',
        'tour_price',
        'tour_description',
        'tour_route',
        'tour_date',
        'hero_img',
        'img_1',
        'img_2',
        'img_3',
        'img_4',
        'advisor_contact_number'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'foreign_key', 'destination_id');
    }
}
