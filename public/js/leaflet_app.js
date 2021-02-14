var count = $('#count').html()
let count_medecins = parseInt(count);
console.log(count_medecins)

var gps_lat = $('#gps_lat_0').html()

let j;

for (j = 0; j < count_medecins; j++) {

    var gps_lat = $('#gps_lat_' + j).html()
    var gps_lng = $('#gps_lng_' + j).html()

    var mymap = L.map('leaflet_carte_' + j).setView([gps_lat, gps_lng], 16);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        maxZoom: 19,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiY2VyZWFsa2lsbyIsImEiOiJja2h1cGtucDYyY2tuMnlrNjBpZXRlbjl0In0.IGaXPnIZ3FeDw5XnpTlNhQ'
    }).addTo(mymap);

    var marker = L.marker([gps_lat, gps_lng]).addTo(mymap);

}