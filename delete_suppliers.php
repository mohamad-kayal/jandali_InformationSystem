<?php
session_start();
require_once("helpers.php");
$id=request_int($_GET, "id");
if ($id > 0 && db_execute($conn, "DELETE FROM supplier WHERE supplier_id=?", "i", [$id])){
	echo "success";
}
?>
