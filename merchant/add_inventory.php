<?php
session_start();

$merchant_id=$_SESSION['merchant_id'];
$cylinder_size=$_POST['cylinder_size'];
$gas_brand=$_POST['gas_brand'];
$price=$_POST['price'];
$quantity=$_POST['quantity'];

require '../database/dbconfig.php';

$insert=mysqli_query($con,"INSERT INTO tbl_inventory(merchant_id,gas_brand,cylinder_size,price,quantity)
	VALUES('$merchant_id', '$gas_brand', '$cylinder_size', '$price', '$quantity')");

if ($insert==true) {
?>
<script type="text/javascript">
window.top.location.href='stock.php?info=added_successfully&t=s';
</script>
<?php
}


?>