<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    /*
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
*/
    public function render($request, Exception $exception)
    {
        // This will replace our 404 response with
        // a JSON response.
        if ($exception instanceof ModelNotFoundException &&
            $request->wantsJson())
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }

       /* if($request->wantsJson() && $exception instanceof NotFoundHttpException) {

            return response_api(false ,$exception->getStatusCode(), 'Not found url' , []  );
        }
        if($request->wantsJson() && $exception instanceof MethodNotAllowedHttpException) {
            return response_api(false ,$exception->getStatusCode() , 'Error method type ex. post , get',[]);
        }
        if($request->wantsJson() && $exception instanceof \ErrorException ) {
            return response_api(false ,500, 'Error' , []);
        }*/

//        if ($exception instanceof MethodNotAllowedHttpException)
//        {
//            return response()->json(['data' => 'Error']);
//        }
//        if ($exception instanceof \ErrorException)
//        {
//            return response()->json(['data' => 'Error']);
//        }


        return parent::render($request, $exception);
    }
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response_api(false , 'Unauthenticated.' , "" , 401 );
           // return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        $guard = array_get($exception->guards(), 0);
        switch ($guard) {
            case 'admin':
                $login = 'admin.auth.login';
                break;
            default:
                $login = 'login';
                break;
        }
        return redirect()->guest(route($login));
    }
}
