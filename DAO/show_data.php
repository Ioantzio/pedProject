<?php
	$host = "localhost";
	$user = "root";
	$password = "";
	$database = "3522_3543";
	
	$con = mysqli_connect($host, $user, $password);
	$db = mysqli_select_db($con, $database) or die("Unable to select database");
	
	if($con && $db)
	{
		$query="select * from movies";
		
		$result = mysqli_query($con, $query);
		
		echo "<b>Database output</b>";
		echo "<hr>";
		
		while($data = mysqli_fetch_row($result))
		{
			$movie = $data[1];
			$movie_shows = deformat($data[2]);
			$start_date = format_date($data[3]);
			$end_date = format_date($data[4]);
			
			echo "<b>$movie</b>";
			echo "<br>";
			echo "Start date: $start_date";
			echo "<br>";
			echo "End date: $end_date";
			foreach($movie_shows as $time_group=>$time_group_time)
			{
				echo "<br><b>" . $time_group . "</b><br>";
				foreach($time_group_time as $time)
				{
					echo $time . "<br>";
				}
			}
			echo "<br><hr><br>";
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
	
	function deformat($data)
	{
		$data = unserialize($data);
		return $data;
	}
	
	function format_date($date)
	{
		$date = new DateTime($date);
		$date = $date -> format('d/m/Y');
		return $date;
	}
?>