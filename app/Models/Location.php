<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    use NodeTrait;

    protected $guarded = [];

    protected $fillable = [
        'name',
        'user_id',
        'team_id',
        'id',
        'hidden',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
