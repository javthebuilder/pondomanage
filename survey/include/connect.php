<?php

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


?>
