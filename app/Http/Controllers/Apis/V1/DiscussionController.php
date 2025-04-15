<?php

namespace App\Http\Controllers\Apis\V1;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Discussion;
use App\Models\Task;

class DiscussionController extends Controller
{
    public function getDiscussions(Request $request, $id)
    {
        try {
            $type = $request->query('type', 'task');
            $messages = [];

            $modelClass = match ($type) {
                'task' => Task::class,
                'project' => Project::class,
                default => null,
            };

            if ($modelClass) {
                $messages = Discussion::with('user')->where('discussionable_type', $modelClass)
                    ->where('discussionable_id', $id)
                    ->orderByDesc('created_at')
                    ->get();
            }

            return response()->json(['data' => $messages], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function create(Request $request) {
        try {
            $data = $request->validate([
                'type' => 'required',
                'id' => 'required',
                'message' => 'required|string',
                'user_id' => ''
            ]);
    
            $discussion = '';
            if ($data['type'] == 'task') {
                $discussion = Task::find($data['id']);
            }else if ($data['type'] == 'project') {
                $discussion = Project::find($data['id']);
            }
    
            $discussion->discussions()->create($data);
    
            return response()->json(['message' => 'Created discussion successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function delete($id) {
        try {
            $discussion = Discussion::find($id);
            $discussion->delete();
            return response()->json(['message' => 'Delete discussion successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

}
