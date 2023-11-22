<?php
include_once("db.php");
include_once("student.php");

$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <!-- Include the header -->
    <?php include('includes/navbar.php'); ?>

<div class="content">
</div>
</body>
<?php include('templates/footer.html'); ?>
</html>
