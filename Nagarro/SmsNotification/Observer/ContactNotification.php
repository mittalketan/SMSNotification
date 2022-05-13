<?php

namespace Nagarro\SmsNotification\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Nagarro\SmsNotification\Helper\Data as Helper;
use Nagarro\SmsNotification\Helper\SendSMS as SendSMSHelper;
use Nagarro\SmsNotification\Helper\MessageParser as MessageParser;
use Magento\Framework\App\Request\Http;

class ContactNotification implements ObserverInterface
{
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $_logLoggerInterface;
    protected $storeManager;
    protected $helper;
    protected $sendSMSHelper;
    protected $messageParser;
    protected $request;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface,
        Helper $helper,
        SendSMSHelper $sendSMSHelper,
        MessageParser $messageParser,
        Http $request

    ) {
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        $this->messageManager = $context->getMessageManager();
        $this->helper = $helper;
        $this->sendSMSHelper = $sendSMSHelper;
        $this->messageParser = $messageParser;
        $this->request = $request;
    }

    public function execute(EventObserver $observer)
    {
        if (!$this->helper->isExtensionActive())
            return;

        $adminMessage = $this->helper->getAdminMessage('ContactNotification');
        if ($adminMessage['enable']) {
            $message =  $this->messageParser->parseMessage($adminMessage['message']);
            $this->sendSMSHelper->sendSmstoAdmin($message);
        }
        $mobilenumber = isset($this->request->getParams()['telephone']) ? $this->request->getParams()['telephone'] : '+919654069449';

        $userMessage = $this->helper->getUserMessage('ContactNotification');
        if ($userMessage['enable']) {
            $message =  $this->messageParser->parseMessage($userMessage['message']);
            $this->sendSMSHelper->sendSms($mobilenumber, $message);
        }
    }
}
