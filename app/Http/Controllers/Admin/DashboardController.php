<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Chat;
use App\Models\IpAudit;
use App\Models\IpFilter;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        // [label, path|null, colour class, icon, tile colour, count] — same order as the reference.
        $boxes = [
            ['Roles', 'admin/roles', 'text-primary', 'fa-solid fa-user-shield', '#4f46e5', Role::where('slug', '!=', 'superadmin')->count()],
            ['Users', 'admin/users', 'text-info', 'fa-solid fa-users', '#0891b2', User::count()],
            ['Inactive Users', null, 'text-danger', 'fa-solid fa-user-slash', '#dc2626', User::where('status', false)->count()],
            ['Online Users', null, 'text-success', 'fa-solid fa-user-check', '#16a34a', count(User::onlineIds())],
            ['Chats', 'admin/messaging/chats', '', 'fa-solid fa-comments', '#7c3aed', Chat::count()],
            ['Notifications', 'admin/messaging/notifications', '', 'fa-solid fa-bell', '#d97706', DB::table('notifications')->count()],
            ['Tickets', 'admin/messaging/tickets', '', 'fa-solid fa-headset', '#0d9488', Ticket::count()],
            ['Black Listed IP', 'admin/ipfiltering', '', 'fa-solid fa-shield-virus', '#334155', IpFilter::where('type', 'blacklist')->count()],
            ['Blocked Attempts', 'admin/ipauditing', '', 'fa-solid fa-ban', '#e11d48', IpAudit::where('blocked', true)->count()],
            ['Logs', 'admin/logs', 'text-warning', 'fa-solid fa-clock-rotate-left', '#ca8a04', ActivityLog::count()],
        ];

        return view('admin.dashboard', compact('boxes'));
    }
}
