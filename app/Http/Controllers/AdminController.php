<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
  public function index()
  {
    $date = Carbon::now()->isoFormat('D-M-Y');
    $month = date('m', strtotime($date));
    $year = date('Y', strtotime($date));
    $totalBarang = Barang::count();

    $today = Penjualan::whereDay('Tgl_Jual', $date)->sum('total');
    $month = Penjualan::whereMonth('Tgl_Jual', [$month, $year])->sum('total');
    $year = Penjualan::whereYear('Tgl_Jual', $year)->sum('total');
    $yearLabel = date('d-m-Y', strtotime($year));
    $yearData = [
      'jan' => Penjualan::whereMonth('Tgl_Jual', 1)->sum('total'),
      'feb' => Penjualan::whereMonth('Tgl_Jual', 2)->sum('total'),
      'mar' => Penjualan::whereMonth('Tgl_Jual', 3)->sum('total'),
      'apr' => Penjualan::whereMonth('Tgl_Jual', 4)->sum('total'),
      'mei' => Penjualan::whereMonth('Tgl_Jual', 5)->sum('total'),
      'jun' => Penjualan::whereMonth('Tgl_Jual', 6)->sum('total'),
      'jul' => Penjualan::whereMonth('Tgl_Jual', 7)->sum('total'),
      'aug' => Penjualan::whereMonth('Tgl_Jual', 8)->sum('total'),
      'sep' => Penjualan::whereMonth('Tgl_Jual', 9)->sum('total'),
      'oct' => Penjualan::whereMonth('Tgl_Jual', 10)->sum('total'),
      'nov' => Penjualan::whereMonth('Tgl_Jual', 11)->sum('total'),
      'dec' => Penjualan::whereMonth('Tgl_Jual', 12)->sum('total'),
    ];
    $nows = strtotime(date('Y-m-d'));
    $start = date('Y-m-d', strtotime('-7 day', $nows));
    $labelDay = date('d-m-Y', strtotime($start));
    $dayData = Penjualan::whereDay('Tgl_Jual', $start)->sum('total');

    return view('admin.pages.dashboard', [
      'title' => 'Dashboard',
      'today' => $today,
      'month' => $month,
      'year' => $year,
      'yearData' => $yearData,
      'yearLabel' => $yearLabel,
      'totalBarang' => $totalBarang,
      'dayData' => $dayData,
      'nows' => $nows,
      'start' => $start,
      // 'labelDay' => $labelDay,
    ]);
  }
}
