<?php 

require('connection.php');
$insertQuery1 = "INSERT INTO test (name) VALUES ('John Doe')";
$result1 = mysqli_query($con, $insertQuery1);


?>