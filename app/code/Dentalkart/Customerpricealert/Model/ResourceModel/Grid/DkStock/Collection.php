<?php
namespace Dentalkart\Customerpricealert\Model\ResourceModel\Grid\DkStock;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'alert_stock_id';
    // protected $_eventPrefix = 'dentalkart_customerpricealert_collection';
    // protected $_eventObject = 'detail_collection';



        /**
        * Define resource model
        *
        * @return void
        */
        protected function _construct()
        {
            $this->_init('Dentalkart\Customerpricealert\Model\Grid\DkStock', 'Dentalkart\Customerpricealert\Model\ResourceModel\Grid\DkStock');
        }
}
