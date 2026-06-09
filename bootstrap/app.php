<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CandidateMiddleware;
use App\Http\Middleware\EmployerMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {

        $middleware->alias([

            'admin' => AdminMiddleware::class,

            'candidate' => CandidateMiddleware::class,

            'employer' => EmployerMiddleware::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
