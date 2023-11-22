<?php
include_once("db.php");
include_once("student.php");

$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);

$data = $student->getGenderData();
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
    <div class="flex">
        <div class="card-body">
            <h2>Gender Percentage Chart</h2>
            <hr>
            <canvas id="genderPie"></canvas>
        </div>
        <div class="card-body">
            <h2>Test Chart</h2>
            <hr>
            <canvas id="genderPie2" width="400" height="400"></canvas>
        </div>
    </div>
</div>
</body>
<?php include('templates/footer.html'); ?>
</html>

<!--Scripts-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var labels = [];
    var counts = [];

    <?php foreach ($data as $item): ?>
    labels.push('<?php echo $item["gender"] === "0" ? "Male" : "Female"; ?>');
    counts.push(<?php echo $item["count"]; ?>);
    <?php endforeach; ?>

    const ctx = document.getElementById('genderPie').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: counts,
                backgroundColor: ['#3498db', '#e74c3c']
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Gender Percentage'
            }
        }
    });
</script>