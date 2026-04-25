<?php
include('connection.php');
include('html_templates.php');
start_page_side_bar();
get_balance_html(); 
// Edit balance funcitons

function get_balance_html(){
    if(!isset($_SESSION['user_id'])){

        ?>
    <script>
    window.location.replace("index.php");
    </script>

<?php
    }
     
  GLOBAL $conn;
$q="SELECT * FROM balance";
$result=mysqli_query($conn,$q);
$row=mysqli_fetch_assoc($result);

echo '<div class="container">
<div class="balancelbp">
  <p>Your balance in LBP is: </p>
  <div id="balance_lbp">
  <span class="price" >'.$row['balance_lbp'].'</span>
  <span>Lebanese Pounds</span><br><br>
  <input type="submit" name="editbalance" onclick="get_edit_balance_lbp()"class="editbutton" value="Edit Balance in LBP"></input>
  </div>
</div>
<div class="balanceusd">
  <p>Your balance in USD is: </p>
  <div id="balance_usd">
  <span class="price" >'.$row['balance_usd'].'</span>
  <span>US Dollars</span><br><br>
  <input type="submit" name="editbalance" onclick="get_edit_balance_usd()"class="editbutton" value="Edit Balance in USD"></input>
  </div>
</div>
';


}

?>
<script>

function get_edit_balance_lbp(){
        var row=document.getElementById("balance_lbp");
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "get_edit_balance_lbp.php", true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("balance_lbp").innerHTML = ""; 
            row.innerHTML=this.responseText;
            console.log(this.responseText);
            }
        };
        xhttp.send();
    }


    function save_edit_balance_lbp(){
        row=document.getElementById("balance_lbp");
        var balance=document.getElementById("new_balance_lbp");
        var xhttp = new XMLHttpRequest();
            var params = new URLSearchParams({balance_lbp:balance.value}).toString();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                row.innerHTML=this.responseText;
            }
        };
        postAjax(xhttp, "save_edit_balance_lbp.php", params);
    }


    
function get_edit_balance_usd(){
        var row=document.getElementById("balance_usd");
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "get_edit_balance_usd.php", true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("balance_usd").innerHTML = ""; 
            row.innerHTML=this.responseText;
            console.log(this.responseText);
            }
        };
        xhttp.send();
    }


    function save_edit_balance_usd(){
        row=document.getElementById("balance_usd");
        var balance=document.getElementById("new_balance_usd");
        var xhttp = new XMLHttpRequest();
            var params = new URLSearchParams({balance_usd:balance.value}).toString();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                row.innerHTML=this.responseText;
            }
        };
        postAjax(xhttp, "save_edit_balance_usd.php", params);
    }



</script>


<!-- Write Here -->

<?php
end_page_side_bar();
?>
