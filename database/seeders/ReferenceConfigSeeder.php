<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Imports the configuration data exported from the reference (old) system
 * (database/seeders/data/reference_config.json), keeping the original IDs so
 * records match one-to-one.
 */
class ReferenceConfigSeeder extends Seeder
{
    public function run(): void
    {
        $d = json_decode(file_get_contents(__DIR__.'/data/reference_config.json'), true);
        $yn = fn ($v) => $v === 'Y' || $v === '1';
        $now = now();
        $rows = fn (array $list, callable $map) => array_map(fn ($r) => $map($r) + ['created_at' => $now, 'updated_at' => $now], $list);

        DB::table('units')->insert($rows($d['units'], fn ($r) => [
            'id' => $r['id'], 'code' => $r['code'], 'name' => $r['unit'], 'address' => $r['address'] ?: null,
            'type' => ['1' => 'Wing', '2' => 'Unit', '3' => 'Division'][$r['type']] ?? 'Wing',
            'order' => $r['order'], 'status' => $yn($r['status']),
        ]));

        DB::table('ranks')->insert($rows($d['ranks'], fn ($r) => [
            'id' => $r['id'], 'short' => $r['code'] ?: null, 'name' => trim($r['rank']), 'order' => $r['order'], 'status' => $yn($r['status']),
        ]));

        DB::table('suppliers')->insert($rows($d['suppliers'], fn ($r) => [
            'id' => $r['id'], 'code' => $r['code'], 'name' => $r['supplier'], 'contact_person' => $r['contactperson'],
            'contact_no' => $r['contactno'], 'email' => $r['email'], 'address' => $r['address'] ?: null, 'status' => $yn($r['status']),
        ]));

        DB::table('parent_categories')->insert($rows($d['parentcategories'], fn ($r) => [
            'id' => $r['id'], 'name' => $r['category'], 'status' => $yn($r['status']),
        ]));

        DB::table('categories')->insert($rows($d['categories'], fn ($r) => [
            'id' => $r['id'], 'parent_category_id' => $r['parent'], 'name' => $r['category'], 'description' => $r['desc'] ?: null, 'status' => $yn($r['status']),
        ]));

        DB::table('brands')->insert($rows($d['brands'], fn ($r) => [
            'id' => $r['id'], 'category_id' => $r['category'], 'name' => $r['brand'], 'description' => $r['description'] ?: null, 'status' => $yn($r['status']),
        ]));

        DB::table('product_models')->insert($rows($d['models'], fn ($r) => [
            'id' => $r['id'], 'category_id' => $r['category'], 'brand_id' => $r['brand'], 'name' => $r['model'], 'status' => $yn($r['status']),
        ]));

        DB::table('item_units')->insert($rows($d['itemunits'], fn ($r) => [
            'id' => $r['id'], 'code' => $r['code'], 'name' => $r['unit'], 'status' => $yn($r['status']),
        ]));

        DB::table('financial_years')->insert($rows($d['financialyears'], fn ($r) => [
            'id' => $r['id'], 'name' => $r['name'], 'is_current' => $yn($r['current']), 'status' => $yn($r['status']),
        ]));

        $id = fn ($v) => $v === '' || $v === null ? null : (int) $v;
        DB::table('items')->insert($rows($d['items'], fn ($r) => [
            'id' => $r['id'], 'parent_category_id' => $r['ParentCatID'], 'category_id' => $r['CategoryID'],
            'brand_id' => $id($r['BrandID']), 'product_model_id' => $id($r['ModelID']), 'port_id' => $id($r['PortID']),
            'layer_id' => $id($r['LayerID']), 'capacity_id' => $id($r['CapacityID']), 'item_unit_id' => $r['UnitID'],
            'code' => $r['Code'], 'name' => $r['Name'], 'description' => $r['Description'] ?: null,
            'has_warranty' => $yn($r['Warranty']), 'is_consumable' => $yn($r['Consumable']), 'is_license' => $yn($r['License']),
            'status' => $yn($r['C4S']),
        ]));
    }
}
