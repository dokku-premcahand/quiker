<div class="col-lg-offset-2 col-lg-8">
	<div class="col-lg-12 center"><h3 class="MT0">Agent Start Day Listing</h3></div>
	<div class="col-lg-12">
		<form class="form-horizontal" action="<?php echo base_url("admin/exportAgent"); ?>" method="POST" id="searchForm">
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-1 control-label">From</label>
		    	<div class="col-sm-3">
		      		<input type="text" name="fromDate" class="form-control datepicker" id="fromDate" placeholder="From Date"
		      		value="<?php echo (!empty($newData['post']['fromDate'])) ? $newData['post']['toDate'] : ""; ?>">
		    	</div>
		    	<label for="inputPassword3" class="col-sm-1 control-label">To</label>
		    	<div class="col-sm-3">
		      		<input type="text" name="toDate" class="form-control datepicker" id="toDate" placeholder="To Date"
		      		value="<?php echo (!empty($newData['post']['toDate'])) ? $newData['post']['toDate'] : ""; ?>">
				</div>
				<div class="col-sm-4" style="text-align: right;">
					<button type="submit" class="btn btn-sm btn-success">Pull</button>
				</div>
			</div>
		</form>
	</div>
	<div class="col-lg-12">
		<table class="table table-bordered" id="agentTable">
			<thead>
				<tr>
					<td>Id</td>
					<td>Name</td>
					<td>Username</td>
					<td>Start day(Date/Time)</td>
				</tr>
			</thead>
			<tbody>
				<?php
					if(!empty($newData['data'])){
						foreach($newData['data'] as $pramoterData){
				?>
						<tr>
							<td><?php echo $pramoterData->id; ?></td>
							<td><?php echo $pramoterData->name; ?></td>
							<td><?php echo $pramoterData->username; ?></td>
							<td><?php echo $pramoterData->start_date_time; ?></td>
						</tr>
				<?php
						}
					}else{
				?>
					<tr>
					<td  colspan="7">
						No Data Present
					</td>
					</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
</div>