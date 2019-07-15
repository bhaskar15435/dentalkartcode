<?php

declare(strict_types=1);

namespace Emizentech\ShopByBrandGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
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
  * @param ItemFactory $checkCustomerAccount
  */
  public function __construct(
    \Emizentech\ShopByBrand\Model\BrandFactory $itemFactory
  ) {
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
      $brandmodel->addFieldToFilter('is_active', 1);
      if(!empty($args['name'])){
        $brandmodel->addFieldToFilter('name', $args['name']);
      }
      if(!empty($args['brand_id'])){
        $brandmodel->addFieldToFilter('attribute_id',$args['brand_id']);
      }
      if(!empty($args['featured'])){
        $brandmodel->addFieldToFilter('featured',$args['featured']);
      }
      if(!empty($args['url_key'])){
        $brandmodel->addFieldToFilter('url_key',$args['url_key']);
      }


      return $brandmodel->getData();
    }
    catch (NoSuchEntityException $exception) {
      throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
    } catch (LocalizedException $exception) {
      throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
    }


  }
}
