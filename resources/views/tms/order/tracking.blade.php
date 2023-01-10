@extends('main.main')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card-header">
            <div class="form-group">
                <input type="hidden" class="form-control" id="order_id" value="{{ $order->id }}">
            </div>
        </div>
        <div class="card card-primary">
            <div class="col-12 mt-4">
                <div class="container">
                    <h3>Sipariş Takibi</h3>
                    <table class="table">
                        <div id="map" style="width:100%;height:400px;"></div>
                    </table>
                </div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="col-12 mt-4">
                <div class="container">
                    <h3>Sipariş Hareketleri</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>DURUM</th>
                                <th>TARİH</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($status as $getStatus)
                            <tr>
                                <td>{{ \App\Models\tms\TMSOrder::OrderStatus[$getStatus->status] }}</td>
                                <td>{{ $getStatus->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="col-12 mt-4">
                <div class="container">
                    <h3>Sipariş Fotoğrafları</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>DURUM</th>
                                <th>FOTOĞRAF</th>
                            </tr>
                        </thead>
                        @foreach ($imageStatus as $key => $value)
                        <tbody>
                            <tr>
                                <td>{{ \App\Models\tms\TMSOrder::OrderStatus[$key] }}</td>
                                <td>
                                    <div id="carousel{{ $key }}" class="carousel slide" data-ride="carousel" style="height: 300px">
                                        <div class="carousel-inner" style="height: 300px">
                                            @for ($i = 0; $i < count($imageStatus[$key]['images']); $i++) @if ($i==0) <div class="carousel-item active">
                                                <img height="300" class="d-block w-100" src="{{ do_space_url($imageStatus[$key]['images'][$i]->image_path) }}">
                                        </div>
                                        @else
                                        <div class="carousel-item">
                                            <img height="300" class="d-block w-100" src="{{ do_space_url($imageStatus[$key]['images'][$i]->image_path) }}">
                                        </div>
                                        @endif
                                        @endfor
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-target="#carousel{{ $key }}" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-target="#carousel{{ $key }}" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </button>
                </div>
                </td>
                </tr>
                </tbody>
                @endforeach
                </table>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@section('js')
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="/js/tms/order/map.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDF1_S5s7p0NJ1ZL5H34c_diTZ0tVLSEUI&callback=initMap"></script>
<script type="text/javascript">
    function initMap() {
        const myLatLng = {
            lat: 22.2734719,
            lng: 70.7512559
        };
        var mapProp = {
            center: myLatLng,
            zoom: 8,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        let map = new google.maps.Map(document.getElementById("map"), mapProp);
        new google.maps.Marker({
            position: myLatLng,
            map,
        });

        let setLatLng;
        let locations;
        $(document).ready(function locationStatus() {
            let orderId = $('#order_id').val();
            $.ajax({
                type: 'POST',
                url: `/tms/order/location`,
                data: {
                    _token: '{{csrf_token()}}',
                    id: orderId
                },
                success: function(data) {
                    var positions = [];
                    $.each(data, function(index, value) {
                        setLatLng = new google.maps.LatLng(data.lat, data.lng);
                        locations = new Array(setLatLng);
                        positions.push({
                            lat: data.lat,
                            lng: data.lng,
                        });
                    });

                    $.each(locations, function(index, location) {
                        map.setCenter(location);
                        google.maps.event.addDomListener(window, 'load',
                            new google.maps.Marker({
                                position: location,
                                map,
                            }));
                    });
                },
                complete: function() {
                    setTimeout(locationStatus, 3000);
                }
            });
        });
    }
    initMap();
</script>
@endsection