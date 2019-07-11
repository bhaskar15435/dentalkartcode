<?php

namespace Dentalkart\PricealertGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Query\Resolver\ValueFactory;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
/**
 * Update customer data resolver
 */
class CustomerPriceAlert implements ResolverInterface
{


    private $valueFactory;


    private $storeinfo;

    private $PriceFactory;

    /**
     * @param AlertPrice $alertPrice
     * @param ValueFactory $valueFactory
     */
    public function __construct(
      \Dentalkart\PricealertGraphQl\Block\Storeinfo $storeinfo,
      \Magento\Catalog\Model\ProductFactory $productFactory,
      \Magento\ProductAlert\Model\PriceFactory $priceFactory,
        ValueFactory $valueFactory
    ) {
        $this->valueFactory = $valueFactory;
        $this->storeinfo=$storeinfo;
        $this->productFactory=$productFactory;
        $this->priceFactory=$priceFactory;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
      if ((!$context->getUserId()) || $context->getUserType() == \Magento\Authorization\Model\UserContextInterface::USER_TYPE_GUEST) {
            throw new GraphQlAuthorizationException(
                __(
                    'Current customer must login first to avail this facility "%1"',
                    [\Magento\Customer\Model\Customer::ENTITY]
                )
            );
        }
        if (!isset($args['productid'])) {
            throw new GraphQlInputException(__('Required parameter "product id" is missing'));
        }
        try {

          $customer_id = $context->getUserId();
          $price=$this->productFactory->create()->load($args['productid'])->getPrice();
          $priceModel = $this->priceFactory->create();
          $priceModel->setData('product_id',$args['productid'])->setData('store_id',$this->storeinfo->getStore()->getId())
            ->setData('website_id',$this->storeinfo->getStore()->getWebsiteId())->setData('customer_id',$customer_id)->setData('price',$price)->save();
          return ['message'=> 'success'];
        } catch (NoSuchEntityException $exception) {
            throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
        } catch (LocalizedException $exception) {
            throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
        }
    }
}
