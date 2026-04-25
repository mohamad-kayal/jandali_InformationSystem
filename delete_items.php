<?php
require_once("helpers.php");
$id=request_int($_GET, "id");
if ($id > 0) {
	db_execute($conn, "DELETE FROM item WHERE item_id=?", "i", [$id]);
}

?>
