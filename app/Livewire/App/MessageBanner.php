<?php

namespace App\Livewire\App;

use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class MessageBanner extends Component
{
    public string $message = '';
    public string $type    = 'success';

    #[On('set-message')]
    public function setMessage(string $message, string $type): void
    {
        $this->message = $message;
        $this->type    = $type;
    }

    #[On('clear-message')]
    public function clearMessage(): void
    {
        $this->message = '';
        $this->type    = 'success';
    }

    public function render(): view
    {
        return view('livewire.app.message-banner');
    }
}
