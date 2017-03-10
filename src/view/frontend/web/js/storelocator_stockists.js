define([
        'jquery',
        'storelocator_stockists',
        'stockists_countries',
        'stockists_mapstyles',
        'stockists_search',
        'stockists_geolocation'
    ],
    function($,config,country_list,mapstyles,search_widget,currentLocation) {
	    
		return function (config) {

	        $(document).ready(function() {

				$.getScript("https://maps.googleapis.com/maps/api/js?v=3&sensor=false&key="+config.apiKey+"&libraries=geometry", function () {
					getStores();
				});

				var map;
	            markers = [];

				// on search show the relevant stores
	            $("#stockists-submit").on("click", function(e) {
	                
	                search_widget.search(map,config);
	                
	            });
	                
	            $('#stockist-search-term').keypress(function(e) {
	                
	                if (e.which == 13) {//Enter key pressed
	                    
	                    search_widget.search(map,config);
	                }
	                
	            });
	            
	            $("body").on("click",".results-content", function() {
	                $(".results-content").not($(this)).removeClass("active");
	                $(this).addClass("active");
	            });
	            
				// full width template
				if(config.template == "full_width_sidebar" || config.template == "full_width_top"){
					$("body").addClass("full-width");
				}
	            
	            // get the stores from admin stockists/ajax/stores
	            function getStores() {
	                var url = window.location.protocol+"//"+window.location.host + config.moduleUrl + '/ajax/stores';
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
	                    zoom: config.zoom, 
	                    scrollwheel: false,
	                    center: {lat: config.latitude, lng: config.longitude},
	                    styles: loadedMapStyles
	                };
	                
	                map = new google.maps.Map(mapElement,mapOptions);
					var directionsService = new google.maps.DirectionsService();
					var directionsDisplay = new google.maps.DirectionsRenderer();
					directionsDisplay.setMap(map);
	                
	                var image = {
	                    url: config.map_pin
	                };
	                var infowindow = new google.maps.InfoWindow({
	                    content: ""
	                });
	                
	                function bindInfoWindow(marker, map, infowindow, name, address, city, postcode, telephone, link, email) {
	                    google.maps.event.addListener(marker, 'click', function() {
	                        var contentString = '<div class="stockists-window" data-latitude="'+marker.getPosition().lat()+'" data-longitude="'+marker.getPosition().lng()+'"><p class="stockists-title">'+name+'</p>'
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
	                        contentString += '<p class="ask-for-directions get-directions" data-directions="DRIVING">Get Directions</p>';
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
	                
	                if(config.geolocation && navigator.geolocation){
									        					
						getGeoLocation(map);
							
		            } 
		            				
					// on click location ask for geolocation and show stores
					if(navigator.geolocation){
						$(document).on("click", ".geocode-location", function(){
							getGeoLocation(map);
						})       
					}
		            
					// attach click events for directions
					if(navigator.geolocation){
						$(document).on("click", ".get-directions", function(){
							var storeDirections = {
								latitude : $(".stockists-window").attr("data-latitude"),
								longitude : $(".stockists-window").attr("data-longitude")
							}
							var userTravelMode = $(this).attr("data-directions");
						
							getGeoLocation(map, storeDirections, userTravelMode, directionsService, directionsDisplay);
							
						})       
					}
	                
	            
	            }
	            
	            //gets geolocation, if storeDirections is set then it is interpreted as a way to getDirection
	            function getGeoLocation(map, storeDirections, userTravelMode, directionsService, directionsDisplay){
	            	var geoOptions = function(){
						return {
							maximumAge: 5 * 60 * 1000,
					    	timeout: 10 * 1000
				    	}
					};
					
					var geoSuccess = function(position) {
						
						// if no params then just center it, otherwise call directions
						if (typeof storeDirections === 'undefined'){ 

							centerMap(position.coords, map, markers);
						
						} else {
						
							getDirections(map, storeDirections, position.coords, userTravelMode, directionsService, directionsDisplay);

						}
												
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

                    currentLocation.search(map, coords, latLng, config);
					
				}  
				
				//get driving directions from user location to store
				function getDirections(map, storeDirections, userLocation, userTravelMode, directionsService, directionsDisplay){
											
					if(typeof userTravelMode === 'undefined'){
						var directionsTravelMode = "DRIVING";
					} else {
						var directionsTravelMode = userTravelMode;
						
					}

					var request = {
						destination: new google.maps.LatLng(storeDirections.latitude,storeDirections.longitude), 
						origin: new google.maps.LatLng(userLocation.latitude,userLocation.longitude), 
						travelMode: google.maps.TravelMode[directionsTravelMode]
					};
					
					directionsService.route(request, function(response, status) {
						if (status == google.maps.DirectionsStatus.OK) {
							directionsDisplay.setDirections(response);
							directionsDisplay.setPanel($('.directions-panel')[0]);
						}
					});
					
					$(".directions-panel").show();
					
					//on close reset map and panel and center map to user location
					$("body").on("click", ".directions-panel .close", function() {
			            $(".directions-panel").hide();
						directionsDisplay.setPanel(null);
						directionsDisplay.setMap(null);
						centerMap(userLocation, map, markers);
		            });
				}

				
	        });
	    };
    }
);
