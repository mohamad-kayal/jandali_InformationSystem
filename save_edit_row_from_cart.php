<?php 
require_once("helpers.php");

$id = request_int($_GET, 'id');
$type_of_cart = request_value($_GET, 'type_of_cart');
$quantity = request_int($_GET, 'quantity', 1);

if ($id <= 0 || $quantity <= 0 || !in_array($type_of_cart, ['purchase_cart', 'sell_cart'], true)) {
    http_response_code(400);
    echo 'Invalid cart update';
    exit;
}

if ($type_of_cart === 'purchase_cart') {
    db_execute($conn, "UPDATE items_in_purchase_cart SET quantity=? WHERE items_in_cart_id=?", "ii", [$quantity, $id]);
} else {
    db_execute($conn, "UPDATE items_in_sell_cart SET quantity=? WHERE items_in_cart_id=?", "ii", [$quantity, $id]);
}
echo h($quantity);
?>
