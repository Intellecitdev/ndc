<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.app');

        // Password policy for new and changed passwords (existing passwords keep working until changed).
        Password::defaults(fn () => Password::min(8)->letters()->mixedCase()->numbers()->symbols());

        // Production runs behind HTTPS: generate https links even when TLS ends at a proxy.
        if (str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        // @canmenu('inventory/configuration/units', 'create') ... @endcanmenu
        Blade::if('canmenu', fn (string $path, string $ability = 'view') => (bool) auth()->user()?->canMenu($path, $ability));
    }
}
