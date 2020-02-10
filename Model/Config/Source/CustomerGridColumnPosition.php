<?php

namespace MagedIn\LoginAsCustomer\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class CustomerGridColumnPosition
 *
 * @package MagedIn\LoginAsCustomer\Model\Config\Source
 */
class CustomerGridColumnPosition implements OptionSourceInterface
{
    /**
     * @return array
     */
    public function toOptionArray() : array
    {
        $result = [];

        foreach ($this->toArray() as $key => $value) {
            $result[] = [
                'value' => $key,
                'label' => $value
            ];
        }

        return $result;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'actions' => __('In Actions Column'),
            'new'     => __('In New Column')
        ];
    }
}
