<?php

namespace App\Exceptions;

use Exception;
use Request,Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException as AuthenticationException ;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // This will replace our 404 response with
        // a JSON response.
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => 'Resource not found'
            ], 404);
        }

        return parent::render($request, $exception);
        // return response()->json(
        //    [
        //      'success' => false,
        //      'message' => '401 Unauthenticated',
        //      'data' => 'Please Login first'
        //    ], 401
        // );
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // return response()->json(['error' => 'Unauthenticated'], 401);
        return $request->expectsJson()
                    ? response()->json(['message' => 'Unauthenticated.'], 401)
                    : redirect()->guest(route('authentication.index'));
        
    }

}
