require([
        'jquery',
        'gmaps_countries',
        'mapstyles',
        'search',
        'async!https://maps.googleapis.com/maps/api/js?key=AIzaSyBivSennK3jMSv4Zeict4gE7_qQ0LmRC8g&libraries=geometry'
    ],
    function($,country_list,mapstyles,search){    
		$(document).ready(function(){
	
		
		    getStores();
			

			$("#stockists-submit").on("click", function(e){
				
				search();
				
			});
				
			$('#stockist-search-term').keypress(function(e){
				
		        if(e.which == 13){//Enter key pressed
			        
					search();
		        }
		        
		    });
		    
		    $("body").on("click",".results-content", function(){
			    $(".results-content").not($(this)).removeClass("active");
			    $(this).addClass("active");
		    })	
			
			function getStores(){
				var url = window.location.href.replace(/\/+$/, "") + '/ajax/stores';
				$.ajax({
				    dataType: 'json',
				    url: url
				}).done(function(response){
					initialize(response);
				});	
			}
	
			var map;
			markers = [];
			
			function initialize(response) {
				
			    var mapElement = document.getElementById('map-canvas');
			    
				var mapOptions = {
					zoom: 13, 
					scrollwheel: false,
					center: {lat: 51.4935057, lng: -0.1506621},
					styles: mapstyles 
				};
				
				
				map = new google.maps.Map(mapElement,mapOptions);
				
				var image = {
				    url: '../images/map_pin.png'
				};
				console.log(image)
				
		  		var infowindow = new google.maps.InfoWindow({
				    content: ""
				});
				
		        function bindInfoWindow(marker, map, infowindow, name, address, city, zipcode, telephone, link, email) {
				    google.maps.event.addListener(marker, 'click', function() {
					    var protocol_link = link.indexOf("http") > -1 ? link : "http://"+link;
			    		var contentString = '<div class="stockists-window"><p class="stockists-title">'+name+
			    		'</p><p class="stockists-telephone"><a href="'+protocol_link+'" target="_blank">'+link+
			    		'</a></p><p class="stockists-telephone">'+telephone+
			    		'</p><p class="stockists-address"><a href="mailto:'+email+'" target="_blank">'+email+
			    		'</a></p><p class="stockists-telephone">'+address+
			    		'</p><p class="stockists-telephone">'+city+
			    		'</span></p><p class="stockists-web">'+zipcode+'</p></div>';
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
						global_zipcode: data.zipcode,
						global_country: data.country,
						position: latLng,
						map:map,
						icon: image,
						title: data.name
					});
					markers.push(marker);
	
			        bindInfoWindow(marker, map, infowindow, data.name, data.address, data.city, data.zipcode, data.phone, data.link, data.email);
			        			
		        }
		        
			
			}
	
			$("body").on("click", ".results-content", function(){
			    var id = $(this).attr('data-marker');
			    changeMarker(id);                             
			});
			
			function changeMarker(id){
				for (i = 0; i < markers.length; i++) { 
					if(markers[i].record_id == id){
		            	google.maps.event.trigger(markers[i], 'click');
					}
	            }
			}
			
			function getCountryCode(name){
				for(var i = 0, len=country_list.length; i < len; i++){
					if(country_list[i].name.toUpperCase() == name.toUpperCase()){
						return country_list[i].code
					}
				}
			}
			
			
		});
    }
);