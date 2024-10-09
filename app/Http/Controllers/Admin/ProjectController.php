<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validazione dell'immagine
        ]);



        // Gestisci il file immagine se presente
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
        } else {
            $imagePath = null; // Nessuna immagine caricata
        }

        // Crea il nuovo progetto con lo slug e l'immagine
        $project = Project::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'slug' => $this->generateUniqueSlug($validated['title']),
            'image' => $imagePath,
        ]);

        return redirect()->route('projects.index')->with('success', 'Progetto creato con successo!');
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
        // Validazione dei dati in ingresso, inclusa l'immagine
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // validazione dell'immagine
        ]);

        // Gestisci il file immagine se presente
        if ($request->hasFile('image')) {
            // Elimina la vecchia immagine, se esiste
            if ($project->image) {
                Storage::delete($project->image);
            }

            // Salva la nuova immagine
            $imagePath = $request->file('image')->store('public/images');
            $project->image = $imagePath;
        }

        // Aggiorna gli altri campi
        $project->title = $validated['title'];
        $project->description = $validated['description'];
        $project->slug = $this->generateUniqueSlug($validated['title']);

        // Salva le modifiche
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
