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
namespace Limesharp\Stockists\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * @api
 */
interface StockistSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get stockist list.
     *
     * @return \Limesharp\Stockists\Api\Data\StockistInterface[]
     */
    public function getItems();

    /**
     * Set stockists list.
     *
     * @param \Limesharp\Stockists\Api\Data\StockistInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
