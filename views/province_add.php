<?php
include_once("../db.php"); // Include the Database class file
include_once("../student_details.php"); // Include the Student class file
include_once("../province.php"); // Include the town city class file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'name' => $_POST['name'],
    ];

    // Instantiate the Database and Town City classes
    $database = new Database();
    $province = new Province($database);
    $province_id = $province->create($data);

    header("Location: province.view.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">

    <title>Add Province Data</title>
</head>
<body>
<!-- Include the header and navbar -->
<?php include('../includes/navbar.php'); ?>

<div class="content">
    <h1>Add Province Data</h1>
    <form action="#" method="post" class="centered-form">

        <label for="name">Province Name</label>
        <input type="text" id="name" name="name" required>

        <input type="submit" value="Add Province">
    </form>
</div>

<?php include('../templates/footer.html'); ?>
</body>
</html>
