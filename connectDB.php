<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php 
 	//echo '<p>Hello World</p>'; \
 	//pondomanage
    //jdbc:mysql:/live-server:3307/pondomanage
    //#jnEj,a5fQ8B6:2u

 	echo 'Connect to DB';
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
		echo "Connected successfully";
	}
	//<--
	$query = "Select storeName from store where parentID=13 OR parentID=6";
	
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
     //output data of each row/
    while($row = $result->fetch_assoc()) {
        echo "name " . $row["storeName"]. "<br>";
			}
		} else {
			echo "0 results";
		}
	$conn->close();


 ?> 
 </body>
</html>