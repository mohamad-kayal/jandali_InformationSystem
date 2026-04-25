<?php
include('functions.php');
include('connection.php');
session_start();
function start_page_side_bar(){
  ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Main Page</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/addItems.css">
    <link rel="stylesheet" href="css/addClient.css">
    <link rel="stylesheet" href="css/addSupplier.css">
    <link rel="stylesheet" href="css/buttons.css">
    <link rel="stylesheet" href="css/balance.css">
    <link rel="stylesheet" href="css/html_templates.css">
    <link rel="stylesheet" type="text/css" href="css/accountdetails.css">
    <script src="jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="DataTables/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.css">
    <script type="text/javascript" charset="utf8" src="DataTables/datatables.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
        $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        $(this).toggleClass('active');
      });
    });
     // if(window.location.href=="http://localhost:8080/pos/suppliers.php"){
     // document.getElementById('suppliers_dropdown').removeAttribute("onclick");
     // }
    // else{
       // window.location.href="suppliers.php";
         // console.log(window.location.href);
         // }
      var CSRF_TOKEN = '<?php echo h(csrf_token()); ?>';
      function postAjax(xhttp, url, params) {
        xhttp.open("POST", url, true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        var payload = params ? params + "&" : "";
        xhttp.send(payload + "csrf_token=" + encodeURIComponent(CSRF_TOKEN));
      }

  </script>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h2>Jandali Co.</h2>
            </div>
            <ul class="list-unstyled components">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li ><a href="suppliers.php" >Suppliers</a></li>
                <li ><a href="clients.php" >Clients</a></li>
                <li ><a href="items.php" >Items</a></li>
                <li ><a href="sell_purchase.php" >Sell / Purchase</a></li>
                <li ><a href="balance.php" >Balance</a></li>
                <li ><a href="inventory.php" >Invetory</a></li>
            </ul>
        </nav>
        <!-- Page Content Holder -->
          <div id="content">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" id="sidebarCollapse" class="navbar-btn">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                        <?php 
                        include('connection.php');
                        $user_id=$_SESSION['user_id'];
                        $q="SELECT * FROM sell_cart WHERE user_id='{$user_id}'";
                        $result=mysqli_query($conn,$q);
                        $cart_id=mysqli_fetch_assoc($result)['cart_id'];
                        $q="SELECT COUNT(items_in_cart_id) as c FROM items_in_sell_cart WHERE cart_id='{$cart_id}'";
                        $count_sales=mysqli_fetch_assoc(mysqli_query($conn,$q))["c"];
                        $q="SELECT COUNT(items_in_cart_id) as c FROM items_in_purchase_cart WHERE cart_id='{$cart_id}'";
                        $count_purchases=mysqli_fetch_assoc(mysqli_query($conn,$q))["c"];
                        ?>
                            <li><a href="sell_cart_items.php" class="navelements">Sales Cart <span id='sales_cart_quantity' style="font-size: 0.85em; color:red;"><?php echo $count_sales; ?></span></a></li>
                            <li><a href="purchase_cart_items.php" class="navelements">Purchases Cart <span id='purchases_cart_quantity' style="font-size: 0.85em; color:red;"><?php echo $count_purchases; ?></a></li>
                            <li><a href="make_payment.php"  class="navelements">Make Payment </a></li>
                            <li><a href="return_items.php"  class="navelements">Return Items </a></li>
                            <li><a href="accountdetails.php"  class="navelements">Account Details </a></li>
                            <li><a href="logout.php"  class="navelements">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
              <!-- nav ends / view start -->
          <?php
        }
function end_page_side_bar(){
        ?>
        </div>
    </div>
</body>
</html>
<?php
}
?>
<?php 
function view_dashboard_html(){
    if(!isset($_SESSION['user_id'])){
        ?>
        
    <script>
    window.location.replace("index.php");
    </script>

<?php
    }
}

?>


<?php function add_items_html(){
    start_page_side_bar();
    if(!isset($_SESSION['user_id'])){

        ?>
    <script>
    window.location.replace("index.php");
    </script>

<?php
    }
     ?>
     
<table id="data" class="compact table table-striped"  style="width:100%;">
</table>
<?php
echo '<form method="get" action=# onsubmit="return add_item()">';
echo "<input type=text required id=add_itemcode class='add_user' placeholder=Item Code> ";
echo "<input type=text required id=add_name class='add_user' name=name autocomlete='on' placeholder=Name> ";
echo "<input type=number step='0.0001' id=add_buying_price class='add_user' required placeholder=Buying price> ";
echo "<input type=number step='0.0001' id=add_selling_price class='add_user' required placeholder=Selling Price> ";
echo "<input type=text id=add_size class='add_user' placeholder=Size> ";
echo "<input type=text id=add_diameter class='add_user' required placeholder=Diameter> ";
echo "<input type=text id=add_brand class='add_user' placeholder=Brand> ";
echo "<input type=text id=add_material class='add_user' placeholder=Material> ";
echo "<input type=text id=add_description class='add_user' placeholder=Description> ";
echo "<input type=text id=add_country_of_origin class='add_user' placeholder=Country of Origin> ";
echo "<input type=number id=add_stock class='add_user' required placeholder=Stock> ";
echo "<input type=text id=add_ministry_code class='add_user' placeholder=Ministry Code > ";
echo "<button  class='addbutton' style='width:111px;'>Add</button>";
echo '</form>';
?>
<script type="text/javascript">
get_table();
function get_table(){
var table=document.getElementById("data");
var xhttp = new XMLHttpRequest();
xhttp.open("GET", "get_items.php", true);
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        table.innerHTML=this.responseText;
        fill_table();
    }
};
xhttp.send();
}
function add_item(){
        var itemcode = document.getElementById("add_itemcode").value;
        if(document.getElementById("add_itemcode").innerHTML=null){
            alert("Please Enter item code");
        }
        else {
        var itemcode = document.getElementById("add_itemcode").value;
        var name = document.getElementById("add_name").value;
        var buying_price = document.getElementById("add_buying_price").value;
        var selling_price = document.getElementById("add_selling_price").value;
        var size = document.getElementById("add_size").value;
        var diameter = document.getElementById("add_diameter").value;
        var brand = document.getElementById("add_brand").value;
        var material = document.getElementById("add_material").value;
        var stock = document.getElementById("add_stock").value;
        var description = document.getElementById("add_description").value;
        var country_of_origin = document.getElementById("add_country_of_origin").value;
        var ministry_code     = document.getElementById("add_ministry_code").value;
        var xhttp = new XMLHttpRequest();
            document.getElementById("add_itemcode").value =" ";
            document.getElementById("add_name").value =" ";
            document.getElementById("add_buying_price").value =" ";
            document.getElementById("add_selling_price").value =" ";
            document.getElementById("add_size").value =" ";
            document.getElementById("add_diameter").value =" ";
            document.getElementById("add_brand").value =" ";
            document.getElementById("add_material").value =" ";
            document.getElementById("add_stock").value =" ";
            document.getElementById("add_description").value =" ";
            document.getElementById("add_country_of_origin").value =" ";
            document.getElementById("add_ministry_code").value =" ";
            var params = new URLSearchParams({name:name, itemcode:itemcode, stock:stock, buying_price:buying_price, selling_price:selling_price,
            size:size, diameter:diameter, brand:brand, material:material, description:description,
            country_of_origin:country_of_origin, ministry_code:ministry_code}).toString();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                document.getElementById("data").innerHTML+=this.responseText;
                fill_table();
                }
            };
            postAjax(xhttp, "add_item.php", params);
            return false;
    }
    }

function delete_items(id){
        console.log(id)
    var r = confirm("Are you sure that you want to delete this record with all the related fields!");
    if (r == true) {
        var row=document.getElementById(id);
        var xhttp = new XMLHttpRequest();
        var params = new URLSearchParams({id:id}).toString();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                    row.style.display= "none";
                    update_purchase_cart_span();
                    update_sell_cart_span();
            }
        };
        postAjax(xhttp, "delete_items.php", params);
} 
    }

 function update_purchase_cart_span(){
        var xhttp= new XMLHttpRequest();
        xhttp.open("GET", "update_purchase_cart_items_after_delete.php", true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
        document.getElementById("purchases_cart_quantity").innerHTML=this.responseText;
            }
        };
        xhttp.send();
            }
    function update_sell_cart_span(){
        var xhttp= new XMLHttpRequest();
        xhttp.open("GET", "update_sell_cart_items_after_delete.php", true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
        document.getElementById("sales_cart_quantity").innerHTML=this.responseText;
            }
        };
        xhttp.send();
            }

function get_edit_row_items(id){
        var row=document.getElementById(id);
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "get_edit_row_items.php?id="+id, true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            row.innerHTML=this.responseText;
            // console.log(this.responseText);
            }
        };
        xhttp.send();
    }


    function save_edit_item(id){
        var itemcode =document.getElementById(id+"_item_code").value;
        var name =document.getElementById(id+"_name").value;
        var buying_price =document.getElementById(id+"_buying_price").value;
        var selling_price =document.getElementById(id+"_selling_price").value;
        var size =document.getElementById(id+"_size").value;
        var diameter =document.getElementById(id+"_diameter").value;
        var brand =document.getElementById(id+"_brand").value;
        var material =document.getElementById(id+"_material").value;
        var description =document.getElementById(id+"_description").value;
        var country_of_origin =document.getElementById(id+"_country_of_origin").value;
        var ministry_code =document.getElementById(id+"_ministry_code").value;
        var row=document.getElementById(id);
        var xhttp = new XMLHttpRequest();
            var params = new URLSearchParams({id:id, item_code:itemcode, name:name, buying_price:buying_price,
            selling_price:selling_price, size:size, diameter:diameter, brand:brand, material:material,
            description:description, country_of_origin:country_of_origin, ministry_code:ministry_code}).toString();
            xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                row.innerHTML=this.responseText;
                console.log(this.responseText);
            }
        };
        postAjax(xhttp, "save_edit_item.php", params);
    }

function fill_table() {
$('#data').DataTable();
}
</script>

<?php
end_page_side_bar();
}?>

<?php 
function add_clients_html(){
    start_page_side_bar();
    if(!isset($_SESSION['user_id'])){
        ?>
    <script>
    window.location.replace("index.php");
    </script>
<?php
    }
     ?>
<table id="data" class="compact table table-striped" style="width:100%;">
</table>

<?php
echo '<form method="get" action=# onsubmit="return add_client()">';
echo "<input type=text  required id=add_name class='add_user' placeholder=Name> ";
echo "<input type=number id=add_phonenumber class='add_user' placeholder=Phone Number> ";
echo "<input type=text id=add_address class='add_user' placeholder=Address> ";
echo "<input type=text id=add_mof class='add_user' placeholder=MOF> ";
echo "<input type=number id=add_balance class='add_user ' step='0.0001' placeholder=Balance(USD)> ";
echo "<input type=number required id=add_discount class='add_user' placeholder=Discount> ";
echo "<button class=addbutton style='width:111px;'>Add</button>";
echo '</form>';

?>
    <script type="text/javascript">
    get_table();
    function get_table(){
    var table=document.getElementById("data");
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "get_client.php", true);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            table.innerHTML=this.responseText;
            fill_table();
        }
    };
    xhttp.send();
    }
    // new functions needs to be defined and edited
    function add_client(){
        var name =document.getElementById("add_name").value;
        var phonenumber =document.getElementById("add_phonenumber").value;
        var address =document.getElementById("add_address").value;
        var mof=document.getElementById("add_mof").value;
        var balance =document.getElementById("add_balance").value;
        var discount =document.getElementById("add_discount").value;
        var xhttp = new XMLHttpRequest();
        document.getElementById("add_name").value=" ";
        document.getElementById("add_phonenumber").value=" ";
        document.getElementById("add_address").value=" ";
        document.getElementById("add_mof").value=" ";
        document.getElementById("add_balance").value=" ";
        document.getElementById("add_discount").value=" ";
        var params = new URLSearchParams({name:name, phonenumber:phonenumber, address:address, mof:mof, balance:balance, discount:discount}).toString();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
            document.getElementById("data").innerHTML+=this.responseText;
            fill_table();
            }
        };
        postAjax(xhttp, "add_client.php", params);
    }

function delete_clients(id){
        console.log(id);
var r = confirm("Are you sure that you want to delete this record with all the related fields!");

           if (r == true) {
        var row=document.getElementById(id);
        var xhttp = new XMLHttpRequest();
        var params = new URLSearchParams({id:id}).toString();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText=="success"){
                    row.style.display= "none";
                }
            }
        };
        postAjax(xhttp, "delete_clients.php", params);
        } 
    }

    function get_edit_row_clients(id){
        var row=document.getElementById(id);
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "get_edit_row_clinets.php?id="+id, true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                row.innerHTML=this.responseText;
            }
        };
        xhttp.send();
    }

    function save_edit_client(id){
        var name =document.getElementById(id+"_name").value;
        var phone_number =document.getElementById(id+"_phone_number").value;
        var address =document.getElementById(id+"_address").value;
        var mof =document.getElementById(id+"_mof").value;
        // console.log(discount);
        var balance_usd =document.getElementById(id+"_balance_usd").value;
        var discount =document.getElementById(id+"_discount").value;
        var row=document.getElementById(id);
        var xhttp = new XMLHttpRequest();
        var params = new URLSearchParams({name:name, id:id, phone_number:phone_number, discount:discount, address:address, mof:mof, balance_usd:balance_usd}).toString();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                row.innerHTML=this.responseText;
                
            }
        };
        postAjax(xhttp, "save_edit_client.php", params);
    }

function fill_table() {
    $('#data').DataTable();
}

</script>
<?php
end_page_side_bar();
}?>

<?php function add_suppliers_html(){
    if(!isset($_SESSION['user_id'])){
        header("location: index.php");
    }
start_page_side_bar();
    ?>
    
    <table id="data" class="compact table table-striped" style="width:100%;">
</table>

<?php
echo '<form method="get" action=# onsubmit="return add_supplier()">';
echo "<input required type=text id=add_title class='add_user' placeholder= Title > ";
echo "<input type=text id=add_location class='add_user' placeholder=Location > ";
echo "<input type=number required id=add_phonenumber class='add_user' placeholder=Phone Number> ";
echo "<input type=email id=add_email class='add_user' placeholder=Email> ";
echo "<input type=number required id=add_balance class='add_user' step='0.0001' placeholder=Balance(USD)> ";
echo "<button class=addbutton  style='width:111px;'>Add</button>";
echo '</form>';

?>
<script type="text/javascript">
    get_table();

    function get_table(){
        var table=document.getElementById("data");
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "get_suppliers.php", true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                table.innerHTML=this.responseText;
                fill_table();
            }
        };
        xhttp.send();
    }
    function add_supplier(){
        var title =document.getElementById("add_title").value;
        var location =document.getElementById("add_location").value;
        var phone =document.getElementById("add_phonenumber").value;
        var email =document.getElementById("add_email").value;
        var balance =document.getElementById("add_balance").value;
        var xhttp = new XMLHttpRequest();
        document.getElementById("add_title").value=" ";
        document.getElementById("add_location").value=" ";
        document.getElementById("add_phonenumber").value=" ";
        document.getElementById("add_email").value=" ";
        document.getElementById("add_balance").value=" ";
        var params = new URLSearchParams({title:title, location:location, phone:phone, email:email, balance:balance}).toString();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
            document.getElementById("data").innerHTML+=this.responseText;
            fill_table();
            }
        };
        postAjax(xhttp, "add_supplier.php", params);
    }

    function delete_suppliers(id){
        var row=document.getElementById(id);
        // Are you sure that you want to delete this record with all the related fields!
var r = confirm("Are you sure that you want to delete this record with all the related fields!");
if (r == true) {
        var xhttp = new XMLHttpRequest();
        var params = new URLSearchParams({id:id}).toString();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText=="success"){
                    row.style.display= "none";
                }
            }
        };
        postAjax(xhttp, "delete_suppliers.php", params);
        } 
    }

    function get_edit_row_suppliers(id){
        var row=document.getElementById(id);
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "get_edit_row_suppliers.php?id="+id, true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                row.innerHTML=this.responseText;
            }
        };
        xhttp.send();
    }

    function save_edit_supplier(id){
        var title =document.getElementById(id+"_title").value;
        var location =document.getElementById(id+"_location").value;
        var phone =document.getElementById(id+"_phone").value;
        var email =document.getElementById(id+"_email").value;
        var balance_usd =document.getElementById(id+"_balance_usd").value;
        var row=document.getElementById(id);
        var xhttp = new XMLHttpRequest();
        var params = new URLSearchParams({title:title, id:id, location:location, phone:phone, email:email, balance_usd:balance_usd}).toString();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                row.innerHTML=this.responseText;
            }
        };
        postAjax(xhttp, "save_edit_supplier.php", params);
    }

    function fill_table() {
        $('#data').DataTable();
    }
</script>
<?php
end_page_side_bar();
}

 function sell_purchase_items(){
    start_page_side_bar();
        if(!isset($_SESSION['user_id'])){

        ?>
    <script>
    window.location.replace("index.php");
    </script>

<?php
    }
     ?>
     
<table id="data" class="compact table table-striped" style="width:100%;">
</table>
<script type="text/javascript">
get_table();
function get_table(){
var table=document.getElementById("data");
var xhttp = new XMLHttpRequest();
xhttp.open("GET", "get_sell_purchase.php", true);
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        table.innerHTML=this.responseText;
        fill_table();
    }
};
xhttp.send();
}
function add_to_purchase_cart(id){
    quantity=document.getElementById(id+"_quantity").value;
if(document.getElementById(id+"_quantity").value<=0){
alert("The Quantity is "+quantity+", you must change the quantity");
    
}
else{

    var quantity =document.getElementById(id+"_quantity").value;
        var xhttp = new XMLHttpRequest();
        var params = new URLSearchParams({item_id:id, quantity:quantity}).toString();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
           console.log(this.responseText);
                document.getElementById(id+"_quantity").value=0;
                document.getElementById("purchases_cart_quantity").innerHTML=this.responseText;
                alert("Items added to cart successfully");
            }
        };
        postAjax(xhttp, "add_to_purchase_cart.php", params);

}

}
function add_to_sell_cart(id){
quantity=document.getElementById(id+"_quantity").value;
if(document.getElementById(id+"_quantity").value<=0){
alert("The Quantity is "+quantity+", you must change the quantity");
    
}
else{

    var quantity =document.getElementById(id+"_quantity").value;
        var xhttp = new XMLHttpRequest();
        var params = new URLSearchParams({item_id:id, quantity:quantity}).toString();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText=="error"){
                    alert("You don't have this quantity in your stock, Check your Sell Cart Please!");
                }
                else {
                    document.getElementById(id+"_quantity").value=0;
                    document.getElementById("sales_cart_quantity").innerHTML=this.responseText;
                    // alert(this.responseText);    
                    alert("Items added to cart successfully");
                }
                
                     }
        };
        postAjax(xhttp, "add_to_sell_cart.php", params);

}
}

function sell_item(id){
        var row=document.getElementById(id);
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "sell_item.php?id="+id, true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText=="success"){
                    row.style.display= "none";
                }
            }
        };
        xhttp.send();
    }

    function fill_table() {
    $('#data').DataTable();
    }
</script>

<?php
end_page_side_bar();
}
// Carts view html functions
function view_sell_cart_html(){
    start_page_side_bar();
    if(!isset($_SESSION['user_id'])){

        ?>
    <script>
    window.location.replace("index.php");
    </script>

<?php
    }
     ?>
     
    <table id="data" class="compact table table-striped" style="width:100%;">
    </table>
    <?php 
    include('connection.php');
    echo '<form method="post" style="float:left;" action="invoice.php">';
    echo csrf_input();
        echo '<span> SELECT Client : &nbsp </span> <select style="width:10em;" class="userselection" required name="client_id" >';
        echo ' <option value="" selected disabled hidden>Choose Client</option>';
        $q="SELECT * FROM client";
        $result=mysqli_query($conn,$q);
        while ($row=mysqli_fetch_assoc($result)) {
            echo '<option value="'.$row['client_id'].'">'.$row['name'].'</option> ';
        }
        echo '</select><br><br>';
    echo '<span style="margin-right:0.2cm;">Amount Paid: </span><input type=number step="0.0001" min="1" placeholder="Amount Paid" style="width: auto;" required name="amount_paid" >';
    echo '<br><span>SELECT LOGO : &nbsp</span><select style="width:10em;" class="userselection" required name="image" >';
    echo ' <option value="" selected disabled hidden>Choose Logo</option>';
    $q="SELECT * FROM logo";
    $result=mysqli_query($conn,$q);
    while ($row=mysqli_fetch_assoc($result)) {
        echo '<option value="'.$row['directory'].'">'.$row['logo_name'].'</option> ';
    }
    echo '</select><br><br>';
    echo '<input type=submit name="submit" value="Confirm Purchase" class="addbutton">' ;
    echo '</form>';
    echo '<form method="post" style="float:right;" action="proforma_invoice.php">';
    echo csrf_input();
    echo '<span> SELECT Client : &nbsp </span> <select style="width:10em;" class="userselection" required name="client_id" >';
    echo ' <option value="" selected disabled hidden>Choose Client</option>';
    $q="SELECT * FROM client";
    $result=mysqli_query($conn,$q);
    while ($row=mysqli_fetch_assoc($result)) {
        echo '<option value="'.$row['client_id'].'">'.$row['name'].'</option> ';
    }
    echo '</select><br><br>';
echo '<span style="margin-right:0.2cm;">Paitent name : </span><input type=text placeholder="Paitent Name : " style="width: auto;" required name="paitent_name" >';
echo '<br><span>SELECT LOGO : &nbsp</span><select style="width:10em;" class="userselection" required name="image" >';
echo ' <option value="" selected disabled hidden>Choose Logo</option>';
$q="SELECT * FROM logo";
$result=mysqli_query($conn,$q);
while ($row=mysqli_fetch_assoc($result)) {
    echo '<option value="'.$row['directory'].'">'.$row['logo_name'].'</option> ';
}
echo '</select><br><br>';
echo '<input type=submit name="submit" value="Print Proforma invoice" class="addbutton">' ;
echo '</form>';

    ?>
    <script type="text/javascript">
        get_table();
        function get_table(){
            var table=document.getElementById("data");
            var xhttp = new XMLHttpRequest();
            xhttp.open("GET", "get_sell_cart.php", true);
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    table.innerHTML=this.responseText;
                    fill_table();
                }
            };
            xhttp.send();
        }
function get_edit_row_items_from_cart_sell(id){
        var row=document.getElementById(id);
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "get_edit_row_items_from_cart.php?id="+id+"&type_of_cart=sell_cart", true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            row.innerHTML=this.responseText;
            // console.log(this.responseText);
            }
        };
        xhttp.send();
    }

    function save_edit_row_from_cart_sell_cart(id){
        var row=document.getElementById(id);
        quantity=document.getElementById(id+"_quantity").value;
        var xhttp = new XMLHttpRequest();
        var params = new URLSearchParams({id:id, type_of_cart:"sell_cart", quantity:quantity}).toString();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            row.innerHTML=this.responseText;
            // console.log(this.responseText);
            }
        };
        postAjax(xhttp, "save_edit_row_from_cart.php", params);
    }
    
function delete_items_from_cart_sell(id){
        var row=document.getElementById(id);
        var xhttp = new XMLHttpRequest();
        var params = new URLSearchParams({id:id}).toString();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                    row.style.display= "none";
                    update_purchase_cart_span();
                    update_sell_cart_span();
            }
        };
        postAjax(xhttp, "delete_sell_cart_item.php", params);

    }

function fill_table() {
$('#data').DataTable();
}

</script>
    
<?php

end_page_side_bar();
}
function view_purchase_cart_html(){
start_page_side_bar();
if(!isset($_SESSION['user_id'])){

    ?>
<script>
window.location.replace("index.php");
</script>

<?php
}
 ?>
 

<table id="data" class="compact table table-striped" style="width:100%;">
</table>
<?php 

include('connection.php');
echo '<form method="post" style="float:left;" action="confirm_purchase.php">';
echo csrf_input();
    echo '<span> SELECT Supplier : &nbsp </span> <select style="width:10em;" class="userselection"  required name="supplier_id" >';
    echo ' <option value="" selected disabled hidden>Choose Supplier</option>';
    $q="SELECT * FROM supplier";
    $result=mysqli_query($conn,$q);
    while ($row=mysqli_fetch_assoc($result)) {
        echo '<option value="'.$row['supplier_id'].'">'.$row['title'].'</option> ';
    }
    echo '</select><br>';
    echo '<br><span>SELECT LOGO : &nbsp</span><select style="width:10em;" class="userselection" required name="image" >';
    echo ' <option value="" selected disabled hidden>Choose Logo</option>';
    $q="SELECT * FROM logo";
    $result=mysqli_query($conn,$q);
    while ($row=mysqli_fetch_assoc($result)) {
        echo '<option value="'.$row['directory'].'">'.$row['logo_name'].'</option> ';
    }
    echo '</select><br><br>';

echo '<span style="margin-right:0.2cm;">Amount Paid: </span><input type=number step="0.0001" min=1 placeholder="Amount Paid" style="width: auto;" required name="amount_paid" >';
// echo '<br><span>SELECT LOGO : &nbsp</span><select style="width:10em;" class="userselection" required name="image" >';
// echo ' <option value="" selected disabled hidden>Choose Logo</option>';
// $q="SELECT * FROM logo";
// $result=mysqli_query($conn,$q);
// while ($row=mysqli_fetch_assoc($result)) {
//     echo '<option value="'.$row['directory'].'">'.$row['logo_name'].'</option> ';
// }
// echo '</select><br><br>';

echo '<input type=submit name="confirm_purchse" value="Confirm Purchase" class="addbutton">' ;
echo '</form>';

?>

<script type="text/javascript">
    get_table();
    function get_table(){
        var table=document.getElementById("data");
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "get_purchase_cart.php?cart_id=", true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                table.innerHTML=this.responseText;
                fill_table();
            }
        };
        xhttp.send();
    }
    function get_edit_row_items_from_cart_purchase(id){
        var row=document.getElementById(id);
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "get_edit_row_items_from_cart.php?id="+id+"&type_of_cart=purchase_cart", true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            row.innerHTML=this.responseText;
            }
        };
        xhttp.send();
    }
    function save_edit_row_from_cart_purchase_cart(id){
        var row=document.getElementById(id);
        quantity=document.getElementById(id+"_quantity").value;
        var xhttp = new XMLHttpRequest();
        var params = new URLSearchParams({id:id, type_of_cart:"purchase_cart", quantity:quantity}).toString();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            // row.innerHTML=this.responseText;
            console.log(this.responseText);
            }
        };
        postAjax(xhttp, "save_edit_row_from_cart.php", params);
    }
            
    function delete_items_from_cart_purchase(id){
        var row=document.getElementById(id);
        var xhttp = new XMLHttpRequest();
        var params = new URLSearchParams({id:id}).toString();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                    row.style.display= "none";
                    update_purchase_cart_span();
                    update_sell_cart_span();
            }
        };
        postAjax(xhttp, "delete_purchase_cart_items.php", params);
    }
    
function fill_table() {
$('#data').DataTable();
}
</script>

<?php
end_page_side_bar();
}
function view_inventory_html(){
    if(!isset($_SESSION['user_id'])){

        ?>
    <script>
    window.location.replace("index.php");
    </script>

<?php
    }
     ?>

<table id="data" class="compact table table-striped"  style="width:100%;">
</table>
<script type="text/javascript">
get_table();
function get_table(){
var table=document.getElementById("data");
var xhttp = new XMLHttpRequest();
xhttp.open("GET", "get_inventory.php", true);
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        table.innerHTML=this.responseText;
        fill_table();
    }
};

xhttp.send();
}
function fill_table() {
$('#data').DataTable();
}
</script>
<?php
}
function start_page_side_bar_for_dashboard(){
  ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Main Page</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/addItems.css">
    <link rel="stylesheet" href="css/addClient.css">
    <link rel="stylesheet" href="css/addSupplier.css">
    <link rel="stylesheet" href="css/buttons.css">
    <link rel="stylesheet" href="css/balance.css">
    <link rel="stylesheet" href="css/html_templates.css">
    <link rel="stylesheet" type="text/css" href="css/accountdetails.css">
    <script src="jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="DataTables/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.css">
    <script type="text/javascript" charset="utf8" src="DataTables/datatables.js"></script>
    <!-- <script type="text/javascript"> -->
    
<!-- 
        $(document).ready(function() {
        $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        $(this).toggleClass('active');
      });
    });
     // if(window.location.href=="http://localhost:8080/pos/suppliers.php"){
     // document.getElementById('suppliers_dropdown').removeAttribute("onclick");
     // }
    // else{
       // window.location.href="suppliers.php";
        // console.log(window.location.href);
        // } -->

  <!-- </script> -->
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h2>Jandali Co.</h2>
            </div>
            <ul class="list-unstyled components">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li ><a href="suppliers.php" >Suppliers</a></li>
                <li ><a href="clients.php" >Clients</a></li>
                <li ><a href="items.php" >Items</a></li>
                <li ><a href="sell_purchase.php" >Sell / Purchase</a></li>
                <li ><a href="balance.php" >Balance</a></li>
                <li ><a href="inventory.php" >Invetory</a></li>
            </ul>
        </nav>
        <!-- Page Content Holder -->
          <div id="content">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" id="sidebarCollapse" class="navbar-btn">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                        <?php 
                        include('connection.php');
                        $user_id=$_SESSION['user_id'];
                        $q="SELECT * FROM sell_cart WHERE user_id='{$user_id}'";
                        $result=mysqli_query($conn,$q);
                        $cart_id=mysqli_fetch_assoc($result)['cart_id'];
                        $q="SELECT COUNT(items_in_cart_id) as c FROM items_in_sell_cart WHERE cart_id='{$cart_id}'";
                        $count_sales=mysqli_fetch_assoc(mysqli_query($conn,$q))["c"];
                        $q="SELECT COUNT(items_in_cart_id) as c FROM items_in_purchase_cart WHERE cart_id='{$cart_id}'";
                        $count_purchases=mysqli_fetch_assoc(mysqli_query($conn,$q))["c"];
                        ?>
                            <li><a href="sell_cart_items.php" class="navelements">Sales Cart <span id='sales_cart_quantity' style="font-size: 0.85em; color:red;"><?php echo $count_sales; ?></span></a></li>
                            <li><a href="purchase_cart_items.php" class="navelements">Purchases Cart <span id='purchases_cart_quantity' style="font-size: 0.85em; color:red;"><?php echo $count_purchases; ?></a></li>
                            <li><a href="make_payment.php"  class="navelements">Make Payment </a></li>
                            <li><a href="return_items.php"  class="navelements">Return Items </a></li>
                            <li><a href="accountdetails.php"  class="navelements">Account Details </a></li>
                            <li><a href="logout.php"  class="navelements">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
              <!-- nav ends / view start -->
          <?php
        }
        function end_page_side_bar_for_dashboard(){
            ?>
            </div>
        </div>
    </body>
    </html>
    <?php
    }
    ?>
    
