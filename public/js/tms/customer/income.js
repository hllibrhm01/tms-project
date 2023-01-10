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
        var customerId = $("#customerId").val();
        addIncome(customerId);
        $("#modal-incomes").modal('show');
    });

    $('#btnEditIncomeButton').click(function (e) {
        e.preventDefault();
        updateIncome();
        $("#modal-incomes").modal('show');
    });

    const deleteIncome = function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var customerId = $("#customerId").val();
        $.ajax({
            type: 'GET',
            url: '/tms/customer/income/delete',
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

        if (id == null) {
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Hakediş Günceleme Hatası',
                subtitle: '',
                body: 'Hakediş bilgileri alınamadı'
            })
            return;
        }

        $.ajax({
            type: 'GET',
            url: '/tms/customer/income/edit',
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
                incomeModal.find('input[name="customer_id"]').val(data.income.customer_id);
                incomeModal.find('input[name="date"]').val(data.income.date);
                incomeModal.find('input[name="income"]').val(data.income.income);
                incomeModal.modal('show');
            }
        });

    }

    const updateIncome = function () {
        var incomeModal = $('#modal-incomes');
        var id = incomeModal.find('input[name="id"]').val();
        var customerId = incomeModal.find('input[name="customer_id"]').val();
        var date = incomeModal.find('input[name="date"]').val();
        var income = incomeModal.find('input[name="income"]').val();

        if (date == '' || income == '') {
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Hakediş Güncellenemedi',
                subtitle: '',
                body: 'Tarih alanı veya fiyat alanı boş bırakılamaz'
            })
            return;
        }

        $.ajax({
            type: 'POST',
            url: '/tms/customer/income/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
                "customer_id": customerId,
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

    const addIncome = function (customerId) {
        var incomeModal = $('#modal-incomes');
        var date = incomeModal.find('input[name="date"]').val();
        var income = incomeModal.find('input[name="income"]').val();

        if (date == '' || income == '') {
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Hakediş Eklenemedi',
                subtitle: '',
                body: 'Tarih ve Hakediş Alanları Boş Bırakılamaz'
            })
            return;
        }

        $.ajax({
            type: 'POST',
            url: '/tms/customer/income/add',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "customer_id": customerId,
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
      console.log(data);
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
