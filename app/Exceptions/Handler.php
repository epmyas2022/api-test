<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Throwable;

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
     * The exception classes with status code.
     *
     * @var array<int, string>
     */
    private $exceptions = [
        BadRequestException::class => Response::HTTP_BAD_REQUEST,
        Exception::class => Response::HTTP_INTERNAL_SERVER_ERROR,
        AccessDeniedHttpException::class => Response::HTTP_FORBIDDEN,
        NotFoundHttpException::class => Response::HTTP_NOT_FOUND,
        UnprocessableEntityHttpException::class => Response::HTTP_UNPROCESSABLE_ENTITY,
        MethodNotAllowedHttpException::class => Response::HTTP_METHOD_NOT_ALLOWED,
        JWTException::class => Response::HTTP_UNAUTHORIZED,
    
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
        });

        $this->renderable(function (Throwable $e) {
            if (array_key_exists(get_class($e), $this->exceptions)) {
                return response()->json(['message' => $e->getMessage()], $this->exceptions[get_class($e)]);
            }
        });
    }
}
