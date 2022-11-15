@extends('layouts.layout-main')
@section('content')
    <div class="container">

        @if (session()->has('success'))
            <div id="alert-border-3" class="mb-4 flex border-t-4 border-green-500 bg-green-100 p-4 dark:bg-green-200"
                role="alert">
                <svg class="h-5 w-5 flex-shrink-0 text-green-700" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"></path>
                </svg>
                <div class="ml-3 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>
                <button type="button"
                    class="-mx-1.5 -my-1.5 ml-auto inline-flex h-8 w-8 rounded-lg bg-green-100 p-1.5 text-green-500 hover:bg-green-200 focus:ring-2 focus:ring-green-400 dark:bg-green-200 dark:hover:bg-green-300"
                    data-dismiss-target="#alert-border-3" aria-label="Close">
                    <span class="sr-only">Dismiss</span>
                    <svg aria-hidden="true" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 lg:gap-8">

            <div class="col-span-12">
                <div
                    class="rounded border border-gray-200 bg-white px-5 py-4 text-black sm:flex sm:items-center sm:justify-center">
                    <div class="mt-3 inline-block sm:mt-0">
                        <div class="text-sm font-light">
                            @include('pages.product.navtab-harga')
                        </div>
                    </div>
                </div>

                <div id="products-grid" class="py-3">
                    <div class="grid grid-flow-row grid-cols-2 gap-2 xs:gap-4 sm:gap-6 md:grid-cols-5 lg:gap-4">
                        @foreach ($products as $product)
                            <form action="{{ route('cart.store') }}" method="post">
                                @csrf
                                <div class="mb-2 h-full w-full overflow-hidden rounded bg-white p-2 shadow-md">
                                    <?php echo '<img src="data:image/BIN;base64,' . base64_encode($product->gbr) . '" class="h-auto max-w-full rounded-md border border-gray-300 bg-white p-1"/>'; ?>
                                    <div class="p-2">
                                        <span class="text-xs text-slate-600">{{ $product->kategori ?? '' }}</span>

                                        <h5 class="text-sm font-medium uppercase tracking-tight hover:text-[#f53b16]">
                                            {{ $product->nama_produk }}
                                        </h5>

                                        <div class="mt-1">
                                            <span class="inline-block text-lg font-semibold text-[#f53b16]">Rp.
                                                {{ number_format($product->harga_jual_umum, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <input type="hidden" name="no_faktur_jual" id="no_faktur_jual"
                                            value="{{ $no_faktur_jual }}">
                                        <input type="hidden" name="barcode" id="barcode" value="{{ $product->barcode }}">
                                        <input type="hidden" name="kd_produk" id="kd_produk"
                                            value="{{ $product->kd_produk }}">
                                        <input type="hidden" name="nama_produk" id="nama_produk"
                                            value="{{ $product->nama_produk }}">
                                        <input type="hidden" name="jumlah" id="jumlah" value="1">
                                        <input type="hidden" name="satuan" id="satuan" value="{{ $product->satuan }}">
                                        <input type="hidden" name="harga_jual" id="harga_jual"
                                            value="{{ $product->harga_jual_umum }}">
                                        <input type="hidden" name="dis" id="dis"
                                            value="{{ $product->diskon_periode }}">
                                        <input type="hidden" name="netto" id="netto" value="">
                                        <input type="hidden" name="total" id="total" value="">
                                        <input type="hidden" name="umum_member" id="umum_member" value="UMUM">
                                        <input type="hidden" name="harga_beli" id="harga_beli"
                                            value="{{ $product->harga_beli }}">
                                        <input type="hidden" name="deskripsi" id="deskripsi"
                                            value="{{ $product->deskripsi }}">
                                        <input type="hidden" name="cash_back" id="cash_back"
                                            value="{{ $product->cash_back }}">
                                        <input type="hidden" name="status_tabungan" id="status_tabungan"
                                            value="{{ $product->status_tabungan }}">
                                        <input type="hidden" name="qty_conversi" id="qty_conversi" value="">
                                        <input type="hidden" name="simpanan_tomember" id="simpanan_tomember"
                                            value="">
                                        <input type="hidden" name="waktu" id="waktu"
                                            value="{{ $waktu }}">
                                        <input type="hidden" name="user" id="user"
                                            value="{{ auth()->user()->username ?? '' }}">

                                        <button type="submit" id="tambah" value="{{ $product->kd_produk }}"
                                            class="rounded-md bg-[#f54c2a] p-1 text-white md:p-2"><i
                                                class="fa fa-shopping-cart"></i>
                                            Tambah</button>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    </div>
                    <div class="mx-10 mt-4 sm:mx-7">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
