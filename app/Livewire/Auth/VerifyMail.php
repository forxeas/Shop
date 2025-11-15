<?php

namespace App\Livewire\Auth;

use App\Contracts\NotifierInterface;
use App\Services\Auth\VerifyMailService;
use App\Services\ExceptionHandlerService;
use App\Services\Message\LivewireNotifier;
use Livewire\Component;
use Illuminate\View\View;


class VerifyMail extends Component
{
    private NotifierInterface $messageService;
    private ExceptionHandlerService $exceptionService;
    private VerifyMailService $verifyMailService;
    public   string $userUuid = '';
    private  string $code;
    public array $data;

    public function boot
    (
        NotifierInterface $messageService,
        ExceptionHandlerService $exceptionService,
        VerifyMailService $verifyMailService
    ): void
    {
        /** @var NotifierInterface|LivewireNotifier $messageService */

        $this->exceptionService = $exceptionService;

        $this->messageService          = $messageService ;
        $this->messageService->setComponent($this);
        $this->verifyMailService       = $verifyMailService;

        $this->exceptionService->boot($this->messageService, $this);
    }


    public function mount(): void
    {
        $this->exceptionService->catchToException(
            function() {
                $this->data = $this->verifyMailService->mountMail();
                $this->code = $this->data['code'];
                unset($this->data['code']);
            },
            'Не удалось отправить код подтверждения',
            'VerifyMail: fail to mount mail'
        );
    }

    public function verify(): void
    {
        $this->exceptionService->catchToException(
            fn() => $this->verifyMailService->verifyMail($this->data, $this->userUuid, $this->code),
            'Ошибка при подтверждении почты',
            'VerifyMail: fail to verify mail'
        );
    }

    public function resend(): void
    {
        $this->exceptionService->catchToException(
            fn() => $this->code = $this->verifyMailService->resend($this->data),
            'Ошибка при отправке кода подтверждения',
            'VerifyMail: fail to resend mail'
        );
    }

    public function render(): View
    {
        return view('livewire.auth.verify-mail');
    }
}
