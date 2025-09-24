@extends('layouts.theme')

@section('content')
    <div class="container">
        <!-- Judul Absensi dengan ukuran lebih besar -->
        <h1 class="text-4xl font-semibold mb-6">Manajemen Absensi</h1>

        {{-- Riwayat Absensi --}}
        <div class="flex flex-col mt-8">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border rounded-lg divide-y divide-gray-200 dark:border-neutral-700 dark:divide-neutral-700">
                        <div class="py-3 px-4 flex justify-between items-center">
                            <div class="relative max-w-xs">
                                <form method="GET" action="{{ route('manajemen.absensi.index') }}">
                                    <label class="sr-only" for="hs-table-with-pagination-search">Cari</label>
                                    <input type="text" name="search" id="hs-table-with-pagination-search"
                                        value="{{ request('search') }}"
                                        class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                        placeholder="Cari">
                                    <button type="submit" class="absolute inset-y-0 start-0 flex items-center ps-3">
                                        <svg class="size-4 text-gray-400 dark:text-neutral-500"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <path d="m21 21-4.3-4.3"></path>
                                        </svg>
                                    </button>
                                </form>

                            </div>

                            <div class="relative">
                                <!-- Tombol Filter -->
                                <button id="filterPopoverButton" type="button"
                                    class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 focus:ring-2 focus:ring-teal-500">
                                    Filter
                                </button>

                                <!-- Popover dengan perbaikan positioning -->
                                <div id="filterPopoverContent"
                                    class="hidden absolute top-full left-0 transform translate-y-2 bg-white border border-gray-300 rounded-lg shadow-lg p-4 z-50 w-64 max-w-xs">
                                    <form action="{{ route('manajemen.absensi.index') }}" method="GET">
                                        <label for="start_date" class="block text-sm font-medium text-gray-700">Nama</label>
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="Cari Nama"
                                            class="border-gray-300 rounded-lg p-2 mt-1 w-full focus:ring-teal-500 focus:border-teal-500 dark:bg-neutral-800 dark:text-white" />

                                        <!-- Input untuk memilih tanggal -->
                                        <label for="start_date" class="block text-sm font-medium text-gray-700 mt-4">Dari
                                            Tanggal</label>
                                        <input type="date" id="start_date" name="start_date"
                                            value="{{ request('start_date') }}"
                                            class="border-gray-300 rounded-lg p-2 mt-1 w-full focus:ring-teal-500 focus:border-teal-500 dark:bg-neutral-800 dark:text-white">

                                        <label for="end_date" class="block text-sm font-medium text-gray-700 mt-4">Sampai
                                            Tanggal</label>
                                        <input type="date" id="end_date" name="end_date"
                                            value="{{ request('end_date') }}"
                                            class="border-gray-300 rounded-lg p-2 mt-1 w-full focus:ring-teal-500 focus:border-teal-500 dark:bg-neutral-800 dark:text-white">
                                        <div>
                                            <label for="end_date"
                                                class="block text-sm font-medium text-gray-700 mt-4">Status</label>
                                            <select name="status"
                                                class="order-gray-300 rounded-lg p-2 mt-1 w-full focus:ring-teal-500 focus:border-teal-500 dark:bg-neutral-800 dark:text-white">
                                                <option value="">Semua Status </option>
                                                <option value="masuk" {{ request('status') == 'masuk' ? 'selected' : '' }}>
                                                    Masuk</option>
                                                <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>
                                                    Sakit</option>
                                                <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>
                                                    Izin</option>
                                                <option value="tidak masuk"
                                                    {{ request('status') == 'tidak masuk' ? 'selected' : '' }}>Tidak Masuk
                                                </option>
                                            </select>
                                        </div>
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
                                                    <th scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                                        Nama</th>
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
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                                @foreach ($absensi as $absen)
                                                    <tr class="hover:bg-gray-100 dark:hover:bg-neutral-700">
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $absen->created_at)->locale('id')->isoFormat('D/MM/YYYY') }}
                                                        </td>

                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                            {{ $absen->user->name }}</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                            {{ $absen->check_in? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $absen->check_in)->locale('id')->isoFormat('HH:mm, D MMMM YYYY'): '-' }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                            {{ $absen->check_out? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $absen->check_out)->locale('id')->isoFormat('HH:mm, D MMMM YYYY'): '-' }}
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
            const margin = 30; // Margin 20px dari sisi layar

            // Reset posisi popover
            popover.style.left = '0px';
            popover.style.right = '0px';

            // Cek apakah popover melebihi sisi kanan layar
            if (popoverRect.right > screenWidth - margin) {
                const overflowRight = popoverRect.right - screenWidth + margin;
                popover.style.left = `-${overflowRight}px`; // Geser ke kiri
            }

            popover.style.zIndex = '50';

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
