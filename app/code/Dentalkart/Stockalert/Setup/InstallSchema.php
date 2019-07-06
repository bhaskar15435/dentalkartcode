<?php
namespace Dentalkart\Stockalert\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('dentalkart_stock_alert')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('dentalkart_stock_alert')
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
                                $installer->getTable('dentalkart_stock_alert'),
                                $setup->getIdxName(
                                    $installer->getTable('dentalkart_stock_alert'),
                                    ['product_id','customer_id','status'],
                                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                                ),
                                ['product_id','customer_id','status'],
                                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                            );
                        }
                        $installer->endSetup();
                    }
                }
