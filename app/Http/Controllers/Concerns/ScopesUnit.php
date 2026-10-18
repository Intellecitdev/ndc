<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;

/**
 * Inventory data belongs to a wing (unit): users work on their own wing's
 * records, Super Admin sees every wing.
 */
trait ScopesUnit
{
    protected function scopeUnit($query, Request $request, string $column = 'unit_id')
    {
        return $request->user()->isSuperAdmin() ? $query : $query->where($column, $request->user()->unit_id);
    }

    protected function ownsUnit(Request $request, ?int $unitId): bool
    {
        return $request->user()->isSuperAdmin() || $unitId === $request->user()->unit_id;
    }
}
