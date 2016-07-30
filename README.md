# Magento2 stockists store locator extension

This is a stockists store locator extension for magento2.

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

### Import

* The csv file needs to be comma separated and values should be quoted;
* check the sample csv file in documentation folder;
* name, latitude and longitude are required
* country field should be the 2 letter ISO code. Example: GB for United Kingdom and US for USA.
* image should be the path of the image which is built from the first to letters separated by slash and then the name of the image. Example: /s/c/screen_shot_2016-07-19_at_09.56.49_2.png. The image should be placed in folder pub/media/limesharp_stockists/stockist/image/s/c/ (last 2 letters changed of course).

## Support
* We **DO NOT** offer any free technical support in installing or customizing this extension.
* If you need support you can contact us but bear in mind that we may not consider quotes under £100.
* If you have any questions, the best place to ask them is http://magento.stackexchange.com/ .
