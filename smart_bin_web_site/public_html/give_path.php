<?php
  require("../includes/config.php");
  if($_SERVER['REQUEST_METHOD']=="GET"){
    render("give_path_st.php");
  }
  else{
    require("../views/header.php");
    $conn = dbconnect();
    if($conn->connect_error){
      die("Connection Failed".$conn->connect_error);
    }
    $query = "SELECT * FROM smartbin";
    $results = $conn->query($query);
    if($results->num_rows>0){
        echo "<div id='map'></div>";
        echo "<div id ='directions-panel'></div>";
        //make and print markers array
        $result = "<script> var Markers = [ [".$_POST['af_lat'].",".$_POST['af_lng']."],";
        while($row=$results->fetch_assoc()){
           if($row['fill']>=$_POST['fill_req']){
              $result = $result."[".$row['lat'].",".$row['lng']."],";
           }
        }
        $result = $result."];</script>";
        echo $result;
        echo "<script src='js/give_path_script.js'></script>";
        echo '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPUQPno2i_CwN8oHisxCakqHJRj79K9U8&callback=initMap"> </script>';
    }
    else{
      echo "Please Add Bins Using Add Bins Option";
    }
    require("../views/footer.php");
}
?>
