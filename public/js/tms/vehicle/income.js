$(function () {
    $('#incomesTable').DataTable({
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

    $('#addIncome').click(function () {
        $('#btnAddIncomeButton').show();
        $('#btnEditIncomeButton').hide();
        $("#modal-incomes").modal('show');
    });

    $('#btnAddIncomeButton').click(function (e) {
        e.preventDefault();
        var vehicleId = $("#vehicleId").val();
        addIncome(vehicleId);
        $("#modal-incomes").modal('show');
    });

    $('#btnEditIncomeButton').click(function (e) {
        e.preventDefault();
        updateIncome();
        $("#modal-incomes").modal('show');
    });

    /*
    $('#modal-incomes').on('hidden.bs.modal', function () {
        $(this).find('input[name="count"]').val(0);
        $(this).find('select[name="inspection_id"]').prop("selectedIndex", 0);

    });
    */

    const deleteIncome = function () {
        var id = $(this).attr('data-id');
        var vehicleId = $("#vehicleId").val();
        $.ajax({
            type: 'GET',
            url: '/tms/vehicle/income/delete',
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
                        title: 'Hakediş Silinemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                fillIncomes(data.incomes);

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Hakediş Silindi',
                    subtitle: '',
                    body: data.message
                })
            }
        });
    }

    const editIncome = function (e) {
        e.preventDefault();
        $('#btnAddIncomeButton').hide();
        $('#btnEditIncomeButton').show();

        var id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: '/tms/vehicle/income/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Hakediş Bilgisi Alınamadı',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                var incomeModal = $("#modal-incomes")
                incomeModal.find('input[name="id"]').val(data.income.id);
                incomeModal.find('input[name="vehicle_id"]').val(data.income.vehicle_id);
                incomeModal.find('input[name="date"]').val(data.income.date);
                incomeModal.find('input[name="income"]').val(data.income.income);
                incomeModal.modal('show');
            }
        });

    }

    const updateIncome = function () {
        var incomeModal = $('#modal-incomes');
        var id = incomeModal.find('input[name="id"]').val();
        var vehicleId = incomeModal.find('input[name="vehicle_id"]').val();
        var date = incomeModal.find('input[name="date"]').val();
        var income = incomeModal.find('input[name="income"]').val();

        $.ajax({
            type: 'POST',
            url: '/tms/vehicle/income/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
                "vehicle_id": vehicleId,
                "date": date,
                "income": income
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Hakediş Güncellenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillIncomes(data.incomes);

            }
        });

    }

    const addIncome = function (vehicleId) {
        var incomeModal = $('#modal-incomes');
        var date = incomeModal.find('input[name="date"]').val();
        var income = incomeModal.find('input[name="income"]').val();

        $.ajax({
            type: 'POST',
            url: '/tms/vehicle/income/add',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "vehicle_id": vehicleId,
                "date": date,
                "income": income,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Hakediş Eklenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillIncomes(data.incomes);

            }
        });

    }

    const fillIncomes = function (data) {
        var incomeTable = $('#incomesTable tbody');
        incomeTable.empty();
        jQuery.each(data, function (i, income) {
            incomeTable.append('<tr>');
            incomeTable.append('<td>' + income.date + '</td>');
            incomeTable.append('<td>' + income.income + '</td>');
            incomeTable.append('<td><a class="deleteIncome" href="#" data-id="' + income.id + '"><i class="fa fa-trash"></i>SİL</a><a class="editIncome" style="margin-left: 20px" href="#" data-id="' + income.id + '"> <i class="fa fa-pen"></i>GÜNCELLE</a></td>');
            incomeTable.append('</tr>');
        });

        $('.deleteIncome').click(deleteIncome);
        $('.editIncome').click(editIncome);
        $('#modal-incomes').modal('hide');
    }

    $('.deleteIncome').click(deleteIncome);
    $('.editIncome').click(editIncome);
});
