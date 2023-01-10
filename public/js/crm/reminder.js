
$(function () {

    $('#remindersTable').DataTable({
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

    $('#reminderFinishTime').datetimepicker({
        icons: {
            time: 'far fa-clock'
        },
        format: 'YYYY-MM-DD hh:mm:ss'
    });

    $('#addReminder').click(function () {
        $('#btnAddReminderButton').show();
        $('#btnEditReminderButton').hide();
        $("#modal-reminders").modal('show');
    });

    $('#btnAddReminderButton').click(function () {
        var customerId = $("#customerId").val();
        addReminder(customerId);
        $("#modal-reminders").modal('show');
    });

    $('#btnEditReminderButton').click(function () {
        updateReminder();
        $("#modal-reminders").modal('show');
    });

    $('#modal-reminders').on('hidden.bs.modal', function () {
        $(this).find('input[name="email"]').val("");
        $(this).find('input[name="abstract"]').val("");
        $(this).find('textarea[name="body"]').val("");
        $(this).find('select[name="is_completed"]').prop("selectedIndex", 0);

    });

    const deleteReminder = function () {

        var id = $(this).attr('data-id');
        var customerId = $("#customerId").val();

        $.ajax({
            type: 'GET',
            url: '/reminder/delete',
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
                        title: 'Hatırlatıcı Silinemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                fillReminders(data.reminders);

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Hatırlatıcı Silindi',
                    subtitle: '',
                    body: data.message
                })
            }
        });
    }

    const editReminder = function () {

        $('#btnAddReminderButton').hide();
        $('#btnEditReminderButton').show();

        var id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: '/reminder/edit',
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

                var reminderModal = $("#modal-reminders")

                reminderModal.find('input[name="id"]').val(data.reminder.id);
                reminderModal.find('input[name="customer_id"]').val(data.reminder.customer_id);
                reminderModal.find('input[name="email"]').val(data.reminder.email);
                reminderModal.find('textarea[name="body"]').val(data.reminder.body);
                reminderModal.find('input[name="abstract"]').val(data.reminder.abstract);
                reminderModal.find('select[name="is_completed"]').val(data.reminder.is_completed).change();
                reminderModal.find('input[name="finish_time"]').val(data.reminder.finish_time).change();

                reminderModal.modal('show');
            }
        });

    }

    const updateReminder = function () {

        var reminderModal = $('#modal-reminders');
        var email = reminderModal.find('input[name="email"]').val();
        var body = reminderModal.find('textarea[name="body"]').val();
        var abstract = reminderModal.find('input[name="abstract"]').val();
        var isCompleted = reminderModal.find('select[name="is_completed"]').val();
        var finishTime = reminderModal.find('input[name="finish_time"]').val();
        var customerId = reminderModal.find('input[name="customer_id"]').val();
        var id = reminderModal.find('input[name="id"]').val();

        $.ajax({
            type: 'POST',
            url: '/reminder/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
                "customer_id": customerId,
                "email": email,
                "body": body,
                "abstract": abstract,
                "is_completed": isCompleted,
                "finish_time": finishTime,
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
                fillReminders(data.reminders);

            }
        });

    }

    const addReminder = function (customerId) {

        var reminderModal = $('#modal-reminders');
        var email = reminderModal.find('input[name="email"]').val();
        var body = reminderModal.find('textarea[name="body"]').val();
        var abstract = reminderModal.find('input[name="abstract"]').val();
        var isCompleted = reminderModal.find('select[name="is_completed"]').val();
        var finishTime = reminderModal.find('input[name="finish_time"]').val();
        var customerId = reminderModal.find('input[name="customer_id"]').val();

        $.ajax({
            type: 'POST',
            url: '/reminder/add',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "customer_id": customerId,
                "email": email,
                "body": body,
                "abstract": abstract,
                "is_completed": isCompleted,
                "finish_time": finishTime,
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
                fillReminders(data.reminders);

            }
        });

    }

    const fillReminders = function (data) {
        var reminderTable = $('#remindersTable tbody');
        reminderTable.empty();

        jQuery.each(data, function (i, reminder) {

            var isCompleted = '<i class="fas fa-check" style="color:green"></i>';
            if (reminder.is_completed != 1) {
                isCompleted = '<i class="fas fa-clock" style="color:red"></i>';
                if (new Date(reminder.finish_time) > new Date())
                    isCompleted = ' <i class="fas fa-hourglass-half" style="color:gray"></i>';
            }

            reminderTable.append('<tr>');
            reminderTable.append('<td>' + reminder.email + '</td>');
            reminderTable.append('<td>' + reminder.abstract + '</td>');
            reminderTable.append('<td>' + reminder.finish_time + '</td>');
            reminderTable.append('<td style="text-align:center;">' + isCompleted + '</td>');
            reminderTable.append('<td><a class="deleteReminder" href="#" data-id="' + reminder.id + '"><i class="nav-icon fa fa-trash "></i></td>');
            reminderTable.append('<td><a class="editReminder" href="#" data-id="' + reminder.id + '"><i class="nav-icon fa fa-edit "></i></td>');
            reminderTable.append('</tr>');
        });

        $('.deleteReminder').click(deleteReminder);

        $('.editReminder').click(editReminder);

        $('#modal-reminders').modal('hide');
    }



    $('.deleteReminder').click(deleteReminder);

    $('.editReminder').click(editReminder);
});