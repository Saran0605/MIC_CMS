<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location:index.php');
	exit();
} else {
	$s = $_SESSION['login_user'];
	$fac_id = $s;

}
$query = "SELECT sname, dept,ayear FROM student WHERE sid='$s'";
$query_run = mysqli_query($db, $query);
if (mysqli_num_rows($query_run) > 0) {
	$srow = mysqli_fetch_assoc($query_run);
	$sdept = $srow['dept'];
	$sname = $srow['sname'];
	$sayear = $srow['ayear'];
}

$query2 = "SELECT name,dept,role FROM faculty WHERE id='$s'";
$query_run2 = mysqli_query($db, $query2);
if (mysqli_num_rows($query_run2) > 0) {
	$frow = mysqli_fetch_assoc($query_run2);
	$fdept = $frow['dept'];
	$fname = $frow['name'];
	$frole = $frow['role'];

}


$query3 = "SELECT gender FROM sbasic WHERE sid='$s'";
$query_run3 = mysqli_query($db, $query3);
if (mysqli_num_rows($query_run3) > 0) {
	$srow2 = mysqli_fetch_assoc($query_run3);
	$sgender = $srow2['gender'];
}
