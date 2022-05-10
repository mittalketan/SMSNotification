<?php

namespace Nagarro\SmsNotification\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Nagarro\SmsNotification\Model\SmsNotification\Source\SmsGateways;
use Nagarro\SmsNotification\Helper\Data as Helper;

class SendSMS extends AbstractHelper
{

    private $twilioGateway;
    private $bulkGateway;
    private $textlocalGateway;
    protected $helper;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Nagarro\SmsNotification\Model\SMSGateway\Twilio $twilio,
        \Nagarro\SmsNotification\Model\SMSGateway\BulkSms $bulkSms,
        \Nagarro\SmsNotification\Model\SMSGateway\TextLocal $textlocal,
        Helper $helper

    ) {
        parent::__construct($context);
        $this->twilioGateway = $twilio;
        $this->bulkGateway = $bulkSms;
        $this->textlocalGateway = $textlocal;
        $this->helper = $helper;
    }

    private function getGatewayConfig()
    {
        return $this->helper->getActiveGateway();
    }

    public function sendSms($to, $message)
    {
        $config = $this->getGatewayConfig();

        if ($config == SmsGateways::Twilio_VALUE) {
            $this->twilioGateway->sendSMS($to, $message);
        }
    }

    public function sendSmstoAdmin($message)
    {
        $to = $this->helper->getAdminPhoneNumber();
        $config = $this->getGatewayConfig();

        if ($config == SmsGateways::Twilio_VALUE) {
            $this->twilioGateway->sendSMS($to, $message);
        }
    }
}
