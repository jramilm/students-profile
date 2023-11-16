<?php
include_once("../db.php"); // Include the Database class file
include_once("../town_city.php"); // Include the Student class file

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch town data by ID from the database
    $db = new Database();
    $town_city = new TownCity($db);
    $town_data = $town_city->read($id); // Implement the read method in the Town class

    if (!$town_data) {
        echo "Town not found.";
    }
} else {
    echo "Town ID not provided.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
    ];

    $db = new Database();
    $town_city = new TownCity($db);

    // Call the edit method to update the student data
    if ($town_city->update($id, $data)) {
        echo "Record updated successfully.";
    } else {
        echo "Failed to update the record.";
    }
    header('Location: towns.view.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Edit Student</title>
</head>
<body>
<!-- Include the header and navbar -->
<?php include('../templates/header.html'); ?>
<?php include('../includes/navbar.php'); ?>

<div class="content">
    <h2>Edit Town Name</h2>
    <form action="#" method="post">
        <input type="hidden" name="id" value="<?php echo $town_data['id']; ?>"/>

        <label for="name">Town Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $town_data['name']; ?>"/>

        <input type="submit" value="Update">
    </form>
</div>
<?php include('../templates/footer.html'); ?>
</body>
</html>
