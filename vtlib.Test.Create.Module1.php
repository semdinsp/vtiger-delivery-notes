<?php
// Just a bit of HTML formatting
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';

echo '<html><head><title>vtlib Module Script</title>';
echo '<style type="text/css">@import url("themes/softed/style.css");br { display: block; margin: 2px; }</style>';
echo '</head><body class=small style="font-size: 12px; margin: 2px; padding: 2px;">';
echo '<a href="index.php"><img src="themes/softed/images/vtiger-crm.gif" alt="vtiger CRM" title="vtiger CRM" border=0></a><hr style="height: 1px">';

// Turn on debugging level
$Vtiger_Utils_Log = true;

include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');

// Create module instance and save it first
$module = new Vtiger_Module();
$module->name = 'Deliverynote';
$module->save();

// Initialize all the tables required
$module->initTables();
/**
 * Creates the following table:
 * vtiger_deliverynote  (deliverynoteid INTEGER)
 * vtiger_deliverynotecf(deliverynoteid INTEGER PRIMARY KEY)
 * vtiger_deliverynotegrouprel((deliverynoteid INTEGER PRIMARY KEY, groupname VARCHAR(100))
 */

// Add the module to the Menu (entry point from UI)
$menu = Vtiger_Menu::getInstance('Inventory');
$menu->addModule($module);

// Add the basic module block
$block1 = new Vtiger_Block();
$block1->label = 'LBL_DELIVERY_INFORMATION';
$module->addBlock($block1);

// Add custom block (required to support Custom Fields)
$block2 = new Vtiger_Block();
$block2->label = 'LBL_CUSTOM_INFORMATION';
$module->addBlock($block2);

/** Create required fields and add to the block */
$field1 = new Vtiger_Field();
$field1->name = 'deliverynotename';
$field1->label = 'Delivery Order';
$field1->table = $module->basetable;
$field1->column = 'deliverynotename';
$field1->columntype = 'VARCHAR(255)';
$field1->uitype = 2;
$field1->typeofdata = 'V~O';
$block1->addField($field1); /** Creates the field and adds to block */

// Set at-least one field to identifier of module record
$module->setEntityIdentifier($field1);

$field2 = new Vtiger_Field();
$field2->name = 'deliverynotetype';
$field2->label = 'Delivery Order Type'; 
$field2->columntype = 'VARCHAR(100)';
$field2->uitype = 15;
$field2->typeofdata = 'V~O';// Varchar~Optional

$block1->addField($field2); /** table and column are automatically set */
$field2->setPicklistValues( Array ('Sent', 'Delivered','Accepted') );


$field3 = new Vtiger_Field();
$field3->name = 'ProductList';
$field3->table = 'vtiger_deliverynote';
$field3->column = 'productlist';
$field3->columntype = 'VARCHAR(50)';
$field3->helpinfo = 'Comma separate product list starting from 1 eg 1,3,4';
$field3->uitype = 2;
$field3->typeofdata = 'V~O';
$block1->addField($field3);
$field4 = new Vtiger_Field();
$field4->name = 'LinkTo';
$field4->label= 'Link To';
$field4->table = 'vtiger_deliverynote';
$field4->column = 'linkto';
$field4->columntype = 'VARCHAR(100)';
$field4->uitype = 10;
$field4->typeofdata = 'V~M';
$field4->helpinfo = 'Related to an existing sales order';
$block1->addField($field4);
$field4->setRelatedModules(Array('SalesOrder'));
/** Invoice */
/** Common fields that should be in every module, linked to vtiger CRM core table */
$field5 = new Vtiger_Field();
$field5->name = 'assigned_user_id';
$field5->label = 'Assigned To';
$field5->table = 'vtiger_crmentity'; 
$field5->column = 'smownerid';
$field5->uitype = 53;
$field5->typeofdata = 'V~M';
$block1->addField($field5);

$field6 = new Vtiger_Field();
$field6->name = 'CreatedTime';
$field6->label= 'Created Time';
$field6->table = 'vtiger_crmentity';
$field6->column = 'createdtime';
$field6->uitype = 70;
$field6->typeofdata = 'T~O';
$field6->displaytype= 2;
$block1->addField($field6);

$field7 = new Vtiger_Field();
$field7->name = 'ModifiedTime';
$field7->label= 'Modified Time';
$field7->table = 'vtiger_crmentity';
$field7->column = 'modifiedtime';
$field7->uitype = 70;
$field7->typeofdata = 'T~O';
$field7->displaytype= 2;
$block1->addField($field7);
/** END */

$field8 = new Vtiger_Field();
$field8->name = 'CustomerPO';
$field8->table = 'vtiger_deliverynote';
$field8->column = 'customerpo';
$field8->columntype = 'VARCHAR(50)';
$field8->helpinfo = 'Customer PO value or customer reference';
$field8->uitype = 2;
$field8->typeofdata = 'V~O';
$block1->addField($field8);
$field9 = new Vtiger_Field();
$field9->name = 'dn_sequence'; //Sequencial
$field9->label = 'Delivery Note Number';
$field9->table = 'vtiger_deliverynote'; //$module->basetable;
$field9->column = 'dn_sequence';
$field9->columntype = 'VARCHAR(100)';
$field9->uitype = 4;
$field9->typeofdata = 'V~O';
$block1->addField($field9);
// following for auto gen on save
$entity_tmp = new CRMEntity();
$entity_tmp->setModuleSeqNumber("configure",$module->name,"DN",1);
// Create default custom filter (mandatory)
$filter1 = new Vtiger_Filter();
$filter1->name = 'All';
$filter1->isdefault = true;
$module->addFilter($filter1);

// Add fields to the filter created
$filter1->addField($field1)->addField($field2, 1)->addField($field5, 2);

// Create one more filter
$filter2 = new Vtiger_Filter();
$filter2->name = 'All2';
$module->addFilter($filter2);

// Add fields to the filter
$filter2->addField($field1);
$filter2->addField($field2, 1);

// Add rule to the filter field
$filter2->addRule($field1, 'CONTAINS', 'Test');

/** Associate other modules to this module */
$module->setRelatedList(Vtiger_Module::getInstance('Accounts'), 'Accounts', Array('ADD','SELECT'));
/*$module->setRelatedList(Vtiger_Module::getInstance('SalesOrder'), 'SalesOrder', Array('ADD','SELECT')); */
/** Set sharing access of this module */
$module->setDefaultSharing('Public_ReadWriteDelete'); 


/** Enable and Disable available tools */
$module->enableTools(Array('Import', 'Export'));
$module->disableTools('Merge');
$moduleInstance=Vtiger_module::getInstance('Deliverynote');
$moduleInstance->addLink('DETAILVIEW','Create PDF',
'index.php?module=Deliverynote&action=CreatePDF&src_module=$MODULE$&src_record=$RECORD$');
$moduleInstance->initWebService();

echo '</body></html>';

?>
