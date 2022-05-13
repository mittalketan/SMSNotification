<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Nagarro\SmsNotification\Controller\Adminhtml\Shipment;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Exception\InputException;
use Magento\Sales\Api\ShipmentRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Send action.
 */
class Send extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Nagarro_SmsNotification::SMS';

    /** @var \Magento\Sales\Api\ShipmentRepositoryInterface */
    protected $_shipmentRepository;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ShipmentRepositoryInterface $shipmentRepository,
        DataPersistorInterface $dataPersistor = null
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_shipmentRepository = $shipmentRepository;
        $this->dataPersistor = $dataPersistor ?: ObjectManager::getInstance()->get(DataPersistorInterface::class);
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $shipment = $this->_initShipment();

        if ($shipment) {
            $resultRedirect = $this->resultRedirectFactory->create()->setPath(
                'sales/shipment/view',
                ['shipment_id' => $shipment->getEntityId()]
            );



            return $resultRedirect;
        }

        return $this->resultRedirectFactory->create()->setPath('sales/shipment/*');
    }

    /**
     * @return false|\Magento\Sales\Model\Order\Shipment
     */
    public function _initShipment()
    {
        $id = $this->getRequest()->getParam('id');
        try {
            $shipment = $this->_shipmentRepository->get($id);
        } catch (NoSuchEntityException $e) {
            // $this->messageManager->addErrorMessage(__('This shipment no longer exists.'));
            return false;
        } catch (InputException $e) {
            // $this->messageManager->addErrorMessage(__('This shipment no longer exists.'));
            return false;
        }

        return $shipment;
    }
}
