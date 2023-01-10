
$(function () {


    $('#meetingTable').DataTable({
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
    

    $('#addMeeting').click(function () {
        $('#btnAddMeetingButton').show();
        $('#btnEditMeetingButton').hide();
        $("#modal-meeting").modal('show');
    });

    $('#btnAddMeetingButton').click(function () {
        var customerId = $("#customerId").val();
        addMeeting(customerId);
        $("#modal-meeting").modal('show');
    });

    $('#btnEditMeetingButton').click(function () {
        updateMeeting();
        $("#modal-meeting").modal('show');
    });

    $('#modal-meeting').on('hidden.bs.modal', function () {
        $(this).find('input[name="header"]').val("");
        $(this).find('textarea[name="description"]').val("");
        $(this).find('input[name="schedule_date"]').val("");
        $(this).find('select[name="type"]').prop("selectedIndex", 0);

    });

    $('#meetingTime').datetimepicker({
        icons: {
            time: 'far fa-clock'
        },
        format: 'YYYY-MM-DD hh:mm:ss'
    });

    const deleteMeetings = function () {

        var id = $(this).attr('data-id');
        var customerId = $("#customerId").val();

        $.ajax({
            type: 'GET',
            url: '/meeting/delete',
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
                        title: 'Toplantı Silinemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                fillMeetings(data.meetings);

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Toplantı Silindi',
                    subtitle: '',
                    body: data.message
                })
            }
        });
    }

    const editMeetings = function () {

        $('#btnAddMeetingButton').hide();
        $('#btnEditMeetingButton').show();
        
        var id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: '/meeting/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Toplantı Silinemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                var meetingModal = $("#modal-meeting")

                meetingModal.find('input[name="id"]').val(id);
                meetingModal.find('input[name="customer_id"]').val(data.meeting.customer_id);
                meetingModal.find('input[name="header"]').val(data.meeting.header);
                meetingModal.find('textarea[name="description"]').val(data.meeting.description);
                meetingModal.find('input[name="schedule_date"]').val(data.meeting.schedule_date);
                meetingModal.find('select[name="type"]').val(data.meeting.type).change();

                meetingModal.modal('show');
            }
        });

    }

    const updateMeeting = function () {

        var meetingModal = $('#modal-meeting');
        var header = meetingModal.find('input[name="header"]').val();
        var description = meetingModal.find('textarea[name="description"]').val();
        var scheduleDate = meetingModal.find('input[name="schedule_date"]').val();
        var type = meetingModal.find('select[name="type"]').val();
        var customerId = meetingModal.find('input[name="customer_id"]').val();
        var id = meetingModal.find('input[name="id"]').val();

        $.ajax({
            type: 'POST',
            url: '/meeting/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
                "customer_id": customerId,
                "type": type,
                "header": header,
                "description": description,
                "schedule_date": scheduleDate,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Toplantı Silinemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillMeetings(data.meetings);

            }
        });

    }

    const addMeeting = function (customerId) {

        var meetingModal = $('#modal-meeting');
        var header = meetingModal.find('input[name="header"]').val();
        var description = meetingModal.find('textarea[name="description"]').val();
        var scheduleDate = meetingModal.find('input[name="schedule_date"]').val();
        var type = meetingModal.find('select[name="type"]').val();

        $.ajax({
            type: 'POST',
            url: '/meeting/add',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "customer_id": customerId,
                "type": type,
                "header": header,
                "description": description,
                "schedule_date": scheduleDate,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Toplantı Eklenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillMeetings(data.meetings);

            }
        });

    }

    const fillMeetings = function (data) {
        var meetingTable = $('#meetingTable tbody');
        meetingTable.empty();

        jQuery.each(data, function (i, meeting) {
            meetingTable.append('<tr>');
            meetingTable.append('<td>' + meeting.customer.company_name + '</td>');
            meetingTable.append('<td>' + meeting.customer.author + '</td>');
            meetingTable.append('<td>' + meeting.type + '</td>');
            meetingTable.append('<td>' + meeting.header + '</td>');
            meetingTable.append('<td>' + meeting.description + '</td>');
            meetingTable.append('<td>' + meeting.schedule_date + '</td>');
            meetingTable.append('<td><a class="deleteMeeting" href="#" data-id="' + meeting.id + '"><i class="nav-icon fa fa-trash "></i></td>');
            meetingTable.append('<td><a class="editMeeting" href="#" data-id="' + meeting.id + '"><i class="nav-icon fa fa-edit "></i></td>');
            meetingTable.append('</tr>');
        });

        $('.deleteMeeting').click(deleteMeetings);

        $('.editMeeting').click(editMeetings);

        $('#modal-meeting').modal('hide');
    }



    $('.deleteMeeting').click(deleteMeetings);

    $('.editMeeting').click(editMeetings);
});