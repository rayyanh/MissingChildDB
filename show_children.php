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

//    $sql = "SELECT personID,firstName,middleName,lastName,birthDate,age FROM Person WHERE personID = ?";
    
    // $sql = "Select personID, firstName, middleName, lastName, birthDate, age, locationName, streetAddress, cityName, stateCode
    // From Person 
    // Join Location
    // On Person.locationID = Location.locationID WHERE personID = ?";

    $sql = "Select personID, firstName, lastName, middleName, locationName, streetAddress, cityName, stateCode, 
            sex, height, weight, hairColor, eyeColor, race, birthDate, age
            From Location
            Join (Person 
            Join PersonAttribute
            On Person.personAttributeID = PersonAttribute.personAttributeID)
            On Person.locationID = Location.locationID WHERE personID = ?";

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
        $stmt->bind_result($personID,$firstName,$lastName,$middleName,$locationName,$streetAddress,$cityName,$stateCode,$sex,$height,$weight,$hairColor,$eyeColor,$race,$birthDate,$age);
        echo '<div>';
        while ($stmt->fetch()) {
            echo '<a href="show_children.php?id='. $firstName . '"></a>' . '<p><strong>Name: </strong>'. $firstName .'  '.$middleName .' '. $lastName . '</p>' . "<p><strong>Birth Date: </strong>$birthDate <br><strong>Age: </strong>$age </p><p><strong>Location: </strong>$locationName <br><strong>Street Address: </strong>$streetAddress <br><strong>State Code: </strong>$stateCode </p><p><strong>Height: </strong>$height ft<br><strong>Weight: </strong>$weight lbs</p><p><strong>Haircolor: </strong>$hairColor <br><strong>EyeColor: </strong>$eyeColor</p><p><strong>Race: </strong>$race</p>";
        }
        echo "</div>";
    ?>
        <div>
            <a href="update_children.php?id=<?= $personID ?>">Update Child Age</a>
            <br><br><br>
            <button type="button" class="btn btn-dark"><a class="text-white" href="show_children.php?id=<?= $personID - 1 ?>">Previous Child</a></button>
            <button type="button" class="btn btn-dark"><a class="text-white" href="show_children.php?id=<?= $personID + 1 ?>">Next Child</a></button>
            <button type="button" class="btn btn-dark"><a class="text-white" href="list_children.php">Back to list</a></button>
        </div>
    <?php
    }

    $conn->close();

    ?>
</>
</body>
</html>
