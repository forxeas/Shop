<?php

namespace App\Services\Message;

use App\Contracts\NotifierInterface;
use Livewire\Component;

class LivewireNotifier implements NotifierInterface
{
    public string $message = '';
    public string $type    = 'success';
    public Component $component;

    public function setComponent(Component $component): void
    {
        $this->component = $component;
    }

    public function notify(string $message, string $type): void
    {
        $this->message = $message;
        $this->type    = $type;

        $this->component->dispatch('set-message', ['message' => $message, 'type' => $type]);
    }

    public function clear(): void
    {
        $this->message = '';
        $this->type    = 'success';
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