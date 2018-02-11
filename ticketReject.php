<?php
	//echo 'you have approve the ticket having the approvecode:'.$_GET['approvecode'];
	//$sampleapprovecode = "K7jLKqhDpKzKXWbI7lzD6NI5DD4aVJBtHpN6bvCD4nwbCRukvjZaYyZhJXWN1lQgw39OuXP1CnlZ8aFiLEh3JH8RIEHMZkXre6nU";	


	$sampleapprovecode = $_GET['approvecode'];
	require_once 'swift/lib/swift_required.php';
	date_default_timezone_set("Asia/Hong_Kong");

	$servername = "live-server:3307/pondomanage";
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
	//echo 'code :'.$sampleapprovecode;
	$query = "SELECT ticketId,concernId,submitDate,name,email, contactNumber,storeId,concernDetail, approveCode, Status from ticket where approveCode='".$sampleapprovecode."'";
	//$query.="from ticket where approveCode=".$_GET['approvecode']."";  //live
		//$query.=" from ticket where approveCode=".$sampleapprovecode."";
	$result = $conn->query($query);
  	if ($result->num_rows > 0) {     
	    while($row = $result->fetch_assoc()) {      
	    	//$parentid = $row["parentID"];
	    	//$storename = $row["StoreName"];
	    	//echo 'parentid:'.$row["parentID"].'<br>';
	      	//echo '<option value="'.$row["storeID"].'">'.$row["storeName"].'</option>';      
	    	$ticketnumber = $row["ticketId"];
  			$storeID = $row["storeId"];
			$name = $row["name"];
			$email = $row["email"];
			$submitDate = $row["submitDate"];
			$contactnumber= $row["contactNumber"];
			$concerntype = $row["concernId"];			
			//$wrongload = $row["parentID"];
			//$correctamount = $row["parentID"];
			$concerndetailArea = $row["concernDetail"];
	      }    
    } 
	else {
	   echo "0 results";
	}

//explode example
	//$concerndetailArea  = "piece1 piece2 piece3 piece4 piece5 piece6";
	$concerndatasplit = explode("/", $concerndetailArea);
	
	$cardnumber = explode(":", $concerndatasplit[0]); // cardnumber
	$cardnumber = $cardnumber[1];

	$wrongload = explode(":",$concerndatasplit[1]); // wrongload
	$wrongload = $wrongload[1];

	$correctamount = explode(":",$concerndatasplit[2]); // correctAmount
	$correctamount = $correctamount[1];


	$concerndetails= $concerndatasplit[3]; // details
//explode example

	$datetime = date('Y/m/d H:i:s');

	$query = "Select parentID,StoreName from store where storeID=".$storeID."";  
  	$result = $conn->query($query); 
  	$branch = $storeID;
  	if ($result->num_rows > 0) {     
	    while($row = $result->fetch_assoc()) {      
	    	$parentid = $row["parentID"];
	    	$storename = $row["StoreName"];
	      }    
    } 
	else {
	   echo "0 results";
	}

 	
   	$query = "Select concernName from concern where concernId=".$concerntype."";  
	$result = $conn->query($query);  
	if ($result->num_rows > 0) {     
	  while($row = $result->fetch_assoc()) {     
	    $concerntypename = $row["concernName"];     
	   }    
	}



?>





<?php





$message=
"<head>
<style>
table, th, td {
    border: 0px solid black;
    border-collapse: collapse;
}
</style>
</head>


<table border ='0' style='font-family:Monospace;color:black;font-style:normal;font-size:14px'>

<th colspan='2'>
	<img src='http://pondobilling.net/share/pondosupportimage/pondoticketimage.jpg' width='450px' height='110'>
</th>


<tr bgcolor='#f2f2f2'>
	<td>Ticket #    </td><td><b>".$ticketnumber."</b></td>
 </tr>
 <tr>
	<td>Sender      </td><td>".$name."</td>
 </tr>
 <tr bgcolor='#f2f2f2'>
	<td>Branch      </td><td>".$storename."</td>
 </tr>
 <tr>
 	<td>Contact #   </td><td>".$contactnumber."</td>
 </tr>
 <tr bgcolor='#f2f2f2'>
 	<td>Card No.    </td><td>".$cardnumber."</td>
 </tr>
 <tr>
 	<td>Concern On   </td><td>".$concerntypename."</td>
 	";

if ($concerntype==1){
	$message.="
 </tr> 
	<tr>
	<td bgcolor='#f2f2f2'>(Wrong Load):</td><td  bgcolor='#f2f2f2'>".$wrongload."</td>
	 </tr>
	 <tr>
		<td>Correct Amount:</td><td>".$correctamount."</td>
	 </tr>";
}
$message.="
 <tr>
	<td colspan='2' bgcolor='#f2f2f2'>Details     :</td>
 </tr>
 <tr>
	<td colspan='2' bgcolor='#f2f2f2'>".$concerndetails."</td>
</tr>


</table>";

$messageintro ="
<font style='font-family:Monospace;color:red;font-style:normal;font-size:16px'> 
	Ticket <b>".$ticketnumber."</b> has been Rejected ! 
</font>
	<br>";
$message = $messageintro.$message;


 echo $message;

?>
<?php



$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
  ->setUsername('pondobilling@gmail.com')
  ->setPassword('405Metroview!');

$mailer = Swift_Mailer::newInstance($transport);

$message = Swift_Message::newInstance('New Ticket '.$ticketnumber.'')
  ->setFrom(array('pondobilling@gmail.com' => 'Pondo Billing Support'))
  //->setCc(array('pondo@vadesystemsolutions.com'))
  ->setCc(array($email,'salesreport.slvismin@mineski.net','operations@mineski.net','customerfeedback@mineski.net'))    
  ->setTo(array('chevmikhail.salvador@mineski.net'))
  ->setBody("".$message,'text/html');
//'sales.report@mineski.net','salesreport.slvismin@mineski.net'
//->setBody("A new ticket has been created :".$ticketnumber.". \nHaving these concern details: \n".$concerndetailArea."\n\nSender:".$name."\nBranch Submitted:".$storename."\n Contact Number:".$contactnumber."");
$result = $mailer->send($message);




$query = "UPDATE ticket SET deniedDate = '".$datetime."', Status ='R' WHERE ticketId='".$ticketnumber."';"; 	
  	if ($conn->query($query) === TRUE) {    
	} else {
    echo "Error: " . $query . "<br>" . $conn->error;}


    $conn->close();
?>





