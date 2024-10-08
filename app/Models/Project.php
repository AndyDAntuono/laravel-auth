<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'slug', 'image'];

    // Hook per generare lo slug automaticamente alla creazione del progetto
    protected static function boot()
    {
        parent::boot();

        // Genera lo slug quando viene creato un nuovo progetto
        static::creating(function ($project) {
            $project->slug = Str::slug($project->title);
        });

        // Se il titolo viene modificato, aggiorna anche lo slug
        static::updating(function ($project) {
            $project->slug = Str::slug($project->title);
        });
    }
}
