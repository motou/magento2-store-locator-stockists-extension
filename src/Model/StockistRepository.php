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
namespace Limesharp\Stockists\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Limesharp\Stockists\Api\StockistRepositoryInterface;
use Limesharp\Stockists\Api\Data;
use Limesharp\Stockists\Api\Data\StockistInterface;
use Limesharp\Stockists\Api\Data\StockistInterfaceFactory;
use Limesharp\Stockists\Api\Data\StockistSearchResultsInterfaceFactory;
use Limesharp\Stockists\Model\ResourceModel\Stores as ResourceStockist;
use Limesharp\Stockists\Model\ResourceModel\Stores\Collection;
use Limesharp\Stockists\Model\ResourceModel\Stores\CollectionFactory as StockistCollectionFactory;

/**
 * Class StockistRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class StockistRepository implements StockistRepositoryInterface
{
    /**
     * @var array
     */
    public $instances = [];
    /**
     * @var ResourceStockist
     */
    public $resource;
    /**
     * @var StoreManagerInterface
     */
    public $storeManager;
    /**
     * @var StockistCollectionFactory
     */
    public $stockistCollectionFactory;
    /**
     * @var StockistSearchResultsInterfaceFactory
     */
    public $searchResultsFactory;
    /**
     * @var StockistInterfaceFactory
     */
    public $stockistInterfaceFactory;
    /**
     * @var DataObjectHelper
     */
    public $dataObjectHelper;

    public function __construct(
        ResourceStockist $resource,
        StoreManagerInterface $storeManager,
        StockistCollectionFactory $stockistCollectionFactory,
        StockistSearchResultsInterfaceFactory $stockistSearchResultsInterfaceFactory,
        StockistInterfaceFactory $stockistInterfaceFactory,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->resource                 = $resource;
        $this->storeManager             = $storeManager;
        $this->stockistCollectionFactory  = $stockistCollectionFactory;
        $this->searchResultsFactory     = $stockistSearchResultsInterfaceFactory;
        $this->stockistInterfaceFactory   = $stockistInterfaceFactory;
        $this->dataObjectHelper         = $dataObjectHelper;
    }
    /**
     * Save page.
     *
     * @param \Limesharp\Stockists\Api\Data\StockistInterface $stockist
     * @return \Limesharp\Stockists\Api\Data\StockistInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(StockistInterface $stockist)
    {
        /** @var StockistInterface|\Magento\Framework\Model\AbstractModel $stockist */
        if (empty($stockist->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $stockist->setStoreId($storeId);
        }
        try {
            $this->resource->save($stockist);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the store: %1',
                $exception->getMessage()
            ));
        }
        return $stockist;
    }

    /**
     * Retrieve Stockist.
     *
     * @param int $stockistId
     * @return \Limesharp\Stockists\Api\Data\StockistInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($stockistId)
    {
        if (!isset($this->instances[$stockistId])) {

            /** @var \Limesharp\Stockists\Api\Data\StockistInterface|\Magento\Framework\Model\AbstractModel $stockist */
            $stockist = $this->stockistInterfaceFactory->create();
            $this->resource->load($stockist, $stockistId);
            
            if (!$stockist->getId()) {
                throw new NoSuchEntityException(__('Requested stockist doesn\'t exist'));

           }
            $this->instances[$stockistId] = $stockist;
        }

        return $this->instances[$stockistId];;
    }

    /**
     * Retrieve pages matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Limesharp\Stockists\Api\Data\StockistSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Limesharp\Stockists\Api\Data\StockistSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var \Limesharp\Stockists\Model\ResourceModel\Stores\Collection $collection */
        $collection = $this->stockistCollectionFactory->create();

        //Add filters from root filter group to the collection
        /** @var FilterGroup $group */
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
        $sortOrders = $searchCriteria->getSortOrders();
        /** @var SortOrder $sortOrder */
        if ($sortOrders) {
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $field = $sortOrder->getField();
                $collection->addOrder(
                    $field,
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        } else {
            // set a default sorting order since this method is used constantly in many
            // different blocks
            $field = 'stockist_id';
            $collection->addOrder($field, 'ASC');
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        /** @var \Limesharp\Stockists\Api\Data\StockistInterface[] $stockists */
        $stockists = [];
        /** @var \Limesharp\Stockists\Model\Stores $stockist */
        foreach ($collection as $stockist) {
            /** @var \Limesharp\Stockists\Api\Data\StockistInterface $stockistDataObject */
            $stockistDataObject = $this->stockistInterfaceFactory->create();
            $this->dataObjectHelper->populateWithArray($stockistDataObject, $stockist->getData(), StockistInterface::class);
            $stockists[] = $stockistDataObject;
        }
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults->setItems($stockists);
    }

    /**
     * Delete stockist.
     *
     * @param \Limesharp\Stockists\Api\Data\StockistInterface $stockist
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(StockistInterface $stockist)
    {
        /** @var \Limesharp\Stockists\Api\Data\StockistInterface|\Magento\Framework\Model\AbstractModel $stockist */
        $id = $stockist->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($stockist);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove stockist %1', $id)
            );
        }
        unset($this->instances[$id]);
        return true;
    }

    /**
     * Delete stockist by ID.
     *
     * @param int $stockistId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($stockistId)
    {
        $stockist = $this->getById($stockistId);
        return $this->delete($stockist);
    }

    /**
     * Helper function that adds a FilterGroup to the collection.
     *
     * @param FilterGroup $filterGroup
     * @param Collection $collection
     * @return $this
     * @throws \Magento\Framework\Exception\InputException
     */
    public function addFilterGroupToCollection(FilterGroup $filterGroup, Collection $collection)
    {
        $fields = [];
        $conditions = [];
        foreach ($filterGroup->getFilters() as $filter) {
            $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
            $fields[] = $filter->getField();
            $conditions[] = [$condition => $filter->getValue()];
        }
        if ($fields) {
            $collection->addFieldToFilter($fields, $conditions);
        }
        return $this;
    }

}
