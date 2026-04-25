<?php 
require_once('helpers.php');
require_post_with_csrf();
$name=request_value($_POST, 'name');
$phonenumber=request_value($_POST, 'phonenumber');
$address=request_value($_POST, 'address');
$mof=request_value($_POST, 'mof');
$balance=request_value($_POST, 'balance');
$discount=request_value($_POST, 'discount');
db_execute($conn, "INSERT INTO client VALUES (NULL,?,?,?,?,?,?)", "ssssss", [$balance, $name, $mof, $address, $phonenumber, $discount]);
$last_id = $conn->insert_id;		
echo "<tr id=\"".h($last_id)."\" >";
echo "<td>".h($name)."</td>";
echo "<td>".h($phonenumber)."</td>";
echo "<td>".h($address)."</td>";
echo "<td>".h($mof)."</td>";
echo "<td>".h($balance)."</td>";
echo "<td>".h($discount)."</td>";
echo "<td><button onclick='get_edit_row_clients(".h($last_id).")' class='editbutton'>Edit</button></td>";
echo "<td><button  onclick='delete_clients(".h($last_id).")' class='deletebutton'>Delete</button></td>";
echo "</tr>";


?>
