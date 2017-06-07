<?php 

require_once("databaseconnection.php");

$db_connect = new DatabaseConnection();

$query =$date_picked1 = $date_picked2 = $date_picked = $location = "";

if(isset($_POST['datepicker'])){
	$date_picked = $_POST['datepicker']; 
}
if(isset($_POST['location'])){
	$location = $_POST['location']; 
}

if(isset($_POST['datepicker1'])){
        $date_picked1 = $_POST['datepicker1']; 
}
if(isset($_POST['datepicker2'])){
        $date_picked2 = $_POST['datepicker2']; 
}
//echo $date_picked." ".$location;

if ($date_picked !== '' && $location !== '') {
    $query = "SELECT * FROM Log WHERE Date ="." '".$date_picked."' AND Location= '".$location."'";
}

//echo $query;
if ($date_picked1 !== '' ) {
    $query = "SELECT * FROM live WHERE Date ="." '".$date_picked1."'";
}
 
if ($date_picked2 !== '' ) {
    $query = "SELECT * FROM result WHERE Date ="." '".$date_picked2."'";
}

$row = $db_connect->return_result($query);

// output headers so that the file is downloaded rather than displayed
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="demo.csv"');
 
// do not cache the file
header('Pragma: no-cache');
header('Expires: 0');

$file = fopen('php://output', 'w');
 
// save the column headers
fputcsv($file, array('Date','Location', 'Value'));
$array = array();

while($res = $row->fetch_row()){
	$curr_row = array($res[0], $res[1], $res[2]);
	array_push($array,$curr_row);
	//echo $res[0]." ".$res[1]."</br>"; 
} 

foreach ($array as $r)
{
    fputcsv($file, $r);
}


$row->close();  
exit();
?>
