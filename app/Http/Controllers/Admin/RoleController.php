<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Support\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RoleController extends Controller
{
    use JsonResponses;

    public function index(Request $request): View
    {
        $roles = Role::withCount('users')
            ->where('slug', '!=', 'superadmin')
            ->when($request->filled('search'), fn ($q) => $q->where(fn ($q) => $q
                ->where('name', 'like', "%{$request->search}%")
                ->orWhere('slug', 'like', "%{$request->search}%")))
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.roles.index', compact('roles'));
    }

    public function create(): View
    {
        return view('admin.roles.form', ['role' => new Role, 'map' => []]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->merge(['slug' => $this->slug($request->input('name'))]);
        $data = $this->check($request, $this->rules(), ['name' => 'Role Name', 'slug' => 'Slug']);

        $role = Role::create(['name' => $data['name'], 'slug' => $data['slug']]);
        $role->syncPermissions($this->validPermissions($request, $role));

        return $this->ok('Role created successfully.', ['redirect' => route('admin.roles.index')]);
    }

    public function show(Role $role): View
    {
        abort_if($role->isSuperAdmin(), 404);
        $role->load(['users', 'permissions']);

        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role): View
    {
        abort_if($role->isSuperAdmin(), 404);

        return view('admin.roles.form', ['role' => $role, 'map' => $role->permissionMap()]);
    }

    public function update(Request $request, Role $role): JsonResponse
    {
        abort_if($role->isSuperAdmin(), 404);
        $data = $this->check($request, ['name' => ['required', 'string', 'max:50']], ['name' => 'Role Name']);

        $role->update(['name' => $data['name']]);
        $role->syncPermissions($this->validPermissions($request, $role));

        return $this->ok('Role updated successfully.', ['redirect' => route('admin.roles.index')]);
    }

    public function destroy(Role $role): JsonResponse
    {
        if (in_array($role->slug, Role::PROTECTED, true)) {
            return $this->fail('This role can not be deleted.');
        }
        if ($role->users()->exists()) {
            return $this->fail('This role is assigned to users. Change their role first.');
        }
        $role->delete();

        return $this->ok('Role deleted successfully.', ['id' => $role->id]);
    }

    /**
     * Keep only "path|ability" pairs that exist in config/menu.php and that the editor
     * holds themselves (no granting more than one has). Permissions the role already has
     * but the editor lacks are left untouched rather than silently removed.
     */
    private function validPermissions(Request $request, Role $role): array
    {
        $allowed = Menu::pages()->flatMap(fn ($p) => collect($p['abilities'])->map(fn ($a) => $p['path'].'|'.$a))->all();
        $requested = array_intersect((array) $request->input('permissions', []), $allowed);

        $editor = $request->user();
        if ($editor->isSuperAdmin()) {
            return array_values($requested);
        }

        $mine = $editor->permissionKeys();
        $existing = $role->permissions->map(fn ($p) => "{$p->path}|{$p->ability}")->all();

        return array_values(array_unique(array_merge(
            array_intersect($requested, $mine),
            array_diff($existing, $mine),
        )));
    }

    private function slug(?string $name): string
    {
        return preg_replace('/[^a-z0-9-]/', '', preg_replace('/[\s-]+/', '', Str::lower(trim((string) $name))));
    }

    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'slug' => ['required', 'string', 'max:50', Rule::unique('roles', 'slug')],
        ];
    }
}
