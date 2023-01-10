$(function () {

    $('#assignmentTable').DataTable({
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


    $('.btnShowSentEmail').click(function () {
        $('#btnSentEmail').attr('disabled', false);
        var assignmentId = $(this).attr("data-id");
        $('#modal-sent-email').find('input[name="assignment_id"]').val(assignmentId)
        $('#modal-sent-email').modal("show");
    });


    $('#btnSentEmail').click(function () {
        $('#btnSentEmail').attr('disabled', true);
        var assignmentId = $('#modal-sent-email').find('input[name="assignment_id"]').val();
        var emailTemplateId = $('#modal-sent-email').find('select[name="email_template_id"]').val();

        $.ajax({
            type: 'POST',
            url: '/email/assignment/sent',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "assignment_id": assignmentId,
                "email_template_id": emailTemplateId,
            },
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Mail Gönderilemedi',
                        subtitle: '',
                        body: data.message
                    })
                    return;
                }

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Mail Gönderildi',
                    subtitle: '',
                    body: data.message
                })

                $('#modal-sent-email').modal("hide");
            }
        });

    });


    $('#modal-sent-email').on('hidden.bs.modal', function () {
        $(this).find('select[name="email_template_id"]').prop("selectedIndex", 0);
    });


});