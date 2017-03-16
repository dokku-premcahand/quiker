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
	<div class="col-lg-12 center"><h3 class="MT0">Add Promoter</h3></div>
	<form class="col-lg-offset-2 col-lg-8" action="<?php echo base_url('admin/addPramoter')?>" method="POST">
		<div class="form-group col-lg-12">
			<label for="Name" class="col-lg-4">Name</label>
			<div class="col-lg-8">
				<input type="text" class="form-control" id="name" placeholder="Name" name="name">
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="Name" class="col-lg-4">Username</label>
			<div class="col-lg-8">
				<input type="text" class="form-control" id="username" placeholder="Username" name="username">
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="password" class="col-lg-4">Password</label>
			<div class="col-lg-8">
				<input type="password" class="form-control col-lg-8" id="password" placeholder="Password" name="password">
			</div>
		</div>
		<div class="form-group center col-lg-12">
			<button class="btn btn-primary" type="submit">SUBMIT</submit>
		</div>
	</form>
</div>