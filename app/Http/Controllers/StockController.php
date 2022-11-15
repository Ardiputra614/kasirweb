<?php

namespace App\Http\Controllers;

use App\Models\Pecah;
use App\Models\Produk;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $produk = Produk::withOut(['supplier']);

        if ($request->input('search')) {
            $produk->search($request->search);
        }

        return view('pages.stock', [
            'title' => 'Stok opname',
            'products' => $produk->orderBy('nama_produk', 'asc')->paginate(5)->withQueryString(),
        ]);
    }

    public function getData()
    {
        if (request()->barcode != null) {
            $pecah = Pecah::select('barcode', 'nama_produk', 'nilai_satuan_dasar', 'satuan', 'kd_produk')->where('barcode', request()->barcode);

            if ($pecah->exists()) {
                $data = $pecah->first();
                $produk = Produk::select('stok_satuan_dasar')->where('kd_produk', $data->kd_produk)->first();

                return response()->json([
                    'message' => 'Berhasil mengambil data',
                    'pecah' => [
                        "barcode" => $data->barcode,
                        "namaProduk" => $data->nama_produk,
                        "satuan" => $data->satuan,
                        "kd_produk" => $data->kd_produk,
                        "stok_before" => $produk->stok_satuan_dasar / $data->nilai_satuan_dasar,
                        "stok_satuan_dasar" => $produk->stok_satuan_dasar,
                        "nilai_satuan_dasar" => $data->nilai_satuan_dasar,
                    ],
                ]);
            } else {
                return response()->json([
                    'message' => 'Data kosong',
                    'pecah' => null
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Barcode kosong',
                'pecah' => null
            ]);
        }
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
        $a = Stock::create($request->all());
        return response()->json($a);
    }

    public function storeSearch(Request $request)
    {
        $request->validate(['stok_after' => 'required']);
        $produk = Produk::where('kd_produk', $request->kd_produk)->first();
        $pecah = Pecah::where('kd_produk', $request->kd_produk)->first();

        $a = Stock::create([
            'kd_produk' => $request->kd_produk,
            'barcode' => $pecah->barcode,
            'stok_before' => $request->stokBefore,
            'stok_after' => $request->stokAfter ?? 1,
            'tgl_opname' => date('Y-m-d', strtotime(Carbon::now())),
            'qty_conversi' => $pecah->nilai_satuan_dasar * $request->stokAfter,
            'user' => auth()->user()->username ?? '',
        ]);
        // return response()->json(200);
        return back()->with('success', 'Berhasil di tambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
