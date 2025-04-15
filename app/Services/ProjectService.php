<?php
namespace App\Services;

use App\Models\Attachment;
use App\Models\Project;
use Auth;
use App\Services\FirebaseService;


class ProjectService {
    private $firebaseService;

    public function __construct(FirebaseService $firebaseService) {
        $this->firebaseService = $firebaseService;
    }

    public function all() {
        try {
            return Project::all();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function create($request) {
        try {
            $data = $request->validated();

            $project = Project::create($data);

            if ($request->has('attachments')) {
                foreach ($request->attachments as $index => $attachment) {
                    $file = $request->file("attachments.$index.file");

                    if ($file && $file->isValid()) {
                        $path = $this->firebaseService->uploadFile($file, 'tasks');
                        $project->attachments()->create([
                            'file_path' => $path,
                        ]);
                    }
                }
            }

            toastr()->success('Tạo dự án thành công!');
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function findById($id) {
        try {
            return Project::find($id);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function update($request, $id) {
        try {
            $data = $request->validated();

            $project = Project::find($id);
            if (!$project) {
                toastr()->error('Dự án không tồn tại!');
                return redirect()->back();
            }

            $project->update($data);

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
                            
                            $project->attachments()->create([
                                'file_path' => $path,
                                'description' => $attachment['description'] ?? null,
                            ]);
                        }
                    }
                }
            }

            toastr()->success('Cập nhật dự án thành công!');
            return redirect()->route('projects.index');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function delete($id) {
        try {
            $project = Project::find($id);
            if (!$project) {
                toastr()->error('Dự án không tồn tại!');
                return redirect()->back();
            }

            $project->delete();

            toastr()->success('Xóa dự án thành công!');
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
}