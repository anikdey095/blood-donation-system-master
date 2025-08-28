<div id="map" style="height: 400px; width: 100%;"></div>

<!-- Latitude & Longitude fields -->
<input type="hidden" name="latitude" id="latitude">
<input type="hidden" name="longitude" id="longitude">

<script>
    let map, marker;

    function initMap() {
        // Default location (Dhaka)
        const defaultLocation = { lat: 23.8103, lng: 90.4125 };

        // Create map
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 12,
            center: defaultLocation
        });

        // Create marker
        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true
        });

        // Update lat/lng in form on marker drag
        google.maps.event.addListener(marker, 'dragend', function () {
            let position = marker.getPosition();
            document.getElementById("latitude").value = position.lat();
            document.getElementById("longitude").value = position.lng();
        });

        // Map click to move marker
        map.addListener("click", (event) => {
            marker.setPosition(event.latLng);
            document.getElementById("latitude").value = event.latLng.lat();
            document.getElementById("longitude").value = event.latLng.lng();
        });

        // Set initial lat/lng in hidden fields
        document.getElementById("latitude").value = defaultLocation.lat;
        document.getElementById("longitude").value = defaultLocation.lng;
    }
</script>

<!-- Load Google Maps API -->
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
</script>
