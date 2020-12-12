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
<title> Reading</title>
<script>
$( document ).ready(function() {	
	$('#reading').DataTable({
		 "processing": true,
		 "sAjaxSource":"<?= site_url('reading/getDateTimeReading')?>",
		 "pageLength": 5,
         "dom": 'lBfrtip',
         "bDestroy": true,
		 "buttons": [
            {
                extend: 'collection',
                text: 'Export',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            }
        ]
	});	
});
</script>
<style>
 .dataTables_length {
  	margin-top:20px;
  }
  div.dt-buttons {
    position: relative;
    float: left;
    margin-left: 20px;
	margin-top:12px;
	font-size:16px;
	font-weight:bold;
 }
 .dataTables_filter {
	 margin-top:20px;
 }
</style>
<div class="container">
	<h2>Generete Excel history</h2>	
	<div class="table-responsive">		
		<table id="reading" class="display" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Reading id</th>
                <th>Date Time</th>
                <th>pH Reading</th>      
                <th>Turbidity Reading</th>           
            </tr>
        </thead>       
    </table>	
	</div>	
	<!-- <div style="margin:50px 0px 0px 0px;">
		<a class="btn btn-default read-more" style="background:#3399ff;color:white" href="http://www.phpzag.com/export-jquery-datatable-data-to-pdfexcelcsv-copy-with-php" title="">Back to Tutorial</a>			
	</div> -->		
</div>
<!-- <?php include('footer.php');?> -->


