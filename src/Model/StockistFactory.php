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

use Magento\Framework\ObjectManagerInterface;
use Limesharp\Stockists\Model\Routing\RoutableInterface;

class StockistFactory implements FactoryInterface
{
    /**
     * Object Manager instance
     *
     * @var ObjectManagerInterface
     */
    public $_objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    public $_instanceName = null;

    /**
     * Factory constructor
     *
     * @param ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(ObjectManagerInterface $objectManager, $instanceName = Stores::class)
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName  = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return RoutableInterface|\Limesharp\Stockists\Model\Stores
     */
    public function create(array $data = array())
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
