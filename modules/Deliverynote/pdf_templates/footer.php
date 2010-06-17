<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *
 ********************************************************************************/


define('USD',"$");
define('EURO', chr(128) );

$desc=explode("\n",$description);
$cond=explode("\n",$conditions);
$num=230;
$desc2=$description."\n ";
/* **************** Begin Description ****************** */
$descBlock=array("10",$top,"53", $num);
$pdf->addDescBlock($desc2, $mod_strings["Description"], $descBlock);

/* ************** End Description *********************** */



/* **************** Begin Terms ****************** */
$stampBlock=array("107",$top,"53", $num);
//scott $pdf->addDescBlock($conditions, $app_strings["DOTerms"], $termBlock);
$pdf->addDescBlock("\n\n\n\n\n\n\nChop with company stamp and sign above:\n ", $mod_strings["DOStamp"], $stampBlock);

/* ************** End Terms *********************** */


?>
