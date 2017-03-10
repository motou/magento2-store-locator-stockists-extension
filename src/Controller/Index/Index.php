<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Limesharp\Stockists\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

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
     * @var string
     */
    const BREADCRUMBS_CONFIG_PATH = 'limesharp_stockists/stockist_content/breadcrumbs';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    public $scopeConfig;
    
    /** @var \Magento\Framework\View\Result\PageFactory  */
    public $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->scopeConfig = $scopeConfig;
    }
    
    /**
     * Load the page defined in view/frontend/layout/stockists_index_index.xml
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(
            $this->scopeConfig->getValue(self::META_TITLE_CONFIG_PATH, ScopeInterface::SCOPE_STORE)
        );
        $resultPage->getConfig()->setDescription(
            $this->scopeConfig->getValue(self::META_DESCRIPTION_CONFIG_PATH, ScopeInterface::SCOPE_STORE)
        );
        $resultPage->getConfig()->setKeywords(
            $this->scopeConfig->getValue(self::META_KEYWORDS_CONFIG_PATH, ScopeInterface::SCOPE_STORE)
        );
        if ($this->scopeConfig->isSetFlag(self::BREADCRUMBS_CONFIG_PATH, ScopeInterface::SCOPE_STORE)) {
            
            /** @var \Magento\Theme\Block\Html\Breadcrumbs $breadcrumbsBlock */
            $breadcrumbsBlock = $resultPage->getLayout()->getBlock('breadcrumbs');
            if ($breadcrumbsBlock) {
                $breadcrumbsBlock->addCrumb(
                    'home',
                    [
                        'label'    => __('Home'),
                        'link'     => $this->_url->getUrl('')
                    ]
                );
                $breadcrumbsBlock->addCrumb(
                    'stockists',
                    [
                        'label'    => __('Stockists'),
                    ]
                );
            }
        }
        
        return $resultPage;

    }

}
