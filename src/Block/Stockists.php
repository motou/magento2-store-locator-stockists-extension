<?php
declare(strict_types=1);
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
 * @author    Claudiu Creanga
 */
 
namespace Limesharp\Stockists\Block;

use Magento\Backend\Block\Template\Context;
use Limesharp\Stockists\Model\Stores;
use Limesharp\Stockists\Model\ResourceModel\Stores\CollectionFactory as StockistsCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Directory\Model\CountryFactory;
use Magento\Directory\Model\Config\Source\Country;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Stockists extends \Magento\Framework\View\Element\Template
{
        
    /**
     * @var string
     */
    const MAP_STYLES_CONFIG_PATH = 'limesharp_stockists/stockist/map_style';
            
    /**
     * @var string
     */
    const ASK_LOCATION_CONFIG_PATH = 'limesharp_stockists/stockist/ask_location';
    
    /**
     * @var StockistsCollectionFactory
     */
    public $stockistsCollectionFactory;
        
    /**
     * @var Country
     */
    public $countryHelper;
    
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    public $storeManager;
    
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    public $scopeConfig;
    
    public function __construct(
        StockistsCollectionFactory $stockistsCollectionFactory,
        StoreManagerInterface $storeManager,
        Country $countryHelper,
        Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->stockistsCollectionFactory = $stockistsCollectionFactory;
        $this->storeManager = $storeManager;
        $this->countryHelper = $countryHelper;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }
    
    public function getBaseImageUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
    
     /**
      * return stockists collection
      *
      * @return CollectionFactory
      */
    public function getStoresForFrontend()
    {
        $collection = $this->stockistsCollectionFactory->create()
            ->addFieldToSelect('*')
            ->addFieldToFilter('status', Stores::STATUS_ENABLED)
            ->addStoreFilter($this->_storeManager->getStore()->getId())
            ->setOrder('name', 'ASC');
        return $collection;
    }
    
    /**
     * get an array of country codes and country names: AF => Afganisthan
     *
     * @return array
     */
    public function getCountries()
    {

        $loadCountries = $this->countryHelper->toOptionArray();
        $countries = [];
        $i = 0;
        foreach ($loadCountries as $country ) {
            $i++;
            if ($i == 1) { //remove first element that is a select
                continue;
            }
            $countries[$country["value"]] = $country["label"];
        }
        return $countries;
    }
    
    /**
     * get map style from configuration
     *
     * @return string
     */   
    public function getMapStyles()
    {
	    return $this->scopeConfig->getValue(self::MAP_STYLES_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * get location settings from configuration
     *
     * @return string
     */   
    public function getLocationSettings()
    {
	    return $this->scopeConfig->getValue(self::ASK_LOCATION_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    
}