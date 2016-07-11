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
namespace Limesharp\Stockists\Model\Stores;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Rss
{
    /**
     * @var string
     */
    const RSS_PAGE_URL                  = 'limesharp_stockists/author/rss';
    /**
     * @var string
     */
    const AUTHOR_RSS_ACTIVE_CONFIG_PATH = 'limesharp_stockists/author/rss';
    /**
     * @var string
     */
    const GLOBAL_RSS_ACTIVE_CONFIG_PATH = 'rss/config/active';
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param UrlInterface $urlBuilder
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        UrlInterface $urlBuilder,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * @return bool
     */
    public function isRssEnabled()
    {
        return
            $this->scopeConfig->getValue(self::GLOBAL_RSS_ACTIVE_CONFIG_PATH, ScopeInterface::SCOPE_STORE) &&
            $this->scopeConfig->getValue(self::AUTHOR_RSS_ACTIVE_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getRssLink()
    {
        return $this->urlBuilder->getUrl(
            self::RSS_PAGE_URL,
            ['store' => $this->storeManager->getStore()->getId()]
        );
    }
}
