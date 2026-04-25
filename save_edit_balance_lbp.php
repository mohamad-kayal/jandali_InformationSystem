<?php
require_once('helpers.php');
require_post_with_csrf();
$new_balance_lbp=request_value($_POST, 'balance_lbp');
db_execute($conn, "UPDATE balance SET balance_lbp=? WHERE balance_id=1", "s", [$new_balance_lbp]);
echo '<span class="price" >'.h($new_balance_lbp).'</span>
<span>Lebanese Pounds</span><br><br>
<input type="submit" name="editbalance" onclick="get_edit_balance_lbp()"class="editbutton" value="Edit Balance in LBP"></input>
'
?>
