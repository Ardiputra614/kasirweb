<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('admin.pages.category.index', [
      'title' => 'Kategori',
      'categories' => Kategori::all(),
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
    $slug = Str::slug($request->namaKategori);
    $kategori = Kategori::where('slug', $slug)->get();

    // if ($slug == $kategori->slug) {
    //   return back()->with('error', 'Kategori sudah ada ganti dengan yang lain');
    // }

    // if ($slug != $kategori->slug) {
    Kategori::create([
      'namaKategori' => $request->namaKategori,
      'slug' => Str::slug($slug),
    ]);
    // }

    return back()->with('success', 'Kategori berhasil ditambah');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $kdKategori)
  {
    $kategori = Kategori::find($kdKategori);
    $slug = Str::slug($request->namaKategori);
    if ($kategori->slug == $slug) {
      return back()->with('error', 'Nama Kategori sudah ada, ganti dengan yang lain');
    }

    $kategori->update([
      'namaKategori' => $request->namaKategori,
      'slug' => Str::slug($request->namaKategori),
    ]);

    return back()->with('success', 'Berhasil di update');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($kdKategori)
  {
    Kategori::destroy($kdKategori);
    return back()->with('success', 'Kategori berhasil dihapus');
  }
}
