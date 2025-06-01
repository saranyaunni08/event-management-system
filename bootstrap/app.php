<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureUserIsInvited;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register middleware alias
        $middleware->alias([
            'ensure.invited' => EnsureUserIsInvited::class,
        ]);

        // Optional: Add to a group if needed (e.g., 'web' group already includes 'auth')
        $middleware->web(append: [
            // Add here if you want it applied to all web routes
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();