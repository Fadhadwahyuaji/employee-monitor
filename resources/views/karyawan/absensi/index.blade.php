@extends('layouts.theme')

@section('content')
    <div class="container">
        <!-- Judul Absensi dengan ukuran lebih besar -->
        <h1 class="text-4xl font-semibold mb-6">Absensi</h1>

        <!-- Tombol Absen (kanan) -->
        <div class="flex justify-end mb-4">
            @if (!$cekAbsensi)
                <!-- Jika belum absen masuk -->
                <button type="button"
                    class="py-3 px-6 text-lg font-medium rounded-lg bg-teal-500 text-white hover:bg-teal-600"
                    aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-scale-animation-modal"
                    data-hs-overlay="#hs-scale-animation-modal">
                    Absen Masuk
                </button>
            @else
                <!-- Jika sudah absen masuk, tampilkan tombol Absen Keluar -->
                <form action="{{ route('karyawan.absensi.out') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="py-3 px-6 text-lg font-medium rounded-lg bg-red-500 text-white hover:bg-red-600">
                        Absen Keluar
                    </button>
                </form>
            @endif
        </div>

        <!-- Modal untuk Absensi -->
        <div id="hs-scale-animation-modal"
            class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog" tabindex="-1" aria-labelledby="hs-scale-animation-modal-label">
            <div
                class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center justify-center">
                <div
                    class="w-full max-w-md bg-white border shadow-lg rounded-xl p-6 pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="hs-scale-animation-modal-label" class="text-xl font-semibold text-gray-800 dark:text-white">
                            Form Absensi</h3>
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

                    <form action="{{ route('karyawan.absensi.in') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="status"
                                class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Status Absensi</label>
                            <select id="status" name="status"
                                class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white dark:focus:ring-teal-500"
                                required>
                                <option value="masuk">Masuk</option>
                                <option value="sakit">Sakit</option>
                                <option value="izin">Izin</option>
                            </select>
                        </div>

                        <!-- Upload Foto hanya untuk Sakit dan Izin -->
                        <div id="photoUpload" class="hidden mb-4">
                            <label for="photo"
                                class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Upload Bukti
                                Foto</label>
                            <input type="file" name="photo" id="photo"
                                class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white dark:focus:ring-teal-500">
                        </div>

                        <div class="flex justify-between items-center">
                            <button type="submit"
                                class="w-full py-2 px-4 bg-teal-600 text-white font-semibold rounded-lg shadow-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-teal-700 dark:hover:bg-teal-600 dark:focus:ring-teal-500">
                                Absen Masuk
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

        <script>
            // Menampilkan input file jika status adalah Sakit atau Izin
            document.getElementById('status').addEventListener('change', function() {
                var fileUpload = document.getElementById('photoUpload');
                var photoInput = document.getElementById('photo');
                if (this.value === 'sakit' || this.value === 'izin') {
                    fileUpload.classList.remove('hidden');
                    photoInput.setAttribute('required', true); // Menambahkan required
                } else {
                    fileUpload.classList.add('hidden');
                    photoInput.removeAttribute('required'); // Menghapus required jika status 'masuk'
                }
            });
        </script>
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 dark:bg-green-900 dark:text-green-200">
                Selamat Bekerja! ☺
            </div>
        @elseif (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-red-100 dark:bg-red-900 dark:text-red-200">
                Gagal
            </div>
        @endif
        {{-- Riwayat Absensi --}}
        <div class="flex flex-col mt-8">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border rounded-lg divide-y divide-gray-200 dark:border-neutral-700 dark:divide-neutral-700">
                        <div class="py-3 px-4 flex justify-between items-center">
                            <div class="relative max-w-xs">
                                {{-- <label class="sr-only">Search</label>
                                <form action="{{ route('karyawan.absensi.index') }}" method="GET">
                                    <input type="text" name="search" id="hs-table-with-pagination-search"
                                        class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                        placeholder="Cari" value="{{ request('search') }}">
                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                        <svg class="size-4 text-gray-400 dark:text-neutral-500"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <path d="m21 21-4.3-4.3"></path>
                                        </svg>
                                    </div>
                                </form> --}}
                            </div>
                            <div class="relative inline-block">
                                <!-- Tombol Filter -->
                                <button id="filterPopoverButton" type="button"
                                    class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 focus:ring-2 focus:ring-teal-500">
                                    Filter
                                </button>

                                <!-- Popover dengan perbaikan positioning -->
                                <div id="filterPopoverContent"
                                    class="hidden absolute left-0 right-0 transform -translate-x-1/2 bg-white border border-gray-300 rounded-lg shadow-lg mt-2 p-4 z-50 w-64 max-w-xs">
                                    <form action="{{ route('karyawan.absensi.index') }}" method="GET">
                                        <!-- Input untuk memilih tanggal -->
                                        <label for="start_date" class="block text-sm font-medium text-gray-700">Dari
                                            Tanggal</label>
                                        <input type="date" id="start_date" name="start_date"
                                            value="{{ request('start_date') }}"
                                            class="border-gray-300 rounded-lg p-2 mt-1 w-full focus:ring-teal-500 focus:border-teal-500 dark:bg-neutral-800 dark:text-white">

                                        <label for="end_date" class="block text-sm font-medium text-gray-700 mt-4">Sampai
                                            Tanggal</label>
                                        <input type="date" id="end_date" name="end_date"
                                            value="{{ request('end_date') }}"
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

                        <div class="flex flex-col">
                            <div class="-m-1.5 overflow-x-auto">
                                <div class="p-1.5 min-w-full inline-block align-middle">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                            <thead>
                                                <tr>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                                        Tanggal</th>
                                                    {{-- <th scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                                        Nama</th> --}}
                                                    <th scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                                        Jam Masuk</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                                        Jam Keluar</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                                        Jumlah Jam</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                                        Status</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                                        Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                                @foreach ($absensi as $absen)
                                                    <tr class="hover:bg-gray-100 dark:hover:bg-neutral-700">
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $absen->created_at)->locale('id')->isoFormat('D/MM/YYYY') }}
                                                        </td>

                                                        {{-- <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                            {{ auth()->user()->name }}</td> --}}
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                            {{ $absen->check_in? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $absen->check_in)->locale('id')->isoFormat('HH:mm'): '-' }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                            {{ $absen->check_out? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $absen->check_out)->locale('id')->isoFormat('HH:mm'): '-' }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                            @if ($absen->check_in && $absen->check_out)
                                                                @php
                                                                    // Parse waktu check_in dan check_out menggunakan Carbon
                                                                    $checkIn = \Carbon\Carbon::parse($absen->check_in);
                                                                    $checkOut = \Carbon\Carbon::parse(
                                                                        $absen->check_out,
                                                                    );

                                                                    // Hitung selisih dalam detik
                                                                    $totalSeconds = $checkIn->diffInSeconds($checkOut);

                                                                    if ($totalSeconds < 60) {
                                                                        // Jika kurang dari 1 menit, tampilkan dalam detik saja
                                                                        $jumlahWaktu = $totalSeconds . ' detik';
                                                                    } elseif ($totalSeconds < 3600) {
                                                                        // Jika kurang dari 1 jam (60 menit), tampilkan dalam menit dan detik
                                                                        $menit = floor($totalSeconds / 60);
                                                                        $detik = $totalSeconds % 60;
                                                                        $jumlahWaktu =
                                                                            $menit . ' menit ' . $detik . ' detik';
                                                                    } else {
                                                                        // Jika lebih dari 1 jam, tampilkan dalam jam dan menit
                                                                        $jam = floor($totalSeconds / 3600);
                                                                        $sisaMenit = floor(($totalSeconds % 3600) / 60);
                                                                        $jumlahWaktu =
                                                                            $jam . ' jam ' . $sisaMenit . ' menit';
                                                                    }
                                                                @endphp
                                                                {{ $jumlahWaktu }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                            <span
                                                                class="
                                                                    inline-block w-20 px-3 py-1 text-sm font-medium text-center rounded-lg
                                                                    {{ $absen->status == 'masuk' ? 'bg-green-400 bg-opacity-70 text-white' : '' }}
                                                                    {{ $absen->status == 'sakit' ? 'bg-orange-400 bg-opacity-70 text-white' : '' }}
                                                                    {{ $absen->status == 'izin' ? 'bg-yellow-400 bg-opacity-70 text-white' : '' }}
                                                                    {{ $absen->status == 'tidak masuk' ? 'bg-red-400 bg-opacity-70 text-white' : '' }}
                                                                ">
                                                                {{ ucfirst($absen->status) }}
                                                            </span>
                                                        </td>


                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                                            @if ($absen->status == 'working')
                                                                <button type="button"
                                                                    class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800">Checkout</button>
                                                            @else
                                                                <span
                                                                    class="inline-flex justify-center items-center size-[46px] rounded-full text-gray-700 dark:text-neutral-400">
                                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                                        aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" fill="none"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke="currentColor" stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                    </svg>

                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-1 px-4">
                            <nav class="flex items-center space-x-1" aria-label="Pagination">
                                {{-- {{ $absensi->links() }} --}}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
