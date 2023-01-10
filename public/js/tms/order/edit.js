$(document).ready(function () {

    $('#group_type').on('change', function () {
        var groupType = $("#group_type").val();
        $("#owner_id").html('');
        $.ajax({
            type: "POST",
            url: "/tms/order/customers",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "group_type": groupType,
            },
            success: function (result) {
                $('#owner_id').html('<option value="">Seçiniz</option>');
                $.each(result, function (key, value) {
                    $("#owner_id").append('<option value="' + value.id + '">' +
                        value.company_name + '</option>');
                });
            }
        });
    });

    let isOwnerIdSet = true;
    $('#type').on('change', function () {
        var type = $("#type").val();
        $("#owner_id").html('');
        $.ajax({
            type: "POST",
            url: "/tms/order/customers",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "type": type,
            },
            success: function (result) {
                $('#owner_id').html('<option value="">Seçiniz</option>');
                $.each(result, function (key, value) {
                    $("#owner_id").append('<option value="' + value.id + '">' + value.company_name + '</option>');
                });

                if (isOwnerIdSet) {
                    let currentOwnerId = $('#current_owner_id').val();
                    $('#owner_id').val(currentOwnerId).change();
                    isOwnerIdSet = false;
                }
            }
        });
    });

    let currentType = $('#type').val();
    $('#type').val(currentType).change();

    let isDistrictSet = true;
    let isCitySet = true;
    $("#city_id").html('');
    $.ajax({
        type: "POST",
        url: "/cms/city/cities",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (result) {
            $.each(result, function (key, value) {
                $("#city_id").append('<option value="' + value.id + '">' + value.name + '</option>');
            });

            if (isCitySet) {
                let currentCity = $('#current_city').val();
                $('#city_id').val(currentCity).change();
                isCitySet = false;
            }
        }
    });

    $('#city_id').on('change', function () {
        var city_id = $("#city_id").val();
        $("#district_id").html('');
        $.ajax({
            type: "POST",
            url: "/cms/district/district",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "city_id": city_id,
                "tax_department_city_id": city_id,
            },
            success: function (result) {
                $.each(result, function (key, value) {
                    $("#district_id").append('<option value=' + value.id + '>' + value.name + '</option>');
                });

                if (isDistrictSet) {
                    let currentDistrict = $('#current_district').val();
                    $('#district_id').val(currentDistrict).change();
                    isDistrictSet = false;
                }
            }
        });
    });

    $('#owner_id').on('change', function () {
        var customerId = $('#owner_id').val();
        $("#product_list").html('');
        $.ajax({
            type: "GET",
            url: "/tms/customer/product/list",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "customer_id": customerId,
            },
            success: function (data) {
                $('#product_list').html('<option value="">Seçiniz</option>');
                $.each(data.products, function (key, value) {
                    $('#product_list').append('<option value="' + value.id +
                        '">' + value.name + '</option>');
                });
            }
        });
    });

    $('#btnAddProduct').on('click', function () {
        var value = $("#product_list option:selected").val();
        if(value == 0)
        {
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Ürün Seçiniz',
                subtitle: '',
                body: "Eklemek için ürün seçiniz"
            })
            return;
        }
        var text = $("#product_list option:selected").text();

        var productsTable = $('#productsTable tbody');
        productsTable.append('<tr><td class="d-none"><input name="productId[]" type="hidden" value="' + value + '"></td><td>' + text + '</td><td><input name="productCount[]" type="number" value="1"></td><td><a class="deleteProduct" href="#" data-id="' + value + '"><i class="fa fa-trash"></i>SİL</a></td></tr>');
        $('.deleteProduct').click(removeProduct);
    });

    $('.deleteProduct').on('click', function () {
        $(this).closest('tr').remove();
    });

    function removeProduct() {
        $(this).closest('tr').remove();
    }

    let currentCity = $('#current_city').val();
    $('#city_id').val(currentCity).change();
});
