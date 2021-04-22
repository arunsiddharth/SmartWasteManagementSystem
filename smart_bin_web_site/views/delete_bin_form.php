<?php
    $conn=dbconnect();
    if($conn->connect_error){
		die("Connection Failed".$conn->conncet_error);
	}
	$query="SELECT * FROM smartbin";
    $results = $conn->query($query);
    echo bin_delete_table($results);
?>