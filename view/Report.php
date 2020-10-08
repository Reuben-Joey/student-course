<!--
	This file demonstrate how to use Pagination
-->
<div class="row-fluid">
	<div class="span2">  
	</div>
		<div class="panel panel-default">
		  <div class="panel-heading">
		    <h3 class="panel-title">Report</h3>
		  </div>
		  <div class="panel-body">
		  	<table class="table table-dark">
			  <thead>
			    <tr>
			      <th scope="col">Student Name</th>
			      <th scope="col">Course Name</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php
		    	if(!empty($reports)) {
		    		foreach($reports as $index => $value){
				  		echo "<tr><td>".$value['first_name']. " ".$value['last_name'] ."</td><td>".
				  		$value['name']."</td></tr>";
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
				  			echo '<li class="page-item"><a class="page-link" href="/subscription/showReport?page='.$i.'">'.$i.'</a></li>';
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