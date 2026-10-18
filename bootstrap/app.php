<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectUsersTo('/welcome');
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        $middleware->web(append: [\App\Http\Middleware\IpFilter::class, \App\Http\Middleware\InactivityTimeout::class]);
        $middleware->alias([
            'menu' => \App\Http\Middleware\CheckMenuPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // AJAX callers get the app's usual { success, message } shape instead of a stack trace.
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                $message = $e->getMessage() ?: match ($e->getStatusCode()) {
                    403 => 'You do not have permission to perform this action.',
                    404 => 'Record not found.',
                    default => 'Something went wrong! Try again.',
                };

                return response()->json(['success' => false, 'message' => $message], $e->getStatusCode());
            }
        });
    })->create();
