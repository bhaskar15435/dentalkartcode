<?php
namespace Dentalkart\Feedback\Block\Index;
class View extends \Magento\Framework\View\Element\Template
{
  /*  public function getText(){
      return "Hello World!";
    }
    */
    protected $_postFactory;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Dentalkart\Feedback\Model\PostFactory $postFactory
	)
	{
		$this->_postFactory = $postFactory;
		parent::__construct($context);
	}

	public function sayHello()
	{
		return __('Hello World');
	}

	public function getPostCollection(){
		$post = $this->_postFactory->create();
		return $post->getCollection();
	}
}
?>
