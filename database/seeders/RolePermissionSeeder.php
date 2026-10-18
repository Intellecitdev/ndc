<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Support\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

/**
 * Role permissions:
 * - Admin: everything.
 * - Quarter Master (QM): purchasing, read access to the whole inventory and the
 *   Approvals queue, where Storeman requests are approved or rejected.
 * - Storeman: creates materials, purchase orders, stock entries and issue
 *   vouchers; each waits for QM approval before it reaches the inventory.
 */
class RolePermissionSeeder extends Seeder
{
    /** Masters that go through approval, so the Storeman may create them. */
    private const MATERIALS = [
        'inventory/configuration/parentcategories', 'inventory/configuration/categories', 'inventory/configuration/brands',
        'inventory/configuration/models', 'inventory/configuration/items',
    ];

    private const PURCHASE = ['inventory/purchase/purchaseorders', 'inventory/purchase/purchaseorderreceive'];

    /**
     * @param  bool  $adminFull  false only adds the Approvals page to Admin (keeps any edits made in Admin > Roles)
     */
    public function run(bool $adminFull = true): void
    {
        if ($admin = Role::where('slug', 'admin')->first()) {
            $adminFull
                ? $admin->syncPermissions($this->all('')->all())
                : $admin->syncPermissions(collect($admin->permissions)->map(fn ($p) => $p->path.'|'.$p->ability)->merge($this->all('inventory/approvals'))->all());
        }

        Role::where('slug', 'qm')->first()?->syncPermissions(
            $this->grant(self::PURCHASE, Menu::ABILITIES)
                ->merge($this->grant($this->paths('inventory/'), ['view']))
                ->merge($this->all('inventory/approvals'))
                ->all()
        );

        Role::where('slug', 'storeman')->first()?->syncPermissions(
            $this->grant($this->paths('inventory/configuration/'), ['view'])
                ->merge($this->grant(self::MATERIALS, ['create']))
                ->merge($this->grant(self::PURCHASE, ['view', 'create']))
                ->merge($this->grant($this->paths('inventory/transaction/'), ['view', 'create', 'edit']))
                ->merge($this->all('inventory/reports/'))
                ->all()
        );
    }

    /** Every page path under a prefix, except the Approvals queue. */
    private function paths(string $prefix): array
    {
        return Menu::pages()->filter(fn ($p) => str_starts_with($p['path'], $prefix) && $p['path'] !== 'inventory/approvals')->pluck('path')->all();
    }

    /** Every ability of every page under a prefix. */
    private function all(string $prefix): Collection
    {
        return Menu::pages()
            ->filter(fn ($p) => str_starts_with($p['path'], $prefix))
            ->flatMap(fn ($p) => collect($p['abilities'])->map(fn ($a) => $p['path'].'|'.$a));
    }

    /** The given abilities on each path, limited to what the page offers. */
    private function grant(array $paths, array $abilities): Collection
    {
        return Menu::pages()->whereIn('path', $paths)
            ->flatMap(fn ($p) => collect($abilities)->intersect($p['abilities'])->map(fn ($a) => $p['path'].'|'.$a));
    }
}
