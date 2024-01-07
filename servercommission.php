<?php


require('connection.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);





// Fetch C_ID from customer_information table
$query = "SELECT C_ID FROM customer_information";
$result = mysqli_query($con, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $c_idc = $row['C_ID'];

        // Now, $c_idc contains the C_ID from the CUSTOMER table
        echo "C_ID from CUSTOMER: $c_idc<br>";
        $table_name = $c_idc;
        calculateAndStoreCommissions($con, $table_name);

        $totalCommission = calculateTotalCommissions($con, $table_name);

        $updateTotalCommissionQuery = "UPDATE customer_information SET TOTAL_COMMISSION = $totalCommission WHERE C_ID = $table_name";
        mysqli_query($con, $updateTotalCommissionQuery);

        $resetcommissionQuery = "UPDATE customer_information SET COMMISSION_STATUS = 'UNPAID' WHERE C_ID = $table_name";
        mysqli_query($con, $resetcommissionQuery);




    }
} else {
    echo "No results found in the CUSTOMER table.";
}
echo "C_ID from CUSTOMER: $table_name<br>";


// ------------------------------calculate-commission--------------------------------------------------------------------

function calculateAndStoreCommissions($con, $table_name) {
    // Define commission rates for each level
    $commissionRates = [
        1 => 0.07,
        2 => 0.06,
        3 => 0.05,
        4 => 0.045,
        5 => 0.040,
        6 => 0.035,
        7 => 0.030,
        8 => 0.023,
        9 => 0.019,
        10 => 0.014,
        11 => 0.009,
        12 => 0.005
    ];
    echo "Calculating and storing commissions for table: $table_name<br>";

    // Fetch LEVEL and C_ID from the specified table
    $query = "SELECT * FROM `$table_name` WHERE PAYMENT_STATUS = 'UNPAID'";

    $result = mysqli_query($con, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $level = $row['LEVEL_JOINED'];
            $c_id = $row['C_ID_CONNECTED'];
            

            // Fetch SUBSCRIPTION_STATUS for the customer based on their C_ID
            //This Query is not neccessary here .You can reomve this query and $subscriptionresult condition and paste it in the above code because it needs to be executed only once and not wwhile iterating through all the rows of a table.
            $subscriptionQuery = "SELECT SUBSCRIPTION_STATUS , COMMISSION_STATUS FROM customer_information WHERE C_ID = $table_name";
            $subscriptionResult = mysqli_query($con, $subscriptionQuery);

            // Fetch SUBSCRIPTION_STATUS for the Referred Customers
            $referred_customer_subscriptionQuery = "SELECT SUBSCRIPTION_STATUS,COMMISSION_STATUS FROM customer_information WHERE C_ID = $c_id";
            $referred_customer_subscriptionResult = mysqli_query($con, $referred_customer_subscriptionQuery);

            if ($subscriptionResult) {
                $subscriptionRow = mysqli_fetch_assoc($subscriptionResult);
                $subscriptionStatus = $subscriptionRow['SUBSCRIPTION_STATUS'];
                $commissionStatus = $subscriptionRow['COMMISSION_STATUS'];

                // Check SUBSCRIPTION_STATUS before calculating commission
               
               
                if($subscriptionStatu == 0){
                    echo "Level: $level, Subscription Status: 0, Pay the registration fee first <br>";

                }
                
                elseif ($commissionStatus == 'PAID') {
                    
                    $updatePaymentStatusQuery = "UPDATE `$table_name` SET PAYMENT_STATUS = 'PAID' ";
                    mysqli_query($con, $updatePaymentStatusQuery);
                    echo "Updated PAYMENT_STATUS to PAID for $table_name where COMMISSION_STATUS is PAID<br>";
                    
                } 
     
                
                elseif (isset($commissionRates[$level])) {
                    
                    if ($referred_customer_subscriptionResult) {
                        $c_subscriptionRow = mysqli_fetch_assoc($referred_customer_subscriptionResult);
                        $c_subscriptionStatus = $c_subscriptionRow['SUBSCRIPTION_STATUS'];
                       


                        if ($c_subscriptionStatus == 1 ) {


                            $commissionRate = $commissionRates[$level];
                            // Replace this with the actual sales amount for the customer
                            $salesAmount = 300; // Example sales amount
                            $commission = $salesAmount * $commissionRate;

                            // Update the commission in the specified table
                            $updateQuery = "UPDATE `$table_name` SET COMMISSION = $commission WHERE C_ID_CONNECTED = $c_id";
                            mysqli_query($con, $updateQuery);

                            echo "Level: $level, Subscription Status: 1, Commission Rate: " . ($commissionRate * 100) . "%, Commission: $commission (Updated)<br>";
                            
                            
                        }
                    }
                    else{
                        echo"customer with c_id :$c_id has not payed the subscription fess and is deactive";
                    }


                } else {
                    echo "Unknown Level: $level<br>";
                }

                // Close the subscription result set
                mysqli_free_result($subscriptionResult);
            } else {
                echo "Error fetching SUBSCRIPTION_STATUS: " . mysqli_error($con);
            }
        }

        // Close the result set
        mysqli_free_result($result);
    } else {
        echo "No results found in the $table_name table.";
    }
}



// --------------------------------add-commission---------------------------------------
function calculateTotalCommissions($con, $table_name) {
  
    $totalCommission = 0;

    // Fetching  commissions for all referrals of the C_ID
    $query = "SELECT COMMISSION FROM `$table_name` WHERE PAYMENT_STATUS = 'UNPAID'";
   

    // $query = "SELECT COMMISSION FROM $table_name ";
    $result = mysqli_query($con, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $commission = $row['COMMISSION'];
            // Add the commission to the total commission
            $totalCommission += $commission;
        }
        // Close the result set
        mysqli_free_result($result);
    } else {
        echo "No results found for C_ID  $table_name table.";
    }

    return $totalCommission;
}































?>

































