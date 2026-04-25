<?php 
require_once("helpers.php");

$id = request_int($_GET, 'id');
$type_of_cart = request_value($_GET, 'type_of_cart');
$quantity = request_int($_GET, 'quantity', 1);

if ($id <= 0 || $quantity <= 0) {
    http_response_code(400);
    echo 'Invalid cart ID or quantity';
    exit;
}

switch ($type_of_cart) {
    case 'purchase_cart':
        db_execute($conn, "UPDATE items_in_purchase_cart SET quantity=? WHERE items_in_cart_id=?", "ii", [$quantity, $id]);
        break;
    case 'sell_cart':
        db_execute($conn, "UPDATE items_in_sell_cart SET quantity=? WHERE items_in_cart_id=?", "ii", [$quantity, $id]);
        break;
    default:
        http_response_code(400);
        echo 'Invalid cart type';
        exit;
}
echo h($quantity);
?>
