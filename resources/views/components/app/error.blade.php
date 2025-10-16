<div>
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="dangerAlert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const alertElement = document.getElementById('dangerAlert');
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
