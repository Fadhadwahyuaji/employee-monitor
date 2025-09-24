@extends('layouts.theme')

@section('content')
    <div class="container">
        <!-- Judul Absensi dengan ukuran lebih besar -->
        <h1 class="text-4xl font-semibold mb-6">Log Aktivitas Karyawan</h1>

        {{-- Riwayat Absensi --}}
        <div class="flex flex-col mt-8">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border rounded-lg divide-y divide-gray-200 dark:border-neutral-700 dark:divide-neutral-700">
                        <div class="py-3 px-4">
                            <form action="{{ route('manajemen.log.index') }}" method="GET" class="py-3 px-4">
                                <div class="relative max-w-xs">
                                    <label class="sr-only">Cari</label>
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
                                </div>
                            </form>

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
                                                        Nama</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                                        Posisi</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                                        Status</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                                        Tanggal Absen</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                                        Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                                @foreach ($users as $user)
                                                    <tr class="hover:bg-gray-100 dark:hover:bg-neutral-700">
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                                                            {{ $user->name }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                            {{ $user->nama }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                            <span
                                                                class="
                                                                inline-block w-20 px-3 py-1 text-sm font-medium text-center rounded-lg
                                                                {{ optional($user->absensis->last())->status == 'masuk' ? 'bg-green-400 bg-opacity-70 text-white' : '' }}
                                                                {{ optional($user->absensis->last())->status == 'sakit' ? 'bg-orange-400 bg-opacity-70 text-white' : '' }}
                                                                {{ optional($user->absensis->last())->status == 'izin' ? 'bg-yellow-400 bg-opacity-70 text-white' : '' }}
                                                                {{ optional($user->absensis->last())->status == 'tidak masuk' ? 'bg-red-400 bg-opacity-70 text-white' : '' }}
                                                                ">
                                                                {{ optional($user->absensis->last())->status ? ucfirst($user->absensis->last()->status) : 'Belum Tersedia' }}
                                                            </span>
                                                        </td>

                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                            {{ $user->absensis->last()? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->absensis->last()->created_at)->locale('id')->isoFormat(' dddd, D MMMM YYYY'): 'Belum Ada Data' }}
                                                        </td>



                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                                            <a href="{{ route('manajemen.log.detail', $user->id) }}">
                                                                <button type="button"
                                                                    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:bg-blue-100 hover:text-blue-800 focus:outline-none focus:bg-blue-100 focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:bg-blue-800/30 dark:hover:text-blue-400 dark:focus:bg-blue-800/30 dark:focus:text-blue-400">
                                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                                        aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" fill="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path fill-rule="evenodd"
                                                                            d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </button>
                                                            </a>

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
                                {{-- {{ $usersi->links() }} --}}
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
