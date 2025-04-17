<?php 
namespace App\Services;

use App\Models\Attachment;
use App\Models\Task;
use Auth;
use App\Services\FirebaseService;

class TaskService {
    private $firebaseService;
    public function __construct(FirebaseService $firebaseService) {
        $this->firebaseService = $firebaseService;
    }

    public function all($type = null) {
        try {
            $tasks = Task::query();
            $user = auth()->user();

            if (strtoupper($user->role->name) !== 'SUPPER ADMIN') {
                $tasks->where('assigned_to', $user->id);
            }

            if ($type) {
                $tasks->where($type, $user->id);
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