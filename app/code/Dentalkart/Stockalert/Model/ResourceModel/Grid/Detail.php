<?php
namespace Dentalkart\Stockalert\Model\ResourceModel\Grid;
class Detail extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
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
	   $this->_init('dentalkart_stockalert_detail' , 'id');
   }

}
