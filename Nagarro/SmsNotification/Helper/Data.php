<?php

namespace Nagarro\SmsNotification\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    /**
     * @var Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $_timezoneInterface;
    const XML_PATH_HELLOWORLD = 'appointment/';

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        //time zone interface
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface
    ) {
        $this->_timezoneInterface = $timezoneInterface;
        parent::__construct($context);
    }

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getGeneralConfig($code, $storeId = null)
    {

        return $this->getConfigValue(self::XML_PATH_HELLOWORLD . 'general/' . $code, $storeId);
    }



    /**
     * @param string $dateTime
     * @return string $dateTime as time zone
     */
    public function getTimeAccordingToTimeZone($dateTime = null)
    {
        // for get current time according to time zone
        if (is_null($dateTime))
            return $this->_timezoneInterface->date();

        // for convert date time according to magento time zone
        $dateTimeAsTimeZone = $this->_timezoneInterface
            ->date(new \DateTime($dateTime));
        // ->format('m/d/y H:i:s');
        return $dateTimeAsTimeZone;
    }
}
