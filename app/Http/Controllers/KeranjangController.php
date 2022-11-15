<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Pecah;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Penjualanfix;
use App\Models\Poin;
use App\Models\Penjualandetail;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $brg = Keranjang::where(['user' => auth()->user()->username ?? ''])->orderBy('id')->get();
        $pelanggan = Pelanggan::select('kd_pelanggan', 'nama_pelanggan')->get();
        $brg = Keranjang::where(['user' => auth()->user()->username ?? ''])->orderBy('no', 'desc')->get();

        if (request('ongkir') == '') {
            $total = $brg->sum('total');
        } else {
            // Penjualanfix::where($)
            $total = $brg->sum('total') - $brg->sum('dis');
        }

        // foreach ($total as $key => $value) {
        //   $total = $value->total;
        // }
        return view('pages.cart', [
            'title' => 'Keranjang',
            'brg' => $brg,
            'total' => $total,
            'pelanggan' => $pelanggan,
        ]);
    }

    public function detail($no_faktur_jual)
    {
        $now = date('Y-m-d', strtotime(Carbon::now()));
        // $no = Penjualanfix::count() + 1;
        // $noFaktur = "WSBB-00" . date('d-m-Y', strtotime(Carbon::now())) . $no;
        $brg = Keranjang::where(['user' => auth()->user()->username ?? ''])->orderBy('no', 'desc')->get();
        $penjualan = Penjualandetail::where('no_faktur_jual', $no_faktur_jual)->get();
        foreach ($penjualan as $key => $value) {
            $no_faktur_jual = $value->no_faktur_jual;
        }

        // $total = $brg->sum('total');
        $ongkir = request('ongkir');
        $total = $brg->sum('total');
        // dd($total);

        if (request('ongkir') == '') {
            $grandTotal = '';
        } else {
            $grandTotal = request('ongkir') + $total;
        }

        // if (request('ongkir') == '') {
        //   $total = intval($brg->sum('total')) + request('ongkir');
        // } else {
        //   $total = 00;
        // }

        if (request('bayar') == '') {
            $kembali = 0;
        } else {
            $kembali = request('bayar') - $grandTotal;
            // $kembali = request('bayar') - (request('ongkir') + $total);
        }

        // $poin1 = Poin::sum('harga_point');

        // $poin = $total / $poin1;


        // dd($kembali);

        return response()->json([
            'penjualan' => $penjualan,
            'total' => $total,
            // 'total2' => $total2,
            'grandTotal' => $grandTotal,
            'now' => $now,
            // 'poin' => $poin,
            'kembali' => $kembali,
            'pelanggan' => request('kd_pelanggan'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function simpan(Request $request)
    {
        $noFaktur = date('Ymd', strtotime(Carbon::now())) . Str::random(3);
        $dataKeranjang = Keranjang::where('user', auth()->user()->username)->get();
        $user = auth()->user()->username;

        $dataSet = [];
        foreach ($dataKeranjang as $d) {
            $dataSet[] = [
                // 'no_faktur_jual' => $d->no_faktur_jual,
                'no_faktur_jual' => $noFaktur,
                'barcode' => $d->barcode,
                'kd_produk' => $d->kd_produk,
                'nama_produk' => $d->nama_produk,
                'jumlah' => $d->jumlah,
                'satuan_jual' => $d->satuan,
                'harga' => $d->harga_jual,
                'disc' => $d->dis,
                'netto' => $d->netto,
                'total' => $d->total,
                'retur' => 0,
                'h_beli' => $d->harga_beli,
                'br' => $d->umum_member,
                'tgl_jual' => $request->tgl_jual,
                'deskripsi' => $d->deskripsi,
                'cash_back' => $d->cash_back,
                'status_tabungan' => $d->status_tabungan,
                'qty_conversi' => $d->qty_conversi,
            ];
        }
        // dd($dataKeranjang);
        DB::table('penjualan_det')->insert($dataSet);

        $date = date('Y-m-d', strtotime(Carbon::now()));

        // $simpanan_tomember = 1 / 100 * (total - sum(harga_beli * jumlah)); //rumus simpanan_tomember
        $pelanggan = Pelanggan::where('kd_pelanggan', $request->kd_pelanggan ?? '')->select('margin')->first();
        if ($request->kd_pelanggan == '') {
            $nominal_tabungan = 00;
        } else {
            $nominal_tabungan = $pelanggan->margin * $dataKeranjang->sum('simpanan_tomember');
        }

        $poin = Poin::select('harga_point', 'tgl_awal', 'tgl_akhir')->first();
        $datePoint = strtotime($poin->tgl_awal) <= strtotime(date('Y-m-d')) && strtotime($poin->tgl_akhir) >= strtotime(date('Y-m-d'));

        if ($datePoint && $request->kd_pelanggan != '') {
            $point = ($dataKeranjang->sum('total') + $request->ongkir) / $poin->harga_point;
        } else {
            $point = 00;
        }

        // dd($nominal_tabungan);
        if ($request->tunai_kredit == 'KREDIT') {
            $a = [
                // 'no_faktur_jual' => $dataSet[0]['no_faktur_jual'],
                'no_faktur_jual' => $noFaktur,
                'tgl_jual' => date('Y-m-d', strtotime($request->tgl_jual)),
                'kd_pelanggan' => $request->kd_pelanggan ?? '',
                'total' => $dataKeranjang->sum('total'),
                'pembayaran' => 00,
                // 'disc' => $dataKeranjang->sum('disc'),
                'disc' => 00,
                'grand_total' => $dataKeranjang->sum('total') + $request->ongkir,
                'operator' => $request->operator,
                'tunai' => 00,
                'ppn' => 0,
                'br' => $dataKeranjang[0]['umum_member'],
                'tunai_kredit' => $request->tunai_kredit,
                'tglbyr' => $date,
                // 'point' => ($dataKeranjang->sum('total') - $dataKeranjang->sum('disc')) / $poin,
                'point' => $point,
                'nominal_tabungan' => $nominal_tabungan,
                'nominal_utang' => $dataKeranjang->sum('total') + $request->ongkir ?? 00,
                'dkc' => $request->tunai_kredit,
                'nama_bank' => '',
                'no_kartu_dk' => '',
                'ongkir' => $request->ongkir,
                'tgl_ongkir' => $request->tgl_ongkir,
                'tgl_tempo' => $request->tgl_tempo,
                'nabung_jujulan' => 00,
            ];
            // dd($a);
            DB::table('penjualan_fix')->insert($a);
            session(['noFaktur' => $noFaktur]);
            DB::delete("DELETE FROM penjualan_b_copy WHERE user = '$user'");
            return redirect()->to('/print');
        } elseif ($request->tunai_kredit == 'KARTU DEBET/KREDIT') {
            $b = [
                'no_faktur_jual' => $noFaktur,
                'tgl_jual' => date('Y-m-d', strtotime($request->tgl_jual)),
                'kd_pelanggan' => $request->kd_pelanggan ?? '',
                'total' => $dataKeranjang->sum('total'),
                'pembayaran' => $request->bayar ?? $dataKeranjang->sum('total') - $dataKeranjang->sum('disc'),
                // 'disc' => $dataKeranjang->sum('disc'),
                'disc' => 00,
                'grand_total' => $dataKeranjang->sum('total') - $dataKeranjang->sum('disc'),
                'operator' => $request->operator,
                'tunai' => $dataKeranjang->sum('total') + $request->ongkir,
                'ppn' => 0,
                'br' => $dataKeranjang[0]['umum_member'],
                'tunai_kredit' => $request->tunai_kredit,
                'tglbyr' => $date,
                'point' => $point,
                'nominal_tabungan' => $nominal_tabungan,
                'nominal_utang' => $request->nominal_utang ?? 00,
                'dkc' => $request->tunai_kredit,
                'nama_bank' => $request->nama_bank,
                'no_kartu_dk' => $request->no_kartu_dk,
                'ongkir' => $request->ongkir,
                'tgl_ongkir' => $request->tgl_ongkir,
                'tgl_tempo' => $request->tgl_tempo ?? date('Y-m-d', strtotime(0)),
                'nabung_jujulan' => 00,
            ];
            // dd($b);
            DB::table('penjualan_fix')->insert($b);
            session(['noFaktur' => $noFaktur]);
            DB::delete("DELETE FROM penjualan_b_copy WHERE user = '$user'");
            return redirect()->to('/print');
            // return back()->with('success', 'Berhasil disimpan');
        } else {
            $data3 = [
                'no_faktur_jual' => $noFaktur,
                'tgl_jual' => date('Y-m-d', strtotime($request->tgl_jual)),
                'kd_pelanggan' => $request->kd_pelanggan ?? '',
                'total' => $dataKeranjang->sum('total'),
                'pembayaran' => $request->bayar ?? 00,
                'disc' => 00,
                'grand_total' => $dataKeranjang->sum('total') + $request->ongkir,
                'operator' => $request->operator,
                'tunai' => $request->bayar,
                'ppn' => 0,
                'br' => $request->br,
                'tunai_kredit' => $request->tunai_kredit,
                'tglbyr' => $date,
                // 'point' => ($dataKeranjang->sum('total') - $dataKeranjang->sum('disc')) / $poin,
                'point' => $point,
                'nominal_tabungan' => $nominal_tabungan,
                // 'nominal_utang' => $request->nominal_utang ?? '',
                'nominal_utang' => $request->nominal_utang ?? 00,
                'dkc' => $request->tunai_kredit,
                'nama_bank' => $request->nama_bank ?? '',
                'no_kartu_dk' => $request->no_kartu_dk ?? '',
                // 'ongkir' => $request->ongkir ?? '',
                'ongkir' => $request->ongkir,
                'tgl_ongkir' => $request->tgl_ongkir,
                // 'tgl_tempo' => $request->tgl_tempo ?? '',
                'tgl_tempo' => $request->tgl_tempo ?? date('Y-m-d', strtotime('')),
                'nabung_jujulan' => 00,
            ];
            // dd($data3);
            DB::table('penjualan_fix')->insert($data3);
            session(['noFaktur' => $noFaktur]);
            DB::delete("DELETE FROM penjualan_b_copy WHERE user = '$user'");
            return redirect()->to('/print');
            // return back()->with('success', 'Berhasil disimpan');
        }
    }

    public function store(Request $request)
    {
        $product = Produk::where('kd_produk', $request->kd_produk)->first();
        $pecah = Pecah::where('kd_produk', $request->kd_produk)->first();
        $dataganda = Keranjang::where(['kd_produk' => $request->kd_produk, 'user' => $request->user])->first();
        $hari = strtotime($pecah->tgl_diskon_awal) <= strtotime(date('Y-m-d')) && strtotime($pecah->tgl_diskon_akhir) >= strtotime(date('Y-m-d'));

        if ($hari && $pecah->ket_diskon_periode == 'AKTIF') {
            $diskon = $pecah->diskon_periode;
        } else {
            $diskon = 00;
        }
        // dd($diskon);

        if ($dataganda == null) {
            Keranjang::create([
                'no_faktur_jual' => $request->no_faktur_jual,
                'barcode' => $request->barcode,
                'kd_produk' => $request->kd_produk,
                'nama_produk' => $request->nama_produk,
                'jumlah' => $request->jumlah,
                'satuan' => $request->satuan,
                'harga_jual' => $request->harga_jual,
                'dis' => $diskon,
                'netto' => $request->harga_jual - $pecah->diskon_periode,
                'total' => ($request->harga_jual - $diskon) * $request->jumlah,
                'umum_member' => $request->umum_member,
                'harga_beli' => $request->harga_beli,
                'deskripsi' => $request->deskripsi,
                'cash_back' => $request->cash_back,
                'status_tabungan' => $request->status_tabungan,
                // 'qty_conversi' => $product->stok_satuan_dasar / $pecah->nilai_satuan_dasar,
                'qty_conversi' => $product->jumlah * $pecah->nilai_satuan_dasar,
                'simpanan_tomember' => 1 / 100 * ((($request->harga_jual - $diskon) * $request->jumlah) - ($request->harga_beli * $request->jumlah)),
                'waktu' => $request->waktu,
                'user' => $request->user,
            ]);
        } else {
            Keranjang::where(['kd_produk' => $request->kd_produk, 'user' => $request->user])
                ->update([
                    'no_faktur_jual' => $request->no_faktur_jual,
                    'barcode' => $request->barcode,
                    'kd_produk' => $request->kd_produk,
                    'nama_produk' => $request->nama_produk,
                    'jumlah' => $dataganda->jumlah + $request->jumlah,
                    'satuan' => $request->satuan,
                    'harga_jual' => $request->harga_jual,
                    'dis' => $diskon,
                    'netto' => $dataganda->netto,
                    'total' => $dataganda->total + (($request->harga_jual - $diskon) * $request->jumlah),
                    'umum_member' => $request->umum_member,
                    'harga_beli' => $request->harga_beli,
                    'deskripsi' => $request->deskripsi,
                    'cash_back' => $request->cash_back,
                    'status_tabungan' => $request->status_tabungan,
                    // 'qty_conversi' => $product->stok_satuan_dasar / $pecah->nilai_satuan_dasar,
                    'qty_conversi' => $dataganda->qty_conversi + ($product->jumlah * $pecah->nilai_satuan_dasar),
                    'simpanan_tomember' => $dataganda->simpanan_tomember + (1 / 100 * ((($request->harga_jual - $diskon) * $request->jumlah) - ($request->harga_beli * $request->jumlah))),
                    'waktu' => $request->waktu,
                    'user' => $request->user,
                ]);
        }

        return back()->with('success', 'Berhasil ditambah ke keranjang!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Keranjang  $keranjang
     * @return \Illuminate\Http\Response
     */
    public function show(Keranjang $keranjang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Keranjang  $keranjang
     * @return \Illuminate\Http\Response
     */
    public function edit(Keranjang $keranjang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Keranjang  $keranjang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Keranjang $keranjang, $no)
    {
        $cart = Keranjang::where('no', $no)->first();
        $product = Pecah::where('kd_produk', $cart->kd_produk)->first();
        // dd($product);

        if ($product->ket_diskon_periode !== 'OFF') {
            $diskon = $product->diskon_periode;
        } elseif ($product->ket_diskon_periode == 'OFF') {
            $diskon = 00;
        }

        Keranjang::where('no', $no)
            ->update([
                'jumlah' => $request->jumlah,
                'total' => ($request->harga_jual - $diskon) * $request->jumlah,
                'simpanan_tomember' => 1 / 100 * ((($request->harga_jual - $diskon) * $request->jumlah) - ($request->harga_beli * $request->jumlah)),
            ]);
        return back()->with('success', 'Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Keranjang  $keranjang
     * @return \Illuminate\Http\Response
     */
    public function destroy($no)
    {
        Keranjang::where('no', $no)->delete();
        return back()->with('success', 'Berhasil dihapus');
    }
}
