<?php
require_once("helpers.php");
require_post_with_csrf();
$id=request_int($_POST, "id");
if ($id > 0) {
	db_execute($conn, "DELETE FROM item WHERE item_id=?", "i", [$id]);
}

?>
