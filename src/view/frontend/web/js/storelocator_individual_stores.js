define([
		'jquery',
		'stockists_individual_stores',
		'stockists_mapstyles',
		'stockists_slick'
	],
	function($,config,mapstyles) {

		return function (config) {

			$(document).ready(function() {

				$.getScript("https://maps.googleapis.com/maps/api/js?v=3&sensor=false&key="+config.apiKey, function () {
					initialize();
				});

				var map;
				config.storeDetails.latitude = parseFloat(config.storeDetails.latitude);
				config.storeDetails.longitude = parseFloat(config.storeDetails.longitude);

				function initialize() {

					var mapElement = document.getElementById('map-canvas-individual');
					var loadedMapStyles = mapstyles[config.map_styles];
					var mapOptions = {
						zoom: config.zoom_individual,
						scrollwheel: false,
						center: {lat: config.storeDetails.latitude, lng: config.storeDetails.longitude},
						styles: loadedMapStyles
					};

					map = new google.maps.Map(mapElement,mapOptions);

					var image = {
						url: config.map_pin
					};
					var infowindow = new google.maps.InfoWindow({
						content: ""
					});

					function bindInfoWindow(marker, map, infowindow, name, address, city, postcode, telephone, link, external_link, email) {
						google.maps.event.addListener(marker, 'click', function() {
							var contentString = '<div class="stockists-window" data-latitude="'+marker.getPosition().lat()+'" data-longitude="'+marker.getPosition().lng()+'"><p class="stockists-title">'+name+'</p>'
                            if (external_link) {
                                var protocol_link = external_link.indexOf("http") > -1 ? external_link : "http://"+external_link;
                                contentString += '<p class="stockists-telephone"><a href="'+protocol_link+'" target="_blank">'+external_link+'</a></p>'
                            } else if (link) {
                                contentString += '<p class="stockists-telephone"><a href="/'+config.moduleUrl+'/'+link+'" target="_blank">Detail page</a></p>'
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
							contentString += '<p class="ask-for-directions get-directions" data-directions="DRIVING"><a href="http://maps.google.com/maps?saddr=&daddr='+marker.getPosition().lat()+','+marker.getPosition().lng()+'" target="_blank">Get Directions</a></p>';
							contentString += '</div>';
							map.setCenter(marker.getPosition());
							infowindow.setContent(contentString);
							infowindow.open(map, marker);
						});
					}

					var latLng = new google.maps.LatLng(config.storeDetails.latitude,
						config.storeDetails.longitude);

					var record_id = "" + config.storeDetails.latitude + config.storeDetails.longitude;

					var marker = new google.maps.Marker({
						record_id: record_id,
						global_name: config.storeDetails.name,
						global_address: config.storeDetails.address,
						global_city: config.storeDetails.city,
						global_postcode: config.storeDetails.postcode,
						global_country: config.storeDetails.country,
						global_image: config.storeDetails.image,
						global_schedule: config.storeDetails.schedule,
						global_link: config.storeDetails.link,
						position: latLng,
						map:map,
						icon: image,
						title: config.storeDetails.name
					});

					bindInfoWindow(marker, map, infowindow, config.storeDetails.name, config.storeDetails.address, config.storeDetails.city, config.storeDetails.postcode, config.storeDetails.phone, config.storeDetails.link, config.storeDetails.external_link, config.storeDetails.email);

				}

				if (config.otherStores && config.otherStoresSlider) {
					// $('.all-stores-slider-wrapper').on(
					// 	'init',
					// 	function (event, slick) {
					// 		if ($(window).width() < 768) {
					// 			$(".all-stores-slider-wrapper").css("max-width", $(window).width() - 50 + "px");
					// 		}
					// 	}
					// );
					function initializeSlick() {
						$(".all-stores-slider-wrapper").slick({
							dots: true,
							arrows: true,
							lazyLoad: 'ondemand',
							slidesToShow: 5,
							slidesToScroll: 4,
							prevArrow: '<button id="arrow-left" type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button"><img src="' + config.slider_arrow + '" alt="Left" /></button>',
							nextArrow: '<button id="arrow-right" type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button"><img src="' + config.slider_arrow + '" alt="Right" /></button>',
							responsive: [
								{
									breakpoint: 1230,
									settings: {
										slidesToShow: 4,
										slidesToScroll: 1,
										infinite: true,
										dots: true
									}
								},
								{
									breakpoint: 1024,
									settings: {
										slidesToShow: 3,
										slidesToScroll: 1,
										infinite: true,
										dots: true,
										arrows: false
									}
								},
								{
									breakpoint: 768,
									settings: {
										slidesToShow: 2,
										slidesToScroll: 1,
										arrows: false,
										infinite: true,
										dots: true
									}
								},
								{
									breakpoint: 480,
									settings: {
										slidesToShow: 1,
										slidesToScroll: 1,
										arrows: false,
										infinite: true,
										dots: true
									}
								}
							]
						});
					}

					if ($(".all-stores-slider-wrapper").length) {
						initializeSlick();
					}
				}

			});
		};
	}
);
