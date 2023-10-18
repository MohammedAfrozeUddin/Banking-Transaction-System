<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIP Banking</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="users.php">Users</a>
        <a href="transfer.php">Transfer Money</a>
        <a href="history.php">History</a>
    </div>
    
    <div style="font-family: 'Gabriela', serif; font-size: 40px; text-align: center; margin: 20px;">Transaction History</div>
    
    <table>
        <tr>
            <th>Sender's Name</th>
            <th>Sender's Account</th>
            <th>Receiver's Name</th>
            <th>Receiver's Account</th>
            <th>Amount</th>
            <th>Date and Time</th>
        </tr>

        <?php
        // Database connection configuration
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "banking";

        // Create a connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Sorry, we failed to connect: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM `transfer`";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["s_name"] . "</td>";
                echo "<td>" . $row["s_acc_no"] . "</td>";
                echo "<td>" . $row["r_name"] . "</td>";
                echo "<td>" . $row["r_acc_no"] . "</td>";
                echo "<td>" . $row["amount"] . "</td>";
                echo "<td>" . $row["date_time"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No records found</td></tr>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </table>
</body>
</html>
