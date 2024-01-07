<?php

require('connection.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$selectQuery = "SELECT C_ID FROM customer_information";
$result = mysqli_query($con, $selectQuery);

if ($result) {
    $serialNumber = 1; // Initialize serial number

    while ($row = mysqli_fetch_assoc($result)) {
        $tableName = $row['C_ID'];

        // Check if the 'PAYMENT_STATUS' column exists in the table
        $checkColumnQuery = "SHOW COLUMNS FROM `$tableName` LIKE 'PAYMENT_STATUS'";
        $checkColumnResult = mysqli_query($con, $checkColumnQuery);

        echo "Execution: $serialNumber<br>"; // Display serial number

        if ($checkColumnResult) {
            if (mysqli_num_rows($checkColumnResult) > 0) {
                echo "Table '$tableName' already has the 'PAYMENT_STATUS' column.";
            } else {
                // Add 'PAYMENT_STATUS' column to the table
                $addColumnQuery = "ALTER TABLE `$tableName` ADD COLUMN PAYMENT_STATUS VARCHAR(255)";
                $addColumnResult = mysqli_query($con, $addColumnQuery);

                if ($addColumnResult) {
                    echo "Table '$tableName' now has the 'PAYMENT_STATUS' column added.";
                } else {
                    echo "Error adding column: " . mysqli_error($con);
                }
            }

            // Free the result set
            mysqli_free_result($checkColumnResult);
        } else {
            echo "Error checking column: " . mysqli_error($con);
        }

        // Add a line break for better readability
        echo "<br>";

        // Increment serial number
        $serialNumber++;
    }
}


// require('connection.php');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// $selectQuery = "SELECT C_ID FROM customer_information";
// $result = mysqli_query($con, $selectQuery);

// if ($result) {
//     $serialNumber = 1; // Initialize serial number

//     while ($row = mysqli_fetch_assoc($result)) {
//         $tableName = $row['C_ID'];

//         // Check if the 'PAYMENT_STATUS' column exists in the table
//         $checkColumnQuery = "SHOW COLUMNS FROM `$tableName` LIKE 'PAYMENT_STATUS'";
//         $checkColumnResult = mysqli_query($con, $checkColumnQuery);

//         echo "Execution: $serialNumber<br>"; // Display serial number

//         if ($checkColumnResult) {
//             if (mysqli_num_rows($checkColumnResult) > 0) {
//                 echo "Table '$tableName' has the 'PAYMENT_STATUS' column.";
//             } else {
//                 echo "Table '$tableName' does not have the 'PAYMENT_STATUS' column.";
//             }

//             // Free the result set
//             mysqli_free_result($checkColumnResult);
//         } else {
//             echo "Error checking column: " . mysqli_error($con);
//         }

//         // Add a line break for better readability
//         echo "<br>";

//         // Increment serial number
//         $serialNumber++;
//     }
// }


// require('connection.php');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// $selectQuery = "SELECT C_ID FROM customer_information";
// $result = mysqli_query($con, $selectQuery);

// if ($result) {
//     while ($row = mysqli_fetch_assoc($result)) {
//         $tableName = $row['C_ID'];

//         // Check if the 'PAYMENT_STATUS' column exists in the table
//         $checkColumnQuery = "SHOW COLUMNS FROM `$tableName` LIKE 'PAYMENT_STATUS'";
//         $checkColumnResult = mysqli_query($con, $checkColumnQuery);

//         if ($checkColumnResult) {
//             if (mysqli_num_rows($checkColumnResult) > 0) {
//                 echo "Table '$tableName' has the 'PAYMENT_STATUS' column.";
//             } else {
//                 echo "Table '$tableName' does not have the 'PAYMENT_STATUS' column.";
//             }

//             // Free the result set
//             mysqli_free_result($checkColumnResult);
//         } else {
//             echo "Error checking column: " . mysqli_error($con);
//         }

//         // Add a line break for better readability
//         echo "<br>";
//     }
// }

    
            




// // Fetch all C_IDs from customer_information table
// $selectQuery = "SELECT C_ID FROM customer_information";
// $result = mysqli_query($con, $selectQuery);

// // Check if the query was successful
// if ($result) {
//     while ($row = mysqli_fetch_assoc($result)) {
//         $C_ID = $row['C_ID'];

//         // Check if PAYMENT_STATUS column already exists
//         $checkColumnQuery = "SHOW COLUMNS FROM `$C_ID` LIKE 'PAYMENT_STATUS'";
//         $checkColumnResult = mysqli_query($con, $checkColumnQuery);

//         if (mysqli_num_rows($checkColumnResult) == 0) {
//             // PAYMENT_STATUS column does not exist, so add it
//             $addColumnQuery = "ALTER TABLE `$C_ID` ADD PAYMENT_STATUS VARCHAR(255) DEFAULT 'UNPAID'";
//             $addColumnResult = mysqli_query($con, $addColumnQuery);

//             // Check if the column addition was successful
//             if (!$addColumnResult) {
//                 echo "Error adding column for C_ID $C_ID: " . mysqli_error($con);
//             }
//         } else {
//             echo "Column PAYMENT_STATUS already exists for C_ID $C_ID";
//         }
//     }

//     echo "Columns PAYMENT_STATUS checked/added successfully for all C_IDs";
// } else {
//     echo "Error fetching C_IDs: " . mysqli_error($con);
// }























// $sql = "SELECT C_ID, TOTAL_COMMISSION, AMOUNT_PAID FROM customer_information";
// $result = mysqli_query($con, $sql);

// if (mysqli_num_rows($result) > 0) {
    
//     while ($row = mysqli_fetch_assoc($result)) {
//         $customer_id = $row["C_ID"];
//         $total_commission = $row["TOTAL_COMMISSION"];
//         $amount_paid = $row["AMOUNT_PAID"];

//         $updated_total_commission = $total_commission - $amount_paid;

//         $updateSql = "UPDATE customer_information SET TOTAL_COMMISSION = $updated_total_commission WHERE C_ID = $customer_id";

//         if (mysqli_query($con, $updateSql)) {
//             echo "Update successful for Customer ID: $customer_id <br>";
//         } else {
//             echo "Error updating record for Customer ID: $customer_id - " . mysqli_error($conn) . "<br>";
//         }

//         echo "<hr>";
//     }
// } else {
//     echo "0 results";
// }



?> 

