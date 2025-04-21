<?php 
namespace App\Services;

use App\Models\Attachment;
use App\Models\Task;
use Auth;
use App\Services\FirebaseService;
use App\Traits\RoleFormat;

class TaskService {
    use RoleFormat;
    private $firebaseService;
    public function __construct(FirebaseService $firebaseService) {
        $this->firebaseService = $firebaseService;
    }

    public function all($type = null) {
        try {
            $tasks = Task::query();
            $user = auth()->user();
            $role = $this->formatRole($user->role);
            $hasViewAllOrder = collect($role['permissions'])
            ->firstWhere('name', 'Task Management')['actions'] ?? [];


            if ($type) {
                $tasks->where($type, $user->id);
            }else {
                if (strtoupper($user->role->name) !== 'SUPPER ADMIN' && !collect($hasViewAllOrder)->pluck('value')->contains('viewAll')) {
                    $tasks->where('assigned_to', $user->id);
                }
            }

            $tasks = $tasks->orderByDesc('id')->get();

            return $tasks;
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function findById($id) {
        try {
            return Task::find($id);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function create($request)
    {
        try {
            $data = $request->validated();

            $data['created_by'] = Auth::id();
            $data['task_code'] = $this->generateCode();

            $task = Task::create($data);

            if ($request->has('attachments')) {
                foreach ($request->attachments as $index => $attachment) {
                    $file = $request->file("attachments.$index.file");

                    if ($file && $file->isValid()) {
                        $path = $this->firebaseService->uploadFile($file, 'tasks');
                        $task->attachments()->create([
                            'file_path' => $path,
                        ]);
                    }
                }
            }

            toastr()->success('Tạo công việc thành công!');
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back()->withInput(); // giữ lại input cũ
        }
    }

    public function update($request, $id)
    {
        try {
            $data = $request->validated();
            $redirect = $request->query('redirect');

            $task = Task::find($id);

            if (!$task) {
                toastr()->error('Công việc không tồn tại!');
                return redirect()->back();
            }

            $task->update($data);

            if ($request->has('attachments')) {
                foreach ($request->attachments as $index => $attachment) {
                    if (isset($attachment['id'])) {
                        $existingAttachment = Attachment::find($attachment['id']);
                        $file = $request->file("attachments.$index.file");

                        if ($file && $file->isValid()) {
                            $path = $this->firebaseService->uploadFile($file, 'tasks');
                            
                            $existingAttachment->update([
                                'file_path' => $path,
                            ]);
                        }
                    } else {
                        $file = $request->file("attachments.$index.file");
            
                        if ($file && $file->isValid()) {
                            $path = $this->firebaseService->uploadFile($file, 'tasks');
                            
                            $task->attachments()->create([
                                'file_path' => $path,
                                'description' => $attachment['description'] ?? null,
                            ]);
                        }
                    }
                }
            }
            toastr()->success('Cập nhật công việc thành công!');

            if ($redirect && $redirect == 'back') {
                return redirect()->back();
            }
            return redirect()->route('tasks.index');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back()->withInput(); 
        }
    }

    public function delete($id) {
        try {
            $task = Task::find($id);

            if (!$task) {
                toastr()->error('Công việc không tồn tại!');
                return redirect()->back();
            }

            $task->delete();

            toastr()->success('Công việc đã được xóa thành công!');

            return redirect()->route('tasks.index');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function statsByStatus($status = null, $overdue = false, $user = null)
    {
        try {
            $tasks = Task::query();

            if ($status) {
                $tasks->where('status', $status);
            }

            if ($user) {
                $tasks->where('assigned_to', $user);
            }

            if ($overdue) {
                $tasks->where('status', '!=', 'completed')
                          ->whereDate('due_date', '<', now());
            }

            $user_auth = Auth::user();

            if (strtoupper($user_auth->role->name) !== 'SUPPER ADMIN') {
                $tasks->where('assigned_to', $user_auth->id);
            }

            return $tasks->count();
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function quickStats() 
    {
        $user_auth = Auth::user();
        $isSupperAdmin = strtoupper($user_auth->role->name) === 'SUPPER ADMIN';

        $today = now();
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $taskQuery = Task::query();
        $completedQuery = Task::query()->where('status', 'completed');
        
        if (!$isSupperAdmin) {
            $taskQuery->where('assigned_to', $user_auth->id);
            $completedQuery->where('assigned_to', $user_auth->id);
        }

        return [
            'today_tasks' => (clone $taskQuery)->whereDate('due_date', $today)
                                            ->where('status', '!=', 'completed')
                                            ->count(),

            'week_tasks' => (clone $taskQuery)->whereBetween('due_date', [$startOfWeek, $endOfWeek])
                                            ->where('status', '!=', 'completed')
                                            ->count(),

            'month_tasks' => (clone $taskQuery)->whereBetween('due_date', [$startOfMonth, $endOfMonth])
                                            ->where('status', '!=', 'completed')
                                            ->count(),

            'total_tasks' => (clone $taskQuery)->where('status', '!=', 'completed')
                                            ->count(),

            'today_completed' => (clone $completedQuery)->whereDate('updated_at', $today)
                                                        ->count(),

            'week_completed' => (clone $completedQuery)->whereBetween('updated_at', [$startOfWeek, $endOfWeek])
                                                    ->count(),

            'month_completed' => (clone $completedQuery)->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
                                                        ->count(),

            'total_completed' => (clone $completedQuery)->count(),
        ];
    }

    


    private function generateCode()
    {
        $year = date('Y');

        $max_code = Task::where('task_code', 'like', "cv-$year-%")
            ->orderByDesc('task_code')
            ->value('task_code');

        if ($max_code) {
            $lastNumber = (int) substr($max_code, -3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return 'CV-' . $year . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }


    
}