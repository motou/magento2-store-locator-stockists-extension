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
namespace Limesharp\Stockists\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Stdlib\DateTime as LibDateTime;
use Magento\Framework\Model\AbstractModel;
use Magento\Store\Model\Store;
use Limesharp\Stockists\Model\Stores as StockistModel;
use Magento\Framework\Event\ManagerInterface;

class Stores extends AbstractDb
{
    /**
     * Store model
     *
     * @var \Magento\Store\Model\Store
     */
    public $store = null;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    public $date;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    public $storeManager;

    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    public $dateTime;

    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    public $eventManager;

    /**
     * @param Context $context
     * @param DateTime $date
     * @param StoreManagerInterface $storeManager
     * @param LibDateTime $dateTime
     * @param ManagerInterface $eventManager
     */
    public function __construct(
        Context $context,
        DateTime $date,
        StoreManagerInterface $storeManager,
        LibDateTime $dateTime,
        ManagerInterface $eventManager
    ) {
        $this->date             = $date;
        $this->storeManager     = $storeManager;
        $this->dateTime         = $dateTime;
        $this->eventManager     = $eventManager;

        parent::__construct($context);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('limesharp_stockists_stores', 'stockist_id');
    }

    /**
     * Process stockist data before deleting
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    public function _beforeDelete(AbstractModel $object)
    {
        $condition = ['stockist_id = ?' => (int)$object->getId()];
        $this->getConnection()->delete($this->getTable('limesharp_stockists_stores'), $condition);
        return parent::_beforeDelete($object);
    }

    /**
     * before save callback
     *
     * @param AbstractModel|\Limesharp\Stockists\Model\Stores $object
     * @return $this
     */
    public function _beforeSave(AbstractModel $object)
    {

        $object->setUpdatedAt($this->date->gmtDate());
        
        if ($object->isObjectNew()) {
            $object->setCreatedAt($this->date->gmtDate());
        }

        return parent::_beforeSave($object);
    }


    /**
     * Set store model
     *
     * @param Store $store
     * @return $this
     */
    public function setStore(Store $store)
    {
        $this->store = $store;
        return $this;
    }

    /**
     * Retrieve store model
     *
     * @return Store
     */
    public function getStore()
    {
        return $this->storeManager->getStore($this->store);
    }


    /**
     * @param AbstractModel $object
     * @param $attribute
     * @return $this
     * @throws \Exception
     */
    public function saveAttribute(AbstractModel $object, $attribute)
    {
        if (is_string($attribute)) {
            $attributes = [$attribute];
        } else {
            $attributes = $attribute;
        }
        if (is_array($attributes) && !empty($attributes)) {
            $this->getConnection()->beginTransaction();
            $data = array_intersect_key($object->getData(), array_flip($attributes));
            try {
                $this->beforeSaveAttribute($object, $attributes);
                if ($object->getId() && !empty($data)) {
                    $this->getConnection()->update(
                        $object->getResource()->getMainTable(),
                        $data,
                        [$object->getResource()->getIdFieldName() . '= ?' => (int)$object->getId()]
                    );
                    $object->addData($data);
                }
                $this->afterSaveAttribute($object, $attributes);
                $this->getConnection()->commit();
            } catch (\Exception $e) {
                $this->getConnection()->rollBack();
                throw $e;
            }
        }
        return $this;
    }

    /**
     * @param AbstractModel $object
     * @param $attribute
     * @return $this
     */
    public function beforeSaveAttribute(AbstractModel $object, $attribute)
    {
        if ($object->getEventObject() && $object->getEventPrefix()) {
            $this->eventManager->dispatch(
                $object->getEventPrefix() . '_save_attribute_before',
                [
                    $object->getEventObject() => $this,
                    'object' => $object,
                    'attribute' => $attribute
                ]
            );
        }
        return $this;
    }

    /**
     * After save object attribute
     *
     * @param AbstractModel $object
     * @param string $attribute
     * @return \Magento\Sales\Model\ResourceModel\Attribute
     */
    public function afterSaveAttribute(AbstractModel $object, $attribute)
    {
        if ($object->getEventObject() && $object->getEventPrefix()) {
            $this->eventManager->dispatch(
                $object->getEventPrefix() . '_save_attribute_after',
                [
                    $object->getEventObject() => $this,
                    'object' => $object,
                    'attribute' => $attribute
                ]
            );
        }
        return $this;
    }
}
