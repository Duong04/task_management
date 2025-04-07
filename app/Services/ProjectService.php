<?php
namespace App\Services;

use App\Models\Project;
use Auth;

class ProjectService {
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

            $project = Project::find($id);
            if (!$project) {
                toastr()->error('Dự án không tồn tại!');
                return redirect()->back();
            }

            $project->update($data);

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