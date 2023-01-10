$(function() {
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
});
  
  $(document).ready(function() {
      $('#tax_department_city_id').on('change', function() {
          var tax_department_city_id = $("#tax_department_city_id").val();
          $("#tax_deparment_district_id").html('');
          $.ajax({
              type: "POST",
              url: "/cms/district/district",
              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              data: {
                  "_token": $('meta[name="csrf-token"]').attr('content'),
                  "tax_department_city_id": tax_department_city_id,
                  "city_id": tax_department_city_id,
              },
              success: function(result) {
                  $('#tax_department_district_id').html('<option value="">Seçiniz</option>');
                  $.each(result, function(key, value) {
                      $("#tax_department_district_id").append('<option value="' + value.id +
                          '">' + value.name + '</option>');
                  });
              }
          });
      });
    });

  $(document).ready(function() {
      $('#tax_department_district_id').on('change', function() {
          var tax_department_district_id = $("#tax_department_district_id").val();
          $("#tax_deparment_district_id").html('');
          $.ajax({
              type: "POST",
              url: "/tms/customer/taxdepartments",
              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              data: {
                  "_token": $('meta[name="csrf-token"]').attr('content'),
                  "tax_department_district_id": tax_department_district_id,
              },
              success: function(result) {
                  $('#tax_department_id').html('<option value="">Seçiniz</option>');
                  $.each(result, function(key, value) {
                      $("#tax_department_id").append('<option value="' + value.id +
                          '">' + value.name + '</option>');
                  });
              }
          });
      });
    });
