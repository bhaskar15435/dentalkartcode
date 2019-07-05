<?php
namespace Dentalkart\Stockalert\Model\ResourceModel\Detail;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'product_alert_stock_collection';
    protected $_eventObject = 'detail_collection';



        /**
        * Define resource model
        *
        * @return void
        */
        protected function _construct()
        {
            $this->_init('Dentalkart\Stockalert\Model\Detail', 'Dentalkart\Stockalert\Model\ResourceModel\Detail');
        }
}
