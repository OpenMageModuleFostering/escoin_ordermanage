<?php 
class Escoin_Ordermanage_Model_System_Config_Order_State
{

public function toOptionArray()
  {
    return array(
      array('value' => 0, 'label' => Mage::helper('ordermanage')->__('Only cancellable orders')),
      array('value' => 1, 'label' => Mage::helper('ordermanage')->__('All orders')),
    );
  }

}
