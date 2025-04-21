<?php

namespace App\Http\Controllers\Apis\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function taskStatsByTime(Request $request)
    {
        try {
            $year = $request->input('year');
            $month = $request->input('month');
            $user = $request->input('user');
            $user_id = $request->input('user_id');
            $role = $request->input('role');

            if ($month && $year) {
                $query = Task::selectRaw('DAY(created_at) as day, COUNT(*) as total')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month);

                if (strtoupper($role) !== 'SUPPER ADMIN') {
                    $query->where('assigned_to',  $user_id);
                }

                if ($user) {
                    $query->where('assigned_to',  $user);
                }

                $tasks = $query->groupBy(DB::raw('DAY(created_at)'))
                    ->pluck('total', 'day'); 

                $daysInMonth = Carbon::create($year, $month)->daysInMonth;

                $dailyData = [];
                for ($i = 1; $i <= $daysInMonth; $i++) {
                    $dailyData[] = $tasks[$i] ?? 0;
                }

                return response()->json([
                    'type' => 'month',
                    'labels' => range(1, $daysInMonth),
                    'data' => $dailyData,
                ]);
            }
            elseif ($year) {
                $query = Task::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                    ->whereYear('created_at', $year);

                if (strtoupper($role) !== 'SUPPER ADMIN') {
                    $query->where('assigned_to', $user_id);
                }

                if ($user) {
                    $query->where('assigned_to', $user);
                }

                $tasks = $query->groupBy(DB::raw('MONTH(created_at)'))
                    ->pluck('total', 'month'); 

                $monthlyData = [];
                for ($i = 1; $i <= 12; $i++) {
                    $monthlyData[] = $tasks[$i] ?? 0;
                }

                return response()->json([
                    'type' => 'year',
                    'labels' => [
                        "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
                        "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
                    ],
                    'data' => $monthlyData,
                ]);
            }

            return response()->json(['error' => 'Thiếu tham số year'], 400);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

}
