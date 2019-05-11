jQuery(document).ready(function($) {
	jQuery('.rem-leaflet-map-area').each(function(index, el) {
		var token = jQuery(this).attr('id');
		var mapsData = window['mapsData' + token];
		var tiles = L.tileLayer(mapsData.leaflet_styles.provider, {
				maxZoom: 21,
				attribution: mapsData.leaflet_styles.attribution
			}),
			latlng = L.latLng(mapsData.def_lat, mapsData.def_long);

		var map = L.map(token, { scrollWheelZoom: false, center: latlng, zoom: parseInt(mapsData.zoom_level), layers: [tiles]});

		var markers = L.markerClusterGroup();
		jQuery.each(mapsData.properties, function(index, property) {
	        var propertyIcon = L.icon({
	            iconUrl: property.icon_url,
	            iconSize: [43, 47],
	            iconAnchor: [18, 30],
	        });
			var marker = L.marker(new L.LatLng(property.lat, property.lon), { icon: propertyIcon, title: property.title });
			marker.bindPopup(property.property_box, {maxWidth : 320});
			markers.addLayer(marker);
			// console.log(property);
		});

		map.addLayer(markers);
	});

	jQuery('.toggle a').click(function(){
		setTimeout(function() {
			window.dispatchEvent(new Event('resize'));
		}, 100);
	});	
});