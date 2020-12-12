	<div class="container">
		<div style="background-color:#3388FF !important" class="jumbotron">
			<a href="<?= site_url(); ?>" class="{ text-decoration: none !important}">
				<h1>Water Quality Monitoring System</h1>
			</a>
			<p>The best WQMS in the world</p>
		</div> 
		<p class="lead">
			<a class="btn btn-primary btn-lg" href="<?= site_url('home/historical'); ?>" role="button">Historical Data</a>
			<a href='<?= site_url('home/getExcelData')?>'><button class='btn btn-primary btn-lg'>Generate Excel</button></a>
			<a href='<?= site_url('home/viewExcel')?>'><button class='btn btn-primary btn-lg'>View Data</button></a>
		</p>
		<br>
		<script type="text/javascript">
		$(document).ready(function(){

			var phdps = [];
			var turbiditydps = [];
			$.ajax({
				url: "<?= site_url('reading/selectHistoryDatetime/').$year.'/'.$month.'/'.$date.'/'.sprintf("%02d",$start).'/'.sprintf("%02d",$end); ?>",
				type: "get",
				dataType: "json",
				success: function(data) {
					var totalPh = 0, totalTurbidity = 0, avgPh = 0, avgTurbidity = 0;
					for(var i = 0; i < data.length; i++) {
						var d = new Date(data[i]['datetime']);
						totalPh += parseFloat(data[i]['phReading']);
						totalTurbidity += parseFloat(data[i]['turbidityReading']);
						phdps.push({x:d, y : parseFloat(data[i]['phReading'])});
						turbiditydps.push({x:d, y : parseFloat(data[i]['turbidityReading'])});
					}
					avgPh = totalPh/data.length;
					avgTurbidity = totalTurbidity/data.length;
					$("#avgPh").html("Average: " + avgPh);
					$("#avgTurbidity").html("Average: " + avgTurbidity);
					var phChart = new CanvasJS.Chart("phChartContainer",{
						title :{
							text: "Treated Water : pH Reading"
						},
						axisX: {						
							title: "Reading Time"
						},
						axisY: {						
							title: "pH"
						},
						data: [{
							type: "line",
							dataPoints : phdps
						}],
						options: {
							scales: {
								xAxes: [{
									time: {
										unit: 'hour'
									}
								}]
							}	
						}
					}).render();

					var turbidityChart = new CanvasJS.Chart("turbidityChartContainer",{
						title :{
							text: "Treated Water : Turbidity Reading"
						},
						axisX: {						
							title: "Reading Time"
						},
						axisY: {						
							title: "Turbidity"
						},
						data: [{
							type: "line",
							dataPoints : turbiditydps
						}],
						options: {
							scales: {
								xAxes: [{
									time: {
										unit: 'hour'
									}
								}]
							}	
						}
					}).render();
				}, error: function(xhr, status, err) {
					console.warn(xhr.responseText)
				}
			});
		});
	</script>
	<div id="phChartContainer" style="height: 300px; width: 100%;"></div>
	<br>
	<h2 id="avgPh" style="text-align:center">Average: {average ph}</h2>
	<br>
	<br>
	<div id="turbidityChartContainer" style="height: 300px; width: 100%;"></div>
	<br>
	<h2 id="avgTurbidity" style="text-align:center">Average: {average turbidity}</h2>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
		
	</div>