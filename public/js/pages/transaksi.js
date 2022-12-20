const loadSelect2 = () => {
    $('#create_supplier_id').select2();
    $('#create_cabang_id').select2();
}
var modals = {addModal: undefined, editModal: undefined};

function calculateTotal() {
    let total_product_prices = 0;
    let tax = parseInt($("#create_tax").val());

    $(".create_new_produk").each(function (i, e) {
        let pid = $(this).attr("data-produk");
        let price = parseInt($( this ).find(".produk_price").val());
        let qty = parseInt($( this ).find(".qty").val());
        total_product_prices = total_product_prices + price*qty;
    });

    let subtotal = tax+total_product_prices;

    $("#create_calc_products").text(Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: total_product_prices.toString().length }).format(total_product_prices));
    $("#create_calc_tax").text(Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: tax.toString().length }).format(tax));
    $("#create_calc_subtotal").text(Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: subtotal.toString().length }).format(subtotal));
    $("#create_calc_total").text(Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: subtotal.toString().length }).format(subtotal));

    return ({products: total_product_prices, tax: tax, subtotal: tax+total_product_prices});
}

$(function () {
    const addModalEl = document.getElementById('addModal');
    var options = {
        onShow: () => {
            $('#create_order_code').val(null).change();
            $('#create_description').val(null).change();
            $('#estimated_date').val(null).change();

            $('#create_supplier_id').val(null).change();
            $('#create_cabang_id').val(null).change();

            $('#create_supplier_id').select2({
                placeholder: "Pilih supplier",
            });
            // $('#create_cabang_id').select2({
            //     placeholder: "Pilih cabang",
            // });

            // $('#create_produk_id').select2();

            if ($('#create_produk_id').select2()) {
                $('#create_produk_id').select2('destroy');
            }
            $('#create_produk_id').val(null).change();
            $("#create_produk_id").attr("disabled", true);

            calculateTotal();
        },
    };
    modals["addModal"] = new Modal(addModalEl, options);

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
            allowClear: true,
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
                    let res = $.map(data, function (e, i) {
                        return {id: e.id, text: e.nama, price: 5000}
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
