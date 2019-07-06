<?php
namespace Dentalkart\Customerstockalert\Model\Grid;


class DkStock extends \Magento\Framework\Model\AbstractModel
{
	const CACHE_TAG = 'dentalkart_customerstockalert';

	protected $_cacheTag = 'dentalkart_customerstockalert';

	protected $_eventPrefix = 'dentalkart_customerstockalert';

	protected function _construct()
	{
		$this->_init('Dentalkart\Customerstockalert\Model\ResourceModel\Grid\DkStock');

	}

}
