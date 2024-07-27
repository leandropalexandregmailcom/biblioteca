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
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->validateCsrfTokens(except: [
            '/*',
            'http://localhost',
        ]);

        // Adicione middleware para o grupo web
        $middleware->web(append: [
            // \App\Http\Middleware\EnsureUserIsSubscribed::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Configuração de tratamento de exceções
        // $exceptions->dontReport(MissedFlightException::class);
        // $exceptions->report(function (InvalidOrderException $e) {
        //     // Implementar lógica de relatório de exceções
        // });
    })->create();
