<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Pembayaran</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

    <style>
        @page {
            margin: 0
        }

        body {
            margin: 0;
            font-size: 10px;
            font-family: monospace;
        }

        td {
            font-size: 10px;
        }

        .sheet {
            margin: 0;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
            page-break-after: always;
        }

        /** Paper sizes **/
        body.struk .sheet {
            width: 58mm;
        }

        body.struk .sheet {
            padding: 2mm;
        }

        .txt-left {
            text-align: left;
        }

        .txt-center {
            text-align: center;
        }

        .txt-right {
            text-align: right;
        }

        /** For screen preview **/
        @media screen {
            body {
                background: #e0e0e0;
                font-family: monospace;
            }

            .sheet {
                background: white;
                box-shadow: 0 .5mm 2mm rgba(0, 0, 0, .3);
                margin: 5mm;
            }
        }

        /** Fix for Chrome issue #273306 **/
        @media print {
            body {
                font-family: monospace;
            }

            body.struk {
                width: 58mm;
                text-align: left;
            }

            body.struk .sheet {
                padding: 2mm;
            }

            .txt-left {
                text-align: left;
            }

            .txt-center {
                text-align: center;
            }

            .txt-right {
                text-align: right;
            }

            .btn-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()" class="struk" class="justify-center">
    <div id="alert-border-3" class="btn-print mb-4 flex border-t-4 border-green-500 bg-green-100 p-4 dark:bg-green-200"
        role="alert">
        <svg class="h-5 w-5 flex-shrink-0 text-green-700" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                clip-rule="evenodd"></path>
        </svg>
        <div class="ml-3 text-sm font-medium text-green-700">
            Transaksi berhasil disimpan
        </div>
    </div>

    <div class="mb-2 text-center">
        <button class="btn-print rounded-md bg-blue-700 p-2 text-white md:p-3" onclick="window.print()">Print</button>
        <a href="/forgetSession" class="btn-print rounded-md bg-green-500 p-2 text-white md:p-3">Transaksi
            Baru</a>
    </div>

    <center>
        <section class="sheet">
            <div class="text-center">
                <h3 style="margin-bottom: 5px;">{{ $identitas->nama }}</h3>
                <p>{{ $identitas->alamat }}</p>
            </div>
            <br>
            <div>
                <p style="float: left;">{{ date('d-m-Y h:i:s') }}</p>
                <p style="float: right">{{ strtoupper(auth()->user()->username) }}</p>
            </div>
            <div class="clear-both" style="clear: both;"></div>
            <p class="text-left uppercase">No: {{ $detail->no_faktur_jual }}</p>
            <p class="text-center">=================================</p>

            <br>
            <table width="100%" style="border: 0;">
                @foreach ($product as $p)
                    <tr>
                        <td colspan="3">{{ ucfirst($p->nama_produk) }}</td>
                    </tr>
                    <tr>
                        <td>{{ $p->jumlah }} x {{ number_format($p->harga) }}</td>
                        <td></td>
                        <td class="text-right">{{ number_format($p->jumlah * $p->harga) }}</td>
                    </tr>
                @endforeach
            </table>
            <p class="text-center">---------------------------------</p>

            <table width="100%" style="border: 0;">
                <tr>
                    <td>Harga Produk:</td>
                    <td class="text-right">{{ number_format($detail->total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Total Item:</td>
                    <td class="text-right">{{ $product->sum('jumlah') }}</td>
                </tr>
                <tr>
                    <td>Diskon:</td>
                    <td class="text-right">{{ number_format($product->sum('disc'), 0, ',', '.') }}</td>
                </tr>

                @if ($detail->umum_member == 'KREDIT')
                    <tr>
                        <td>Nominal Utang:</td>
                        <td class="text-right">{{ number_format($detail->nominal_utang, 0, ',', '.') }}</td>
                    </tr>
                @endif
                @if ($detail->tgl_tempo !== '1970-01-01')
                    <tr>
                        <td>Tanggal Tempo:</td>
                        <td class="text-right">{{ date('d-m-y', strtotime($detail->tgl_tempo)) }}</td>
                    </tr>
                @endif
                @if ($detail->nama_bank !== '')
                    <tr>
                        <td>Nama Bank:</td>
                        <td class="text-right">{{ $detail->nama_bank }}</td>
                    </tr>
                @endif
                @if ($detail->no_kartu_dk !== '')
                    <tr>
                        <td>No kartu:</td>
                        <td class="text-right">{{ $detail->no_kartu_dk }}</td>
                    </tr>
                @endif
                <tr>
                    <td>Ongkir:</td>
                    <td class="text-right">{{ number_format($detail->ongkir, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Grand Total:</td>
                    <td class="text-right">{{ number_format($detail->grand_total, 0, ',', '.') }}</td>
                </tr>
                @if ($detail->tunai_kredit == 'TUNAI')
                    <tr>
                        <td>Kembali:</td>
                        <td class="text-right">
                            {{ number_format($detail->pembayaran - $detail->grand_total, 0, ',', '.') }}</td>
                    </tr>
                @endif
                @if ($detail->nominal_utang !== 0 and $detail->tunai_kredit == 'KREDIT')
                    <tr>
                        <td>Nominal Utang:</td>
                        <td class="text-right">{{ number_format($detail->nominal_utang, 0, ',', '.') }}</td>
                    </tr>
                @endif

            </table>

            <p class="text-center">=================================</p>
            <p class="text-center">-- TERIMA KASIH --</p>

        </section>
    </center>
    <script>
        window.setTimeout(function() {
            $("#alert-border-3").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 1000);

        let body = document.body;
        let html = document.documentElement;
        let height = Math.max(
            body.scrollHeight, body.offsetHeight,
            html.clientHeight, html.scrollHeight, html.offsetHeight
        );

        document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "innerHeight=" + ((height + 50) * 0.264583); <
        script >
            <
            /body>

            <
            /html>
