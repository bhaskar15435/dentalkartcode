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
      \Dentalkart\StockalertGraphQl\Block\Storeinfo $storeinfo,
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
      if ((!$context->getUserId()) || $context->getUserType() == \Magento\Authorization\Model\UserContextInterface::USER_TYPE_GUEST) {
            throw new GraphQlAuthorizationException(
                __(
                    'Current customer must login first to avail this facility "%1"',
                    [\Magento\Customer\Model\Customer::ENTITY]
                )
            );
            $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/xyz.log');
            $logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);
            $logger-info("kam ban gaya");
        }
        if (!isset($args['productid'])) {
            throw new GraphQlInputException(__('Required parameter "product id" is missing'));
        }
        try {

          $customer_id = $context->getUserId();
          $stockModel = $this->stockFactory->create();
          $stockModel->setData('productid',$args['productid'])->setData('status',0)->setData('customer_id',$customer_id)->save();
        } catch (NoSuchEntityException $exception) {
            throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
        } catch (LocalizedException $exception) {
            throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
        }
    }
}
