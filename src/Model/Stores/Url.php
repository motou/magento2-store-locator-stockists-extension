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
namespace Limesharp\Stockists\Model\Stores;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use Limesharp\Stockists\Model\Stores;

class Url
{
    /**
     * @var string
     */
    const URL_CONFIG_PATH      = 'limesharp_stockists/stockist_content/url';

    /**
     * url builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    public $urlBuilder;

    /**
     * @var ScopeConfigInterface
     */
    public $scopeConfig;

    /**
     * @param UrlInterface $urlBuilder
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        UrlInterface $urlBuilder,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return string
     */
    public function getListUrl()
    {
        $sefUrl = $this->scopeConfig->getValue(self::URL_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
        if ($sefUrl) {
            return $this->urlBuilder->getUrl('', ['_direct' => $sefUrl]);
        }
        return $this->urlBuilder->getUrl('stockists/stores/index');
    }

    /**
     * @param Stores $stockist
     * @return string
     */
    public function getStockistUrl(Stores $stockist)
    {
        if ($urlKey = $stockist->getUrlKey()) {
            return $this->urlBuilder->getUrl('', ['_direct'=>$urlKey]);
        }
        return $this->urlBuilder->getUrl('stockists/stores/view', ['id' => $stockist->getId()]);
    }
}
