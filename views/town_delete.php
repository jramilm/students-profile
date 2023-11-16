<?php
include_once("../db.php"); // Include the Database class file
include_once("../town_city.php"); // Include the Student class file

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id']; // Retrieve the 'id' from the URL

    // Instantiate the Database and Student classes
    $db = new Database();
    $town_city = new TownCity($db);

    // Call the delete method to delete the student record
    if ($town_city->delete($id)) {
        echo "Record deleted successfully.";
    } else {
        echo "Failed to delete the record.";
    }
    header("Location: towns.view.php");
}
?>