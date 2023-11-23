<?php
include_once("../db.php");
include_once("../province.php");

$db = new Database();
$connection = $db->getConnection();
$province = new Province($db);

$search = isset($_GET['search']) ? $_GET['search'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Province Records</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<!-- Include the header -->
<?php include('../includes/navbar.php'); ?>

<div class="content">
    <div class="flex">
          <h2 style="width:25%">Province Records</h2>
		  <form method="GET" action="#" id="searchForm" class="searchForm">
		    <div class="container-search">
		      <input type="text" placeholder="Search" name="search" class="search" id="searchInput">
		      <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
			    <path d="M790.588 1468.235c-373.722 0-677.647-303.924-677.647-677.647 0-373.722 303.925-677.647 677.647-677.647 373.723 0 677.647 303.925 677.647 677.647 0 373.723-303.924 677.647-677.647 677.647Zm596.781-160.715c120.396-138.692 193.807-319.285 193.807-516.932C1581.176 354.748 1226.428 0 790.588 0S0 354.748 0 790.588s354.748 790.588 790.588 790.588c197.647 0 378.24-73.411 516.932-193.807l516.028 516.142 79.963-79.963-516.142-516.028Z" fill-rule="evenodd"></path>
		      </svg>
		    </div>
		  </form>
		</div>
		<table class="orange-theme">
			<thead>
			<tr>
				<th>Name</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			<!-- You'll need to dynamically generate these rows with data from your database -->

			<?php
			$results = $province->getAll();
			foreach ($results as $result) {
				?>
				<tr>
					<td><?php echo $result['name']; ?></td>
					<td>
						<a href="province_edit.php?id=<?php echo $result['id']; ?>"><i style="font-size:24px;color:forestgreen" class="fa fa-edit"></i></a>
						|
						<a href="province_delete.php?id=<?php echo $result['id']; ?>"><i style="font-size:24px;color:orangered" class="fa fa-trash"></i></a>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<div class="flex-between">
		  <a class="button-link" href="province_add.php">Add New Record</a>
		  <button class="button-link" id="refreshButton">Refresh</button>
		</div>
		
		<!--Pagination Section-->
		<div class="pagination">
			<?php
				$row = $province->getProvinceCount();
				$totalPages = ceil($row / 10);

				for ($i = 1; $i <= $totalPages; $i++) {
					echo '<a href="?page=' . $i . '&search=' . urlencode($search) . '" class="page-link">' . $i . '</a>';
				}
			?>
		</div>
	</div>
<?php include('../templates/footer.html'); ?>
</body>
</html>


<!--Scripts-->
<script>
    const searchInput = document.getElementById('searchInput');

	searchInput.addEventListener('keydown', function (event) {
		if (event.key === 'Enter') {
			updateURL();
			event.preventDefault(); 
		}
	});
	
	refreshButton.addEventListener('click', function () {
		clearSearch();
	});
	
	window.addEventListener('popstate', function (event) {
		location.reload();
	});

	function updateURL() {
		const searchTerm = searchInput.value.trim();
		const newURL = window.location.origin + window.location.pathname + '?search=' + encodeURIComponent(searchTerm);
		
		window.history.pushState({ path: newURL }, '', newURL);

		const form = document.getElementById('searchForm');
		form.submit();
	}
	
	function clearSearch() {
		searchInput.value = '';

		const newURL = window.location.origin + window.location.pathname;
		window.history.pushState({ path: newURL }, '', newURL);

		location.reload();
	}
</script>