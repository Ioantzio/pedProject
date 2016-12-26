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
			$movie_shows_test = $data[2];
			$start_date = format_date($data[3]);
			$end_date = format_date($data[4]);
			
			echo "<b>$movie</b>";
			echo "<br>";
			echo "Start date: $start_date";
			echo "<br>";
			echo "End date: $end_date";
			echo "<br>";
			
			showSchedule($movie_shows);
			echo "<hr>";
		}
		echo "<input type=\"button\" value=\"Return to home page\" onclick=\"location.href='../admin.html'\">";
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
	
	function showSchedule($show_cinemas)
	{
		if(!is_null($show_cinemas))
		{
			echo "<table>";
			foreach($show_cinemas as $time_group=>$time_group_time)
			{
				echo "<td>";
				echo "<table border=\"solid 1px\">";
				echo "<tr>";
				echo "<th><b>" . $time_group . "</b></th>";
				echo "<td>";
				foreach($time_group_time as $time)
				{
					echo $time;
					echo "<br>";
				}
				echo "</td>";
				echo "</tr>";
				echo "</table>";
				echo "</td>";
			}
			echo "</table>";
		}
		else
		{
			echo "<br><b>Error with showSchedule.</b>";
		}
	}
	
	function deformat($data)
	{
		$data = json_decode(base64_decode($data, true));
		return $data;
	}
	
	function format_date($date)
	{
		$date = new DateTime($date);
		$date = $date -> format('d/m/Y');
		return $date;
	}
?>