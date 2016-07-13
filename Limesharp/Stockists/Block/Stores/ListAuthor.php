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
namespace Limesharp\Stockists\Block\Stores;

use Magento\Framework\UrlFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Theme\Block\Html\Pager;
use Limesharp\Stockists\Model\Stores;
use Limesharp\Stockists\Model\ResourceModel\Stores\CollectionFactory as AuthorCollectionFactory;

class ListAuthor extends Template
{
    /**
     * @var AuthorCollectionFactory
     */
    protected $authorCollectionFactory;
    /**
     * @var UrlFactory
     */
    protected $urlFactory;

    /**
     * @var \Limesharp\Stockists\Model\ResourceModel\Stores\Collection
     */
    protected $authors;

    /**
     * @param Context $context
     * @param AuthorCollectionFactory $authorCollectionFactory
     * @param UrlFactory $urlFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        AuthorCollectionFactory $authorCollectionFactory,
        UrlFactory $urlFactory,
        array $data = []
    ) {
        $this->authorCollectionFactory = $authorCollectionFactory;
        $this->urlFactory = $urlFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return \Limesharp\Stockists\Model\ResourceModel\Stores\Collection
     */
    public function getAuthors()
    {
        if (is_null($this->authors)) {
            $this->authors = $this->authorCollectionFactory->create()
                ->addFieldToSelect('*')
                ->addFieldToFilter('status', Stores::STATUS_ENABLED)
                ->addStoreFilter($this->_storeManager->getStore()->getId())
                ->setOrder('name', 'ASC');
        }
        return $this->authors;
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        /** @var \Magento\Theme\Block\Html\Pager $pager */
        $pager = $this->getLayout()->createBlock(Pager::class, 'limesharp_stockists.author.list.pager');
        $pager->setCollection($this->getAuthors());
        $this->setChild('pager', $pager);
        $this->getAuthors()->load();
        return $this;
    }

    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
