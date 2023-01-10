
$(function () {
    $('#vehicleOrdersTable').sortable({ items: 'tr' });

    $("#save").on('click', function () {
        var vehicleId = $("#vehicle_id").val();
        var planDate = $("#plan_date_input").val();

        var orders = [];
        $('#vehicleOrdersTable > tbody  > tr').each(function (index, tr) {
            var orderId = $(tr).attr("orderId");
            orders.push(orderId);
        });

        $.ajax({
            type: 'POST',
            url: "/tms/vehicle/plan/update",
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

    $('#plan_date').datetimepicker({
        format: 'YYYY-MM-DD',
    });

});