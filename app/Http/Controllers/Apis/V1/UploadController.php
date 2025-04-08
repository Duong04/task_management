<?php

namespace App\Http\Controllers\Apis\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CloundinaryService;

class UploadController extends Controller
{
    private $cloundinaryService;

    public function __construct(CloundinaryService $cloundinaryService)
    {
        $this->cloundinaryService = $cloundinaryService;
    }

    public function uploadCloundinary(Request $request)
    {
        try {
            $request->validate([
                'upload' => 'required|image',
            ]);
    
            $file = $request->file('upload');
            $result = $this->cloundinaryService->upload($file, 'images');
    
            return response()->json([
                'success' => true,
                'default' => $result,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
