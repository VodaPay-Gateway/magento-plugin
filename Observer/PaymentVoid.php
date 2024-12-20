<?php

namespace VodaPay\VodaPay\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Creditmemo;
use Magento\Sales\Model\Order\Invoice;
use VodaPay\VodaPay\Controller\VodaPay\Payment;
use Psr\Log\LoggerInterface;
use VodaPay\VodaPay\Model\CoreFactory;

class PaymentVoid implements ObserverInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private LoggerInterface $logger;
    /**
     * @var \VodaPay\VodaPay\Model\CoreFactory
     */
    private CoreFactory $coreFactory;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param \VodaPay\VodaPay\Model\CoreFactory $coreFactory
     */
    public function __construct(LoggerInterface $logger, CoreFactory $coreFactory)
    {
        $this->logger      = $logger;
        $this->coreFactory = $coreFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $data = $observer->getData();

        $payment = $data['payment'];
        $order   = $payment->getOrder();

        $ptid       = $payment->getParentTransactionId();
        $collection = $this->coreFactory->create()
                                        ->getCollection()
                                        ->addFieldToFilter('payment_id', $ptid);

        $orderItem = $collection->getFirstItem();
        $reversed  = $orderItem->getData('state');

        if ($reversed !== 'REVERSED') {
            return;
        }

        $order->setState(Order::STATE_CLOSED);
        $order->setStatus('vodapay_auth_reversed');
        $order->save();
    }
}
