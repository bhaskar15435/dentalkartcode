<?php
namespace Dentalkart\Feedback\Controller\Index;

use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\InvalidRequestException;

class Submit extends \Magento\Framework\App\Action\Action implements CsrfAwareActionInterface
{
	protected $_pageFactory;

  protected $postFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
    \Dentalkart\Feedback\Model\PostFactory $postFactory //to take the input from the ResourceModel->Post.php
    )
	{
		$this->_pageFactory = $pageFactory;
    $this->postFactory = $postFactory;
		return parent::__construct($context);
	}

  public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
  {
      return null;
  }

  public function validateForCsrf(RequestInterface $request): ?bool
  {
      return true;
  }

	public function execute()
	{
	   $name = $this->getRequest()->getParam('name');
     echo $name."<br/>";
    $email = $this->getRequest()->getParam('email');
     echo $email."<br/>";
     $message = $this->getRequest()->getParam('message');
     echo $message."<br/>";
     $category = $this->getRequest()->getParam('category');
     $feedbackPost = $this->postFactory->create();//post=class in model and we have made their factory
     $feedbackPost->setData('name', $name)
        ->setData('email', $email)//to set the data
        ->setData('message', $message)
        ->setData('category', $category)
        ->save();//to save the data to the sql table
      echo "Your data has been saved. To view all the feedbacks, click <a href='/magento/feedback/index/view'>Here</a>";
	}
}
