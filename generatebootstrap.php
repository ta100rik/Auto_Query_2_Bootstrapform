<?php

$con = mysqli_connect("rdbms.strato.de","U3422793","WW123chicken","DB3422793");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql = $_POST['sql'];
$labellen = $_POST['label'];
$inputlen = $_POST['input'];
$explode_sql = explode(" ",$sql);
foreach ($explode_sql as $key => $value) {
	if($value == 'FROM' || $value == 'from'){
		$table = $explode_sql[$key + 1];
	}
}
$describesql = "DESCRIBE " . $table;
$run = mysqli_query($con,$describesql);
$html = array();
array_push($html,'<form>');
while($row = mysqli_fetch_assoc($run)){
	$field 			= $row['Field'];

	$opening 		= '<div class="form-group">';
	$label 			= ' <label for="'.$field.'" class="col-sm-'.$labellen.' col-form-label">'.$field.'</label>';
	$open_in_div 	= '<div class="col-sm-'.$inputlen.'">';
	$input 			= '<input type="text" class="form-control"  name="'.$field.'" id="'.$field.'">';
	$close_div 		= '</div>';

	array_push($html,$opening);
	array_push($html,$label);
	array_push($html,$open_in_div);
	array_push($html,$input);
	array_push($html,$close_div);
	array_push($html,$close_div);

}
array_push($html,'</form>');
echo json_encode($html);
?>