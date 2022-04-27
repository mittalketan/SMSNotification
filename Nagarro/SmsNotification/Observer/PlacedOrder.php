<?php

namespace Nagarro\SmsNotification\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\StoreManagerInterface;
use Nagarro\SmsNotification\Helper\Data as Helper;

class PlacedOrder implements ObserverInterface
{
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $_logLoggerInterface;
    protected $storeManager;
    protected $helper;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface,
        StoreManagerInterface $storeManager,
        Helper $helper

    ) {
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        $this->messageManager = $context->getMessageManager();
        $this->storeManager = $storeManager;
        $this->helper = $helper;
    }

    public function execute(Observer $observer)
    {

        dump($observer);
        die;

        return $this;
    }
}
