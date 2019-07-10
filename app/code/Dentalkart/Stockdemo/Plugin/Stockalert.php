<?php
namespace Dentalkart\Stockdemo\Plugin;

/**
 *
 */
class Stockalert
{

  protected $stockFactory;

  function __construct(\Magento\ProductAlert\Model\StockFactory $stockFactory
  )
  {
    $this->stockFactory=$stockFactory;
  }

  public function afterresolve(\Dentalkart\PricealertGraphQl\Model\Resolver\Customeralert $subject,$return,
          $field,
          $context,
          $info,
          $value = null,
          $args = null){

    $model=$this->stockFactory->create()->getcollection();
    $productid=$args['productid'];
    $count=0;
    $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/xyz.log');
    $logger = new \Zend\Log\Logger();
    $logger->addWriter($writer);


  foreach($model->getData() as $id){

    if($id['product_id']==$productid){
      if(is_null($id['send_date']))
      {
        $count+=1;
      }
      elseif(strtotime($id['add_date'])>strtotime($id['send_date'])){

        $count+=1;
      }
    }
  }

  $logger->info($count);

  return $return;
  }
}

 ?>
