<?php 
require_once("helpers.php");
require_post_with_csrf();

$id = request_int($_POST, 'id');
$type_of_cart = request_value($_POST, 'type_of_cart');
$quantity = request_int($_POST, 'quantity', 0);
$user_id = require_authenticated_user();

if ($id <= 0 || $quantity <= 0) {
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
