<?php 
require_once("helpers.php");
require_post_with_csrf();
$id = request_int($_POST, 'id'); 
$title = request_value($_POST, 'title'); 
$location = request_value($_POST, 'location'); 
$phone = request_value($_POST, 'phone'); 
$email = request_value($_POST, 'email'); 
$balance_usd = request_value($_POST, 'balance_usd'); 

db_execute($conn, "UPDATE supplier SET title=?, location=?, phone_number=?, email=?, balance_usd=? WHERE supplier_id=?", "sssssi", [$title, $location, $phone, $email, $balance_usd, $id]);

echo "<td>".h($title)."</td>";
echo "<td>".h($location)."</td>";
echo "<td>".h($phone)."</td>";
echo "<td>".h($email)."</td>";
echo "<td>".h($balance_usd)."</td>";
echo "<td><button class='editbutton' onclick='get_edit_row_suppliers(".h($id).")'>Edit</button></td>";
echo "<td><button class='deletebutton' onclick='delete_suppliers(".h($id).")'>Delete</button></td>";
?>

