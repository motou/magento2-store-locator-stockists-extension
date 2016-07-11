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
 * @author    Claudiu Creanga
 */
namespace Limesharp\Stockists\Block\Stores\ListAuthor;

use Magento\Framework\App\Rss\DataProviderInterface;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Limesharp\Stockists\Model\Stores;
use Limesharp\Stockists\Model\Stores\Rss as RssModel;
use Limesharp\Stockists\Model\Stores\Url;
use Limesharp\Stockists\Model\ResourceModel\Stores\CollectionFactory;

class Rss extends AbstractBlock implements DataProviderInterface
{
    /**
     * @var string
     */
    const CACHE_LIFETIME_CONFIG_PATH = 'limesharp_stockists/author/rss_cache';

    /**
     * @var \Limesharp\Stockists\Model\Stores\Rss
     */
    protected $rssModel;

    /**
     * @var \Limesharp\Stockists\Model\Stores\Url
     */
    protected $urlModel;

    /**
     * @var \Limesharp\Stockists\Model\ResourceModel\Stores\CollectionFactory
     */
    protected $authorCollectionFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param Context $context
     * @param RssModel $rssModel
     * @param Url $urlModel
     * @param CollectionFactory $authorCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        RssModel $rssModel,
        Url $urlModel,
        CollectionFactory $authorCollectionFactory,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->rssModel = $rssModel;
        $this->urlModel = $urlModel;
        $this->authorCollectionFactory = $authorCollectionFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * @return int
     */
    protected function getStoreId()
    {
        $storeId = (int)$this->getRequest()->getParam('store_id');
        if ($storeId == null) {
            $storeId = $this->storeManager->getStore()->getId();
        }
        return $storeId;
    }

    /**
     * @return array
     */
    public function getRssData()
    {
        $url = $this->urlModel->getListUrl();
        $data = [
            'title' => __('Authors'),
            'description' => __('Authors'),
            'link' => $url,
            'charset' => 'UTF-8'
        ];
        $collection = $this->authorCollectionFactory->create();
        $collection->addStoreFilter($this->getStoreId());
        $collection->addFieldToFilter('is_active', Stores::STATUS_ENABLED);
        $collection->addFieldToFilter('in_rss', 1);
        foreach ($collection as $item) {
            /** @var \Limesharp\Stockists\Model\Stores $item */
            $description = '<table><tr><td><a href="%s">%s</a></td></tr></table>';
            $description = sprintf($description, $item->getAuthorUrl(), $item->getName());
            $data['entries'][] = [
                'title' => $item->getName(),
                'link' => $item->getAuthorUrl(),
                'description' => $description,
            ];
        }
        return $data;
    }

    /**
     * Check if RSS feed allowed
     *
     * @return mixed
     */
    public function isAllowed()
    {
        return $this->rssModel->isRssEnabled();
    }

    /**
     * Get information about all feeds this Data Provider is responsible for
     *
     * @return array
     */
    public function getFeeds()
    {
        $feeds = [];
        $feeds[] = [
            'label' => __('Authors'),
            'link' => $this->rssModel->getRssLink(),
        ];
        $result = ['group' => __('News'), 'feeds' => $feeds];
        return $result;
    }

    /**
     * @return bool
     */
    public function isAuthRequired()
    {
        return false;
    }

    /**
     * @return int
     */
    public function getCacheLifetime()
    {
        $lifetime = $this->_scopeConfig->getValue(
            self::CACHE_LIFETIME_CONFIG_PATH,
            ScopeInterface::SCOPE_STORE
        );
        return $lifetime ?: null;
    }
}
