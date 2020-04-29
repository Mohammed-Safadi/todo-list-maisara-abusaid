<?php 
	
	$errors = "";

	// connect to database
	$db = mysqli_connect("localhost", "root", "", "todo");

	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {

		if (empty($_POST['task'])) {
			$errors = "You must fill in the task";
		}else{
			$task = $_POST['task'];
			$query = "INSERT INTO tasks (task) VALUES ('$task')";
			mysqli_query($db, $query);
			header('location: index.php');
		}
	}	

	// delete task
	if (isset($_GET['del_task'])) {
		$id = $_GET['del_task'];

		mysqli_query($db, "DELETE FROM tasks WHERE id=".$id);
		header('location: index.php');
	}
    // done task
    if (isset($_GET['done_task'])) {
		$id = $_GET['done_task'];

		mysqli_query($db, "UPDATE tasks SET status = 1 WHERE id=".$id);
		header('location: index.php');
	}

	// select all tasks if page is visited or refreshed
	$tasks = mysqli_query($db, "SELECT * FROM tasks");
    mysqli_close($db);

?>
<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
		integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<style>
		.actions {
			visibility: hidden;
			font-size: .85em;
		}

		li:hover .actions {
			visibility: visible;
		}

		li:hover {
			border-bottom-color: #999;
		}
       
	</style>
	<title>To-do's List</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body>
	<div class="container py-5">
		<h1 class="mb-5">My To-do's List</h1>
		<form method="post" action="index.php" class="form-inline mb-4">
            
			<input type="text" name="task" class="form-control" placeholder="New Task..." required>
            <button type="submit" name="submit" class="btn btn-primary ml-2">Add to List</button>
			
		</form>
        
		<ul class="todos list-group list-group-flush">
            
            <?php $i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
            
			<li class="list-group-item d-flex" draggable="true">
                
                <?php if ($row['status'] == 0) { ?>
				<span class="text-danger"><?php echo $row['task']; ?></span>
                <?php }else {  ?>
				<span class="text-success"><?php echo $row['task']; ?></span>
				 <?php } ?>
                
				<span class="actions ml-auto">
					<?php if($row['status'] == 0){?>
                    <a href="index.php?done_task=<?php echo $row['id'] ?>" style="text-decoration: none;" class="done-btn text-success">Mark as Done</a> |
                    <?php } ?>
					<a href="index.php?del_task=<?php echo $row['id']; ?>" class="delete-btn text-danger">Delete</a>
				</span>
			</li>
			<?php $i++; } ?>
		</ul>
	</div>
    <script>
        /*    $(".btn").on("click",function(){  
            var valueofinput= $('.form-control').val();
            if (valueofinput != '' ){
            $('.todos').append('<li class="list-group-item d-flex" draggable="true">'
               + '\n' +
				'<span class="text-danger">'+valueofinput+'</span>'
                + '\n' +
				'<span class="actions ml-auto">'
                + '\n' +
					'<a href="#" class="done-btn text-success">Mark as Done</a> |\n'+
					'<a href="#" class="delete-btn text-danger">Delete</a> \n'+
				'</span> \n'+
			'</li>');

            $('.form-control').val('');

        }}
        );
        

        $(document).on("click",'.delete-btn',function () {
            $(this).parent().parent().remove()             

        });

        $(document).on("click",'.done-btn',function () {
            $(this).parent().parent().children('span:first').addClass("text-success");
            $(this).parent().parent().children('span:first').removeClass("text-danger");
            $(this).parent().empty()
        });

*/


</script> 



</body>

</html>