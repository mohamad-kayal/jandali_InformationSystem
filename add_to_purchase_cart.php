<?php 
require_once('helpers.php');
require_post_with_csrf();
$user_id=(int) $_SESSION['user_id'];
$item_id=request_int($_POST, 'item_id');
$quantity=request_int($_POST, 'quantity');
$cart=db_fetch_assoc($conn, "SELECT * FROM purchase_cart WHERE user_id=?", "i", [$user_id]);
$cart_id=(int) $cart['cart_id'];
$existing=db_fetch_assoc($conn, "SELECT * FROM items_in_purchase_cart WHERE item_id=? AND cart_id=?", "ii", [$item_id, $cart_id]);
if($quantity <= 0){
    http_response_code(400);
    echo 'Invalid quantity';
    exit;
}
if($existing){

    db_execute($conn, "UPDATE items_in_purchase_cart SET quantity=quantity+? WHERE item_id=? AND cart_id=?", "iii", [$quantity, $item_id, $cart_id]);

}
else{

    db_execute($conn, "INSERT INTO items_in_purchase_cart VALUES (NULL, ?, ?, ?)", "iii", [$cart_id, $item_id, $quantity]);
}

$count=db_fetch_assoc($conn, "SELECT COUNT(items_in_cart_id) as c FROM items_in_purchase_cart WHERE cart_id=?", "i", [$cart_id])["c"];
echo $count;
?>

