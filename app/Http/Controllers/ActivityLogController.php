<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Exports\ActivityLogExport;
use Maatwebsite\Excel\Facades\Excel;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        // Filter berdasarkan log type
        if ($request->log_type) {
            $query->where('log_type', $request->log_type);
        }

        // Filter berdasarkan tanggal
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where('pesan', 'like', '%' . $search . '%');
        }

        $activityLogs = $query->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('activity-log.index', compact('activityLogs'));
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        $filters = [
            'log_type' => $request->log_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        return Excel::download(new ActivityLogExport($filters), 'activity-log-' . date('Y-m-d-H-i-s') . '.xlsx');
    }
}
