<?php
/**
* Copyright © 2015 Emizentech. All rights reserved.
*/

namespace Emizentech\ShopByBrand\Controller\Adminhtml\Items;

use Emizentech\ShopByBrand\Model\Items;

class NewAction extends \Emizentech\ShopByBrand\Controller\Adminhtml\Items
{
  /**
  * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory
  */
  protected $_attrOptionCollectionFactory;

  protected  $registry;
  protected $categoryCollectionFactory;

  //    public function __construct(
  //        \Magento\Backend\App\Action\Context $context,
  //        \Magento\Framework\Registry $registry,
  //        \Magento\Backend\Model\View\Result\ForwardFactory $ForwardFactory ,
  //        \Magento\Framework\View\Result\PageFactory $PF,
  //     	\Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory,
  //         array $data = []
  //     ) {
  //         parent::__construct($context, $data);
  //         $this->_attrOptionCollectionFactory = $attrOptionCollectionFactory;
  //
  //     }

  public function __construct(
    \Magento\Backend\App\Action\Context $context,
    \Magento\Framework\Registry $coreRegistry,
    \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
    \Magento\Framework\View\Result\PageFactory $resultPageFactory,
    \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
    array $data=[]
  ) {
    $this->_coreRegistry = $coreRegistry;
    parent::__construct($context,$coreRegistry,$resultForwardFactory,$resultPageFactory);
    $this->resultForwardFactory = $resultForwardFactory;
    $this->resultPageFactory = $resultPageFactory;
    $this->categoryCollectionFactory=$categoryCollectionFactory;
  }

  public function execute()
  {
    //         $this->_forward('edit');
    $model = $this->_objectManager->create(
      'Magento\Catalog\Model\ResourceModel\Eav\Attribute'
      )->setEntityTypeId(
        \Magento\Catalog\Model\Product::ENTITY
      );

      $model->loadByCode(\Magento\Catalog\Model\Product::ENTITY,'manufacturer');
      $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/xyz.log');
      $logger = new \Zend\Log\Logger();
      $logger->addWriter($writer);
      $logger->info('hey hoo');
      // $category=$this->collectionFactory->create()->getcollection();

      //         echo "<pre>";
      //         var_dump(get_class_methods($model));
      foreach($model->getOptions() as $option){
        //var_dump($option->debug());
        $category=$this->categoryCollectionFactory->create()
          ->addAttributeToSelect('url_key')
          ->addAttributeToFilter('name',$option->getLabel())->getFirstItem();
          // throw new \Exception($category->getData());
        $item = $this->_objectManager->create('Emizentech\ShopByBrand\Model\Items');
        if($option->getValue()){
          $id = (int)$option->getValue();
          if ($id) {
            $item->load($id);
            if ($id != $item->getId()) {
              //                         throw new \Magento\Framework\Exception\LocalizedException(__('The wrong item is specified.'));
            }
          }

          $data = array(
            'name' => $option->getLabel(),
            'attribute_id' => $option->getValue(),
            'is_active' => 1,
            'url_key'=>$category->getUrlKey(),
            'category_id'=>$category->getId()
          );
          $item->setData($data);
          // 				var_dump($item->debug());
          try{
            $item->save();
          }
          catch(\Exception $e){

          }
          // 				var_dump($item->debug());
          // 				die;

        }
      }
      $this->messageManager->addSuccess(__('All Brands Re-Synced'));
      $this->_redirect('emizentech_shopbybrand/*/');

    }
  }
