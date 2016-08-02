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
 
namespace Limesharp\Stockists\Setup;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;
use Magento\Config\Model\ResourceModel\Config\Data;
use Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory;

/**
 * @codeCoverageIgnore
 */
 
class Uninstall implements UninstallInterface
{
    /**
     * @var CollectionFactory
     */
    public $collectionFactory;
    /**
     * @var Data
     */
    public $configResource;
    /**
     * @param CollectionFactory $collectionFactory
     * @param Data $configResource
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Data $configResource
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->configResource    = $configResource;
    }
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.Generic.CodeAnalysis.UnusedFunctionParameter)
     */
    // @codingStandardsIgnoreStart
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    // @codingStandardsIgnoreEnd
    {
        //remove tables
        if ($setup->tableExists('limesharp_stockists_stores')) {
            $setup->getConnection()->dropTable('limesharp_stockists_stores');
        }
        //remove config settings if any
        $collection = $this->collectionFactory->create()
            ->addPathFilter('limesharp_stockists_stores');
        foreach ($collection as $config) {
            $this->deleteConfig($config);
        }
    }
    /**
     * @param AbstractModel $config
     * @throws \Exception
     */
    public function deleteConfig(AbstractModel $config)
    {
        $this->configResource->delete($config);
    }
}