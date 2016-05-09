<?php

$con=mysqli_connect("localhost","root","","herodb");
$data=json_decode($_POST["data"]);
$name=$_POST["name"];

if($_POST["type"]=="out"){
	mysqli_query($con,"DROP TABLE `$name`");
	mysqli_query($con,"CREATE TABLE `$name` (
    `name` varchar(255) NOT NULL default '',
    `advantage` float(11) NOT NULL default 0
	)");
	for($i=0;$i<count($data);$i++){
		$heroName=$data[$i]->name;
		$heroAdvantage=$data[$i]->advantage;
		mysqli_query($con,"INSERT INTO `$name` (name,advantage) VALUES ('$heroName',$heroAdvantage)");
	}
}
?>