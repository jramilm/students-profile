<?php
include_once("../db.php"); // Include the Database class file
include_once("../province.php"); // Include the Student class file

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch province data by ID from the database
    $db = new Database();
    $province = new Province($db);
    $province_data = $province->read($id); // Implement the read method in the Province class

    if (!$province) {
        echo "Province not found.";
    }
} else {
    echo "Province ID not provided.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
    ];

    $db = new Database();
    $province = new Province($db);

    // Call the edit method to update the province data
    if ($province->update($id, $data)) {
        echo "Record updated successfully.";
        header('Location: province.view.php');
    } else {
        echo "Failed to update the record.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Edit Province</title>
</head>
<body>
<!-- Include the header and navbar -->
<?php include('../includes/navbar.php'); ?>

<div class="content">
    <h2>Edit Province Name</h2>
    <form action="#" method="post" name="form_edit">
        <input type="hidden" name="id" value="<?php echo $province_data['id']; ?>"/>

        <label for="name">Province Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $province_data['name']; ?>"/>

        <input type="submit" value="Update">
    </form>
</div>
<?php include('../templates/footer.html'); ?>
</body>
</html>
