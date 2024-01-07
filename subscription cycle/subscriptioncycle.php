<?php
 require('connection.php');
 error_reporting(E_ALL);
ini_set('display_errors', 1);


$selectQuery = "SELECT * FROM `customer_information`";
$result = mysqli_query($con, $selectQuery);

if ($result) {

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
            $subscriptionExpiration = $row['SUBSCRIPTION_EXPIRATION'];
            $currentDateTime = date('Y-m-d H:i:s');
            $username = $row['USERNAME']; 
            
            
            if ($currentDateTime <= $subscriptionExpiration) {
         
                $updateQuery = "UPDATE `customer_information` SET `SUBSCRIPTION_STATUS` = 1 WHERE `USERNAME` = '$username'";
                echo "Subscription status for user $username is updated to 1.<br>";
            } else {
               
                $updateQuery = "UPDATE `customer_information` SET `SUBSCRIPTION_STATUS` = 0 WHERE `USERNAME` = '$username'";
                echo "Subscription status for user $username is updated to 0.<br>";
           
            }

            // Execute the update query
            $updateResult = mysqli_query($con, $updateQuery);

            if (!$updateResult) {
                echo "Error updating subscription status: " . mysqli_error($con) . "<br>";
            }
        }
    } else {
        echo "No rows found in the customer_information table.";
    }
} else {
    echo "Error fetching data: " . mysqli_error($con);
}





?>
