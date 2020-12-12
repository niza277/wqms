<div class="container">
		<div style="background-color:#3388FF !important" class="jumbotron">
		<a href="<?= site_url(); ?>" class="{ text-decoration: none !important}">
			<h1 style="color:white" style="text-align:center">Water Quality Monitoring System</h1>
		</a>
		<p>The best WQMS in the world</p>
	</div>
	<p class="lead">
			<a class="btn btn-primary btn-lg" href="<?= site_url('home/historical'); ?>" role="button">Historical Data</a>
			<a href='<?= site_url('home/getExcelData')?>'><button class='btn btn-primary btn-lg'>Generate Excel</button></a>
			<a href='<?= site_url('home/viewExcel')?>'><button class='btn btn-primary btn-lg'>View Data</button></a>
	</p>
	<br>
	<br>
	<div class="row">
		<div class="col-md-6">
			<h2>Choose The Date and Time</h2>
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1">Choose Date</span>
				</div>
				<input type="date" name="date_2" id="date_2" class="form-control"/>
			</div>
			<br>
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1">Choose Start Time</span>
				</div>
				<select name="time_start" id="time_start" class="form-control">
					<option value="">none</option>
					<?php for($i = 1; $i < 25; $i++): ?>
						<option value="<?= $i?>"><?= $i?></option>	
					<?php endfor; ?>
				</select>
			</div>
			<br>
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1">Choose End Time</span>
				</div>
				<select name="time_end" id="time_end" class="form-control">
					<option value="">none</option>
					<?php for($i = 1; $i < 25; $i++): ?>
						<option value="<?= $i?>"><?= $i?></option>	
					<?php endfor; ?>
				</select>
			</div>
			<br>
			<button class="btn btn-block btn-primary" onclick="getDatetime();">Submit</button>
		</div>
		<div class="col-md-6">
			<h2>Choose The Date</h2>
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1">Choose Date</span>
				</div>
				<input type="date" name="date" id="date" class="form-control">
			</div>
			<br>
			<button class="btn btn-block btn-primary" onclick="getDate();">Submit</button>
		</div>
	</div>
</div>

<script type="text/javascript">
	function getDate() {
		var datetime = $("#date").val();
		datetime = new Date(datetime);
		var month = ("0" + (datetime.getMonth() + 1)).slice(-2);
		var date = ("0" + datetime.getDate()).slice(-2);
		var year = datetime.getFullYear();
		window.location.href = "<?= site_url()?>/home/historical?year="+year+"&month="+month+"&date="+date;

	}

	function getDatetime() {
		var datetime = $("#date_2").val();
		var starttime = $("#time_start").val();
		var endtime = $("#time_end").val();
		datetime = new Date(datetime);
		var month = ("0" + (datetime.getMonth() + 1)).slice(-2);
		var date = ("0" + datetime.getDate()).slice(-2);
		var year = datetime.getFullYear();
		window.location.href = "<?= site_url()?>/home/historicalDatetime?year="+year+"&month="+month+"&date="+date+"&start="+starttime+"&end="+endtime;
	}
</script>