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

namespace Limesharp\Stockists\Ui\DataProvider\Stores\Form\Modifier;

use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Limesharp\Stockists\Model\ResourceModel\Stores\CollectionFactory;

class StoresData implements ModifierInterface
{
    /**
     * @var \Limesharp\Stockists\Model\ResourceModel\Stores\Collection
     */
    protected $collection;

    /**
     * @param CollectionFactory $stockistCollectionFactory
     */
    public function __construct(
        CollectionFactory $stockistCollectionFactory
    ) {
        $this->collection = $stockistCollectionFactory->create();
    }

    /**
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        return $meta;
    }

    /**
     * @param array $data
     * @return array|mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function modifyData(array $data)
    {
        $items = $this->collection->getItems();
        /** @var $stockist \Limesharp\Stockists\Model\Stores */
        foreach ($items as $stockist) {
            $_data = $stockist->getData();
            if (isset($_data['avatar'])) {
                $avatar = [];
                $avatar[0]['name'] = $stockist->getAvatar();
                $avatar[0]['url'] = $stockist->getAvatarUrl();
                $_data['avatar'] = $avatar;
            }
            if (isset($_data['resume'])) {
                $resume = [];
                $resume[0]['name'] = $stockist->getResume();
                $resume[0]['url'] = $stockist->getResumeUrl();
                $_data['resume'] = $resume;
            }
            $stockist->setData($_data);
            $data[$stockist->getId()] = $_data;
        }
        return $data;
    }
}
