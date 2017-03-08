define(['stockists_mapstyles'], function() {
	return {
		default: "",
		ultra_light_with_labels: [
			{
				"featureType": "water",
				"elementType": "geometry",
				"stylers": [{
					"color": "#e9e9e9"
				}, {
					"lightness": 17
				}]
			}, {
				"featureType": "landscape",
				"elementType": "geometry",
				"stylers": [{
					"color": "#f5f5f5"
				}, {
					"lightness": 20
				}]
			}, {
				"featureType": "road.highway",
				"elementType": "geometry.fill",
				"stylers": [{
					"color": "#ffffff"
				}, {
					"lightness": 17
				}]
			}, {
				"featureType": "road.highway",
				"elementType": "geometry.stroke",
				"stylers": [{
					"color": "#ffffff"
				}, {
					"lightness": 29
				}, {
					"weight": 0.2
				}]
			}, {
				"featureType": "road.arterial",
				"elementType": "geometry",
				"stylers": [{
					"color": "#ffffff"
				}, {
					"lightness": 18
				}]
			}, {
				"featureType": "road.local",
				"elementType": "geometry",
				"stylers": [{
					"color": "#ffffff"
				}, {
					"lightness": 16
				}]
			}, {
				"featureType": "poi",
				"elementType": "geometry",
				"stylers": [{
					"color": "#f5f5f5"
				}, {
					"lightness": 21
				}]
			}, {
				"featureType": "poi.park",
				"elementType": "geometry",
				"stylers": [{
					"color": "#dedede"
				}, {
					"lightness": 21
				}]
			}, {
				"elementType": "labels.text.stroke",
				"stylers": [{
					"visibility": "on"
				}, {
					"color": "#ffffff"
				}, {
					"lightness": 16
				}]
			}, {
				"elementType": "labels.text.fill",
				"stylers": [{
					"saturation": 36
				}, {
					"color": "#333333"
				}, {
					"lightness": 40
				}]
			}, {
				"elementType": "labels.icon",
				"stylers": [{
					"visibility": "off"
				}]
			}, {
				"featureType": "transit",
				"elementType": "geometry",
				"stylers": [{
					"color": "#f2f2f2"
				}, {
					"lightness": 19
				}]
			}, {
				"featureType": "administrative",
				"elementType": "geometry.fill",
				"stylers": [{
					"color": "#fefefe"
				}, {
					"lightness": 20
				}]
			}, {
				"featureType": "administrative",
				"elementType": "geometry.stroke",
				"stylers": [{
					"color": "#fefefe"
				}, {
					"lightness": 17
				}, {
					"weight": 1.2
				}]
			}
		],
		hopper: [
			{
				"featureType": "water",
				"elementType": "geometry",
				"stylers": [{
					"hue": "#165c64"
				}, {
					"saturation": 34
				}, {
					"lightness": -69
				}, {
					"visibility": "on"
				}]
			}, {
				"featureType": "landscape",
				"elementType": "geometry",
				"stylers": [{
					"hue": "#b7caaa"
				}, {
					"saturation": -14
				}, {
					"lightness": -18
				}, {
					"visibility": "on"
				}]
			}, {
				"featureType": "landscape.man_made",
				"elementType": "all",
				"stylers": [{
					"hue": "#cbdac1"
				}, {
					"saturation": -6
				}, {
					"lightness": -9
				}, {
					"visibility": "on"
				}]
			}, {
				"featureType": "road",
				"elementType": "geometry",
				"stylers": [{
					"hue": "#8d9b83"
				}, {
					"saturation": -89
				}, {
					"lightness": -12
				}, {
					"visibility": "on"
				}]
			}, {
				"featureType": "road.highway",
				"elementType": "geometry",
				"stylers": [{
					"hue": "#d4dad0"
				}, {
					"saturation": -88
				}, {
					"lightness": 54
				}, {
					"visibility": "simplified"
				}]
			}, {
				"featureType": "road.arterial",
				"elementType": "geometry",
				"stylers": [{
					"hue": "#bdc5b6"
				}, {
					"saturation": -89
				}, {
					"lightness": -3
				}, {
					"visibility": "simplified"
				}]
			}, {
				"featureType": "road.local",
				"elementType": "geometry",
				"stylers": [{
					"hue": "#bdc5b6"
				}, {
					"saturation": -89
				}, {
					"lightness": -26
				}, {
					"visibility": "on"
				}]
			}, {
				"featureType": "poi",
				"elementType": "geometry",
				"stylers": [{
					"hue": "#c17118"
				}, {
					"saturation": 61
				}, {
					"lightness": -45
				}, {
					"visibility": "on"
				}]
			}, {
				"featureType": "poi.park",
				"elementType": "all",
				"stylers": [{
					"hue": "#8ba975"
				}, {
					"saturation": -46
				}, {
					"lightness": -28
				}, {
					"visibility": "on"
				}]
			}, {
				"featureType": "transit",
				"elementType": "geometry",
				"stylers": [{
					"hue": "#a43218"
				}, {
					"saturation": 74
				}, {
					"lightness": -51
				}, {
					"visibility": "simplified"
				}]
			}, {
				"featureType": "administrative.province",
				"elementType": "all",
				"stylers": [{
					"hue": "#ffffff"
				}, {
					"saturation": 0
				}, {
					"lightness": 100
				}, {
					"visibility": "simplified"
				}]
			}, {
				"featureType": "administrative.neighborhood",
				"elementType": "all",
				"stylers": [{
					"hue": "#ffffff"
				}, {
					"saturation": 0
				}, {
					"lightness": 100
				}, {
					"visibility": "off"
				}]
			}, {
				"featureType": "administrative.locality",
				"elementType": "labels",
				"stylers": [{
					"hue": "#ffffff"
				}, {
					"saturation": 0
				}, {
					"lightness": 100
				}, {
					"visibility": "off"
				}]
			}, {
				"featureType": "administrative.land_parcel",
				"elementType": "all",
				"stylers": [{
					"hue": "#ffffff"
				}, {
					"saturation": 0
				}, {
					"lightness": 100
				}, {
					"visibility": "off"
				}]
			}, {
				"featureType": "administrative",
				"elementType": "all",
				"stylers": [{
					"hue": "#3a3935"
				}, {
					"saturation": 5
				}, {
					"lightness": -57
				}, {
					"visibility": "off"
				}]
			}, {
				"featureType": "poi.medical",
				"elementType": "geometry",
				"stylers": [{
					"hue": "#cba923"
				}, {
					"saturation": 50
				}, {
					"lightness": -46
				}, {
					"visibility": "on"
				}]
			}
		],
		light_dream: [
			{
				"featureType": "landscape",
				"stylers": [{
					"hue": "#FFBB00"
				}, {
					"saturation": 43.400000000000006
				}, {
					"lightness": 37.599999999999994
				}, {
					"gamma": 1
				}]
			}, {
				"featureType": "road.highway",
				"stylers": [{
					"hue": "#FFC200"
				}, {
					"saturation": -61.8
				}, {
					"lightness": 45.599999999999994
				}, {
					"gamma": 1
				}]
			}, {
				"featureType": "road.arterial",
				"stylers": [{
					"hue": "#FF0300"
				}, {
					"saturation": -100
				}, {
					"lightness": 51.19999999999999
				}, {
					"gamma": 1
				}]
			}, {
				"featureType": "road.local",
				"stylers": [{
					"hue": "#FF0300"
				}, {
					"saturation": -100
				}, {
					"lightness": 52
				}, {
					"gamma": 1
				}]
			}, {
				"featureType": "water",
				"stylers": [{
					"hue": "#0078FF"
				}, {
					"saturation": -13.200000000000003
				}, {
					"lightness": 2.4000000000000057
				}, {
					"gamma": 1
				}]
			}, {
				"featureType": "poi",
				"stylers": [{
					"hue": "#00FF6A"
				}, {
					"saturation": -1.0989010989011234
				}, {
					"lightness": 11.200000000000017
				}, {
					"gamma": 1
				}]
			}
		],
		blue_water: [
			{
				"featureType": "administrative",
				"elementType": "labels.text.fill",
				"stylers": [{
					"color": "#444444"
				}]
			}, {
				"featureType": "landscape",
				"elementType": "all",
				"stylers": [{
					"color": "#f2f2f2"
				}]
			}, {
				"featureType": "poi",
				"elementType": "all",
				"stylers": [{
					"visibility": "off"
				}]
			}, {
				"featureType": "road",
				"elementType": "all",
				"stylers": [{
					"saturation": -100
				}, {
					"lightness": 45
				}]
			}, {
				"featureType": "road.highway",
				"elementType": "all",
				"stylers": [{
					"visibility": "simplified"
				}]
			}, {
				"featureType": "road.arterial",
				"elementType": "labels.icon",
				"stylers": [{
					"visibility": "off"
				}]
			}, {
				"featureType": "transit",
				"elementType": "all",
				"stylers": [{
					"visibility": "off"
				}]
			}, {
				"featureType": "water",
				"elementType": "all",
				"stylers": [{
					"color": "#46bcec"
				}, {
					"visibility": "on"
				}]
			}
		],
		pale_down: [
			{
				"featureType": "administrative",
				"elementType": "all",
				"stylers": [{
					"visibility": "on"
				}, {
					"lightness": 33
				}]
			}, {
				"featureType": "landscape",
				"elementType": "all",
				"stylers": [{
					"color": "#f2e5d4"
				}]
			}, {
				"featureType": "poi.park",
				"elementType": "geometry",
				"stylers": [{
					"color": "#c5dac6"
				}]
			}, {
				"featureType": "poi.park",
				"elementType": "labels",
				"stylers": [{
					"visibility": "on"
				}, {
					"lightness": 20
				}]
			}, {
				"featureType": "road",
				"elementType": "all",
				"stylers": [{
					"lightness": 20
				}]
			}, {
				"featureType": "road.highway",
				"elementType": "geometry",
				"stylers": [{
					"color": "#c5c6c6"
				}]
			}, {
				"featureType": "road.arterial",
				"elementType": "geometry",
				"stylers": [{
					"color": "#e4d7c6"
				}]
			}, {
				"featureType": "road.local",
				"elementType": "geometry",
				"stylers": [{
					"color": "#fbfaf7"
				}]
			}, {
				"featureType": "water",
				"elementType": "all",
				"stylers": [{
					"visibility": "on"
				}, {
					"color": "#acbcc9"
				}]
			}
		],
		paper: [
			{
				"featureType": "administrative",
				"elementType": "all",
				"stylers": [{
					"visibility": "off"
				}]
			}, {
				"featureType": "landscape",
				"elementType": "all",
				"stylers": [{
					"visibility": "simplified"
				}, {
					"hue": "#0066ff"
				}, {
					"saturation": 74
				}, {
					"lightness": 100
				}]
			}, {
				"featureType": "poi",
				"elementType": "all",
				"stylers": [{
					"visibility": "simplified"
				}]
			}, {
				"featureType": "road",
				"elementType": "all",
				"stylers": [{
					"visibility": "simplified"
				}]
			}, {
				"featureType": "road.highway",
				"elementType": "all",
				"stylers": [{
					"visibility": "off"
				}, {
					"weight": 0.6
				}, {
					"saturation": -85
				}, {
					"lightness": 61
				}]
			}, {
				"featureType": "road.highway",
				"elementType": "geometry",
				"stylers": [{
					"visibility": "on"
				}]
			}, {
				"featureType": "road.arterial",
				"elementType": "all",
				"stylers": [{
					"visibility": "off"
				}]
			}, {
				"featureType": "road.local",
				"elementType": "all",
				"stylers": [{
					"visibility": "on"
				}]
			}, {
				"featureType": "transit",
				"elementType": "all",
				"stylers": [{
					"visibility": "simplified"
				}]
			}, {
				"featureType": "water",
				"elementType": "all",
				"stylers": [{
					"visibility": "simplified"
				}, {
					"color": "#5f94ff"
				}, {
					"lightness": 26
				}, {
					"gamma": 5.86
				}]
			}
		],
		light_monochrome: [
			{
				"featureType": "administrative.locality",
				"elementType": "all",
				"stylers": [{
					"hue": "#2c2e33"
				}, {
					"saturation": 7
				}, {
					"lightness": 19
				}, {
					"visibility": "on"
				}]
			}, {
				"featureType": "landscape",
				"elementType": "all",
				"stylers": [{
					"hue": "#ffffff"
				}, {
					"saturation": -100
				}, {
					"lightness": 100
				}, {
					"visibility": "simplified"
				}]
			}, {
				"featureType": "poi",
				"elementType": "all",
				"stylers": [{
					"hue": "#ffffff"
				}, {
					"saturation": -100
				}, {
					"lightness": 100
				}, {
					"visibility": "off"
				}]
			}, {
				"featureType": "road",
				"elementType": "geometry",
				"stylers": [{
					"hue": "#bbc0c4"
				}, {
					"saturation": -93
				}, {
					"lightness": 31
				}, {
					"visibility": "simplified"
				}]
			}, {
				"featureType": "road",
				"elementType": "labels",
				"stylers": [{
					"hue": "#bbc0c4"
				}, {
					"saturation": -93
				}, {
					"lightness": 31
				}, {
					"visibility": "on"
				}]
			}, {
				"featureType": "road.arterial",
				"elementType": "labels",
				"stylers": [{
					"hue": "#bbc0c4"
				}, {
					"saturation": -93
				}, {
					"lightness": -2
				}, {
					"visibility": "simplified"
				}]
			}, {
				"featureType": "road.local",
				"elementType": "geometry",
				"stylers": [{
					"hue": "#e9ebed"
				}, {
					"saturation": -90
				}, {
					"lightness": -8
				}, {
					"visibility": "simplified"
				}]
			}, {
				"featureType": "transit",
				"elementType": "all",
				"stylers": [{
					"hue": "#e9ebed"
				}, {
					"saturation": 10
				}, {
					"lightness": 69
				}, {
					"visibility": "on"
				}]
			}, {
				"featureType": "water",
				"elementType": "all",
				"stylers": [{
					"hue": "#e9ebed"
				}, {
					"saturation": -78
				}, {
					"lightness": 67
				}, {
					"visibility": "simplified"
				}]
			}
		],
	}

});