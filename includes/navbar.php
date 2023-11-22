<!--
<div class="sidebar">
        <h1>Menu</h1>
        <ul>
            <li><a href="/students-profile/index.php">Home</a></li>
            <li><a href="/students-profile/views/students.view.php">Students</a></li>
            <li><a href="/students-profile/views/towns.view.php">Town</a></li>
            <li><a href="/students-profile/views/province.view.php">Province</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">Reports</a>
                <div class="dropdown-content">
                    <a href="#">Report 1</a>
                    <a href="#">Report 2</a>
                    <a href="#">Report 3</a>
                </div>
            </li>
        </ul>
</div>
-->
<link rel="stylesheet" type="text/css" href="../css/styles.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none;" id="sidebar">
  <button onclick="w3_close()" class="w3-bar-item w3-large w3-button">Close &times;</button>
  <hr class="thin" />
  <a href="/students-profile/index.php" class="w3-bar-item w3-button">Dashboard</a>
  <a href="/students-profile/views/students.view.php" class="w3-bar-item w3-button">Students</a>
  <a href="/students-profile/views/towns.view.php" class="w3-bar-item w3-button">Town</a>
  <a href="/students-profile/views/province.view.php" class="w3-bar-item w3-button">Province</a>
</div>

<div class="w3-teal">
  <button class="w3-button w3-teal w3-xlarge" onclick="w3_open()">☰</button>
  <div class="w3-container indent">
    <h1>Students Profile</h1>
  </div>
</div>

<script>
function w3_open() {
  document.getElementById("sidebar").style.display = "block";
}

function w3_close() {
  document.getElementById("sidebar").style.display = "none";
}
</script>
     