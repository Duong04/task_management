<?php
namespace App\Services;

use App\Models\Subtask;
use Auth;
use App\Services\FirebaseService;

class SubtaskService {
    private $firebaseService;

    public function __construct(FirebaseService $firebaseService) {
        $this->firebaseService = $firebaseService;
    }

    public function all() {
        try {
            $subtasks = Subtask::orderByDesc('id');

            return $subtasks->get();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function create($request) {
        try {
            $data = $request->validated();

            $data['created_by'] = Auth::id();

            $task = Subtask::create($data);

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

            toastr()->success('Tạo nhiệm vụ thành công!');
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back()->withInput(); 
        }
    }

    public function delete($id) {
        try {
            $task = Subtask::find($id);

            if (!$task) {
                toastr()->error('Nhiệm vụ không tồn tại!');
                return redirect()->back();
            }

            $task->delete();

            toastr()->success('Nhiệm vụ đã được xóa thành công!');

            return redirect()->route('subtasks.index');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
}