<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Limesharp\Stockists\Controller\Ajax;

/**
 * Responsible for loading page content.
 *
 * This is a basic controller that only loads the corresponding layout file. It may duplicate other such
 * controllers, and thus it is considered tech debt. This code duplication will be resolved in future releases.
 */
class Stores extends \Magento\Framework\App\Action\Action
{
	
	protected $resultJsonFactory;
	
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ){
        $this->resultJsonFactory = $resultJsonFactory;
		parent::__construct($context);
	}
	
    /**
     * Load the page defined in view/frontend/layout/samplenewpage_index_index.xml
     *
     * @return \Magento\Framework\Controller\Result\JsonFactory
     */
    public function execute()
    {
	    $json =  array("name"=> "Harrods",
"address"=> "87-135 Brompton Rd",
"city"=> "London",
"country"=> "United Kingdom",
"zipcode"=> "SW1X 7XL",
"region"=> "London",
"email"=> "customer.services@harrods.com",
"phone"=> "442077301234",
"store"=> "worldwide",
"status"=> "Enabled",
"link"=> "www.harrods.com",
"latitude"=> "51.499394",
"longitude"=> "-0.163245");
return  $this->resultJsonFactory->create()->setData($json);


    }
}
