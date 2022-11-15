function numThousand(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

let addCart = document.querySelector("#addCart");

$(document).ready(function () {


  function cartsum() {
    $.ajax({
      type: "GET",
      url: "/cartsum",
      dataType: "json",
      success: function (response) {
        $('#cartsum').html('');
        // $('#cartsum').append('<a href="/cart" class="flex"><i class="fa-solid fa-cart-shopping"></i><span class="order-1 text-blue-600" id="cartsum">' +response.cartsum + '</span></a>')
        $('#cartsum').append(`<div class="fa-2x"><span class="fa-layers fa-fw"><i class="fa-solid fa-cart-shopping"></i><span class="fa-layers-counter" style="background:Tomato">${response.cartsum}</span></span></div>`)
      },
    })
  }

  $(document).on("input", "#qty", function (e) {
    $.ajax({
      type: "GET",
      url: "/cartsum/{kdUser}",
      dataType: "json",
      success: function (response) {
        $('#cartsum').html('');
        $('#cartsum').append('<a href="/cart" class="flex"><i class="fa-solid fa-cart-shopping"></i><span class="z-10 order-1 text-blue-600" id="cartsum">' + response.cartsum + '</span></a>')
      },
    })
  })

  cartsum();
  // stok();
}); //end document
