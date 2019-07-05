<?php
namespace Dentalkart\StockalertGraphQl\Block;

class StoreInfo extends \Magento\Framework\View\Element\Template
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->_storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * @return Store
     */
    public function getStore()
    {
        return $this->_storeManager->getStore();
    }
  }
