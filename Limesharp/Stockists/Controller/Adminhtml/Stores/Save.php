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

use Magento\Backend\Model\Session;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Result\PageFactory;
use Limesharp\Stockists\Api\AuthorRepositoryInterface;
use Limesharp\Stockists\Api\Data\AuthorInterface;
use Limesharp\Stockists\Api\Data\AuthorInterfaceFactory;
use Limesharp\Stockists\Controller\Adminhtml\Stores;
use Limesharp\Stockists\Model\Uploader;
use Limesharp\Stockists\Model\UploaderPool;

class Save extends Stores
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
     * @param AuthorRepositoryInterface $authorRepository
     * @param PageFactory $resultPageFactory
     * @param Date $dateFilter
     * @param Context $context
     * @param AuthorInterfaceFactory $authorFactory
     * @param DataObjectProcessor $dataObjectProcessor
     * @param DataObjectHelper $dataObjectHelper
     * @param UploaderPool $uploaderPool
     */
    public function __construct(
        Registry $registry,
        AuthorRepositoryInterface $authorRepository,
        PageFactory $resultPageFactory,
        Date $dateFilter,
        Context $context,
        AuthorInterfaceFactory $authorFactory,
        DataObjectProcessor $dataObjectProcessor,
        DataObjectHelper $dataObjectHelper,
        UploaderPool $uploaderPool
    )
    {
        $this->authorFactory = $authorFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->uploaderPool = $uploaderPool;
        parent::__construct($registry, $authorRepository, $resultPageFactory, $dateFilter, $context);
    }

    /**
     * run the action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        /** @var \Limesharp\Stockists\Api\Data\AuthorInterface $author */
        $author = null;
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['store_id']) ? $data['store_id'] : null;
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            if ($id) {
                $author = $this->authorRepository->getById((int)$id);
            } else {
                unset($data['store_id']);
                $author = $this->authorFactory->create();
            }
            $avatar = $this->getUploader('image')->uploadFileAndGetName('avatar', $data);
            $data['avatar'] = $avatar;
            $resume = $this->getUploader('file')->uploadFileAndGetName('resume', $data);
            $data['resume'] = $resume;
            $this->dataObjectHelper->populateWithArray($author, $data, AuthorInterface::class);
            $this->authorRepository->save($author);
            $this->messageManager->addSuccessMessage(__('You saved the store'));
            if ($this->getRequest()->getParam('back')) {
                $resultRedirect->setPath('stockists/stores/edit', ['store_id' => $author->getId()]);
            } else {
                $resultRedirect->setPath('stockists/stores');
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            if ($author != null) {
                $this->storeAuthorDataToSession(
                    $this->dataObjectProcessor->buildOutputDataArray(
                        $author,
                        AuthorInterface::class
                    )
                );
            }
            $resultRedirect->setPath('stockists/stores/edit', ['store_id' => $id]);
        } catch (\Exception $e) {
	        var_dump($e); die();
            $this->messageManager->addErrorMessage(__('There was a problem saving the store'));
            if ($author != null) {
                $this->storeAuthorDataToSession(
                    $this->dataObjectProcessor->buildOutputDataArray(
                        $author,
                        AuthorInterface::class
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
    protected function getUploader($type)
    {
        return $this->uploaderPool->getUploader($type);
    }

    /**
     * @param $authorData
     */
    protected function storeAuthorDataToSession($authorData)
    {
        $this->_getSession()->setSampleNewsAuthorData($authorData);
    }
}
