$(function () {

    $('#paperworksTable').DataTable({
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

    $('#addPaperwork').click(function () {
        $('#btnAddPaper').show();
        $('#btnEditPaper').hide();
        $("#modal-paperworks").modal('show');
    });

    $('#btnAddPaper').click(function () {
        var customerId = $("#customerId").val();
        addPaperwork(customerId);
        $("#modal-paperworks").modal('show');
    });

    $('#btnEditPaper').click(function () {
        updatePaperwork();
        $("#modal-paperworks").modal('show');
    });

    $('#modal-paperworks').on('hidden.bs.modal', function () {
        $(this).find('file[name="file"]').val("");
        $(this).find('textarea[name="description"]').val("");
        $(this).find('select[name="paper_type"]').prop("selectedIndex", 0);

    });

    const deletePaperwork = function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var customerId = $("#customerId").val();

        $.ajax({
            type: 'GET',
            url: '/tms/customer/paper/delete',
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
                        title: 'Evrak Silinemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                fillPaperworks(data.papers);

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Evrak Silindi',
                    subtitle: '',
                    body: data.message
                })
            }
        });
    }

    const editPaperwork = function (e) {
        e.preventDefault();
        $('#btnAddPaper').hide();
        $('#btnEditPaper').show();

        var id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: '/tms/customer/paper/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Evrak Bilgisi Alınamadı',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                var paperModal = $("#modal-paperworks");

                paperModal.find('input[name="id"]').val(data.paper.id);
                paperModal.find('input[name="customer_id"]').val(data.paper.customer_id);
                paperModal.find('file[name="file"]').val(data.paper.path);
                paperModal.find('textarea[name="description"]').val(data.paper.description);
                paperModal.find('select[name="paper_type"]').val(data.paper.type).change();

                paperModal.modal('show');
            }
        });

    }

    const updatePaperwork = function () {

        var paperModal = $('#modal-paperworks');
        var file = $('#paperFile')[0].files[0];
        var description = paperModal.find('textarea[name="description"]').val();
        var paperType = paperModal.find('select[name="paper_type"]').val();
        var customerId = paperModal.find('input[name="customer_id"]').val();
        var id = paperModal.find('input[name="id"]').val();

        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('customer_id', customerId);
        formData.append('description', description);
        formData.append('paper_type', paperType);
        formData.append('id', id);

        if (file != null)
            formData.append('file', file);

        $.ajax({
            type: 'POST',
            url: '/tms/customer/paper/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Evrak Güncellenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillPaperworks(data.papers);

            }
        });

    }

    const addPaperwork = function (customerId) {

        var paperModal = $('#modal-paperworks');
        var file = $('#paperFile')[0].files[0];
        var description = paperModal.find('textarea[name="description"]').val();
        var paperType = paperModal.find('select[name="paper_type"]').val();
        var customerId = paperModal.find('input[name="customer_id"]').val();
        //
        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('file', file);
        formData.append('customer_id', customerId);
        formData.append('description', description);
        formData.append('paper_type', paperType);

        $.ajax({
            url: '/tms/customer/paper/add',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Evrak Eklenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillPaperworks(data.papers);

            }
        });

    }

    const fillPaperworks = function (data) {
        var spaceUrl = $('#spaceUrl').val();
        var paperTable = $('#paperworksTable tbody');
        paperTable.empty();

        jQuery.each(data, function (i, paper) {
            paperTable.append('<tr>');
            paperTable.append('<td>' + paper.type + '</td>');
            paperTable.append('<td>' + paper.description + '</td>');
            paperTable.append('<td><a href="' + spaceUrl + "/" + paper.path + '" target="_blank">İNDİR</a></td>');
            paperTable.append('<td><a class="deletePaperwork" href="#" data-id="' + paper.id + '"><i class="nav-icon fa fa-trash "></i></td>');
            paperTable.append('<td><a class="editPaperwork" href="#" data-id="' + paper.id + '"><i class="nav-icon fa fa-edit "></i></td>');
            paperTable.append('</tr>');
        });

        $('.deletePaperwork').click(deletePaperwork);
        $('.editPaperwork').click(editPaperwork);
        $('#modal-paperworks').modal('hide');
    }

    $('.deletePaperwork').click(deletePaperwork);
    $('.editPaperwork').click(editPaperwork);
});