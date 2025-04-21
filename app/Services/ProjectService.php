<?php
namespace App\Services;

use App\Models\Attachment;
use App\Models\Project;
use Auth;
use App\Services\FirebaseService;
use App\Traits\RoleFormat;


class ProjectService {
    use RoleFormat;
    private $firebaseService;

    public function __construct(FirebaseService $firebaseService) {
        $this->firebaseService = $firebaseService;
    }

    public function all($type = null) {
        try {
            $projects = Project::query();
            $user = auth()->user();
            $role = $this->formatRole($user->role);
            $hasViewAllOrder = collect($role['permissions'])
            ->firstWhere('name', 'Project Management')['actions'] ?? [];


            if ($type) {
                $projects->where('type', $type);
            }

            if ($type == 'user') {
                if (strtoupper($user->role->name) !== 'SUPPER ADMIN' && !collect($hasViewAllOrder)->pluck('value')->contains('viewAll')) {
                    $projects->where('manager_id', $user->id)
                        ->orWhere('created_by', $user->id);
                }
            }else if ($type == 'department') {
                if (strtoupper($user->role->name) !== 'SUPPER ADMIN' && !collect($hasViewAllOrder)->pluck('value')->contains('viewAll')) {
                    $projects->where('department_id', $user->department_id);
                }
            }

            return $projects->get();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function create($request) {
        try {
            $data = $request->validated();

            $data['created_by'] = Auth::user()->id;
            $project = Project::create($data);

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
            $redirect = $request->query('redirect');

            $project = Project::find($id);
            if (!$project) {
                toastr()->error('Dự án không tồn tại!');
                return redirect()->back();
            }

            $project->update($data);

            toastr()->success('Cập nhật dự án thành công!');

            if ($redirect && $redirect == 'back') {
                return redirect()->back();
            }
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