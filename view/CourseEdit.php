<div class="row-fluid">
	<div class="span2">
	  
	</div>
	<div class="span10">
		<div class="panel panel-default">
		  <div class="panel-heading">
		    <h3 class="panel-title">Course Edit</h3>
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
		  	<form method='POST' action="/course/save">	
		  		<input type="hidden" name="id" value="<?php echo $course['id']; ?>" > 	  		
			  <div class="form-group row">
			    <label for="name" class="col-sm-2 col-form-label">Course Name *</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $course['name']; ?>">
				</div>
			  </div>
			  <div class="form-group row">
			    <label for="detail" class="col-sm-2 col-form-label">Course Detail</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="detail" name="detail" placeholder="Detail" value="<?php echo $course['detail']; ?>">
			    </div>
			  </div>
			  <button type="submit" class="btn btn-primary" id="course_submit">Save</button>
			</form>  
		  </div>
		</div> 
	</div>
</div>
<script>
$(document).ready(function(){
  $("#course_submit").click(function(event){
  	if ($("#name").val() == '') {
  		alert('Please enter a valid name');
  		event.preventDefault(); 
  	}
   	
  });
});
</script>