<?php
declare(strict_types=1);
/**
 * Storelocator_Stockists extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category  Storelocator
 * @package   Storelocator_Stockists
 * @copyright 2016 Claudiu Creanga
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 * @author    Claudiu Creanga
 */
namespace Storelocator\Stockists\Controller\Adminhtml\Stores;

use \Storelocator\Stockists\Controller\Adminhtml\Stores as StockistController;

class Import extends StockistController
{
    /**
     * Stockists import.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Storelocator_Stockists::stores'); 
        $resultPage->getConfig()->getTitle()->prepend(__('Import'));
        $resultPage->addBreadcrumb(__('Import'), __('Import'), $this->getUrl('stockists/stores'));      
        
        return $resultPage;
    }
}

