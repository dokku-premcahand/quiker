<div class="col-lg-12">
	<div class="col-lg-12">
	<div class="row form-group">
		<div class="col-lg-offset-3 col-lg-4">
			<label>Today's Count :</label> 
			<?php 
				echo $todayCount;
			?>
		</div>
		<div class="col-lg-5">
			<?php 
				if(isset($startDay) && !empty($startDay)){
					echo "<label>Your Day started at ".$startDay."</label>";
				}
				else{				
					echo '<a class="btn btn-primary" href="'.base_url().'agent/products/start_day" type="button">Start Day</a>';
				} 
			?>
		</div>
	</div>	
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
			<label for="Name" class="col-lg-4">Name<span style="color: red;">*</span></label>
			<div class="col-lg-8">
				<input type="text" class="form-control" id="name" placeholder="Name" name="name" 
				value="<?php if(isset($post['name']) && !empty($post['name'])){echo $post['name'];} ?>">
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
			<label for="Name" class="col-lg-4">Marital Status<span style="color: red;">*</span></label>
			<div class="col-lg-8">
				<select class="form-control" name="marital_status">
				<option value="">Select Marital Status</option>
				<option value="Single" <?php if(isset($post['marital_status']) && $post['marital_status'] == 'Single'){echo "selected";}?>>Single</option>
				<option value="Married" <?php if(isset($post['marital_status']) && $post['marital_status'] == 'Married'){echo "selected";}?>>Married</option>
				</select>
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="Name" class="col-lg-4">Email Address</label>
			<div class="col-lg-8">
				<input type="text" class="form-control" id="email" placeholder="Email Address" name="email" 
				value="<?php if(isset($post['email']) && !empty($post['email'])){echo $post['email'];} ?>">
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="payment_type" class="col-lg-4">Type<span style="color: red;">*</span></label>
			<div class="col-lg-8">
				<div class="col-lg-6">
					<input type="radio" id="awas_ftcash" name="payment_type" 
				value="Awas & Ftcash" checked> Awas & Ftcash
				</div>
				<div class="col-lg-6">
					<input type="radio" id="ftcash" name="payment_type" 
				value="Ftcash" <?php if(isset($post['payment_type']) && $post['payment_type'] == 'Ftcash'){echo "checked";} ?>> Ftcash
				</div>
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="Name" class="col-lg-4">Aadhar No.</label>
			<div class="col-lg-8">
				<input type="text" class="form-control" id="aadhar" placeholder="Aadhar No." name="aadhar" 
				value="<?php if(isset($post['aadhar']) && !empty($post['aadhar'])){echo $post['aadhar'];} ?>">
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="Name" class="col-lg-4">Father Name</label>
			<div class="col-lg-8">
				<input type="text" class="form-control" id="father_name" placeholder="Father Name" name="father_name" 
				value="<?php if(isset($post['father_name']) && !empty($post['father_name'])){echo $post['father_name'];} ?>">
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="Name" class="col-lg-4">Father Age</label>
			<div class="col-lg-8">
				<input type="text" class="form-control" id="aadhar" placeholder="Father Age" name="father_age" 
				value="<?php if(isset($post['father_age']) && !empty($post['father_age'])){echo $post['father_age'];} ?>">
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="Name" class="col-lg-4">Caste</label>
			<div class="col-lg-8">
				<input type="text" class="form-control" id="aadhar" placeholder="Caste" name="caste" 
				value="<?php if(isset($post['caste']) && !empty($post['caste'])){echo $post['caste'];} ?>">
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="payment_type" class="col-lg-4">House Type</label>
			<div class="col-lg-8">
				<div class="col-lg-6">
					<input type="radio" id="rent" name="house_type" 
				value="rent" checked> Rent
				</div>
				<div class="col-lg-6">
					<input type="radio" id="owned" name="house_type" 
				value="owned" <?php if(isset($post['house_type']) && $post['house_type'] == 'owned'){echo "checked";} ?>> Owned
				</div>
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="Name" class="col-lg-4">Salary</label>
			<div class="col-lg-8">
				<input type="text" class="form-control" id="salary" placeholder="Salary" name="salary" 
				value="<?php if(isset($post['salary']) && !empty($post['salary'])){echo $post['salary'];} ?>">
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="password" class="col-lg-4">Image1</label>
			<div class="col-lg-12 MG10">
				<input type="file" name="image_1" id="image_1" class="image"/>
			</div>
			<label for="password" class="col-lg-4 MG10">Image2</label>
			<div class="col-lg-12 MG10">
				<input type="file" name="image_2" id="image_2" class="image"/>
			</div>
			<label for="password" class="col-lg-4 MG10">Image3</label>
			<div class="col-lg-12 MG10">
				<input type="file" name="image_3" id="image_3" class="image"/>
			</div>			
			<label for="password" class="col-lg-4 MG10">Image4</label>
			<div class="col-lg-12 MG10">
				<input type="file" name="image_4" id="image_4" class="image"/>
			</div>
			<label for="password" class="col-lg-4 MG10">Image5</label>
			<div class="col-lg-12 MG10">
				<input type="file" name="image_5" id="image_5" class="image"/>
			</div>
			<label for="password" class="col-lg-4 MG10">Image6</label>
			<div class="col-lg-12 MG10">
				<input type="file" name="image_6" id="image_6" class="image"/>
			</div>
		</div>
		<div class="form-group center col-lg-12">
			<button class="btn btn-primary" type="submit">SUBMIT</submit>
		</div>
	</form>
	</div>
</div>