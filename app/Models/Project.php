<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'tools',
        'datastack',
        'icon',
        'repo_link',
        'demo_link',
        'highlights',
    ];

    protected $casts = [
        'tools' => 'array',
        'highlights' => 'array',
    ];

    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('order');
    }
}
