<?php
namespace Dentalkart\Feedback\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
		$installer = $setup;

		$installer->startSetup();

		if(version_compare($context->getVersion(), '1.1.0', '<')) {
			if (!$installer->tableExists('dentalkart_feedback_post')) {
				$table = $installer->getConnection()->newTable(
					$installer->getTable('dentalkart_feedback_post')
				)
        ->addColumn(
          'post_id',
          \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
          null,
          [
            'identity' => true,
            'nullable' => false,
            'primary'  => true,
            'unsigned' => true,
          ],
          'Post ID'
        )
        ->addColumn(
          'name',
          \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
          255,
          [],
          'Post Name'
        )

        ->addColumn(
          'email',
          \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
          255,
          [],
          'Post email'
        )

        ->addColumn(
          'message',
          \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
          644,
          [],
          'Post message'
        )
        ->addColumn(
          'category',
          \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
          255,
          [],
          'Post category'
        )

					->setComment('Post Table');
				$installer->getConnection()->createTable($table);

				$installer->getConnection()->addIndex(
					$installer->getTable('dentalkart_feedback_post'),
					$setup->getIdxName(
						$installer->getTable('dentalkart_feedback_post'),
						['name','email','message','category'],
						\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
					),
					['name','email','message','category'],
					\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
				);
			}
		}

		$installer->endSetup();
	}
}
