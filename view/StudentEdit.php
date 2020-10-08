<div class="row-fluid">
	<div class="span2">
	  
	</div>
	<div class="span10">
		<div class="panel panel-default">
		  <div class="panel-heading">
		    <h3 class="panel-title">Student Edit</h3>
		  </div>
		  <div class="panel-body">
		  	<?php
		  		if(isset($hasSuccessMessage)) {
		  		?>
		  			<div class="alert alert-warning alert-dismissible show" role="alert">
					  <?php echo $hasSuccessMessage; ?>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				<?php	
				} else if(isset($hasErrorMessage)) {
		  		?>
		  			<div class="alert alert-warning alert-dismissible show" role="alert">
					  <?php echo $hasErrorMessage; ?>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				<?php	
				}
		  	?>
		  	<form method='POST' action="/student/save">	
		  		<input type="hidden" name="id" value="<?php echo $student['id']; ?>" > 		
			  <div class="form-group row">
			    <label for="first_name" class="col-sm-2 col-form-label">First Name *</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="<?php echo $student['first_name']; ?>">
				</div>
			  </div>
			  <div class="form-group row">
			    <label for="last_name" class="col-sm-2 col-form-label">Last Name *</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo $student['last_name']; ?>">
			    </div>
			  </div>
			  <div class="form-group row">
			    <label for="dob" class="col-sm-2 col-form-label">DOB *</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="dob" name="dob" placeholder="DOB" value="<?php echo $student['dob']; ?>">
			    </div>
			  </div>
			  <div class="form-group row">
			    <label for="firstName" class="col-sm-2 col-form-label">Contact No. *</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="Contact No" value="<?php echo $student['contact_no']; ?>">
			    </div>
			  </div>
			  <button type="submit" class="btn btn-primary" id="student_submit">Save</button>
			</form>  
		  </div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
  $("#student_submit").click(function(event){
  	if ($("#first_name").val() == '') {
  		alert('Please enter a valid first name');
  		event.preventDefault(); 
  	}

  	if ($("#last_name").val() == '') {
  		alert('Please enter a valid last name');
  		event.preventDefault(); 
  	}

  	if ($("#dob").val() == '') {
  		alert('Please enter a valid date of birth');
  		event.preventDefault(); 
  	}

  	if ($("#contact_no").val() == '') {
  		alert('Please enter a valid Contact No');
  		event.preventDefault(); 
  	}
   	
  });
});
</script>