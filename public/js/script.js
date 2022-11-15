$(document).ready(() => {
  // pagination
  // $(document).on("click", "#pagination a", function(event) {
  //   event.preventDefault();

  //   let page = $(this).attr("href").split("page=")[1];
  //   history.pushState(null, null, `?page=${page}`);

  //   $.ajax({
  //     type: "GET",
  //     url: "/products?page=" + page,
  //     success: function (response) {
  //         $("#products-grid").html(response);
  //     },
  //   });
  // });

  // searching
  function searchProduct(e) {
    e.preventDefault();
    const form = new FormData(e.target);

    const search = form.get("search");
    const category = $('#kategori').val();

  }
});
