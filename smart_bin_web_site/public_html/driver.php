<?php
    require("../includes/config.php");
    if($_SERVER['REQUEST_METHOD']=="GET"){
		require("../views/header.php");
		$conn=dbconnect();
        if($conn->connect_error){
		    die("Connection Failed".$conn->conncet_error);
		}
        $query="SELECT * FROM drivers";
        $result = $conn->query($query);
		echo driver_table_maker($result);
		echo "<br/><br/>";
		require("../views/add_driver.php");
		require("../views/footer.php");
    }
    else{
        if(!isset($_POST['dname']) || empty($_POST["rfid"])){
			apologize("Name and Rfid must be provided");
		}
        else{
                    $conn=dbconnect();
                    if($conn->connect_error){
				        die("Connection Failed".$conn->conncet_error);
		            }
                    $query="INSERT INTO drivers(dname,rfid) VALUES('".$_POST['dname']."','".$_POST['rfid']."')";
					//echo $query;
                    $result = $conn->query($query);
                    if($result!=1){
                        apologize("RFID with this id already registered");
                    }
                    else{
                        redirect('show_bin.php');
                    }
        }
    }



?>