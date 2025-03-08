<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    //
    public function showActivityLogs(Request $request)
    {
        // Ambil parameter filter dari request
        $activityType = $request->get('activity_type');

        // Query dasar
        $activityLogs = ActivityLog::with('user')
            ->when($activityType, function ($query) use ($activityType) {
                // Filter berdasarkan jenis aktivitas
                if ($activityType === 'create_account') {
                    $query->where('action', 'like', '%buat akun%');
                } elseif ($activityType === 'login') {
                    $query->where('action', 'like', '%login%');
                } elseif ($activityType === 'update') {
                    $query->where('action', 'like', '%update%');
                } elseif ($activityType === 'export_excel') {
                    $query->where('action', 'like', '%export excel%');
                } elseif ($activityType === 'export_pdf') {
                    $query->where('action', 'like', '%export pdf%');
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Pagination 10 data per halaman

        // Hapus otomatis data yang lebih dari 1 tahun
        $oneYearAgo = Carbon::now()->subYear();
        ActivityLog::where('created_at', '<', $oneYearAgo)->delete();

        return view('admin.activity-logs', compact('activityLogs'));
    }
}
