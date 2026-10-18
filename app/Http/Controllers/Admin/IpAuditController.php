<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\IpAudit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class IpAuditController extends Controller
{
    use JsonResponses;

    public function index(Request $request): View
    {
        $audits = IpAudit::when($request->filled('search'), fn ($q) => $q
            ->where('ip', 'like', "%{$request->search}%")
            ->orWhere('url', 'like', "%{$request->search}%")
            ->orWhere('reason', 'like', "%{$request->search}%"))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.ipauditing', compact('audits'));
    }

    public function update(Request $request, IpAudit $ipauditing): JsonResponse
    {
        $data = $this->check($request, [
            'ip' => ['required', 'ip'],
            'url' => ['required', 'string', 'max:500'],
            'user_agent' => ['required', 'string', 'max:500'],
            'blocked' => ['required', 'boolean'],
            'reason' => ['required', Rule::in(IpAudit::REASONS)],
        ], ['ip' => 'IP', 'url' => 'URL', 'user_agent' => 'User Agent', 'blocked' => 'Is Blocked?', 'reason' => 'Reason']);

        $ipauditing->update($data);

        return $this->ok('IP auditing info updated successfully.');
    }

    public function destroy(IpAudit $ipauditing): JsonResponse
    {
        $ipauditing->delete();

        return $this->ok('IP auditing info deleted successfully.', ['id' => $ipauditing->id]);
    }
}
