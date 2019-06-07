<?php
/**
 * Created by PhpStorm.
 * User: MKochanski
 * Date: 7/24/2018
 * Time: 3:07 PM
 */
require_once 'config.inc.php';

?>
<html>
<head>
    <title>Sample PHP Database Program</title>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
<?php
require_once 'header.inc.php';
?>
<div class = "container">
    <br>
    <h2>Missing Child List</h2>
    <?php
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database, $port);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

	// Prepare SQL Statement
    //$sql = "SELECT CustomerNumber,CustomerName FROM Customer ORDER BY CustomerName";
    //$sql = "SELECT personID,firstName,middleName,lastName FROM Person";
    $sql = "Select personID,firstName,middleName,lastName
    From Person 
    Join Location
    On Person.locationID = Location.locationID";
    $stmt = $conn->stmt_init();
    if (!$stmt->prepare($sql)) {
        echo "failed to prepare";
    }
    else {
		
		// Execute the Statement
        $stmt->execute();
		
		// Loop Through Result
        $stmt->bind_result($personID,$firstName, $middleName, $lastName);
        echo "<ul>";
        while ($stmt->fetch()) {
            // echo "<p>" . $firstName," ",$middleName," ",$lastName . "</p>";
            echo '<li><a href="show_children.php?id='  . $personID . '">'  . $firstName," ",$lastName . '</a></li>';
        }
        echo "</ul>";
    }

	// Close Connection
    $conn->close();

    ?>
</div>
</body>
</html>
