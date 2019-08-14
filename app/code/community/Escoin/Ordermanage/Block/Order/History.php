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
 * @category   	Escoin
 * @package		Escoin_Ordermanage
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */


/**
 * Orders history block
 *
 * @author Escoin <sales@espot.co.in>
 * @see Mage_Sales_Block_Order_History
 */
class Escoin_Ordermanage_Block_Order_History extends Mage_Sales_Block_Order_History
{
    public function __construct()
    {
        parent::__construct();
        
        // Replace default template
        $this->setTemplate('escoin_ordermanage/sales/order/history.phtml');
    }

}
