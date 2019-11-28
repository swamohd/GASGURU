<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="../images/favicon.ico" />
	<title>Statistics :: GasGuru</title>
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
<article style="margin:0px 10px 10px 10px ;" class="message is-info">
<div class="message-body">
<h3 class="title is-5">Statistics</h3>
</div>
</article>
<br>
<div class="steps">

<!-- FORM -->
<?php
if (isset($_GET['from'])) {
// FROM
$dt=$_GET['from'];
// $dt=$dt->format('d F Y');
$pieces=explode("-", $dt);
$year=$pieces['0'];
$month=$pieces['1'];
$day=$pieces['2'];
//FROM
//FROM FORMAT: $deadlinetime="d-m-Y  H:i:s";
$deadlinetime= $day."-".$month."-".$year." 00:00:00"; //USER DEADLINE TIME
$deadlinetimestamp= strtotime($deadlinetime); //USER DEADLINE TIMESTAMP
$date = new DateTime("@".$deadlinetimestamp);  //SNAP TO UTC
$utctime=$date->format('d-m-Y  H:i:s'); // UTC TIME
$utctimestamp=strtotime($utctime); // UTC TIMESTAMP
$from_timestamp=$utctimestamp;
// FROM FORMAT
// TO
$dtt=$_GET['to'];
$piecest=explode("-", $dtt);
$yeart=$piecest['0'];
$montht=$piecest['1'];
$dayt=$piecest['2'];
//FROM
//TO FORMAT: $deadlinetime="d-m-Y  H:i:s";
$deadlinetimet= $dayt."-".$montht."-".$yeart." 00:00:00"; //USER DEADLINE TIME
$deadlinetimestampt= strtotime($deadlinetimet); //USER DEADLINE TIMESTAMP
$datet = new DateTime("@".$deadlinetimestampt);  //SNAP TO UTC
$utctimet=$datet->format('d-m-Y  H:i:s'); // UTC TIME
$utctimestampt=strtotime($utctimet); // UTC TIMESTAMP
$to_timestamp=$utctimestampt;
// FROM FORMAT

// echo "FROM".$from_timestamp."<br>";
// echo "TO".$to_timestamp."<br>";
$statement="From <b>".$dt."</b> to <b>".$dtt."</b>";

}else{
// FROM START OF THE MONTH TO NOW
$hoursseen="0";
$dateseen = date("d-m-Y  H:i:s", strtotime(sprintf("+%d hours", $hoursseen))); //USER SEEN TIME
$seentimestamp= strtotime($dateseen); //USER SEEN TIMESTAMP
$dateseen = new DateTime("@".$seentimestamp);  //SNAP TO UTC
$utctimeseen=$dateseen->format('d-m-Y  H:i:s'); // UTC TIME
$utctimestampseen=strtotime($utctimeseen); // UTC TIMESTAMP
$now_month=$utctimestampseen;
         // ..................................
         $slastseen = new DateTime("@".$now_month); // snap to UTC
         $now_month_date=$slastseen->format('d F Y'); //disaplay time according to timezome
         // .....................................
// START MONTH
$m=date("m");
$y=date("Y");
$start_month="01-".$m."-".$y." 07:00:00";
$dateseenn = $start_month;
$seentimestampn= strtotime($dateseenn); //USER SEEN TIMESTAMP
$dateseenn = new DateTime("@".$seentimestampn);  //SNAP TO UTC
$utctimeseenn=$dateseenn->format('d-m-Y  H:i:s'); // UTC TIME
$utctimestampseenn=strtotime($utctimeseenn); // UTC TIMESTAMP
$start_month=$utctimestampseenn;
$to_timestamp=$utctimestampseenn;

         // ..................................
         $slastseenn = new DateTime("@".$start_month); // snap to UTC
         $start_month_date=$slastseenn->format('d F Y'); //disaplay time according to timezome
         // .....................................
// START MONTH
$statement="Showing records from <b>".$start_month_date."</b> to <b>".$now_month_date."</b>";
// FROM THE START OF THE MONTH TO NOW

$from_timestamp=strtotime($start_month_date);
$to_timestamp=strtotime($now_month_date)+(24*60*60);

// echo $from_timestamp."<br>".$to_timestamp;

}
?>
 <!-- FETCH RANGE -->

<!-- FORM TO FETCH RANGE -->
<div class="box">
 <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div style="width:100%">
    <span class="is-pulled-left"><b>FROM</b>&nbsp;&nbsp;</span><input class="is-pulled-left" type="date" name="from" required/><br><br>
    <span class="is-pulled-left"><b>TO</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><input class="is-pulled-left" type="date" name="to" required/> 
    <input style="visibility:hidden;position:absolute;" type="text" name="seen" value="true" /> 
    </div>
    <div style="width:100%">
     <br><br>
    <button class="button is-primary is-pulled-left" type="submit">FETCH</button><br> <br>    
    </div>

</form>  

</div>
<!-- FORM TO FETCH RANGE -->
<!-- FORM -->

<!-- SQL -->
<?php
require '../database/dbconfig.php';

$s1=mysqli_query($con,"SELECT * FROM tbl_orders WHERE client_id='$user_id' AND date_posted BETWEEN '$from_timestamp' AND '$to_timestamp'");
$total=mysqli_num_rows($s1);

$s2=mysqli_query($con,"SELECT * FROM tbl_orders WHERE client_id='$user_id' AND order_status='1' AND date_posted BETWEEN '$from_timestamp' AND '$to_timestamp'");
$pending=mysqli_num_rows($s2);

$s3=mysqli_query($con,"SELECT * FROM tbl_orders WHERE client_id='$user_id' AND order_status='2' AND date_posted BETWEEN '$from_timestamp' AND '$to_timestamp'");
$shipping=mysqli_num_rows($s3);

$s4=mysqli_query($con,"SELECT * FROM tbl_orders WHERE client_id='$user_id' AND order_status='3' AND date_posted BETWEEN '$from_timestamp' AND '$to_timestamp'");
$awaiting_payment=mysqli_num_rows($s4);

$s5=mysqli_query($con,"SELECT * FROM tbl_orders WHERE client_id='$user_id' AND order_status='4' AND date_posted BETWEEN '$from_timestamp' AND '$to_timestamp'");
$completed=mysqli_num_rows($s5);

$s6=mysqli_query($con,"SELECT * FROM tbl_orders WHERE client_id='$user_id' AND order_status='5' AND date_posted BETWEEN '$from_timestamp' AND '$to_timestamp'");
$cancelled=mysqli_num_rows($s6);





?>
<!-- SQL -->

<!-- CONTENT -->
<div id="content">
<div class="box">
<table class="table is-stipped is-fullwidth">
<tbody>
  <tr>
  <td colspan="2">
<?php
echo $statement;
?>    
  </td>
</tr>
<tr>
  <td colspan="2">
<div class="notification is-primary"><p>Total expenditure: Ksh 25000</p></div>    
  </td>
</tr>
<tr>
  <td>
<p class="title is-6 has-text-primary">Total orders made : <?php echo $total; ?></p>     
  </td>
</tr>
<tr>
  <td>
<p class="title is-6 has-text-info">Orders awaiting confirmation : <?php echo $pending; ?></p>    
  </td>
</tr>
<tr>
  <td>
<p class="title is-6 has-text-info">Orders under shipping : <?php echo $shipping; ?></p>    
  </td>
</tr>
<tr>
  <td>
<p class="title is-6 has-text-info">Orders awaiting payment : <?php echo $awaiting_payment; ?></p>    
  </td>
</tr>
<tr>
  <td>
<p class="title is-6 has-text-info">Cancelled orders : <?php echo $cancelled; ?></p>    
  </td>
</tr>
<tr>
  <td>
<p class="title is-6 has-text-info">Completed orders : <?php echo $completed; ?></p>
  </td>
</tr>
</tbody>
</table>
</div>  	
</div>
<!-- CONTENT -->
<br>
<!-- PRINT -->
<a class="button is-primary is-pulled-left button-full" href="javascript:generate()">Generate PDF</a><br><br>
<script type="text/javascript" src="../js/html2canvas.js"></script>
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/jspdf.min.js"></script>
<script>
var base64Img = null;
imgToBase64('octocat.jpg', function(base64) {
    base64Img = base64; 
});

margins = {
  top: 70,
  bottom: 40,
  left: 30,
  width: 550
};

generate = function()
{
  var pdf = new jsPDF('p', 'pt', 'a4');
  pdf.setFontSize(18);
  pdf.fromHTML(document.getElementById('content'), 
    margins.left, // x coord
    margins.top,
    {
      // y coord
      width: margins.width// max width of content on PDF
    },function(dispose) {
      headerFooterFormatting(pdf, pdf.internal.getNumberOfPages());
    }, 
    margins);
    
  // var iframe = document.createElement('iframe');
  // iframe.setAttribute('style','position:fixed;box-sizing:border-box;right:0; top:0; bottom:0; height:100%; width:50%; padding:0;');
  // document.body.appendChild(iframe);
  // render = window.open().document;
  // render.write('<html><body></body></html>');
  // render.body.appendChild( iframe );
  // iframe.src = pdf.output('datauristring');
     window.open(pdf.output('bloburl'), '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');
// SENDING PDF
var pdff =pdf.output(); //returns raw body of resulting PDF returned as a string as per the plugin documentation.
var data = new FormData();
data.append("data" , pdff);
var xhr = new XMLHttpRequest();
xhr.open( 'post', 'upload.php', true ); //Post to php Script to save to server
xhr.send(data);
 // SENDING PDF

};
function headerFooterFormatting(doc, totalPages)
{
    for(var i = totalPages; i >= 1; i--)
    {
        doc.setPage(i);                            
        //header
        header(doc);
        
        footer(doc, i, totalPages);
        doc.page++;
    }
};

function header(doc)
{
    doc.setFontSize(30);
    doc.setTextColor(40);
    doc.setFontStyle('normal');
  
    if (base64Img) {
       doc.addImage(base64Img, 'JPEG', margins.left, 10, 40,40);        
    }
      
    doc.text("GASGURU REPORT", margins.left + 50, 40 );
  doc.setLineCap(2);
  doc.line(3, 70, margins.width + 43,70); // horizontal line
};

// You could either use a function similar to this or pre convert an image with for example http://dopiaza.org/tools/datauri
// http://stackoverflow.com/questions/6150289/how-to-convert-image-into-base64-string-using-javascript
function imgToBase64(url, callback, imgVariable) {
 
    if (!window.FileReader) {
        callback(null);
        return;
    }
    var xhr = new XMLHttpRequest();
    xhr.responseType = 'blob';
    xhr.onload = function() {
        var reader = new FileReader();
        reader.onloadend = function() {
      imgVariable = reader.result.replace('text/xml', 'image/jpeg');
            callback(imgVariable);
        };
        reader.readAsDataURL(xhr.response);
    };
    xhr.open('GET', url);
    xhr.send();
};

function footer(doc, pageNumber, totalPages){

    var str = "Page " + pageNumber + " of " + totalPages
   
    doc.setFontSize(10);
    doc.text(str, margins.left, doc.internal.pageSize.height - 20);
    
};

 </script>
<!-- PRINT -->
<!-- CONTENT -->


<br><br>
</div>


</div>
<!-- MAIN -->

<!-- FOOTER -->
<?php
// require 'footer_resources.php';
?>
<!-- FOOTER -->

</body>
</html>