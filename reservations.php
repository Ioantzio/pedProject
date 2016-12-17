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
	<td>
	<table id="title_table">
	<tr>
		<td>
		</td>
		<td id="title_cell">
			<center><font id="title">Welcome to CinemaStar</font></center>
		</td>
		<td id="home_cell">
			<a id="home_link" href="index.html" target="_blank">Home</a>
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
			<SELECT name="movie">
			<option value="Fantastic Beasts and Where To Find Them" selected>Fantastic Beasts and Where To Find Them
			<option value="Creed">Creed
			<option value="Deadpool">Deadpool
			<option value="Antman">Antman
		</td>
	</tr>
	<tr>
		<td>
			<input type="submit" value="Pick date">
		</td>
	</tr>
	</table>
	</FORM>
	</td>
</tr>
</table>

<?php
	if(!empty($_POST['movie']))
	{
		connect_to_db();
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
			$movie = $_POST['movie'];
			$cinema = $_POST['cinema'];
			
			$query="SELECT * FROM movies WHERE movie = '$movie'";
			$result = mysqli_query($con, $query);
			
			$i = 0;
			
			while($data = mysqli_fetch_row($result))
			{
				$movie = $data[1];
				//$movie_shows = unserialize($data[2]);
				$start_date = format_date($data[3]);
				$end_date = format_date($data[4]);
				
				echo "<b>$movie</b>";
				echo "<br>";
				echo "Start date: $start_date";
				echo "<br>";
				echo "End date: $end_date";
				echo "<br><hr><br>";
				$i++;
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
		
		//echo "<input type=\"button\" name=\"show_movies\" value=\"Show movies\" onclick=\"location.href='DAO/show_data.php';\"/>";
	}
	
	function format_date($date)
	{
		$date = new DateTime($date);
		$date = $date -> format('d/m/Y');
		return $date;
	}
?>

</body>
</html>