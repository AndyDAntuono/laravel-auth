<?php

namespace App\Models;  // Aggiungi questo per specificare il namespace corretto

use Illuminate\Database\Eloquent\Factories\HasFactory; // Importa HasFactory
use Illuminate\Database\Eloquent\Model; // Importa Model
use Illuminate\Support\Str; // Importa Str per generare lo slug

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

    // Accedi al percorso completo dell'immagine
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
