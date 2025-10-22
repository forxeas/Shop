<?php

namespace App\Abstracts;

use App\Contracts\NotifierInterface;
use App\Services\Auth\AuthService;
use App\Services\ExceptionHandlerService;
use App\Services\Message\LivewireNotifier;
use Livewire\Component;

abstract class AbstractAuthComponent extends Component
{
    protected AuthService $service;
    protected NotifierInterface $messageService;
    protected ExceptionHandlerService $exceptionHandlerService;

    public function boot
    (
        AuthService             $authService,
        NotifierInterface       $livewireNotifier,
        ExceptionHandlerService $exceptionHandlerService
    ): void
    {
        /** @var NotifierInterface|LivewireNotifier $livewireNotifier */

        $this->exceptionHandlerService = $exceptionHandlerService;

        $this->messageService          = $livewireNotifier ;
        $this->messageService->setComponent($this);
        $this->service                 = $authService;

        $this->exceptionHandlerService->boot($this->messageService, $this);
    }
}