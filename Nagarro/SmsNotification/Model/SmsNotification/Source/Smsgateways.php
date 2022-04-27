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
class Smsgateways implements \Magento\Framework\Option\ArrayInterface
{
    const BULKSMS_VALUE = 'bulksms';
    const TEXTLOCAL_VALUE = 'textlocal';
    const Twilio_VALUE = 'twilio';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::BULKSMS_VALUE, 'label' => __('Bulksms')],
            ['value' => self::TEXTLOCAL_VALUE, 'label' => __('Textlocal')],
            ['value' => self::Twilio_VALUE, 'label' => __('Twilio')],
        ];
    }
}
