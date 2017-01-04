<link rel="icon" href="http://i.imgur.com/hB4xj4K.png">
<?php
	$host = "localhost";
	$user = "root";
	$password = "";
	$database = "3522_3543";
	
	$con = mysqli_connect($host, $user, $password);
	$db = mysqli_select_db($con, $database);
	
	if($con && $db)
	{
		session_start();
		$movie_title = $_SESSION['movie_title'];
		$movie_info = $_SESSION['cinema_info'];
		$movie_start_date = $_SESSION['start_date'];
		$movie_end_date = $_SESSION['end_date'];
		
		$movie_info = base64_encode(json_encode($movie_info));
		$movie_info = mysqli_real_escape_string($con, $movie_info);
		
		$query="insert into movies(movie, movie_shows, start_date, end_date) values(
		\"$movie_title\",
		\"$movie_info\",
		\"$movie_start_date\",
		\"$movie_end_date\"
		)";
		
		if(mysqli_query($con, $query))
		{
			echo "Data insertion successfully";
		}
		else
		{
			echo "Data insertion failed";
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
	
	echo "<hr>";
	echo "<input type=\"button\" value=\"Administration page\" onclick=\"location.href='../index.html'\">";
	echo "&nbsp";
	echo "<input type=\"button\" value=\"Close this window\" onclick=\"self.close()\">";
	mysqli_close($con);
?>