<?php
namespace Dentalkart\Stockalert\Model;


class Detail extends \Magento\Framework\Model\AbstractModel implements \Dentalkart\Stockalert\Api\Data\InputdataInterface
{
	const CACHE_TAG = 'dentalkart_stock_alert';

	protected $_cacheTag = 'dentalkart_stock_alert';

	protected $_eventPrefix = 'dentalkart_stock_alert';

	protected function _construct()
	{
		$this->_init('Dentalkart\Stockalert\Model\ResourceModel\Detail');

	}


	/**
	* Get ProductId
	*
	* @return int
	*/
	public function getProductId()
    {
        return $this->getData(self::KEY_PRODUCT_ID);
    }

    public function getCustomerId()
    {
        return $this->getData(self::KEY_CUSTOMER_ID);
    }
    // public function getExpectedQuantity()
    // {
    //     return $this->getData(self::KEY_EXPECTED_QUANTITY);
    // }
    // public function getExpectedPrice()
    // {
    //     return $this->getData(self::KEY_EXPECTED_PRICE);
    // }
    public function getStatus()
    {
        return $this->getData(self::KEY_STATUS);
    }


    /**
    * set ProductId
    *
    * @param int $product_id
    * @return $this
    */
    public function setProductId($product_id)
    {
        return $this->setData(self::KEY_PRODUCT_ID, $product_id);
    }

    public function setCustomerId($customer_id)
    {
        return $this->setData(self::KEY_CUSTOMER_ID, $customer_id);
    }
    // public function setExpectedQuantity($expected_quantity)
    // {
    //     return $this->setData(self::KEY_EXPECTED_QUANTITY, $expected_quantity);
    // }
    // public function setExpectedPrice($expected_price)
    // {
    //     return $this->setData(self::KEY_EXPECTED_PRICE, $expected_price);
    // }
    public function setStatus($status)
    {
        return $this->setData(self::KEY_STATUS, $status);
    }

}
