<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use LogsActivity;

    /** Roles that cannot be deleted from Admin > Roles. */
    public const PROTECTED = ['superadmin', 'admin'];

    protected $fillable = ['name', 'slug'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(RolePermission::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->slug === 'superadmin';
    }

    /**
     * ['path' => ['view', 'edit', ...]]
     */
    public function permissionMap(): array
    {
        return $this->permissions->groupBy('path')->map(fn ($rows) => $rows->pluck('ability')->all())->all();
    }

    /**
     * Replace all permissions with the given "path|ability" strings.
     */
    public function syncPermissions(array $keys): void
    {
        $this->permissions()->delete();
        
        $rows = collect($keys)->unique()->map(function ($key) {
            [$path, $ability] = explode('|', $key, 2) + [1 => null];

            return ['role_id' => $this->id, 'path' => $path, 'ability' => $ability];
        })->filter(fn ($r) => $r['ability'])->values()->all();

        if ($rows) {
            RolePermission::insert($rows);
        }
        $this->unsetRelation('permissions');
    }
}
