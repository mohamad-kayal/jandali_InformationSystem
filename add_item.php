<?php 
require_once('helpers.php');
$itemcode=request_value($_GET, 'itemcode');
$name=request_value($_GET, 'name');
$buying_price=request_value($_GET, 'buying_price');
$selling_price=request_value($_GET, 'selling_price');
$size=request_value($_GET, 'size');
$diameter=request_value($_GET, 'diameter');
$brand=request_value($_GET, 'brand');
$material=request_value($_GET, 'material');
$description=request_value($_GET, 'description');
$country_of_origin=request_value($_GET, 'country_of_origin');
$stock=request_value($_GET, 'stock');
$ministry_code=request_value($_GET, 'ministry_code');
db_execute(
    $conn,
    "INSERT INTO item VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?)",
    "ssssssssssss",
    [$itemcode, $name, $buying_price, $selling_price, $size, $diameter, $brand, $material, $description, $country_of_origin, $stock, $ministry_code]
);
$last_id = $conn->insert_id;
echo "<tr id=\"".h($last_id)."\">";
echo "<td>".h($itemcode)."</td>";
echo "<td>".h($name)."</td>";
echo "<td>".h($buying_price)."</td>";
echo "<td>".h($selling_price)."</td>";
echo "<td>".h($size)."</td>";
echo "<td>".h($diameter)."</td>";
echo "<td>".h($brand)."</td>";
echo "<td>".h($material)."</td>";
echo "<td>".h($description)."</td>";
echo "<td>".h($country_of_origin)."</td>";
echo "<td>".h($ministry_code)."</td>";
echo "<td><button onclick='get_edit_row_items(".h($last_id).")'  class='editbutton'>Edit</button></td>";
echo "<td><button onclick='delete_items(".h($last_id).")' class='deletebutton'>Delete</button></td>";
echo "</tr>";
?>
