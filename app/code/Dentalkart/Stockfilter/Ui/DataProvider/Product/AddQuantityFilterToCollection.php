<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Dentalkart\Stockfilter\Ui\DataProvider\Product;

use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Magento\Framework\Data\Collection;
use Magento\Ui\DataProvider\AddFilterToCollectionInterface;

/**
 * Class AddQuantityFilterToCollection
 */
class AddQuantityFilterToCollection implements AddFilterToCollectionInterface
{
    /**
     * {@inheritdoc}
     */
    public function addFilter(Collection $collection, $field, $condition = null)
    {
        if (isset($condition['gteq'])) {
            $collection->getSelect()->where(
                AbstractCollection::ATTRIBUTE_TABLE_ALIAS_PREFIX . 'is_in_stock.is_in_stock >= ?',
                (float)$condition['gteq']
            );
        }
        if (isset($condition['lteq'])) {
            $collection->getSelect()->where(
                AbstractCollection::ATTRIBUTE_TABLE_ALIAS_PREFIX . 'is_in_stock.is_in_stock <= ?',
                (float)$condition['lteq']
            );
        }
    }
}
