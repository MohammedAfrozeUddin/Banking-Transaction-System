<?php
session_start();
$server = "localhost";
$username = "root";
$password = "";
$con = mysqli_connect($server, $username, $password, "banking");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$flag = false;

if (isset($_POST['transfer'])) {
    $sender = $_SESSION['sender'];
    $receiver = $_POST["reciever"];
    $amount = $_POST["amount"];

    // Validate the transaction amount
    if ($amount <= 0) {
        die("Invalid transaction amount.");
    }

    // Check if the sender has sufficient balance
    $sql = "SELECT Balance FROM users WHERE name='$sender'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($amount > $row["Balance"] || $row["Balance"] - $amount < 100) {
                die("Transaction denied: Insufficient balance or balance below minimum threshold.");
            } else {
                $sql = "UPDATE `users` SET Balance=(Balance-$amount) WHERE Name='$sender'";
                
                if ($con->query($sql) === TRUE) {
                    $flag = true;
                } else {
                    die("Error in updating sender's balance: " . $con->error);
                }
            }
        }
    } else {
        die("Error: Sender not found.");
    }
}

if ($flag) {
    // Update the receiver's balance
    $sql = "UPDATE `users` SET Balance=(Balance+$amount) WHERE name='$receiver'";
    if ($con->query($sql) === TRUE) {
        $flag = true;
    } else {
        die("Error in updating receiver's balance: " . $con->error);
    }
}

if ($flag) {
    // Get sender's and receiver's account numbers
    $sql = "SELECT Acc_Number FROM users WHERE name='$sender' OR name='$receiver'";
    $result = $con->query($sql);
    $accounts = array();
    while ($row = $result->fetch_assoc()) {
        $accounts[] = $row['Acc_Number'];
    }

    // Insert transaction details into the transfer table
    $sql = "INSERT INTO `transfer`(s_name, s_acc_no, r_name, r_acc_no, amount) VALUES ('$sender', '$accounts[0]', '$receiver', '$accounts[1]', '$amount')";
    if ($con->query($sql) === TRUE) {
        // Redirect with success message
        $location = 'Details.php?user=' . $sender;
        header("Location: $location&message=success");
    } else {
        die("Error updating transaction record: " . $con->error);
    }
}

// Close the database connection
mysqli_close($con);
?>
