function store() {
  var namaBarang = $("namaBarang").val();
  $.ajax{
    {
      type: "get",
        url: "{{ url('products.store') }}",
          data: "namaBarang=" + namaBarang,
            success: function(data) {
              "berhasil"'
            }
    }
  };
}
