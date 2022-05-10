<?php

namespace Nagarro\SmsNotification\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Nagarro\SmsNotification\Helper\Data as Helper;
use Nagarro\SmsNotification\Helper\SendSMS as SendSMSHelper;
use Nagarro\SmsNotification\Helper\MessageParser as MessageParser;

class CreditMemoGenerated implements ObserverInterface
{
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $_logLoggerInterface;
    protected $storeManager;
    protected $helper;
    protected $sendSMSHelper;
    protected $messageParser;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface,
        Helper $helper,
        SendSMSHelper $sendSMSHelper,
        MessageParser $messageParser

    ) {
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        $this->messageManager = $context->getMessageManager();
        $this->helper = $helper;
        $this->sendSMSHelper = $sendSMSHelper;
        $this->messageParser = $messageParser;
    }

    public function execute(EventObserver $observer)
    {
        if (!$this->helper->isExtensionActive())
            return;

        $adminMessage = $this->helper->getAdminMessage('CreditMemoNotification');
        if ($adminMessage['enable']) {
            $message =  $this->messageParser->parseMessage($adminMessage['message']);
            $this->sendSMSHelper->sendSmstoAdmin($message);
        }

        $userMessage = $this->helper->getUserMessage('CreditMemoNotification');
        if ($userMessage['enable']) {
            $message =  $this->messageParser->parseMessage($adminMessage['message']);
            $this->sendSMSHelper->sendSms('+919654069449', $message);
        }


        //dump($adminMessage);
        //$invoice = $observer->getEvent()->getInvoice();
        //$order = $invoice->getOrder();

       // dump($observer);
        // dump($smsGateway);

       // dump($order);
       // dump($invoice);
       // die;
    }
}
