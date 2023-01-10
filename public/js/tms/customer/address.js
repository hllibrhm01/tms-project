$(function () {
    let isDistrictSet = true;
    let isCitySet = true;
    let isTaxDeparmentSet = true;
    $("#tax_department_city_id").html('');
    $.ajax({
        url: '/cms/city/cities',
        type: "POST",
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        success: function (result) {
            $.each(result, function (key, value) {
                $("#tax_department_city_id").append('<option value="' + value.id +
                    '">' + value.name + '</option>');
            });
            if (isCitySet) {
                let currentCity = $('#current_city').val();
                $('#tax_department_city_id').val(currentCity).change();
                isCitySet = false;
            }
        }
    });
    $('#tax_department_city_id').on('change', function () {
        var tax_department_city_id = this.value;
        $("#tax_department_district_id").html('');
        $.ajax({
            url: '/cms/district/district',
            type: "POST",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "tax_department_city_id": tax_department_city_id,
                "city_id": tax_department_city_id,
            },
            dataType: 'json',
            success: function (result) {
                $.each(result, function (key, value) {
                    $("#tax_department_district_id").append('<option value=' + value.id + '>' + value.name + '</option>');
                });
                if (isDistrictSet) {
                    let currentDistrict = $('#current_district').val();
                    $('#tax_department_district_id').val(currentDistrict).change();
                    isDistrictSet = false;
                }
            }
        });
    });
    $('#tax_department_district_id').on('change', function () {
        var tax_department_district_id = this.value;
        $("#tax_department_id").html('');
        $.ajax({
            url: '/tms/customer/taxdepartments',
            type: "POST",
            data: {
                "tax_department_district_id": tax_department_district_id,
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },
            dataType: 'json',
            success: function (result) {
                $.each(result, function (key, value) {
                    $("#tax_department_id").append('<option value=' + value.id + '>' + value.name + '</option>');
                });
                if (isTaxDeparmentSet) {
                    let currentTaxDepartment = $('#current_tax_department').val();
                    $('#tax_department_id').val(currentTaxDepartment).change();
                    isTaxDeparmentSet = false;
                }
            }
        });
    });
    let currentCity = $('#current_city').val();
    $('#tax_deparment_city_id').val(currentCity).change();



    $('#addressesTable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "sProcessing": "İşleniyor..",
            "sZeroRecords": "Henüz kayıt yok",
            "sEmptyTable": "Henüz kayıt yok",
            "sInfo": "Toplam _TOTAL_ kayıttan _START_ ile _END_ arası gösteriliyor",
            "sInfoEmpty": "Heüz kayıt yok",
            "sSearch": "Ara:",
            "sLoadingRecords": "Yükleniyor...",
            "oPaginate": {
                "sFirst": "Ilk Sayfa",
                "sLast": "Son Sayfa",
                "sNext": "Sıradaki",
                "sPrevious": "Önceki"
            },
            "oAria": {
                "sSortAscending": ": Artana göre sırala",
                "sSortDescending": ": Azalana göre sırala"
            }
        },
    });

    $('#addAddress').click(function () {
        $('#btnAddAddressButton').show();
        $('#btnEditAddressButton').hide();
        $("#modal-addresses").modal('show');
    });

    $('#btnAddAddressButton').click(function (e) {
        e.preventDefault();
        var customerId = $("#customerId").val();
        addAddress(customerId);
        $("#modal-addresses").modal('show');
    });

    $('#btnEditAddressButton').click(function (e) {
        e.preventDefault();
        updateAddress();
        $("#modal-addresses").modal('show');
    });

    const deleteAddress = function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var customerId = $("#customerId").val();
        $.ajax({
            type: 'GET',
            url: '/tms/customer/address/delete',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
                "customer_id": customerId
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Adres Silinemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                fillAddresses(data.addresses);

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Adres Silindi',
                    subtitle: '',
                    body: data.message
                })
            }
        });
    }

    const editAddress = function (e) {
        e.preventDefault();
        $('#btnAddAddressButton').hide();
        $('#btnEditAddressButton').show();

        var id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: '/tms/customer/address/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Adres Bilgisi Alınamadı',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                var addressModal = $("#modal-addresses");
                addressModal.find('input[name="id"]').val(data.address.id);
                addressModal.find('input[name="customer_id"]').val(data.address.customer_id);
                addressModal.find('select[name="city_id"]').val(data.address.city_id);
                addressModal.find('select[name="district_id"]').val(data.address.district_id);
                addressModal.find('input[name="address"]').val(data.address.address);
                addressModal.find('select[name="is_invoice_address"]').val(data.address.is_invoice_address);
                addressModal.modal('show');
            }
        });

    }

    const updateAddress = function () {
        var addressModal = $('#modal-addresses');
        var id = addressModal.find('input[name="id"]').val();
        var customerId = addressModal.find('input[name="customer_id"]').val();
        var cityId = addressModal.find('select[name="city_id"]').val();
        var districtId = addressModal.find('select[name="district_id"]').val();
        var address = addressModal.find('input[name="address"]').val();
        var isInvoiceAddress = addressModal.find('select[name="is_invoice_address"]').val();

        $.ajax({
            type: 'POST',
            url: '/tms/customer/address/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
                "customer_id": customerId,
                "city_id": cityId,
                "district_id": districtId,
                "address": address,
                "is_invoice_address": isInvoiceAddress,
            },
            success: function (data) {
                if (data.error) {
                    alert(data);
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Adres Güncellenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillAddresses(data.addresses);

            }
        });

    }

    const addAddress = function (customerId) {
        var addressModal = $('#modal-addresses');
        var cityId = addressModal.find('select[name="city_id"]').val();
        var districtId = addressModal.find('select[name="district_id"]').val();
        var address = addressModal.find('input[name="address"]').val();
        var isInvoiceAddress = addressModal.find('select[name="is_invoice_address"]').val();

        $.ajax({
            type: 'POST',
            url: '/tms/customer/address/add',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "customer_id": customerId,
                "city_id": cityId,
                "district_id": districtId,
                "address": address,
                "is_invoice_address": isInvoiceAddress,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Adres Eklenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillAddresses(data.addresses);

            }
        });

    }

    let invoiceStatus = ["HAYIR", "EVET"];

    const fillAddresses = function (data) {
        var addressTable = $('#addressesTable tbody');
        addressTable.empty();
        jQuery.each(data, function (i, address) {
            addressTable.append('<tr>');
            addressTable.append('<td>' + address.city.name + '</td>');
            addressTable.append('<td>' + address.district.name + '</td>');
            addressTable.append('<td>' + address.address + '</td>');
            addressTable.append('<td>' + invoiceStatus[address.is_invoice_address] + '</td>');
            addressTable.append('<td><a class="deleteAddress" href="#" data-id="' + address.id + '"><i class="fa fa-trash"></i>SİL</a><a class="editAddress" style="margin-left: 20px" href="#" data-id="' + address.id + '"> <i class="fa fa-pen"></i>GÜNCELLE</a></td>');
            addressTable.append('</tr>');
        });

        $('.deleteAddress').click(deleteAddress);
        $('.editAddress').click(editAddress);
        $('#modal-addresses').modal('hide');
    }

    $('.deleteAddress').click(deleteAddress);
    $('.editAddress').click(editAddress);
});

$(document).ready(function () {
    $('#city_id').on('change', function () {
        var city_id = this.value;
        $("#district_id").html('');
        $.ajax({
            url: '/cms/district/district',
            type: "POST",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "city_id": city_id,
                "tax_department_city_id": city_id,
            },
            dataType: 'json',
            success: function (result) {
                $('#district_id').html('<option value="">Seçiniz</option>');
                $.each(result, function (key, value) {
                    $("#district_id").append('<option value="' + value.id +
                        '">' + value.name + '</option>');
                });
            }
        });
    });
});
