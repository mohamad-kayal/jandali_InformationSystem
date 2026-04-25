<?php 
session_start();
require_once("helpers.php");

$id = request_int($_GET, 'id');
$type_of_cart = request_value($_GET, 'type_of_cart');
$quantity = request_int($_GET, 'quantity', 1);
$user_id = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;

if ($id <= 0 || $quantity <= 0 || $user_id <= 0) {
    http_response_code(400);
    echo 'Invalid cart ID or quantity';
    exit;
}

switch ($type_of_cart) {
    case 'purchase_cart':
        db_execute(
            $conn,
            "UPDATE items_in_purchase_cart SET quantity=? WHERE item_id=? AND cart_id IN (SELECT cart_id FROM purchase_cart WHERE user_id=?)",
            "iii",
            [$quantity, $id, $user_id]
        );
        break;
    case 'sell_cart':
        db_execute(
            $conn,
            "UPDATE items_in_sell_cart SET quantity=? WHERE item_id=? AND cart_id IN (SELECT cart_id FROM sell_cart WHERE user_id=?)",
            "iii",
            [$quantity, $id, $user_id]
        );
        break;
    default:
        http_response_code(400);
        echo 'Invalid cart type';
        exit;
}
echo h($quantity);
?>
