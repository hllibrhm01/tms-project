$(function (e) {
    let isServiceSet = true;
    $("#service_id").html('');
    $.ajax({
        url: '/tms/vehicle/services',
        type: "POST",
        data: {
          "_token": $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        success: function(result) {
            $('#service_id').html('<option value="">Seçiniz</option>');
            $.each(result, function(key, value) {
                $("#service_id").append('<option value="' + value.id +
                    '">' + value.name + '</option>');
            });
            if (isServiceSet) {
                let currentServiceId = $('#current_service_id').val();
                $('#service_id').val(currentServiceId).change();
                isServiceSet = false;
        }
    }
    });

    $("#service_div").hide();
    $("#service_description").click(function() {
        if($(this).is(":checked")) {
            $("#service_div").show();
        } else {
            $("#service_div").hide();
        }
    });

    
    var controlServiceDescription = document.getElementById("service_description").checked;
    controlServiceDescription ? $("#service_div_edit").show() : $("#service_div_edit").hide();
    $("#service_description").click(function() {
        if($(this).is(":checked")) {
            $("#service_div_edit").show();
        } else {
            $("#service_div_edit").hide();
        }
    });
    
    $("#supplier_div").hide();
    $("#ownership").change(function() {
        if($(this).val() == "1") {
            $("#supplier_div").show();
        } else {
            $("#supplier_div").hide();
        }
    });

    if($("#ownership").val() == "1") {
        $("#supplier_div").show();
    } else {
        $("#supplier_div").hide();
    }

});