<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $taskService;
    public function __construct(TaskService $taskService) {
        $this->taskService = $taskService;
    }
    public function index() {
        $task_status_completed = $this->taskService->statsByStatus('completed');
        $task_status_not_started = $this->taskService->statsByStatus('not_started');
        $task_status_in_progress = $this->taskService->statsByStatus('in_progress');
        $task_overdue = $this->taskService->statsByStatus(null, true);

        $task_stats = $this->taskService->quickStats();
        return view('pages/dashboard.index', compact('task_status_completed', 'task_status_not_started', 'task_status_in_progress', 'task_overdue', 'task_stats'));
    }
}
