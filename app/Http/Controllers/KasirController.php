<?php

namespace App\Http\Controllers;

use App\Models\Kasir;
use App\Models\Barang;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Point;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $no = Penjualan::count() + 1;
    $noFaktur = "FJ" . date('d-m-Y', strtotime(Carbon::now())) . $no;
    $penjualan = Kasir::where('noFakturJualan', $noFaktur)->get();

    $subtotal = $penjualan->sum('hrgJual') * $penjualan->sum('jmlhJual');

    $Tgl_Jual = date('Y-m-d', strtotime(Carbon::now()));

    $pelanggan = Pelanggan::all();

    if (session(['id' => 'noFaktur'])) {
      return view('kasir.pages.index', [
        'title' => 'Kasir',
        'penjualan' => $penjualan,
        'noFaktur' => $noFaktur,
        'subtotal' => $subtotal,
        'Tgl_Jual' => $Tgl_Jual,
        'pelanggan' => $pelanggan,
      ]);
    } else {
      return view('kasir.pages.index', [
        'title' => 'Kasir',
        'penjualan' => $penjualan,
        'noFaktur' => $noFaktur,
        'subtotal' => $subtotal,
        'pelanggan' => $pelanggan,
        'Tgl_Jual' => $Tgl_Jual,
      ]);
    }
  }

  public function getBarcodeData()
  {
    if (request()->barcode != null) {
      $barang = Barang::select('barcode', 'namaBarang', 'hrgJual', 'hrgBeli', 'stok')->where('barcode', request()->barcode);
      // dd($barang);
      if ($barang->exists()) {
        $data = $barang->first();

        return response()->json([
          'message' => 'Berhasil mengambil data',
          'barang' => [
            "barcode" => $data->barcode,
            "namaBarang" => $data->namaBarang,
            "hrgBeli" => $data->hrgBeli,
            "hrgJual" => $data->hrgJual,
            "stok" => $data->stok,
          ],
        ]);
      } else {
        return response()->json([
          'message' => 'Data kosong',
          'barang' => null
        ]);
      }
    } else {
      return response()->json([
        'message' => 'Barcode kosong',
        'barang' => null
      ]);
    }
  }

  public function getDetailData($noFakturJualan)
  {
    $now = date('Y-m-d', strtotime(Carbon::now()));
    $no = Penjualan::count() + 1;
    $noFaktur = "FJ" . date('d-m-Y', strtotime(Carbon::now())) . $no;
    $penjualan = Kasir::where('noFakturJualan', $noFaktur)->get();
    $total = DB::select("select ifnull(sum(hrgJual*jmlhJual),0) as total from tabelrealpenjualan where noFakturJualan =  '$noFaktur'");

    foreach ($total as $key => $value) {
      $total2 = $value->total;
    }

    $poin1 = Point::sum('kelipatan');

    $poin = $total2 / $poin1;

    if (request('bayar') == "") {
      $kembali = 0;
    } else {
      $kembali = request('bayar') - $total2;
    }

    return response()->json([
      'penjualan' => $penjualan,
      'total' => $total2,
      'now' => $now,
      'poin' => $poin,
      'kembali' => $kembali,
      'pelanggan' => request('Kd_Pelanggan'),
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
  public function store(Request $request)
  {
    $k = Kasir::create($request->all());
    session(['noFakturJualan' => 'noFakturJualan']);
    return response()->json($k);
    // return back();
  }

  public function simpan(Request $request)
  {
    $poin = Point::sum('kelipatan');
    $p = Penjualan::create([
      'No_Faktur_Jual' => $request->No_Faktur_Jual,
      'Tgl_Jual' => $request->Tgl_Jual,
      'Kd_Pelanggan' => $request->Kd_Pelanggan ?? '',
      'Total' => $request->Total,
      'Bayar' => $request->Bayar,
      'Kd_User' => $request->Kd_User,
      'poin' => doubleval($request->Total) / $poin,
    ]);
    // dd(request('Kd_Pelanggan'));
    // $p = Penjualan::create($request->all());
    // $request->session()->forget('id');
    // return $p;
    session(['noFakturJualan' => $request->No_Faktur_Jual]);
    return redirect()->to('/selesai')->with('success', 'Berhasil di simpan');
    // return response()->json($p);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Kasir  $kasir
   * @return \Illuminate\Http\Response
   */
  public function show()
  {
    // $penjualan = Kasir::find(session('noFakturJual'));
    // if (!$penjualan) {
    //   abort(404);
    // }
    $barang = Kasir::where('noFakturJualan', session('noFakturJualan'))->get();
    $totalItem = Kasir::where('noFakturJualan', session('noFakturJualan'))->sum('jmlhJual');
    $detail = Penjualan::where('No_Faktur_Jual', session('noFakturJualan'))->first();
    // dd($detail->No_Faktur_Jual);
    $time = Carbon::now();

    return view('kasir.pages.notaKecil', [
      'detail' => $detail,
      'barang' => $barang,
      'time' => $time,
      'totalItem' => $totalItem,
    ]);
  }

  public function selesai()
  {
    // $penjualan = Kasir::find(session('noFaktur'));
    // if (!$penjualan) {
    //   abort(404);
    // }
    $detail = Penjualan::where('No_Faktur_Jual', session('noFakturJualan'))
      ->get();
    // dd($detail);

    return view('kasir.pages.selesai', [
      'title' => 'Selesai',
      'detail' => $detail,
    ]);
  }
  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Kasir  $kasir
   * @return \Illuminate\Http\Response
   */
  public function edit(Kasir $kasir)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Kasir  $kasir
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Kasir $kasir)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Kasir  $kasir
   * @return \Illuminate\Http\Response
   */
  public function destroy(Kasir $kasir, Request $request)
  {
    $request->session()->forget('noFakturJualan');
    // Kasir::destroy($d->no);
    // return back();
  }
}
