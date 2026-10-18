<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Reads config/menu.php — the single source of truth for modules, sidebar
 * menus and the permissions that can be granted on each page.
 */
class Menu
{
    public const ABILITIES = ['view', 'create', 'edit', 'delete'];

    /**
     * Every permission-bearing page, flattened:
     * [path, title, module, group (parent menu title|null), abilities].
     */
    public static function pages(): Collection
    {
        static $pages;

        return $pages ??= collect(config('menu'))->flatMap(function ($module, $moduleKey) {
            return collect($module['items'])->flatMap(function ($item) use ($moduleKey) {
                $children = $item['children'] ?? null;

                return collect($children ?? [$item])
                    ->reject(fn ($page) => $page['exact'] ?? false) // module dashboards
                    ->map(fn ($page) => [
                        'path' => $page['path'],
                        'title' => $page['title'],
                        'module' => $moduleKey,
                        'group' => $children ? $item['title'] : null,
                        'abilities' => $page['abilities'] ?? self::ABILITIES,
                    ]);
            });
        })->values();
    }

    /**
     * The menu page a request path belongs to (longest matching prefix).
     */
    public static function pageFor(string $path): ?array
    {
        $path = trim($path, '/');

        return self::pages()
            ->filter(fn ($p) => $path === $p['path'] || str_starts_with($path, $p['path'].'/'))
            ->sortByDesc(fn ($p) => strlen($p['path']))
            ->first();
    }

    /**
     * Module tree for the role form: module => [group|null => [pages]].
     */
    public static function tree(): Collection
    {
        return self::pages()->groupBy('module')->map(fn ($pages) => $pages->groupBy(fn ($p) => $p['group'] ?? ''));
    }

    public static function moduleTitle(string $module): string
    {
        return config("menu.$module.title", ucfirst($module));
    }
}
