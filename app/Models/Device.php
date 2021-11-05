<?php

namespace App\Models;

use App\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'body',
        'user_id',
        'location_id',
        'hidden',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function team()
    {
        return $this->hasManyThrough(Team::class, Location::class);
    }
}
