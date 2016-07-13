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
namespace Limesharp\Stockists\Controller\Adminhtml\Stores;

use Limesharp\Stockists\Controller\Adminhtml\Stores;
use Limesharp\Stockists\Controller\RegistryConstants;

class Edit extends Stores
{
    /**
     * Initialize current author and set it in the registry.
     *
     * @return int
     */
    protected function _initAuthor()
    {
        $authorId = $this->getRequest()->getParam('stockist_id');
        $this->coreRegistry->register(RegistryConstants::CURRENT_STOCKIST_ID, $authorId);

        return $authorId;
    }

    /**
     * Edit or create author
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $authorId = $this->_initAuthor();

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Limesharp_Stockists::stores');
        $resultPage->getConfig()->getTitle()->prepend(__('Stockists'));
        $resultPage->addBreadcrumb(__('Stockists'), __('Stockists'), $this->getUrl('stockists/stores'));

        if ($authorId === null) {
            $resultPage->addBreadcrumb(__('New Store'), __('New Store'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Store'));
        } else {
            $resultPage->addBreadcrumb(__('Edit Store'), __('Edit Store'));
            $resultPage->getConfig()->getTitle()->prepend(
                $this->authorRepository->getById($authorId)->getName()
            );
        }
        return $resultPage;
    }
}
