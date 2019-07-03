<?php
namespace Dentalkart\Stockfilter\Ui\Component\Listing\Column;

class Status implements \Magento\Framework\Option\ArrayInterface
{


    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('In Stock')],
            ['value' => 0, 'label' => __('Out Of Stock')]
        ];
    }
}
