<?php
    require("../includes/config.php");
	require('../views/header.php');
    if($_SERVER['REQUEST_METHOD']=="GET"){
        $conn=dbconnect();
        if($conn->connect_error){
			die("Connection Failed".$conn->conncet_error);
		}
        $query="SELECT * FROM ((collection c LEFT JOIN drivers d ON c.did=d.did)LEFT JOIN smartbin s ON c.bid=s.bid)";
        $result = $conn->query($query);
		echo collection_table_maker($result);
    }
	require('../views/footer.php');
?>