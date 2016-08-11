define([
        'jquery',
        'limesharp_stockists',
        'stockists_countries',
        'stockists_mapstyles',
        'stockists_search',
        'stockists_geolocation',
        'async!https://maps.googleapis.com/maps/api/js?key=AIzaSyBivSennK3jMSv4Zeict4gE7_qQ0LmRC8g&libraries=geometry'
    ],
    function($,config,country_list,mapstyles,search_widget,getGeolocation) {
	    
		return function (config) {


	        $(document).ready(function() {
	
	            var map;
	            markers = [];
	
	            getStores();
	
	            $("#stockists-submit").on("click", function(e) {
	                
	                search_widget.search(map);
	                
	            });
	                
	            $('#stockist-search-term').keypress(function(e) {
	                
	                if (e.which == 13) {//Enter key pressed
	                    
	                    search_widget.search(map);
	                }
	                
	            });
	            
	            $("body").on("click",".results-content", function() {
	                $(".results-content").not($(this)).removeClass("active");
	                $(this).addClass("active");
	            })    
	            
	            function getStores() {
	                var url = window.location.href.replace(/\/+$/, "") + '/ajax/stores';
	                $.ajax({
	                    dataType: 'json',
	                    url: url
	                }).done(function(response) {
	                    initialize(response);
	                });    
	            }
	            
	            function initialize(response) {
	                
	                var mapElement = document.getElementById('map-canvas');	                
	                var loadedMapStyles = mapstyles[config.map_styles];
	                
	                var mapOptions = {
	                    zoom: 13, 
	                    scrollwheel: false,
	                    center: {lat: 51.4935057, lng: -0.1506621},
	                    styles: loadedMapStyles
	                };
	                
	                map = new google.maps.Map(mapElement,mapOptions);
	                
	                var image = {
	                    url: config.map_pin
	                };
	                var infowindow = new google.maps.InfoWindow({
	                    content: ""
	                });
	                
	                function bindInfoWindow(marker, map, infowindow, name, address, city, postcode, telephone, link, email) {
	                    google.maps.event.addListener(marker, 'click', function() {
	                        var contentString = '<div class="stockists-window"><p class="stockists-title">'+name+'</p>'
	                        if (link) {
	                            var protocol_link = link.indexOf("http") > -1 ? link : "http://"+link;
	                            contentString += '<p class="stockists-telephone"><a href="'+protocol_link+'" target="_blank">'+link+'</a></p>'
	                        }
	                        if (telephone) {
	                            contentString += '<p class="stockists-telephone">'+telephone+'</p>';
	                        }
	                        if (email) {
	                            contentString += '<p class="stockists-address"><a href="mailto:'+email+'" target="_blank">'+email+'</a></p>';
	                        }
	                        if (address) {
	                            contentString += '<p class="stockists-telephone">'+address+'</p>'
	                        }
	                        if (city) {
	                            contentString += '<p class="stockists-telephone">'+city+'</p>'
	                        }
	                        if (postcode) {
	                            contentString += '<p class="stockists-web">'+postcode+'</p>';
	                        }
	                        contentString += '<p class="ask-for-directions">Get Directions</p>';
	                        contentString += '</div>';
	                        map.setCenter(marker.getPosition());
	                        infowindow.setContent(contentString);
	                        infowindow.open(map, marker);
	                    });
	                }        
	                
	                var length = response.length
	                
	                for (var i = 0; i < length; i++) {
	                    
	                    var data = response[i];
	                    
	                    var latLng = new google.maps.LatLng(data.latitude,
	                        data.longitude);
	                        
	                    var record_id = "" + data.latitude + data.longitude;
	        
	                    var marker = new google.maps.Marker({
	                        record_id: record_id,
	                        global_name: data.name,
	                        global_address: data.address,
	                        global_city: data.city,
	                        global_postcode: data.postcode,
	                        global_country: data.country,
	                        position: latLng,
	                        map:map,
	                        icon: image,
	                        title: data.name
	                    });
	                    markers.push(marker);
	    
	                    bindInfoWindow(marker, map, infowindow, data.name, data.address, data.city, data.postcode, data.phone, data.link, data.email);
	                                
	                }
	                if(config.geolocation){
		                alert();
	                }
	                if(config.geolocation && navigator.geolocation){
									        					
						getGeoLocation();
							
		            } 
		            
					// attach click events for directions
					if(navigator.geolocation){
						$(document).on("click", ".ask-for-directions", function(map){
							$(".directions-panel").show();
							getDirections();
						})       
					}
	                
	            
	            }
	            
	            function getGeoLocation(){
	            	var geoOptions = function(){
						return {
							maximumAge: 5 * 60 * 1000,
					    	timeout: 10 * 1000
				    	}
					};
					
					var geoSuccess = function(position) {
											
						centerMap(position.coords, map, markers)
						
					};
					var geoError = function(position) {
						
						return;
												
					};
				
					navigator.geolocation.getCurrentPosition(geoSuccess, geoError, geoOptions);
	            }
	    
	            $("body").on("click", ".results-content", function() {
	                var id = $(this).attr('data-marker');
	                changeMarker(id);                             
	            });
	            
	            function changeMarker(id) {
	                for (i = 0; i < markers.length; i++) { 
	                    if (markers[i].record_id == id) {
	                        google.maps.event.trigger(markers[i], 'click');
	                    }
	                }
	            }
	            
	            //after the user has shared his geolocation, center map, insert marker and show stores
	            function centerMap(coords, map, markers){
		            
					var latLng = new google.maps.LatLng(coords.latitude,coords.longitude);

                    getGeolocation.search(map, coords, latLng);
					
				}  
				
				// on click location ask for geolocation and show stores
				if(navigator.geolocation){
					$(document).on("click", ".geocode-location", function(){
						getGeoLocation();
					})       
				}
				
				function getDirections(map){
					console.log(map);
					
			        var directionsService = new google.maps.DirectionsService();
					var directionsDisplay = new google.maps.DirectionsRenderer();
					
					directionsDisplay.setMap(map);
					directionsDisplay.setPanel($('.directions-panel')[0]);
					
					var request = {
						origin: 'London', 
						destination: 'Cambridge',
						travelMode: google.maps.DirectionsTravelMode.DRIVING
					};
					
					directionsService.route(request, function(response, status) {
						if (status == google.maps.DirectionsStatus.OK) {
							directionsDisplay.setDirections(response);
						}
					});
				}

				
	        });
	    };
    }
);