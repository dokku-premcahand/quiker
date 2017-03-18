<div class="col-lg-offset-2 col-lg-8">
	<div class="col-lg-12 center"><h3 class="MT0">Product Listing</h3></div>
	<div class="col-lg-12 center">
		<div class="col-lg-12">
			<form class="form-horizontal" action="<?php echo base_url("backoffice/pull"); ?>" method="POST">
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-1 control-label">From</label>
			    	<div class="col-sm-3">
			      		<input type="text" class="form-control" id="inputEmail3" placeholder="From Date">
			    	</div>
			    	<label for="inputPassword3" class="col-sm-1 control-label">To</label>
			    	<div class="col-sm-3">
			      		<input type="text" class="form-control" id="inputPassword3" placeholder="To Date">
					</div>
					<div class="col-sm-4" style="text-align: right;">
						<button type="submit" class="btn btn-sm btn-primary">Search</button>
						<button type="submit" class="btn btn-sm btn-success">Pull</button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-lg-12">
			<form class="form-horizontal" action="<?php echo base_url("backoffice/export"); ?>" method="POST">
				<div class="form-group">
					<div class="col-sm-offset-8 col-sm-4" style="text-align: right;">
						<button type="button" class="btn btn-sm btn-danger" id="markAsDone">Mark As Done</button>
						<button type="button" class="btn btn-sm btn-danger">Export</button>
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
					<td>Id</td>
					<td>Shop Name</td>
					<td>Phone Number</td>
					<td>Marital Status</td>
					<td>Email</td>
					<td>Promoter Name</td>
					<td>Select</td>
				</tr>
			</thead>
			<tbody>
				<?php
				if (!empty($newData)) {
					foreach($newData as $productData){
				?>
					<tr>
						<td><?php echo $productData->id; ?></td>
						<td><?php echo $productData->name; ?></td>
						<td><?php echo $productData->phone_number; ?></td>
						<td><?php echo $productData->marital_status; ?></td>
						<td><?php echo $productData->email; ?></td>
						<td><?php echo $productData->pramoterName; ?></td>
						<td>
							<!-- <a href="<?php echo base_url('admin/downloadProduct/'.$productData->folder);?>" target="_blank">
								<button type="button" class="btn btn-primary">Download</button>
							</a> -->
							<input type="checkbox" name="product[]" id="product_<?php echo $productData->id;?>" value="<?php echo $productData->id;?>"/>
						</td>
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
	</form>
</div>