<?php 
require_once('helpers.php');
require_post_with_csrf();
$user_id=(int) $_SESSION['user_id'];
$item_id=request_int($_POST, 'item_id');
$quantity=request_int($_POST, 'quantity');
$result=db_fetch_assoc($conn, "SELECT * FROM item WHERE item_id=?", "i", [$item_id]);
$items_in_cart=db_fetch_assoc(
    $conn,
    "SELECT quantity AS c FROM items_in_sell_cart WHERE item_id=? AND cart_id IN (SELECT cart_id FROM sell_cart WHERE user_id=?)",
    "ii",
    [$item_id, $user_id]
);
$items_in_cart_count = $items_in_cart ? (int) $items_in_cart['c'] : 0;
if(!$result || $quantity <= 0 || $result['stock']-$items_in_cart_count<$quantity){
    echo 'error';
}
else{
    $cart = db_fetch_assoc($conn, "SELECT * FROM sell_cart WHERE user_id=?", "i", [$user_id]);
    $cart_id=(int) $cart['cart_id'];
    $existing = db_fetch_assoc($conn, "SELECT * FROM items_in_sell_cart WHERE item_id=? AND cart_id=?", "ii", [$item_id, $cart_id]);
    if($existing){
        db_execute($conn, "UPDATE items_in_sell_cart SET quantity=quantity+? WHERE item_id=? AND cart_id=?", "iii", [$quantity, $item_id, $cart_id]);
    }
    else {
        db_execute($conn, "INSERT INTO items_in_sell_cart VALUES (NULL, ?, ?, ?)", "iii", [$cart_id, $item_id, $quantity]);
        
        }
    $count=db_fetch_assoc($conn, "SELECT COUNT(items_in_cart_id) as c FROM items_in_sell_cart WHERE cart_id=?", "i", [$cart_id])["c"];
    echo $count;
}
?>
