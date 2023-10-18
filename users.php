<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>GRIP Banking</title>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="users.php">Users</a>
        <a href="transfer.php">Transfer Money</a>
        <a href="history.php">History</a>
    </div>
    <div style="font-size: 30px; text-align: center; margin: 20px;">Bank's users</div>
    <div class="customer_table">
        <table>
            <tr>
                <th>Sr.No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Balance</th>
                <th>Details</th>
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
                die("Connection failed: " . $conn->connect_error);
            }

            // SQL query to fetch user data
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["Sr.No."] . "</td>";
                    echo "<td>" . $row["Name"] . "</td>";
                    echo "<td>" . $row["Email"] . "</td>";
                    echo "<td>" . $row["Gender"] . "</td>";
                    echo "<td>" . $row["Balance"] . "</td>";
                    echo '<td><a href="Details.php?user=' . $row["Name"] . '&message=no" type="button" name="user" id="users1"><span>Expand</span></a></td>';
                    echo "</tr>";
                }
            } else {
                echo "No records found";
            }

            // Close the database connection
            $conn->close();
            ?>
        </table>
    </div>
    <script src="JS/jsfile.js"></script>
</body>
</html>
