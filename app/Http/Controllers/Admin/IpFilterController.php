<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\IpFilter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IpFilterController extends Controller
{
    use JsonResponses;

    public function index(Request $request): View
    {
        $filters = IpFilter::when($request->filled('search'), fn ($q) => $q
            ->where('ip_address', 'like', "%{$request->search}%")
            ->orWhere('type', 'like', "%{$request->search}%"))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.ipfiltering', compact('filters'));
    }

    public function store(Request $request): JsonResponse
    {
        IpFilter::create($this->payload($request));

        return $this->ok('IP address added successfully.');
    }

    public function update(Request $request, IpFilter $ipfiltering): JsonResponse
    {
        $ipfiltering->update($this->payload($request));

        return $this->ok('IP address updated successfully.');
    }

    public function destroy(IpFilter $ipfiltering): JsonResponse
    {
        $ipfiltering->delete();

        return $this->ok('IP address deleted successfully.', ['id' => $ipfiltering->id]);
    }

    private function payload(Request $request): array
    {
        $data = $this->check($request, [
            'ip_address' => ['required', 'ip'],
            'type' => ['required', 'in:blacklist,whitelist'],
            'C4S' => ['required', 'in:Y,N'],
        ], ['ip_address' => 'IP Address', 'type' => 'Type', 'C4S' => 'Is Active?']);

        return ['ip_address' => $data['ip_address'], 'type' => $data['type'], 'is_active' => $data['C4S'] === 'Y'];
    }
}
