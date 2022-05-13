<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Nagarro\SmsNotification\Model\SmsNotification\Source;

/**
 * Source model for element with enable and disable variants.
 * @api
 * @since 100.0.2
 */
class OTPLength implements \Magento\Framework\Option\ArrayInterface
{
    const VALUE_3 = 3;
    const VALUE_4 = 4;
    const VALUE_5 = 5;
    const VALUE_6 = 6;
    const VALUE_7 = 7;
    const VALUE_8 = 8;
    const VALUE_9 = 9;
    const VALUE_10 = 10;


    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::VALUE_3, 'label' => __('3')],
            ['value' => self::VALUE_4, 'label' => __('4')],
            ['value' => self::VALUE_5, 'label' => __('5')],
            ['value' => self::VALUE_6, 'label' => __('6')],
            ['value' => self::VALUE_7, 'label' => __('7')],
            ['value' => self::VALUE_8, 'label' => __('8')],
            ['value' => self::VALUE_9, 'label' => __('9')],
            ['value' => self::VALUE_10, 'label' => __('10')],

        ];
    }
}
