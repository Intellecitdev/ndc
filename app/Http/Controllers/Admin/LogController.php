<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use App\Support\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class LogController extends Controller
{
    public function index(Request $request): View
    {
        $logs = ActivityLog::with('user')
            ->when($request->filled('Subject'), fn ($q) => $q->where('subject', 'like', "%{$request->Subject}%"))
            ->when($request->filled('StartDate'), fn ($q) => $q->whereDate('created_at', '>=', $request->StartDate))
            ->when($request->filled('EndDate'), fn ($q) => $q->whereDate('created_at', '<=', $request->EndDate))
            ->when($request->filled('UserID'), fn ($q) => $q->where('user_id', $request->UserID))
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.logs', [
            'logs' => $logs,
            'users' => User::whereHas('role', fn ($q) => $q->where('slug', '!=', 'superadmin'))->orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function pdf(ActivityLog $log): Response
    {
        return Pdf::stream('pdf.log', ['log' => $log->load('user')], 'Log Activity Details', 'log-'.$log->id);
    }
}
