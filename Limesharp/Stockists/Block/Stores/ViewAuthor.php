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

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Limesharp\Stockists\Block\ImageBuilder;

class ViewAuthor extends Template
{
    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var ImageBuilder
     */
    protected $imageBuilder;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param $imageBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ImageBuilder $imageBuilder,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->imageBuilder = $imageBuilder;
        parent::__construct($context, $data);
    }

    /**
     * get current author
     *
     * @return \Limesharp\Stockists\Model\Stores
     */
    public function getCurrentAuthor()
    {
        return $this->coreRegistry->registry('current_author');
    }

    /**
     * @param $entity
     * @param $imageId
     * @param array $attributes
     * @return \Limesharp\Stockists\Block\Image
     */
    public function getImage($entity, $imageId, $attributes = [])
    {
        return $this->imageBuilder->setEntity($entity)
            ->setImageId($imageId)
            ->setAttributes($attributes)
            ->create();
    }
}
