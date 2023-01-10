
$(function () {

    $('#emailsTable').DataTable({
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


    $('#btnSentEmail').click(function () {
        $('#btnSentEmail').attr('disabled',true);
        var customerId = $("#customerId").val();
        var emailTemplateId = $('#modal-emails').find('select[name="email_template_id"]').val();

        $.ajax({
            type: 'POST',
            url: '/email/customer/sent',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "customer_id": customerId,
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
                fillEmails(data.emails);

            }
        });

    });


    $('#modal-emails').on('hidden.bs.modal', function () {
        $(this).find('select[name="email_template_id"]').prop("selectedIndex", 0);
        $('#btnSentEmail').attr('disabled',false);
    });


    const fillEmails = function (data) {
        var emailTable = $('#emailsTable tbody');
        emailTable.empty();

        jQuery.each(data, function (i, email) {
            emailTable.append('<tr>');
            emailTable.append('<td>' + email.type + '</td>');
            emailTable.append('<td>' + email.body + '</td>');
            emailTable.append('<td>' + email.sent_time + '</td>');
            emailTable.append('<td></td>');
            emailTable.append('</tr>');
        });

        $('#modal-emails').modal('hide');
    }


});