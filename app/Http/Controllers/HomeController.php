<?php

namespace App\Http\Controllers;

use App\Models\Pecah;
use App\Models\Kategori;
use App\Models\Keranjang;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\Penjualan;
use App\Models\Penjualandetail;
use App\Models\Penjualanfix;
use App\Models\Produk;
use App\Models\Identitas;
use DateTime;
// use App\Models\RinciOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        $no = Penjualanfix::count() + 1;
        $no_faktur_jual = "WSBB-00" . $no;
        $waktu = date('Y-m-d h:i:s', strtotime(Carbon::now()));

        $products = Pecah::withOut(['supplier']);

        if ($request->input('search')) {
            $products->search($request->search);
        }

        if ($request->input('category') !== "all") {
            $category = $request->category;
            $products->where('kategori', 'LIKE', "%{$category}%");
        }


        return view('pages.product.umum', [
            'title' => 'Produk Harga Member',
            'no_faktur_jual' => $no_faktur_jual,
            'waktu' => $waktu,
            "categories" => Kategori::select('nama_kategori')->orderBy('nama_kategori', 'asc')->get(),
            "products" => $products->orderBy('harga_jual_member', 'desc')->paginate(20),
        ]);
    }

    public function umum(Request $request)
    {

        // dd(date('YmdHis.U', strtotime(Carbon::now())));
        $no = Penjualanfix::count() + 1;
        $no_faktur_jual = "WSBB-00" . $no;
        $waktu = date('Y-m-d h:i:s', strtotime(Carbon::now()));

        $products = Pecah::withOut(['supplier']);

        if ($request->input('search')) {
            $products->search($request->search);
        }

        if ($request->input('category') !== "all") {
            $category = $request->category;
            $products->where('kategori', 'LIKE', "%{$category}%");
        }

        // return view('pages.product.umum', [
        return view('pages.product.umum', [
            'title' => 'Produk Harga Umum',
            'no_faktur_jual' => $no_faktur_jual,
            'waktu' => $waktu,
            "categories" => Kategori::select('nama_kategori')->orderBy('nama_kategori', 'asc')->get(),
            "products" => $products->orderBy('harga_jual_umum', 'desc')->paginate(20)->withQueryString(),
        ]);
    }


    public function member(Request $request)
    {
        $no = Penjualanfix::count() + 1;
        $no_faktur_jual = "WSBB-00" . $no;
        $waktu = date('Y-m-d h:i:s', strtotime(Carbon::now()));

        $products = Pecah::withOut(['supplier']);

        if ($request->input('search')) {
            $products->search($request->search);
        }

        if ($request->input('category') !== "all") {
            $category = $request->category;
            $products->where('kategori', 'LIKE', "%{$category}%");
        }

        // return view('pages.product.member', [
        return view('pages.product.member', [
            'title' => 'Produk Harga Member',
            'no_faktur_jual' => $no_faktur_jual,
            'waktu' => $waktu,
            "categories" => Kategori::select('nama_kategori')->orderBy('nama_kategori', 'asc')->get(),
            "products" => $products->orderBy('harga_jual_member', 'desc')->paginate(20)->withQueryString(),
        ]);
    }

    public function grosir(Request $request)
    {
        $no = Penjualanfix::count() + 1;
        $no_faktur_jual = "WSBB-00" . $no;
        $waktu = date('Y-m-d h:i:s', strtotime(Carbon::now()));

        $products = Pecah::withOut(['supplier']);

        if ($request->input('search')) {
            $products->search($request->search);
        }

        if ($request->input('category') !== "all") {
            $category = $request->category;
            $products->where('kategori', 'LIKE', "%{$category}%");
        }


        return view('pages.product.grosir', [
            'title' => 'Produk Harga Grosir',
            'no_faktur_jual' => $no_faktur_jual,
            'waktu' => $waktu,
            "categories" => Kategori::select('nama_kategori')->orderBy('nama_kategori', 'asc')->get(),
            "products" => $products->orderBy('harga_jual_grosir', 'desc')->paginate(20)->withQueryString(),
        ]);
    }

    public function memberGrosir(Request $request)
    {
        $no = Penjualanfix::count() + 1;
        $no_faktur_jual = "WSBB-00" . $no;
        $waktu = date('Y-m-d h:i:s', strtotime(Carbon::now()));

        $products = Pecah::withOut(['supplier']);

        if ($request->input('search')) {
            $products->search($request->search);
        }

        if ($request->input('category') !== "all") {
            $category = $request->category;
            $products->where('kategori', 'LIKE', "%{$category}%");
        }

        return view('pages.product.member-grosir', [
            'title' => 'Produk Harga Member Grosir',
            'no_faktur_jual' => $no_faktur_jual,
            'waktu' => $waktu,
            "categories" => Kategori::select('nama_kategori')->orderBy('nama_kategori', 'asc')->get(),
            "products" => $products->orderBy('harga_jual_grosir_member', 'desc')->paginate(20)->withQueryString(),
        ]);
    }

    public function print()
    {
        // dd(session('no_faktur_jual'));
        $identitas = Identitas::select('nama', 'alamat', 'hp')->first();
        // dd($identitas);
        $no_faktur_jual = session('noFaktur');
        // dd($no_faktur_jual);
        $product = Penjualandetail::where('no_faktur_jual', session('noFaktur'))->get();
        $detail = Penjualanfix::where('no_faktur_jual', session('noFaktur'))->first();
        // dd($detail, $product);

        // dd($detail, $product, $no_faktur_jual);
        return view('pages.print', [
            'title' => 'Nota',
            'detail' => $detail,
            'product' => $product,
            'identitas' => $identitas,
        ]);
    }

    public function cartSum()
    {
        // $cartsum = Keranjang::where(['kdUser' => auth()->user()->kdUser ?? ''])->sum('qty');
        $cartsum = Keranjang::where(['user' => auth()->user()->username ?? ''])->sum('jumlah');
        return response()->json([
            'cartsum' => $cartsum,
        ]);
    }

    public function forgetSession(Request $request)
    {
        $request->session()->forget('no_faktur_jual');
        return redirect('/');
    }

    public function stock()
    {
        return view('pages.stock', [
            'title' => 'Stok',
            'products' => Pecah::orderBy('barcode', 'asc')->paginate(20),
        ]);
    }
}
