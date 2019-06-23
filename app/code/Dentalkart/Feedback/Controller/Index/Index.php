<?php
namespace Dentalkart\Feedback\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
  protected $_pageFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{
		$this->_pageFactory = $pageFactory;

		return parent::__construct($context);
	}

	public function execute()
	{

	  echo '
    <form action="/magento/feedback/index/submit/" method="POST">
    <table>
         <tr>
            <td>Name:</td>
            <td><input type = "text" name = "name">

            </td>
         </tr>

         <tr>
            <td>E-mail: </td>
            <td><input type = "text" name = "email">

            </td>
         </tr>

         <tr>
            <td>E-message: </td>
            <td><input type = "text" name = "message">

            </td>
         </tr>



         <tr>
            <td>category:</td>
            <td>
                 <input type = "radio" name = "category" value = "product">product
                 <input type = "radio" name = "category" value = "server">server
                  <input type = "radio" name = "category" value = "customer_care">customer_care
                  <input type = "radio" name = "category" value = "delivery">delivery
              </td>
              <tr>
               <td>
                  <input type = "submit" name = "submit" value = "Submit">
               </td>
            </tr>

         </table>
    </form>
    ';
	}
}
