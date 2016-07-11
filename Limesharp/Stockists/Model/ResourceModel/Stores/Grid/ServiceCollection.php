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
// @codingStandardsIgnoreFile
namespace Limesharp\Stockists\Model\ResourceModel\Stores\Grid;

use Magento\Framework\Api\AbstractServiceCollection;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SimpleDataObjectConverter;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Data\Collection\EntityFactory;
use Magento\Framework\DataObject;
use Limesharp\Stockists\Api\AuthorRepositoryInterface;
use Limesharp\Stockists\Api\Data\AuthorInterface;

/**
 * Author collection backed by services
 */
class ServiceCollection extends AbstractServiceCollection
{
    /**
     * @var AuthorRepositoryInterface
     */
    protected $authorRepository;

    /**
     * @var SimpleDataObjectConverter
     */
    protected $simpleDataObjectConverter;

    /**
     * @param EntityFactory $entityFactory
     * @param FilterBuilder $filterBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param AuthorRepositoryInterface $authorRepository
     * @param SimpleDataObjectConverter $simpleDataObjectConverter
     */
    public function __construct(
        EntityFactory $entityFactory,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        AuthorRepositoryInterface $authorRepository,
        SimpleDataObjectConverter $simpleDataObjectConverter
    ) {
        $this->authorRepository          = $authorRepository;
        $this->simpleDataObjectConverter = $simpleDataObjectConverter;
        parent::__construct($entityFactory, $filterBuilder, $searchCriteriaBuilder, $sortOrderBuilder);
    }

    /**
     * Load customer group collection data from service
     *
     * @param bool $printQuery
     * @param bool $logQuery
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function loadData($printQuery = false, $logQuery = false)
    {
        if (!$this->isLoaded()) {
            $searchCriteria = $this->getSearchCriteria();
            $searchResults = $this->authorRepository->getList($searchCriteria);
            $this->_totalRecords = $searchResults->getTotalCount();
            /** @var AuthorInterface[] $authors */
            $authors = $searchResults->getItems();
            foreach ($authors as $author) {
                $authorItem = new DataObject();
                $authorItem->addData(
                    $this->simpleDataObjectConverter->toFlatArray($author, AuthorInterface::class)
                );
                $this->_addItem($authorItem);
            }
            $this->_setIsLoaded();
        }
        return $this;
    }
}
