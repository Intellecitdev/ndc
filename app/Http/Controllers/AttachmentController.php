<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

/**
 * Private uploads (PO scan copies, ticket attachments) are served only through here,
 * after the same checks as the pages that show them. Direct /storage URLs are blocked
 * by storage/app/public/.htaccess.
 */
class AttachmentController extends Controller
{
    public function purchaseOrder(Request $request, PurchaseOrder $purchaseorder): Response
    {
        $user = $request->user();
        // Purchase Orders page, or the QM approval page that shows the scan copy.
        abort_unless($user->canMenu('inventory/purchase/purchaseorders') || $user->canMenu('inventory/approvals'), 403);
        abort_unless($user->isSuperAdmin() || $purchaseorder->unit_id === $user->unit_id, 404);

        return $this->serve($purchaseorder->attachment);
    }

    public function ticket(Request $request, Ticket $ticket): Response
    {
        $user = $request->user();
        abort_unless($ticket->user_id === $user->id || $user->canMenu('admin/messaging/tickets'), 403);

        return $this->serve($ticket->attachment);
    }

    private function serve(?string $path): Response
    {
        abort_unless($path && Storage::disk('public')->exists($path), 404);

        return Storage::disk('public')->response($path, basename($path), [
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
