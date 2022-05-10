<?php

namespace Nagarro\SmsNotification\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Nagarro\SmsNotification\Model\SmsNotification\Source\SmsGateways;
use Nagarro\SmsNotification\Helper\Data as Helper;

class MessageParser extends AbstractHelper
{
    protected $helper;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        Helper $helper

    ) {
        parent::__construct($context);
        $this->helper = $helper;
    }

    public function parseMessage($message)
    {
        return $message;
    }
}
