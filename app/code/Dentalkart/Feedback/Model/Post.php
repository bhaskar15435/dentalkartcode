<?php
namespace Dentalkart\Feedback\Model;
class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'dentalkart_feedback_post';

	protected $_cacheTag = 'dentalkart_feedback_post';

	protected $_eventPrefix = 'dentalkart_feedback_post';

	protected function _construct()
	{
		$this->_init('Dentalkart\Feedback\Model\ResourceModel\Post');
    //_init() will define the resource model which will actually fetch the information from the database
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}
