<?php
    require("../includes/config.php");
    if(!isset($_GET['bid'])){
			render("delete_bin_form.php",["title" => "Delete Bin"]);
	}
    else{
            $conn=dbconnect();
            if($conn->connect_error){
			        die("Connection Failed".$conn->conncet_error);
		    }
            $query="DELETE FROM smartbin WHERE bid=".$_GET['bid'];
            $result = $conn->query($query);
            redirect('show_bin.php');
    }
?>