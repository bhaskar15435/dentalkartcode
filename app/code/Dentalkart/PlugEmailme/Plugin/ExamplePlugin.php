<?php
namespace Dentalkart\PlugEmailme\Plugin;

class ExamplePlugin
{
  const XML_PATH_EMAIL_RECIPIENT = 'cataloginventory/item_options/notification_email';

  protected $_transportBuilder;

  protected $inlineTranslation;

  protected $scopeConfig;

  public function __construct(
    \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
    \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
  ) {
    $this->_transportBuilder = $transportBuilder;
    $this->inlineTranslation = $inlineTranslation;
    $this->scopeConfig = $scopeConfig;
  }

  public function afterverifyNotification(Magento\CatalogInventory\Api\StockStateInterface $subject, $productId)
  {
    $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/xyz.log');
    $logger = new \Zend\Log\Logger();
    $logger->addWriter($writer);
    $logger->info('foobar');

    $sender = [
      'name' => "bhaskar",
      'email' => "bhaskar@dentalkart.com",
    ];
    $postObject=['name' => 'bhaskar','email' =>'bhaskar@dentalkart.com','test' => 'product with '.$productId.' is below the threshold quantity.'];
    $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
    $transport = $this->_transportBuilder
    ->setTemplateIdentifier('send_email_email_template') // this code we have mentioned in the email_templates.xml
    ->setTemplateOptions(
      (
        [
          'area' => \Magento\Framework\App\Area::AREA_ADMINHTML, // this is using frontend area to get the template file
          'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
        ]
        )
        ->setTemplateVars(['data' => $postObject])
        ->setFrom($sender)
        ->addTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope))
        ->getTransport() );

        $transport->sendMessage();
        //$this->inlineTranslation->resume();
        // $this->messageManager->addSuccess(
        // __('product with '.''.$productId.' is below the threshold quantity.')
        // );

        // foreach($items as $stockItem){
        //$this->logger->info($stockItem->getProductId());

      return $productId;
    }
}
    ?>
