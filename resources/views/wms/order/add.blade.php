
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
                                        <h3 class="card-title">Sipariş Ekle</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="POST" action="{{ route('post.wms.order.add', ['typeld' => 1]) }}">
                                        @csrf
                                        <div class="container">
                                            <div class="input-group mt-4 row">
                                                <div class="col-sm-2">
                                                    <label class="control-label">Tipi :</label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="type" name="type">
                                                        <option value="" selected>Seçiniz</option>
                                                        <option value="1"
                                                        @if((route('get.wms.order.add', ['typeld']) == '1')) selected @endif>
                                                            Bayi 
                                                        </option>
                                                        <option value="2"
                                                        @if((route('get.wms.order.add', ['typeld']) == '2')) selected @endif>
                                                            Depo 
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="owner_id">Şirket Adı :</label>
                                                    </div>
                                                    <div class="col">
                                                        <select class="form-control" id="owner_id" name="owner_id">
                                                            @foreach ($customers as $customer)
                                                                <option value="{{ $customer->id }}" data-select2-id="1">{{ $customer->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="weight">Ağırlık :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input type="number" class="form-control" id="weight" name="weight"
                                                            placeholder="Ağırlık giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="phone">Telefon :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control" id="phone" name="phone"
                                                            placeholder="Telefon numarası giriniz">
                                                    </div>
                                                </div>
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
                                                        <label class="control-label" for="product_info">Ürün Bilgisi:</label>
                                                    </div>
                                                    <div class="col">
                                                        <textarea class="form-control" rows="3" id="product_info" name="product_info"
                                                        placeholder="Enter ..."></textarea>
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
                                                <div class="input-group mt-4 row mb-3">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="note">Not :</label>
                                                    </div>
                                                    <div class="col">
                                                        <textarea class="form-control" rows="3" id="note" name="note"
                                                        placeholder="Enter ..."></textarea>
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

