<?php
declare(strict_types=1);
/**
 * Storelocator_Stockists extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category  Storelocator
 * @package   Storelocator_Stockists
 * @copyright 2016 Claudiu Creanga
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 * @author    Claudiu Creanga
 */

namespace Storelocator\Stockists\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.Generic.CodeAnalysis.UnusedFunctionParameter)
     */

    // @codingStandardsIgnoreStart
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if ($installer->tableExists('storelocator_stockists_stores')) {
            $table = $installer->getTable('storelocator_stockists_stores');
            $connection = $installer->getConnection();
            if (version_compare($context->getVersion(), '2.0.0') < 0) {
                $connection->addColumn(
                    $table,
                    'schedule',
                    [
                        'type' => Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => true,
                        'comment' => 'Schedule'
                    ]
                );
                $connection->addColumn(
                    $table,
                    'station',
                    [
                        'type' => Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => true,
                        'comment' => 'Nearest Station'
                    ]
                );
                $connection->addColumn(
                    $table,
                    'description',
                    [
                        'type' => Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => true,
                        'comment' => 'Description'
                    ]
                );
                $connection->addColumn(
                    $table,
                    'intro',
                    [
                        'type' => Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => true,
                        'comment' => 'Intro'
                    ]
                );
                $connection->addColumn(
                    $table,
                    'details_image',
                    [
                        'type' => Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => true,
                        'comment' => 'Details Image'
                    ]
                );
                $connection->addColumn(
                    $table,
                    'distance',
                    [
                        'type' => Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => true,
                        'comment' => 'Distance'
                    ]
                );
                $connection->addColumn(
                    $table,
                    'external_link',
                    [
                        'type' => Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => true,
                        'comment' => 'External Link'
                    ]
                );
            }
            $installer->endSetup();
        }
    }
}
