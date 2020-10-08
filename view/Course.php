<!--
	This file demonstrate how to use Pagination
-->

<div class="row-fluid">
	<div class="span2">
	  
	</div>
	<div class="span10">
		<div class="panel panel-default">
		  <div class="panel-heading">
		    <h3 class="panel-title">Course</h3>
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
		  	<form method='POST' action="/course/create">	  		
			  <div class="form-group row">
			    <label for="name" class="col-sm-2 col-form-label">Course Name</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="name" name="name" placeholder="Name">
				</div>
			  </div>
			  <div class="form-group row">
			    <label for="detail" class="col-sm-2 col-form-label">Course Detail</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="detail" name="detail" placeholder="Detail">
			    </div>
			  </div>
			  <button type="submit" class="btn btn-primary" id="course_submit">Submit</button>
			</form>  
		  </div>
		</div>
		<div class="panel panel-default">
		  <div class="panel-heading">
		    <h3 class="panel-title">Course Detail</h3>
		  </div>
		  <div class="panel-body">
		  	<table class="table table-dark">
			  <thead>
			    <tr>
			      <th scope="col"></th>
			      <th scope="col">Course</th>
			      <th scope="col"></th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php
		    	if(!empty($courses)) {
		    		foreach($courses as $course){
				  		echo "<tr><th scope='row'><a type='button' class='btn btn-primary' href='/course/edit/".$course['id']."'>Edit</a></th>".
				  		"<td>".$course['name']."</td>".
				  		"<td><form method='POST' action='/course/delete'>".
				  		"<input type='hidden' name='id' value='".$course['id']."'>".
				  		"<button type='submit' class='btn btn-primary btnDelete'>Delete</button>".
				  		"</form></td></tr>";
				  	}
		    	}
			  	?>
			    
			  </tbody>
			</table>
			<?php
				if(!empty($total) && $total > \Controller\Course::DEFAULT_NUM_ROWS) {
					$pages = ceil($total/ \Controller\Course::DEFAULT_NUM_ROWS);
				?>
				<nav aria-label="...">
				  <ul class="pagination pagination-sm">
				  	<?php
				  		for ($i=1; $i <= $pages; $i++) { 
				  			echo '<li class="page-item"><a class="page-link" href="/course?page='.$i.'">'.$i.'</a></li>';
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


  $("#course_submit").click(function(event){
  	if ($("#name").val() == '') {
  		alert('Please enter a valid name');
  		event.preventDefault(); 
  	}
   	
  });
});
</script>