<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Absensi') }}</title>

    <!-- Preline CSS dan JS -->
    <link href="https://cdn.jsdelivr.net/npm/preline@1.4.2/dist/preline.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/preline@1.4.2/dist/preline.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="./node_modules/preline/dist/preline.js"></script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Choices.js CSS -->
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet">

    <!-- Choices.js JS -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

</head>

<body class="font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white">
            @include('components.sidebar')
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar -->
            @include('components.navbar')

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-white p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Preline JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            HSOverlay.init(); // Inisialisasi untuk Preline modals

            // Event listener untuk modal triggers
            var modalTriggers = document.querySelectorAll('[data-hs-overlay]');
            modalTriggers.forEach(function(trigger) {
                trigger.addEventListener('click', function() {
                    var targetSelector = this.getAttribute('data-hs-overlay');
                    var targetModal = document.querySelector(targetSelector);

                    if (targetModal) {
                        // Toggle class untuk tampilkan/sembunyikan modal
                        targetModal.classList.toggle('hidden');
                        targetModal.classList.toggle('block');
                    }
                });
            });
        });
    </script>
</body>

</html>
