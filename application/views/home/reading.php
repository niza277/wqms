
	<div class="container">
		<!-- <div class="jumbotron">  -->
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
		  var phReading;
		  var turbidityReading;

		  // acceptable range
		  var maxPh = 7.3;
		  var minPh = 6.2;
		  var maxTurbidity = 2.1;
		  var minTurbidity = 0.4;

		  // ajax to get data from arduino through json
		  $.ajax({
			url: "<?= base_url();?>/index.php/home/json",
			url: "http://192.168.43.82/phRead",
			type: "post",
			dataType: "json",
			async: false,
			success: function(data) {
				var d = new Date();
				phReading = data.reading.ph;
				turbidityReading = data.reading.turbidity;
				phdps.push({x:new Date(), y : phReading});
				turbiditydps.push({x:new Date(), y : turbidityReading});
			}, error: function(xhr, status, err) {
				console.warn(xhr.responseText)
			}

		});

		// line graph for ph reading
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
				dataPoints : phdps // ph data point set
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
		});

		// line graph for turbidity reading
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
				dataPoints : turbiditydps // turbidity data point set
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
		});

		phChart.render();
		turbidityChart.render();
		var updateInterval = 1000; // in ms

		var updateChart = function () {
			$.ajax({
				 // url: "http://192.168.43.82/phRead",
				 url: "<?= base_url();?>/index.php/home/json",
				type: "post",
				dataType: "json",
				async: false,
				success: function(data) {
					phReading = data.reading.ph;
					turbidityReading = data.reading.turbidity;
					var audio = new Audio("<?= base_url('assets/sound/sireen.mp3')?>");
					if (phReading < maxPh && phReading > minPh) {
						$("#phReading").css("color", "black");
						
					} else {
						$("#phReading").css("color", "red");
						$("#phReading").html(phReading + " [out of range]"); 
						if (parseInt(phReading) > 14) {
							phReading -= 6;
						}
						console.log(phReading);
						$.post("<?= site_url('sms/send_sms') ?>", {"message" : "PH reading exceeds normal range: pH :"+phReading}, function() {
							console.log("sms is sent");
						})
						audio.play();
					} 

					if (turbidityReading < maxTurbidity && turbidityReading > minTurbidity) {
						$("#turbidityReading").css("color", "black");
					} else {
						$("#turbidityReading").css("color", "red");
						$("#turbidityReading").html(turbidityReading + " [out of range]");
						$.post("<?= site_url('sms/send_sms') ?>", {"message" : "Turbidity reading exceeds normal range: tubidity :" + turbidityReading}, function() {
							console.log("sms is sent");
						})
						audio.play();
					} 
					$("#phReading").html(phReading);
					$("#turbidityReading").html(turbidityReading);
				}

			});
			var d = new Date();
			phdps.push({x:new Date(),y: phReading});
			turbiditydps.push({x:new Date(),y: turbidityReading});
			
			if (phdps.length >  20 )
			{
				phdps.shift();				
				turbiditydps.shift();				
			}

			phChart.render();	
			turbidityChart.render();	

		};

		var insertDB = function () {
			$.get("<?= site_url('reading/add');?>", {"ph": phReading, "turbidity": turbidityReading}, function(data) {
				console.log(data.message);
			}, 'json');
		}

	setInterval(function(){updateChart()}, updateInterval); // update graph for 1 sec : chart graph
	setInterval(function(){insertDB()}, updateInterval*60*5); //  insert ke mysql in 5min masuk ke db
	});
	</script>
	<div class="row">
		<div class="col-md-6">
			<h3 style="text-align: center;">pH Reading</h3>
			<h4 style="text-align: center;" id="phReading">{ph reading}</h4>
		</div>
		<div class="col-md-6">
			<h3 style="text-align: center;">Turbidity Reading</h3>
			<h4 style="text-align: center;" id="turbidityReading">{turbidity reading}</h4>
		</div>
	</div>
	<div id="phChartContainer" style="height: 300px; width: 100%;"></div>
	<br>
	<br>
	<div id="turbidityChartContainer" style="height: 300px; width: 100%;"></div>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
		
	</div>
	