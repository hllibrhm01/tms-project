
@extends('main.main')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-12">
                                <!-- general form elements -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Depo Düzenle</h3>
                                    </div>

                                    <div>
                                        <input type="hidden" id="current_city" value="{{$location->city_id}}">
                                        <input type="hidden" id="current_district" value="{{$location->district_id}}">

                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="POST" action="">
                                        @csrf
                                        <div class="container">
                                            <div class="input-group mt-4 row">
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="city_id">Şehir :</label>
                                                    </div>
                                                    <div class="col">
                                                        <select class="form-control" id="city_id" name="city_id">
                                                            <option 
                                                                value="{{ $location->city->id }}"
                                                                data-select2-id="{{ $location->city->id }}">
                                                                {{ $location->city->name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="district_id">İlçe :</label>
                                                    </div>
                                                    <div class="col">
                                                        <select class="form-control" id="district_id" name="district_id">
                                                            <option 
                                                                value="{{ $location->district->id }}"
                                                                data-select2-id="{{ $location->district->id }}">
                                                                {{ $location->district->name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row mb-3">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="address_description">Adres Bilgisi :</label>
                                                    </div>
                                                    <div class="col">
                                                        <textarea 
                                                            class="form-control" 
                                                            rows="3" 
                                                            id="address_description" 
                                                            name="address_description"
                                                            placeholder="Enter ...">{{ $location->address_description }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="authorized_person">Yetkili Adı-Soyadı :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input 
                                                            value="{{ $location->authorized_person }}"
                                                            type="text" 
                                                            class="form-control" 
                                                            name="authorized_person"
                                                            placeholder="Yetkili adı giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="email">Email :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input 
                                                            value="{{ $location->email }}"
                                                            type="text" 
                                                            class="form-control" 
                                                            name="email"
                                                            placeholder="Email adresi giriniz">
                                                    </div>
                                                </div>
                                                    <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="phone">Telefon :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input 
                                                            value="{{ $location->phone }}"
                                                            type="text" 
                                                            class="form-control" 
                                                            id="phone" 
                                                            name="phone"
                                                            placeholder="Telefon numarası giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row mb-3">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="capacity">Kapasite :</label>
                                                    </div>
                                                    <div class="col">
                                                        <textarea 
                                                            class="form-control" 
                                                            rows="3" 
                                                            id="capacity" 
                                                            name="capacity"
                                                            placeholder="Enter ...">{{ $location->capacity }}</textarea>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer ml-auto">
                                            <div class="float-right">
                                                <button type="submit" class="btn btn-primary">Kaydet</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('js')
@endsection

<script type="text/javascript">
$(document).ready(function() {
    let isOwnerIdSet = true;
	$('#type').on('change', function() {
		var type = this.value;
		$("#owner_id").html('');
		$.ajax({
			url: "{{route('post.tms.order.customers')}}",
			type: "POST",
			data: {
				type: type,
				_token: '{{csrf_token()}}'
			},
			dataType: 'json',
			success: function(result) {
				$('#owner_id').html('<option value="">Seçiniz</option>');
				$.each(result, function(key, value) {
					$("#owner_id").append('<option value="' + value.id + '">' + value.company_name + '</option>');
				});

                if(isOwnerIdSet)
                {
                        let currentOwnerId = $('#current_owner_id').val(); 
                        $('#owner_id').val(currentOwnerId).change();             
                        isOwnerIdSet = false;
                }
			}
		});
	});

    let currentType = $('#type').val(); 
    $('#type').val(currentType).change();
});
</script>


<script type="text/javascript">
    $(document).ready(function() {
        let isDistrictSet = true;
        let isCitySet = true;
        $("#city_id").html('');
        $.ajax({
            url: "{{route('post.tms.order.cities')}}",
            type: "POST",
            data: {
                //city: city,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
                $('#city_id').html('<option value="">Seçiniz</option>');
                $.each(result, function(key, value) {
                    $("#city_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                });

                if(isCitySet)
                {
                        let currentCity = $('#current_city').val(); 
                        $('#city_id').val(currentCity).change();             
                        isCitySet = false;
                }
            }
        });
        $('#city_id').on('change', function() {
            var city_id = this.value;
            $("#district_id").html('');
            $.ajax({
                url: "{{route('post.tms.order.districts')}}",
                type: "POST",
                data: {
                    city_id: city_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                    $.each(result, function(key, value) {
                        $("#district_id").append('<option value=' + value.id + '>' + value.name + '</option>');
                    });

                    if(isDistrictSet)
                    {
                         let currentDistrict = $('#current_district').val(); 
                          $('#district_id').val(currentDistrict).change();   
                          isDistrictSet = false;
                    }
                }
            });
        });

        let currentCity = $('#current_city').val(); 
        $('#city_id').val(currentCity).change();
    });
</script>

