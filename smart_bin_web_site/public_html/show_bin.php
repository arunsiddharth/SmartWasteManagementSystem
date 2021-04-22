<?php
    require("../includes/config.php");
    require('../views/header.php');
    /*show table data of bins,thingspeak provides the percentage filled*/
    $conn=dbconnect();
    if($conn->connect_error){
	        die("Connection Failed".$conn->conncet_error);
	}
    $query="SELECT * FROM smartbin";
    $results = $conn->query($query);
    if($results->num_rows>0){
        /*get data from thingspeak and update it*/
        $url = 'https://api.thingspeak.com/channels/400231/feeds.json'; // path to your JSON file
        $data = file_get_contents($url); // put the contents of the file into a variable
        $characters = json_decode($data);
        /*decode it and put into sql table*/
        decoder_adder($characters);
        /*Now print it*/
        
        echo bin_printer($results);
        echo "</br></br>";
        echo iot_graph();
        echo "</br></br>";
        echo "<div id='map'></div>";
        $tmp=$conn->query($query);
        echo marker_script($tmp);
        echo "<script src='js/show_bin_script.js'></script>";
        echo '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPUQPno2i_CwN8oHisxCakqHJRj79K9U8&callback=initMap"> </script>';
    
    }
    else{
        echo "Please Add Bins Using Add Bins Option";
    }
    require('../views/footer.php');
?>