<?php

namespace App\Http\Middleware;

use App\Support\Menu;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Guards every page listed in config/menu.php with the role's permission.
 * The required ability comes from the route's "ability" default, or is
 * inferred from the controller method name.
 */
class CheckMenuPermission
{
    private const METHOD_ABILITY = [
        'create' => 'create', 'store' => 'create',
        'edit' => 'edit', 'update' => 'edit',
        'destroy' => 'delete',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $path = $request->path();

        // Module dashboards: any permission inside the module is enough.
        if (array_key_exists($path, config('menu'))) {
            abort_unless($user->canModule($path), 403);

            return $next($request);
        }

        if ($page = Menu::pageFor($path)) {
            $route = $request->route();
            $ability = $route->defaults['ability']
                ?? self::METHOD_ABILITY[$route->getActionMethod()]
                ?? 'view';

            if (! $user->canMenu($page['path'], $ability)) {
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'You do not have permission to perform this action.'], 403);
                }
                abort(403);
            }
        }

        return $next($request);
    }
}
