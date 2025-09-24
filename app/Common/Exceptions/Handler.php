<?php
namespace App\Common\Exceptions;

use App\Common\Jobs\DiscordExceptionReportingJob;

use Illuminate\Foundation\Exceptions\Handler as BaseHandler;
use Throwable;

class Handler extends BaseHandler
{
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);

        // if($this->isReportableException($exception)) {
        //     DiscordExceptionReportingJob::dispatch($exception);
        // }
    }

    private function isReportableException(Throwable $exception)
    {
        return !in_array(get_class($exception), $this->dontReport);
    }
}
