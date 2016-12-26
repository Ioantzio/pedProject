<?php
session_start();

$movie = $_SESSION['movie_picked'];
$cinema = $_SESSION['cinema_picked'];
$date = $_POST['date'];
$time = $_POST['time'];

echo "Ticket bought:";
echo "<br><br>";
echo "<b>" . $movie . "</b>";
echo "<br>";
echo $cinema;
echo "<br>";
echo $date;
echo "<br>";
echo $time;

echo "<hr>";
echo "<input type=\"button\" name=\"homePage\" value=\"Home page\" onclick=\"location.href='index.html';\"/>";
echo "&nbsp";
echo "<input type=\"button\" name=\"reservationsPage\" value=\"Reservation\" onclick=\"location.href='reservations.php';\"/>";
?>