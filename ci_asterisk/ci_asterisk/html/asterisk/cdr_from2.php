<?php
//require_once('authorize.php');
//セッションの開始
//require_once('startsession.php');
require_once('header.php');
//require_once('appvars.php');
?>
<!doctype html>
<html>

<head>
	<title>Bar Chart</title>
	<script src="web/js/Chartjs/dist/Chart.min.js"></script>
	<!--<script src="web/js/Chartjs/samples/utils.js"></script>-->
	<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	</style>
</head>

<body>


<canvas id="myChart"></canvas>
<script>
	var ctx = document.getElementById('myChart').getContext('2d');
	var chart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ["1","2","3","4"],
			datasets: [{
				label: "mydata",
				backgroundColor: 'rgb(255,99,132)',
				data: [0,10,20,30],
			}]
		},
		options:{

		}
	});


</script>
</body>

</html>

<?php
require_once('footer.php');
?>
