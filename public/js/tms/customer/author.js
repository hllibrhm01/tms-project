$(function () {
    $('#authorsTable').DataTable({
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

    $('#modal-authors').on('hidden.bs.modal', function () {
        $(this).find('input[name="id"]').val(-1);
        $(this).find('input[name="name"]').val('');
        $(this).find('input[name="title"]').val('');
        $(this).find('input[name="phone"]').val('');
        $(this).find('input[name="email"]').val('');

    });

    $('#addAuthors').click(function () {
        $('#btnAddAuthorButton').show();
        $('#btnEditAuthorButton').hide();
        $("#modal-authors").modal('show');
    });

    $('#btnAddAuthorButton').click(function (e) {
        e.preventDefault();
        var customerId = $("#customerId").val();
        addAuthor(customerId);
        $("#modal-authors").modal('show');
    });

    $('#btnEditAuthorButton').click(function (e) {
        e.preventDefault();
        updateAuthor();
        $("#modal-authors").modal('show');
    });

    const deleteAuthor = function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var customerId = $("#customerId").val();
        $.ajax({
            type: 'GET',
            url: '/tms/customer/author/delete',
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
                        title: 'Yetkili Silinemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                fillAuthors(data.authors);

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Yetkili Silindi',
                    subtitle: '',
                    body: data.message
                })
            }
        });
    }

    const editAuthor = function (e) {
        e.preventDefault();
        $('#btnAddAuthorButton').hide();
        $('#btnEditAuthorButton').show();

        var id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: '/tms/customer/author/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Yetkili Bilgisi Alınamadı',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                var authorModal = $("#modal-authors")
                authorModal.find('input[name="id"]').val(data.author.id);
                authorModal.find('input[name="customer_id"]').val(data.author.customer_id);
                authorModal.find('input[name="name"]').val(data.author.name);
                authorModal.find('input[name="title"]').val(data.author.title);
                authorModal.find('input[name="phone"]').val(data.author.phone);
                authorModal.find('input[name="email"]').val(data.author.email);
                authorModal.modal('show');
            }
        });

    }

    const updateAuthor = function () {
        var authorModal = $('#modal-authors');
        var id = authorModal.find('input[name="id"]').val();
        var customerId = authorModal.find('input[name="customer_id"]').val();
        var name = authorModal.find('input[name="name"]').val();
        var title = authorModal.find('input[name="title"]').val();
        var phone = authorModal.find('input[name="phone"]').val();
        var email = authorModal.find('input[name="email"]').val();

        $.ajax({
            type: 'POST',
            url: '/tms/customer/author/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
                "customer_id": customerId,
                "name": name,
                "title": title,
                "phone": phone,
                "email": email
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Yetkili Güncellenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillAuthors(data.authors);

            }
        });

    }

    const addAuthor = function (customerId) {
        var authorModal = $('#modal-authors');
        var name = authorModal.find('input[name="name"]').val();
        var title = authorModal.find('input[name="title"]').val();
        var phone = authorModal.find('input[name="phone"]').val();
        var email = authorModal.find('input[name="email"]').val();

            if (email == "") {
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Yetkili Eklenemedi',
                    subtitle: '',
                    body: 'Yetkili E-Posta Adresi Boş Olamaz'
                })
                return;
            }

        $.ajax({
            type: 'POST',
            url: '/tms/customer/author/add',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "customer_id": customerId,
                "name": name,
                "title": title,
                "phone": phone,
                "email": email
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Yetkili Eklenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillAuthors(data.authors);

            }
        });

    }

    const fillAuthors = function (data) {
        var authorTable = $('#authorsTable tbody');
        authorTable.empty();
        jQuery.each(data, function (i, author) {
            authorTable.append('<tr>');
            authorTable.append('<td>' + author.name + '</td>');
            authorTable.append('<td>' + author.title + '</td>');
            authorTable.append('<td>' + author.phone + '</td>');
            authorTable.append('<td>' + author.email + '</td>');
            authorTable.append('<td><a class="deleteAuthor" href="#" data-id="' + author.id + '"><i class="fa fa-trash"></i>SİL</a><a class="editAuthor" style="margin-left: 20px" href="#" data-id="' + author.id + '"> <i class="fa fa-pen"></i>GÜNCELLE</a></td>');
            authorTable.append('</tr>');
        });

        $('.deleteAuthor').click(deleteAuthor);
        $('.editAuthor').click(editAuthor);
        $('#modal-authors').modal('hide');
    }

    $('.deleteAuthor').click(deleteAuthor);
    $('.editAuthor').click(editAuthor);
});
