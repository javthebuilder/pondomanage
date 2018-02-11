<!DOCTYPE html>
<html>
<head>
<script>
function validateForm() {
    //var x = document.forms["myForm"]["fname"].value;
    var name = document.forms["pondosupportform"]["sname"].value;
    var email= document.forms["pondosupportform"]["email"].value;    
    var validate=true;
    if (name == "") {
        alert("Name must be filled out");
        validate = false;
    }
    if (email == "") {
        alert("Email must be filled out");
        validate = false;
    }
    if (!validateEmail(email)) {
        alert("Email must be valid");
        validate = false;
    }
	if(document.forms["pondosupportform"]["branchselect"].value==0){
        alert("Select Your Branch");
        validate = false;
    }
    if(document.forms["pondosupportform"]["concerntype"].value==0){
        alert("Select Concern About");
        validate = false;
    }
    return validate;   
}

function validateEmail(email){ 

  var this_email = email;
  var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
  if (filter.test(this_email))
      testresults = true;
  else {      
      testresults = false;
  }
return (testresults);
}

</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<script>
$(document).ready(function(){
    $('#concerntype').on('change', function() {
      if ( this.value == '1')
      //.....................^.......
      {
        $("#wrongloadselected").show();
      }
       else  
      {
        $("#wrongloadselected").hide();
      }
    });
});
</script>
</head>
<body>




<?php
  $parentid = $_GET['parentID'];
  //$servername = "live-server:3307/pondomanage";
  $servername = "vadesystems.ddns.net:3307/pondomanage";
  $username = "pondomanage";
  $password = "#jnEj,a5fQ8B6:2u";
  $database = "pondomanage";
  // Create connection
  $conn = new mysqli($servername, $username, $password,$database);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  else{
    echo "";
  }
  //<--
  if ($parentid == '13') {
    $storeGroup='parentID=13 OR parentID=6';
  }else{
    $storeGroup='parentid='.$parentid;
  }
  
  $query = "Select storeID,storeName from store where ".$storeGroup."";  
  $result = $conn->query($query);  
?>
<h1>Pondo Support Ticket Form</h1>
<form name="pondosupportform" action="PondoSendTicket.php" onsubmit="return validateForm()"  method="post"  enctype="multipart/form-data">

<table>
  <tr>
<td>Branch select:</td>    
<td> 

<?php
    if ($result->num_rows > 0) {
     //output data of each row/
    echo '<select id="branch" name="branchselect">';
    echo '<option value="0">Select Branch</option>';
    while($row = $result->fetch_assoc()) {
      //echo "" . $row["storeName"]. "<br>";
      echo '<option value="'.$row["storeID"].'">'.$row["storeName"].'</option>';
      //<option value="saab">Saab</option>      
      }
    echo '</select>';
    } 
  else {
    echo "0 results";
  }
  
  

?>
</td>
</tr>

<tr>
  <td>Name :</td>
  <td><input type="text" name="sname" value=""></td>
</tr>
<tr>
  <td>Email:</td>
  <td><input type="text" name="email" value=""></td>
</tr>
<tr>
  <td>Contact Number:</td>
  <td><input type="text" name="contactnumber" value=""></td>
</tr>

<tr>
  <td>Card Number:</td>
  <td><input type="text" name="cardnumber" value=""></td>
</tr>
<tr>

<tr>
  <td>Concern About:</td>
  <td>
  <select name='concerntype' id='concerntype'>
  <?php 
  $query = "Select * from concern";  
  $result = $conn->query($query);  
  if ($result->num_rows > 0) {
     //output data of each row/
    //echo '<select name="concerntype" id="selectconcerntype">';
    echo '<option value="0">Select Type of Concern</option>';
    while($row = $result->fetch_assoc()) {
      //echo "" . $row["storeName"]. "<br>";
      echo '<option value="'.$row["concernId"].'">'.$row["concernName"].'</option>';
      //<option value="saab">Saab</option>      
      }
    echo '</select>';
    } 
  else {
    echo "0 results";
  }

  ?>
</td>
</tr>
<tr>
	<td colspan="2">
		
	</td>
</tr>
</table>
<div style='display:none;' id='wrongloadselected'>
				<table>
				<tr>
				  <td>(Wrong Load Amount):</td>
				  <td><input type="text" name="wrongload" value=""></td>
				</tr>
				<tr>
				  <td>Correct Amount:</td>
				  <td><input type="text" name="correctamount" value=""></td>
				</tr>
				</table>
</div>  
  Concern in Detail:
  <!--
  <input type="text" name="concerndetail" value=""><b>  
  -->
  <br>
  ​<textarea id="concerndetailA" name="concerndetailArea" rows="10" cols="50"></textarea>  
  <br>
  Select file to upload (Limit 24MB): <input type="file" name="fileToUpload" id="fileToUpload">
  <br>
  <input type="submit" value="Submit">
</form> 

<?php  
    $conn->close();
?>

</body>
</html>
