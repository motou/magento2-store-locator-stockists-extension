<?php
/**
 * Limesharp_Stockists extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category  Limesharp
 * @package   Limesharp_Stockists
 * @copyright 2016 Claudiu Creanga
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 * @author   Claudiu Creanga
 */
 
namespace Limesharp\Stockists\Block;

use Magento\Backend\Block\Template\Context;
use Limesharp\Stockists\Model\ResourceModel\Stores\CollectionFactory;

class Stores extends \Magento\Framework\View\Element\Template
{
	
    /**
     * @var CollectionFactory
     */
     
    protected $collectionFactory;
    
    public function __construct(
        CollectionFactory $collectionFactory,
		Context $context ,
		array $data = []
    )
    {
        $this->collectionFactory = $collectionFactory; 
        parent::__construct($context, $data);
    }
    
     /**
     * return stockists collection
     *
     * @return CollectionFactory
     */
    public function getStoresForFrontend()
    {
	    $collection = $this->collectionFactory->create()->getData();
	    return $collection;
    }
}