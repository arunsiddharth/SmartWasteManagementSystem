<?php
    require("../includes/config.php");
    if($_SERVER['REQUEST_METHOD']=="GET"){
        $bid = $_GET['bid'];
		$rfid = $_GET['rfid'];
		$fill = $_GET['fill'];
		$conn=dbconnect();
        if($conn->connect_error){
			die("Connection Failed".$conn->conncet_error);
		}
        $query="SELECT * FROM drivers WHERE rfid='".$rfid."'";
        $result = $conn->query($query);
		$row = $result->fetch_assoc();
		$did = $row['did'];
		$query = "INSERT INTO collection(did,bid,fillafter) VALUES({$did},{$bid},{$fill})";
		$conn->query($query);
		echo "<html><br>1</br></html>";
    }
?>