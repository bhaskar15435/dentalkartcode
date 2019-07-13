<?php

namespace Dentalkart\Stockfilter\Ui\DataProvider\Product;

use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Magento\Framework\Data\Collection;
use Magento\Ui\DataProvider\AddFilterToCollectionInterface;


class AddQuantityFilterToCollection implements AddFilterToCollectionInterface
{
    /**
     * {@inheritdoc}
     */
    public function addFilter(Collection $collection, $field, $condition = null)
    {
      $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/xyz.log');
      $logger = new \Zend\Log\Logger();
      $logger->addWriter($writer);
        if (isset($condition['gteq'])) {
            $collection->getSelect()->where(
                AbstractCollection::ATTRIBUTE_TABLE_ALIAS_PREFIX . 'is_in_stock.is_in_stock >= ?',
                (float)$condition['gteq']
            );
            $logger->info('hey bro');
        }
        if (isset($condition['lteq'])) {
            $collection->getSelect()->where(
                AbstractCollection::ATTRIBUTE_TABLE_ALIAS_PREFIX . 'is_in_stock.is_in_stock <= ?',
                (float)$condition['lteq']
            );
            $logger->info('hey bro kuch kar yaar');
        }

    }
}
