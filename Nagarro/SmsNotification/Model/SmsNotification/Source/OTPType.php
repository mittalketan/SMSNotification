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
class OTPType implements \Magento\Framework\Option\ArrayInterface
{
    const Numeric_VALUE = 'Numeric';
    const AlphaNumeric_VALUE = 'AlphaNumeric';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::Numeric_VALUE, 'label' => __('Numeric')],
            ['value' => self::AlphaNumeric_VALUE, 'label' => __('Alpha Numeric')],
        ];
    }
}
