<!--
	This file demonstrate how to use Pagination
-->
<div class="row-fluid">
	<div class="span2">
	  
	</div>
	<div class="span10">
		<div class="panel panel-default">
		  <div class="panel-heading">
		    <h3 class="panel-title">Student Registration</h3>
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
		  	<form method='POST' action="/student/create">	  		
			  <div class="form-group row">
			    <label for="first_name" class="col-sm-2 col-form-label">First Name *</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
				</div>
			  </div>
			  <div class="form-group row">
			    <label for="last_name" class="col-sm-2 col-form-label">Last Name *</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
			    </div>
			  </div>
			  <div class="form-group row">
			    <label for="dob" class="col-sm-2 col-form-label">DOB *</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="dob" name="dob" placeholder="DOB">
			    </div>
			  </div>
			  <div class="form-group row">
			    <label for="firstName" class="col-sm-2 col-form-label">Contact No. *</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="Contact No">
			    </div>
			  </div>
			  <button type="submit" class="btn btn-primary" id="student_submit">Submit</button>
			</form>  
		  </div>
		</div>
		<div class="panel panel-default">
		  <div class="panel-heading">
		    <h3 class="panel-title">Students Detail</h3>
		  </div>
		  <div class="panel-body">
		  	<table class="table table-dark">
			  <thead>
			    <tr>
			      <th scope="col"></th>
			      <th scope="col">First Name</th>
			      <th scope="col">Last Name</th>
			      <th scope="col"></th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php
		    	if(!empty($students)) {
		    		foreach($students as $student){
				  		echo "<tr><th scope='row'><a type='button' class='btn btn-primary' href='/student/edit/".$student['id']."'>Edit</a></th>".
				  		"<td>".$student['first_name']."</td><td>".$student['last_name']."</td>".
				  		"<td><form method='POST' action='/student/delete'>".
				  		"<input type='hidden' name='id' value='".$student['id']."'>".
				  		"<button type='submit' class='btn btn-primary btnDelete'>Delete</button>".
				  		"</form></td></tr>";
				  	}
		    	}
			  	?>
			    
			  </tbody>
			</table>
			<?php
				if(!empty($total) && $total > \Controller\Student::DEFAULT_NUM_ROWS) {
					$pages = ceil($total/ \Controller\Student::DEFAULT_NUM_ROWS);
				?>
				<nav aria-label="...">
				  <ul class="pagination pagination-sm">
				  	<?php
				  		for ($i=1; $i <= $pages; $i++) { 
				  			echo '<li class="page-item"><a class="page-link" href="/student?page='.$i.'">'.$i.'</a></li>';
				  		}
				    ?>
				  </ul>
				</nav>
				<?php
				}
			?>
		  </div>
		</div>	  
	</div>
</div>
<script>
$(document).ready(function(){

  $(".btnDelete").click(function(event){
  	if (!confirm('Are you sure you want to delete?')) {
  		event.preventDefault(); 
  	}
  });

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