<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_link_id',
        'location',
        'latitude',
        'longitude',
        'ip',
        'os',
        'browser',
        'device',
        'country'
    ];

    protected $casts = [
        'location' => 'object',
    ];


    public function shortlink()
    {
        return $this->belongsTo(ShortLink::class, 'short_link_id');
    }
}
