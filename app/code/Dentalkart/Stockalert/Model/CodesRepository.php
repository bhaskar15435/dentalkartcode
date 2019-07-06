<?php
namespace Dentalkart\Stockalert\Model;
use Dentalkart\Stockalert\Api\CodesRepositoryInterface;

class CodesRepository implements CodesRepositoryInterface
{
    protected $_detailFactory;
    protected $attributeinfo;
    protected $collectionFactory;

    public function __construct(
        \Dentalkart\Stockalert\Model\DetailFactory $detailFactory,
        \Dentalkart\Stockalert\Model\ResourceModel\Detail\CollectionFactory $collectionFactory,
        \Magento\Eav\Model\Entity\Attribute $attributeinfo
    ){
        $this->_detailFactory = $detailFactory;
        $this->attributeinfo = $attributeinfo;
        $this->collectionFactory = $collectionFactory;

    }


    /**
    * @param int $id
    * @return \Dentalkart\Stockalert\Api\Data\InputdataInterface
    */
    public function get($id){
        $bulk = $this->_detailFactory->create()->load($id);
        return $bulk;
    }


    /**
    * @param \Dentalkart\Stockalert\Api\Data\InputdataInterface $Stockalert
    * @return \Dentalkart\Stockalert\Api\Data\InputdataInterface
    */
    public function save(\Dentalkart\Stockalert\Api\Data\InputdataInterface $Stockalert){

        $Stockalertdetails = $this->_detailFactory->create();
        $Stockalertdetails->setCustomerId($Stockalert->getCustomerId())
        ->setProductId($Stockalert->getProductId())
        ->setExpectedQuantity($Stockalert->getExpectedQuantity())
        ->setExpectedPrice($Stockalert->getExpectedPrice())
        ->setStatus($Stockalert->getStatus())
        ->save();
        return $Stockalertdetails;
    }

    /**
    * @param int $id
    * @return bool true
    */
    public function deleteById($id)
    {
        $bulk = $this->_detailFactory->create()->load($id);
        $bulk->delete();
        return true;
    }


    /**
    *
    * @return bool true
    */
    public function execute()
    {
        $collection = $this->collectionFactory->create();

        $productNameAttribute= $this->attributeinfo->loadByCode(\Magento\Catalog\Model\Product::ENTITY, \Magento\Catalog\Api\Data\ProductInterface::NAME);
        $productNameAttributeId = $productNameAttribute->getAttributeId();

        $collection->getSelect()->join(
            [
                'product_varchar' => $collection->getTable('catalog_product_entity_varchar')
            ],
            "product_varchar.entity_id = main_table.product_id AND product_varchar.attribute_id = {$productNameAttributeId}",
            []
            )->columns(['product_name' => 'product_varchar.value']);

            $productPriceAttribute= $this->attributeinfo->loadByCode(\Magento\Catalog\Model\Product::ENTITY, \Magento\Catalog\Api\Data\ProductInterface::NAME);
            $productPriceAttributeId = $productPriceAttribute->getAttributeId();

            $collection->getSelect()->join(
                [
                    'product_alert' => $collection->getTable('product_alert_stock')
                ],
                "product_alert.product_id = main_table.product_id AND AND product_alert.customer_id =main_table.customer_id",
                []
                )->columns(['product_add_date' => 'product_alert.add_date']);


        // $customerAttribute = $this->attributeinfo->loadByCode(\Magento\Customer\Model\Customer::ENTITY, \Magento\Customer\Api\Data\CustomerInterface::FIRSTNAME);
        // $customerAttributeId = $customerAttribute->getAttributeId();
        // $customerAttributeId = 23;

        $collection->getSelect()->join(
            ['customer' => $collection->getTable('customer_entity')],
            "customer.entity_id = main_table.customer_id ",
            []
            )->columns(['customer_name' => 'customer.firstname','customer_email' => 'customer.email']);

       $collection->getSelect()->join(
            [
                'product_sku' => $collection->getTable('catalog_product_entity')
            ],
            "product_sku.entity_id = main_table.product_id ",
            []
            )->columns(['product_sku' => 'product_sku.value']);


                foreach ($collection as $item){
                    echo $item->getproduct_name()."\n";
                    echo $item->getcustomer_name()."\n";
                }
                return true;
            }
        }
