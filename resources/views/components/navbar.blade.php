<header class="sticky top-0 z-50 w-full bg-white text-sm py-3 dark:bg-neutral-800">
    <nav class="max-w-[85rem] w-full mx-auto px-4 flex items-center justify-between">
        <!-- Logo atau Judul Situs -->
        <div class="flex items-center">
            {{-- <a href="{{ url('/') }}" class="text-xl font-bold">Your Logo</a> --}}
        </div>

        <!-- Navigasi Utama -->
        <div class="flex items-center space-x-4">
            <!-- Dark Mode Dropdown -->
            <button type="button"
                class="hs-dark-mode-active:hidden block hs-dark-mode font-medium text-gray-800 rounded-full hover:bg-gray-200 focus:outline-none focus:bg-gray-200 dark:text-neutral-200 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                data-hs-theme-click-value="dark">
                <span class="group inline-flex shrink-0 justify-center items-center size-9">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
                    </svg>
                </span>
            </button>
            <button type="button"
                class="hs-dark-mode-active:block hidden hs-dark-mode font-medium text-gray-800 rounded-full hover:bg-gray-200 focus:outline-none focus:bg-gray-200 dark:text-neutral-200 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                data-hs-theme-click-value="light">
                <span class="group inline-flex shrink-0 justify-center items-center size-9">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="4"></circle>
                        <path d="M12 2v2"></path>
                        <path d="M12 20v2"></path>
                        <path d="m4.93 4.93 1.41 1.41"></path>
                        <path d="m17.66 17.66 1.41 1.41"></path>
                        <path d="M2 12h2"></path>
                        <path d="M20 12h2"></path>
                        <path d="m6.34 17.66-1.41 1.41"></path>
                        <path d="m19.07 4.93-1.41 1.41"></path>
                    </svg>
                </span>
            </button>


            <!-- Main Dropdown -->
            <div class="hs-dropdown relative">
                <button id="hs-navbar-dropdown" type="button"
                    class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-400 dark:hs-accordion-active:text-white dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                    aria-haspopup="true">
                    {{ Auth::user()->name }}
                    <svg class="ms-2 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </button>

                <div class="hs-dropdown-menu hidden absolute z-10 mt-2 min-w-[120px] bg-white shadow-md rounded-lg p-1 dark:bg-neutral-800 dark:text-neutral-400"
                    aria-labelledby="hs-navbar-dropdown">
                    <a href="#" class="block px-3 py-2 hover:bg-gray-100 dark:hover:bg-neutral-700">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block px-3 py-2 hover:bg-gray-100 dark:hover:bg-neutral-700">
                            Logout
                        </button>
                    </form>

                    {{-- <div class="hs-dropdown relative">
                        <button type="button"
                            class="hs-dropdown-toggle w-full flex justify-between items-center px-3 py-2 hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-400">
                            Sub Menu
                            <svg class="ms-2 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </button>

                        <!-- Sub Menu -->
                        <div
                            class="hs-dropdown-menu hidden z-10 bg-white shadow-md rounded-lg p-2 dark:bg-neutral-800 dark:text-neutral-400">
                            <a href="#" class="block px-3 py-2 hover:bg-gray-100 dark:hover:bg-neutral-700">
                                Sub Item 1
                            </a>
                            <a href="#"
                                class="block px-3 py-2 hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-400">
                                Sub Item 2
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </nav>
</header>
