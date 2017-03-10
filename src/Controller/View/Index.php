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

namespace Limesharp\Stockists\Controller\View;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Limesharp\Stockists\Model\ResourceModel\Stores\CollectionFactory as StockistsCollectionFactory;
use Limesharp\Stockists\Model\Stores;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Index
 * @package Limesharp\Stockists\Controller\View
 */
class Index extends Action
{
    /**
     * @var string
     */
    const META_DESCRIPTION_CONFIG_PATH = 'limesharp_stockists/stockist_content/meta_description';

    /**
     * @var string
     */
    const META_KEYWORDS_CONFIG_PATH = 'limesharp_stockists/stockist_content/meta_keywords';

    /**
     * @var string
     */
    const META_TITLE_CONFIG_PATH = 'limesharp_stockists/stockist_content/meta_title';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    public $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    public $storeManager;

    /** @var \Magento\Framework\View\Result\PageFactory  */
    public $resultPageFactory;

    /**
     * @var StockistsCollectionFactory
     */
    public $stockistsCollectionFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ScopeConfigInterface $scopeConfig,
        StockistsCollectionFactory $stockistsCollectionFactory,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->scopeConfig = $scopeConfig;
        $this->stockistsCollectionFactory = $stockistsCollectionFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * Load the page defined in view/frontend/layout/stockists_index_index.xml
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $url = $this->_url->getCurrentUrl();
        preg_match('/our-stores\/(.*)/',$url,$matches);

        $details = $this->getStoreDetails($matches[1]);
        $allStores = $this->getAllStockistStores();

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getLayout()->getBlock('stockists.stores.individual')->setDetails($details);
        $resultPage->getLayout()->getBlock('stockists.stores.individual')->setAllStores($allStores );

        $resultPage->getConfig()->getTitle()->set(
            $this->scopeConfig->getValue(self::META_TITLE_CONFIG_PATH, ScopeInterface::SCOPE_STORE)
        );
        $resultPage->getConfig()->setDescription(
            $this->scopeConfig->getValue(self::META_DESCRIPTION_CONFIG_PATH, ScopeInterface::SCOPE_STORE)
        );
        $resultPage->getConfig()->setKeywords(
            $this->scopeConfig->getValue(self::META_KEYWORDS_CONFIG_PATH, ScopeInterface::SCOPE_STORE)
        );

        return $resultPage;

    }

    /**
     * return data from the loaded store details. Only the first store is returned if there are multiple urls
     *
     * @return array
     */
    public function getStoreDetails($url)
    {
        $collection = $this->getIndividualStore($url);
        foreach($collection as $stockist){
            return $stockist->getData();
        }
    }

    /**
     * return data from the loaded store details. Only the first store is returned if there are multiple urls
     *
     * @return array
     */
    public function getAllStockistStores()
    {
        $collection = $this->getAllStoresCollection();
        $data = [];
        foreach($collection as $stockist){
            $data[] = $stockist->getData();
        }
        return $data;
    }

    /**
     * return stockists collection filtered by url
     *
     * @return CollectionFactory
     */
    public function getIndividualStore($url)
    {
        $collection = $this->stockistsCollectionFactory->create()
            ->addFieldToSelect('*')
            ->addFieldToFilter('status', Stores::STATUS_ENABLED)
            ->addFieldToFilter('link', $url)
            ->addStoreFilter($this->storeManager->getStore()->getId())
            ->setOrder('name', 'ASC');
        return $collection;
    }

    /**
     * return stockists collection 
     *
     * @return CollectionFactory
     */
    public function getAllStoresCollection()
    {
        $collection = $this->stockistsCollectionFactory->create()
            ->addFieldToSelect('*')
            ->addFieldToFilter('status', Stores::STATUS_ENABLED)
            ->addStoreFilter($this->storeManager->getStore()->getId())
            ->setOrder('name', 'ASC');
        return $collection;
    }

}
