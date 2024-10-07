<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Str; // importa la facciata Str

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;
    
        // Controlla se lo slug esiste già nel database
        while (Project::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    
        return $slug;
    }

    public function store(Request $request)
    {
        // validazione dei campi
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

       //crea lo slug univoco dal titolo
       $slug = $this->generateUniqueSlug($validated['title']);

        // crea il progetto includendo lo slug
        Project::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'slug' =>$slug, // salva lo slug univoco nel database
        ]);

        return redirect()->route('projects.index')->with('success', 'Progetto creato con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //validazione dei campi
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        //Aggiorna i campi del progetto
        $project->title = $validated['title'];
        $project->description = $validated['description'];

        /// genera il nuovo slug univoco dal titolo
        $project->slug = $this->generateUniqueSlug($validated['title']);

        //Salva il progetto aggiornato
        $project->save();

        //Reindirizza dopo l'aggiornamento
        return redirect()->route('projects.index')->with('success', 'Progetto aggiornato con successo!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        // Reindirizza alla lista dei progetti con un messaggio di successo
        return redirect()->route('projects.index')->with('success', 'Progetto eliminato con successo!');
    }
}
