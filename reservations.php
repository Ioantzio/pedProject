<!DOCTYPE html>

<html>
<head>
	<link type="text/css" rel="stylesheet" href="index.css"/>
	<link rel="icon" href="http://i.imgur.com/hB4xj4K.png">
	
	<title>Welcome to Cinema Star</title>
</head>
	
<body>
<table id="page_table">
<tr>
	<td id="title_row">
	<table id="title_table">
	<tr>
		<td>
		<table id="user_table">
		<tr>
		</tr>
		</table>
		</td>
		<td id="title_cell">
				<center><font id="title">Welcome to CinemaStar</font></center>
		</td>
		<td id="reservations_cell">
		
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td>
	<FORM action="reservations.php" method="post">
	<table id="form_table">
	<tr>
		<td>
			<SELECT name="movie">
			<option value="Fantastic Beasts and Where To Find Them" selected>Fantastic Beasts and Where To Find Them
			<option value="Creed">Creed
			<option value="Deadpool">Deadpool
			<option value="Antman">Antman
		</td>
	</tr>
	<tr>
		<td>
			<SELECT name="cinema">
			<option value="New York Star" selected>New York Star
			<option value="Whiskonsin Star">Whiskonsin Star
			<option value="Paris Star">Paris Star
			<option value="Athens Star">Athens Star
			<option value="San Francisco Star">San Fransisco Star
			<option value="Sydney Star">Sydney Star
			<option value="London Star">London Star
		</td>
	</tr>
	<tr>
		<td>
			<input type="submit" name="Date" value="Date">
		</td>
	</tr>
	</table>
	</FORM>
	</td>
</tr>
</table>

<?php
	if(isset($_POST['Date']))
	{
		connect_to_db();
	}
	
	if(isset($_POST['Buy']))
	{
		echo "Ticket bought";
	}

	function connect_to_db()
	{
		$host = "localhost";
		$user = "root";
		$password = "";
		$database = "3522_3543";
	
		$con = mysqli_connect($host, $user, $password);
		$db = mysqli_select_db($con, $database) or die("Unable to select database");
		
		if($con && $db)
		{
			$movie_chosen = $_POST['movie'];
			$cinema_chosen = $_POST['cinema'];
			
			$query="SELECT * FROM movies";
			$result = mysqli_query($con, $query);
			
			$i = 0;
			
			while($data = mysqli_fetch_row($result))
			{
				$movie = $data[1];
				$movie_shows = deformat($data[2]);
				$start_date = format_date($data[3]);
				$end_date = format_date($data[4]);
				
				if($movie == $movie_chosen)
				{
					session_start();
					$_SESSION['movie_picked'] = $movie_chosen;
					$_SESSION['cinema_picked'] = $cinema_chosen;
					
					echo "<hr>";
					echo "<b>$movie</b>";
					echo "<br>";
					echo "Start date: $start_date";
					echo "<br>";
					echo "End date: $end_date";
					echo "<br><br>";	
					echo "$cinema_chosen";
					echo "<br>";
					
					$date = date("d/m/Y", time());
					$day = 86400;
					
					$increment = $day;
					
					echo "<FORM action=\"checkout.php\" method=\"post\">";
					echo "<b>Date</b>";
					echo "<br>";
					echo "<SELECT name=\"date\">";
					
					do
					{
						echo "<option value=\"$date\">" . $date;
						
						$date = date("d/m/Y", time()+$increment);
						$increment = $increment + $day;
					} while(!($date == $end_date));
					
					echo "</select>";
					echo "<br><br>";
					
					foreach($movie_shows as $time_group=>$time_group_time)
					{
						if($time_group == $cinema_chosen)
						{
							// echo "<b>" . $time_group . "</b>";
							echo "<b>Time</b>";
							echo "<br>";
							echo "<SELECT name=\"time\">";
							foreach($time_group_time as $time)
							{
								echo "<option value=\"$time\">" . $time;
							}
							echo "</select>";
						}
					}
					
					echo "<br><hr><br>";
					$i++;
					echo "<input type=\"submit\" name=\"Buy\" value=\"Buy\">";
				}
			}
			
			if(!isset($day))
			{
				echo "No showings of the chosen movie or chosen cinema.";
			}
			mysqli_close($con);
		}
		else if(!($con))
		{
			echo "Error: Unable to connect to MySQL";
		}
		else if(!($db))
		{
			echo "Error: Unable to connect to database.";
		}
		else
		{
			echo "Error: Something unexpected occured.";
		}
	}
	
	function format_date($date)
	{
		$date = new DateTime($date);
		$date = $date -> format('d/m/Y');
		return $date;
	}
	
	function deformat($data)
	{
		$data = json_decode(base64_decode($data, true));
		return $data;
	}
?>

</body>
</html>