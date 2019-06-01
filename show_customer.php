<?php
/**
 * @Author: Rayyan Hussain
 * 
 * with code skeleton provided by Mark Kochanski
 */
require_once 'config.inc.php';
// Get Customer Number
$id = $_GET['id'];
if ($id === "") {
    header('location: list_children.php');
    exit();
}
if ($id === false) {
    header('location: list_children.php');
    exit();
}
if ($id === null) {
    header('location: list_children.php');
    exit();
}
?>
<html>
<head>
    <title>Missing Child Information Page</title>
    <link rel="stylesheet" href="base.css">
</head>
<body>
<?php
require_once 'header.inc.php';
?>
<br>
<div class = "container">
    <h2>Show Missing Child</h2>
    <?php

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database, $port);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

	// Prepare SQL using Parameterized Form (Safe from SQL Injections)
    // $sql = "SELECT CustomerNumber,CustomerName,StreetAddress,CityName,StateCode,PostalCode FROM Customer C " .
    //     "INNER JOIN Address A ON C.defaultAddressID = A.addressID WHERE CustomerNumber = ?";

    $sql = "SELECT personID,firstName,middleName,lastName,birthDate,age FROM Person WHERE personID = ?";
    $stmt = $conn->stmt_init();
    if (!$stmt->prepare($sql)) {
        echo "failed to prepare";
    }
    else {
		
		// Bind Parameters from User Input
        $stmt->bind_param('s',$id);
		
		// Execute the Statement
        $stmt->execute();
		
		// Process Results Using Cursor
        $stmt->bind_result($personID,$firstName,$middleName,$lastName,$birthDate,$age);
        echo '<div>';
        while ($stmt->fetch()) {
            echo '<a href="show_customer.php?id='. $firstName . '"></a>' . '<p><strong>Name: </strong>'. $firstName .'  '.$middleName .' '. $lastName . '</p>' . "<p><strong>Birth Date: </strong>$birthDate <br><strong>Age: </strong>$age </p>";
        }
        echo "</div>";
    ?>
        <div>
            <a href="update_customer.php?id=<?= $personID ?>">Update Child Age</a>
        </div>
    <?php
    }

    $conn->close();

    ?>
</>
</body>
</html>
