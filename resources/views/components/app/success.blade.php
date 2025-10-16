@props(['message'])
@php
    $message = $message ?? session('success')
@endphp

<div>
    @if($message)
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const alertElement = document.getElementById('successAlert');
                if (alertElement) {
                    setTimeout(function() {
                        const alert = bootstrap.Alert.getOrCreateInstance(alertElement);
                        alert.close();
                    }, 3000);
                }
            });
        </script>
    @endif
</div>
