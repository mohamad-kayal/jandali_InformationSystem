<?php
session_start();
require_once("helpers.php");
require_post_with_csrf();
$id=request_int($_POST, "id");
if ($id > 0 && db_execute($conn, "DELETE FROM supplier WHERE supplier_id=?", "i", [$id])){
	echo "success";
}
?>
