<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\View\ViewException;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Stancl\Tenancy\Exceptions\TenantDatabaseDoesNotExistException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, $exception)
    {
        if (
            ($exception instanceof TenantDatabaseDoesNotExistException) ||
            (tenant() && (! tenant('ready')) && $exception instanceof QueryException) ||
            (tenant() && (! tenant('ready')) && $exception instanceof ViewException && $exception->getPrevious() instanceof QueryException)
        ) {
            return response()->view('errors.building');
        }

        // This will replace our 404 response with
        // a JSON response.
        if ($exception instanceof ModelNotFoundException &&
        $request->wantsJson())
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }

    return parent::render($request, $exception);

    }
    // public function render($request, Throwable $exception)
    // {
    //     return parent::render($request, $exception);
    // }


    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? response()->json(['message' => $exception->getMessage()], 401)
            : redirect()->guest(route('login', ['account' => $request->route('account')]));
    }

}

