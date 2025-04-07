<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
use Illuminate\Http\Request;
use App\Services\PositionService;

class PositionController extends Controller
{
    private $positionService;

    public function __construct(PositionService $positionService)
    {
        $this->positionService = $positionService;
    }

    public function index()
    {
        $positions = $this->positionService->all();
        return view('pages.position.index', compact('positions'));
    }

    public function create()
    {
        return view('pages.position.create');
    }

    public function store(PositionRequest $request) {
        return $this->positionService->create($request);
    }

    public function show($id) {
        $position = $this->positionService->findById($id);

        if (!$position) {
            abort(404);
        }

        return view('pages.position.update', compact('position'));
    }

    public function update(PositionRequest $request, $id) {
        return $this->positionService->update($request, $id);
    }
    public function delete($id) {
        return $this->positionService->delete($id);
    }
}
