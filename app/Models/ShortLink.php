<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'main_url',
        'hash',
        'number',
        'expiry_time',
        'expiry_date',
    ];
}
