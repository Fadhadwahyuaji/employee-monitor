@extends('layouts.theme')

@section('content')
    <div class="container">
        <h1 class="text-4xl font-semibold mb-6">Log Aktivitas {{ $user->name }}</h1>

        @php
            use Carbon\Carbon;

            // Set locale ke bahasa Indonesia
            Carbon::setLocale('id');

            // Mengelompokkan log per hari
            $logsGroupedByDate = $logs->groupBy(function ($log) {
                return $log->created_at->format('Y-m-d');
            });
        @endphp

        @foreach ($logsGroupedByDate as $date => $logsForDay)
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold mb-4">
                    {{ Carbon::parse($date)->translatedFormat('l, j F Y') }}
                </h3>
                <div class="relative">
                    <!-- Tombol Filter -->
                    <button id="filterPopoverButton" type="button"
                        class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 focus:ring-2 focus:ring-teal-500">
                        Filter
                    </button>

                    <!-- Popover dengan perbaikan positioning -->
                    <div id="filterPopoverContent"
                        class="hidden absolute top-0 left-0 right-0 transform -translate-x-1/2 bg-white border border-gray-300 rounded-lg shadow-lg mt-2 p-4 z-50 w-64 max-w-xs">
                        <form action="{{ route('manajemen.log.detail', $user->id) }}" method="GET">

                            <!-- Input untuk memilih tanggal -->
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                            <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                                class="border-gray-300 rounded-lg p-2 mt-1 w-full focus:ring-teal-500 focus:border-teal-500 dark:bg-neutral-800 dark:text-white">

                            <label for="end_date" class="block text-sm font-medium text-gray-700 mt-4">Sampai
                                Tanggal</label>
                            <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                                class="border-gray-300 rounded-lg p-2 mt-1 w-full focus:ring-teal-500 focus:border-teal-500 dark:bg-neutral-800 dark:text-white">

                            <!-- Tombol Submit -->
                            <button type="submit"
                                class="mt-4 w-full bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 focus:ring-2 focus:ring-teal-500">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="timeline">
                @foreach ($logsForDay->reverse() as $log)
                    <!-- Membalik urutan log untuk yang terbaru di bawah -->
                    <div class="timeline-item">
                        <div class="timeline-bubble"></div>
                        <div class="activity-item">
                            <div class="time">{{ $log->created_at->format('H:i') }}</div>
                            <div class="activity">
                                <div class="title" id="aktivitas-{{ $log->id }}">
                                    {{ $log->aktivitas }}
                                    <div class="update-form" id="aktivitas-update-{{ $log->id }}"
                                        style="display: none;">
                                        <input type="text" id="aktivitas-input-{{ $log->id }}"
                                            value="{{ $log->aktivitas }}" class="inline-input" />
                                    </div>
                                </div>
                                <div class="status scheduled" id="deskripsi-{{ $log->id }}">
                                    {{ $log->deskripsi }}
                                    <div class="update-form" id="deskripsi-update-{{ $log->id }}"
                                        style="display: none;">
                                        <textarea id="deskripsi-input-{{ $log->id }}" class="inline-input">{{ $log->deskripsi }}</textarea>
                                    </div>
                                </div>
                                @if ($log->link)
                                    <a href="{{ $log->link }}" target="_blank"
                                        class="text-blue-600 text-sm hover:underline">Lihat Lampiran</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

        <script>
            const button = document.getElementById('filterPopoverButton');
            const popover = document.getElementById('filterPopoverContent');

            button.addEventListener('click', () => {
                popover.classList.toggle('hidden');

                // Hitung posisi popover setiap kali ditampilkan
                const buttonRect = button.getBoundingClientRect();
                const popoverRect = popover.getBoundingClientRect();
                const screenWidth = window.innerWidth;
                const margin = 30; // Margin 20px dari sisi layar

                // Reset posisi popover
                popover.style.left = '0px';
                popover.style.right = '0px';

                // Cek apakah popover melebihi sisi kanan layar
                if (popoverRect.right > screenWidth - margin) {
                    const overflowRight = popoverRect.right - screenWidth + margin;
                    popover.style.left = `-${overflowRight}px`; // Geser ke kiri
                }

                // Pastikan popover tidak lebih besar dari lebar layar dengan padding
                // popover.style.maxWidth = `${screenWidth - 2 * margin}px`;
            });

            // Klik di luar popover untuk menutup
            document.addEventListener('click', (event) => {
                if (!button.contains(event.target) && !popover.contains(event.target)) {
                    popover.classList.add('hidden');
                }
            });
        </script>
    @endsection
