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
namespace Limesharp\Stockists\Model\Source;

use Magento\Directory\Model\ResourceModel\Country\CollectionFactory as CountryCollectionFactory;
use Magento\Framework\Option\ArrayInterface;

class Country extends AbstractSource implements ArrayInterface
{
    /**
     * @var \Limesharp\Stockists\Model\Stores
     */
    public $countryCollectionFactory;

    /**
     * @param CountryCollectionFactory $countryCollectionFactory
     * @param array $options
     */
    public function __construct(
        CountryCollectionFactory $countryCollectionFactory,
        array $options = []
    ) {
        $this->countryCollectionFactory = $countryCollectionFactory;
        parent::__construct($options);
    }

    /**
     * get options as key value pair
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (count($this->options) == 0) {
            $this->options = $this->countryCollectionFactory->create()->toOptionArray(' ');
        }
        return $this->options;
    }
}
