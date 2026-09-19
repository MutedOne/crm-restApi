<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
         $exceptions->report(function (\Throwable $e) {
            Log::error($e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        });

      
       $exceptions->render(function (\Throwable $e, $request) {

           if ($request->is('api/*')) {

                $status = match (true) {
                    $e instanceof NotFoundHttpException => 404,
                    $e instanceof \Illuminate\Validation\ValidationException => 422,
                    $e instanceof \Illuminate\Auth\AuthenticationException => 401,
                    $e instanceof \Illuminate\Auth\Access\AuthorizationException => 403,
                    default => 500,
                };

                $message = match ($status) {
                    404 => 'Resource not found.',
                    422 => 'Validation failed.',
                    401 => 'Unauthenticated.',
                    403 => 'Unauthorized.',
                    default => 'Something went wrong.',
                };

                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], $status);
            }
        });
    })->create();
