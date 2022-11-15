function numThousand(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

let barcode = document.querySelector("#barcode");
let barcodeHidden = document.querySelector("#barcodeHidden");
let qtyHidden = document.querySelector("#qtyHidden");
let jmlhJual = document.querySelector("#jmlhJual");
let stok = document.querySelector('#stok');

let namaBarang = document.querySelector("#namaBarang");
let namaBarangHidden = document.querySelector("#namaBarangHidden");
let hrgBeli = document.querySelector("#hrgBeli");
let hrgJual = document.querySelector("#hrgJual");
let hrgJualHidden = document.querySelector("#hrgJualHidden");

let btnTambah = document.querySelector("#btnTambah");
let btnSimpan = document.querySelector("#btnSimpan");
let total = document.querySelector("#total");
let kode = document.querySelector("#kode");
let save = document.querySelector("#save");

// let tabelKasir = document
//     .querySelector("#tabelKasir")
//     .getElementsByTagName("tbody")[0];

barcode.addEventListener("input", function() {
  fetch(`/kasir-barcode-data?barcode=${barcode.value}`)
      .then((response) => response.json())
      .then((data) => {
        if (data.barang !== null) {
              barcodeHidden.value = data.barang.barcode;
              namaBarang.value = data.barang.namaBarang;
              hrgBeli.value = data.barang.hrgBeli;
              hrgJual.value = data.barang.hrgJual;
              stok.value = data.barang.stok;

              barcode.value = data.barang.barcode;
              namaBarangHidden.value = data.barang.namaBarang;
              hrgJualHidden.value = data.barang.hrgJual;
              console.log(barcode.value, namaBarang.value, hrgBeli.value, hrgJual.value,
                  namaBarangHidden.value, hrgJualHidden.value);
          } else {
              barcodeHidden.value = "";
              namaBarang.value = "";
              namaBarangHidden.value = "";

              hrgBeli.value = "";
              hrgJual.value = "";
          }
      })
});

$(document).ready(function() {
  detail();
  total();
  formTransaksi();
  // dataSimpan();
  // simpan();
  function detail() {
      $.ajax({
          type: "GET",
          url: "/kasir/detail/{noFakturJualan}",
          dataType: "json",
          success: function(response) {
              $('tbody').html('');
              $.each(response.penjualan, function(key, item) {
                  $('tbody').append(
                      '<tr class= "border-b bg-white text-black hover:bg-gray-50 text-center w-full">\
                                    <td class="items-center py-3 px-7 dark:text-white">' + parseInt(key + 1) + '</td>\
                                    <td class="items-center py-3 px-7 dark:text-white">' + item.barcode + '</td>\
                                    <td class="items-center py-3 px-7 dark:text-white">' + item.namaBarang + '</td>\
                                    <td class="items-center py-3 px-7 dark:text-white">' + item.jmlhJual + '</td>\
                                    <td class="items-center py-3 px-7 dark:text-white">' + item.hrgJual + '</td>\
                                    <td class="items-center py-3 px-7 dark:text-white">' + item.jmlhJual * item
                      .hrgJual + '</td>\
                                    </tr>')
              })
          }
      })
  }

  function total() {
      $.ajax({
          type: "GET",
          url: "/kasir/detail/{noFakturJualan}",
          dataType: "json",
          success: function(response) {
              // console.log(response.penjualan);
              $('#total').html('');
              $('#total').append(
                  '<div name="total" id="total">'+response.total+'</div>');
          }
      })
  }


  function formTransaksi() {
      $.ajax({
          type: "GET",
          url: "/kasir/detail/{noFakturJualan}",
          dataType: "json",
          success: function(response) {
            console.log(response.poin);

              $('#formTransaksi').html('');
              $('#formTransaksi').append(
                  '<div class="m-3">\
                              <div class="grid w-full grid-cols-1">\
                                  <div class="my-3">\
                                      <div class="grid grid-cols-2 gap-7">\
                                          <b class="text-center">Pelanggan ?</b>\
                                          <select name="Kd_Pelanggan" id="Kd_Pelanggan">\
                                        <option value="">Pilih Pelanggan ?</option>\
                                        @foreach ($pelanggan as $p)\
                                            <option value="{{ $p->kdPelanggan }}">{{ $p->namaPelanggan }}</option>\
                                        @endforeach\
                                    </select>\
                                      </div>\
                                  </div>\
                                  <div class="my-3">\
                                      <div class="grid grid-cols-2 gap-7">\
                                          <b class="text-center">Bayar:</b>\
                                          <input type="number" class="w-full p-2" id="bayar" name="bayar">\
                                      </div>\
                                  </div>\
                                  <div class="my-3">\
                                      <div class="grid grid-cols-2 gap-7">\
                                          <b class="text-center">Total:</b>\
                                          <input type="hidden" class="w-full p-2" id="total" name="total" value="' + response.total +'" disabled>\
                                          <div id="total">'+response.total+'</div>\
                                          <input type="hidden" id="poin" name="poin" value="'+response.poin+'">\
                                      </div>\
                                  </div>\
                                  <div class="my-3">\
                                      <div class="grid grid-cols-2 gap-7">\
                                        <b class="text-center">Kembali:</b>\
                                        <div id="kembali"></div>\
                                        <input type="hidden" class="w-full p-2" id="Tgl_Jual" min="0" name="Tgl_Jual" value="{{ $Tgl_Jual }}">\
                                          <input type="hidden" class="w-full p-2" name="Kd_Pelanggan" id="Kd_Pelanggan" value="1" min="0" disabled>\
                                          <div id="total"></div>\
                                      </div>\
                                  </div>\
                                  </div>\
                                  <input type="hidden" id="Kd_User" value="{{ auth()->user()->kdUser }}">\
                                <div class="grid grid-cols-2 gap-7">\
                                  <div></div>\
                                  <button type="submit" id="btnSimpan"class="text-semibold rounded-lg bg-blue-600 p-2 text-center text-sm text-white">Simpan Transaksi</button>\
                                  <div></div>\
                                </div>')
          }
      })

  }


  $(document).on("input", '#bayar', function(e) {
      e.preventDefault();
      var bayar = {
          'bayar': $('#bayar').val(),
      }


      $.ajax({
          type: "GET",
          url: "/kasir/detail/{noFakturJualan}",
          data: bayar,
          dataType: "json",
          success: function(response) {
              $('#kembali').html('');
              $('#kembali').append(
                  '<div>'+ numThousand(response.kembali) +'</div>');
          }
      })
  })

  // bayar.addEventListener('keyup', function() {
  //     document.querySelector("#bayar").innerHTML = numThousand(bayar.value);
  // });

  $(document).on("click", '#btnTambah', function(e) {
      e.preventDefault();

      var data = {
          'noFakturJualan': $('#noFakturJualan').val(),
          'barcode': $('#barcode').val(),
          'namaBarang': $('#namaBarang').val(),
          'jmlhJual': $('#jmlhJual').val(),
          'hrgJual': $('#hrgJual').val(),
          'hrgBeli': $('#hrgBeli').val()
      }
      console.log(data);

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
          type: "POST",
          url: "{{ route('transaksi.store') }}",
          data: data,
          dataType: "json",
          success: function(response) {
              if (response.stok) {
                bayar
              }
              barcode.value = "";
              barcodeHidden.value = "";
              namaBarangHidden.value = "";
              namaBarang.value = "";
              hrgJual.value = "";
              hrgJualHidden.value = "";
              jmlhJual.value = "";
              detail();
              // total();
              formTransaksi();
          }
      })
  });

  $(document).on("click", '#btnSimpan', function(e) {
      e.preventDefault();

      var data = {
          'No_Faktur_Jual': $('#noFakturJualan').val(),
          'Tgl_Jual': $('#Tgl_Jual').val(),
          'Kd_Pelanggan': $('#Kd_Pelanggan').val(),
          'Total': $('#total').val(),
          'Bayar': $('#bayar').val(),
          'Kd_User': $('#Kd_User').val(),
          'poin': $('#poin').val()
      }
      console.log(data);

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
          type: "POST",
          url: "{{ route('transaksi.simpan') }}",
          data: data,
          dataType: "json",
          success: function(response) {
              detail();
              formTransaksi();
          }
      })
  });



}); //Document stop
