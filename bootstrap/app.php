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
        $middleware->alias([
            'beatrice' => \App\Http\Middleware\beatrice::class,
            'admin' => \App\Http\Middleware\admin::class,
            'owner' => \App\Http\Middleware\owner::class,
            'orang_gudang' => \App\Http\Middleware\orang_gudang::class,
            'beatricekawaii' => \App\Http\Middleware\beatriceKAWAIIII::class,
            'org_gudang/admin' => \App\Http\Middleware\Admin\org_gudang::class,
            'not_paid' => \App\Http\Middleware\Guest::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
