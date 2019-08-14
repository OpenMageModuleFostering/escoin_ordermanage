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
class Escoin_Ordermanage_Model_Observer
{
    const SALES_ORDER_GRID_NAME = 'sales_order_grid';
    
    public function addOptionToDelete($observer)
    {
        if (self::SALES_ORDER_GRID_NAME == $observer->getEvent()->getBlock()->getId()) {
            $massBlock = $observer->getEvent()->getBlock()->getMassactionBlock();
            if ($massBlock) {
                $massBlock->addItem('escoin_delete_order', array(
                    'label'=> Mage::helper('core')->__('Delete'),
                    'url'  => Mage::helper('adminhtml')->getUrl("adminhtml/ordermanage_order/delete"),
                    'confirm' => Mage::helper('core')->__('Are you sure to delete the selected orders?'),
                ));
            }
        }
    }
    
    public function deleteOrderFromGrid($observer)
    {
        //-- Delete the orders from the sales_order_grid table if not automatically done by the system --//
        $order = $observer->getOrder();
        if ($order->getId()) {
            $coreResource = Mage::getSingleton('core/resource');
            $writeConnection = $coreResource->getConnection('core_write');
            $salesOrderGridTable = $coreResource->getTableName('sales_flat_order_grid');
            $query = sprintf('Delete from %s where entity_id = %s', $salesOrderGridTable, (int)$order->getId());
            $writeConnection->raw_query($query);
        }
    }
}
