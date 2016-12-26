<?php
$movie = clean_input($_POST['movie']);
$startDate = format_date($_POST['start_date']);
$endDate = format_date($_POST['end_date']);

$checked_cinemas = array();
$cinemas_time_group = array();

$time_array = array();
$checked_time = array();

$cinemas_2d = array();

if(!empty($movie) && $startDate != '01/01/2016' && $endDate != '01/01/2016')
{
	// echo "<hr>Call cinemas() function<br>";
	cinemas();
}
else
{
	echo "There is an empty field.";
	echo "<hr>";
}

function cinemas()
{
	$cinemas = $_POST['cinema_group'];
	
	if(!empty($cinemas))
	{
		foreach($cinemas as $cinema)
		{
			if(!isset($cinema))
			{
				return;
			}
			else
			{
				// echo "Push \$checked_cinemas & cinemas_time_group: " . $cinema . "<br>";
				$cinemas_time_group[] = $cinema . "_time_group";
				$checked_cinemas[] = replace($cinema, '_', ' ');
			}
		}
		
		if(!empty($cinemas_time_group))
		{
			// echo "<hr>Call getTimeGroup() function<br>";
			getTimeGroup($cinemas_time_group, $checked_cinemas);
		}
		else
		{
			// echo "\$cinemas_time_group.<br>";
		}
	}
	else
	{
		// echo "\$cinemas.<br>";
	}
}

function getTimeGroup($time_group_per_cinema, $cinemas)
{
	for ($i = 0; $i < count($time_group_per_cinema); $i++)
	{
		if(isset($time_array))
		{
			unset($time_array);
		}
		
		if(isset($checked_time))
		{
			unset($checked_time);
		}
		
		$time_array = $_POST[$time_group_per_cinema[$i]];
		
		// echo "<br><b>" . $time_group_per_cinema[$i] . "</b><br>";
		if(!empty($time_array))
		{
			foreach($time_array as $time)
			{
				if(!isset($time) && !empty($time))
				{
					return;
				}
				else
				{
					// echo "Push \$checked_time '" . $time . "'<br>";
					$checked_time[] = replace($time, '_', ':');
				}
			}
			// echo "Push \$cinemas_2d[" . $time_group_per_cinema[$i] . "]<br>";
			$cinemas_2d[$cinemas[$i]] = $checked_time;
			// echo "<br>";
		}
		else
		{
			// echo "\$time_array of " . $time_group_per_cinema[$i] . ".<br>";
			continue;
		}
	}
	
	if(!empty($cinemas_2d))
	{
		// echo "<hr>Call showSchedule() function<br>";
		showSchedule($cinemas_2d);
	}
	else
	{
		// echo "\$cinemas_2d.<br>";
	}
}

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
	
	insert_data($show_cinemas);
}

function insert_data($cinemas)
{
	$movie = clean_input($_POST['movie']);
	$startDate = $_POST['start_date'];
	$endDate = $_POST['end_date'];
	
	session_start();
	$_SESSION['movie_title'] = clean_input($_POST['movie']);
	$_SESSION['cinema_info'] = $cinemas;
	$_SESSION['start_date'] = $startDate;
	$_SESSION['end_date'] = $endDate;
	
	echo "<hr>";
	echo "<input type=\"button\" value=\"Insert data\" onclick=\"location.href='DAO/insert_data.php'\">";
	echo "&nbsp";
}

function replace($data, $find, $replace)
{
	$data = str_replace($find, $replace, $data);
	return $data;
}

function format_date($date)
{
	$date = new DateTime($date);
	$date = $date -> format('d/m/Y');
	return $date;
}
	
function clean_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	return $data;
}

// echo "<hr>";
echo "<input type=\"button\" name=\"previousPage\" value=\"Return to previous page\" onclick=\"location.href='admin.html';\"/>";
?>