<?php

namespace App\Services;

use App\Contracts\NotifierInterface;
use Illuminate\Support\Facades\Log;
use Throwable;

class ExceptionHandlerService
{
    protected ?string $message = null;
    public function __construct(protected NotifierInterface $messageService)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function catchToException(
        callable $action,
        string   $message,
        string   $logMessage,
    ): void
    {
        try {
            $action();
        } catch (Throwable $e) {
            $this->messageService->notify($message, 'error');

            Log::critical($logMessage . ': ' . $e->getMessage());
            $this->message = $this->messageService->getMessage();
        }
    }
    public function catchExceptionFinally
    (
        callable $action,
        string   $message,
        string   $logMessage,
        callable $finally
    ): void
    {
        $this->catchToException($action, $message, $logMessage);
        $finally();
    }
}
