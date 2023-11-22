<?php
include_once("../db.php");
include_once("../student.php");
include_once("../student_details.php");

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
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <!-- Include the header -->
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2>Student Records</h2>
    <table class="orange-theme">
        <thead>
            <tr>
                <th>Student Number</th>
                <th>Full Name</th>
                <th>Contact Number</th>
                <th>Gender</th>
                <th>Birthdate</th>
                <th>Town ID</th>
                <th>Province ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- You'll need to dynamically generate these rows with data from your database -->
       
            
            
            <?php
            $results = $student->displayAllWithDetails();
            foreach ($results as $result) {
            ?>
            <tr>
                <td><?php echo $result['student_number']; ?></td>
                <td><?php echo $result['first_name'] . " " . $result['middle_name'] . " " . $result['last_name']; ?></td>
                <td><?php echo $result['contact_number']; ?></td>
                <td><?php if($result['gender'] == '0') {echo 'M';} else {echo 'F';}?></td>
                <td><?php echo date("M j Y", strtotime($result['birthday'])); ?></td>
                <td><?php echo $result['town_city']; ?></td>
                <td><?php echo $result['province']; ?></td>
                <td>
                    <a href="student_edit.php?id=<?php echo $result['id']; ?>">Edit</a>
                    |
                    <a href="student_delete.php?id=<?php echo $result['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>

           
        </tbody>
    </table>
        
    <a class="button-link" href="student_add.php">Add New Record</a>

        </div>
        
        <!-- Include the header -->
  
    <?php include('../templates/footer.html'); ?>


    <p></p>
</body>
</html>
