<?php
include_once("db.php");
include_once("student.php");

$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);

$data = $student->getGenderData();
$data2 = $student->getPopulationData();
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
            <canvas id="genderPie" width="250" height="250"></canvas>
        </div>
        <div class="card-body">
            <h2>Population Chart</h2>
            <hr>
            <canvas id="populationChart" width="350" height="350"></canvas>
        </div>
    </div class="flex">
</div>
</body>
<?php include('templates/footer.html'); ?>
</html>

<!--Scripts-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    var labels = [];
    var counts = [];

    <?php foreach ($data as $item): ?>
    labels.push('<?php echo $item["gender"] === "0" ? "Male" : "Female"; ?>');
    counts.push(<?php echo $item["count"]; ?>);
    <?php endforeach; ?>

    const gender = document.getElementById('genderPie').getContext('2d');
    const pieChart = new Chart(gender, {
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

<script>
    var labels = [];
    var datasets = {};

    <?php foreach ($data2 as $item): ?>
    var province = '<?php echo $item["province_name"]; ?>';
    var townCity = '<?php echo $item["town_name"]; ?>';
    var count = <?php echo $item["count"]; ?>;

    labels.push(townCity);

    if (!datasets[province]) {
        datasets[province] = [];
    }
    datasets[province].push(count);
    <?php endforeach; ?>

    // Create Chart
    const population = document.getElementById('populationChart').getContext('2d');
    const barChart = new Chart(population, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: Object.keys(datasets).map(province => ({
                label: province,
                data: datasets[province],
                backgroundColor: getRandomColor(),
            }))
        },
        options: {
            title: {
                display: true,
                text: 'Population Percentage by Town/City'
            },
            scales: {
                x: { stacked: false },
                y: { stacked: false }
            }
        }
    });
    console.log(labels);
    console.log(datasets);
</script>