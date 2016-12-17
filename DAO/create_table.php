<?php
	$host = "localhost";
	$user = "root";
	$password = "";
	$database = "3522_3543";
	
	$con = mysqli_connect($host, $user, $password);
	$db = mysqli_select_db($con, $database) or die("Unable to select database");
	
	if($con && $db)
	{
		$query="create table movies(
		id int(6) not null auto_increment,
		movie varchar(50) not null,
		movie_shows BLOB(60) not null,
		start_date date not null,
		end_date date not null,
		index(id)
		)";
		
		if(mysqli_query($con, $query))
		{
			echo "Table creation successfull";
		}
	}
	elseif(!($con))
	{
		echo "Error: Unable to connect to MySQL";
	}
	elseif(!($db))
	{
		echo "Error: Unable to connect to database.";
	}
	else
	{
		echo "Error: Something unexpected occured.";
	}
	
	mysqli_close($con);
?>