<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIP Banking</title>
    <link rel="stylesheet" href="CSS/style.css">
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="users.php">Users</a>
        <a href="transfer.php">Transfer Money</a>
        <a href="history.php">History</a>
    </div>

    <h3 style="font-family: 'Gabriela', serif; font-size: 40px; text-align: center; margin: 20px;">Make a Transaction</h3>

    <div class="card container">
        <?php
        if ($_GET['message'] == 'success') {
            echo "<h3><p style='color:green;' class='messagehide'>Transaction was completed successfully</p></h3>";
        }
        if ($_GET['message'] == 'transactionDenied') {
            echo "<h3><p style='color:red;' class='messagehide'>Transaction Failed</p></h3>";
        }
        ?>

        <form action="transfer.php" method="POST">
            <label for="reciever"><b>To:</b></label>
            <select name="reciever" id="dropdown" class="textbox" required>
                <option>Select Recipient</option>
                <?php
                $db = mysqli_connect("localhost", "root", "", "banking");
                $res = mysqli_query($db, "SELECT * FROM users WHERE name!='$user'");
                while ($row = mysqli_fetch_array($res)) {
                    echo ("<option>" . $row['Name'] . "</option>");
                }
                ?>
            </select>
            <br><br>

            <label for="sender"><b>From:</b></label>
            <span style="font-size: 1.2em;"><input id="myinput" name="sender" class="textbox" disabled type="text" value='<?php echo "$user"; ?>'></span>
            <br><br>

            <label for="amount"><b>Amount (&#8377;):</b></label>
            <input name="amount" type="number" min="100" class="textbox" required>
            <br><br>

            <button id="transfer" name="transfer">Transfer</button>
        </form>
    </div>
</body>
</html>
