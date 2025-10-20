<?php

namespace App\Services;

use App\Contracts\NotifierInterface;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Throwable;

class ExceptionHandlerService
{
    protected ?string $message = null;
    protected NotifierInterface $messageService;
    public function boot
    (
        NotifierInterface $messageService,
        Component $component
    ): void
    {
        $this->messageService = $messageService;
        $this->messageService->setComponent($component);
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @throws Throwable
     */
    public function catchToException(
        callable $action,
        string   $message,
        string   $logMessage,
    ): mixed
    {
        try {
            return  $action();
        } catch (Throwable $e) {
            $this->messageService->notify($message, 'error');

            Log::critical($logMessage . ': ' . $e->getMessage());
            $this->message = $this->messageService->getMessage();
        }
        return null;
    }

    /**
     * @throws Throwable
     */
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
