Looking for a maintainer to take control of this project and move it forward. There are new releases of magento2 and apparently some things stopped working, i.e. issue #29. As I no longer work with magento, I don't have time to debug the issue. Anyone interested, post your availability here: https://github.com/ClaudiuCreanga/magento2-store-locator-stockists-extension/issues/30

# Magento2 stockists store locator extension

This is a feature rich stockists store locator extension for magento2. 

**Table of Contents** 
- [Magento2 stockists store locator extension](#)
	- [Install](#install)
	- [Features](#features)
	- [Usage](#usage)
		- [Basic](#basic)
		- [Import](#import)
		- [Export](#export)
	- [Support](#support)
	- [Demo](#demo)
	- [Uninstall](#uninstall)

## Install

```
$ composer require limesharp/stockists
$ composer update
$ php bin/magento setup:upgrade 
$ php bin/magento setup:static-content:deploy
$ php bin/magento cache:clean
```

Or you can download the latest zip file from releases, drop it into your app folder, copy the contents of src folder into the main folder and then run the last 2 commands above.

Or you can also get it from the <a href="https://marketplace.magento.com/limesharp-stockists.html"> magento2 marketplace.</a> (there it is the old version 1.0.6 with less features)

It requires magento 2.1 or above and php7 (for php5.6 use v.1.0.6).

Visit the extension website: http://claudiucreanga.github.io/magento2-store-locator-stockists-extension/

<b>You need to use your own gmaps api key</b>. Go to https://developers.google.com/maps/documentation/javascript/get-api-key and get your own key and then insert it in configuration > stockists > Gmaps Api Key. Otherwise the map may not work because of Gmaps' daily limits.

## Features

* Details: name, address, city, country, postcode, internal link, external link, telephone, email, schedule, description, intro, nearest station, distance;
* Images: upload images of your stores. Two images can be uploaded, one for index page and one for individual store pages;
* Individual store pages on your website;
* Import: import your stores from a csv file;
* Export: export stores to a csv file;
* Interactive map: stores positioned on the map via longitude and latitude;
* Geolocation: show nearest stores to user (in chrome only via https);
* Search: search functionality in the sidebar;
* Directions: show directions from user location to store (driving, walking, cycling or public transport);
* Map Styles: choose from over 10 different map styles to fit your store;
* Breadcrumbs: show/hide breadcrumbs;
* SEO: edit titles, meta descriptions and keywords;
* Url: chose your url where your store locator appears;
* Radius: Select and style your radius in settings;
* Unit: Chose between miles and kilometres;
* Pin: Use custom map pin;
* Responsive: Mobile responsive templates;
* Templates: Choose from 3 different templates;
* Api key: Use your own Gmaps api key for higher traffic;

## Usage

### Basic

* The default url is /stockists. So once installed go to www.website.com/stockists (insert store code if necessary);
* Location in admin is inside content menu > stockists;
* Name, latitude and longitude are required values;
* Bear in mind that chrome and some other browsers allow geolocation services only via https;

### Import

* The csv file needs to be comma separated and values should be quoted;
* check the sample csv file in in <a href="https://github.com/ClaudiuCreanga/magento2-store-locator-stockists-extension/tree/master/docs">docs folder</a>;
* name, latitude and longitude are required;
* country field should be the 2 letter ISO code. Example: GB for United Kingdom and US for USA;
* image should be the path of the image which is built from the first to letters separated by slash and then the name of the image. Example: for image test.png the path is /t/e/test.png. The image should be placed in folder pub/media/limesharp_stockists/stockist/image/t/e/ (last 2 letters changed of course);
* if you want a stockist to be in multiple stores you can pass the ids of stores comma separated inside the store_id field;
* To make sure your csv file is formatted correctly, you can open it in a text editor. It should look like this (comma separated and quoted values):

![csv](docs/images/csv.jpg?raw=true "CSV")

### Export

* Just click export stores and a file will be saved by your browser on your computer;

## Support
* I **DO NOT** offer any free technical support in installing or customizing this extension.
* This extention works out of the box with any magento 2.1 site, but depending on your theme it may need further styling.
* If you need help please ask questions on http://magento.stackexchange.com/ .

## Demo

* Main dashboard:

![Main dashboard](docs/images/main.jpg?raw=true "Main dashboard")
* Location in admin:

![Locationd](docs/images/location.jpg?raw=true "Location")
* Settings:

![Settings](docs/images/settings1.jpg?raw=true "Settings")
![Settings](docs/images/settings2.jpg?raw=true "Settings")
![Settings](docs/images/settings3.jpg?raw=true "Settings")

* Frontend full page:

![Frontend](docs/images/front.jpg?raw=true "Frontend")

* Frontend store window:

![window](docs/images/window.jpg?raw=true "Window")

* Store Details:

![window](docs/images/store-details.png?raw=true "Window")

* Frontend search:

![search](docs/images/search.jpg?raw=true "search")

* Driving directions:

![Driving directions](docs/images/directions.jpg?raw=true "Driving directions")

## Uninstall

* If you installed it manually:

	- remove the folder app/code/Limesharp/Stockists;
	- drop the tables limesharp_stockists_stores (drop table limesharp_stockists_stores);
	- remove the config settings. DELETE FROM core_config_data WHERE path LIKE 'limesharp_stockists/%'
	- remove the module Limesharp_Stockists from app/etc/config.php
	- remove the module Limesharp_Stockists from table setup_module: DELETE FROM setup_module WHERE module='Limesharp_Stockists'

* If you installed it via composer:

	- run this in console: php bin/magento module:uninstall -r Limesharp_Stockists.
