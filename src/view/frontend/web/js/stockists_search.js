define([
    'jquery',
    'stockists_countries',
    'stockists_search'
    ], 
    function($,country_list) {        

        return {
            geocoderObject : function() {
                return new google.maps.Geocoder();
            },
            address : function() {
                return $("#stockist-search-term").val()
            },
            getCountryCode : function() {
                name = this.address();
                for(var i = 0, len=country_list.length; i < len; i++) {
                    if (country_list[i].name.toUpperCase() == name.toUpperCase()) {
                        return country_list[i].code
                    }
                }
            },
            search : function(map,config) {                        

                var geocoder = this.geocoderObject();
                
                $(".stockists-results").empty();
                $(".stockists-results").append("<span class='results-word'>Results for <span class='italic'>" + this.address() + ":</span></span><br />");
                    
                var code_country = this.getCountryCode();    
                geocoder.geocode(
                    {'address': this.address()},
                    function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                                if (results[0]["types"][0] == "country") {
                                    map.setZoom(5);
                                    map.setCenter(results[0].geometry.location);
                                    var marker = new google.maps.Marker({
                                        map: map,            
                                        position: results[0].geometry.location
                                    });
                                    for (i = 0; i < markers.length; i++) { 
                                        if (markers[i].global_country == code_country) {
						                    if(config.unit == "default"){
						                        var store_distance = parseFloat(distance*0.001).toFixed(2);
						                        var unitOfLength = "kilometres";
						                    } else if(config.unit == "miles"){
						                        var store_distance = parseFloat(distance*0.000621371192).toFixed(2);
						                        var unitOfLength = "miles";
					                        }
                                            var contentToAppend = "<div class='results-content' data-miles='"+store_distance+"' data-marker='"+markers[i].record_id+"'><p class='results-title'>"+markers[i].global_name+"</p>";
                                            if (markers[i].global_address) {
                                                contentToAppend += "<p class='results-address'>"+markers[i].global_address+"</p>";
                                            }
                                            if (markers[i].global_city) {
                                                contentToAppend += "<p class='data-phone'>"+markers[i].global_city+" "+markers[i].global_postcode+"</p>";
                                            }
                                            contentToAppend += "</div>";
                                            $(".stockists-results").append(contentToAppend);
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
                                        radius: config.radius,    // value from admin settings
                                        fillColor: config.fillColor,
									    fillOpacity: config.fillOpacity, 
									    strokeColor: config.strokeColor,
									    strokeOpacity: config.strokeOpacity,
								        strokeWeight: config.strokeWeight
                                    });
                                    circle.bindTo('center', marker, 'position');
                                    for (i = 0; i < markers.length; i++) { 
                                        var distance = google.maps.geometry.spherical.computeDistanceBetween(marker.position, markers[i].position);
                                        if (distance < config.radius) {
						                    if(config.unit == "default"){
						                        var store_distance = parseFloat(distance*0.001).toFixed(2);
						                        var unitOfLength = "kilometres";
						                    } else if(config.unit == "miles"){
						                        var store_distance = parseFloat(distance*0.000621371192).toFixed(2);
						                        var unitOfLength = "miles";
					                        }
                                            var contentToAppend = "<div class='results-content' data-miles='"+store_distance+"' data-marker='"+markers[i].record_id+"'><p class='results-title'>"+markers[i].global_name+"</p>";
                                            if (markers[i].global_address) {
                                                contentToAppend += "<p class='results-address'>"+markers[i].global_address+"</p>";
                                            }
                                            if (markers[i].global_city) {
                                                contentToAppend += "<p class='data-phone'>"+markers[i].global_city+" "+markers[i].global_postcode+"</p>";
                                            }
                                            contentToAppend += "<p class='data-miles'>"+store_distance+" "+unitOfLength+"</p></div>";
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
                        else {
                            alert("No stores near your location.");
                        }
                    }
                );
            }
        
        }

    }                
);
