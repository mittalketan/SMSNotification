<?php

namespace Nagarro\SmsNotification\Model\SMSGateway;

use Twilio\Rest\ClientFactory;
use Psr\Log\LoggerInterface;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Twilio
{
    const TWILIO_ACCOUNT_SID = 'SmsNotification/smsgateways/TwilioAccountSID';
    const TWILIO_AUTH_TOKEN = 'SmsNotification/smsgateways/TwilioAuthToken';
    const TWILIO_MOBILE_NUMBER = 'SmsNotification/smsgateways/TwilioMobiloNumber';

    /** @var ClientFactory */
    private $clientFactory;

    /** @var LoggerInterface */
    private $logger;

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /** @var EncryptorInterface */
    private $encryptor;

    /**
     * SendOrderNotification constructor.
     * @param ClientFactory $clientFactory
     * @param LoggerInterface $logger
     * @param ScopeConfigInterface $scopeConfig
     * @param EncryptorInterface $encryptor
     */
    public function __construct(
        ClientFactory $clientFactory,
        LoggerInterface $logger,
        ScopeConfigInterface $scopeConfig,
        EncryptorInterface $encryptor
    ) {
        $this->clientFactory = $clientFactory;
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
        $this->encryptor = $encryptor;
    }

    private function getTwilioAccountSID($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::TWILIO_ACCOUNT_SID,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    private function getTwilioAuthToken($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::TWILIO_AUTH_TOKEN,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    private function getTwilioMobiloNumber($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::TWILIO_MOBILE_NUMBER,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    private function getClient($username, $password)
    {
        return $this->clientFactory->create([
            'username' => $username,
            'password' => $password,
        ]);
    }

    public function sendSMS($to, $message)
    {
        $twilioAuthToken = $this->getTwilioAuthToken();
        $twilioAccountSID = $this->getTwilioAccountSID();
        $twilioMobiloNumber = $this->getTwilioMobiloNumber();

        if (is_null($twilioAuthToken) || is_null($twilioAccountSID) || is_null($twilioMobiloNumber))
            return;

        $client = $this->getClient($twilioAccountSID, $twilioAuthToken);

        $params = [
            'from' => $twilioMobiloNumber,
            'body' => $message,
        ];

        try {
            $message =  $client->messages->create($to, $params);
            return $message->sid;
        } catch (\Exception $e) {
            $this->logger->critical('Error message', ['exception' => $e]);
            return $e->getMessage();
        }
    }
}
