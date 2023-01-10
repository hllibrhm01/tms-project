
$(function () {

    $('#meetingNoteTable').DataTable({
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

    $('#addMeetingNote').click(function () {
        $('#btnAddMeetingNoteButton').show();
        $('#btnEditMeetingNoteButton').hide();
        $("#modal-meeting-notes").modal('show');
    });

    $('#btnAddMeetingNoteButton').click(function () {
        var customerId = $("#customerId").val();
        addMeetingNote(customerId);
        $("#modal-meeting-notes").modal('show');
    });

    $('#btnEditMeetingNoteButton').click(function () {
        updateMeetingNote();
        $("#modal-meeting-notes").modal('show');
    });

    $('#modal-meeting-notes').on('hidden.bs.modal', function () {
        $(this).find('textarea[name="discussed_topics"]').val("");
        $(this).find('textarea[name="notes"]').val("");
        $(this).find('textarea[name="to_dos"]').val("");
        $(this).find('select[name="meeting_id"]').prop("selectedIndex", 0);

    });


    const deleteMeetingNote = function () {

        var id = $(this).attr('data-id');
        var customerId = $("#customerId").val();

        $.ajax({
            type: 'GET',
            url: '/meeting/note/delete',
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
                        title: 'Toplantı Notu Silinemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                fillMeetingNotes(data.meetingNotes);

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Toplantı Notu Silindi',
                    subtitle: '',
                    body: data.message
                })
            }
        });
    }

    const editMeetingNote = function () {

        $('#btnAddMeetingNoteButton').hide();
        $('#btnEditMeetingNoteButton').show();
        var id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: '/meeting/note/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Toplantı Notu Bulunamadı',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                var meetingNoteModal = $("#modal-meeting-notes");

                meetingNoteModal.find('input[name="id"]').val(id);
                meetingNoteModal.find('input[name="customer_id"]').val(data.meetingNote.customer_id);
                meetingNoteModal.find('textarea[name="discussed_topics"]').val(data.meetingNote.discussed_topics);
                meetingNoteModal.find('textarea[name="notes"]').val(data.meetingNote.notes);
                meetingNoteModal.find('textarea[name="to_dos"]').val(data.meetingNote.to_dos);
                meetingNoteModal.find('select[name="meeting_id"]').val(data.meetingNote.meeting_id).change();

                meetingNoteModal.modal('show');
            }
        });

    }

    const updateMeetingNote = function () {

        var meetingNoteModal = $('#modal-meeting-notes');
        var discussedTopics = meetingNoteModal.find('textarea[name="discussed_topics"]').val();
        var notes = meetingNoteModal.find('textarea[name="notes"]').val();
        var toDos = meetingNoteModal.find('textarea[name="to_dos"]').val();
        var meetingId = meetingNoteModal.find('select[name="meeting_id"]').val();
        var customerId = meetingNoteModal.find('input[name="customer_id"]').val();
        var id = meetingNoteModal.find('input[name="id"]').val();

        $.ajax({
            type: 'POST',
            url: '/meeting/note/edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
                "customer_id": customerId,
                "discussed_topics": discussedTopics,
                "notes": notes,
                "to_dos": toDos,
                "meeting_id": meetingId,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Toplantı Güncellenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillMeetingNotes(data.meetingNotes);

            }
        });

    }

    const addMeetingNote = function (customerId) {

        var meetingNoteModal = $('#modal-meeting-notes');
        var discussedTopics = meetingNoteModal.find('textarea[name="discussed_topics"]').val();
        var notes = meetingNoteModal.find('textarea[name="notes"]').val();
        var toDos = meetingNoteModal.find('textarea[name="to_dos"]').val();
        var meetingId = meetingNoteModal.find('select[name="meeting_id"]').val();

        $.ajax({
            type: 'POST',
            url: '/meeting/note/add',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "customer_id": customerId,
                "discussed_topics": discussedTopics,
                "notes": notes,
                "to_dos": toDos,
                "meeting_id": meetingId,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Toplantı Notu Eklenemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }
                fillMeetingNotes(data.meetingNotes);

            }
        });

    }

    const fillMeetingNotes = function (data) {
        var meetingNoteTable = $('#meetingNoteTable tbody');
        meetingNoteTable.empty();

        jQuery.each(data, function (i, meetingNote) {
            meetingNoteTable.append('<tr>');
            meetingNoteTable.append('<td>' + meetingNote.meeting.header + '</td>');
            meetingNoteTable.append('<td>' + meetingNote.meeting.meet_type + '</td>');
            meetingNoteTable.append('<td>' + meetingNote.discussed_topics + '</td>');
            meetingNoteTable.append('<td>' + meetingNote.notes + '</td>');
            meetingNoteTable.append('<td>' + meetingNote.to_dos + '</td>');
            meetingNoteTable.append('<td><a  href="#" class="deleteMeetingNote" data-id="' + meetingNote.id + '"><i class="nav-icon fa fa-trash "></i></td>');
            meetingNoteTable.append('<td><a href="#" class="editMeetingNote" data-id="' + meetingNote.id + '"><i class="nav-icon fa fa-edit "></i></td>');
            meetingNoteTable.append('</tr>');
        });

        $('.deleteMeetingNote').click(deleteMeetingNote);

        $('.editMeetingNote').click(editMeetingNote);

        $('#modal-meeting-notes').modal('hide');
    }



    $('.deleteMeetingNote').click(deleteMeetingNote);

    $('.editMeetingNote').click(editMeetingNote);
});