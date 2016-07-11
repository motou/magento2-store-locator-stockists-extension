require([
        'jquery'
    ],
    function($){		

function search(){
									
		var address = $("#stockist-search-term").val();
		var geocoder;
		geocoder = new google.maps.Geocoder();	
		
		$(".stockists-results").empty();
		$(".stockists-results").append("<span class='results-word'>Results for <span class='italic'>" + address + ":</span></span><br />");		
		
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					if(results[0]["types"][0] == "country"){
						map.setZoom(5);
						map.setCenter(results[0].geometry.location);
						var marker = new google.maps.Marker({
							map: map,			
							position: results[0].geometry.location
						});
						for (i = 0; i < markers.length; i++) { 
							var code_country = getCountryCode(address);
							if(markers[i].global_country == code_country){
								$(".stockists-results").append("<div class='results-content' data-marker='"+markers[i].record_id+"'><p class='results-title'>"+markers[i].global_name+"</p><p class='results-address'>"+markers[i].global_address+"</p><p class='data-phone'>"+markers[i].global_city+" "+markers[i].global_zipcode+"</p><p class='data-miles'>"+parseFloat(distance*0.000621371192).toFixed(2)+" miles</p></div>");
							}
			            }
					}
					else{
						map.setZoom(9);
						map.setCenter(results[0].geometry.location);
						var marker = new google.maps.Marker({
							map: map,			
							position: results[0].geometry.location
						});
						var circle = new google.maps.Circle({
							map: map,
							radius: 40233.6,    // 25 miles in metres
							fillColor: '#AA0000'
						});
						circle.bindTo('center', marker, 'position');
						for (i = 0; i < markers.length; i++) { 
							var distance = google.maps.geometry.spherical.computeDistanceBetween(marker.position, markers[i].position);
							if(distance < 40233){
								var store_distance = parseFloat(distance*0.000621371192).toFixed(2);
								$(".stockists-results").append("<div class='results-content' data-miles='"+store_distance+"' data-marker='"+markers[i].record_id+"'><p class='results-title'>"+markers[i].global_name+"</p><p class='results-address'>"+markers[i].global_address+"</p><p class='data-phone'>"+markers[i].global_city+" "+markers[i].global_zipcode+"</p><p class='data-miles'>"+store_distance+" miles</p></div>");
							}
			            }
			            var $wrapper = $('.stockists-results');

						$wrapper.find('.results-content').sort(function(a, b) {
						    return +a.dataset.miles - +b.dataset.miles;
						})
						.appendTo($wrapper);
					}
				}
			}
			else {
				alert("No stores near your location.");
			}
		});
		
    }

	}				
);
