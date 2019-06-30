<?php

namespace Dentalkart\Lowstocknotify\Plugin;
use Magento\Framework\Api\ExtensibleDataInterface;

class notifier
{
  const XML_PATH_NOTIFY_THRESHOLD_QYT='cataloginventory/item_options/notify_stock_qty';
  const XML_PATH_EMAIL_RECIPIENT = 'cataloginventory/item_options/notification_email';

  protected $scopeConfig;

  protected $item;

  protected $transportBuilder;

  protected $storeManager;

  protected $_productRepository;

  protected $stockRegistryInterface;

  public function __construct(
    \Magento\Catalog\Model\ProductRepository $productRepository,
    \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    \Magento\Store\Model\StoreManagerInterface $storeManager,
    \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistryInterface,
    \Magento\Framework\App\Config\Storage\WriterInterface $configWriter,
    //\Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistryInterface,
    \Magento\Framework\Stdlib\DateTime\DateTime $datetime
    )
    {
      $this->_productRepository = $productRepository;
      $this->scopeConfig = $scopeConfig;
      $this->stockRegistryInterface=$stockRegistryInterface;
      $this->_transportBuilder = $transportBuilder;
      $this->storeManager = $storeManager;
      $this->configWriter=$configWriter;
      //$this->stockRegistryInterface=$stockRegistryInterface;
      $this->datetime=$datetime;
    }

    public function afterregisterProductsSale(\Magento\CatalogInventory\Api\RegisterProductSaleInterface $subject ,$return,$items)
    {

      $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
      $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/xyz.log');
      $logger = new \Zend\Log\Logger();
      $logger->addWriter($writer);
      foreach($items as $productid => $requestvalue){
        $Qty=$this->stockRegistryInterface->getStockItem($productid)->getQty();
        $thresholdqyt=$this->scopeConfig->getValue(self::XML_PATH_NOTIFY_THRESHOLD_QYT,$storeScope);
        $productname=$this->_productRepository->getById($productid)->getName();
        $model=$this->stockRegistryInterface->getStockItem($productid);
        $model->load($productid);
        $notify=$model->getLowStockDate();

        if($Qty<=$thresholdqyt && $notify==NULL){
          $model->setLowStockDate($this->datetime->gmtDate());
          $model->save();
          $sender = [
            'name' => "bhaskar",
            'email' => "bhaskar@dentalkart.com",
          ];

          $emails=$this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope);
          $emailarray=explode(',',$emails);
          $post=array('name' => 'bhaskar','email' =>'bhaskar@dentalkart.com','test' => 'product with productid '.$productid.
          ' and productname '.$productname. ' is below the threshold quantity.');
          foreach($emailarray as $email){
            $postObject=new \Magento\Framework\DataObject();
            $postObject->setData($post);
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
              $logger->info($model->getLowStockDate());

            }
          }

          elseif($Qty>$thresholdqyt && $notify==$model->getLowStockDate()){
            $model->setLowStockDate(NULL);
            $model->save();
            $logger->info($model->getLowStockDate());
          }

          else{
            $logger->info('chill mar');
          }

        }
        return $return;
      }
    }
    ?>
