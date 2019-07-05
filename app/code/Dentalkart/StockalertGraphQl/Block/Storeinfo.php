<?php
namespace Dentalkart\StockalertGraphQl\Block;

class Storeinfo extends \Magento\Framework\View\Element\Template
{

  public $storeManager;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * @return Store
     */
    public function getStore()
    {
        return $this->storeManager->getStore();
    }
  }
