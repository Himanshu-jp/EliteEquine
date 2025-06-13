<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\ApiAuthenticate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Admin route group
            Route::middleware(['web'])
                ->prefix('admin')
                ->group(function () {
                    // Redirect /admin to /admin/login
                    Route::redirect('/', url('/admin/login'));

                    // Load admin-specific routes
                    require base_path('routes/admin.php');
                });
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'checkAdminRole' => IsAdminMiddleware::class,
            'PreventBackHistory' => PreventBackHistory::class,
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'ApiAuthenticate' => ApiAuthenticate::class,
        ]);
        $middleware->statefulApi(); // Enable SPA auth
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle exceptions if needed
    })
    ->create();
