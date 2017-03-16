<div class="col-lg-12">
	<div class="col-lg-12">
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
	<form class="col-lg-offset-3 col-lg-6" action="<?php echo base_url('agent/products')?>" method="POST" enctype="multipart/form-data">
		<div class="form-group col-lg-12">
			<label for="Name" class="col-lg-4">Shop Name<span style="color: red;">*</span></label>
			<div class="col-lg-8">
				<input type="text" class="form-control" id="shopname" placeholder="Shop Name" name="shopname" 
				value="<?php if(isset($post['shopname']) && !empty($post['shopname'])){echo $post['shopname'];} ?>">
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="Name" class="col-lg-4">Email Address<span style="color: red;">*</span></label>
			<div class="col-lg-8">
				<input type="text" class="form-control" id="address" placeholder="Email Address" name="email" 
				value="<?php if(isset($post['address']) && !empty($post['email'])){echo $post['email'];} ?>">
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="Name" class="col-lg-4">Phone Number<span style="color: red;">*</span></label>
			<div class="col-lg-8">
				<input type="text" class="form-control" id="phonenumber" placeholder="Phone Number" name="phonenumber" 
				value="<?php if(isset($post['phonenumber']) && !empty($post['phonenumber'])){echo $post['phonenumber'];} ?>">
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="Name" class="col-lg-4">Address<span style="color: red;">*</span></label>
			<div class="col-lg-8">
				<textarea class="form-control" id="address" placeholder="Address" name="address" style="resize: none;height: 100px;"><?php if(isset($post['address']) && !empty($post['address'])){echo $post['address'];} ?></textarea>
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="Name" class="col-lg-4">Category<span style="color: red;">*</span></label>
			<div class="col-lg-8">
				<select class="form-control" name="category">
				<option value="">Select Category</option>
				<option value="1" <?php if(isset($post['category']) && $post['category'] == 1){echo "selected";}?>>Shop</option>
				<option value="2" <?php if(isset($post['category']) && $post['category'] == 2){echo "selected";}?>>Freelancer</option>
				</select>
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="password" class="col-lg-4">Pan</label>
			<div class="col-lg-12 MG10">
				<input type="file" name="image_1" id="image_1" class="image"/>
			</div>
			<label for="password" class="col-lg-4 MG10">Tin</label>
			<div class="col-lg-12 MG10">
				<input type="file" name="image_2" id="image_2" class="image"/>
			</div>
			<label for="password" class="col-lg-4 MG10">Canclled Cheque</label>
			<div class="col-lg-12 MG10">
				<input type="file" name="image_3" id="image_3" class="image"/>
			</div>
		</div>
		<div class="form-group center col-lg-12">
			<button class="btn btn-primary" type="submit">SUBMIT</submit>
		</div>
	</form>
	</div>
</div>