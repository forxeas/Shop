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
    protected ExceptionHandlerService $exceptionService;

    public function boot
    (
        AuthService             $authService,
        NotifierInterface       $messageService,
        ExceptionHandlerService $exceptionService
    ): void
    {
        /** @var NotifierInterface|LivewireNotifier $messageService */

        $this->exceptionService = $exceptionService;

        $this->messageService          = $messageService ;
        $this->messageService->setComponent($this);
        $this->service                 = $authService;

        $this->exceptionService->boot($this->messageService, $this);

        $this->exceptionService->boot($this->messageService, $this);
    }
}