<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;
use Throwable;
use \Symfony\Component\HttpFoundation\Response;


class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    
    public function render($request, Throwable $exception)
    {
        if(strpos($request->getPathInfo(),"/api/") !== false){
            if($exception instanceof ModelNotFoundException){
                return response()->json(["success" => false, "error" => "Error modelo no encontrado"], 400);
            }
    
            if($exception instanceof QueryException){
                return response()->json(["success" => false, "error" => "DB Error " , $exception->getMessage()], 500);
            }
    
            if($exception instanceof HttpException){
                return response()->json(["success" => false, "error" => "Error de ruta" , $exception->getMessage()], 404);
            }
    
            if($exception instanceof AuthenticationException){
                return response()->json(["success" => false, "error" => "Error de autentificación"], 401);
            }
    
            if ($exception instanceof AuthorizationException) {
                return response()->json(["success" => false, "error" => "Error de autentificación, permiso denegado para este recurso"], 403);
            }

            if ($exception instanceof ValidationException) {
                //$exception = $this->convertValidationExceptionToResponse($exception, $request);
                
                return response()->json(["success" => false, "error" => "Campos incompletos", "fields" => $exception->errors()], 422);
            }
        }
        return parent::render($request, $exception);
    }
    
}
