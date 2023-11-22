<?php
include_once("../db.php"); // Include the Database class file
include_once("../student.php"); // Include the Student class file
include_once("../student_details.php"); // Include the Student class file
include_once("../town_city.php");
include_once("../province.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [    
        'student_number' => $_POST['student_number'],
        'first_name' => $_POST['first_name'],
        'middle_name' => $_POST['middle_name'],
        'last_name' => $_POST['last_name'],
        'gender' => $_POST['gender'],
        'birthday' => $_POST['birthday'],
        'contact_num' => $_POST['contact_number'],
        'street' => $_POST['street'],
        'town_city' => $_POST['town_city'],
        'province' => $_POST['province'],
        'zip' => $_POST['zip_code']
    ];

    // Instantiate the Database and Student classes
    $database = new Database();
    // create data in student table
    $student = new Student($database);
    $student_id = $student->create($data);
    // create data in student_details table
    $student_details = new StudentDetails($database);
    $student_details_id = $student_details->create($data);

    header("Location: students.view.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">

    <title>Add Student Data</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h1>Add Student Data</h1>
    <form action="" method="post" class="centered-form">
        <label for="student_number">Student Number:</label>
        <input type="text" name="student_number" id="student_number" required>

        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" required>

        <label for="middle_name">Middle Name:</label>
        <input type="text" name="middle_name" id="middle_name">

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" required>

        <label for="gender">Gender:</label>
        <select name="gender" id="gender" required>
            <option value="0">Male</option>
            <option value="1">Female</option>
        </select>

        <label for="birthday">Birthdate:</label>
        <input type="date" name="birthday" id="birthday" required>

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" required>

        <label for="street">Street:</label>
        <input type="text" id="street" name="street" required>



        <label for="town_city">Town / City:</label>
        <select name="town_city" id="town_city" required>
        <?php
            $database = new Database();
            $towns = new TownCity($database);
            $results = $towns->getAll();
            // echo print_r($results);
            foreach($results as $result)
            {
                echo '<option value="' . $result['id'] . '">' . $result['name'] . '</option>';
            }
        ?>
        </select>

        <label for="province">Province:</label>
        <select name="province" id="province" required>
        <?php
            $database = new Database();
            $provinces = new Province($database);
            $results = $provinces->getAll();
            // echo print_r($results);
            foreach($results as $result)
            {
                echo '<option value="' . $result['id'] . '">' . $result['name'] . '</option>';
            }
        ?>
        </select>

        <label for="zip_code">Zip Code:</label>
        <input type="text" id="zip_code" name="zip_code" required>
        <input type="submit" value="Add Student">
    </form>
    </div>
    
    <?php include('../templates/footer.html'); ?>
</body>
</html>
