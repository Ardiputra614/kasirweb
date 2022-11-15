@extends('layouts.layout-main')
@section('content')
    <div class="container">
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
        </div>

        <div id="success"></div>
        <div id="error"></div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-5">
            <div>
                <label for="">Barcode</label>
                <input type="text" class="w-full rounded-lg border p-2" placeholder="Barcode" id="barcode"
                    name="barcode" autofocus>
                <input type="hidden" name="barcodeHidden" id="barcodeHidden">
                <input type="hidden" name="kd_produk" id="kdProduk">
                <input type="hidden" name="tgl_opname" id="tglOpname"
                    value="{{ date('Y-m-d', strtotime(Carbon\Carbon::now())) }}">
                <input type="hidden" name="user" id="user" value="{{ auth()->user()->username }}">
                <input type="hidden" name="nilai_satuan_dasar" id="nilai_satuan_dasar">
            </div>
            <div>
                <label for="">Jumlah stok baru</label>
                <input type="number" class="w-full rounded-lg border p-2" placeholder="stok baru" min="1"
                    id="stokAfter" name="stok_after">
            </div>
            <div>
                <label for="">Stok sebelumnya</label>
                <input type="text" class="w-full rounded-lg border bg-gray-100 p-2 uppercase"
                    placeholder="Stok Sebelumnya" disabled id="stokBefore" name="stok_before">
            </div>
            <div>
                <label for="">Nama Produk</label>
                <input type="text" class="w-full rounded-lg border bg-gray-100 p-2 uppercase" placeholder="Nama Produk"
                    disabled id="namaProduk">
            </div>
            <div>
                <label for="">Satuan</label>
                <input type="text" class="w-full rounded-lg border bg-gray-100 p-2" placeholder="Satuan" disabled
                    id="satuan">
            </div>
        </div>
        <button type="submit" class="mx-auto mt-3 rounded-lg bg-green-400 p-2 text-sm text-white hover:bg-green-600"
            id="btnTambah"><i class="fa fa-plus"></i>
            Tambah</button>
    </div>

    <div>
        @include('pages.dataStok')
    </div>


    <script src="/js/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}


    <script>
        function numThousand(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        let barcode = document.querySelector("#barcode");
        let barcodeHidden = document.querySelector("#barcodeHidden");
        let kdProduk = document.querySelector("#kdProduk");
        let namaProduk = document.querySelector("#namaProduk");
        let stokAfter = document.querySelector("#stokAfter");
        let satuan = document.querySelector("#satuan");
        let stokBefore = document.querySelector("#stokBefore");


        let btnTambah = document.querySelector("#btnTambah");

        barcode.addEventListener("input", function() {
            fetch(`/barcode-data?barcode=${barcode.value}`)
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    if (data.pecah !== null) {
                        // barcode.value = data.pecah.barcode;
                        barcodeHidden.value = data.pecah.barcode;
                        kdProduk.value = data.pecah.kd_produk;
                        namaProduk.value = data.pecah.namaProduk;
                        satuan.value = data.pecah.satuan;
                        stokBefore.value = data.pecah.stok_before;
                        nilai_satuan_dasar.value = data.pecah.nilai_satuan_dasar;
                    } else {
                        barcodeHidden.value = "";
                        namaProduk.value = "";
                        satuan.value = '';
                        stokBefore.value = '';
                        stokAfter.value = "";
                    }
                })
        });

        $(document).ready(function() {
            // dataSimpan();
            // simpan();

            $(document).on("click", '#btnTambah', function(e) {
                e.preventDefault();

                if (barcodeHidden.value == "") {
                    barcodeHidden.setCustomValidity("Isikan dahulu");
                    barcodeHidden.reportValidity("Isikan dahulu");
                    $('#error').html("");
                    $('#error').append('<div id="alert-border-2" class="flex p-4 mb-4 bg-red-100 border-t-4 border-red-500 dark:bg-red-200" role="alert">\
                                                                                    <svg class="flex-shrink-0 w-5 h-5 text-red-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>\
                                                                                    <div class="ml-3 text-sm font-medium text-red-700">\
                                                                                    Barcode harap diisi\
                                                                                    </div>\
                                                                                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 dark:bg-red-200 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 dark:hover:bg-red-300 inline-flex h-8 w-8"  data-dismiss-target="#alert-border-2" aria-label="Close">\
                                                                                    <span class="sr-only">Dismiss</span>\
                                                                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>\
                                                                                    </button>\
                                                                                </div>')
                    window.setTimeout(function() {
                        $("#error").fadeTo(500, 0).slideUp(500, function() {
                            $(this).remove();
                        });
                    }, 1000);
                    $('#barcode').focus();
                } else {
                    var nilai_satuan_dasar = $('#nilai_satuan_dasar').val();
                    var stokAfter = $('#stokAfter').val();
                    var qty_conversi = nilai_satuan_dasar * stokAfter;
                    console.log(nilai_satuan_dasar);
                    var data = {
                        'barcode': $('#barcode').val(),
                        'kd_produk': $('#kdProduk').val(),
                        'stok_before': $('#stokBefore').val(),
                        'stok_after': $('#stokAfter').val(),
                        'tgl_opname': $('#tglOpname').val(),
                        'qty_conversi': qty_conversi,
                        'user': $('#user').val(),
                    }
                    console.log(data);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    $.ajax({
                        type: "POST",
                        url: "{{ route('stock.store') }}",
                        data: data,
                        dataType: "json",
                        success: function(response) {
                            barcode.value = "";
                            barcodeHidden.value = "";
                            namaProduk.value = "";
                            satuan.value = "";
                            stokBefore.value = "";
                            stokAfter.value = "";
                            $("#success").html("");
                            $("#success").append(
                                '<div id="alert-border-3" class="mb-4 flex border-t-4 border-green-500 bg-green-100 p-4 dark:bg-green-200"\
                                                                                                                                                                                            role="alert">\
                                                                                                                                                                                            <svg class="h-5 w-5 flex-shrink-0 text-green-700" fill="currentColor" viewBox="0 0 20 20"\
                                                                                                                                                                                                xmlns="http://www.w3.org/2000/svg">\
                                                                                                                                                                                                <path fill-rule="evenodd"\
                                                                                                                                                                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"\
                                                                                                                                                                                                    clip-rule="evenodd"></path>\
                                                                                                                                                                                            </svg>\
                                                                                                                                                                                            <div class="ml-3 text-sm font-medium text-green-700">\
                                                                                                                                                                                                Berhasil ditambah\
                                                                                                                                                                                            </div>\
                                                                                                                                                                                        </div>'
                            );
                            window.setTimeout(function() {
                                $("#success").fadeTo(500, 0).slideUp(500, function() {
                                    $(this).remove();
                                });
                            }, 1000);
                            $('#barcode').focus();
                        }
                    })
                }
            });

        }); //Document stop
    </script>
@endsection
