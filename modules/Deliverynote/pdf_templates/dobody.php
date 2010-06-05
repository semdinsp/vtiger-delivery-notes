<?php
// watermark based on status
// this is the postion of the watermark before the rotate
$waterMarkPositions=array("30","180");
// this is the rotate amount (todo)
$waterMarkRotate=array("45","50","180");
# scott customer does not want watermark
# $pdf->watermark( $status, $waterMarkPositions, $waterMarkRotate );

include("include/tcpdf/pdfconfig.php");

// blow a bubble around the table
$Bubble=array("10",$body_top,"170","$bottom");
$pdf->tableWrapper($Bubble);

/* ************ Begin Table Setup ********************** */
// Each of these arrays needs to have matching keys
// "key" => "Length"
// total of columns needs to be 190 in order to fit the table
// correctly
$prodTable=array("10","60");
//added for value field allignment
//contains the x angle starting point of the value field
$space=array("4"=>"191","5"=>"189","6"=>"187","7"=>"186","8"=>"184","9"=>"182","10"=>"180","11"=>"179","12"=>"177","13"=>"175");
//if taxtype is individual

	$colsAlign["Product Name"] = "L";
	$colsAlign["Description"] = "L";
	$colsAlign["Qty"] = "R";
	$colsAlign["Count"] = "L";
//    $colsAlign["Units"] = "R";
//scott 	$colsAlign["Price"] = "R";
//scott 	$colsAlign["Discount"] = "R";
//scott //scott 	$colsAlign["Tax"] = "R";
//scott 	$colsAlign["Total"] = "R";
$cols["Count"] = "10";
	$cols["Product Code"] = "40";
	$cols["Product Name"] = "115";
	$cols["Qty"] = "25";
//	$cols["Units"] = "22";
//scott 	$cols["Price"] = "22";
//scott 	$cols["Discount"] = "15";
//scott 	$cols["Tax"] = "20";
//scott 	$cols["Total"] = "25";



$pdf->addCols( $cols,$prodTable,$bottom, $focus->column_fields["hdnTaxType"]);
$pdf->addLineFormat( $colsAlign);

/* ************** End Table Setup *********************** */



/* ************* Begin Product Population *************** */
$ppad=3;
$y    = $body_top+10;

for($i=0;$i<count($line);$i++)
{
	$size = $pdf->addProductLine( $y, $line[$i] );
	$y   += $size+$ppad;
}

/* ******************* End product population ********* */


/* ************* Begin Totals ************************** */
//scott total $t=$bottom+56;
//scott total  $pad=6;
//scott total for($i=0;$i<count($total);$i++)
//scott total {
//scott total 	$size = $pdf->addProductLine( $t, $total[$i], $total[$i] );
//scott total 	$t   += $pad;
//scott total }

//Set the x and y positions to place the NetTotal, Discount, S&H charge
//if taxtype is not individual ie., group tax  #SCOTT if($focus->column_fields["hdnTaxType"] != "individual")


/* ************** End Totals *********************** */


?>
