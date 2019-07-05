<?php
namespace Dentalkart\Stockalert\Model\ResourceModel\Grid\Detail\Grid;



use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\Search\AggregationInterface;
use Dentalkart\Stockalert\Model\ResourceModel\Detail\Collection as DetailCollection;



class Collection extends DetailCollection  implements SearchResultInterface
{
  protected $aggregations;
  protected $attributeinfo;

  /**
  * @param \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory
  * @param \Psr\Log\LoggerInterface $logger
  * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
  * @param \Magento\Framework\Event\ManagerInterface $eventManager
  * @param \Magento\Store\Model\StoreManagerInterface $storeManager
  * @param \Magento\Framework\EntityManager\MetadataPool $metadataPool
  * @param \Magento\Eav\Model\Entity\Attribute $attributeinfo

  * @param string $mainTable
  * @param string $eventPrefix
  * @param string $eventObject
  * @param string $resourceModel
  * @param string $model
  * @param \Magento\Framework\DB\Adapter\AdapterInterface $connection
  * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource
  *
  * @SuppressWarnings(PHPMD.ExcessiveParameterList)
  */
  public function __construct(
    \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
    \Psr\Log\LoggerInterface $logger,
    \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
    \Magento\Framework\Event\ManagerInterface $eventManager,
    \Magento\Store\Model\StoreManagerInterface $storeManager,
    \Magento\Eav\Model\Entity\Attribute $attributeinfo,
    $mainTable,
    $eventPrefix,
    $eventObject,
    $resourceModel,
    $model = 'Magento\Framework\View\Element\UiComponent\DataProvider\Document',
    \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
    \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
  ) {
    parent::__construct(
      $entityFactory,
      $logger,
      $fetchStrategy,
      $eventManager,
      $connection,
      $resource
    );
    $this->_eventPrefix = $eventPrefix;
    $this->_eventObject = $eventObject;
    $this->_init($model, $resourceModel);
    $this->setMainTable($mainTable);
    $this->attributeinfo = $attributeinfo;

  }

  /**
  * @return AggregationInterface
  */
  public function getAggregations()
  {
    return $this->aggregations;
  }

  /**
  * @param AggregationInterface $aggregations
  * @return $this
  */
  public function setAggregations($aggregations)
  {
    $this->aggregations = $aggregations;
  }

  /**
  * Get search criteria.
  *
  * @return \Magento\Framework\Api\SearchCriteriaInterface|null
  */
  public function getSearchCriteria()
  {
    return null;
  }

  /**
  * Set search criteria.
  *
  * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
  * @return $this
  * @SuppressWarnings(PHPMD.UnusedFormalParameter)
  */
  public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
  {
    return $this;
  }

  /**
  * Get total count.
  *
  * @return int
  */
  public function getTotalCount()
  {
    return $this->getSize();
  }

  /**
  * Set total count.
  *
  * @param int $totalCount
  * @return $this
  * @SuppressWarnings(PHPMD.UnusedFormalParameter)
  */
  public function setTotalCount($totalCount)
  {
    return $this;
  }

  /**
  * Set items list.
  *
  * @param \Magento\Framework\Api\ExtensibleDataInterface[] $items
  * @return $this
  * @SuppressWarnings(PHPMD.UnusedFormalParameter)
  */
  public function setItems(array $items = null)
  {
    return $this;
  }

  /**
  *
  * @return void
  */
  protected function _initSelect()
  {
    parent::_initSelect();

    // $productNameAttribute= $this->attributeinfo->loadByCode(\Magento\Catalog\Model\Product::ENTITY, \Magento\Catalog\Api\Data\ProductInterface::NAME);
    // $productNameAttributeId = $productNameAttribute->getAttributeId();
    $productNameAttributeId = 73;
    $this->getSelect()->join(
      [
        'product_varchar' => $this->getTable('catalog_product_entity_varchar')
      ],
      "product_varchar.entity_id = main_table.product_id AND product_varchar.attribute_id={$productNameAttributeId}",
      []
      )->columns(['product_name' => 'product_varchar.value']);

      // $this->getSelect()->join(
      //   [
      //     'product_alert' => $this->getTable('product_alert_stock')
      //   ],
      //   "product_alert.product_id = main_table.product_id AND product_alert.customer_id =main_table.customer_id",
      //   []
      //   )->columns(['product_add_date' => 'product_alert.add_date']);


        $this->getSelect()->join(
          ['customer' => $this->getTable('customer_entity')],
          "customer.entity_id = main_table.customer_id ",
          []
          )->columns(['customer_name' => 'customer.firstname','customer_email' => 'customer.email']);

          $this->getSelect()->join(
            [
              'product' => $this->getTable('catalog_product_entity')
            ],
            "product.entity_id = main_table.product_id ",
            []
            )->columns(['product_sku' => 'product.sku']);

        }
      }
