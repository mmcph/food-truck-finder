<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="./css/map-view-style.css">
	</head>
	<body>
		<!--The div element for the map -->

		<div id="map"></div>
		<script>
			// Initialize and add the map
			function initMap() {
				// The location of Albuquerque
				var abq = {lat: 35.10513700, lng: -106.62930400};
				// The map, centered at Albuquerque
				var map = new google.maps.Map(
					document.getElementById('map'), {zoom: 12, center: abq});
				// The marker, positioned at Albuquerque
				// var marker = new google.maps.Marker({position: abq, map: map});
			}
		</script>
		<!--Load the API from the specified URL
		* The async attribute allows the browser to render the page while the API loads
		* The key parameter will contain your own API key (which is not needed for this tutorial)
		* The callback parameter executes the initMap() function
		-->
		<script async defer
				  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5SJBjV23l2lsVA4XShTo2la48KAtXdFg&callback=initMap">
		</script>
	</body>
</html>