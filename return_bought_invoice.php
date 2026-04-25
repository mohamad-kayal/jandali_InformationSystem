<?php
require_once 'helpers.php';
$invoice_id = request_int($_GET, 'id');
$result = db_fetch_assoc($conn, "SELECT * FROM purchase_invoice WHERE invoice_id=?", "i", [$invoice_id]);
if (!$result) {
    die('Invoice not found');
}
?>
<form method="post" action="view_items_from_invoice.php">
<?php echo csrf_input(); ?>
<input type="text" hidden value="<?php echo h($invoice_id)?>" name="invoice_id">
<input type="text" hidden value="<?php echo h($result['invoice_group'])?>" name="invoice_group">
<input type="text" hidden value="<?php echo h($result['invoice_date_of_sale'])?>" name="invoice_date_of_sale">
<input type="text" hidden value="<?php echo h($result['amount_paid'])?>" name="amount_paid">
<input type="submit"  value="confirm Return" name="invoice_confirm">
</form>
