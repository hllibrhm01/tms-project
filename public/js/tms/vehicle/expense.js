
$(function () {

    const DAILY_MEAL_PRICE = $('#daily_mail_price').val();

    $('#vehiclesTable').DataTable({
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

    $(".fuel_taken_with_tl").on('change', function () {
        var closestDivCollapsibleContent = $(this).closest('.collapsible-content');
        var driven = closestDivCollapsibleContent.find("input[name=driven_km]").val();
        var value = $(this).val();
        var calculated = (value / 1.18).toFixed(2);
        var calculatedPerKM = calculated / driven;
        $(this).val(calculated);
        closestDivCollapsibleContent.find("input[name=fuel_consumption_per_km]").val(calculatedPerKM.toFixed(2));
        calculateTotal(closestDivCollapsibleContent);
    });

    $(".driven_km").on('change', function () {
        var closestDivCollapsibleContent = $(this).closest('.collapsible-content');
        var value = $(this).val();
        var fuel_taken_with_tl = closestDivCollapsibleContent.find("input[name=fuel_taken_with_tl]").val();
        var fuel_taken_per_litre = closestDivCollapsibleContent.find("input[name=fuel_taken_per_litre]").val();
        var fuel_consumption_per_km = fuel_taken_with_tl / value;
        var fuel_consumption_percentage_per_km = (fuel_taken_per_litre / value) * 100;
        closestDivCollapsibleContent.find("input[name=fuel_consumption_per_km]").val(fuel_consumption_per_km.toFixed(2));
        closestDivCollapsibleContent.find("input[name=fuel_consumption_percentage_per_km]").val(fuel_consumption_percentage_per_km.toFixed(2));
        calculateTotal(closestDivCollapsibleContent);
    });

    $(".fuel_taken_per_litre").on('change', function () {
        var closestDivCollapsibleContent = $(this).closest('.collapsible-content');
        var driven_km = closestDivCollapsibleContent.find("input[name=driven_km]").val();
        var value = $(this).val();
        var fuel_consumption_percentage_per_km = (value / driven_km) * 100;
        closestDivCollapsibleContent.find("input[name=fuel_consumption_percentage_per_km]").val(fuel_consumption_percentage_per_km.toFixed(2));
        calculateTotal(closestDivCollapsibleContent);
    });

    $(".employee_count").on('change', function () {
        var closestDivCollapsibleContent = $(this).closest('.collapsible-content');
        var employee_count = $(this).val();
        var dailyCost = employee_count * DAILY_MEAL_PRICE;
        closestDivCollapsibleContent.find("input[name=daily_meal_cost]").val(dailyCost);
        calculateTotal(closestDivCollapsibleContent);
    });

    $(".employee_count").on('change', function () {
        var closestDivCollapsibleContent = $(this).closest('.collapsible-content');
        var employee_count = closestDivCollapsibleContent.find("input[name=employee_count]").val();
        var dailyCost = employee_count * DAILY_MEAL_PRICE;
        closestDivCollapsibleContent.find("input[name=daily_meal_cost]").val(dailyCost);
        calculateTotal(closestDivCollapsibleContent);
    });

    $(".overtimer_employee_count").on('change', function () {
        var closestDivCollapsibleContent = $(this).closest('.collapsible-content');
        var overtimer_employee_count = closestDivCollapsibleContent.find("input[name=overtimer_employee_count]").val();
        var overtimeDailyCost = overtimer_employee_count * DAILY_MEAL_PRICE;
        closestDivCollapsibleContent.find("input[name=daily_overtime_meal_cost]").val(overtimeDailyCost);
        calculateTotal(closestDivCollapsibleContent);
    });

    $(".daily_overtime_meal_cost,.highway_expenses,.day_laborer,.supplies_cost,.rental_cost,.employee_cost").on('change', function () {
        calculateTotal($(this).closest('.collapsible-content'));
    });


    function calculateTotal(tr) {
        var fuel_taken_with_tl = tr.find("input[name=fuel_taken_with_tl]").val();
        var rental_cost = tr.find("input[name=rental_cost]").val();
        var employee_cost = tr.find("input[name=employee_cost]").val();
        var daily_meal_cost = tr.find("input[name=daily_meal_cost]").val();
        var daily_overtime_meal_cost = tr.find("input[name=daily_overtime_meal_cost]").val();
        var highway_expenses = tr.find("input[name=highway_expenses]").val();
        var day_laborer = tr.find("input[name=day_laborer]").val();
        var supplies_cost = tr.find("input[name=supplies_cost]").val();

        var total = parseFloat(fuel_taken_with_tl) + parseFloat(rental_cost) + parseFloat(employee_cost) + parseFloat(daily_meal_cost);
        total += parseFloat(daily_overtime_meal_cost) + parseFloat(highway_expenses) + parseFloat(day_laborer) + parseFloat(supplies_cost);
        tr.find("input[name=total_cost]").val(total.toFixed(2));
    }

    $(".save").on('click', function () {
        var closestDivCollapsibleContent = $(this).closest('.collapsible-content');
        var employee_count = closestDivCollapsibleContent.find("input[name=employee_count]").val();
        var missing_employee_count = closestDivCollapsibleContent.find("input[name=missing_employee_count]").val();
        var overtimer_employee_count = closestDivCollapsibleContent.find("input[name=overtimer_employee_count]").val();
        var work_finish_time = closestDivCollapsibleContent.find("input[name=work_finish_time]").val();
        var driven_km = closestDivCollapsibleContent.find("input[name=driven_km]").val();
        var fuel_taken_per_litre = closestDivCollapsibleContent.find("input[name=fuel_taken_per_litre]").val();
        var fuel_taken_with_tl = closestDivCollapsibleContent.find("input[name=fuel_taken_with_tl]").val();
        var fuel_consumption_per_km = closestDivCollapsibleContent.find("input[name=fuel_consumption_per_km]").val();
        var fuel_consumption_percentage_per_km = closestDivCollapsibleContent.find("input[name=fuel_consumption_percentage_per_km]").val();
        var rental_cost = closestDivCollapsibleContent.find("input[name=rental_cost]").val();
        var employee_cost = closestDivCollapsibleContent.find("input[name=employee_cost]").val();
        var daily_meal_cost = closestDivCollapsibleContent.find("input[name=daily_meal_cost]").val();
        var daily_overtime_meal_cost = closestDivCollapsibleContent.find("input[name=daily_overtime_meal_cost]").val();
        var highway_expenses = closestDivCollapsibleContent.find("input[name=highway_expenses]").val();
        var day_laborer = closestDivCollapsibleContent.find("input[name=day_laborer]").val();
        var supplies_cost = closestDivCollapsibleContent.find("input[name=supplies_cost]").val();
        var total_cost = closestDivCollapsibleContent.find("input[name=total_cost]").val();
        var vehicle_id = closestDivCollapsibleContent.find("input[name=vehicle_id]").val();
        var date = $("#plan_date_input").val();

        $.ajax({
            type: 'POST',
            url: "/tms/vehicle/expense/update",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "vehicle_id": vehicle_id,
                "date": date,
                "employee_count": employee_count,
                "missing_employee_count": missing_employee_count,
                "overtimer_employee_count": overtimer_employee_count,
                "work_finish_time": work_finish_time,
                "driven_km": driven_km,
                "fuel_taken_per_litre": fuel_taken_per_litre,
                "fuel_taken_with_tl": fuel_taken_with_tl,
                "fuel_consumption_per_km": fuel_consumption_per_km,
                "fuel_consumption_percentage_per_km": fuel_consumption_percentage_per_km,
                "rental_cost": rental_cost,
                "employee_cost": employee_cost,
                "daily_meal_cost": daily_meal_cost,
                "daily_overtime_meal_cost": daily_overtime_meal_cost,
                "highway_expenses": highway_expenses,
                "day_laborer": day_laborer,
                "supplies_cost": supplies_cost,
                "total_cost": total_cost
            },
            success: function (data) {
                if (data.error) {
                    return;
                }

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Maliyet Bilgisi Güncellendi.',
                    body: 'Maliyet Bilgisi Güncellendi.',
                })

                closestDivCollapsibleContent.find("input[name=total_revenue]").val(data.expense.total_revenue);
            }
        });
    });

    $('#plan_date').datetimepicker({
        format: 'YYYY-MM-DD',
    });

    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    };

});