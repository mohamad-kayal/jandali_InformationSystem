<?php
require_once("helpers.php");
require_post_with_csrf();
$id=request_int($_POST, "id");
$user_id=(int) $_SESSION['user_id'];
db_execute(
    $conn,
    "DELETE FROM items_in_sell_cart WHERE item_id=? AND cart_id IN (SELECT cart_id FROM sell_cart WHERE user_id=?)",
    "ii",
    [$id, $user_id]
);

?>
