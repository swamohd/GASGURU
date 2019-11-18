<?php
$order_id=$_GET['order_id'];
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require '../database/dbconfig.php';

$confirm=mysqli_query($con,"UPDATE tbl_orders
	SET order_status='2'
	WHERE id='$order_id'");

if ($confirm==true) {
?>
<script type="text/javascript">
	window.top.location.href='history.php?info=shipping&t=s';
</script>
<?php
}
?>