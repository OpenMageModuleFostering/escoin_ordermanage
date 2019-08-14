<?php
/**
 * Escoin_Ordermanage extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category    Escoin
 * @package   Escoin_Ordermanage
 * @copyright   Copyright (c) 2014
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 */

require_once 'Mage/Adminhtml/controllers/Sales/OrderController.php';

class Escoin_Ordermanage_Adminhtml_Ordermanage_OrderController extends Mage_Adminhtml_Sales_OrderController
{
    public function deleteAction()
    {


        $orderIds = $this->getRequest()->getPost('order_ids', array());
        $deletedOrders = 0;
        if ($orderIds) {
            foreach ($orderIds as $orderId) {
                $order = Mage::getModel('sales/order')->load($orderId);
                $transactionContainer = Mage::getModel('core/resource_transaction');
                if ($order->getId()) {
                    $deletedOrders++;
                    // add invoices to delete
                    if ($order->hasInvoices()){
                      $invoices = Mage::getResourceModel('sales/order_invoice_collection')->setOrderFilter($orderId)->load();
                      if ($invoices) {
                          foreach ($invoices as $invoice){
                              $invoice = Mage::getModel('sales/order_invoice')->load($invoice->getId());
                              $transactionContainer->addObject($invoice);
                          }
                      }
                   }
                   
                   // add shipments to delete
                   if ($order->hasShipments()){
                       $shipments = Mage::getResourceModel('sales/order_shipment_collection')->setOrderFilter($orderId)->load();
                       foreach ($shipments as $shipment){
                           $shipment = Mage::getModel('sales/order_shipment')->load($shipment->getId());
                           $transactionContainer->addObject($shipment);
                       }
                   }
                   //delete
                   $transactionContainer->addObject($order)->delete();
                }
            }
        }
        
        if ($deletedOrders) {

            $val = ($deletedOrders > 1)?'were':'was';
            $this->_getSession()->addSuccess($this->__('%s order(s) %s successfully deleted.', $deletedOrders,$val));
        }
        $this->_redirect('adminhtml/sales_order/', array());
    }
}
