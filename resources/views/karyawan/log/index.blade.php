@extends('layouts.theme')

@section('content')
    <div class="container">
        <h1 class="text-4xl font-semibold mb-6">Log Aktivitas</h1>
        <div class="flex justify-end mb-4">
            <button type="button"
                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-500 shadow-sm hover:bg-gray-100 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:text-neutral-400 dark:border-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-scale-animation-modal"
                data-hs-overlay="#hs-scale-animation-modal">
                Tambah Aktivitas
            </button>
        </div>

        {{-- Modal --}}
        <div id="hs-scale-animation-modal"
            class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog" tabindex="-1" aria-labelledby="hs-scale-animation-modal-label">
            <div
                class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center justify-center">
                <div
                    class="w-full max-w-md bg-white border shadow-lg rounded-xl p-6 pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="hs-scale-animation-modal-label" class="text-xl font-semibold text-gray-800 dark:text-white">
                            Tambah Aktivitas</h3>
                        <button type="button"
                            class="text-gray-400 hover:text-gray-600 dark:text-neutral-400 dark:hover:text-white"
                            aria-label="Close" data-hs-overlay="#hs-scale-animation-modal">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6L6 18"></path>
                                <path d="M6 6L18 18"></path>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('karyawan.log.store') }}" method="POST">
                        @csrf

                        <!-- Judul Aktivitas -->
                        <div class="mb-4">
                            <label for="judul"
                                class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Judul
                                Aktivitas</label>
                            <input type="text" id="judul" name="judul"
                                class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white dark:focus:ring-teal-500"
                                placeholder="Masukkan judul aktivitas" required>
                        </div>

                        <!-- Deskripsi Aktivitas -->
                        <div class="mb-4">
                            <label for="deskripsi"
                                class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi"
                                class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white dark:focus:ring-teal-500"
                                rows="4" placeholder="Tuliskan deskripsi aktivitas" required></textarea>
                        </div>

                        <!-- Link Bukti -->
                        <div class="mb-4">
                            <label for="link_bukti"
                                class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Link
                                Lampiran/bukti (Opsional)</label>
                            <input type="url" id="link_bukti" name="link_bukti"
                                class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white dark:focus:ring-teal-500"
                                placeholder="Masukkan link bukti pekerjaan">
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-between items-center">
                            <button type="submit"
                                class="w-full py-2 px-4 bg-teal-600 text-white font-semibold rounded-lg shadow-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-teal-700 dark:hover:bg-teal-600 dark:focus:ring-teal-500">
                                Tambah Aktivitas
                            </button>
                        </div>
                    </form>

                    <div class="flex justify-center items-center mt-4">
                        <button type="button"
                            class="w-full py-2 px-4 bg-gray-200 text-gray-800 font-semibold rounded-lg shadow-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:bg-neutral-700 dark:text-white dark:hover:bg-neutral-600 dark:focus:ring-neutral-500"
                            data-hs-overlay="#hs-scale-animation-modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

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
                <div class="relative inline-block">
                    <!-- Tombol Filter -->
                    <button id="filterPopoverButton" type="button"
                        class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 focus:ring-2 focus:ring-teal-500">
                        Filter
                    </button>

                    <!-- Popover dengan perbaikan positioning -->
                    <div id="filterPopoverContent"
                        class="hidden absolute left-0 right-0 transform -translate-x-1/2 bg-white border border-gray-300 rounded-lg shadow-lg mt-2 p-4 z-50 w-64 max-w-xs">
                        <form action="{{ route('karyawan.log.index') }}" method="GET">
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


                                <!-- Ikon untuk memperbarui aktivitas -->
                                <button class="update-button" id="update-button-{{ $log->id }}"
                                    onclick="toggleModal('update-modal-{{ $log->id }}')" aria-haspopup="dialog"
                                    aria-expanded="false" aria-controls="update-modal-{{ $log->id }}"
                                    data-hs-overlay="#update-modal-{{ $log->id }}">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                            clip-rule="evenodd" />
                                        <path fill-rule="evenodd"
                                            d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

        {{-- // modal update --}}
        @foreach ($logsGroupedByDate as $date => $logsForDay)
            @foreach ($logsForDay->reverse() as $log)
                <!-- Modal Update untuk setiap log -->
                <div id="update-modal-{{ $log->id }}"
                    class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none"
                    role="dialog" tabindex="-1" aria-labelledby="update-modal-{{ $log->id }}-label">
                    <div
                        class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center justify-center">
                        <div
                            class="w-full max-w-md bg-white border shadow-lg rounded-xl p-6 pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                            <div class="flex justify-between items-center mb-4">
                                <h3 id="update-modal-{{ $log->id }}-label"
                                    class="text-xl font-semibold text-gray-800 dark:text-white">
                                    Update Aktivitas</h3>
                                <button type="button"
                                    class="text-gray-400 hover:text-gray-600 dark:text-neutral-400 dark:hover:text-white"
                                    aria-label="Close" data-hs-overlay="#update-modal-{{ $log->id }}">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M18 6L6 18"></path>
                                        <path d="M6 6L18 18"></path>
                                    </svg>
                                </button>
                            </div>

                            <form action="{{ route('karyawan.log.update', $log->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Judul Aktivitas -->
                                <div class="mb-4">
                                    <label for="aktivitas"
                                        class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Judul
                                        Aktivitas</label>
                                    <input type="text" id="aktivitas" name="aktivitas"
                                        class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white dark:focus:ring-teal-500"
                                        placeholder="Masukkan judul aktivitas" value="{{ $log->aktivitas }}" required>
                                </div>

                                <!-- Deskripsi Aktivitas -->
                                <div class="mb-4">
                                    <label for="deskripsi"
                                        class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Deskripsi</label>
                                    <textarea id="deskripsi" name="deskripsi"
                                        class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white dark:focus:ring-teal-500"
                                        rows="4" placeholder="Tuliskan deskripsi aktivitas" required>{{ $log->deskripsi }}</textarea>
                                </div>

                                <!-- Link Bukti -->
                                <div class="mb-4">
                                    <label for="link"
                                        class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Link
                                        Lampiran/bukti (Opsional)</label>
                                    <input type="url" id="link" name="link"
                                        class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white dark:focus:ring-teal-500"
                                        placeholder="Masukkan link bukti pekerjaan" value="{{ $log->link }}">
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-between items-center">
                                    <button type="submit"
                                        class="w-full py-2 px-4 bg-teal-600 text-white font-semibold rounded-lg shadow-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-teal-700 dark:hover:bg-teal-600 dark:focus:ring-teal-500">
                                        Update Aktivitas
                                    </button>
                                </div>
                            </form>

                            <div class="flex justify-center items-center mt-4">
                                <button type="button"
                                    class="w-full py-2 px-4 bg-gray-200 text-gray-800 font-semibold rounded-lg shadow-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:bg-neutral-700 dark:text-white dark:hover:bg-neutral-600 dark:focus:ring-neutral-500"
                                    data-hs-overlay="#update-modal-{{ $log->id }}">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>

    <script>
        const button = document.getElementById('filterPopoverButton');
        const popover = document.getElementById('filterPopoverContent');

        button.addEventListener('click', () => {
            popover.classList.toggle('hidden');

            // Hitung posisi popover setiap kali ditampilkan
            const buttonRect = button.getBoundingClientRect();
            const popoverRect = popover.getBoundingClientRect();
            const screenWidth = window.innerWidth;
            const margin = 26; // Margin minimum dari sisi layar

            // Reset posisi popover
            popover.style.left = '0px';
            popover.style.right = 'auto';

            // Cek apakah popover melebihi sisi kanan layar
            if (popoverRect.right > screenWidth - margin) {
                const overflowRight = popoverRect.right - screenWidth + margin;
                popover.style.left = `-${overflowRight}px`; // Geser ke kiri
            }

            // Cek apakah popover melebihi sisi kiri layar
            if (popoverRect.left < margin) {
                const overflowLeft = margin - popoverRect.left;
                popover.style.left = `${overflowLeft}px`; // Geser ke kanan
            }

            // Cek apakah popover terlalu besar melebihi lebar layar
            if (popoverRect.width > screenWidth - 2 * margin) {
                popover.style.width = `${screenWidth - 2 * margin}px`; // Sesuaikan lebar
            }

            // Pastikan popover tidak lebih besar dari lebar layar dengan padding
            popover.style.maxWidth = `${screenWidth - 2 * margin}px`;
        });

        // Klik di luar popover untuk menutup
        document.addEventListener('click', (event) => {
            if (!button.contains(event.target) && !popover.contains(event.target)) {
                popover.classList.add('hidden');
            }
        });
    </script>
@endsection
