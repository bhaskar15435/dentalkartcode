<?php
namespace Dentalkart\Feedback\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'post_id';
	protected $_eventPrefix = 'dentalkart_feedback_post_collection';
	protected $_eventObject = 'post_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Dentalkart\Feedback\Model\Post', 'Dentalkart\Feedback\Model\ResourceModel\Post');
    //_init() call the _init() method to init the model, resource model in _construct() function.
	}

}
