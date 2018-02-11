<?php

include "include/connect.php";


// echo $database.'<br>';
// echo $_POST['branch'].'<br>';
//
// echo $_POST['name'].'<br>';
// echo $_POST['cardnumber'].'<br>';
//
//
// echo $_POST['ab_score'].'<br>';
// echo $_POST['cl_score'].'<br>';
// echo $_POST['pr_score'].'<br>';
// echo $_POST['up_score'].'<br>';
// echo $_POST['gamerequest'].'<br>';
// echo $_POST['others'].'<br>';
// echo $_POST['comment'].'<br>';

date_default_timezone_set("Asia/Hong_Kong");
$datetime = date('Y/m/d H:i:s');
$branch = $_POST['branch'];
$query = "INSERT INTO misurvey (storeid, name, cardnumber, abscore, clscore, prscore, upscore, gamerequest, others, comment, surveytakenon)";
$query.="VALUES (
  ".$branch."
  ,'".$_POST['name']."'
  ,'".$_POST['cardnumber']."'
  ,'".$_POST['ab_score']."'
  ,'".$_POST['cl_score']."'
  ,'".$_POST['pr_score']."'
  ,'".$_POST['up_score']."'
  ,'".$_POST['gamerequest']."'
  ,'".$_POST['others']."'
  ,'".$_POST['comment']."'
  ,'".$datetime."')";
//$query."'".$_POST['pr_score']."','".$_POST['up_score']."','".$_POST['gamerequest']."','".$_POST['others']."','".$_POST['comment']."','".$datetime."');";


if ($conn->query($query) === TRUE) {
//echo "mission complete";
?>
<img src="img/endofsurvey.jpg" title="SubmiTicket"/>

<?php

} else {
echo "Error!!!!!!!!!!!!!: " . $query . "<br>" . $conn->error;}

$conn->close();
 ?>
