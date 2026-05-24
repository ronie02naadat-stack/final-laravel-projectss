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
        //Global middleware
        $middleware->append(App\Http\Middleware\PromotionMW::class);

        //Middleware group
        $middleware->group('group_middleware',[
            App\Http\Middleware\MiddlewareOne::class,
            App\Http\Middleware\MiddlewareTwo::class,
        ]);
        //Middleware alias
        $middleware->alias([
            'maintenance' => App\Http\Middleware\DownForMaintenanceMW::class,
            'check-maintenance-mode' => App\Http\Middleware\CheckMaintenanceMode::class,
            'check-user-type' => App\Http\Middleware\CheckUserType::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
