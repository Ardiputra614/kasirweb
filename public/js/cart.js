// function numThousand(x) {
//     return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
// }

let tambah = document.querySelector("#tambah");

cartsum();


function cartsum() {
    $.ajax({
        type: "GET",
        url: "/cartsum",
        dataType: "json",
        success: function (response) {
            $('#cartsum').html('');
            $('#cartsum').append('<a href="/cart" class="flex">\
                <i class="fa-solid fa-cart-shopping"></i>\
                <span class="z-10 order-1 text-blue-600" id="cartsum">' + response.cartsum + '</span>\
            </a>')
        },
    })
}

$(document).ready(function () {
    $('#harga').on('change', function () {
        const id = $('#harga').val();
        if (id == 'UMUM') {
            window.location = "/umum";
        } else if (id == 'MEMBER') {
            window.location = "/member";
        } else if (id == 'GROSIR') {
            window.location = "/grosir";
        } else if (id == 'MEMBER GROSIR') {
            window.location = "/member-grosir";
        }
    })
})
