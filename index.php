<?php
/**
 * @Author: Rayyan Hussain
*/?>
<html>
<head>
    <title>Missing Children - Missing Child DB</title>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<?php
require_once 'header.inc.php';
?>
<div class = "container paddingAdd">
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Missing Children Database</h1>
    <p class="lead">This is an online repository of missing children. You can see all missing children, search based on state, and more.</p>
    <p>This is <strong>NOT</strong> a place to report missing children. For that, please call 911.</p>
  </div>
</div>
    <h2>Available commands: </h2>
    <br>
    <button type="button" class="btn btn-dark"><a class = "text-white"href="list_children.php">List <em>all</em> missing children</a></button>
    <!-- <button type="button" class="btn btn-dark"><a class = "text-white"href="list_children.php">Select based on ???</a></button> -->
    <button type="button" class="btn btn-dark"><a class = "text-white"href="list_children.php">Update information</a></button>
</div>
</body>
</html>
