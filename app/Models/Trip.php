<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'organizer_id',
        'title',
        'destination',
        'date',
        'price',
        'quota',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function organizer()
    {
        return $this->belongsTo(Organizers::class, 'organizer_id');
    }

    public function bookings()
    {
        return $this->hasMany(Bookings::class, 'trip_id');
    }
}