<?php
namespace Dentalkart\Stockalert\Api\Data;

/**
* @api
*/
interface InputdataInterface
{
    const KEY_PRODUCT_ID = 'product_id';
    const KEY_CUSTOMER_ID = 'customer_id';
    const KEY_STATUS = 'status';

    /**
    * Get ProductId
    *
    * @return int
    */
    public function getProductId();

    /**
    * Get CustomerId
    *
    * @return int
    */
    public function getCustomerId();

  /**
    * Get Status
    *
    * @return int
    */
    public function getStatus();

    /**
    * Set ProductId
    *
    * @param int $id
    * @return $this
    */
    public function setProductId($id);

    /**
    * Set CustomerId
    *
    * @param int $CustomerId
    * @return $this
    */
    public function setCustomerId($id);

    /**
    * Set Status
    *
    * @param int $Status
    * @return $this
    */
    public function setStatus($id);

}
