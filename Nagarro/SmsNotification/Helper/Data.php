<?php

namespace Nagarro\SmsNotification\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Nagarro\SmsNotification\Model\SmsNotification\Source\SmsGateways;

class Data extends AbstractHelper
{
    const XML_PATH_EXTENSION_SMSNOIFICATION = 'SmsNotification/';
    const XML_PATH_EXTENSION_ADMINTEMPLATE = 'AdminTemplates/';
    const XML_PATH_EXTENSION_USERTEMPLATE = 'UserTemplates/';
    protected $_customerRepository;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
    ) {
        parent::__construct($context);
        $this->_customerRepository = $customerRepository;
    }

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getGeneralConfig($grp = 'general/', $code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_EXTENSION_SMSNOIFICATION . $grp . $code, $storeId);
    }

    public function getGeneralConfigForSMSNotification($grp = 'general/', $code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_EXTENSION_SMSNOIFICATION . $grp . $code, $storeId);
    }

    public function getGeneralConfigForAdminTemplate($grp, $code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_EXTENSION_ADMINTEMPLATE . $grp . $code, $storeId);
    }

    public function getGeneralConfigForUserTemplate($grp, $code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_EXTENSION_USERTEMPLATE . $grp . $code, $storeId);
    }

    /**
     * isExtensionActive function
     *
     * @return boolean
     */
    public function isExtensionActive()
    {
        return (bool) $this->getGeneralConfigForSMSNotification('general/', 'enable');
    }

    /**
     * getActiveGateway function
     *
     * @return array
     */
    public function getActiveGateway()
    {
        return $this->getGeneralConfigForSMSNotification('smsgateways/', 'gateway');
    }

    public function getAdminPhoneNumber()
    {
        return $this->getGeneralConfigForAdminTemplate('adminGeneral/', 'MobileNumber');
    }


    public function getAdminMessage($group)
    {
        $group = $group . '/';
        $return = [];
        $return['enable'] = (bool) $this->getGeneralConfigForAdminTemplate($group, 'Enable');
        if ($return['enable']) {
            $return['message'] = $this->getGeneralConfigForAdminTemplate($group, 'MessageText');
        }
        return $return;
    }

    public function getUserMessage($group)
    {
        $group = $group . '/';
        $return = [];
        $return['enable'] = (bool) $this->getGeneralConfigForUserTemplate($group, 'Enable');
        if ($return['enable']) {
            $return['message'] = $this->getGeneralConfigForUserTemplate($group, 'MessageText');
        }
        return $return;
    }

    public function getCustomerMobile($order)
    {   
        if($order && $order->getShippingAddress())
        return $order->getShippingAddress()->getData()['telephone'];
        else
        return '+919654069449';
    }
}
