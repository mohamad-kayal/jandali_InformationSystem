<?php
require_once 'helpers.php';
require_once 'html_templates.php';
require_post_with_csrf();
$invoice_id=request_int($_POST, 'invoice_id');
$invoice_group=request_value($_POST, 'invoice_group');
$invoice_date_of_sale=request_value($_POST, 'invoice_date_of_sale');
$amount_paid=request_value($_POST, 'amount_paid');
$purchase_stmt=db_execute($conn, "SELECT * from purchase where invoice_group=?", "s", [$invoice_group]);
$purchse_result=$purchase_stmt ? mysqli_stmt_get_result($purchase_stmt) : false;
start_page_side_bar();
?>
<form method="post" action="confirm_return_bought.php">
<?php echo csrf_input(); ?>
<table id="data" class="compact table table-striped"  style="width:100%;">
<thead>
    <tr>
			<th>Item code</th>
			<th>Date of sale</th>
			<th>Supplier Name</th>
			<th>Quantity</th>
			<th>Quantity to return</th>
			<th>Action</th>

		</tr>
	</thead>
	<?php
	$i=0;
    while ($row=mysqli_fetch_assoc($purchse_result)) {
		$q="SELECT title from supplier where supplier_id='{$row['supplier_id']}'";
		$supplier_result=mysqli_fetch_assoc(mysqli_query($conn,$q));
    $q="SELECT * from item where item_code='{$row['item_code']}'";
    $item=mysqli_fetch_assoc(mysqli_query($conn,$q));
	echo '<tr>';
    echo '<td >'.$item['item_code'].'</td>';
	echo '<td>'.$invoice_date_of_sale.'</td>';
	echo '<td>'.$supplier_result['title'].'</td>';
	echo '<td>'.$row['quantity'].'</td>';
	echo '<input type=text hidden name=invoice_quantity[] value='.$row['quantity'].'>';
	echo '<input type=text hidden name=purchase_id[] value='.$row['purchase_id'].'>';
	echo '<input type=text hidden name=supplier_id[] value='.$row['supplier_id'].'>';
	echo '<input type=text hidden name=item_code[] value='.$item['item_code'].'>';
	echo '<input type=text hidden name=invoice_group value='.$invoice_group.'>';

	echo '<td><input style="width:100px;" value="0" name="quantity_returned[]" type=number max='.$row["quantity"].' min=0 id="save_button"  placeholder="Return Quantity"></td>';
	echo '</tr>';
		$i++;
}
	?>
	<tfoot>
		<tr>
		<th>Item code</th>
			<th>Date of sale</th>
			<th>Supplier Name</th>
			<th>Quantity</th>
			<th>Quantity to return</th>
			<th>Action</th>
			

		</tr>
    </tfoot>
</table>
<?php
 echo '<br><span>SELECT LOGO : &nbsp</span><select style="width:10em;" class="userselection" required name="image" >';
 echo ' <option value="" selected disabled hidden>Choose Logo</option>';
 $q="SELECT * FROM logo";
 $result=mysqli_query($conn,$q);
 while ($row=mysqli_fetch_assoc($result)) {
	 echo '<option value="'.$row['directory'].'">'.$row['logo_name'].'</option> ';
 }
 echo '</select><br><br>';


?>
<input type="submit">
</form>
<script>


fill_table();
function fill_table() {
$('#data').DataTable();
}
function disable_input(){
	document.getElementById("save_button").disabled = true; 
}
</script>

<?php

end_page_side_bar();

?>
