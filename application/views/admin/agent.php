<div class="col-lg-offset-2 col-lg-8">
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
		}else if($this->session->flashdata('success')){
	?>
		<div class="col-lg-offset-2 col-lg-8 alert alert-success">
			<?php 
				echo $this->session->flashdata('success');  
				$this->session->set_flashdata('success','');
			?>
		</div>
	<?php
		}
	?>
	<div class="col-lg-12 center"><h3 class="MT0">Promoters Listing</h3></div>
	<div class="col-lg-12">
		<table class="table table-bordered" id="pramotersTable">
			<thead>
				<tr>
					<td>Id</td>
					<td>Name</td>
					<td>Username</td>
					<td>Action</td>
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
						<td>
							<?php
								if($pramoterData->status == "enabled"){
							?>
								<a href="<?php echo base_url('admin/changeStatus/'.$pramoterData->id.'/disabled');?>">
									<button type="button" class="btn btn-danger">Disable</button>
								</a>
							<?php
								}else{
							?>
								<a href="<?php echo base_url('admin/changeStatus/'.$pramoterData->id.'/enabled');?>">
									<button type="button" class="btn btn-success">Enable</button>
								</a>
							<?php
								}
							?>
						</td>
					</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
</div>