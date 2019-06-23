<?php
namespace Dentalkart\Feedback\Model\ResourceModel;


class Post extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}

	protected function _construct()
	{
		$this->_init('dentalkart_feedback_post', 'post_id');// to define the table name and primary key for that table
    //so we have the table name dentalkart_feedback_post and primary key is post_id
	}

}
