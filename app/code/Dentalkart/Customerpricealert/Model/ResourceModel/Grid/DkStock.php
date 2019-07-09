<?php
namespace Dentalkart\Customerpricealert\Model\ResourceModel\Grid;
class DkStock extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
   /**
	* Construct.
	*
	* @param \Magento\Framework\Model\ResourceModel\Db\Context $context
	*/
   public function __construct(
	   \Magento\Framework\Model\ResourceModel\Db\Context $context
   )
   {
	   parent::__construct($context);
   }
   /**
	* Initialize resource model.
	*/
   protected function _construct()
   {
	   $this->_init('product_alert_stock' , 'alert_stock_id');
   }

}
