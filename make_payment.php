<?php 
require_once('helpers.php');
include('html_templates.php');
start_page_side_bar();

if(!isset($_SESSION['user_id'])){

  ?>
<script>
window.location.replace("index.php");
</script>

<?php
}

$q="SELECT * FROM supplier";
$result_supplier=mysqli_query($conn,$q);
$q="SELECT * FROM client";
$result_client=mysqli_query($conn,$q);

echo '<div class="container">
<div class="balancelbp" style="">
  <p>Client Payment: </p>
  <div id="balance_lbp">
  <form  action=# method=post>
  '.csrf_input().'
  <span>Select Client</span>
  <select class="userselection" style="width:10em;" name="selection_client" required id="client_select" onchange="get_dept_client()">
  <option value="" selected disabled hidden>Choose Client</option>';
   while($row=mysqli_fetch_assoc($result_client)){
  echo '<option value="'.$row['client_id'].'">'.$row['name'].'</opiton>';
  }

  echo ' </select>
  <br>
  <span id="dept_client">Dept : </span>
  <br><br>
  <span>Amount Paid:</span>
  <input type=number required step="0.0001" name="amount_paid_client"></input><br>
  <input type="submit" name="confirm_payment_clinet" onclick="get_edit_balance_lbp()"class="deletebutton" value="Confirm Payment"></input>
  </form>
  </div>
  </div>
  <div class="balanceusd">
  <p>Supplier Payment </p>
  <div id="balance_usd">
   <form action=# method=post>
   '.csrf_input().'
  <span>Select Supplier</span>
  <select class="userselection"  style="width:10em;"  name="selection_supplier" required id="supplier_select" onchange="get_dept_supplier()">
  <option value="" selected disabled hidden>Choose Supplier</option>';

  while($row=mysqli_fetch_assoc($result_supplier)){
    echo '<option value="'.$row['supplier_id'].'">'.$row['title'].'</opiton>';
    }
  
  echo ' </select>
  <br>
  <span id="dept_supplier" > Dept: </span>
  <br><br>
  <span>Amount Paid:</span>
  <br>
  <input type=number step="0.0001" required name="amount_paid_supplier" plc ></input>
  <input type="submit"  name="confirm_payment_supplier" class="deletebutton" value="Confirm Payment"></input>
  </form>
  </div>
</div>
';



if(isset($_POST['confirm_payment_supplier'])){
  if(!verify_csrf($_POST)){
    echo 'Invalid request';
  } else {
    $supplier_id=request_int($_POST, 'selection_supplier');
    $amount_paid=request_value($_POST, 'amount_paid_supplier');
    db_execute($conn, "UPDATE supplier SET balance_usd=balance_usd-? WHERE supplier_id=?", "si", [$amount_paid, $supplier_id]);
  }
}

if(isset($_POST['confirm_payment_clinet'])){
  if(!verify_csrf($_POST)){
    echo 'Invalid request';
  } else {
    $client_id=request_int($_POST, 'selection_client');
    $amount_paid=request_value($_POST, 'amount_paid_client');
    db_execute($conn, "UPDATE client SET balance_usd=balance_usd-? WHERE client_id=?", "si", [$amount_paid, $client_id]);
  }
}
?>
<script>

function get_dept_client(){
// target element  document.getElementById('dept_client');
var client_id=document.getElementById('client_select').value;
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "get_client_dept.php?id="+client_id, true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById('dept_client').innerHTML=this.responseText;
            }
        };
        xhttp.send();
}


function get_dept_supplier(){
var supplier_id=document.getElementById('supplier_select').value;
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "get_supplier_dept.php?id="+supplier_id, true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById('dept_supplier').innerHTML=this.responseText;
            }
        };
        xhttp.send();
}


</script>
