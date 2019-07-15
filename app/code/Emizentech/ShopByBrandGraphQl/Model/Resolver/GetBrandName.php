<?php

declare(strict_types=1);

namespace Emizentech\ShopByBrandGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\CustomerGraphQl\Model\Customer\CustomerDataProvider;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;

/**
* Customers field resolver, used for GraphQL request processing.
*/
class GetBrandName implements ResolverInterface
{
  /**
  * @var item
  */
  private $itemFactory;

  /**
  * @var CustomerDataProvider
  */
  private $customerDataProvider;

  /**
  * @param ItemFactory $checkCustomerAccount
  * @param CustomerDataProvider $customerDataProvider
  */
  public function __construct(
    CustomerDataProvider $customerDataProvider,
    \Emizentech\ShopByBrand\Model\BrandFactory $itemFactory
  ) {
    $this->customerDataProvider = $customerDataProvider;
    $this->itemFactory=$itemFactory;
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


    try
    {
      $brandmodel=$this->itemFactory->create()->getcollection();
      if(!empty($args['brand'])){
        $brandmodel->addFieldToFilter('name', $args['brand']);
      }
      if(!empty($args['id'])){
        $brandmodel->addFieldToFilter('attribute_id',$args['id']);
      }


      if(!$brandmodel->getSize()){
        throw new GraphQlNoSuchEntityException(__("Brand doesn't exist."));
      }

      return $brandmodel->getFirstItem()->getData();
    }
    catch (NoSuchEntityException $exception) {
      throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
    } catch (LocalizedException $exception) {
      throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
    }


  }
}
