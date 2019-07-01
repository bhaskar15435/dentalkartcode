<?php
namespace Dentalkart\Stockalert\Ui\Component\Listing\Column;

class Status implements \Magento\Framework\Option\ArrayInterface
{


    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('email has send')],
            ['value' => 0, 'label' => __('email not send')]
        ];
    }
}
