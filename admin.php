<?php
$movie = clean_input($_POST['movie']);
$startDate = format_date($_POST['start_date']);
$endDate = format_date($_POST['end_date']);

if(!empty($movie) && $startDate != '01/01/2016' && $endDate != '01/01/2016')
{
	cinemas();
}
else
{
	echo "There is an empty field.";
}

function cinemas()
{
	$cinemas = $_POST['cinema_group'];
	$checked_cinemas = array();
	$cinemas_time_group = array();
	$cinemas_2d = array();
	
	$checked_time = array();
	
	foreach($cinemas as $cinema)
	{
		if(!isset($cinema))
		{
			return;
		}
		else
		{
			array_push($checked_cinemas, $cinema);
		}
	}
	
	foreach($checked_cinemas as $cinema)
	{
		array_push($cinemas_time_group, $cinema . "_time_group");
	}
	
	foreach($cinemas_time_group as $time_group)
	{
		//TODO
		//variable in $_POST as parameter is not working yet
		$time_array = $_POST[$time_group];
		
		foreach($time_array as $time)
		{
			if(!isset($time))
			{
				return;
			}
			else
			{
				array_push($checked_time, $time);
				//echo $time_group;
				//echo $time;
				//echo "<br>";
			}
		}
		
		$cinemas_time_group[$time_group] = $checked_time;
		
		unset($checked_time);
		$checked_time = array();
	}
	
	foreach($cinemas_time_group as $time_group)
	{
		echo $time_group;
		echo "<br>";
		
		foreach($time_group as $time)
		{
			echo $time;
			echo "<br>";
		}
		
		echo "<br><hr><br>";
	}
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

echo "<br><br>";
echo "<input type=\"button\" name=\"previousPage\" value=\"OK\" onclick=\"location.href='admin.html';\"/>";
?>