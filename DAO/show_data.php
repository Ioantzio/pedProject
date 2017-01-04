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
		$query="select * from movies";
		
		$result = mysqli_query($con, $query);
		
		if(!empty(mysqli_fetch_row($result)))
		{
			echo "<table border=\"solid 2px\"><tr>";
			
			while($data = mysqli_fetch_row($result))
			{
				$movie = $data[1];
				$movie_shows = deformat($data[2]);
				$movie_shows_test = $data[2];
				$start_date = format_date($data[3]);
				$end_date = format_date($data[4]);
				
				echo "<td>";
				echo "<table>";
				echo "<tr>";
				echo "<th><b>$movie</b></th>";
				echo "</tr>";
				echo "<tr><td>";
				echo "Start date: $start_date";
				echo "</td></tr>";
				echo "<tr><td>";
				echo "End date: $end_date";
				echo "</td></tr>";
				echo "</tr>";
				
				showSchedule($movie_shows);
				echo "</td>";
			}
		}
		else
		{
			echo "No data found.";
		}
		echo "</tr>";
		echo "</table>";
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
	
	function showSchedule($show_cinemas)
	{
		if(!is_null($show_cinemas))
		{
			echo "<table>";
			foreach($show_cinemas as $time_group=>$time_group_time)
			{
				echo "<tr>";
				echo "<td>";
				echo "<table border=\"solid 1px\">";
				echo "<tr>";
				echo "<th><b>" . $time_group . "</b></th>";
				echo "<td>";
				echo "<SELECT name=\"time\">";
				foreach($time_group_time as $time)
				{
					echo "<option value=\"$time\">" . $time;
				}
				echo "</td>";
				echo "</tr>";
				echo "</table>";
				echo "</td>";
				echo "</tr>";
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