<?php 
require_once("helpers.php");
$id = request_int($_GET, 'id'); 
$name = request_value($_GET, 'name'); 
$phone_number = request_value($_GET, 'phone_number'); 
$address = request_value($_GET, 'address'); 
$mof = request_value($_GET, 'mof'); 
$discount = request_value($_GET, 'discount'); 
$balance_usd = request_value($_GET, 'balance_usd'); 
db_execute(
    $conn,
    "UPDATE client SET `name`=?, phone_number=?, address=?, MOF=?, discount=?, balance_usd=? WHERE client_id=?",
    "ssssssi",
    [$name, $phone_number, $address, $mof, $discount, $balance_usd, $id]
);
echo "<td>".h($name)."</td>";
echo "<td>".h($phone_number)."</td>";
echo "<td>".h($address)."</td>";
echo "<td>".h($mof)."</td>";
echo "<td>".h($balance_usd)."</td>";
echo "<td>".h($discount)."</td>";
echo "<td><button class='editbutton' onclick='get_edit_row_clients(".h($id).")'>Edit</button></td>";
echo "<td><button class='deletebutton' onclick='delete_clients(".h($id).")'>Delete</button></td>";
?>

