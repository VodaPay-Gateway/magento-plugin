<?php

namespace VodaPay\VodaPay\Model\Config;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class PaymentAction
 */
class VodaPayPaymentAction implements OptionSourceInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => "AUTH",
                'label' => __('Authorize'),
            ],
            [
                'value' => "SALE",
                'label' => __('Sale'),
            ],
            [
                'value' => "PURCHASE",
                'label' => __('Purchase'),
            ]
        ];
    }
}
