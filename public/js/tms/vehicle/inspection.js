$(function () {
    $('#inspectionsTable').DataTable({
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

    $('#addInspection').click(function () {
        $('#btnAddInspectionButton').show();
        $('#btnEditInspectionButton').hide();
        $("#modal-inspections").modal('show');
    });

    $('#btnAddInspectionButton').click(function (e) {
        e.preventDefault();
        var vehicleId = $("#vehicleId").val();
        addInspection(vehicleId);
        $("#modal-inspections").modal('show');
    });

    $('#btnEditInspectionButton').click(function (e) {
        e.preventDefault();
        updateInspection();
        $("#modal-inspections").modal('show');
    });

    $('#modal-inspections').on('hidden.bs.modal', function () {
        $(this).find('input[name="count"]').val(0);
        $(this).find('select[name="inspection_id"]').prop("selectedIndex", 0);

    });

    const deleteInspection = function () {
        var id = $(this).attr('data-id');
        var vehicleId = $("#vehicleId").val();
        $.ajax({
            type: 'GET',
            url: '/tms/vehicle/inspection/delete',
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
                        title: 'Bakım Silinemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                fillInspections(data.inspections);

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Bakım Silindi',
                    subtitle: '',
                    body: data.message
                })
            }
        });
    }

    const editInspection = function (e) {
        e.preventDefault();
        $('#btnAddInspectionButton').hide();
        $('#btnEditInspectionButton').show();

        var id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: '/tms/vehicle/inspection/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Bakım Bilgisi Alınamadı',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                var inspectionModal = $("#modal-inspections")
                inspectionModal.find('input[name="id"]').val(data.inspection.id);
                inspectionModal.find('input[name="vehicle_id"]').val(data.inspection.vehicle_id);
                inspectionModal.find('input[name="date"]').val(data.inspection.date);
                inspectionModal.find('input[name="cost"]').val(data.inspection.cost);
                // inspectionModal.find('select[name="equipment_id"]').val(data.equipment.equipment_id).change();
                inspectionModal.modal('show');
            }
        });

    }

    const updateInspection = function () {
        var inspectionModal = $('#modal-inspections');
        var id = inspectionModal.find('input[name="id"]').val();
        var vehicleId = inspectionModal.find('input[name="vehicle_id"]').val();
        var date = inspectionModal.find('input[name="date"]').val();
        var cost = inspectionModal.find('input[name="cost"]').val();

        $.ajax({
            type: 'POST',
            url: '/tms/vehicle/inspection/edit',
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
                        title: 'Bakım Güncellenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillInspections(data.inspections);

            }
        });

    }

    const addInspection = function (vehicleId) {
        var inspectionModal = $('#modal-inspections');
        var date = inspectionModal.find('input[name="date"]').val();
        var cost = inspectionModal.find('input[name="cost"]').val();

        $.ajax({
            type: 'POST',
            url: '/tms/vehicle/inspection/add',
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
                        title: 'Bakım Eklenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillInspections(data.inspections);

            }
        });

    }

    const fillInspections = function (data) {
        var inspectionTable = $('#inspectionsTable tbody');
        inspectionTable.empty();
        jQuery.each(data, function (i, inspection) {
            inspectionTable.append('<tr>');
            inspectionTable.append('<td>' + inspection.date + '</td>');
            inspectionTable.append('<td>' + inspection.cost + '</td>');
            inspectionTable.append('<td><a class="deleteInspection" href="#" data-id="' + inspection.id + '"><i class="fa fa-trash"></i>SİL</a><a class="editInspection" style="margin-left: 20px" href="#" data-id="' + inspection.id + '"> <i class="fa fa-pen"></i>GÜNCELLE</a></td>');
            inspectionTable.append('</tr>');
        });

        $('.deleteInspection').click(deleteInspection);
        $('.editInspection').click(editInspection);
        $('#modal-inspections').modal('hide');
    }

    $('.deleteInspection').click(deleteInspection);
    $('.editInspection').click(editInspection);
});
