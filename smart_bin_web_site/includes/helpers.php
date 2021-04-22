<?php
    /**
     * helpers.php
     *
     * Helper functions.
     */
    date_default_timezone_set("Asia/Kolkata");
    require_once("config.php");

    function apologize($message)
    {
        render("apology.php", ["message" => $message]);
    }

    function logout(){
		$_SESSION=[];
		session_destroy();
		redirect("login.php");
	}

   
	function redirect($location){
		header("Location: {$location}");
		exit;
	}

    function render($view, $values = []){
		if(file_exists("../views/{$view}")){
			extract($values);
			require("../views/header.php");
			require("../views/{$view}");
			require("../views/footer.php");
			exit;
		}
		else{
			echo "Invalid View";
			//trigger_error("Invalid View:{$view}",E_USER_ERROR);
		}
	}
	function dbconnect(){
		$server = "localhost";
		$username = "id637674_root";
		$password = "asd59632";
		$dbname ="id637674_intern";
		return mysqli_connect($server, $username, $password, $dbname);
	}
    function bin_printer($data){
        $final = "<table class='table table-striped'><thead><tr><th>Sr. No.</th><th>Bin Id</th><th>Location</th><th>Fill %</th></tr></thead>";
        $i=1;
        while($row = $data->fetch_assoc()){
            $final = $final . "<tr align = 'left'><td>".$i."</td><td>".$row['bid']."</td><td>".$row['location']."</td><td>".$row['fill']."%</td></tr>";
            $i=$i+1;
        }
        $final = $final."</table>";
        return $final;
    }
    function decoder_adder($data){
            /*Fetch last insert id*/
            $conn=dbconnect();
            if($conn->connect_error){
			        die("Connection Failed".$conn->conncet_error);
		    }
            $query="SELECT * FROM entry";
            $result = $conn->query($query);
            $last_entry = $result->fetch_assoc();
            $last_entry = $last_entry['e_id'];
            //echo $last_entry;
            if($data->channel->last_entry_id!=$last_entry){
                //need to update data
                $feed = $data->feeds;
                $feed_num_rows = count($feed);
                $most_fresh = array();
                for($i=0;$i<=$feed_num_rows-1;$i++){
                    foreach($feed[$i] as $key=>$value){
                        if(strpos($key,"ield")==1){
                            $f_num = filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                            if($value!=null){
                                $most_fresh[$f_num]=$value;
                            }
                        }
                    }
                }
                /*Now insert into table*/
                foreach($most_fresh as $key=>$value){
                    $query = "UPDATE smartbin SET fill=".$value." WHERE bid = ".$key;
                    $conn ->query($query);
                }
                $query = "UPDATE entry SET e_id=".$feed_num_rows;
                $conn->query($query);
                $_SESSION['most_fresh'] = $most_fresh;
            }
            //print table;
    }
    function iot_graph(){
        $conn = dbconnect();
        $query = "SELECT bid FROM smartbin";
        $bins = $conn->query($query);
        $result="";
        $i = 0;
        //<iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/400231/charts/1?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15"></iframe>
        while($row=$bins->fetch_assoc() ){
            $result=$result.'<iframe width="40%" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/400231/charts/'.$row['bid'].'?bgcolor=%23ffffff&color=%23d62020&dynamic=true&type=line&update=15"></iframe>&nbsp;&nbsp;';
            $i++;
        }
        $result=$result.'</br></br>JSON DATA AT:<a href="https://api.thingspeak.com/channels/400231/feeds.json">LINK</a>';
        return $result;
    }
	
	
	function collection_table_maker($data){
		$final = "<table class='table table-striped'><thead><tr><th>Sr. No.</th><th>Bin Id</th><th>Location</th><th>Driver Name</th><th>Fill %</th><th>Date</th></tr></thead>";
        $i=1;
        while($row = $data->fetch_assoc()){
            $final = $final . "<tr align = 'left'><td>".$i."</td><td>".$row['bid']."</td><td>".$row['location']."</td><td>".$row['dname']."</td><td>".$row['fillafter']."</td><td>".$row['date']."</td></tr>";
            $i=$i+1;
        }
        $final = $final."</table>";
        return $final;
	}
	
	function driver_table_maker($data){
		$final = "<table class='table table-striped'><thead><tr><th>Sr. No.</th><th>Driver Name</th><th>RFID No.</th></tr></thead>";
        $i=1;
        while($row = $data->fetch_assoc()){
            $final = $final."<tr align = 'left'><td>".$i."</td><td>".$row['dname']."</td><td>".$row['rfid']."</td></tr>";
            $i=$i+1;
        }
        $final = $final."</table>";
        return $final;
	}
	
    function bin_delete_table($data){
        $final = "<table class='table table-striped'><thead><tr><th>Sr. No.</th><th>Bin Id</th><th>Location</th><th>Fill %</th></tr></thead>";
        $i=1;
        while($row = $data->fetch_assoc()){
            $final = $final . "<tr align = 'left'><td>".$i."</td><td>".$row['bid']."</td><td>".$row['location']."</td><td><a href='delete_bin.php?bid=".$row['bid']."'>DELETE</a></td></tr>";
            $i=$i+1;
        }
        $final = $final."</table>";
        return $final;
    }
    
    function getIcon($val){
        if($val>80){
            return "../img/full_bin.png";
        }
        else if($val>40){
            return "../img/half_bin.png";
        }
        else{
            return "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";
        }
    }
	
    function marker_script($data){
        $result = "<script>var Markers_props = [";
        while($row = $data->fetch_assoc()){
            $result = $result."{coords : {lat : ".$row['lat'].",lng : ".$row['lng']."},icon :'".getIcon($row['fill'])."', content : '<h3>".$row['fill']."% filled</h3></br><h5>".$row['location']."</h5> '},";
        }
        $result = $result."];</script>";
        return $result;
    }
?>
