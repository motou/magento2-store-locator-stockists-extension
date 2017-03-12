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
namespace Limesharp\Stockists\Controller\Adminhtml\Stores;

use Magento\Backend\Model\Session;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Result\PageFactory;
use Limesharp\Stockists\Api\StockistRepositoryInterface;
use Limesharp\Stockists\Api\Data\StockistInterface;
use Limesharp\Stockists\Api\Data\StockistInterfaceFactory;
use Limesharp\Stockists\Controller\Adminhtml\Stores;
use Limesharp\Stockists\Model\Uploader;
use Limesharp\Stockists\Model\UploaderPool;

class Save extends Stores
{
    /**
     * @var DataObjectProcessor
     */
    public $dataObjectProcessor;

    /**
     * @var DataObjectHelper
     */
    public $dataObjectHelper;

    /**
     * @var UploaderPool
     */
    public $uploaderPool;

    /**
     * @param Registry $registry
     * @param StockistRepositoryInterface $stockistRepository
     * @param PageFactory $resultPageFactory
     * @param Date $dateFilter
     * @param Context $context
     * @param StockistInterfaceFactory $stockistFactory
     * @param DataObjectProcessor $dataObjectProcessor
     * @param DataObjectHelper $dataObjectHelper
     * @param UploaderPool $uploaderPool
     */
    public function __construct(
        Registry $registry,
        StockistRepositoryInterface $stockistRepository,
        PageFactory $resultPageFactory,
        Date $dateFilter,
        Context $context,
        StockistInterfaceFactory $stockistFactory,
        DataObjectProcessor $dataObjectProcessor,
        DataObjectHelper $dataObjectHelper,
        UploaderPool $uploaderPool
    ) {
        $this->stockistFactory = $stockistFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->uploaderPool = $uploaderPool;
        parent::__construct($registry, $stockistRepository, $resultPageFactory, $dateFilter, $context);
    }

    /**
     * run the action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {

        /** @var \Limesharp\Stockists\Api\Data\StockistInterface $stockist */
        $stockist = null;
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['stockist_id']) ? $data['stockist_id'] : null;
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            if ($id) {
                $stockist = $this->stockistRepository->getById((int)$id);
            } else {
                unset($data['stockist_id']);
                $stockist = $this->stockistFactory->create();
            }
            $image = $this->getUploader('image')->uploadFileAndGetName('image', $data);
            $data['image'] = $image;
            
            if(isset($data['store_id'])) {
			    if(in_array('0',$data['store_id'])){
			        $data['store_id'] = '0';
			    }
			    else{
			        $data['store_id'] = implode(",", $data['store_id']);
			    }
			}
            
            $this->dataObjectHelper->populateWithArray($stockist, $data, StockistInterface::class);
            $this->stockistRepository->save($stockist);
            $this->messageManager->addSuccessMessage(__('You saved the store'));
            if ($this->getRequest()->getParam('back')) {
                $resultRedirect->setPath('stockists/stores/edit', ['stockist_id' => $stockist->getId()]);
            } else {
                $resultRedirect->setPath('stockists/stores');
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            if ($stockist != null) {
                $this->storeStockistDataToSession(
                    $this->dataObjectProcessor->buildOutputDataArray(
                        $stockist,
                        StockistInterface::class
                    )
                );
            }
            $resultRedirect->setPath('stockists/stores/edit', ['stockist_id' => $id]);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was a problem saving the store'));
            if ($stockist != null) {
                $this->storeStockistDataToSession(
                    $this->dataObjectProcessor->buildOutputDataArray(
                        $stockist,
                        StockistInterface::class
                    )
                );
            }
            $resultRedirect->setPath('stockists/stores/edit', ['store_id' => $id]);
        }
        return $resultRedirect;
    }

    /**
     * @param $type
     * @return Uploader
     * @throws \Exception
     */
    public function getUploader($type)
    {
        return $this->uploaderPool->getUploader($type);
    }

    /**
     * @param $stockistData
     */
    public function storeStockistDataToSession($stockistData)
    {
        $this->_getSession()->setLimesharpStockistsStoresData($stockistData);
    }
}
