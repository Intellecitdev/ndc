<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IssueVoucherItem extends Model
{
    use LogsActivity;

    /** Stock Receive "type" filter values (as in the reference). */
    public const FILTERS = [0 => 'All', 4 => 'Pending', 1 => 'Received', 3 => 'Returned'];

    protected $fillable = ['issue_voucher_id', 'stock_id', 'to_unit_id', 'quantity', 'status', 'actioned_by', 'actioned_at'];

    protected $casts = ['actioned_at' => 'datetime'];

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(IssueVoucher::class, 'issue_voucher_id');
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function actioner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actioned_by');
    }

    public function toUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'to_unit_id');
    }
}
