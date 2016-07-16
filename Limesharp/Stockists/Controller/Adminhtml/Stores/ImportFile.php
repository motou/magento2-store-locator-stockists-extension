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
 * @author   Claudiu Creanga
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

class ImportFile extends Stores
{
    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var UploaderPool
     */
    protected $uploaderPool;

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
    )
    {
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
        $file = $this->getUploader('file')->uploadFileAndGetName('import', $data);        
        $id = !empty($data['stockist_id']) ? $data['stockist_id'] : null;
        $resultRedirect = $this->resultRedirectFactory->create();
        
        if($file){
            try {
	            if ($id) {
	                $stockist = $this->stockistRepository->getById((int)$id);
	            } else {
	                unset($data['stockist_id']);
	                $stockist = $this->stockistFactory->create();
	            }

	            $resume = $this->getUploader('file')->uploadFileAndGetName('resume', $data);
	            $data['resume'] = $resume;
	            $this->dataObjectHelper->populateWithArray($stockist, $data, StockistInterface::class);
	            $this->stockistRepository->save($stockist);
	            $this->messageManager->addSuccessMessage(__('Your file has been imported successfully'));
	            
                $resultRedirect->setPath('stockists/stores');
	            
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
	            $resultRedirect->setPath('stockists/stores/edit');
	        } catch (\Exception $e) {
	            $this->messageManager->addErrorMessage(__('There was a importing the file'));
	            if ($stockist != null) {
	                $this->storeStockistDataToSession(
	                    $this->dataObjectProcessor->buildOutputDataArray(
	                        $stockist,
	                        StockistInterface::class
	                    )
	                );
	            }
	            $resultRedirect->setPath('stockists/stores/import');
	        }
        } else {
			$this->messageManager->addError(__('Please upload a file'));
        }

        return $resultRedirect;
    }

    /**
     * @param $type
     * @return Uploader
     * @throws \Exception
     */
    protected function getUploader($type)
    {
        return $this->uploaderPool->getUploader($type);
    }

    /**
     * @param $stockistData
     */
    protected function storeStockistDataToSession($stockistData)
    {
        $this->_getSession()->setSampleNewsStockistData($stockistData);
    }
}
