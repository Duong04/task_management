<?php 
namespace App\Services;

use App\Models\Task;
use Auth;
use App\Services\FirebaseService;

class TaskService {
    private $firebaseService;
    public function __construct(FirebaseService $firebaseService) {
        $this->firebaseService = $firebaseService;
    }

    public function all() {
        try {
            return Task::all();
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
                        'description' => $attachment['description'] ?? null,
                    ]);
                }
            }
        }

        toastr()->success('Task created successfully!');
        return redirect()->back();
    } catch (\Throwable $th) {
        toastr()->error($th->getMessage());
        return redirect()->back()->withInput(); // giữ lại input cũ
    }
}


    private function generateCode()
    {
        $max_code = Task::max('task_code');

        if ($max_code && is_numeric($max_code)) {
            $nextNumber = (int) $max_code + 1;
            return str_pad($nextNumber, 9, '0', STR_PAD_LEFT);
        }

        return '000000001';
    }

    
}