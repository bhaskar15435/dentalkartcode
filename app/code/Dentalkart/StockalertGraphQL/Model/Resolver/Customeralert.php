<?php

namespace Dentalkart\StockalertGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Query\Resolver\ValueFactory;

/**
 * Update customer data resolver
 */
class Customeralert implements ResolverInterface
{


    private $valueFactory;


    private $storeinfo;

    private $stockFactory;

    /**
     * @param Alertstock $alertstock
     * @param ValueFactory $valueFactory
     */
    public function __construct(
      \Dentalkart\StockalertGraphQl\Block\StoreInfo $storeinfo,
      \Magento\ProductAlert\Model\StockFactory $stockFactory,
        ValueFactory $valueFactory
    ) {
        $this->valueFactory = $valueFactory;
        $this->storeinfo=$storeinfo;
        $this->stockFactory=$stockFactory;
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
      if ((!$context->getUserId()) || $context->getUserType() == UserContextInterface::USER_TYPE_GUEST) {
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
      // date_default_timezone_set('Asia/Calcutta');
        // if (!isset($args['sku'])) {
        //     throw new GraphQlInputException(__('Required parameter "sku" is missing'));
        // }
        try {
          // $code = $args['input']['code'];
          //   $message = $args['input']['message'];
          //   if (isset($args['input']['attachments'])) {
          //       $attachments = $args['input']['attachments'];
          //   }

          $customer_id = $context->getUserId();
          $stockModel = $this->stockFactory->create();
          $stockModel->setData('store_id',$this->storeinfo->getstore_id())
            ->setData('website_id',$this->storeinfo->getwebsite_id())->setData('customer_id',$customer_id)->save();
        } catch (NoSuchEntityException $exception) {
            throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
        } catch (LocalizedException $exception) {
            throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
        }
    }
}
