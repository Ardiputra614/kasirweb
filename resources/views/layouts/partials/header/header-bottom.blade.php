<div class="border-y border-gray-200 bg-white">
    <div class="container">
        <nav class="px-3">
            <div class="container relative flex flex-wrap items-center justify-between">
                <div class="flex">
                    <button type="button"
                        class="inline-flex items-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 md:hidden"
                        data-collapse-toggle="navbar-menu" aria-controls="navbar-menu" aria-expanded="false">
                        <span class="sr-only">Open Menu</span>
                        <svg class="h-6 w-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div id="navbar-menu"
                    class="absolute top-9 left-0 z-10 mx-auto hidden w-full items-center justify-between md:relative md:top-0 md:z-0 md:order-1 md:flex md:w-auto">
                    <ul
                        class="mt-4 flex flex-col rounded-lg border border-gray-100 bg-gray-50 p-3 shadow-lg md:mt-0 md:flex-row md:space-x-8 md:border-0 md:bg-white md:p-2 md:text-sm md:font-medium md:shadow-none">
                        <li>
                            <a href="/"
                                class="{{ request()->is('umum*') || request()->is('member*') || request()->is('grosir*') || request()->is('member-grosir*') ? 'text-white bg-[#f53b16]' : 'text-gray-700 hover:bg-gray-100' }} block rounded py-2 pr-4 pl-3">
                                Produk
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('stock.index') }}"
                                class="{{ request()->is('stock*') ? 'text-white bg-[#f53b16]' : 'text-gray-700 hover:bg-gray-100' }} block rounded py-2 pr-4 pl-3">
                                Stok
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cart.index') }}"
                                class="{{ request()->is('cart*') ? 'text-white bg-[#f53b16]' : 'text-gray-700 hover:bg-gray-100' }} block rounded py-2 pr-4 pl-3">
                                Keranjang
                            </a>
                        </li>
                    </ul>
                </div>
                {{-- <div class="absolute right-0 flex items-center">
                    <div class="relative">
                        <i class="fa-brands fa-instagram fa-xl"></i>
                    </div>
                </div> --}}
            </div>
        </nav>
    </div>
</div>
