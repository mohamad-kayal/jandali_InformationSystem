
<?php 
require_once('helpers.php');

// supplier operations
function add_supplier(){
	GLOBAL $conn;
	if(isset($_POST['add_supplier'])){
		$title= mysqli_real_escape_string($conn,$_POST['title']); 
		$location= mysqli_real_escape_string($conn,$_POST['location']); 
		$phone_number= mysqli_real_escape_string($conn,$_POST['phone_number']); 
		$email= mysqli_real_escape_string($conn,$_POST['email']); 
		$balance= mysqli_real_escape_string($conn,$_POST['balance']); 
		$sql = "INSERT INTO supplier VALUES ('{}','{$title}','{$location}','{$phone_number}','{$email}','{$balance}') ";
	mysqli_query($conn,$sql);
}
}

function delete_supplier(){
	GLOBAL $conn;
	if(isset($_POST['delete_supplier'])){
		$supplier_id=mysqli_real_escape_string($conn,$_POST['supplier']);
		$sql="DELETE FROM supplier WHERE supplier_id='{$supplier_id}'";
		mysqli_query($conn,$sql);
	}
}
function edit_supplier(){
	GLOBAL $conn;
	if (isset($_POST['edit_supplier'])) {
		$supplier_id=mysqli_real_escape_string($conn,$_POST['supplier_id']);
		$title= mysqli_real_escape_string($conn,$_POST['title']); 
		$location= mysqli_real_escape_string($conn,$_POST['location']); 
		$phone_number= mysqli_real_escape_string($conn,$_POST['phone_number']); 
		$email= mysqli_real_escape_string($conn,$_POST['email']); 
		$balance_lbp= mysqli_real_escape_string($conn,$_POST['balance_lbp']); 
		$balance_usd= mysqli_real_escape_string($conn,$_POST['balance_usd']); 
		$sql="UPDATE `supplier` SET `title`='{$title}',`location`='{$location}',`phone_number`='{$phone_number}',`email`='{$email}',`balance_lbp`='{$balance_lbp}'
		, `balance_usd`='{$balance_usd}' WHERE supplier_id='{$supplier_id}'";
		mysqli_query($conn,$sql);
			}
}
// item operations

function add_item(){
	GLOBAL $conn;
	if(isset($_POST['add_item'])){
$item_code= mysqli_real_escape_string($conn,$_POST['item_code']); 
$ministry_code= mysqli_real_escape_string($conn,$_POST['ministry_code']); 
$name= mysqli_real_escape_string($conn,$_POST['name']); 
$buying_price= mysqli_real_escape_string($conn,$_POST['buying_price']); 
$selling_price= mysqli_real_escape_string($conn,$_POST['selling_price']); 
$lowest_selling_price= mysqli_real_escape_string($conn,$_POST['lowest_selling_price']); 
$size= mysqli_real_escape_string($conn,$_POST['size']); 
$diameter= mysqli_real_escape_string($conn,$_POST['diameter']); 
$brand= mysqli_real_escape_string($conn,$_POST['brand']); 
$material= mysqli_real_escape_string($conn,$_POST['material']); 
$description= mysqli_real_escape_string($conn,$_POST['description']); 
$country_of_origin= mysqli_real_escape_string($conn,$_POST['country_of_origin']); 
$stock= mysqli_real_escape_string($conn,$_POST['stock']); 
$sql = "INSERT INTO item VALUES ('{$item_code}','{$name}','{$buying_price}','{$selling_price}','{$lowest_selling_price}','{$size}','{$diameter}','{$brand}','{$material}','{$description}','{$country_of_origin}','{$stock}','{$ministry_code}') ";
 // echo $sql;
if(!mysqli_query($conn,$sql)) echo mysqli_error($conn);

}
}


function sell_item(){ 
	GLOBAL $conn;
if(isset($_POST['sell_item'])){
$item_code= mysqli_real_escape_string($conn,$_POST['item']); 
$client_id= mysqli_real_escape_string($conn,$_POST['client']); 
$payment_type= mysqli_real_escape_string($conn,$_POST['payment_type']); 
$quantity= mysqli_real_escape_string($conn,$_POST['quantity']); 
$price= mysqli_real_escape_string($conn,$_POST['price']); 
$amount= mysqli_real_escape_string($conn,$_POST['amount']); 
$date= mysqli_real_escape_string($conn,$_POST['date']);
$sql = "INSERT INTO sell VALUES ('{$client_id}','{$item_code}','{$price}','{$date}','{$payment_type}','{$amount}',{$quantity}) ";

if(mysqli_query($conn,$sql)){
$sql="UPDATE item set stock= stock- ".$quantity." WHERE item_code='{$item_code}'";	
echo $sql;
mysqli_query($conn,$sql);
$diff=$amount-($quantity*$price);
$sql="UPDATE client SET balance= balance -".$diff." WHERE client_id= '{$client_id}'";
mysqli_query($conn,$sql);
}
}
}

function purchase_item(){
	GLOBAL $conn;
	if(isset($_POST['purchase'])){
$supplier= mysqli_real_escape_string($conn,$_POST['supplier']); 
$item_code= mysqli_real_escape_string($conn,$_POST['item']); 
$price_per_item= mysqli_real_escape_string($conn,$_POST['price_per_item']); 
$date= mysqli_real_escape_string($conn,$_POST['date']);
$amount = mysqli_real_escape_string($conn,$_POST['amount']);;
$quantity= mysqli_real_escape_string($conn,$_POST['quantity']); 
$sql = "INSERT INTO purchase VALUES ('{}','{$supplier}','{$item_code}','{$price_per_item}','{$date}','{$amount}','{$quantity}') ";
if(mysqli_query($conn,$sql)){
$sql="UPDATE item set stock=stock+".$quantity." WHERE item_code='{$item_code}'";
mysqli_query($conn,$sql);
$diff=$amount-($quantity*$price_per_item);
$sql="UPDATE supplier SET balance= balance+".$diff." WHERE supplier_id='{$supplier}'";
mysqli_query($conn,$sql);
}
else {
	echo mysqli_error($conn);
}
// UPDATE `item` SET stock=stock+1 WHERE item_code='0093824' 
}
}

function select_item(){
	GLOBAL $conn;
	$sql="SELECT * From item";
		$result=mysqli_query($conn,$sql);
		while($row=mysqli_fetch_assoc($result)){
			echo '<option value="'.$row['item_code'].'">'.$row['name'].'</option>';
		}
}
function select_sell_item(){
	GLOBAL $conn;
	$sql="SELECT * From item";
		$result=mysqli_query($conn,$sql);
		while($row=mysqli_fetch_assoc($result)){
			if($row['stock']>0){
			echo '<option value="'.$row['item_code'].'">'.$row['name'].'</option>';
		}
		}
}
function delete_item(){
	GLOBAL $conn;
	if(isset($_POST['delete_item'])){
	$item_code=mysqli_real_escape_string($conn,$_POST['item']);
	$sql="DELETE FROM `item` WHERE item_code = '{$item_code}'";
	mysqli_query($conn,$sql);
	}
}
function edit_item(){
	GLOBAL $conn;
	if (isset($_POST['edit_item'])) {
	
$item_code= mysqli_real_escape_string($conn,$_POST['item']); 
$ministry_code= mysqli_real_escape_string($conn,$_POST['ministry_code']); 
$name= mysqli_real_escape_string($conn,$_POST['name']); 
$buying_price= mysqli_real_escape_string($conn,$_POST['buying_price']); 
$selling_price= mysqli_real_escape_string($conn,$_POST['selling_price']); 
$lowest_selling_price= mysqli_real_escape_string($conn,$_POST['lowest_selling_price']); 
$size= mysqli_real_escape_string($conn,$_POST['size']); 
$diameter= mysqli_real_escape_string($conn,$_POST['diameter']); 
$brand= mysqli_real_escape_string($conn,$_POST['brand']); 
$material= mysqli_real_escape_string($conn,$_POST['material']); 
$description= mysqli_real_escape_string($conn,$_POST['description']); 
$country_of_origin= mysqli_real_escape_string($conn,$_POST['country_of_origin']); 
$stock= mysqli_real_escape_string($conn,$_POST['stock']);
$sql = "UPDATE `item` SET `item_code`='{$item_code}',`name`='{$name}',`buying_price`='{$buying_price}',`selling_price`='{$selling_price}',`lowest_selling_price`='{$lowest_selling_price}',`size`='{$size}',`diameter`='{$diameter}',`brand`='{$brand}',`material`='{$material}',`description`='{$description}',`country_of_origin`='{$country_of_origin}',`stock`='{$stock}',`ministry_code`='{$ministry_code}' WHERE item_code= '{$item_code}'";
mysqli_query($conn,$sql);
}
}

// Client operations

function add_client(){
	GLOBAL $conn;
	if(isset($_POST['add_client'])){
$balance= mysqli_real_escape_string($conn,$_POST['balance']); 
$name= mysqli_real_escape_string($conn,$_POST['name']); 
$mof= mysqli_real_escape_string($conn,$_POST['mof']); 
$address= mysqli_real_escape_string($conn,$_POST['address']); 
$phone_number= mysqli_real_escape_string($conn,$_POST['phone_number']); 
$diccount= mysqli_real_escape_string($conn,$_POST['diccount']); 
$sql = "INSERT INTO client VALUES ('{}','{$balance}','{$name}','{$mof}','{$address}','{$phone_number}','{$diccount}') ";
mysqli_query($conn,$sql);
}
}

function delete_client(){
	GLOBAL $conn;
	if (isset($_POST['delete_client'])) {
	$client_id=mysqli_real_escape_string($conn,$_POST['client']);
	$sql="DELETE FROM `client` WHERE client_id='{$client_id}'";
	mysqli_query($conn,$sql);

	}
}
function edit_client(){
	GLOBAL $conn;
	if (isset($_POST['edit_client'])) {
$client_id=mysqli_escape_string($conn,$_POST['client']);
$balance= mysqli_real_escape_string($conn,$_POST['balance']); 
$name= mysqli_real_escape_string($conn,$_POST['name']); 
$mof= mysqli_real_escape_string($conn,$_POST['mof']); 
$address= mysqli_real_escape_string($conn,$_POST['address']); 
$phone_number= mysqli_real_escape_string($conn,$_POST['phone_number']); 
$discount= mysqli_real_escape_string($conn,$_POST['discount']); 
$sql = "UPDATE `client` SET `balance`='{$balance}',`name`='{$name}',`MOF`='{$mof}',`address`='{$address}',`phone_number`='{$phone_number}' WHERE client_id='{$client_id}', `discount`='{$discount}'";
mysqli_query($conn,$sql);
		
	}
}

// "SELECT supplier.supplier_id as supplier_id,purchase.supplier_id as purchase_supplier_id  From supplier ,purchase where supplier_id=purchase_supplier_id "
function select_supplier(){
	GLOBAL $conn;
		$sql="SELECT * From supplier";
		$result=mysqli_query($conn,$sql);
		while($row=mysqli_fetch_assoc($result)){
			echo '<option value="'.$row['supplier_id'].'">'.$row['title'].'</option>';
		}
}

function select_client(){
	GLOBAL $conn;
		$sql="SELECT * From client";
		$result=mysqli_query($conn,$sql);
		while($row=mysqli_fetch_assoc($result)){
			echo '<option value="'.$row['client_id'].'">'.$row['name'].'</option>';
}
}

function show_inventory(){
	if(isset($_POST['show_inventory'])){
	GLOBAL $conn;
	$sql="SELECT * FROM item WHERE stock > 0";
	$result=mysqli_query($conn,$sql);
 	while($row=mysqli_fetch_assoc($result)){
 		echo '<p>'.$row['name'].'</p>';
 	}
 }
}
function check_balance_with_amount_paid(){
	if(isset($_POST['check_balance'])){
		GLOBAL $conn;
		//for this piece of code we are calculating the balance with the amount paid, that mean if a client still have a payment it will not be shown in this code.

		//Calculate all the sold items price
		$sql="SELECT SUM(price) FROM sell";
		$result=mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		$sold_items_price_in_total=$row['SUM(price)'];

		//select all the prices that purchased 
		$sql="SELECT quantity, price_per_item FROM purchase group by purchase_id";
		$result=mysqli_query($conn,$sql);
		$total_purchased=0;
		while($row=mysqli_fetch_assoc($result)){
 		$total_purchased=($total_purchased+($row['quantity']*$row['price_per_item']));
		}
		$balance_with_amount_paid=$sold_items_price_in_total-$total_purchased;
		// $total_with_amount_paid=mysqli_query($conn,$sql);
		// $balance=$sold-$bought;
		// echo $balance;
		echo 'Your balance is with paid amounts:'.$balance_with_amount_paid;
	
	}
}

function check_balance_with_full_payment(){
//this code will calculate the owner balance if every item in the stock is fully paid
if(isset($_POST['check_balance_with_full_payment'])){
	GLOBAL $conn;
	//getting the balance for all the sold items
	//caulculting the total price for sold itmes
	$sql="SELECT price, quantity from sell";
	$result=mysqli_query($conn,$sql);
	$price_and_quantity_for_sold_items=0;
	while ($row=mysqli_fetch_assoc($result)) {
	$price_and_quantity_for_sold_items+=$row['price']*$row['quantity'];
	}
	//calculating the total price for bought items
	$sql="SELECT price_per_item, quantity from purchase";
	$result=mysqli_query($conn,$sql);
	$price_and_quantity_for_bought_items=0;
	while ($row=mysqli_fetch_assoc($result)) {
	$price_and_quantity_for_bought_items+=$row['price_per_item']*$row['quantity'];
	}
	// echo $price_and_quantity_for_bought_items;
	echo $total_balance_for_full_payment=$price_and_quantity_for_sold_items-$price_and_quantity_for_bought_items;
}

}

function return_bought_items(){
	if(isset($_POST['return_bought_items'])){
		GLOBAL $conn;

}	
}

function return_sold_items(){
	if(isset($_POST['return_sold_items'])){
		GLOBAL $conn;

	}
}

function check_login(){
	if(isset($_POST['login'])){
		GLOBAL $conn;
		session_start();
$username= request_value($_POST, 'username'); 
$password= request_value($_POST, 'password'); 
		$stmt = db_execute($conn, "SELECT * FROM user WHERE username=?", "s", [$username]);
		$result = $stmt ? mysqli_stmt_get_result($stmt) : false;
		$row = $result ? mysqli_fetch_assoc($result) : null;
		if($row && (password_verify($password, $row['password']) || $row['password'] === $password)){
			$_SESSION['user_id']=$row['user_id'];
			if (!password_get_info($row['password'])['algo']) {
				$new_hash = password_hash($password, PASSWORD_DEFAULT);
				db_execute($conn, "UPDATE user SET password=? WHERE user_id=?", "si", [$new_hash, $row['user_id']]);
			}
			header('location: dashboard.php');
			exit;
		//login admin
		// role id => privileges
	}
	
echo "<span>invalid Username or password</span>";

	}
}

// function select_product(){
// 	GLOBAL $conn;
// 		$sql="SELECT * From product";
// 		$result=mysqli_query($conn,$sql);
// 		while($row=mysqli_fetch_assoc($result)){
// 			echo '<option value="'.$row['product_id'].'">'.$row['title'].'</option>';
// 		}
// }
?>
