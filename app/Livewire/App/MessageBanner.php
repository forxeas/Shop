<?php

namespace App\Livewire\App;

use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class MessageBanner extends Component
{
    public string $message = '';
    public string $type    = 'success';

    public function mount(): void
    {
        $this->message = (string) session('success');
    }

    #[On('set-message')]
    public function setMessage(array $message): void
    {
        $this->message = $message['message'];
        $this->type    = $message['type'];
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
