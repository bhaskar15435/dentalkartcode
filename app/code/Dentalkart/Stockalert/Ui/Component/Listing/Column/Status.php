<?php
namespace Dentalkart\Stockalert\Ui\Component\Listing\Column;

class Status implements \Magento\Framework\Option\ArrayInterface
{


    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Email Has Send')],
            ['value' => 0, 'label' => __('Email Has Not Send')]
        ];
    }
}
