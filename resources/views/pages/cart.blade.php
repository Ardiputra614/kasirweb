@extends('layouts.layout-main')
@section('content')
    @if ($brg->count() == '')
        <div class="mx-auto mb-80">
            <div class="mb-4 flex justify-center rounded-lg bg-blue-100 p-4 text-sm text-blue-700 dark:bg-blue-200 dark:text-blue-800"
                role="alert">
                <svg aria-hidden="true" class="mr-3 inline h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Belum ada barang yang ditambah ke keranjang!</span>
                    <a href="/products"
                        class="hidden rounded-lg bg-blue-600 p-1 text-white hover:bg-blue-800 md:p-2">Belanja <i
                            class="fa fa-circle-right"></i></a>
                </div>
            </div>
        </div>
    @else
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

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                #
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Gambar
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Nama Produk
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Jumlah
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Harga
                            </th>
                            <th scope="col" class="py-3 px-6">
                                SubTotal
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brg as $key => $b)
                            <tr
                                class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                                <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">
                                    {{ $key + 1 }}
                                </td>
                                <td class="w-32 p-4">
                                    @if ($b->pecah->gbr == '')
                                        <img src="https://res.cloudinary.com/smegamart-softdev/image/upload/v1663833101/products/produk_fwzfro.jpg"
                                            alt="Apple Watch" class="h-8 w-8">
                                    @else
                                        {{-- <img src="{{ $b->pecah->gbr }}" alt="Apple Watch" class="h-8 w-8"> --}}
                                        <?php echo '<img src="data:image/BIN;base64,' . base64_encode($b->pecah->gbr) . '" class="h-10 w-10 rounded-md border border-gray-300 bg-white p-1"/>'; ?>
                                    @endif
                                </td>
                                <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">
                                    {{ $b->nama_produk }}
                                </td>
                                <form action="{{ route('cart.update', [$b->no]) }}" method="POST">
                                    @method('put')
                                    @csrf
                                    <td class="mx-auto items-center justify-between py-4 px-6">
                                        <div class="text-center">
                                            <input type="number" id="jumlah" name="jumlah"
                                                class="block w-14 rounded-lg border border-gray-300 bg-gray-50 px-2.5 py-1 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                                placeholder="1" required="" min="1" value="{{ $b->jumlah }}">
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">
                                        {{ number_format($b->harga_jual, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">
                                        {{ number_format($b->jumlah * $b->harga_jual, 0, ',', '.') }}
                                    </td>
                                    <td class="flex py-4 px-6">

                                        <input type="hidden" value="{{ $b->harga_jual }}" name="harga_jual">
                                        <input type="hidden" value="{{ $b->dis }}" name="dis">
                                        <button type="submit"
                                            class="mx-1 rounded-lg bg-yellow-400 p-2 font-medium text-white dark:text-white">Update
                                        </button>
                                </form>
                                <form action="{{ route('cart.destroy', $b->no) }}" method="post">
                                    @method('delete')
                                    @csrf
                                    <button type="submit"
                                        class="rounded-lg bg-red-600 p-2 font-medium text-white dark:text-white"
                                        onclick="return confirm('Yakin barang dihapus')">Hapus
                                    </button>
                                </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- <button type="submit">Simpan</button> --}}
        </div>
        {{-- </form> --}}

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
            <div></div>
            {{-- <div id="formTransaksi"></div> --}}
            <form action="/simpan" method="POST">
                @csrf

                @foreach ($brg as $b)
                    {{-- inputan penjualan_fix --}}
                    <input type="hidden" name="no_faktur_jual" id="no_faktur_jual" value="{{ $b->no_faktur_jual }}">
                    <input type="hidden" name="tgl_jual" id="tgl_jual" value="{{ $b->waktu }}">
                    <input type="hidden" name="total" id="total" value="{{ $brg->sum('total') }}">
                    <input type="hidden" name="disc" id="disc" value="{{ $brg->sum('disc') }}">
                    <input type="hidden" name="netto" id="netto" value="{{ $brg->sum('netto') }}">
                    <input type="hidden" name="grand_total" id="grand_total"
                        value="{{ $brg->sum('total') - $brg->sum('disc') }}">
                    <input type="hidden" name="operator" id="operator" value="{{ $b->user }}">
                    <input type="hidden" name="ppn" id="ppn" value="">
                    <input type="hidden" name="br" id="br" value="{{ $b->umum_member }}">
                    <input type="hidden" name="nominal_tabungan" id="nominal_tabungan"
                        value="{{ $b->nominal_tabungan }}">
                    <input type="hidden" name="nominal_utang" id="nominal_utang" value="{{ $b->nominal_utang }}">
                    <input type="hidden" name="nabung_jujulan" id="nabung_jujulan" value="{{ $b->nabung_jujulan }}">
                @endforeach

                <div class="m-3">
                    <div class="grid w-full grid-cols-1">
                        <div class="my-3">
                            <div class="grid grid-cols-2 gap-7">
                                <b class="text-center">Pelanggan ?</b>
                                <select name="kd_pelanggan" id="kd_pelanggan">
                                    <option value="">Pilih Pelanggan ?</option>
                                    @foreach ($pelanggan as $p)
                                        <option value="{{ $p->kd_pelanggan }}">{{ $p->nama_pelanggan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="my-3">
                            <div class="grid grid-cols-2 gap-7">
                                <b class="text-center">Jenis Bayar:</b>
                                <div class="grid grid-cols-1">
                                    <div>
                                        <select name="tunai_kredit" id="tunai_kredit" class="w-full" required>
                                            <option value="" selected>Pilih Metode Bayar</option>
                                            <option value="TUNAI">Tunai</option>
                                            <option value="KREDIT">Kredit</option>
                                            <option value="KARTU DEBET/KREDIT">Kartu Debet/Kredit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="my-3">
                                <div class="grid grid-cols-2 gap-7">
                                    <b class="text-center">Ongkir:</b>
                                    <input type="number" name="ongkir" id="ongkir" placeholder="contoh: 15000"
                                        required>
                                </div>
                            </div>
                            <div class="my-3">
                                <div class="grid grid-cols-2 gap-7">
                                    <b class="text-center">Tanggal Ongkir:</b>
                                    <input type="date" data-date-format="DD/MM/YYYY" name="tgl_ongkir"
                                        id="tgl_ongkir" required>
                                </div>
                            </div>

                            <div id="selected"></div>

                            <div class="my-3">
                                <div class="grid grid-cols-2 gap-7">
                                    <b class="text-center">Total Produk:</b>
                                    <div id="total">{{ number_format($total, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="my-3">
                                <div class="grid grid-cols-2 gap-7">
                                    <b class="text-center">Grand Total:</b>
                                    <div id="grandTotal"></div>
                                </div>
                            </div>
                            <div class="my-3">
                                <div class="grid grid-cols-2 gap-7">
                                    <b class="text-center">Kembali:</b>
                                    <div id="kembali"></div>
                                </div>
                            </div>
                        </div>


                        <div class="grid grid-cols-2 gap-7">
                            {{-- <div><button class="right-0 rounded-md bg-gray-700 p-2 text-white"
                                    type="reset">Reset</button></div> --}}
                            <div></div>
                            <button type="submit"
                                class="text-semibold rounded-lg bg-blue-600 p-2 text-center text-sm text-white">Simpan
                                Transaksi</button>
                            <div></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // formTransaksi();

            $('#tunai_kredit').on('change', function() {
                const id = $('#tunai_kredit').val();
                if (id == 'TUNAI') {
                    $('#selected').html('');
                    $('#selected').append('<div class="my-3" id="selected">\
                                                                    <div class="grid grid-cols-2 gap-7">\
                                                                        <b class="text-center">Bayar:</b>\
                                                                        <input type="number" class="w-full p-2" id="bayar" name="bayar" placeholder="125000" required>\
                                                                    </div>\
                                                                </div>')
                } else if (id == 'KREDIT') {
                    $('#selected').html('');
                    $('#selected').append('<div class="my-3" id="selected">\
                                                                <div class="grid grid-cols-2 gap-7">\
                                                                    <b class="text-center">Tanggal Tempo:</b>\
                                                                    <input type="date" class="w-full p-2" id="tgl_tempo" name="tgl_tempo" required>\
                                                                </div>\
                                                            </div>')
                } else if (id == 'KARTU DEBET/KREDIT') {
                    $("#selected").html('');
                    $("#selected").append('<div class="my-3" id="selected">\
                                                        <div class="grid grid-cols-2 gap-7">\
                                                            <b class="text-center">Nama Bank</b>\
                                                            <input type="text" class="w-full p-2" id="nama_bank" name="nama_bank"\
                                                                placeholder="Nama Bank" required>\
                                                        </div>\
                                                        <div class="mt-1 grid grid-cols-2 gap-7">\
                                                            <b class="text-center">Nomor Kartu</b>\
                                                            <input type="text" class="w-full p-2" id="no_kartu_dk" name="no_kartu_dk"\
                                                                placeholder="NO Kartu" required>\
                                                        </div>\
                                                    </div>')
                } else {
                    $("#selected").html('');
                    $("#selected").append('');
                }
            });



            $(document).on("input", '#bayar', function(e) {
                e.preventDefault();
                var bayar = {
                    'bayar': $('#bayar').val(),
                    'ongkir': $('#ongkir').val(),
                }
                // console.log(bayar);

                $.ajax({
                    type: "GET",
                    url: "/detail/{no_faktur_jual}",
                    data: bayar,
                    dataType: "json",
                    success: function(response) {
                        var kembali = {
                            'kembali': bayar.bayar - (response.total + bayar.ongkir),
                        }
                        console.log(response.kembali);
                        $('#kembali').html('');
                        $('#kembali').append(
                            // '<div>'+ numThousand(kembali.kembali) + '</div>');
                            '<div>' + numThousand(response.kembali) + '</div>');
                    }
                })
            })


            $(document).on("input", '#ongkir', function(e) {
                e.preventDefault();
                var ongkir = {
                    'ongkir': $('#ongkir').val(),
                }
                // console.log(ongkir);

                $.ajax({
                    type: "GET",
                    url: "/detail/{no_faktur_jual}",
                    data: ongkir,
                    dataType: "json",
                    success: function(response) {
                        var grandTotal = {
                            'grandTotal': ongkir.ongkir + response.total,
                        }
                        console.log(response.grandTotal);
                        $('#grandTotal').html('');
                        $('#grandTotal').append(
                            // '<div>'+ numThousand(grandTotal.grandTotal) + '</div>');
                            '<div>' + numThousand(response.grandTotal) + '</div>');
                    }
                })
            })
        });
    </script>
@endsection
