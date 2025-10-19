<div>
    @if($message)
        <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition
                class="alert alert-{{ $type === 'error' ? 'danger' : 'success' }} alert-dismissible fade show"
                role="alert"
        >
            {{ $message }}
            <button type="button" class="btn-close" @click="show = false"></button>
        </div>
    @endif
</div>
