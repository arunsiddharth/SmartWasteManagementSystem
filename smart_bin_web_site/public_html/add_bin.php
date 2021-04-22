<?php
    require("../includes/config.php");
    if($_SERVER['REQUEST_METHOD']=="GET"){
        render("add_bin_form.php",["title" => "Add Bin"]);
    }
    else{
        if(!isset($_POST['bin_id']) || empty($_POST["location"])){
			apologize("bin_id and location must be provided");
		}
        else{
                    $conn=dbconnect();
                    if($conn->connect_error){
				        die("Connection Failed".$conn->conncet_error);
		            }
                    $query="INSERT INTO smartbin(bid,location,lat,lng) VALUES(".$_POST['bin_id'].",'".$_POST['location']."',".$_POST['af_lat'].",".$_POST['af_lng'].")";
                    $result = $conn->query($query);
                    if($result!=1){
                        apologize("Smart Bin with this id already registered");
                    }
                    else{
                        redirect('show_bin.php');
                    }
        }
    }



?>