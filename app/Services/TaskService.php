<?php 
namespace App\Services;

use App\Models\Task;

class TaskService {
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
    
}