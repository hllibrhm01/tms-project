$(function () {
    $('#maintainsTable').DataTable({
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

    $('#addMaintain').click(function () {
        $('#btnAddMaintainButton').show();
        $('#btnEditMaintainButton').hide();
        $("#modal-maintains").modal('show');
    });

    $('#btnAddMaintainButton').click(function (e) {
        e.preventDefault();
        var vehicleId = $("#vehicleId").val();
        addMaintain(vehicleId);
        $("#modal-maintains").modal('show');
    });

    $('#btnEditMaintainButton').click(function (e) {
        e.preventDefault();
        updateMaintain();
        $("#modal-maintains").modal('show');
    });

    const deleteMaintain = function () {
        var id = $(this).attr('data-id');
        var vehicleId = $("#vehicleId").val();
        $.ajax({
            type: 'GET',
            url: '/tms/vehicle/maintain/delete',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
                "vehicle_id": vehicleId
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Hatırlatıcı Silinemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                fillMaintains(data.maintains);

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Hatırlatıcı Silindi',
                    subtitle: '',
                    body: data.message
                })
            }
        });
    }

    const editMaintain = function (e) {
        e.preventDefault();
        $('#btnAddMaintainButton').hide();
        $('#btnEditMaintainButton').show();

        var id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: '/tms/vehicle/maintain/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Hatırlatıcı Bilgisi Alınamadı',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                var maintainModal = $("#modal-maintains")
                maintainModal.find('input[name="id"]').val(data.maintain.id);
                maintainModal.find('input[name="vehicle_id"]').val(data.maintain.vehicle_id);
                maintainModal.find('input[name="date"]').val(data.maintain.date);
                maintainModal.find('select[name="type"]').val(data.maintain.type);
                maintainModal.find('input[name="kilometer"]').val(data.maintain.kilometer);
                maintainModal.find('input[name="cost"]').val(data.maintain.cost);
                maintainModal.modal('show');
            }
        });

    }

    const updateMaintain = function () {
        var maintainModal = $('#modal-maintains');
        var id = maintainModal.find('input[name="id"]').val();
        var vehicleId = maintainModal.find('input[name="vehicle_id"]').val();
        var date = maintainModal.find('input[name="date"]').val();
        var type = maintainModal.find('select[name="type"]').val();
        var kilometer = maintainModal.find('input[name="kilometer"]').val();
        var cost = maintainModal.find('input[name="cost"]').val();

        $.ajax({
            type: 'POST',
            url: '/tms/vehicle/maintain/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
                "vehicle_id": vehicleId,
                "date": date,
                "type": type,
                "kilometer": kilometer,
                "cost": cost
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Hatırlatıcı Güncellenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillMaintains(data.maintains);

            }
        });

    }

    const addMaintain = function (vehicleId) {
        var maintainModal = $('#modal-maintains');
        var date = maintainModal.find('input[name="date"]').val();
        var type = maintainModal.find('select[name="type"]').val();
        var kilometer = maintainModal.find('input[name="kilometer"]').val();
        var cost = maintainModal.find('input[name="cost"]').val();

        $.ajax({
            type: 'POST',
            url: '/tms/vehicle/maintain/add',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "vehicle_id": vehicleId,
                "date": date,
                "type": type,
                "kilometer": kilometer,
                "cost": cost,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Hatırlatıcı Eklenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillMaintains(data.maintains);

            }
        });

    }

    const type = ["PERİYODİK", "HASAR", "MİNİ HASAR"];

    const fillMaintains = function (data) {
        var maintainTable = $('#maintainsTable tbody');
        maintainTable.empty();
        jQuery.each(data, function (i, maintain) {
            maintainTable.append('<tr>');
            maintainTable.append('<td>' + maintain.date + '</td>');
            maintainTable.append('<td>' + type[maintain.type] + '</td>');
            maintainTable.append('<td>' + maintain.kilometer + '</td>');
            maintainTable.append('<td>' + maintain.cost + '</td>');
            maintainTable.append('<td><a class="deleteMaintain" href="#" data-id="' + maintain.id + '"><i class="fa fa-trash"></i>SİL</a><a class="editMaintain" style="margin-left: 20px" href="#" data-id="' + maintain.id + '"> <i class="fa fa-pen"></i>GÜNCELLE</a></td>');
            maintainTable.append('</tr>');
        });

        $('.deleteMaintain').click(deleteMaintain);
        $('.editMaintain').click(editMaintain);
        $('#modal-maintains').modal('hide');
    }

    $('.deleteMaintain').click(deleteMaintain);
    $('.editMaintain').click(editMaintain);
});
