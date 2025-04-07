<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use Illuminate\Http\Request;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    private $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        $projects = $this->projectService->all();
        return view('pages.project.index', compact('projects'));
    }

    public function create()
    {
        return view('pages.project.create');
    }

    public function store(ProjectRequest $request)
    {
        return $this->projectService->create($request);
    }

    public function show($id)
    {
        $project = $this->projectService->findById($id);
        if (!$project) {
            abort(404);
        }
        return view('pages.project.update', compact('project'));
    }

    public function update(ProjectRequest $request, $id)
    {
        return $this->projectService->update($request, $id);
    }

    public function delete($id)
    {
        return $this->projectService->delete($id);
    }
}
