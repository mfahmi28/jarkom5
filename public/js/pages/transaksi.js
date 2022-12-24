const loadSelect2 = () => {
    $('#create_supplier_id').select2();
    $('#create_cabang_id').select2();
}
var modals = {addModal: undefined, detailModal: undefined};

function toIdr(int) {
    return (Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: int.toString().length }).format(int));
}

const calculateTotal = () => {
    let total_product_prices = 0;
    let tax = parseInt($("#create_tax").val());

    $(".create_new_produk").each(function (i, e) {
        let pid = $(this).attr("data-produk");
        let price = parseInt($( this ).find(".produk_price").val());
        let qty = parseInt($( this ).find(".qty").val());
        total_product_prices = total_product_prices + (price * qty);
    });

    let subtotal = tax+total_product_prices;

    $("#create_calc_products").text(toIdr(total_product_prices));
    $("#create_calc_tax").text(toIdr(tax));
    $("#create_calc_subtotal").text(toIdr(subtotal));
    $("#create_calc_total").text(toIdr(subtotal));

    return ({products: total_product_prices, tax: tax, subtotal: tax+total_product_prices});
}

window.calculateTotal = calculateTotal();

$(function () {
    const addModalEl = document.getElementById('addModal');
    const detailModalEl = document.getElementById('detailModal');

    modals["addModal"] = new Modal(addModalEl, {});
    modals["detailModal"] = new Modal(detailModalEl, {});


    window.showTransactionCreate = () => {
        $('#create_order_code').val(null).change();
        $('#create_description').val(null).change();
        $('#estimated_date').val(null).change();

        $('#create_supplier_id').val(null).change();
        $('#create_cabang_id').val(null).change();

        $('#create_produk_id').val(null).change();
        $("#create_produk_id").attr("disabled", true);

        calculateTotal();
        modals["addModal"].show();

        if ($('#create_produk_id').select2()) {
            $('#create_produk_id').select2('destroy');
        }

        $('#create_supplier_id').select2({
            placeholder: "Pilih supplier",
        });
    }

    window.showTransactionDetail = (transaksi_id) => {
        showLoadingScreen(true)

        $.ajax({
            type: 'GET',
            url: '/transaksi/detail',
            data: {
                transaksi_id: transaksi_id
            },
            success: function(response) {
                showLoadingScreen(false);

                $("#detail_apply").attr('data-transaksi_id', response.transaksi_detail.id);
                $("#detail_order_code").text(response.transaksi_detail.order_code);
                $("#detail_supplier").text(response.transaksi_detail.supplier);
                $("#detail_estimated_date").text(response.transaksi_detail.estimated_date);
                $("#detail_supplier").text(response.transaksi_detail.supplier);
                $("#detail_description").text(response.transaksi_detail.description);
                $("#detail_status_name").text(response.transaksi_detail.status_name);
                $("#detail_tax").text(toIdr(response.transaksi_detail.tax));
                $("#detail_total_produk").text(toIdr(response.transaksi_detail.total));
                $("#detail_total").text(toIdr(response.transaksi_detail.subtotal));
                $("#detail_sub_total").text(toIdr(response.transaksi_detail.subtotal));

                $("#detail_list_produks").html("");
                if (response.transaksi_detail.transaksi_produks) {
                    response.transaksi_detail.transaksi_produks.forEach((produk, idx) => {
                        $("#detail_list_produks").append(listProdukTemplate(produk.produk_name, produk.qty, (idx%2 ? 'bg-purple-100' : 'bg-white'), produk.id));
                    });
                }

                if(response.transaksi_detail.status == 0) { // PENDING
                    $('.btn-approve').removeClass('hidden')
                } else {
                    $('.btn-approve').addClass('hidden')
                }

                if(response.transaksi_detail.status == 1) { // APPROVED
                    $('.btn-ship').removeClass('hidden')
                } else {
                    $('.btn-ship').addClass('hidden')
                }

                if(response.transaksi_detail.status == 3) { // SHIPPING
                    $('.btn-receive, .retur-field').removeClass('hidden')
                } else {
                    $('.btn-receive, .retur-field').addClass('hidden')
                }

                if(response.status == 'OK') {
                    modals["detailModal"].show();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                showLoadingScreen(false);

                alert('Terjadi Kesalahan! Silahkan Ulangi');
            }
        })
    }

    $("#detail_apply button").on("click", function (e) {
        let id = $( this ).parent().attr('data-transaksi_id');
        let action = $( this ).attr('data-action');
        if ( action ) {
            applyTransaksi(id, action);
        }
    });

    $(".toggle-modal").on("click", function (e) {
        e.preventDefault();
        if ($(this).data('modal')) {
            modals[$(this).data('modal')].toggle();
        }
    });

    $('#create_supplier_id').on('select2:select', function (e) {
        $('#create_produk_id').val(null).trigger('change');
        $('#create_produk_id option').remove();

        $("#create_produk_id").attr("disabled", false);
        $('#create_produk_id').select2({
            placeholder: "Pilih produk",
            // allowClear: true,
            ajax: {
                url: `${route}/search/produk`,
                delay: 250,
                data: function (params) {
                    var query = {
                        q: params.term,
                        l: 8,
                        s: $("#create_supplier_id").val()
                    }
                    return query;
                },
                processResults: function (data) {
                    console.log(data)
                    let res = $.map(data, function (e, i) {
                        return {id: e.id, text: e.nama, price: e.harga_per_qty}
                    });
                    return { results: res };
                }
            }
        });
        $(`.create_new_produk`).remove();

        calculateTotal();
        // let supplier_id = $(this).val();
        // let old_supplier_id = $('#create_supplier_id_old').val();

        // console.log('supplier Selected');
        // if (old_supplier_id && old_supplier_id != supplier_id) {
        //     //todo confirm
        // } else {
        //     $('#create_supplier_id_old').val(supplier_id);
        // }
    });

    $("#create_produk_add").on("click", function (e) {
        let data = $('#create_produk_id').select2('data')[0];
        if (data) {
            let pid = data.id;
            let pname = data.text;
            let price = data.price;
            let qty =  parseInt($("#create_qty").val());

            if (qty > 0) {
                if ($(`.create_new_produk[data-produk=${pid}]`).length) {
                    let new_product = $(`.create_new_produk[data-produk=${pid}]`).find('.qty');
                    new_product.val(parseInt(new_product.val()) + qty);
                }else{
                    $("#create_product_list").append(createProdukTemplate(pid, pname, qty, price));
                }
            }
        }
        calculateTotal();
    });

    $(document).on('click','.remove_produk',function(){
        $(`.create_new_produk[data-produk=${$(this).attr('data-produk')}]`).remove();
        calculateTotal();
    });
});
