<?php

namespace App\Services\Messages;

use App\Contracts\NotifierInterface;
use Event;

class MessageNotifier implements NotifierInterface
{
    public ?string $message = null;
    private string $type = 'info';

    public function notify(string $message, string $type): void
    {
        $this->message = $message;
        $this->type    = $type;

        Event::dispatch
        (
            'set-message',
            [
                'message' => $message,
                'type' => $type
            ]
        );
    }

    public function clear(): void
    {
        $this->message = null;
        Event::dispatch('clear-message');
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
