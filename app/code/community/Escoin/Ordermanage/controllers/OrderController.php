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
 * @package     Escoin_Ordermanage
 * @copyright   Copyright (c) 2014
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Escoin_Ordermanage_Order controller
 */
class Escoin_Ordermanage_OrderController extends Mage_Core_Controller_Front_Action
{


    /**
     * Handles cancel order action
     */
    public function cancelAction()
    {
        $orderId = $this->getRequest()->get('order_id');

     
        //var_dump(Mage_Sales_Model_Order::STATE_CANCELLED);die;
        // Load order
        if(!empty($orderId)) {
            //$comment = "Order {$orderId} has been cancelled by user.";
            $comment = "";
            $state = 'customer_cancelled';
            $status = 'customer_cancelled';
            $isCustomerNotified = true;


            $order = Mage::getModel('sales/order')->load($orderId);
            //$order->setState(Mage_Sales_Model_Order::STATE_CUSTOMER_CANCELLED, true);
            $order->setState($state, $status, $comment, $isCustomerNotified);
            $order->sendOrderUpdateEmail(true, $comment);
            $order->save();
            Mage::getSingleton('core/session')->addSuccess($this->__("Order was successfully cancelled."));
        }
        
        // Redirect back to orders list
        $this->_redirect('sales/order/history/');
    }
}
