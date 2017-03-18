<div class="col-lg-offset-2 col-lg-8">
	<div class="col-lg-12 center"><h3 class="MT0">Agent Start Day Listing</h3></div>
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
					foreach($newData as $pramoterData){
				?>
					<tr>
						<td><?php echo $pramoterData->id; ?></td>
						<td><?php echo $pramoterData->name; ?></td>
						<td><?php echo $pramoterData->username; ?></td>
						<td><?php echo $pramoterData->start_date_time; ?></td>
					</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
</div>