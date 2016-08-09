define([
    'jquery',
    'stockists_geolocation'
    ], 
    function($) {        

        return {
	        
            search : function(map, coords, latLng) {                        
                
                $(".stockists-results").empty();
                $(".stockists-results").append("<span class='results-word'>Closest stores:</span><br />");
				map.setCenter(latLng);
                map.setZoom(9);
				var marker = new google.maps.Marker({
                    record_id: "" + coords.latitude + coords.longitude,
                    position: latLng,
                    map:map
                });
                var circle = new google.maps.Circle({
                    map: map,
                    radius: 40233.6,    // 25 miles in metres
                    fillColor: '#AA0000'
                });
                circle.bindTo('center', marker, 'position');
                for (i = 0; i < markers.length; i++) { 
                    var distance = google.maps.geometry.spherical.computeDistanceBetween(marker.position, markers[i].position);
                    if (distance < 40233) {
                        var store_distance = parseFloat(distance*0.000621371192).toFixed(2);
                        var contentToAppend = "<div class='results-content' data-miles='"+store_distance+"' data-marker='"+markers[i].record_id+"'><p class='results-title'>"+markers[i].global_name+"</p>";
                        if (markers[i].global_address) {
                            contentToAppend += "<p class='results-address'>"+markers[i].global_address+"</p>";
                        }
                        if (markers[i].global_city) {
                            contentToAppend += "<p class='data-phone'>"+markers[i].global_city+" "+markers[i].global_postcode+"</p>";
                        }
                        contentToAppend += "<p class='data-miles'>"+store_distance+" miles</p></div>";
                        $(".stockists-results").append(contentToAppend);
                    }
                }
                var $wrapper = $('.stockists-results');
                
                //sort the result by distance
                $wrapper.find('.results-content').sort(function(a, b) {
                    return +a.dataset.miles - +b.dataset.miles;
                })
                .appendTo($wrapper);
                              
            }
        
        }

    }                
);
