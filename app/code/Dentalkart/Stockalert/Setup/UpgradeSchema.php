<?php
namespace Dentalkart\Stockalert\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $installer = $setup;

        $installer->startSetup();

        if(version_compare($context->getVersion(), '1.1.0', '<')) {
            if (!$installer->tableExists('product_alert_stock')) {
                $table = $installer->getConnection()->newTable(
                    $installer->getTable('product_alert_stock')
                    )
                    ->addColumn(
                        'id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary'  => true,
                            'unsigned' => true,
                        ],
                        'Stockalert id'
                        )
                        ->addColumn(
                            'product_id',
                            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                            255,
                            [],
                            'Stockalert product_id'
                            )
                            ->addColumn(
                                'customer_id',
                                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                                255,
                                [],
                                'Stockalert customer_id'
                                )
                                        ->addColumn(
                                            'status',
                                            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                                            1,
                                            [],
                                            'Stockalert status'
                                            )
                                            ->setComment('Detail Table');
                                            $installer->getConnection()->createTable($table);
                                            $installer->getConnection()->addIndex(
                                                $installer->getTable('product_alert_stock'),
                                                $setup->getIdxName(
                                                    $installer->getTable('product_alert_stock'),
                                                    ['product_id','customer_id','status'],
                                                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                                                ),
                                                ['product_id','customer_id','status'],
                                                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                                            );
                                        }
                                    }

                                    $installer->endSetup();
                                }
                            }
