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
 
namespace Limesharp\Stockists\Model;

use Magento\UrlRewrite\Model\ResourceModel\UrlRewriteFactory;
use Limesharp\Stockists\Model\Stores\Url as UrlModel;
use Magento\Framework\App\Action\Context;

class UrlRewrite
{
	
    /**
     * @var string
     */
    const URL_CONFIG_PATH = 'limesharp_stockists/stockist_content/url';
	
	/**
	* @var \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteFactory
	*/
	protected $urlRewriteFactory;
	
    /**
     * @var \Limesharp\Stockists\Model\Stores\Url
     */
    protected $urlModel;
	 
	/**
	* @param Context $context
	* @param \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteFactory $urlRewriteFactory
	*/
	public function __construct(
	    Context $context,
	    UrlRewriteFactory $urlRewriteFactory,
        UrlModel $urlModel
	) {
        parent::__construct($context);
	    $this->urlRewriteFactory = $urlRewriteFactory;
        $this->urlModel = $urlModel;
	}
	
    public function _afterSave()
    {
	    var_dump($this->getCustomUrlRewrite());die("da");
		if($this->getCustomUrlRewrite() != "stockists"){
			$urlRewriteModel = $this->urlRewriteFactory->create();
			/* set current store id */
			$urlRewriteModel->setStoreId(1);
			/* this url is not created by system so set as 0 */
			$urlRewriteModel->setIsSystem(0);
			/* unique identifier - set random unique value to id path */
			$urlRewriteModel->setIdPath(rand(1, 100000));
			/* set actual url path to target path field */
			$urlRewriteModel->setTargetPath("stockists");
			/* set requested path which you want to create */
			$urlRewriteModel->setRequestPath($this->getCustomUrlRewrite());
			/* set current store id */
			$urlRewriteModel->save();
		}
    }
    
    /**
     * get fill opacity settings from configuration
     *
     * @return string
     */   
    public function getCustomUrlRewrite(): string
    {
	    return $this->scopeConfig->getValue(self::URL_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    
}