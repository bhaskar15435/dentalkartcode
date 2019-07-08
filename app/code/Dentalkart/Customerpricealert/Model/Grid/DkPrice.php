<?php
namespace Dentalkart\Customerpricealert\Model\Grid;


class DkPrice extends \Magento\Framework\Model\AbstractModel
{
	const CACHE_TAG = 'dentalkart_customerpricealert';

	protected $_cacheTag = 'dentalkart_customerpricealert';

	protected $_eventPrefix = 'dentalkart_customerpricealert';

	protected function _construct()
	{
		$this->_init('Dentalkart\Customerpricealert\Model\ResourceModel\Grid\DkPrice');

	}

}
