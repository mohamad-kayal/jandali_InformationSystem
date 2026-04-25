<?php
require_once('helpers.php');
require_post_with_csrf();
$new_balance_usd=request_value($_POST, 'balance_usd');
db_execute($conn, "UPDATE balance SET balance_usd=? WHERE 1", "s", [$new_balance_usd]);
echo '<span class="price" >'.h($new_balance_usd).'</span>
<span>US Dollars</span><br><br>
<input type="submit" name="editbalance" onclick="get_edit_balance_usd()"class="editbutton" value="Edit Balance in USD"></input>
'
?>
