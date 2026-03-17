<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'resume_url',
        'tagline',
        'bio',
    ];
}
