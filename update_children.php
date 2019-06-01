<?php
/**
 * Created by PhpStorm.
 * User: MKochanski
 * Date: 7/24/2018
 * Time: 3:07 PM
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
    <h2>Update Child Age</h2>
    <?php

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database, $port);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

	// Check the Request is an Update from User -- Submitted via Form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $age = $_POST['age'];
        if ($age === null)
            echo "<div><i>Specify a new age</i></div>";
        else if ($age === false)
            echo "<div><i>Specify a new age</i></div>";
        else if (trim($age) === "")
            echo "<div><i>Specify a new age</i></div>";
        else {
			
            /* perform update using safe parameterized sql */
            $sql = "UPDATE Person SET age = ? WHERE personID = ?";
            $stmt = $conn->stmt_init();
            if (!$stmt->prepare($sql)) {
                echo "failed to prepare";
            } else {
				
				// Bind user input to statement
                $stmt->bind_param('ss', $age,$id);
				
				// Execute statement and commit transaction
                $stmt->execute();
                $conn->commit();
            }
        }
    }

    /* Refresh the Data */
    $sql = "SELECT personID,firstName,middleName,lastName,birthDate,age FROM Person WHERE personID = ?";
    $stmt = $conn->stmt_init();
    if (!$stmt->prepare($sql)) {
        echo "failed to prepare";
    }
    else {
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $stmt->bind_result($personID,$firstName,$middleName,$lastName,$birthDate,$age);
        ?>
        <form method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
        <?php
        while ($stmt->fetch()) {
            echo '<a href="show_children.php?id='. $firstName . '"></a>' . '<p><strong>Name: </strong>'. $firstName .'  '.$middleName .' '. $lastName . '</p>' . "<p><strong>Birth Date: </strong>$birthDate <br><strong>Age: </strong>$age </p>";

        }
    ?>
            <!-- <input type="text" name="age" class="form-control col-md-6"  placeholder="Input New Age">
            <button class = "btn col-auto" type="submit number">Update</button> -->
            <div class="input-group mb-3">
                <input type="text" name ="age" class="form-control" placeholder="Input New Age">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit number">Update</button>
                </div>
            </div>
        
        </form>
    <?php
    }

    $conn->close();

    ?>
</>
</body>
</html>
