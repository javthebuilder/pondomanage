<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>


<b>A new tickect has been created</b><br>

<?php

	function generateRandomString($length = 100) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

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
	
	$query = "Select parentID,StoreName from store where storeID=".$_POST['branchselect']."";  
  	$result = $conn->query($query); 


  	$branch = str_pad($_POST['branchselect'], 4, "0", STR_PAD_LEFT);
  	

  	if ($result->num_rows > 0) {     
	    while($row = $result->fetch_assoc()) {      
	    	$parentid = $row["parentID"];
	    	$storename = $row["StoreName"];
	    	//echo 'parentid:'.$row["parentID"].'<br>';
	      	//echo '<option value="'.$row["storeID"].'">'.$row["storeName"].'</option>';      
	      }    
    } 
	else {
	   echo "0 results";
	}

	if($parentid==13 || $parentid==6)
		$tickectIntro = 'MI';
	else if($parentid==92)
		$tickectIntro = 'BS';
	else
		$tickectIntro = 'OB';

	
	$query = "SELECT COUNT(*) FROM ticket where storeId=".$branch."";
	$result  = $conn->query($query); 
		while($row = $result->fetch_assoc()) {
			//echo 	'retrieved:'.$row['COUNT(*)'];      
			$nextID = $row['COUNT(*)']+1;

		}
	//echo "next ID ".$nextID."<br>";
  	date_default_timezone_set("Asia/Hong_Kong");
  	$nextID = str_pad($nextID, 3, "0", STR_PAD_LEFT);
  	//$ticketnumber = ''.$parentid.''.date("y").date("m").date("d").date("h").date("i").date("s").$branch.'';
	$ticketnumber = ''.$tickectIntro.'-'.$branch.'-'.$nextID.'';	
  	$storeID = $_POST['branchselect'];
	$name = $_POST['sname']; 
	$email = $_POST['email']; 
	$contactnumber= $_POST['contactnumber']; 
	$concerntype = $_POST['concerntype'];
	$cardnumber = $_POST['cardnumber'];
	$wrongload = (double)$_POST['wrongload'];
	$correctamount = (double)$_POST['correctamount'];
	//$concerndetail = $_POST['concerndetail'];
	$concerndetailArea = $_POST['concerndetailArea'];

	$concerndetailAreawithamount = ''.$_POST['concerndetailArea'].'';
	
	$datetime = date('Y/m/d H:i:s');

   	$query = "Select concernName from concern where concernId=".$concerntype."";  
	$result = $conn->query($query);  
	if ($result->num_rows > 0) {     
	  while($row = $result->fetch_assoc()) {     
	    $concerntypename = $row["concernName"];     
	   }    
	}

	// if($wrongload==''){
	// 	$wrongload=0;
	// }

	$approvecode = generateRandomString();

  	$query = "INSERT INTO ticket (ticketId,concernId,submitDate,name,email, contactNumber,storeId,concernDetail, approveCode, Status,cardnumber,wrongload,correctamount)";
  	$query.="VALUES ('".$ticketnumber."','".$_POST['concerntype']."','".$datetime."','".$_POST['sname']."','".$_POST['email']."','".$_POST['contactnumber']."',".$storeID.",'".$concerndetailArea."','".$approvecode."	','P','".$cardnumber."',".$wrongload.",".$correctamount.");";  	


  	if ($conn->query($query) === TRUE) {
    
	} else {
    echo "Error: " . $query . "<br>" . $conn->error;}
    
	
	echo 'Ticket Number:'.$ticketnumber;
	echo '<br>';	
	echo 'Sender:'.$_POST['sname'].'<br>'; 
	echo 'Email:'.$_POST['email'].'<br>'; 
	echo 'Contact Number'.$_POST['contactnumber'].'<br>';
	echo 'Wrong Load Amount'.$_POST['wrongload'].'<br>';
	echo 'Correct Amount'.$_POST['correctamount'].'<br>';
	echo ''.$concerntypename.'<br>'; 
	
	echo 'Concern in detail:<br> '.$_POST['concerndetailArea'].'<br>';

	$conn->close();
?>
<?php
require_once 'swift/lib/swift_required.php';
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
	<td colspan='2' bgcolor='#f2f2f2'>".$concerndetailArea."</td>
</tr>";

$messagetocreator = $message."</table>";

$message.="
<tr>
		<td colspan='' align='center'>
			<a href='http://122.53.58.75/pondo/ticketApprove.php?approvecode=".$approvecode."' target='_blank'>
				<img src='http://pondobilling.net/share/pondosupportimage/Approve.png' alt='' width='225' height='65'> 
			</a>
		</td>

		<td colspan='' align='center'>
			<a href='http://122.53.58.75/pondo/ticketReject.php?approvecode=".$approvecode."' target='_blank'>
				<img src='http://pondobilling.net/share/pondosupportimage/Reject.png' alt='' width='225' height='65'> 
			</a>
		</td>
		
</tr>
</table>";

$message.="
<font style='font-family:Monospace;color:black;font-style:normal;font-size:14px'> 
If you can't see the image<br>
Click on the link below to Approve the ticket:
<br>
	<a href='http://122.53.58.75/pondo/ticketApprove.php?approvecode=".$approvecode."' target='_blank'>
		<i>ApproveTickect".$ticketnumber.":".$approvecode."</i>
	</a>
<br><br>
To Reject the ticket just this link:
	<a href='http://122.53.58.75/pondo/ticketReject.php?approvecode=".$approvecode."' target='_blank'>
		<i>RecjectTickect".$ticketnumber.":".$approvecode."</i>
	</a>

</font>";






$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
  ->setUsername('pondobilling@gmail.com')
  ->setPassword('405Metroview!');

  //echo '<br>'.date('H').'<br>';
if($parentid==13 || $parentid==6){
	//if (intval(date('H')) < 20 && intval(date('H')) >= 6 ){
		$arrayto = array('salesreport.slvismin@mineski.net','operations@mineski.net','customerfeedback@mineski.net','chevmikhail.salvador@mineski.net');
	//}
	//else{
		//$arrayto = array('pondobilling@gmail.com');
	//}
}else if($parentid==92){

	$arrayto = array('pondobilling@gmail.com','chuasteve08@gmail.com');
}
else{

	$arrayto = array('pondobilling@gmail.com');

}

$mailer = Swift_Mailer::newInstance($transport);
$messageintro="<font style='font-family:Monospace;color:black;font-style:normal;font-size:14px'> 
A new ticket has been sumbitted, please select a response once your done reviewing the details.<br>
</font>";
$message = Swift_Message::newInstance('New Ticket '.$ticketnumber.'')
  ->setFrom(array('pondobilling@gmail.com' => 'Pondo Billing Support'))  
  ->setTo($arrayto)      
  ->setBody("".$message,'text/html');

//$target_path = fileattachment();

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
echo '<br> FT: '.$imageFileType.'<br>';
$target_path = "";
$servermove_file = false;
//$nofile = false;
$haveattached = true;


if(empty($_FILES["fileToUpload"]["name"])) {
    //echo '<br/><br/>No Uploaded file.<br/><br/>';
    $haveattached = false;
}


if($haveattached){


	if (file_exists($target_file)) {
		echo 'file name : '.$_FILES["fileToUpload"]["name"].'<br>';
	    echo "Sorry, file already exists.";
	    $uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 24000000) {
		echo "<br> + ".filesize($_FILES["fileToUpload"]["name"]);
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// else
	// {
	// 	//echo "<br> + OK  checkin file size :".$_FILES["fileToUpload"]["size"]."<br>";
	// 	//echo "file name : ".basename($_FILES["fileToUpload"]["name"])."<br>";
	// 	if ($_FILES["fileToUpload"]["size"] == 0) {
	// 		$nofile=true;
	// 	}

	// }
	if ($uploadOk != 0) {
	    //echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	// }
	// else {

	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	    	echo "<br>Have attachment ".$imageFileType."<br/>";
	    	echo "File name : ".basename($_FILES["fileToUpload"]["name"])."<br>";
	    	$target_path = "uploads/" . basename($_FILES['fileToUpload']['name']);
	    	$servermove_file = true;	    		
	    }	    
	}
}else{
	//echo "<br>no attachment<br>";
}

if($servermove_file){
	$message->attach(Swift_Attachment::fromPath($target_path));
}
$result = $mailer->send($message);




//sending to the ticket creator
$messagetocreatorintro="
<font style='font-family:Monospace;color:black;font-style:normal;font-size:12px'>
The Ticket has been sent to the Head Office for Approval
<br>
You will receive a notification email once this ticket has been approve or rejected.
<br>
</font>
";

$mailer2 = Swift_Mailer::newInstance($transport);
$message2 = Swift_Message::newInstance('New Ticket '.$ticketnumber.'')
  ->setFrom(array('pondobilling@gmail.com' => 'Pondo Billing Support'))
  //->setCc(array('pondo@vadesystemsolutions.com'))
  //->setCc(array('pondobilling@gmail.com'))    
  ->setTo(array($email))
  ->setBody("".$messagetocreatorintro.$messagetocreator,'text/html');

if($servermove_file){
	$message2->attach(Swift_Attachment::fromPath($target_path));
}  
$result = $mailer2->send($message2);

if($servermove_file){
	unlink($target_path);
}
?>

</body>
</html>
