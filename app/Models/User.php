<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, LogsActivity, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'full_name',
        'mobile_no',
        'address',
        'role_id',
        'unit_id',
        'rank_id',
        'photo',
        'join_date',
        'last_login_at',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'join_date' => 'date',
            'status' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function quickLinks(): HasMany
    {
        return $this->hasMany(QuickLink::class);
    }

    public function isAdmin(): bool
    {
        return in_array($this->role?->slug, ['superadmin', 'admin'], true);
    }

    public function isSuperAdmin(): bool
    {
        return (bool) $this->role?->isSuperAdmin();
    }

    private ?array $permissionCache = null;

    /**
     * ['menu/path' => ['view', ...]] for this user's role (cached per request).
     */
    public function permissionMap(): array
    {
        return $this->permissionCache ??= $this->role?->permissionMap() ?? [];
    }

    public function canMenu(string $path, string $ability = 'view'): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return in_array($ability, $this->permissionMap()[trim($path, '/')] ?? [], true);
    }

    /**
     * "path|ability" keys of everything this user may do.
     */
    public function permissionKeys(): array
    {
        return collect($this->permissionMap())
            ->flatMap(fn ($abilities, $path) => array_map(fn ($ability) => "$path|$ability", $abilities))
            ->values()
            ->all();
    }

    /**
     * May this user hand out (or manage users of) the given role? Only when every
     * permission of that role is one they hold themselves — no privilege escalation.
     */
    public function canGrantRole(?Role $role): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        if (! $role) {
            return true;
        }
        if ($role->isSuperAdmin()) {
            return false;
        }

        $mine = $this->permissionKeys();

        return $role->permissions->every(fn ($p) => in_array("{$p->path}|{$p->ability}", $mine, true));
    }

    /**
     * True when the role has at least "view" on one page of the module.
     */
    public function canModule(string $module): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return collect($this->permissionMap())
            ->keys()
            ->contains(fn ($path) => str_starts_with($path, $module.'/') && $this->canMenu($path));
    }

    /**
     * Whatever this user creates waits for QM approval, unless they may approve it themselves.
     */
    public function needsApproval(): bool
    {
        return ! $this->canMenu('inventory/approvals', 'edit');
    }

    /**
     * Active users whose role may approve requests of the given wing (null = shared master data).
     * Super Admin is left out: they see the queue but are not paged for every request.
     */
    public static function approvers(?int $unitId): \Illuminate\Support\Collection
    {
        $roleIds = RolePermission::where('path', 'inventory/approvals')->where('ability', 'edit')->pluck('role_id');

        return static::where('status', true)->whereIn('role_id', $roleIds)
            ->when($unitId, fn ($q) => $q->where('unit_id', $unitId))
            ->get();
    }

    /**
     * Online = has a session that was active within the session lifetime.
     */
    public static function onlineIds(): array
    {
        return DB::table('sessions')
            ->whereNotNull('user_id')
            ->where('last_activity', '>=', now()->subMinutes((int) config('session.lifetime'))->getTimestamp())
            ->distinct()
            ->pluck('user_id')
            ->all();
    }

    public function isOnline(): bool
    {
        return in_array($this->id, self::onlineIds());
    }

    /**
     * Force logout from every device (Admin > Users > OnLine button).
     */
    public function logoutEverywhere(): void
    {
        DB::table('sessions')->where('user_id', $this->id)->delete();
    }

    /**
     * Ends this user's sessions on every other device, keeping the current one.
     */
    public function logoutOtherSessions(string $currentSessionId): void
    {
        DB::table('sessions')->where('user_id', $this->id)->where('id', '!=', $currentSessionId)->delete();
    }

    public function avatarUrl(): string
    {
        return $this->photo ? asset('storage/'.$this->photo) : asset('images/avatar.png');
    }
}
