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
use Limesharp\Stockists\Model\ResourceModel\Stores\Collection;
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
    const MAP_STYLES_CONFIG_PATH = 'limesharp_stockists/stockist_map/map_style';
            
    /**
     * @var string
     */
    const ASK_LOCATION_CONFIG_PATH = 'limesharp_stockists/stockist_map/ask_location';
    
    /**
     * @var string
     */
    const TEMPLATE_CONFIG_PATH = 'limesharp_stockists/stockist_map/template';
    
    /**
     * @var string
     */
    const UNIT_LENGTH_CONFIG_PATH = 'limesharp_stockists/stockist_map/unit_length';
        
    /**
     * @var int
     */
    const ZOOM_CONFIG_PATH = 'limesharp_stockists/stockist_map/zoom';
            
    /**
     * @var string
     */
    const RADIUS_CONFIG_PATH = 'limesharp_stockists/stockist_map/radius';
            
    /**
     * @var string
     */
    const STROKE_WEIGHT_CONFIG_PATH = 'limesharp_stockists/stockist_radius/circle_stroke_weight';
    
    /**
     * @var string
     */
    const STROKE_OPACITY_CONFIG_PATH = 'limesharp_stockists/stockist_radius/circle_stroke_opacity';
        
    /**
     * @var string
     */
    const STROKE_COLOR_CONFIG_PATH = 'limesharp_stockists/stockist_radius/circle_stroke_color';
            
    /**
     * @var string
     */
    const FILL_OPACITY_CONFIG_PATH = 'limesharp_stockists/stockist_radius/circle_fill_opacity';
            
    /**
     * @var string
     */
    const FILL_COLOR_CONFIG_PATH = 'limesharp_stockists/stockist_radius/circle_fill_color';
    
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
    
     /**
      * return stockists collection
      *
      * @return CollectionFactory
      */
    public function getStoresForFrontend(): Collection
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
    public function getCountries(): array
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
    public function getMapStyles(): string
    {
	    return $this->scopeConfig->getValue(self::MAP_STYLES_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * get location settings from configuration
     *
     * @return string
     */   
    public function getLocationSettings(): string
    {
	    return $this->scopeConfig->getValue(self::ASK_LOCATION_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
        
    /**
     * get template settings from configuration, i.e full width or page width
     *
     * @return string
     */   
    public function getTemplateSettings(): string
    {
	    return $this->scopeConfig->getValue(self::TEMPLATE_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
        
    /**
     * get unit of length settings from configuration
     *
     * @return string
     */   
    public function getUnitOfLengthSettings(): string
    {
	    return $this->scopeConfig->getValue(self::UNIT_LENGTH_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
            
    /**
     * get zoom settings from configuration
     *
     * @return int
     */   
    public function getZoomSettings(): int
    {
	    return (int)$this->scopeConfig->getValue(self::ZOOM_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
                
    /**
     * get radius settings from configuration
     *
     * @return string
     */   
    public function getRadiusSettings(): string
    {
	    return $this->scopeConfig->getValue(self::RADIUS_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
                
    /**
     * get stroke weight settings from configuration
     *
     * @return string
     */   
    public function getStrokeWeightSettings(): string
    {
	    return $this->scopeConfig->getValue(self::STROKE_WEIGHT_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
                
    /**
     * get stroke opacity settings from configuration
     *
     * @return string
     */   
    public function getStrokeOpacitySettings(): string
    {
	    return $this->scopeConfig->getValue(self::STROKE_OPACITY_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
                
    /**
     * get stroke color settings from configuration
     *
     * @return string
     */   
    public function getStrokeColorSettings(): string
    {
	    return $this->scopeConfig->getValue(self::STROKE_COLOR_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
                
    /**
     * get fill opacity settings from configuration
     *
     * @return string
     */   
    public function getFillOpacitySettings(): string
    {
	    return $this->scopeConfig->getValue(self::FILL_OPACITY_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
                
    /**
     * get fill color settings from configuration
     *
     * @return string
     */   
    public function getFillColorSettings(): string
    {
	    return $this->scopeConfig->getValue(self::FILL_COLOR_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    
     /**
     * get base image url
     *
     * @return string
     */ 
    public function getBaseImageUrl(): string
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
    
}