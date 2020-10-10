var DS = {}, dsMap , marker, radiusCircle, subscriberArr = [];

(function(){	
	
	DS.initMap = function(divId){
		dsMap = new google.maps.Map(document.getElementById(divId), {
			zoom: 9,
			scrollwheel: true,
			center:  new google.maps.LatLng(25.152622, 55.226534),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			zoomControl: true,
			mapTypeControl: false,
			scaleControl: false,
			panControl: false,
			navigationControl: false,
			streetViewControl: false,
			gestureHandling: 'cooperative',
		});
		
		DS.addMarkerOnClick();
		
	};
	
	DS.getMapVar = function(){
		return dsMap;
	}
	
	DS.drawCircle = function(marker){
		
		if(radiusCircle){
			radiusCircle.setMap(null);
		}
		
		radiusCircle = new google.maps.Circle({
		  strokeColor: '#FF0000',
		  strokeOpacity: 1,
		  strokeWeight: 1,
		  fillColor: '#FF0000',
		  fillOpacity: 0.35,
		  map: dsMap,
		  center: marker.position,
		  radius: parseInt($('#radius').val())*1000
		});
		
	};
	
	
	DS.isMarkerInsideCircle = function(marker,circle){
		if (google.maps.geometry.spherical.computeDistanceBetween(marker.getPosition(), circle.getCenter()) <= circle.getRadius()) {
			return true
		} else {
			return false;
		}
	};
	
	DS.addMarkerOnClick = function(){
		
		marker  = new google.maps.Marker({
			position: new google.maps.LatLng(0,0), 
			draggable: true,
			animation: google.maps.Animation.DROP,
			map: dsMap
		});
		
		
		google.maps.event.addListener(dsMap, 'click', function(event) {
			
			var position;
			
			position = event.latLng;
			
			marker.setPosition(position);
			
			dsMap.panTo(position);
			
			DS.drawCircle(marker);
			
		});
		
		
		
		google.maps.event.addListener(marker, "dragend", function(event) {
			
			position = marker.getPosition();		
			
			dsMap.panTo(position);
			
			DS.drawCircle(marker);
			
		});
		
		
		$('#radius').on('keyup',function(e){
			if($(this).val() < 10 ){
				return;
			}
			
			DS.drawCircle(marker);
			
		});
		
		
		
		/* google.maps.event.addListener(marker, "dragend", function(event) { 
			console.log('asd')
			dsMap.panTo(position);
		}); */
	};
	
	
	
})();