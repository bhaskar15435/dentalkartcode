<?php
namespace Dentalkart\Stockfilter\Ui\Component\Listing\Column;

class Status implements \Magento\Framework\Option\ArrayInterface
{


    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('in_stock')],
            ['value' => 0, 'label' => __('out_of_stock')]
        ];
    }
}
