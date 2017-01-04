<link rel="icon" href="http://i.imgur.com/hB4xj4K.png">
<?php
	$host = "localhost";
	$user = "root";
	$password = "";
	$database = "3522_3543";
	
	$con = mysqli_connect($host, $user, $password);
	
	if($con)
	{
		$query="create database 3522_3543";
		
		if(mysqli_query($con, $query))
		{
			echo "Database creation successfull";
		}
		else
		{
			echo "Database already exists.";
		}
	}
	elseif(!($con))
	{
		echo "Error: Unable to connect to MySQL";
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