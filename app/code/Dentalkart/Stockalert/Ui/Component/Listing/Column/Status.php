<?php
namespace Dentalkart\Stockalert\Ui\Component\Listing\Column;

class Status implements \Magento\Framework\Option\ArrayInterface
{


    public function toOptionArray()
    {
        return [
            ['value' => 2, 'label' => __('A')],
            ['value' => 1, 'label' => __('B')]
        ];
    }
}
