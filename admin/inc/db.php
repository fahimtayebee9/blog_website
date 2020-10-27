<?php
	
	$db = mysqli_connect("localhost", "root", "", "blog_website");

	if ( $db ){
		// echo "Database Connected";
	}
	else {
		die("MySQL Connection Faild." . mysqli_error($db));
	}

?>