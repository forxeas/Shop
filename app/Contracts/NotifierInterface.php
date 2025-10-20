<?php

namespace App\Contracts;
use Livewire\Component;

interface NotifierInterface
{
    public function notify(string $message, string $type): void;
    public function getMessage(): ?string;
    public function getType(): string;
    public function setComponent(Component $component): void;
}
