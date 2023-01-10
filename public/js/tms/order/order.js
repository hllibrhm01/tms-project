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


    var orderTable = $('#orderTable');
    
    if (orderTable.length > 0) {
        $('#ordersTable').DataTable({
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
    }

    $('#city_id').on('change', function () {
        loadDistricts(this.value);
    });

    $('#district_id').on('change', function () {
        loadNeighborhoods(this.value);
    });


    const loadDistricts = function (cityId) {
        $.ajax({
            type: 'GET',
            url: "/address/city/districts",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "city_id": cityId
            },
            success: function (data) {
                if (data.error) {
                    console.log(data.message);
                    return;
                }
                fillDistricts(data.districts);
            }
        });
    }

    const fillDistricts = function (data) {
        var districtObject = $('#district_id');
        districtObject.empty();

        districtObject.append('<option value=0 data-select2-id="0">SEÇİNİZ</option>');
        jQuery.each(data, function (i, district) {
            districtObject.append('<option value=' + district["id"] + ' data-select2-id=' + district["id"] + '>' + district["name"] + '</option>');
        });
    }

    const loadNeighborhoods = function (districtId) {
        var cityId = $('#city_id').val();
        $.ajax({
            type: 'GET',
            url: "/address/district/neighborhood",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "district_id": districtId,
            },
            success: function (data) {
                if (data.error) {
                    console.log(data.message);
                    return;
                }
                fillNeighborhoods(data.neighborhoods);
            }
        });
    }

    const fillNeighborhoods = function (data) {
        var neighborhoodObject = $('#neighborhood_id');
        neighborhoodObject.empty();

        neighborhoodObject.append('<option value=0 data-select2-id="0">SEÇİNİZ</option>');
        jQuery.each(data, function (i, neighborhood) {
            neighborhoodObject.append('<option value=' + neighborhood["id"] + ' data-select2-id=' + neighborhood["id"] + '>' + neighborhood["name"] + '</option>');
        });
    }
