<?php
include_once("../db.php"); // Include the Database class file
include_once("../student_details.php"); // Include the Student class file
include_once("../town_city.php"); // Include the town city class file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'name' => $_POST['name'],
    ];

    // Instantiate the Database and Town City classes
    $database = new Database();
    $town_city = new TownCity($database);
    $town_city_id = $town_city->create($data);

    if ($town_city_id) {
        //town city record successfully created

        // Retrieve town city details from the form
        $towncityDetails = [
            'name' => $_POST['name'],
        ];

        // Create town city details linked to the town city
        $towncityDetails = new TownCity($database);

        if ($towncityDetails->create($towncityDetails)) {
            echo "Record inserted successfully.";
        } else {
            echo "Failed to insert the record.";
        }
    }
    header("Location: towns.view.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">

    <title>Add Town City Data</title>
</head>
<body>
<!-- Include the header and navbar -->
<?php include('../templates/header.html'); ?>
<?php include('../includes/navbar.php'); ?>

<div class="content">
    <h1>Add Town City Data</h1>
    <form action="#" method="post" class="centered-form">

        <label for="name">Town City Name</label>
        <input type="text" id="name" name="name" required>

        <input type="submit" value="Add Town City">
    </form>
</div>

<?php include('../templates/footer.html'); ?>
</body>
</html>
