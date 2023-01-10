$(function () {
    $('#vehicleOrdersTable').sortable({ items: 'tr' });

    $(document).on('click', '#save', function () {
        var vehicleId = $("#vehicle_id").val();
        var planDate = $("#plan_date_input").val();

        var orders = [];
        $('#vehicleOrdersTable > tbody  > tr').each(function (index, tr) {
            var orderId = $(tr).attr("orderId");
            orders.push(orderId);
        });

        $.ajax({
            type: 'POST',
            url: "update",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "vehicle_id": vehicleId,
                "plan_date": planDate,
                "orders": orders,
            },
            success: function (data) {
                if (data.error) {
                    console.log(data.message);
                    return;
                }

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Planlama Kaydedildi',
                    body: 'Planlama başarıyla kaydedildi.',
                })
            }
        });
    });

    $(document).on('click', '.updateStatus', function () {
        var orderId = $(this).attr("orderId");

        $.ajax({
            type: 'POST',
            url: "/tms/order/nextStatus",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "order_id": orderId,
            },
            success: function (data) {
                if (data.error) {
                    console.log(data.message);
                    return;
                }
                openStatusModel(data.order_id, data.status_list, data.code);
            }
        });
    });

    $(document).on('click', '#btnUpdateStatusButton', function () {
        // button disabled 
        $('#btnUpdateStatusButton').prop('disabled', true);
        const codeRequiredList = JSON.parse($("#codeMandatoryStatus").val());
        const imageRequiredList = JSON.parse($("#imageMandatoryStatus").val());
        const noteRequiredList = JSON.parse($("#noteMandatoryStatus").val());
        let selectedStatus = parseInt($("#status_list").val());

        var orderId = $("#order_id").val();
        var note = $("#note").val();
        var statusId = $("#status_list").val();
        var code = $("#code").val();

        let hasError = false;
        let slsIndex = codeRequiredList.indexOf(selectedStatus);
        if (slsIndex > -1) {
            if (code == "") {
                hasError = true;
                $('#btnUpdateStatusButton').prop('disabled', false);
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'SMS Kodu Hatası',
                    body: 'SMS Kodu Boş Bırakılamaz',
                })
            } else {
                $('#btnUpdateStatusButton').prop('disabled', false);
            }
        }

        let noteIndex = noteRequiredList.indexOf(selectedStatus);
        if (noteIndex > -1) {
            if (note == "") {
                hasError = true;
                $('#btnUpdateStatusButton').prop('disabled', false);
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Not Alanı Hatası',
                    body: 'Not Alanı Boş Bırakılamaz',
                })
            }
        }

        let imageIndex = imageRequiredList.indexOf(selectedStatus);
        if (imageIndex > -1) {
            let total = $('#images1source')[0]?.files.length;
            total += $('#images2source')[0]?.files.length;
            total += $('#images3source')[0]?.files.length;
            total += $('#images4source')[0]?.files.length;
            total += $('#images5source')[0]?.files.length;
            total += $('#images6source')[0]?.files.length;

            if (total < 1) {
                hasError = true;
                $('#btnUpdateStatusButton').prop('disabled', false);
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Fotoğraf Yükleme Hatası',
                    body: 'En az 1 Fotoğraf Yüklenmelidir',
                })
            }
        }

        if (hasError)
            return;

        var formData = new FormData();

        if ($('#images1source')[0]?.files.length > 0) {
            var img1 = $('#images1source')[0].files[0];
            formData.append('file1', img1);
        }

        if ($('#images2source')[0]?.files.length > 0) {
            var img2 = $('#images2source')[0].files[0];
            formData.append('file2', img2);
        }

        if ($('#images3source')[0]?.files.length > 0) {
            var img3 = $('#images3source')[0].files[0];
            formData.append('file3', img3);
        }

        if ($('#images4source')[0]?.files.length > 0) {
            var img4 = $('#images4source')[0].files[0];
            formData.append('file4', img4);
        }

        if ($('#images5source')[0]?.files.length > 0) {
            var img5 = $('#images5source')[0].files[0];
            formData.append('file5', img5);
        }

        if ($('#images6source')[0]?.files.length > 0) {
            var img6 = $('#images6source')[0].files[0];
            formData.append('file6', img6);
        }

        formData.append('order_id', orderId);
        formData.append('status', statusId);
        formData.append('note', note);
        formData.append('code', code);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        $.ajax({
            type: 'POST',
            url: "/tms/order/updateStatus",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            enctype: 'multipart/form-data',
            data: formData,
            success: function (data) {
                if (data.error) {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Güncelleme Başarısız',
                        body: data.message,
                    })
                    $("#modal-status").modal('hide');
                    return;
                }


                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Güncelleme Başarılı',
                    body: data.message,
                })


                $("#modal-status").modal('hide');
                window.location.reload();
            }
        });

    });

    $(document).on('change', '#status_list', function () {
        const codeRequiredList = JSON.parse($("#codeMandatoryStatus").val());
        let value = parseInt($("#status_list").val());
        let index = codeRequiredList.indexOf(value);
        if (index > -1)
            $('#code_div').removeClass('d-none');
        else
            $('#code_div').addClass('d-none');

    });

    const openStatusModel = function (orderId, statusList, code) {
        var statusModal = $("#modal-status");
        var selectBox = statusModal.find('select[name="status_list"]');
        statusModal.find('input[name="order_id"]').val(orderId);
        statusModal.find('input[name="temp_code"]').val(code);

        selectBox.empty();
        for (var i = 0; i < statusList.length; i++) {
            selectBox.append('<option value="' + statusList[i]["id"] + '">' + statusList[i]["value"] + '</option>');
        };

        let slValue = parseInt($("#status_list").val());
        $('#status_list').val(slValue).change();
        statusModal.modal('show');
    };


    let slValue = parseInt($("#status_list").val());
    $('#status_list').val(slValue).change();

});
