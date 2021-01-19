<?php
defined( 'ABSPATH' ) or die('Say No to Hackers!');

$orders = wc_get_orders( array('numberposts' => -1) );

$arr = array();
$filename = 'users.csv';
foreach ($orders As $csvorder) {
$id = $csvorder->get_id();
$date = $csvorder->get_date_created();
$name = $csvorder->get_billing_first_name() . ' ' .$csvorder->get_billing_last_name();
$status = $csvorder->get_status();
$total = $csvorder->get_total();

$export_data = array($id,$date,$name,$status,$total);
array_push($arr,$export_data);
}

if(isset($_POST['export'])) {
	
header("Content-Type:application/csv"); 
header("Content-Disposition:attachment;filename=export.csv"); 
ob_end_clean();
$output = fopen("php://output",'w') or die("Can't open php://output");

fputcsv($output, array('Order ID', 'Date Created', 'Customer Name', 'Order Status', 'Order Total' ));
foreach($arr as $product) {
    fputcsv($output, $product);
}


 exit;
	

};
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
<div class="container">
<h1>Export to CSV</h1>
<form method="post" action="<?php echo $outpath ?>">
<button class="btn" name="export">Export to CSV</button>

<table class="table">

<thead>
<tr>
<th>Order ID</th>
<th>Date Created</th>
<th>Customer Name</th>
<th>Order Status</th>
<th>Order Total</th>
</tr>
</thead>

<tbody>

<?php foreach( $orders as $order ){ ?>
<tr>
<td><?php echo $order->get_id(); ?></td>
<td><?php echo $order->get_date_created(); ?></td>
<td><?php echo $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();?> </td>
<td><?php echo $order->get_status(); ?></td>
<td><?php echo $order->get_total(); ?></td>

</tr>
<?php } ?>

</tbody>

</table>
</form>
</div>
</body>
</html>
