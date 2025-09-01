<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    public function index() {
        $projects = Project::withCount('issues')->latest()->paginate(10);
        return view('projects.index', compact('projects'));
    }
    public function create() { 
        return view('projects.create');
     }
    public function store(StoreProjectRequest $request) {
        $this->authorize('create', Project::class);

        $project = Project::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('projects.show', $project)
                        ->with('success','Project created');
    }
    public function show(Project $project) {
        $project->load(['issues.tags']);
        $issues = $project->issues()->with('tags')->latest()->paginate(10);
        return view('projects.show', compact('project','issues'));
    }
    public function edit(Project $project) { return view('projects.edit', compact('project')); }
    public function update(UpdateProjectRequest $request, Project $project) {
        $this->authorize('update', $project);
        $project->update($request->validated());
        return redirect()->route('projects.show',$project)->with('success','Updated');
    }
    public function destroy(Project $project) {
        $this->authorize('delete', $project);
        $project->delete();
        return redirect()->route('projects.index')->with('success','Deleted');
    }
}