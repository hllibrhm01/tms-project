$(function () {
    $('#productsTable').DataTable({
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
    
    $('#modal-products').on('hidden.bs.modal', function () {
        $(this).find('input[name="name"]').val("");
        $(this).find('input[name="price"]').val(0);
    });

    $('#addProduct').click(function () {
        $('#btnAddProductButton').show();
        $('#btnEditProductButton').hide();
        $("#modal-products").modal('show');
    });

    $('#btnAddProductButton').click(function (e) {
        e.preventDefault();
        var customerId = $("#customerId").val();
        addProduct(customerId);
        $("#modal-products").modal('show');
    });

    $('#btnEditProductButton').click(function (e) {
        e.preventDefault();
        updateProduct();
        $("#modal-products").modal('show');
    });

    const deleteProduct = function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var customerId = $("#customerId").val();
        $.ajax({
            type: 'GET',
            url: '/tms/customer/product/delete',
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
                        title: 'Ürün Silinemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                fillProducts(data.products);

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Ürün Silindi',
                    subtitle: '',
                    body: data.message
                })
            }
        });
    }

    const editProduct = function (e) {
        e.preventDefault();
        $('#btnAddProductButton').hide();
        $('#btnEditProductButton').show();

        var id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: '/tms/customer/product/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Ürün Bilgisi Alınamadı',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                var productModal = $("#modal-products")
                productModal.find('input[name="id"]').val(data.product.id);
                productModal.find('input[name="customer_id"]').val(data.product.customer_id);
                productModal.find('input[name="name"]').val(data.product.name);
                productModal.find('input[name="price"]').val(data.product.price);
                productModal.modal('show');
            }
        });

    }

    const updateProduct = function () {
        var productModal = $('#modal-products');
        var id = productModal.find('input[name="id"]').val();
        var customerId = productModal.find('input[name="customer_id"]').val();
        var name = productModal.find('input[name="name"]').val();
        var price = productModal.find('input[name="price"]').val();

        $.ajax({
            type: 'POST',
            url: '/tms/customer/product/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
                "customer_id": customerId,
                "name": name,
                "price" : price
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Ürün Güncellenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillProducts(data.products);

            }
        });

    }

    const addProduct = function (customerId) {
        var productModal = $('#modal-products');
        var name = productModal.find('input[name="name"]').val();
        var price = productModal.find('input[name="price"]').val();

        $.ajax({
            type: 'POST',
            url: '/tms/customer/product/add',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "customer_id": customerId,
                "name": name,
                "price" : price
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Ürün Eklenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillProducts(data.products);

            }
        });

    }

    const fillProducts = function (data) {
        var incomeTable = $('#productsTable tbody');
        incomeTable.empty();
        jQuery.each(data, function (i, product) {
            incomeTable.append('<tr>');
            incomeTable.append('<td>' + product.name + '</td>');
            incomeTable.append('<td>' + product.price + '</td>');
            incomeTable.append('<td><a class="deleteProduct" href="#" data-id="' + product.id + '"><i class="fa fa-trash"></i>SİL</a><a class="editProduct" style="margin-left: 20px" href="#" data-id="' + product.id + '"> <i class="fa fa-pen"></i>GÜNCELLE</a></td>');
            incomeTable.append('</tr>');
        });

        $('.deleteProduct').click(deleteProduct);
        $('.editProduct').click(editProduct);
        $('#modal-products').modal('hide');
    }

    $('.deleteProduct').click(deleteProduct);
    $('.editProduct').click(editProduct);
});
