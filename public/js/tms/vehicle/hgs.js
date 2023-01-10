$(function () {
    $('#hgsTable').DataTable({
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

    $('#addHGS').click(function () {
        $('#btnAddHGSButton').show();
        $('#btnEditHGSButton').hide();
        $("#modal-hgs").modal('show');
    });

    $('#btnAddHGSButton').click(function (e) {
        e.preventDefault();
        var vehicleId = $("#vehicleId").val();
        addHGS(vehicleId);
        $("#modal-hgs").modal('show');
    });

    $('#btnEditHGSButton').click(function (e) {
        e.preventDefault();
        updateHGS();
        $("#modal-hgs").modal('show');
    });

    $('#modal-hgs').on('hidden.bs.modal', function () {
        $(this).find('input[name="count"]').val(0);
    });

    const deleteHGS = function () {
        var id = $(this).attr('data-id');
        var vehicleId = $("#vehicleId").val();
        $.ajax({
            type: 'GET',
            url: '/tms/vehicle/hgs/delete',
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
                        title: 'HGS Silinemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                fillHGS(data.hgs);

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'HGS Silindi',
                    subtitle: '',
                    body: data.message
                })
            }
        });
    }

    const editHGS = function (e) {
        e.preventDefault();
        $('#btnAddHGSButton').hide();
        $('#btnEditHGSButton').show();

        var id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: '/tms/vehicle/hgs/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'HGS Bilgisi Alınamadı',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                var HGSModal = $("#modal-hgs")
                HGSModal.find('input[name="id"]').val(data.hgs.id);
                HGSModal.find('input[name="vehicle_id"]').val(data.hgs.vehicle_id);
                HGSModal.find('input[name="date"]').val(data.hgs.date);
                HGSModal.find('input[name="cost"]').val(data.hgs.cost);
                HGSModal.modal('show');
            }
        });

    }

    const updateHGS = function () {
        var HGSModal = $('#modal-hgs');
        var id = HGSModal.find('input[name="id"]').val();
        var vehicleId = HGSModal.find('input[name="vehicle_id"]').val();
        var date = HGSModal.find('input[name="date"]').val();
        var cost = HGSModal.find('input[name="cost"]').val();

        $.ajax({
            type: 'POST',
            url: '/tms/vehicle/hgs/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
                "vehicle_id": vehicleId,
                "date": date,
                "cost": cost
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'HGS Güncellenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillHGS(data.hgs);

            }
        });

    }

    const addHGS = function (vehicleId) {
        var HGSModal = $('#modal-hgs');
        var date = HGSModal.find('input[name="date"]').val();
        var cost = HGSModal.find('input[name="cost"]').val();

        $.ajax({
            type: 'POST',
            url: '/tms/vehicle/hgs/add',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "vehicle_id": vehicleId,
                "date": date,
                "cost": cost,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'HGS Eklenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillHGS(data.hgs);

            }
        });

    }

    const fillHGS = function (data) {
        var HGSTable = $('#hgsTable tbody');
        HGSTable.empty();
        jQuery.each(data, function (i, hgs) {
            HGSTable.append('<tr>');
            HGSTable.append('<td>' + hgs.date + '</td>');
            HGSTable.append('<td>' + hgs.cost + '</td>');
            HGSTable.append('<td><a class="deleteHGS" href="#" data-id="' + hgs.id + '"><i class="fa fa-trash"></i>SİL</a><a class="editHGS" style="margin-left: 20px" href="#" data-id="' + hgs.id + '"> <i class="fa fa-pen"></i>GÜNCELLE</a></td>');
            HGSTable.append('</tr>');
        });

        $('.deleteHGS').click(deleteHGS);
        $('.editHGS').click(editHGS);
        $('#modal-hgs').modal('hide');
    }

    $('.deleteHGS').click(deleteHGS);
    $('.editHGS').click(editHGS);
});
