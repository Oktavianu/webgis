<!DOCTYPE html>
<html lang="en">
<head>
	<base target="_top">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>Layers Control Tutorial - Leaflet</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />
	<link rel="stylesheet" href="{{ asset('search/src/leaflet-search.css')}}" />


    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

	<!-- dari download jquery -->
	<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

	<!-- Leaflet.TextPath -->
	<script src="{{ asset('leaflet/js/leaflet.textpath.js ')}}"></script>

	<style>
		html, body {
			height: 100%;
			margin: 0;
		}
		.leaflet-container {
			height: 1000px;
			width: 1400px;
			max-width: 100%;
			max-height: 100%;
		}
	</style>

<script src="{{ asset('search/src/leaflet-search.js')}}"></script>



	
</head>
<body>

<div id='map'></div>
<script src="https://leafletjs.com/examples/geojson/sample-geojson.js" type="text/javascript"></script>

<script>
var data = [
		{"loc":[0.119275, 110.596268], "title":"sanggau"},
		{"loc":[0.821144, 109.477699], "title":"bengkayang"},
		{"loc":[-0.115488, 110.290282], "title":"meliau"},
		{"loc":[-0.031174, 110.120284], "title":"Tayan"},
	];

//sample data values for populate map
	const cities = L.layerGroup();

	const mLittleton = L.marker([-0.037799, 109.459676]).bindPopup('Nama : Projek beni <br> Harga : total 20 juta <br> Ket : harus jadi ni <br>').addTo(cities);
	const mDenver = L.marker([-6.214687250230856, 106.84256319745691]).bindPopup('Nama : Projek beni <br> Harga : total 20 juta <br> Ket : harus jadi ni <br>').addTo(cities);
	const mAurora = L.marker([3.594508, 98.672093]).bindPopup('Nama : Projek beni <br> Harga : total 20 juta <br> Ket : harus jadi ni <br>').addTo(cities);
	const mGolden = L.marker([1.362755, 109.300327]).bindPopup('Nama : Projek beni <br> Harga : total 20 juta <br> Ket : harus jadi ni <br>').addTo(cities);

	const mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>';
	const mbUrl = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
 
	const streets = L.tileLayer(mbUrl, {id: 'mapbox/streets-v11', tileSize: 512, zoomOffset: -1, attribution: mbAttr});

	const osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	});

	const map = L.map('map', {
		center: [-2.014066, 114.654494],
		zoom: 5,
		layers: [osm, cities]
	});

	const baseLayers = {
		'OpenStreetMap': osm,
		'Streets': streets
		
	};

	const overlays = {
		'Cities': cities
	};

	const layerControl = L.control.layers(baseLayers, overlays).addTo(map);
	const crownHill = L.marker([39.75, -105.09]).bindPopup('This is Crown Hill Park.');
	const rubyHill = L.marker([39.68, -105.00]).bindPopup('This is Ruby Hill Park.');

	const parks = L.layerGroup([crownHill, rubyHill]);

	const satellite = L.tileLayer(mbUrl, {id: 'mapbox/satellite-v9', tileSize: 512, zoomOffset: -1, attribution: mbAttr});
	layerControl.addBaseLayer(satellite, 'Satellite');
	layerControl.addOverlay(parks, 'Parks');

	map.addLayer(new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'));	//base layer
	var markersLayer = new L.LayerGroup();	//layer contain searched elements
	
	map.addLayer(markersLayer);

	var controlSearch = new L.Control.Search({
		position:'topleft',		
		layer: markersLayer,
		initial: false,
		zoom: 5,
		marker: false
	});
	map.addControl(controlSearch);

	////////////populate map with markers from sample data
	for(i in data) {
		var title = data[i].title,	//value searched
			loc = data[i].loc,		//position found
			marker = new L.Marker(new L.latLng(loc), {title: title} );//se property searched
		marker.bindPopup('title: '+ title );
		markersLayer.addLayer(marker);
	}

		$.getJSON('peta/11.geojson', function(json) {
          geoLayer = L.geoJson(json, {
            style: function(feature) {
              return {
                          fillOpacity : 0,
                          weight : 5,
                          color  : "red",
                          dashArray: "30 10",
                          lineCap : "square"
                      };
            },

            onEachFeature: function(feature, layer) {
            
               layer.on('click',(e)=>{
                       var html= '<div><h5> Nama Lokasi : '+feature.properties.fid+'</h5>';
                           html+= '<h5> Negara : '+feature.properties.NAME_0+'</h5>';
						   html+= '<h5> Provinsi : '+feature.properties.NAME_1+'</h5>';
						   html+= '<h5> Kode : '+feature.properties.KODE+'</h5>';
                       L.popup()
                       .setLatLng(layer.getBounds().getCenter())
                       .setContent(html)
                       .openOn(map);
               })

              layer.addTo(map);

            }

          });
          
        })

		$.getJSON('peta/12.geojson', function(json) {
          geoLayer = L.geoJson(json, {
            style: function(feature) {
              return {
                          fillOpacity : 0,
                          weight : 5,
                          color  : "red",
                          dashArray: "30 10",
                          lineCap : "square"
                      };
            },

            onEachFeature: function(feature, layer) {
            
               layer.on('click',(e)=>{
                       var html= '<div><h5> Nama Lokasi : '+feature.properties.fid+'</h5>';
                           html+= '<h5> Negara : '+feature.properties.NAME_0+'</h5>';
						   html+= '<h5> Provinsi : '+feature.properties.NAME_1+'</h5>';
						   html+= '<h5> Kode : '+feature.properties.KODE+'</h5>';
                       L.popup()
                       .setLatLng(layer.getBounds().getCenter())
                       .setContent(html)
                       .openOn(map);
               })

              layer.addTo(map);

            }

          });
          
        })

</script>


</body>
</html>
