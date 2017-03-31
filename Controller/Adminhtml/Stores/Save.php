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

use Magento\Backend\Model\Session;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Result\PageFactory;
use Storelocator\Stockists\Api\StockistRepositoryInterface;
use Storelocator\Stockists\Api\Data\StockistInterface;
use Storelocator\Stockists\Api\Data\StockistInterfaceFactory;
use Storelocator\Stockists\Controller\Adminhtml\Stores;
use Storelocator\Stockists\Model\Uploader;
use Storelocator\Stockists\Model\UploaderPool;
use Magento\UrlRewrite\Model\UrlRewrite as BaseUrlRewrite;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite as UrlRewriteService;
use Magento\UrlRewrite\Model\UrlFinderInterface;
use Magento\Store\Model\StoreManagerInterface;
use Storelocator\Stockists\Block\Stockists;

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
     * @var BaseUrlRewrite
     */
    protected $urlRewrite;

    /**
     * Url rewrite service
     *
     * @var $urlRewriteService
     */
    protected $urlRewriteService;

    /**
     * Url finder
     *
     * @var UrlFinderInterface
     */
    protected $urlFinder;

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Configuration
     *
     * @var Stockists
     */
    protected $stockistsConfig;

    /**
     * StockistInterfaceFactory
     *
     * @var Stockists
     */
    protected $stockistFactory;

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
        BaseUrlRewrite $urlRewrite,
        UrlRewriteService $urlRewriteService,
        UrlFinderInterface $urlFinder,
        StoreManagerInterface $storeManager,
        StockistInterfaceFactory $stockistFactory,
        Stockists $stockistsConfig,
        DataObjectProcessor $dataObjectProcessor,
        DataObjectHelper $dataObjectHelper,
        UploaderPool $uploaderPool
    ) {
        $this->urlRewrite = $urlRewrite;
        $this->urlRewriteService = $urlRewriteService;
        $this->urlFinder = $urlFinder;
        $this->storeManager = $storeManager;
        $this->stockistsConfig = $stockistsConfig;
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
        $storeId = $this->storeManager->getStore()->getId();

        /** @var \Storelocator\Stockists\Api\Data\StockistInterface $stockist */
        $stockist = null;
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['stockist_id']) ? $data['stockist_id'] : null;
        $resultRedirect = $this->resultRedirectFactory->create();

        if($data["link"]) {
            $this->saveUrlRewrite($data["link"], $id, $storeId);
        }

        try {
            if ($id) {
                $stockist = $this->stockistRepository->getById((int)$id);
            } else {
                unset($data['stockist_id']);
                $stockist = $this->stockistFactory->create();
            }
            $image = $this->getUploader('image')->uploadFileAndGetName('image', $data);
            $data['image'] = $image;
            $details_image = $this->getUploader('image')->uploadFileAndGetName('details_image', $data);
            $data['details_image'] = $details_image;

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
        $this->_getSession()->setStorelocatorStockistsStoresData($stockistData);
    }

    /**
     * Saves the url rewrite for that specific store
     * @param $link string
     * @param $id int
     * @param $storeId int
     * @return void
     */
    public function saveUrlRewrite($link, $id, $storeId)
    {
        $moduleUrl = $this->stockistsConfig->getModuleUrlSettings();
        $getCustomUrlRewrite = $moduleUrl."/".$link;
        $stockistId = $moduleUrl."-".$id;
        $filterData = [
            UrlRewriteService::STORE_ID => $storeId,
            UrlRewriteService::ENTITY_TYPE =>  $stockistId,
            UrlRewriteService::ENTITY_ID => $id
        ];

        $rewriteFinder = $this->urlFinder->findOneByData($filterData);

        // if it was not set, create a new one and if necessary delete the old one
        if ($rewriteFinder === null) {

            // check maybe there is an old url with this target path and delete it
            $filterDataOldUrl = [
                UrlRewriteService::STORE_ID => $storeId,
                UrlRewriteService::REQUEST_PATH => $getCustomUrlRewrite,
            ];
            $rewriteFinderOldUrl = $this->urlFinder->findOneByData($filterDataOldUrl);

            if($rewriteFinderOldUrl !== null){
                $this->urlRewrite->load($rewriteFinderOldUrl->getUrlRewriteId())->delete();
            }

            // now we can save
            $this->urlRewrite->setStoreId($storeId)
                ->setIdPath(rand(1, 100000))
                ->setRequestPath($getCustomUrlRewrite)
                ->setTargetPath("stockists/view/index")
                ->setEntityType($stockistId)
                ->setEntityId($id)
                ->setIsSystem(0)
                ->save();
        } else {
            // if it was set check if the info is different and update it if that's the case
            $targetPathAlreadySet = $this->urlRewrite->load($rewriteFinder->getUrlRewriteId())->getRequestPath();
            if($targetPathAlreadySet != $getCustomUrlRewrite) {
                $this->urlRewrite->load($rewriteFinder->getUrlRewriteId())
                    ->setRequestPath($getCustomUrlRewrite)
                    ->save();
            }
        }
    }
}
