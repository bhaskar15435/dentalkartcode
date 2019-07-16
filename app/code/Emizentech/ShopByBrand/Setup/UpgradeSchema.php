<?php

namespace Emizentech\ShopByBrand\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '0.2.4') < 0) {
            $connection = $setup->getConnection();
            $connection->addColumn(
                $setup->getTable('emizentech_shopbybrand_items'),
                'url_path',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'URL Path'
                ]
            );
        }
    }
}







// <?php
//
//
//
// use Magento\Framework\Setup\UpgradeSchemaInterface;
// use Magento\Framework\Setup\ModuleContextInterface;
// use Magento\Framework\Setup\SchemaSetupInterface;
// use Magento\Framework\DB\Ddl\Table;
// use Magento\Framework\DB\Adapter\AdapterInterface;
//
//
// class UpgradeSchema implements UpgradeSchemaInterface
// {
//   public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
//   {
//     $installer = $setup;
//
//     $installer->startSetup();
//
//             $installer->startSetup();
//             if (version_compare($context->getVersion(), "0.2.2 ", "<")) {
//               $table  = $installer->getConnection()
//               ->newTable($installer->getTable('emizentech_shopbybrand_items'))
//               ->addColumn(
//                 'id',
//                 Table::TYPE_INTEGER,
//                 null,
//                 ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
//                 'Id'
//                 )
//                 ->addColumn(
//                   'name',
//                   Table::TYPE_TEXT,
//                   null,
//                   ['default' => null],
//                   'Name'
//                   )
//                   ->addColumn(
//                     'attribute_id',
//                     Table::TYPE_INTEGER,
//                     null,
//                     ['default' => null , 'unique' => true],
//                     'attribute_id'
//                     )
//                     ->addIndex(
//                       $installer->getIdxName(
//                         'attribute_id',
//                         ['attribute_id'],
//                         \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
//                       ),
//                       ['attribute_id'],
//                       ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
//                       )
//                       ->addColumn(
//                         'sort_order',
//                         Table::TYPE_INTEGER,
//                         null,
//                         ['default' => 0],
//                         'Sort Order'
//                         )
//                         ->addColumn(
//                           'url_key',
//                           Table::TYPE_TEXT,
//                           null,
//                           ['default' => null],
//                           'Url Key'
//                           )
//                           ->addColumn(
//                             'logo',
//                             Table::TYPE_TEXT,
//                             null,
//                             ['default' => null],
//                             'logo'
//                             )
//                             ->addColumn(
//                               'is_active',
//                               Table::TYPE_SMALLINT,
//                               null,
//                               [],
//                               'Active Status'
//                               )
//                               ->addColumn(
//                                 'category_id',
//                                 Table::TYPE_INTEGER,
//                                 null,
//                                 [],
//                                 'Category Id'
//                                 )
//                                 ->addColumn(
//                                   'featured',
//                                   Table::TYPE_SMALLINT,
//                                   null,
//                                   ['default' => 0],
//                                   'Featured'
//                                   )
//                                   ->setComment(
//                                     'Brand Table'
//                                     )
//                                     ;
//
//             }
//             if (version_compare($context->getVersion(), '0.2.3', '<')) {
//                       $installer->getConnection()->addColumn(
//                             $installer->getTable('emizentech_shopbybrand_items'),
//                             'category_id',
//                             [
//                                 'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
//                                 'length' => 10,
//                                 'nullable' => true,
//                                 'comment' => 'Category Id'
//                             ]
//                         );
//                     }
//
//
//
//                           $installer->endSetup();
//
//
//                         }
//                       }
