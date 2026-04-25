<?php 
require_once('helpers.php');
$name=request_value($_GET, 'name');
$phonenumber=request_value($_GET, 'phonenumber');
$address=request_value($_GET, 'address');
$mof=request_value($_GET, 'mof');
$balance=request_value($_GET, 'balance');
$discount=request_value($_GET, 'discount');
db_execute($conn, "INSERT INTO client VALUES (NULL,?,?,?,?,?,?)", "ssssss", [$balance, $name, $mof, $address, $phonenumber, $discount]);
$last_id = $conn->insert_id;		
echo "<tr id=".h($last_id)." >";
echo "<td>".h($name)."</td>";
echo "<td>".h($phonenumber)."</td>";
echo "<td>".h($address)."</td>";
echo "<td>".h($mof)."</td>";
echo "<td>".h($balance)."</td>";
echo "<td>".h($discount)."</td>";
echo "<td><button onclick='get_edit_row_clients(". $last_id.")' class='editbutton'>Edit</button></td>";
echo "<td><button  onclick='delete_clients(". $last_id.")' class='deletebutton'>Delete</button></td>";
echo "</tr>";


?>
