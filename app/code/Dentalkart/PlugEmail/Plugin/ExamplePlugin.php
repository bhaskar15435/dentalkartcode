<?php
namespace Dentalkart\PlugEmail\Plugin;

class ExamplePlugin
{
   // protected $logger;

   // public function __construct(\Psr\Log\LoggerInterface $logger)
   // {
   //    $this->logger = $logger;
   // }

   public function afterregisterProductsSale(\Magento\CatalogInventory\Model\StockManagement $subject, $items)
   {
	    $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/xyz.log');
	  	$logger = new \Zend\Log\Logger();
	  	$logger->addWriter($writer);
	   	$logger->info('foobar');
      // $arr=[1,2,3];
   		// foreach($items as $stockItem){
			// $this->logger->info($stockItem->getProductId());
		    return $items;
	}
}
