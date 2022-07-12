<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Elasticsearch\Common\Exceptions\Forbidden403Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
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
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return response()->json($exception->validator->errors()->messages(), 400);
        }

        // catch exception of authorization of any API
        if ($exception instanceof AuthorizationException) {
            return response()->json($exception->getMessage(), 401);
        }

        // catch exception of model not found of any API
        if ($exception instanceof  ModelNotFoundException ) 
        {
            return response()->json([
                'message' => 'model not found',
            ], 404);
        }
        if ($exception instanceof NotFoundHttpException) 
        {
            return response()->json([
                'message' => 'route not found',
            ], 404);
        }
        if ($exception instanceof Forbidden403Exception) 
        {
            return response()->json([
                'message' => 'permission denied',
            ], 403);
        }
        //catch any exception of any API 
        return response()->json(
            [
                'message' => ($exception->getMessage()) ? $exception->getMessage() : 'internal server error',
            ],
            500
        );
    }
}
