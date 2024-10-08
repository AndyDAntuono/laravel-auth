<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Method to generate a unique slug for a project based on the title.
     *
     * @param  string  $title
     * @param  Project|null $project (optional)
     * @return string
     */
    private function generateUniqueSlug($title, Project $project = null)
    {
        $slug = Str::slug($title); // Crea lo slug di base
        $originalSlug = $slug;
        $counter = 1;

        // Verifica se lo slug esiste già (escludendo l'ID del progetto in caso di aggiornamento)
        if ($project) {
            while (Project::where('slug', $slug)->where('id', '!=', $project->id)->exists()) {
                $slug = $originalSlug . '-' . $counter; // Aggiunge un numero incrementale se esiste già
                $counter++;
            }
        } else {
            while (Project::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter; // Aggiunge un numero incrementale se esiste già
                $counter++;
            }
        }

        return $slug;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validazione dei dati in ingresso, inclusa l'immagine
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048', // Aggiunto campo immagine, opzionale, con massimo 2MB
        ]);
    
        // Genera uno slug unico dal titolo
        $slug = $this->generateUniqueSlug($validated['title']);
    
        // Gestione dell'upload immagine
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); // Salva l'immagine nella cartella storage/app/public/images
        }
    
        // Crea il progetto con lo slug univoco e l'immagine
        Project::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'slug' => $slug,
            'image' => $imagePath, // Salva il percorso dell'immagine
        ]);
    
        return redirect()->route('projects.index')->with('success', 'Progetto creato con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        // Validazione dei dati
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048', // Aggiunto campo immagine, opzionale
        ]);
    
        // Verifica se il titolo è stato modificato e aggiorna lo slug solo se necessario
        if ($project->title !== $validated['title']) {
            $project->slug = $this->generateUniqueSlug($validated['title']);
        }
    
        // Gestione dell'upload immagine
        if ($request->hasFile('image')) {
            // Elimina l'immagine precedente se esiste
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
        
            // Carica la nuova immagine
            $project->image = $request->file('image')->store('images', 'public');
        }
    
        // Aggiorna i dati del progetto
        $project->title = $validated['title'];
        $project->description = $validated['description'];
    
        // Salva le modifiche nel database
        $project->save();
    
        return redirect()->route('projects.index')->with('success', 'Progetto aggiornato con successo!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Progetto eliminato con successo!');
    }
}
