<!DOCTYPE html>
<html lang="en">
<head>
	<base target="_top">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>Quick Start - Leaflet</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

	<style>
		html, body {
			height: 100%;
			margin: 0;
		}
		.leaflet-container {
			height: 400px;
			width: 600px;
			max-width: 100%;
			max-height: 100%;
		}
	</style>

	
</head>
<body>



<div id="map" style="width: 600px; height: 400px;"></div>

<script src="https://leafletjs.com/examples/geojson/sample-geojson.js" type="text/javascript"></script>

<script>
	const map = L.map('map').setView([39.74739, -105], 13);

	const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(map);

	const baseballIcon = L.icon({
		iconUrl: 'baseball-marker.png',
		iconSize: [32, 37],
		iconAnchor: [16, 37],
		popupAnchor: [0, -28]
	});

	function onEachFeature(feature, layer) {
		let popupContent = `<p>I started out as a GeoJSON ${feature.geometry.type}, but now I'm a Leaflet vector!</p>`;

		if (feature.properties && feature.properties.popupContent) {
			popupContent += feature.properties.popupContent;
		}

		layer.bindPopup(popupContent);
	}

	/* global campus, bicycleRental, freeBus, coorsField */
	const bicycleRentalLayer = L.geoJSON([bicycleRental, campus], {

		style(feature) {
			return feature.properties && feature.properties.style;
		},

		onEachFeature,

		pointToLayer(feature, latlng) {
			return L.circleMarker(latlng, {
				radius: 8,
				fillColor: '#ff7800',
				color: '#000',
				weight: 1,
				opacity: 1,
				fillOpacity: 0.8
			});
		}
	}).addTo(map);

	const freeBusLayer = L.geoJSON(freeBus, {

		filter(feature, layer) {
			if (feature.properties) {
				// If the property "underConstruction" exists and is true, return false (don't render features under construction)
				return feature.properties.underConstruction !== undefined ? !feature.properties.underConstruction : true;
			}
			return false;
		},

		onEachFeature
	}).addTo(map);

	const coorsLayer = L.geoJSON(coorsField, {

		pointToLayer(feature, latlng) {
			return L.marker(latlng, {icon: baseballIcon});
		},

		onEachFeature
	}).addTo(map);

	$.getJSON ("peta/11.geojson", function(json){
        geoLayer = L.geoJson(json, {
            style: function(feature){
                return {
                    opacity: 0.5,
                    color: 'read',
                    fillColor: 'grey'
                };
            },
			onEachFeature: function(feature, layer){
				layer.addTo(map);
			}
    	});

	})

	</script>


</body>
</html>
