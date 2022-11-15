<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\Gambar;
use App\Models\Suplier;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('admin.pages.product.index', [
      'title' => 'Produk',
      'products' => Barang::all(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.pages.product.create', [
      'title' => 'Tambah Produk',
      'satuan' => Satuan::all(),
      'kategori' => Kategori::all(),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $rules = [
      'namaBarang' => 'required|max:255',
      'slug' => 'required|max:255',
      'hrgBeli' => 'required',
      'hrgJual' => 'required',
      'kdSatuan' => 'required',
      'kdKategori' => 'required',
      'stok' => 'required',
      'stok_gudang' => 'required',
      'deskripsi' => 'required',
      'cloud_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
      'images[]' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
      'barcode' => 'required|max:18|unique:databarang'
    ];

    $validatedData = $request->validate($rules);
    $barang = Barang::create($validatedData);

    if ($request->hasFile("cloud_img")) {
      $file = $request->file('cloud_img');
      $image = Cloudinary::upload($file->getRealPath(), ['folder' => 'products']);
      $public_id = $image->getPublicId();
      $url = $image->getSecurePath();
      // dd($url, $public_id);
      $barang->update([
        'cloud_img' => $public_id,
        'img_urls' => $url,
      ]);
    }

    if ($request->hasFile("images")) {
      $file = $request->file('images');
      foreach ($file as $key => $file) {
        $images = Cloudinary::upload($file->getRealPath(), ['folder' => 'products']);
        $public_id = $images->getPublicId();
        $url = $images->getSecurePath();
        Gambar::create([
          'cloud_img' => $public_id,
          'img_urls' => $url,
          'barcode' => $request->barcode,
        ]);
      }
    }

    // Barang::create([
    //   'barcode' => $request->barcode,
    //   'namaBarang' => $request->namaBarang,
    //   'slug' => Str::slug($request->namaBarang),
    // ]);
    return back()->with('success', 'Berhasil ditambah');
    // return response()->json('Berhasil', 200);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($barcode)
  {
    $barang =  Barang::findOrFail($barcode);
    $images = Gambar::where('barcode', $barcode)->get();
    return view('admin.pages.product.detail', [
      'title' => 'Detail',
      'product' => $barang,
      'images' => $images,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($barcode)
  {
    $kategori = Kategori::all();
    $satuan = Satuan::all();
    $barang = Barang::findOrFail($barcode);
    $gambar = Gambar::where('barcode', $barcode)->get();
    // dd($barang);
    return view('admin.pages.product.edit', [
      'title' => 'Edit Produk',
      'barang' => $barang,
      'satuan' => $satuan,
      'kategori' => $kategori,
      'gambar' => $gambar,
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $product = Barang::findOrFail($id);
    $rules = [
      'namaBarang' => 'required|max:255',
      'slug' => 'required|max:255',
      'hrgBeli' => 'required',
      'hrgJual' => 'required',
      'kdSatuan' => 'required',
      'kdKategori' => 'required',
      'stok' => 'required',
      'stok_gudang' => 'required',
      'deskripsi' => 'required',
      'cloud_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
      'images[]' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
      // 'barcode' => 'required|max:18|unique:databarang'
    ];

    if ($request->barcode != $product->barcode) {
      $rules['barcode'] = 'required|unique:databarang';
    }

    $validatedData = $request->validate($rules);
    $product->update($validatedData);

    if ($request->hasFile('cloud_img')) {
      $file = $request->file('cloud_img');
      $image = Cloudinary::upload($file->getRealPath(), ['folder' => 'products']);
      $public_id = $image->getPublicId();
      $url = $image->getSecurePath();

      $image = [
        "cloud_img" => $public_id,
        "img_urls" => $url,
      ];
      $product->where('barcode', $product->barcode)
        ->update($image);
    }

    if ($request->hasFile("images")) {
      $files = $request->file("images");
      foreach ($files as $file) {
        $images = Cloudinary::upload($file->getRealPath(), ['folder' => 'products']);
        $public_id = $images->getPublicId();
        $url = $images->getSecurePath();
        Gambar::create([
          'cloud_img' => $public_id,
          'img_urls' => $url,
          'barcode' => $product->barcode,
        ]);
      }
    }
    return redirect()->to('/dashboard/products')->with("success", "Berhasil diedit!!");
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($barcode)
  {
    $barang = Barang::findOrFail($barcode);
    $images = Gambar::where('barcode', $barcode)->get();


    if ($images->count() >= 1) {
      foreach ($images as $image) {
        Cloudinary::destroy($image->cloud_img);
      }
      $images->where('barcode', $barcode)->delete();
    }

    if ($barang->cloud_img == null) {
      Barang::destroy($barcode);
    }

    if ($barang->cloud_img != null) {
      Cloudinary::destroy($barang->cloud_img);
      Barang::destroy($barcode);
    }

    return back()->with('success', 'Berhasil dihapus!!');
  }

  public function deletecover($barcode)
  {
    $product = Barang::findOrFail($barcode);
    // dd($product);

    Cloudinary::destroy($product->cloud_img);

    $a = [
      'cloud_img' => "",
      'img_urls' => "",
    ];

    $product->where('barcode', $product->barcode)
      ->update($a);
    // $product->where('id', $product->id)
    //         ->update($url);

    return back()->with('success', 'Gambar Utama Berhasil dihapus!!');
  }

  public function deletegambar($kdGambar)
  {
    $images = Gambar::findOrFail($kdGambar);
    // dd($images);
    Cloudinary::destroy($images->cloud_img);

    $images->delete();
    return back()->with('success', 'Gambar berhasil dihapus!!');
  }

  public function data()
  {
    $brg = DB::table('databarang');
    $barang = $brg->select('databarang.*', 'tabelkategori.namaKategori as namaKategori', 'tabelsatuan.namaSatuan as namaSatuan')
      ->leftJoin('tabelkategori', 'tabelkategori.kdKategori', 'databarang.kdKategori')
      ->leftJoin('tabelsatuan', 'tabelsatuan.kdSatuan', 'databarang.kdSatuan')
      ->get();

    return response()->json($barang);
  }
}
