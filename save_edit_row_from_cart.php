<?php 
require_once("helpers.php");

$id = request_int($_GET, 'id');
$type_of_cart = request_value($_GET, 'type_of_cart');
$quantity = request_int($_GET, 'quantity', 1);

$allowed_tables = [
    'purchase_cart' => 'items_in_purchase_cart',
    'sell_cart' => 'items_in_sell_cart',
];

if ($id <= 0 || $quantity <= 0 || !isset($allowed_tables[$type_of_cart])) {
    http_response_code(400);
    echo 'Invalid cart update';
    exit;
}

db_execute($conn, "UPDATE {$allowed_tables[$type_of_cart]} SET quantity=? WHERE items_in_cart_id=?", "ii", [$quantity, $id]);
echo h($quantity);
?>
