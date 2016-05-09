<?php

$con=mysqli_connect("localhost","root","","herodb");
$data=json_decode($_POST["data"]);

switch($_POST["type"]){
case "out":
	$name=$_POST["name"];
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
break;
case "in":
	$rows=[];
	for($i=0;$i<count($data);$i++){
		$name=$data[$i];
		$result=$con->query("SELECT*FROM `$name`");
		while($row=$result->fetch_assoc()){
			$hName=$row["name"];
			$hAdvantage=$row["advantage"];
			if(!(in_array($hName,$data))){
				if(array_key_exists($hName,$rows)){
					$rows[$hName]=bcadd($rows[$hName],$hAdvantage,4);
				}else{
					$rows[$hName]=$hAdvantage;
				}
			}
		}
	}
	asort($rows);
	echo json_encode($rows);
break;
}

?>