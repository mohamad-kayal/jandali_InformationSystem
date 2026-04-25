<?php 
require_once('helpers.php');
require_post_with_csrf();
$title=request_value($_POST, 'title');
$location=request_value($_POST, 'location');
$phone=request_value($_POST, 'phone');
$email=request_value($_POST, 'email');
$balance=request_value($_POST, 'balance');
db_execute($conn, "INSERT INTO supplier VALUES (NULL,?,?,?,?,?)", "sssss", [$title, $location, $phone, $email, $balance]);
$last_id = $conn->insert_id;
echo "<tr id=\"".h($last_id)."\">";
echo "<td>".h($title)."</td>";
echo "<td>".h($location)."</td>";
echo "<td>".h($phone)."</td>";
echo "<td>".h($email)."</td>";
echo "<td>".h($balance)."</td>";
echo "<td><button class='editbutton' onclick='get_edit_row_suppliers(".h($last_id).")'>Edit</button></td>";
echo "<td><button class='deletebutton' onclick='delete_suppliers(".h($last_id).")'>Delete</button></td>";
echo "</tr>";


?>
