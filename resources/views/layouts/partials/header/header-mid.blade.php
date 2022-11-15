<div class="@if (request()->is('/')) border-b @endif bg-white pt-2 lg:pt-0">
    <div class="container">
        <nav class="px-3 py-2 lg:py-3">
            <div class="container relative mx-auto flex flex-wrap items-center justify-between">
                <a href="/" class="px-2">
                    <span class="self-center whitespace-nowrap font-oswald text-3xl font-semibold">WSB POS</span>
                </a>

                @if (request()->is('umum*') || request('member*') || request('grosir*') || request('member-grosir*'))
                    <div class="px-2 md:basis-8/12">
                        <button type="button"
                            class="tex-gray-500 mr-1 rounded-lg p-2.5 text-sm hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 md:hidden"
                            data-collapse-toggle="navbar-search" aria-controls="navbar-search" aria-expanded="false">
                            <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Cari</span>
                        </button>
                        <div class="relative hidden items-center md:block">
                            <div class="relative mt-3 md:mt-0">
                                <form method="GET">
                                    <div class="flex">
                                        <select id="countries" name="category"
                                            class="z-10 flex-shrink-0 items-center rounded-l-lg border border-gray-300 bg-gray-100 py-2.5 pl-1 pr-3 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 sm:inline-flex sm:border-r-0">
                                            <option selected="" value="all" name="category">Kategori</option>
                                            @foreach (App\Models\Kategori::select('nama_kategori')->get() as $kategori)
                                                <option value="{{ $kategori->nama_kategori }}"
                                                    @if ($kategori->nama_kategori == request('category')) {{ 'selected' }} @endif>
                                                    {{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="relative w-full">
                                            <input type="search" id="search-dropdown" value="{{ request('search') }}"
                                                class="z-20 block w-full rounded-r-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-[#c51826] focus:ring-[#c51826] sm:rounded-l-none"
                                                placeholder="Cari produk..." name="search">
                                            <button type="submit"
                                                class="absolute top-0 right-0 rounded-r-lg border border-[#f53b16] bg-[#f53b16] p-2.5 text-sm font-medium text-white hover:bg-[#ac1521] focus:outline-none focus:ring-4 focus:ring-red-300">
                                                <svg aria-hidden="true" class="h-5 w-5" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                </svg>
                                                <span class="sr-only">Cari</span>
                                            </button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="navbar-search"
                        class="absolute top-9 left-0 z-10 hidden w-full items-center justify-between">
                        <div class="relative mt-3">
                            <form method="GET">
                                <div class="flex">
                                    <select id="countries" name="category"
                                        class="z-10 flex-shrink-0 items-center rounded-l-lg border border-gray-300 bg-gray-100 py-2.5 pl-1 pr-3 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 sm:inline-flex sm:border-r-0">
                                        <option selected="" value="all" name="category">Kategori</option>
                                        @foreach (App\Models\Kategori::select('nama_kategori')->get() as $kategori)
                                            <option value="{{ $kategori->nama_kategori }}"
                                                @if (request('category') == $kategori->nama_kategori) {{ 'selected' }} @endif>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="relative w-full">
                                        <input type="search" id="search-dropdown"
                                            class="z-20 block w-full rounded-r-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 shadow-lg focus:border-[#c51826] focus:ring-[#c51826] sm:rounded-l-none"
                                            placeholder="Cari produk..." name="search">
                                        <button type="submit"
                                            class="absolute top-0 right-0 rounded-r-lg border border-[#f53b16] bg-[#f53b16] p-2.5 text-sm font-medium text-white hover:bg-[#ac1521] focus:outline-none focus:ring-4 focus:ring-red-300">
                                            <svg aria-hidden="true" class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                            <span class="sr-only">Cari</span>
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                @if (!request()->is('/'))
                    <div id="cartsum" style="--fa-top:-10px; --fa-right:-5px; --fa-counter-scale:.4;"></div>
                @endif
            </div>
        </nav>
    </div>
</div>
