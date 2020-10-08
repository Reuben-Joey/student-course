<div class="row-fluid">
	<div class="span2">  
	</div>
		<div class="panel panel-default">
		  <div class="panel-heading">
		    <h3 class="panel-title">Student Course Registration</h3>
		  </div>
		  <div class="panel-body">
		  	<form method='POST' action="/subscription/create">
		  		<div id="all_subs">
				  	<div class="row">
						<div class="col-sm-4">Students</div>
						<div class="col-sm-4">Course</div>
						<div class="col-sm-4"><a id="addMore" href="javascript:void(0)">+<a/></div>
					</div>
					<div class="row" id="subscription">
						<select class="browser-default custom-select col-sm-4" name="student_id[]">
						  	<?php
				    		if(!empty($students)) {
				    			foreach($students as $student){
						  			echo "<option value='".$student['id']."'>".$student['first_name']." ".$student['last_name']." </option>";
						  		}
				    		}
					  		?>
						</select>
						<select class="browser-default custom-select col-sm-4" name="course_id[]">
						  	<?php
				    		if(!empty($courses)) {
				    			foreach($courses as $course){
						  			echo "<option value='".$course['id']."'>".$course['name']."</option>";
						  		}
				    		}
					  		?>
						</select>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form> 
		  </div>
		</div>


		<!-- -->
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


		<div class="panel panel-default">
		  <div class="panel-heading">
		    <h3 class="panel-title">Registration Details</h3>
		  </div>
		  <div class="panel-body">
		  	<table class="table table-dark">
			  <thead>
			    <tr>
			      <th scope="col">Student</th>
			      <th scope="col">Course</th>
			      <th scope="col"></th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php
		    	if(!empty($reports)) {
		    		foreach($reports as $report){
				  		echo "<tr>".
				  		"<td>".$report['first_name']." ".$report['last_name']."</td>".
				  		"<td>".$report['name']."</td>".
				  		"<td><form method='POST' action='/subscription/delete'>".
				  		"<input type='hidden' name='id' value='".$report['id']."'>".
				  		"<button type='submit' class='btn btn-primary btnDelete'>Delete</button>".
				  		"</form></td></tr>";
				  	}
		    	}
			  	?>
			    
			  </tbody>
			</table>
			<?php
				if(!empty($total) && $total > \Controller\Subscription::DEFAULT_NUM_ROWS) {
					$pages = ceil($total/ \Controller\Subscription::DEFAULT_NUM_ROWS);
				?>
				<nav aria-label="...">
				  <ul class="pagination pagination-sm">
				  	<?php
				  		for ($i=1; $i <= $pages; $i++) { 
				  			echo '<li class="page-item"><a class="page-link" href="/subscription?page='.$i.'">'.$i.'</a></li>';
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


  $("#addMore").click(function(){
    var clone = $('#subscription').clone();
    console.log(clone);
    clone.appendTo("#all_subs");
  });
});
</script>