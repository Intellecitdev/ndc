<?php

namespace Database\Seeders;

use App\Models\Rank;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Base data taken from the reference (old) system.
     */
    public function run(): void
    {
        foreach ([
            ['Super Admin', 'superadmin'],
            ['Admin', 'admin'],
            ['Quarter Master', 'qm'],
            ['Storeman', 'storeman'],
        ] as [$name, $slug]) {
            Role::updateOrCreate(['slug' => $slug], ['name' => $name]);
        }

        // Wings, ranks and all Inventory > Configuration masters, with the reference IDs.
        $this->call(ReferenceConfigSeeder::class);

        $ndc = Unit::where('code', 'WHI0008')->value('id');

        $this->call(RolePermissionSeeder::class);

        // Same accounts as the reference system. Passwords come from SEED_ADMIN_PASSWORD /
        // SEED_USER_PASSWORD: set strong ones in the production .env before seeding.
        [$adminPass, $userPass] = [config('seeding.admin_password'), config('seeding.user_password')];
        foreach ([
            ['superadmin', 'shamim424884@gmail.com', 'Shamimul Haque', '01977424884', 'superadmin', 'CIVIL', '2025-04-10', $adminPass],
            ['administrator', 'administrator@gmail.com', 'Administrator', null, 'admin', 'Colonel', '2025-01-12', $adminPass],
            ['Purchaser', 'purchaser@test.com', 'Purchaser', '01977424885', 'qm', 'Sainik', '2026-10-12', $userPass],
            ['Issuer', 'issuer@test.com', 'Issuer', '01977424886', 'storeman', 'Sainik', '2026-10-12', $userPass],
        ] as [$login, $email, $fullName, $mobile, $role, $rank, $joined, $password]) {
            $user = User::firstOrNew(['name' => $login]);
            $user->fill([
                'email' => $email,
                'full_name' => $fullName,
                'mobile_no' => $mobile,
                'role_id' => Role::where('slug', $role)->value('id'),
                'unit_id' => $ndc,
                'rank_id' => Rank::where('name', $rank)->value('id'),
                'join_date' => $joined,
            ]);
            // Only new accounts get the seed password: re-seeding never resets a password already changed.
            if (! $user->exists) {
                if (blank($password)) {
                    throw new \RuntimeException('Set SEED_ADMIN_PASSWORD and SEED_USER_PASSWORD in .env (strong passwords) before seeding.');
                }
                $user->password = $password;
            }
            $user->save();
            $user->forceFill(['created_at' => $joined])->saveQuietly();
        }

        $this->call(ReferenceTransactionSeeder::class);
    }
}
