<div>
    <button class="btn border-rounded px-4 py-2" wire:click.prevent="switchTheme">
        {{ $darkTheme === 'light' ? '🌞' : '🌙' }}
    </button>
</div>

<script>
    document.documentElement.setAttribute('data-bs-theme', '{{ $darkTheme }}');
    console.log('{{ $darkTheme }}')
    document.addEventListener('livewire:init', () => {
        Livewire.on('theme-changed', ({theme}) => {
            document.documentElement.setAttribute('data-bs-theme', theme);
        });
    });
</script>