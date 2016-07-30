# Magento2 stockists store locator extension

This is a stockists store locator extension for magento2.

**Table of Contents** 

- [Magento2 stockists store locator extension](#)
	- [Install](#)
	- [Features](#)
	- [Usage](#)
		- [Basic](#)
		- [Import](#)
		- [Export](#)
	- [Support](#support)
	- [Demo](#)

## Install

```
$ composer require limesharp/stockists
$ composer update
$ php bin/magento setup:upgrade 
$ php bin/magento setup:static-content:deploy
```

Or you can download this zip file and drop it into your app folder and then run the last 2 commands above.

## Features

* Details: name, address, city, country, postcode, link, telephone, email
* Images: upload images of your stores
* Interactive map: stores positioned on the map via longitude and latitude
* Search: search functionality in the sidebar, radius of 25 miles
* Import: import your stores from a csv file
* Export: export stores to a csv file

## Usage

### Basic

* The default url is /stockists. So once installed go to www.website.com/stockists (insert store code if necessary);
* Location in admin is inside content menu > stockists;
* Name, latitude and longitude are required values;

### Import

* The csv file needs to be comma separated and values should be quoted;
* check the sample csv file in documentation folder;
* name, latitude and longitude are required;
* country field should be the 2 letter ISO code. Example: GB for United Kingdom and US for USA;
* image should be the path of the image which is built from the first to letters separated by slash and then the name of the image. Example: for image test.png the path is /t/e/test.png. The image should be placed in folder pub/media/limesharp_stockists/stockist/image/t/e/ (last 2 letters changed of course);
* To make sure your csv file is formatted correctly, you can open it in a text editor. It should look like this (comma separated and quoted values):

![csv](documentation/images/csv.jpg?raw=true "CSV")

### Export

* Just click export stores and a file will be saved by your browser on your computer;

## Support
* We **DO NOT** offer any free technical support in installing or customizing this extension.
* If you need support you can contact us but bear in mind that we may not consider quotes under £100.
* If you have any questions, the best place to ask them is http://magento.stackexchange.com/ .

## Demo

* Main dashboard:

![Main dashboard](documentation/images/main.jpg?raw=true "Main dashboard")
* Location in admin:

![Locationd](documentation/images/location.jpg?raw=true "Location")
* Settings:

![Settings](documentation/images/settings.jpg?raw=true "Settings")

* Frontend full page:

![Frontend](documentation/images/front.jpg?raw=true "Frontend")

* Frontend store window:

![window](documentation/images/window.jpg?raw=true "Window")

* Frontend search:

![search](documentation/images/search.jpg?raw=true "search")

