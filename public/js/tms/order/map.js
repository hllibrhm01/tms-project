function initMap() {
    const myLatLng = {
        lat: 22.2734719,
        lng: 70.7512559
    };
    var mapProp = {
        center: myLatLng,
        zoom: 8,
        // mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    let element = document.getElementById('map');
    // let map = new google.maps.Map(document.getElementById("map"), mapProp);
    let map = new google.maps.Map(element, mapProp);
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
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                // _token: '{{csrf_token()}}',
                "id": orderId
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
};

// initMap();