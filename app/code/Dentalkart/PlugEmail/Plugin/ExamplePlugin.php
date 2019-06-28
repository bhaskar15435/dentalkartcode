<?php
namespace Dentalkart\PlugEmail\Plugin;
use Magento\InventoryReservationsApi\Model\GetReservationsQuantityInterface;
use Magento\InventorySalesApi\Api\IsProductSalableForRequestedQtyInterface;
use Magento\InventorySalesApi\Model\GetStockItemDataInterface;
use Magento\InventorySalesApi\Api\Data\ProductSalableResultInterface;
// use Magento\InventorySalesApi\Api\Data\ProductSalableResultInterfaceFactory;
// use Magento\InventorySalesApi\Api\Data\ProductSalabilityErrorInterfaceFactory;
use Magento\InventoryConfigurationApi\Api\GetStockItemConfigurationInterface;
use Magento\InventoryConfigurationApi\Api\Data\StockItemConfigurationInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
class ExamplePlugin
{

  const XML_PATH_EMAIL_RECIPIENT = 'cataloginventory/item_options/notification_email';

  const XML_PATH_NOTIFY_THRESHOLD_QYT='cataloginventory/item_options/notify_stock_qty';

  const XML_PATH_CONTROL='cataloginventory/item_options/demo';

  // protected $_transportBuilder;

  // protected $inlineTranslation;
  //
   protected $scopeConfig;

  protected $getStockItemData;

  protected $getReservationsQuantity;

  protected $getStockItemConfiguration;

  protected $stockItemInterface;
  protected $datetime;

  public function __construct(
    \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
    \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    GetStockItemDataInterface $getStockItemData,
    GetReservationsQuantityInterface $getReservationsQuantity,
    \Magento\Framework\App\Config\Storage\WriterInterface $configWriter,
    // GetStockItemConfigurationInterface $getStockItemConfiguration,
    \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistryInterface,
    \Magento\Framework\Stdlib\DateTime\DateTime $datetime
    // ProductSalabilityErrorInterfaceFactory $productSalabilityErrorFactory,
    // ProductSalableResultInterfaceFactory $productSalableResultFactory
  ) {
    $this->_transportBuilder = $transportBuilder;
    // $this->inlineTranslation = $inlineTranslation;
    $this->scopeConfig = $scopeConfig;
    $this->getStockItemData = $getStockItemData;
    $this->getReservationsQuantity = $getReservationsQuantity;
    $this->stockRegistryInterface=$stockRegistryInterface;
    $this->datetime=$datetime;
    $this->configWriter=$configWriter;
    // $this->productSalabilityErrorFactory = $productSalabilityErrorFactory;
    // $this->productSalableResultFactory = $productSalableResultFactory;

  }

  public function afterexecute(\Magento\InventorySalesApi\Api\IsProductSalableForRequestedQtyInterface $subject,  $items, $sku,$stockId,$requestedQty)
  {
    $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
    $stockItemData = $this->getStockItemData->execute($sku, $stockId);
    $qtyWithReservation = $stockItemData[GetStockItemDataInterface::QUANTITY] +
        $this->getReservationsQuantity->execute($sku, $stockId);
    $thresholdqyt=$this->scopeConfig->getValue(self::XML_PATH_NOTIFY_THRESHOLD_QYT,$storeScope);
   // $qtyLeftInStock = $qtyWithReservation - $getStockItemConfiguration->getMinQty() - $requestedQty;
    //$stockItemInterface=$this->stockItemInterface->getLowStockDate();

    //$model1=$this->stockRegistryInterface->getStockItemBySku($sku)->getItemId();
    $model=$this->stockRegistryInterface->getStockItemBySku($sku);
    // // //$model->load($model1);
    // $model->setLowStockDate($this->datetime->gmtDate());
    // //$model->save();
    // $model->setIsInStock((bool)$this->datetime->gmtDate());
    // $this->stockRegistryInterface->updateStockItemBySku($sku, $model);


     $control=$this->scopeConfig->getValue(self::XML_PATH_CONTROL,$storeScope);
    // $model->save();
    $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/xyz.log');
    $logger = new \Zend\Log\Logger();
    $logger->addWriter($writer);
    $logger->info($qtyWithReservation);
    // $logger->info($thresholdqyt);
  // if($thresholdqyt>=$qtyWithReservation && $control=='no'){
  //   $this->configWriter->delete('cataloginventory/item_options/demo',$scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,$scopeId = 0);
  //   $this->configWriter->save('cataloginventory/item_options/demo','yes',$scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,$scopeId = 0);
  //   $control=$this->scopeConfig->getValue(self::XML_PATH_CONTROL,$storeScope);
  //   $logger->info('1'.$control);
  // }
  // elseif($thresholdqyt>=$qtyWithReservation && $control=='yes'){
  //   $logger->info("main hun don");
  //   //$this->configWriter->save('cataloginventory/item_options/demo','',$scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,$scopeId = 0);
  //   $control=$this->scopeConfig->getValue(self::XML_PATH_CONTROL,$storeScope);
  // }
  // elseif ($thresholdqyt<$qtyWithReservation && $control=='no') {
  //   $this->configWriter->delete('cataloginventory/item_options/demo',$scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,$scopeId = 0);
  //   $this->configWriter->save('cataloginventory/item_options/demo','yes',$scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,$scopeId = 0);
  //   $logger->info('2'.$control);
  //   $control=$this->scopeConfig->getValue(self::XML_PATH_CONTROL,$storeScope);
  // }
  //
  // elseif ($qtyWithReservation>$thresholdqyt && $control=='yes') {
  //   $logger->info('3'.$control);
  // }
  // elseif (is_null($control)) {
  //   $this->configWriter->delete('cataloginventory/item_options/demo',$scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,$scopeId = 0);
  //   $this->configWriter->save('cataloginventory/item_options/demo','no',$scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,$scopeId = 0);
  //   $control=$this->scopeConfig->getValue(self::XML_PATH_CONTROL,$storeScope);
  // }
  // else {
  //   $logger->info('4'.$control);
  // }
  //$this->configWriter->delete('cataloginventory/item_options/demo',$scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,$scopeId = 0);
  $this->configWriter->save('cataloginventory/item_options/demo','yes',$scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,$scopeId = 0);

    $sender = [
      'name' => "bhaskar",
      'email' => "bhaskar@dentalkart.com",
     ];

    $emails=$this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope);
    $emailarray=explode(',',$emails);





      foreach($emailarray as $email){
      $postObject=['name' => 'bhaskar','email' =>'bhaskar@dentalkart.com','test' => 'product with '.$sku.' is below the threshold quantity.'];
      $transport = $this->_transportBuilder
      ->setTemplateIdentifier('send_email_email_template') // this code we have mentioned in the email_templates.xml
      ->setTemplateOptions(
          [
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND, // this is using frontend area to get the template file
            'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
          ]
        )
          ->setTemplateVars(['data' => $postObject])
          ->setFrom($sender)
          ->addTo($email)
          ->getTransport();
          $transport->sendMessage();
          $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/xyz.log');
          $logger = new \Zend\Log\Logger();
          $logger->addWriter($writer);
          $logger->info($email);
        }
        return $items;
    }

  }
