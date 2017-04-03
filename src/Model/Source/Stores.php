<?php


namespace Limesharp\Stockists\Model\Source;

use Magento\Framework\Option\ArrayInterface;
use \Magento\Store\Model\StoreManagerInterface;

class Stores extends AbstractSource implements ArrayInterface
{
    /*
     * StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param array $options
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        array $options = []
    ) {
        $this->storeManager = $storeManager;
        parent::__construct($options);
    }
    /**
     *
     * get options as key value pair and add new line between items
     *
     * @return array
     */
    public function toOptionArray()
    {
        $this->options = [];
        if (count($this->options) == 0) {
            $stores = $this->storeManager->getStores();
            $i = 0;
            foreach ($stores as $store){
                $newLine = $i != 0 ? '<br>' : '';
                $this->options[] = ["value" => $store->getId(), "label" =>  html_entity_decode(nl2br($newLine.$store->getName()))];
                $i++;
            }
        }
        return $this->options;

    }

}
