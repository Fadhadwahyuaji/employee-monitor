@extends('layouts.theme')

@section('content')
    <div class="container">
        <!-- Judul Absensi dengan ukuran lebih besar -->
        <h1 class="text-4xl font-semibold mb-6">Manajemen User</h1>
        <div class="flex justify-end mb-4">
            <button type="button"
                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-500 shadow-sm hover:bg-gray-100 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:text-neutral-400 dark:border-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-scale-animation-modal"
                data-hs-overlay="#hs-scale-animation-modal">
                Tambah User
            </button>
        </div>
        {{-- @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 dark:bg-green-900 dark:text-green-200">
                {{ session('success') }}
            </div>
        @else
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-red-100 dark:bg-red-900 dark:text-red-200">
                Gagal
            </div>
        @endif --}}
        {{-- List User --}}
        <div class="flex flex-col mt-8">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border rounded-lg divide-y divide-gray-200 dark:border-neutral-700 dark:divide-neutral-700">
                        <div class="py-3 px-4">
                            <div class="relative max-w-xs">
                                <form method="GET" action="{{ route('admin.user.index') }}">
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
                                                        Email</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                                        Role</th>
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
                                                            {{ $user->email }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                            {{ $user->roles->pluck('name')->implode(', ') ?? 'Belum Tersedia' }}
                                                        </td>



                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium flex justify-end space-x-2">
                                                            <button class="" id="update-button-{{ $user->id }}"
                                                                onclick="toggleModal('update-modal-{{ $user->id }}')"
                                                                aria-haspopup="dialog" aria-expanded="false"
                                                                aria-controls="update-modal-{{ $user->id }}"
                                                                data-hs-overlay="#update-modal-{{ $user->id }}">
                                                                <svg class="w-6 h-6 text-yellow-400 dark:text-white"
                                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" fill="none"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                                                </svg>
                                                            </button>
                                                            <form action="{{ route('admin.user.destroy', $user->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $user->name }}?');"
                                                                class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="focus:outline-none">
                                                                    <svg class="w-6 h-6 text-red-800 dark:text-white"
                                                                        aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" fill="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path fill-rule="evenodd"
                                                                            d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </button>
                                                            </form>
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

        {{-- Modal --}}
        <div id="hs-scale-animation-modal"
            class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog" tabindex="-1" aria-labelledby="hs-scale-animation-modal-label">
            <div
                class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center justify-center">
                <div
                    class="w-full max-w-md bg-white border shadow-lg rounded-xl p-6 pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="hs-scale-animation-modal-label"
                            class="text-xl font-semibold text-gray-800 dark:text-white">
                            Tambah User</h3>
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

                    <form action="{{ route('admin.user.store') }}" method="POST">
                        @csrf

                        <!-- Nama User -->
                        <div class="mb-4">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Nama</label>
                            <input type="text" id="name" name="name"
                                class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white dark:focus:ring-teal-500"
                                placeholder="Masukkan Nama" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Email</label>
                            <input type="email" id="email" name="email"
                                class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white dark:focus:ring-teal-500"
                                placeholder="Masukkan Email" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Kata
                                Sandi</label>
                            <input type="password" id="password" name="password"
                                class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white dark:focus:ring-teal-500"
                                placeholder="Masukkan Kata Sandi" required>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 dark:text-neutral-300">
                                Konfirmasi Kata Sandi
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white dark:focus:ring-teal-500"
                                placeholder="Konfirmasi Kata Sandi" required>
                        </div>

                        <!-- Pilih Role -->
                        <!-- Pilih Role -->
                        <div class="mb-4">
                            <label for="role"
                                class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Role</label>
                            <div class="flex flex-wrap gap-4 mt-2">
                                <div class="flex items-center">
                                    <input id="role-admin" name="role[]" type="checkbox" value="admin"
                                        class="h-4 w-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:focus:ring-teal-500">
                                    <label for="role-admin" class="ml-2 text-sm text-gray-700 dark:text-neutral-300">
                                        Admin
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="role-manajemen" name="role[]" type="checkbox" value="manajemen"
                                        class="h-4 w-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:focus:ring-teal-500">
                                    <label for="role-manajemen" class="ml-2 text-sm text-gray-700 dark:text-neutral-300">
                                        Manajemen
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="role-karyawan" name="role[]" type="checkbox" value="karyawan"
                                        class="h-4 w-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:focus:ring-teal-500">
                                    <label for="role-karyawan" class="ml-2 text-sm text-gray-700 dark:text-neutral-300">
                                        Karyawan
                                    </label>
                                </div>
                            </div>
                            <small class="text-gray-500 dark:text-neutral-400">Centang untuk memilih role user.</small>
                        </div>



                        <!-- Submit Button -->
                        <div class="flex justify-between items-center">
                            <button type="submit"
                                class="w-full py-2 px-4 bg-teal-600 text-white font-semibold rounded-lg shadow-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-teal-700 dark:hover:bg-teal-600 dark:focus:ring-teal-500">
                                Tambah User
                            </button>
                        </div>
                    </form>

                    <!-- Cancel Button -->
                    <div class="flex justify-center items-center mt-4">
                        <button type="button"
                            class="w-full py-2 px-4 bg-gray-200 text-gray-800 font-semibold rounded-lg shadow-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:bg-neutral-700 dark:text-white dark:hover:bg-neutral-600 dark:focus:ring-neutral-500"
                            data-hs-overlay="#hs-scale-animation-modal">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($users as $user)
            <!-- Modal Update user -->
            <div id="update-modal-{{ $user->id }}"
                class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none"
                role="diauser" tabindex="-1" aria-labelledby="update-modal-{{ $user->id }}-label">
                <div
                    class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center justify-center">
                    <div
                        class="w-full max-w-md bg-white border shadow-lg rounded-xl p-6 pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                        <div class="flex justify-between items-center mb-4">
                            <h3 id="update-modal-{{ $user->id }}-label"
                                class="text-xl font-semibold text-gray-800 dark:text-white">
                                Update User</h3>
                            <button type="button"
                                class="text-gray-400 hover:text-gray-600 dark:text-neutral-400 dark:hover:text-white"
                                aria-label="Close" data-hs-overlay="#update-modal-{{ $user->id }}">
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M18 6L6 18"></path>
                                    <path d="M6 6L18 18"></path>
                                </svg>
                            </button>
                        </div>

                        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nama User -->
                            <div class="mb-4">
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Nama</label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $user->name) }}"
                                    class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white dark:focus:ring-teal-500"
                                    placeholder="Masukkan Nama" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Email</label>
                                <input type="email" id="email" name="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white dark:focus:ring-teal-500"
                                    placeholder="Masukkan Email" required>
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password"
                                    class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Kata
                                    Sandi</label>
                                <input type="password" id="password" name="password"
                                    class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white dark:focus:ring-teal-500"
                                    placeholder="Masukkan Kata Sandi">
                                <small class="text-gray-500 dark:text-neutral-400">Kosongkan jika tidak ingin mengganti
                                    kata sandi.</small>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="mb-4">
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700 dark:text-neutral-300">
                                    Konfirmasi Kata Sandi
                                </label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white dark:focus:ring-teal-500"
                                    placeholder="Konfirmasi Kata Sandi">
                            </div>


                            <!-- Pilih Role -->
                            <!-- Pilih Role -->
                            <div class="mb-4">
                                <label for="role"
                                    class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Role</label>
                                <div class="flex flex-wrap gap-4 mt-2">
                                    @foreach ($roles as $role)
                                        <div class="flex items-center">
                                            <input id="role-{{ $role->id }}" name="role[]" type="checkbox"
                                                value="{{ $role->name }}"
                                                {{ $user->roles->contains('name', $role->name) ? 'checked' : '' }}
                                                class="h-4 w-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-600 dark:focus:ring-teal-500">
                                            <label for="role-{{ $role->id }}"
                                                class="ml-2 text-sm text-gray-700 dark:text-neutral-300">
                                                {{ ucfirst($role->name) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-gray-500 dark:text-neutral-400">Centang untuk memilih role user.</small>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-between items-center">
                                <button type="submit"
                                    class="w-full py-2 px-4 bg-teal-600 text-white font-semibold rounded-lg shadow-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-teal-700 dark:hover:bg-teal-600 dark:focus:ring-teal-500">
                                    Perbarui User
                                </button>
                            </div>
                        </form>

                        <div class="flex justify-center items-center mt-4">
                            <button type="button"
                                class="w-full py-2 px-4 bg-gray-200 text-gray-800 font-semibold rounded-lg shadow-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:bg-neutral-700 dark:text-white dark:hover:bg-neutral-600 dark:focus:ring-neutral-500"
                                data-hs-overlay="#update-modal-{{ $user->id }}">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{-- // modal update --}}

    </div>
    <!-- Initialize Choices.js -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectElement = document.getElementById('role');
            var choices = new Choices(selectElement, {
                removeItemButton: true,
                maxItemCount: 3, // Optional: batas maksimal pilihan yang bisa dipilih
                searchEnabled: true, // Menambahkan pencarian dalam dropdown
            });
        });
    </script>
@endsection
