<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Stock;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Purchase orders, receives, stock and issue vouchers exported read-only from the
 * reference system (data/reference_transactions.json), keeping the reference IDs,
 * creators and timestamps.
 */
class ReferenceTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $data = json_decode(file_get_contents(__DIR__.'/data/reference_transactions.json'), true);
        $unit = fn (string $name) => Unit::where('name', $name)->value('id');
        $user = fn (string $fullName) => User::where('full_name', $fullName)->value('id');
        $item = fn (string $code) => Item::where('code', $code)->value('id');

        DB::transaction(function () use ($data, $unit, $user, $item) {
            $poLines = [];
            foreach ($data['purchase_orders'] as $po) {
                $by = $user($po['created_by']);
                DB::table('purchase_orders')->insert([
                    'id' => $po['id'], 'po_no' => $po['po_no'], 'date' => $po['date'], 'unit_id' => $unit($po['unit']),
                    'supplier_id' => $po['supplier_id'], 'financial_year_id' => $po['financial_year_id'], 'reference_no' => $po['reference_no'],
                    'priority' => $po['priority'], 'comments' => $po['comments'], 'status' => true,
                    'created_by' => $by, 'updated_by' => $by, 'created_at' => $po['created_at'], 'updated_at' => $po['created_at'],
                ]);
                foreach ($po['items'] as $line) {
                    $poLines[$po['id']][$line['item_id']] = DB::table('purchase_order_items')->insertGetId([
                        'purchase_order_id' => $po['id'], 'item_id' => $line['item_id'], 'order_qty' => $line['qty'], 'received_qty' => 0,
                        'created_at' => $po['created_at'], 'updated_at' => $po['created_at'],
                    ]);
                }
            }

            foreach ($data['receives'] as $rc) {
                $by = $user($rc['created_by']);
                $unitId = $unit($rc['unit']);
                DB::table('purchase_receives')->insert([
                    'id' => $rc['id'], 'invoice_no' => $rc['invoice_no'], 'date' => $rc['date'], 'unit_id' => $unitId,
                    'supplier_id' => $rc['supplier_id'], 'purchase_order_id' => $rc['po_id'],
                    'financial_year_id' => collect($data['purchase_orders'])->firstWhere('id', $rc['po_id'])['financial_year_id'],
                    'received_qty' => $rc['received_qty'], 'status' => true,
                    'created_by' => $by, 'updated_by' => $by, 'created_at' => $rc['created_at'], 'updated_at' => $rc['created_at'],
                ]);
                foreach (collect($rc['items'])->groupBy('code') as $code => $lines) {
                    $itemId = $item($code);
                    $poItemId = $poLines[$rc['po_id']][$itemId];
                    $qty = $lines->sum('qty');
                    $receiveItemId = DB::table('purchase_receive_items')->insertGetId([
                        'purchase_receive_id' => $rc['id'], 'purchase_order_item_id' => $poItemId, 'item_id' => $itemId, 'quantity' => $qty,
                        'created_at' => $rc['created_at'], 'updated_at' => $rc['created_at'],
                    ]);
                    DB::table('purchase_order_items')->where('id', $poItemId)->increment('received_qty', $qty);
                    foreach ($lines as $s) {
                        DB::table('stocks')->insert([
                            'id' => $s['stock_id'], 'unit_id' => $unitId, 'item_id' => $itemId, 'purchase_receive_id' => $rc['id'],
                            'purchase_receive_item_id' => $receiveItemId, 'supplier_id' => $rc['supplier_id'], 'serial_no' => $s['serial'],
                            'quantity' => $s['qty'], 'status' => Stock::IN_STOCK, 'coverage_type' => $s['type'], 'coverage_start' => $s['start'],
                            'duration' => $s['duration'], 'duration_type' => $s['duration_type'], 'coverage_end' => $s['end'],
                            'created_by' => $by, 'updated_by' => $by, 'created_at' => $rc['created_at'], 'updated_at' => $rc['created_at'],
                        ]);
                    }
                }
            }

            foreach ($data['issue_vouchers'] as $iv) {
                $by = $user($iv['issued_by']);
                $voucherId = DB::table('issue_vouchers')->insertGetId([
                    'id' => $iv['ref_id'],
                    'iv_no' => $iv['iv_no'], 'date' => $iv['date'], 'from_unit_id' => $unit($iv['from_unit']),
                    'created_by' => $by, 'updated_by' => $by, 'created_at' => $iv['created_at'], 'updated_at' => $iv['created_at'],
                ]);
                foreach ($iv['items'] as $line) {
                    $stockId = DB::table('stocks')->where('serial_no', $line['serial'])->value('id');
                    DB::table('issue_voucher_items')->insert([
                        'issue_voucher_id' => $voucherId, 'stock_id' => $stockId, 'to_unit_id' => $unit($line['to_unit']),
                        'quantity' => $line['qty'], 'status' => $line['status'], 'created_at' => $iv['created_at'], 'updated_at' => $iv['created_at'],
                    ]);
                    if ($line['status'] === 'Pending') {
                        DB::table('stocks')->where('id', $stockId)->update(['status' => Stock::TRANSFERRED]);
                    }
                }
            }
        });
    }
}
