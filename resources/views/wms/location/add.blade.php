
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
                                        <h3 class="card-title">Depo Ekle</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="POST" action="{{ route('post.wms.location.add') }}">
                                        @csrf
                                        <div class="container">
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="city_id">Şehir :</label>
                                                    </div>
                                                    <div class="col">
                                                        <select class="form-control" id="city_id" name="city_id">
                                                            @foreach ($cities as $city)
                                                                <option value="{{ $city->id }}" data-select2-id="{{ $city->id }}">{{ $city->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="district_id">İlçe :</label>
                                                    </div>
                                                    <div class="col">
                                                        <select class="form-control" id="district_id" name="district_id">
                                                            @foreach ($districts as $distict)
                                                                <option value="{{ $distict->id }}"
                                                                    data-select2-id="{{ $distict->id }}">
                                                                    {{ $distict->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row mb-3">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="address_description">Adres Bilgisi :</label>
                                                    </div>
                                                    <div class="col">
                                                        <textarea class="form-control" rows="3" id="address_description" name="address_description"
                                                        placeholder="Enter ..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="authorized_person">Yetkili Adı Soyadı :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input class="form-control" id="authorized_person" name="authorized_person"
                                                            placeholder="Yetkili Adı Soyadı Giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="email">Email :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control" id="email" name="email"
                                                            placeholder="Email giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row mb-3">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="phone">Telefon :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control" id="phone" name="phone"
                                                            placeholder="Telefon giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row mb-3">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="capacity">Kapasite:</label>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control" id="capacity" name="capacity"
                                                            placeholder="Kapasite giriniz">
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
	$('#type').on('change', function() {
		var type = this.value;
		$("#owner_id").html('');
		$.ajax({
			url: "{{route('post.wms.order.customers')}}",
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
			}
		});
	});
	});

</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#city_id').on('change', function() {
            var city_id = this.value;
            $("#district_id").html('');
            $.ajax({
                url: "{{route('post.wms.order.districts')}}",
                type: "POST",
                data: {
                    city_id: city_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#district_id').html('<option value="">Seçiniz</option>');
                    $.each(result, function(key, value) {
                        $("#district_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        });
    });
</script>

