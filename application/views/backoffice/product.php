<div class="col-lg-offset-2 col-lg-8">
	<div class="col-lg-12 center"><h3 class="MT0">Product Listing</h3></div>
	<?php
		if($this->session->flashdata('error') || validation_errors()){
	?>
		<div class="col-lg-offset-2 col-lg-8 alert alert-danger">
			<?php echo $this->session->flashdata('error'); 
				$this->session->set_flashdata('error',''); 
			?>
			<?php echo validation_errors();?>
		</div>
	<?php		
		}
	?>
	<div class="col-lg-12 center">
		<div class="col-lg-12">
			<form class="form-horizontal" action="<?php echo base_url("backoffice/searchProduct"); ?>" method="POST" id="searchForm">
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
						<!-- <button type="submit" class="btn btn-sm btn-primary">Search</button> -->
						<button type="button" class="btn btn-sm btn-success" id="pullSearchData">Pull</button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-lg-12">
			<form class="form-horizontal" action="<?php echo base_url("backoffice/exportAll"); ?>" method="POST">
				<div class="form-group">
					<div class="col-sm-offset-8 col-sm-4" style="text-align: right;">
						<button type="button" class="btn btn-sm btn-danger" id="markAsDone">Mark As Done</button>
						<button type="button" class="btn btn-sm btn-danger" id="exportSelected">Export</button>
					</div>
				</div>
				<input type="hidden" name="productIds" id="productsIds" value=""/>
			</form>
		</div>
	</div>
	<form action="<?php echo base_url('backoffice/changeProductStatus'); ?>" method="POST" id="changeProductStatus">
	<div class="col-lg-12">
		<table class="table table-bordered" id="productTable">
			<thead>
				<tr>
					<td>Sequence</td>
					<td>Name</td>
					<td>Phone Number</td>
					<td>Marital Status</td>
					<td>Type</td>
					<td>Email</td>
					<td>Agent Name</td>
					<td>Date</td>
					<td>Action</td>
				</tr>
			</thead>
			<tbody>
				<?php
				if (!empty($newData)) {
					foreach($newData['data'] as $productData){
				?>
					<tr>
						<td><?php echo $productData->sequence; ?></td>
						<td><?php echo $productData->name; ?></td>
						<td><?php echo $productData->phone_number; ?></td>
						<td><?php echo $productData->marital_status; ?></td>
						<td><?php echo $productData->payment_type; ?></td>
						<td><?php echo $productData->email; ?></td>
						<td><?php echo $productData->pramoterName; ?></td>
						<td><?php echo $productData->date; ?></td>
						<td>
							<input type="checkbox" name="product[]" id="product_<?php echo $productData->id;?>" value="<?php echo $productData->id;?>"/>
						</td>
					</tr>
				<?php
					$latestProductId = $productData->id;
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
	<input type="hidden" name="latestProductId" id="latestProductId" value="<?php echo (isset($latestProductId) && !empty($latestProductId) ? $latestProductId : 0); ?>"/>
	</form>
	<audio id="myAudio">
		<source src="<?php echo base_url('assets/alerts/alert-2.wav');?>" type="audio/wav">
	</audio>
</div>