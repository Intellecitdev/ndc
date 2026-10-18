<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\ItemUnit;
use App\Models\ParentCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Sanitary, Carpenter and Electric store items (264, from the paper item lists).
 * Each list gets its own parent category + category; codes follow the list order
 * (SAN-0001, CAR-0001, ELE-0001...). Items are consumable (no serial) in Pieces.
 * Safe to run again: everything is matched by name/code.
 *
 *   php artisan db:seed --class=MaintenanceItemSeeder
 */
class MaintenanceItemSeeder extends Seeder
{
    private const LISTS = [
        ['Sanitary', 'SAN', [
            'Concealed Bib Cock', 'Plastic Bib Cock', 'Angel Stock Cock', 'Council Stock Cock', 'Twin Bib Cock',
            'Pilar Cock', 'Basin Mixer Fixed', 'Bath Mixer', 'Sink Mixer', 'Basin Mixer',
            'Push Shower', 'Hand Shower', 'Moving Shower', 'High Commode Seat Cover (Orient)', 'High Commode Seat Cover (Carla)',
            'R A K Ball Cock', 'Soap Ketch', 'Basin Magic Pipe', 'Sink Magic Pipe', 'Sink Waste',
            'Tissue Holder', 'Heat Proof Connection Pipe (Basin)', 'Heat Proof Connection Pipe (For Geyser)', 'Lead Pipe Connection Pipe White', 'Gate Bulb ¾ Inch, 1 Inch',
            'Gas Stove', 'Double Injector', 'Single Injector', 'Thread Tap', 'Glass Self',
            '4 Inch Net Mesh for Bathroom', 'GI Bush', 'Adjustable Range Sewing Range', 'Pipe Range 14 Inches', 'Gas Stove Pipe',
            'Sink Pillar Cock', 'Glass Clip Packet', 'Gas Stove Pipe Clip', 'GI Plug', 'Bath Shower Pipe',
            'Push Shower Head', 'Push Button', 'Basin Mixer Moving', 'RAK Ball Cock Fitting', 'Bath Shower Head',
            'High Commode Seat Cover Nut', 'Kurian Putting', 'White Cement', '0.5 Inch Gate Bulb', '0.5/1.5 Inch Ball Bulb',
            '0.5 Inch GI Short Pitch', 'Gas Stove Nozzle', 'Water Filter PP 20 Inch', 'Water Filter PP 10 Inch', 'Towel Stand (24 Inch SS)',
            'Ball Cock (Float Bulb) 2 Inch', 'Ball Cock (Float Bulb) 1.5 Inch', 'Ball Cock (Float Bulb) 1 Inch', 'Ball Cock (Float Sand) 0.5 Inch', 'Ball Cock (Float Bulb) 3/4 Inch',
            'Net Filter (20 Inch)', 'Net Filter (10 Inch)', 'Box Filter (20 Inch)', 'Box Filter (10 Inch)', 'Gas Riser',
            'Plastic Low Down', 'Thai Silicone Gum', 'Gas Stove Half-Quarter Key', 'Rack Towel Rail', 'Water Filter Bib Cock',
            'Kitchen Tissue Holder (SS)', 'Plus Minus Gum', 'Ring Tape', '100 Gas Burners', '0.5 Inch Gas Cock',
            '0.5 Inch Non-Nikon Bulb', '0.5 Inch Union GI', '0.5 Inch Elbow GI', '0.5 Inch Nipple GI', 'Bath Mixer Off Side',
            'Geyser Pressure Bulb', 'Star Ainge Set', 'Water Filter Pressure Bulb', 'Water Filter Inlet Bulb', 'CPVC Pipe',
            'CPVC Pipe (Female Type Socket)', 'CPVC Pipe (Male Type Socket)', 'CPVC Pipe (Plain Elbow)', 'CPVC Pipe Gum', 'CPVC Pipe (Female Tee)',
            'CPVC Pipe (Plain Tee)', 'CPVC Pipe (Female Elbow)', 'CPVC Union', 'RD Water Connector', '50 mm Lock',
            'Water Filter Pipe (5 mm)', 'Water Filter Pipe (10 mm)', 'Plumber Tools Bag', 'Electric Carrying Bag', 'Sink Cock Div',
            '18 Inch Manhole Cover', '2 Inch UPVC Pipe', '2 Inch Elbow', '2 Inch Pipe Tee', '2 Inch Clam (GI)',
            'Ring Caster', 'CPVC Plain Socket', 'Login Cock', '0.5 Inch GI Clam',
        ]],
        ['Carpenter', 'CAR', [
            'Steel Cornice', 'Steel Tape', 'Geyser 45 Ltr', 'HazBolt', 'Rim Lock/Door Lock',
            'Handle Lock', 'Lever Lock', 'Splash', 'Screen Clam', 'Counsel Kopje',
            'Chain Link', 'Drawer Lock', 'Door Magnet', 'Wardrobe Channel (15 Inch)', 'Door Handle',
            'Drawer Handle Golden', 'Thai Window Wheel', 'Thai Lock', 'Thai Window Mosquito Net (Fiber) 7 Feet', 'Thai Rubber 2 Part Half Inch',
            'Thai Rubber Round 2 Yarn', 'Plastic Door Casing (3 Inch)', 'Melamine Board (Bois Color)', 'Melamine Board (Grey Color)', 'Roar Fly Board (15 ml)',
            'Roar Fly Board (18 ml)', 'Aging 3x4 Base Color', 'Aging 3x8 Grey Color', 'Aging 3x4 Wall Night Color', 'Solution Gum',
            'L Culm 1 Inch', 'Drawer Lock Clam 1 Inch', 'Auto Polish', 'Wood Series Paper', 'MS Washer (2 Yarns) Thin',
            'MS Washer (3 Yarns) Thin', 'Wardrobe Concealed Closet (State/Half/Full)', 'Glass Push Magnet (Black)', 'Glass Magnet', 'Push Lock',
            'Super Glue Gum', 'Tip Pudding', 'Wood Screw 0.5 Inch', 'Wood Screw 1.4/1 Inch', 'Guna Wire (Thin)',
            'GI Wire', 'Net Thai Window Wheel', 'Glass Cutting Pen', 'Wood Screw 3/4 Inch', 'Drawer Handle Screw 1.4/1 Inch',
            'Drawer Handle Screw 1 Inch', 'Pipe Handle', 'Star Burning Screw (1 Inch)', 'Star Burning Screw (1.5 Inch)', 'Doba Handle',
            'Drawer Knobs', 'Mosquito Netting Hook', 'Steel Wire Cut (0.5 Inch)', 'Steel Wire Cut (1 Inch)', 'Steel Wire Cut (2 Inch)',
            'Pin Super (3/4) White', 'Wool Screw 3 Inch', 'Plastic Door Handle', '4 Wooden Door Hinge', 'Hand Saw',
            'Conceal Height 2 Inch', 'Batal', 'Kechi', 'Screw 0.5 Inch', 'Screw 1 Inch',
            'Screw 1.5 Inch', 'Screw 2 Inch', 'Screw 2.5 Inch', 'Screw 3 Inch',
        ]],
        ['Electric', 'ELE', [
            'LED Light 15 Watt', 'LED Tube Light 4 Fit 20 Watt', 'LED Tube Light 2 Fit 10 Watt', 'Slim Botton LED Tube Light 4 Fit 40 Watt', 'Slim Botton LED Tube Light 2 Fit 20 Watt',
            'T-5 Tube Light 4 Feet 20 Watt (White)', 'T-5 Tube Light 4 Feet 20 Watt (Oram)', 'Jhar Batir Light Small /60 Watt', 'LED Light 07 Watt', 'LED Panel Light 6 Watt',
            'LED Panel Light 8 Watt', 'LED Panel Light 40 Watt (Slim Type Square)', 'LED Light 40 Watt (Box Type Square)', 'LED Panel Light 40 Watt (Box Type Square)', 'LED Panel Light 40 Watt (Slim Type Square)',
            'LED Panel Light 1×1 Fit 24 Watt', 'LED Panel Light 8×8 Fit 18 Watt (Box Type Square)', 'LED Panel Light 8×8 Fit 18 Watt (Slim Type Square)', 'LED Panel Light 8×8 Fit 12 Watt (Slim Type Square)', 'LED Panel Light 8×8 Fit 12 Watt (Box Type Square)',
            'Search Light 100 Watt', 'Search Light 200 Watt', 'Ceiling Fan 56 Inch', 'Exhaust Fan 06 Inch', 'Exhaust Fan 08 Inch',
            'Exhaust Fan 10 Inch', 'Exhaust Fan 12 Inch', 'Holder', 'MK Regulator', 'Normal Regulator',
            'Capacitor', '2 Pin Socket', '3 Pin Socket', '6 Pin Socket', '3 Pin Plug',
            'MK Box', 'Piano Switch', '1 Gang Switch', '2 Gang Switch', '3 Gang Switch',
            '4 Gang Switch', 'DB Switch', '1.5 RM Cable', 'Electric Channel', '10 AMP Circuit Breaker',
            '16 AMP Circuit Breaker', '20 AMP Circuit Breaker', '32 AMP Circuit Breaker', '40 AMP Circuit Breaker', '63 AMP Circuit Breaker',
            'Screw Driver', 'Royal Plug', 'Plus', 'Taster', 'Drill Machine',
            'Calling Bell Battery', 'Calling Bell Electric', 'Piano 2 Pin Socket', '2 Pin Plug', 'Wall Holder',
            'Multi Plug', 'Spot Light White', 'Pasha Spot Light', 'Calling Bell Switch', 'Cable Clip',
            'Focus LED Light', 'Hammer', 'Nos Plus', 'Cutting Plus', 'Piano Calling Bell Switch',
            'Ceiling Fan 36 Inch', 'Remote Battery', 'Chamatir Small / Slim Patch Holder', 'Jharbati Holder (Golden Colour)', 'Spot Light Oram',
            'LED Panel Light 1 Fit / 4 Fit (Box Type)', 'T-5 Light 2 Fit 10 Watt Oram', 'One Phase Circuit Breaker Box', 'LED Panel Light 4 Fit / 6 Inch', 'Panel Light 6 Inch Round',
            'LED Light 15 Watt (Oram Colour)',
        ]],
    ];

    public function run(): void
    {
        $unit = ItemUnit::firstOrCreate(['name' => 'Pieces'], ['code' => 'PCS', 'status' => true]);

        DB::transaction(function () use ($unit) {
            foreach (self::LISTS as [$name, $prefix, $items]) {
                $parent = ParentCategory::updateOrCreate(['name' => $name], ['status' => true, 'approval_status' => ParentCategory::APPROVED]);
                $category = Category::updateOrCreate(
                    ['parent_category_id' => $parent->id, 'name' => $name],
                    ['description' => "$name item list", 'status' => true, 'approval_status' => Category::APPROVED]
                );

                foreach ($items as $i => $itemName) {
                    Item::updateOrCreate(['code' => sprintf('%s-%04d', $prefix, $i + 1)], [
                        'parent_category_id' => $parent->id, 'category_id' => $category->id, 'item_unit_id' => $unit->id,
                        'name' => $itemName, 'has_warranty' => false, 'is_consumable' => true, 'is_license' => false,
                        'status' => true, 'approval_status' => Item::APPROVED,
                    ]);
                }
            }
        });
    }
}
