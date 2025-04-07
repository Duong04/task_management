<?php 
namespace App\Services;

use App\Models\Action;
use App\Models\PermissionAction;


class ActionService
{
    public function all() {
        try {
            return Action::with('permissionActions')->orderByDesc('id')->get();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function create($request) {
        try {
            $data = $request->validated();

            $action = Action::create($data);

            foreach ($request->input('permissions') as $item) {
                PermissionAction::create([
                    'action_id' => $action->id,
                    'permission_id' => $item
                ]);
            }

            toastr()->success('Hành động đã được tạo thành công!');

            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function findById($id) {
        try {
            return Action::find($id);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function update($request, $id) {
        try {
            $data = $request->validated();

            $action = Action::find($id);

            if (!$action) {
                toastr()->error('Hành động không tồn tại!');
                return redirect()->back();
            }

            PermissionAction::where('action_id', $id)->delete();

            $action->update($data);

            foreach ($request->input('permissions') as $item) {
                PermissionAction::create([
                    'action_id' => $id,
                    'permission_id' => $item
                ]);
            }

            toastr()->success('Hành động đã được cập nhật thành công!');

            return redirect()->route('actions.index');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function delete($id) {
        try {
            $action = Action::find($id);

            if (!$action) {
                toastr()->error('Hành động không tồn tại!');
                return redirect()->back();
            }

            $action->delete();

            toastr()->success('Hành động đã được xóa thành công!');

            return redirect()->route('actions.index');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
}