<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="../images/favicon.ico" />
  <title>New orders :: GasGuru</title>
  <link rel="stylesheet" type="text/css" href="../css/bulma.css">
  <link rel="stylesheet" type="text/css" href="../css/custom.css">
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
     <script src="../js/jquery-3.3.1.min.js"></script>
     <script src="../js/custom.js"></script>
     <script src="../js/bulma.js"></script>
</head>
<body class="is-light">

<!-- HEADER -->
<?php
require 'header_dashboard.php';
?>
<!-- HEADER -->

<!-- ASIDE -->
<div class="custom-aside">
<?php
require 'dashboard_menu.php';
?>
</div>
<!-- ASIDE -->

<!-- MAIN -->
<div class="custom-main">
<!-- MOBILE -->
<?php
require 'mobile_dashboard_menu.php';
?>
<!-- MOBILE -->

<div class="steps">
<h1 style="color:#a88beb;" class="title is-3 has-text-left">Confirm to fulfil new orders</h1>	
<div style="overflow-x:scroll;" class="box">
<?php
require '../database/dbconfig.php';

// FETCH
$history=mysqli_query($con,"SELECT * FROM tbl_orders WHERE merchant_id='$merchant_id' AND order_status='1' ORDER BY id desc");
if (mysqli_num_rows($history)>0) {
?>
<table class="table is-stripped is-fullwidth is-bordered">
	<thead>
		<th class="has-text-primary"><sup>NO</sup></th>
		<th class="has-text-primary">CYLINDER SIZE</th>
		<th class="has-text-primary">GAS BRAND</th>
		<th class="has-text-primary">QUANTITY</th>
		<th class="has-text-primary">BUYER CONTACT</th>
		<th class="has-text-primary">LOCATION</th>
		<th class="has-text-primary">PRICE</th>
		<th class="has-text-primary">ACTION</th>
	</thead>
	<tbody>
<?php
while ($rowhistory=$history->fetch_assoc()) {
$order_id=$rowhistory['id'];
$inventory_id=$rowhistory['stock_id'];
$quantity=$rowhistory['quantity'];
$status=$rowhistory['order_status'];
$client_id=$rowhistory['client_id'];
// INVENTORY
$inventory=mysqli_query($con,"SELECT * FROM tbl_inventory WHERE id='$inventory_id'");
while ($rowinventory=$inventory->fetch_assoc()) {
$cylinder_size=$rowinventory['cylinder_size'];
$gas_brand=$rowinventory['gas_brand'];
$price=$rowinventory['price']*$quantity;
$merchant_id=$rowinventory['merchant_id'];
// CLIENT
  $cont=mysqli_query($con,"SELECT * FROM tbl_clients WHERE id='$client_id'");
  while ($rowname=$cont->fetch_assoc()) {
  $contact=$rowname['phone'];
  $fname=$rowname['first_name'];
  }
//LOCATION
 $check=mysqli_query($con,"SELECT * FROM locations WHERE user_id = '$client_id'");
// location set
while ($rowcheck=$check->fetch_assoc()) {
$location=$rowcheck['description'];
$location_id=$rowcheck['id'];
}

}
// STATUS
 switch ($status) {
 	case '1':
    $order_status="Processing";
 		break;
 	case '2':
 	$order_status="Shipping";
 		break;
 	case '3':
 	$order_status="Awaiting payment";
 		break;
 	case '4':
 	$order_status="Completed";
 		break;
 	default:
 		# code...
 		break;
 }

?>
<tr>
	<td><?php echo $order_id; ?></td>
	<td><?php echo $cylinder_size; ?> (Kgs)</td>
	<td><?php echo $gas_brand; ?></td>
	<td><?php echo $quantity; ?></td>
	<td><?php echo $fname."<br>".$contact; ?></td>
	<td><?php echo $location;?><br><a href="map.php?location_id=<?php echo $location_id; ?>">View map</a></td>
	<td>Ksh <?php echo $price; ?></td>
	<td><a target="targetframe" onclick="loadgif()" class="button is-success butt" href="confirm_fulfilment.php?order_id=<?php echo $order_id; ?>">CONFIRM</a> <a target="targetframe" onclick="loadgif()" class="button is-danger" href="decline_fulfilment.php?order_id=<?php echo $order_id; ?>">DECLINE</a></td>
</tr>
<?php

}
?>	
</tbody>
</table>
<?php
}else{
?>
<p>You do not have any new orders.</p>
<?php
}
// FETCH
?>	
</div>


</div>

</div>
<!-- MAIN -->

<!-- FOOTER -->
<?php
require 'targetframe.php';
?>
<!-- FOOTER -->

</body>
</html>
