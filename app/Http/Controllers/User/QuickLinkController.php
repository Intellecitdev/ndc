<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\QuickLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class QuickLinkController extends Controller
{
    /**
     * Admins see everyone's bookmarks (with the owner's name), others only their own.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $quickLinks = QuickLink::with('user')
            ->when(! $user->isAdmin(), fn ($q) => $q->where('user_id', $user->id))
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(fn ($q) => $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('link', 'like', "%{$request->search}%"));
            })
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('user.quicklink', compact('quickLinks'));
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:50'],
            'link' => ['required', 'string', 'max:250', 'regex:'.QuickLink::LINK_PATTERN],
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }

        $quickLink = $request->user()->quickLinks()->create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Bookmark added successfully.',
            'redirect' => $quickLink->safeLink(),
        ]);
    }

    public function update(Request $request, QuickLink $quicklink): JsonResponse
    {
        $this->authorizeOwner($request, $quicklink);

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:50'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }

        $quicklink->update($validator->validated());

        return response()->json(['success' => true, 'message' => 'Bookmark updated successfully.']);
    }

    public function destroy(Request $request, QuickLink $quicklink): JsonResponse
    {
        $this->authorizeOwner($request, $quicklink);
        $quicklink->delete();

        return response()->json(['success' => true, 'message' => 'Bookmark deleted successfully.']);
    }

    private function authorizeOwner(Request $request, QuickLink $quickLink): void
    {
        abort_unless($quickLink->user_id === $request->user()->id || $request->user()->isAdmin(), 403);
    }

    private function failed($errors): JsonResponse
    {
        return response()->json(['success' => false, 'errors' => $errors, 'message' => 'Validation failed.']);
    }
}
