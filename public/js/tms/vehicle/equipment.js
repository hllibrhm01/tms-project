
$(function () {
    $('#equipmentsTable').DataTable({
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

    $('#addEquipment').click(function () {
        $('#btnAddEquipmentButton').show();
        $('#btnEditEquipmentButton').hide();
        $("#modal-equipments").modal('show');
    });

    $('#btnAddEquipmentButton').click(function (e) {
        e.preventDefault();
        var vehicleId = $("#vehicleId").val();
        addEquipment(vehicleId);
        $("#modal-equipments").modal('show');
    });

    $('#btnEditEquipmentButton').click(function (e) {
        e.preventDefault();
        updateEquipment();
        $("#modal-equipments").modal('show');
    });

    $('#modal-equipments').on('hidden.bs.modal', function () {
        $(this).find('input[name="count"]').val(0);
        $(this).find('select[name="equipment_id"]').prop("selectedIndex", 0);

    });

    const deleteEquipment = function () {
        var id = $(this).attr('data-id');""
        var vehicleId = $("#vehicleId").val();
        $.ajax({
            type: 'GET',
            url: '/tms/vehicle/equipment/delete',
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
                        title: 'Ekipman Silinemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                fillEquipments(data.equipments);

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Ekipman Silindi',
                    subtitle: '',
                    body: data.message
                })
            }
        });
    }

    const editEquipment = function (e) {
        e.preventDefault();
        $('#btnAddEquipmentButton').hide();
        $('#btnEditEquipmentButton').show();

        var id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: '/tms/vehicle/equipment/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Ekipman Bilgisi Alınamadı',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                var equipmentModal = $("#modal-equipments")
                equipmentModal.find('input[name="id"]').val(data.equipment.id);
                equipmentModal.find('input[name="vehicle_id"]').val(data.equipment.vehicle_id);
                equipmentModal.find('input[name="count"]').val(data.equipment.count);
                equipmentModal.find('select[name="equipment_id"]').val(data.equipment.equipment_id).change();
                equipmentModal.modal('show');
            }
        });

    }

    const updateEquipment = function () {
        var equipmentModal = $('#modal-equipments');
        var vehicleId = equipmentModal.find('input[name="vehicle_id"]').val();
        var count = equipmentModal.find('input[name="count"]').val();
        var equipmentId = equipmentModal.find('select[name="equipment_id"]').val();
        var id = equipmentModal.find('input[name="id"]').val();

        $.ajax({
            type: 'POST',
            url: '/tms/vehicle/equipment/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
                "count": count,
                "equipment_id": equipmentId,
                "vehicle_id": vehicleId
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Ekipman Güncellenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillEquipments(data.equipments);

            }
        });

    }

    const addEquipment = function (vehicleId) {
        var equipmentModal = $('#modal-equipments');
        var count = equipmentModal.find('input[name="count"]').val();
        var equipmentId = equipmentModal.find('select[name="equipment_id"]').val();

        $.ajax({
            type: 'POST',
            url: '/tms/vehicle/equipment/add',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "vehicle_id": vehicleId,
                "equipment_id": equipmentId,
                "count": count,
            },
            success: function (data) {
              console.log(data);
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Ekipman Eklenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillEquipments(data.equipments);

            }
        });

    }

    const fillEquipments = function (data) {
        var equipmentTable = $('#equipmentsTable tbody');
        equipmentTable.empty();
        jQuery.each(data, function (i, equipment) {
          console.log(equipment);
            equipmentTable.append('<tr>');
            equipmentTable.append('<td>' + equipment.equipment.equipment_name + '</td>');
            equipmentTable.append('<td>' + equipment.count + '</td>');
            equipmentTable.append('<td><a class="deleteEquipment" href="#" data-id="' + equipment.id + '"><i class="fa fa-trash"></i>SİL</a><a class="editEquipment" style="margin-left: 20px" href="#" data-id="' + equipment.id + '"> <i class="fa fa-pen"></i>GÜNCELLE</a></td>');
            equipmentTable.append('</tr>');
        });

        $('.deleteEquipment').click(deleteEquipment);
        $('.editEquipment').click(editEquipment);
        $('#modal-equipments').modal('hide');
    }

    $('.deleteEquipment').click(deleteEquipment);
    $('.editEquipment').click(editEquipment);
});
