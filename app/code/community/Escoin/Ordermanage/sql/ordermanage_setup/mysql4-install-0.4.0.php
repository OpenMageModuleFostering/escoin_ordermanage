<?php 

$installer = $this;
$installer->startSetup();
 
// $installer->addAttribute(
//     'order',
//     'is_cancelled',
//     array(
//         'type' => 'int',
//         'default' => 0,
//         'grid' => true,
//         'unsigned'  => true,
//     )
// );


// Required tables
$statusTable = $installer->getTable('sales/order_status');
$statusStateTable = $installer->getTable('sales/order_status_state');
 
// Insert statuses
$installer->getConnection()->insertArray(
    $statusTable,
    array(
        'status',
        'label'
    ),
    array(

        array('status' => 'customer_cancelled', 'label' => 'Cancelled By Customer')
    )
);
 
// Insert states and mapping of statuses to states
$installer->getConnection()->insertArray(
    $statusStateTable,
    array(
        'status',
        'state',
        'is_default',
        //'visible_on_front'
    ),
    array(
        array(
            'status' => 'customer_cancelled',
            'state' => 'customer_cancelled',
            'is_default' => 1,
            //'visible_on_front' => 1

        ),
    )
);


 
$installer->endSetup();