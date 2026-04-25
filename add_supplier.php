<?php 
require_once('helpers.php');
$title=request_value($_GET, 'title');
$location=request_value($_GET, 'location');
$phone=request_value($_GET, 'phone');
$email=request_value($_GET, 'email');
$balance=request_value($_GET, 'balance');
db_execute($conn, "INSERT INTO supplier VALUES (NULL,?,?,?,?,?)", "sssss", [$title, $location, $phone, $email, $balance]);
$last_id = $conn->insert_id;
echo "<tr id=".h($last_id).">";
echo "<td>".h($title)."</td>";
echo "<td>".h($location)."</td>";
echo "<td>".h($phone)."</td>";
echo "<td>".h($email)."</td>";
echo "<td>".h($balance)."</td>";
echo "<td><button class='editbutton' onclick='get_edit_row_suppliers(".h($last_id).")'>Edit</button></td>";
echo "<td><button class='deletebutton' onclick='delete_suppliers(".h($last_id).")'>Delete</button></td>";
echo "</tr>";


?>
