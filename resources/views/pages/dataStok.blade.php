<h1 class="mt-3 mb-2 text-center text-lg">Menurut pencarian nama produk</h1>
<form method="get">
    <div class="relative mx-auto mt-3 w-52">
        <input type="search" id="search-dropdown" value="{{ request('search') }}"
            class="z-20 block w-full rounded-r-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-[#c51826] focus:ring-[#c51826] sm:rounded-l-none"
            placeholder="Cari nama produk..." name="search">
        <button type="submit"
            class="absolute top-0 right-0 rounded-r-lg border border-[#f53b16] bg-[#f53b16] p-2.5 text-sm font-medium text-white hover:bg-[#ac1521] focus:outline-none focus:ring-4 focus:ring-red-300">
            <svg aria-hidden="true" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <span class="sr-only">Cari</span>
        </button>
    </div>
</form>
<div class="container mt-2">
    <div class="relative mt-3 overflow-x-auto shadow-md sm:rounded-lg">
        <table class="mt-2 w-full text-left text-sm text-gray-500 dark:text-gray-400">
            <thead
                class="border-b border-t bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-3 text-center">
                        Aksi
                    </th>
                    <th scope="col" class="py-3 px-3">
                        Nama Produk / barcode
                    </th>
                    <th scope="col" class="py-3 px-3">
                        Jumlah stok baru
                    </th>
                    <th scope="col" class="py-3 px-3">
                        stok lama
                    </th>
                    <th scope="col" class="py-3 px-3">
                        satuan
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $key => $b)
                    <tr
                        class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">

                        <form action="{{ route('storeSearch') }}" method="POST">
                            @csrf
                            <input type="hidden" name="kd_produk" value="{{ $b->kd_produk }}" id="kd_produk">

                            <td class="py-1 px-3 text-center font-semibold text-gray-700 dark:text-white">
                                <button type="submit" id="addSearch"
                                    class="mx-auto mt-3 rounded-lg bg-green-400 p-2 text-sm text-white hover:bg-green-600">
                                    Tambah</button>
                            </td>
                            <td class="py-1 px-3 font-semibold text-gray-700 dark:text-white">
                                {{ $b->nama_produk }} <br>
                                <span class="mt-2 text-gray-500">{{ $b->pecah->barcode }}</span>
                            </td>
                            <td class="mx-auto items-center justify-between py-1 px-3">
                                <div class="text-center">
                                    <input type="number" id="stokAfter"
                                        class="block w-14 rounded-lg border border-gray-300 bg-gray-50 px-2.5 py-1 text-center text-sm text-gray-700 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                        placeholder="1" required="" min="1" value="1" name="stokAfter"
                                        value="1">
                                    {{-- {{ $b->qty }} --}}
                                </div>
                            </td>
                            <td class="py-1 px-3 font-semibold text-gray-700 dark:text-white">
                                {{ $b->stok_satuan_dasar / $b->pecah->nilai_satuan_dasar }}
                                <input type="hidden"
                                    value="{{ $b->stok_satuan_dasar / $b->pecah->nilai_satuan_dasar }}"
                                    name="stokBefore" id="stokBefore">
                            </td>
                            <td class="py-1 px-3 font-semibold text-gray-700 dark:text-white">
                                {{ $b->satuan_dasar }}
                            </td>
                        </form>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3 md:mt-10">
        {{ $products->links() }}
    </div>
</div>
