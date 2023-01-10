
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

                                    <div>
                                        <input type="hidden" id="current_city" value="{{$order->city_id}}">
                                        <input type="hidden" id="current_district" value="{{$order->district_id}}">
                                        <input type="hidden" id="current_owner_id" value="{{$order->owner_id}}">

                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="POST" action="">
                                        @csrf
                                        <div class="container">
                                            <div class="input-group mt-4 row">
                                                <div class="col-sm-2">
                                                    <label class="control-label">Tipi :</label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="type" name="type">
                                                        <option value="1"
                                                        @if(($order->type == 1)) selected @endif>
                                                            Bayi 
                                                        </option>
                                                        <option value="2"
                                                        @if(($order->type == 2)) selected @endif>
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
                                                                <option 
                                                                    value="{{ $order->owner_id }}"
                                                                    data-select2-id="{{ $order->owner_id }}">{{ $order->customer->company_name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="input-group mt-4 row">
                                                        <div class="col-sm-2">
                                                            <label class="control-label" for="weight">Ağırlık :</label>
                                                        </div>
                                                        <div class="col">
                                                            <input 
                                                                value="{{ $order->weight }}"
                                                                type="number" 
                                                                class="form-control" 
                                                                id="weight" 
                                                                name="weight"
                                                                placeholder="Ağırlık giriniz">
                                                        </div>
                                                    </div>
                                                    <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="phone">Telefon :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input 
                                                            value="{{ $order->phone }}"
                                                            type="text" 
                                                            class="form-control" 
                                                            id="phone" 
                                                            name="phone"
                                                            placeholder="Telefon numarası giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="city_id">Şehir :</label>
                                                    </div>
                                                    <div class="col">
                                                        <select class="form-control" id="city_id" name="city_id">
                                                            <option 
                                                                value="{{ $order->city->id }}"
                                                                data-select2-id="{{ $order->city->id }}">
                                                                {{ $order->city->name }}</option>
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
                                                                value="{{ $order->district->id }}"
                                                                data-select2-id="{{ $order->district->id }}">
                                                                {{ $order->district->name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row mb-3">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="product_info">Ürün Bilgisi:</label>
                                                    </div>
                                                    <div class="col">
                                                        <textarea 
                                                            class="form-control" 
                                                            rows="3" 
                                                            id="product_info" 
                                                            name="product_info"
                                                            placeholder="Enter ...">{{ $order->product_info }}</textarea>
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
                                                            placeholder="Enter ...">{{ $order->address_description }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row mb-3">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="note">Not :</label>
                                                    </div>
                                                    <div class="col">
                                                        <textarea 
                                                            class="form-control" 
                                                            rows="3" 
                                                            id="note" 
                                                            name="note"
                                                            placeholder="Enter ...">{{ $order->note }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row mb-3">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="address_description">Durumu :</label>
                                                    </div>
                                                        <div class="col">
                                                            <select class="form-control" name="status" id="status">
                                                                <option value="1"
                                                                    @if(($order->status== 1)) selected @endif>
                                                                        Sipariş Alındı
                                                                    </option>
                                                                    <option value="2"
                                                                    @if(($order->status== 2)) selected @endif>
                                                                        Taşımada 
                                                                    </option>
                                                                    <option value="3"
                                                                    @if(($order->type == 3)) selected @endif>
                                                                        Kurulumda
                                                                    </option>
                                                                    <option value="4"
                                                                    @if(($order->type == 4)) selected @endif>
                                                                        Kuruldu
                                                                    </option>
                                                                    <option value="5"
                                                                    @if(($order->type == 5)) selected @endif>
                                                                        Anket Bekleniyor
                                                                    </option>
                                                                    <option value="6"
                                                                    @if(($order->type == 6)) selected @endif>
                                                                        Hasarlı Ürün
                                                                    </option>
                                                                    <option value="7"
                                                                    @if(($order->type == 7)) selected @endif>
                                                                        Tamamlandı
                                                                    </option>
                                                                    <option value="8"
                                                                    @if(($order->type == 8)) selected @endif>
                                                                        İade Bekliyor 
                                                                    </option>
                                                            </select>
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
            url: "{{route('post.wms.order.cities')}}",
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
                url: "{{route('post.wms.order.districts')}}",
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

