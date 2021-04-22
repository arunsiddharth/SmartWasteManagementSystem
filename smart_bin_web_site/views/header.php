<!DOCTYPE html>

<html>

    <head>

        <!-- http://getbootstrap.com/ -->
        <link href="/css/bootstrap.min.css" rel="stylesheet"/>
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
        <link href="/css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>$mart Bin: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>$mart Bin</title>
        <?php endif ?>

        <!-- https://jquery.com/ -->
        <script src="/js/jquery-1.11.3.min.js"></script>

        <!-- http://getbootstrap.com/ -->
        <script src="/js/bootstrap.min.js"></script>

        <script src="/js/scripts.js"></script>

    </head>
    <?php
        if (!in_array($_SERVER["PHP_SELF"], ["/wstation.php"])){
        echo '<body background="img/bkg.jpg" style="background-size:100%">';
        }
        else{
        echo '<body background="img/bkg.jpg" style="background-size:100%" onload="javascript:search('."'Jaipur'".');">';
        }
    ?>

    

        <div class="container">

            <div id="top">
                <div>
                    <a href="/"><img alt="E$PHA IOT" src="/img/download.jpg"/></a>
                </div>
				
				<!--<?php if (!empty($_SESSION["id"])){
			$conn = dbconnect();
			$query="SELECT * FROM users WHERE id=".$_SESSION['id'].";";
			$result = $conn->query($query);
			if($result->num_rows >0){
					$row = $result -> fetch_assoc();
					echo "<h3>Welcome ".$row['name']."</h3><br><br>";
				}
			} 
			?>-->
				
				
                <?php if (!empty($_SESSION["id"])): ?>
                    <ul class="nav nav-pills">
						<li><button class="btn btn-primary dropdown-toggle" type="button"><a href="index.php" style="color:white;text-decoration: none;"><strong>HOME</strong></a></button></li>
						<li><button class="btn btn-primary dropdown-toggle" type="button"><a href="driver.php" style="color:white;text-decoration: none;">ADD DRIVER</a></button></li>
                        <li><button class="btn btn-primary dropdown-toggle" type="button"><a href="collection.php" style="color:white;text-decoration: none;">COLLECTION</a></button></li>
                        
<?php if(in_array($_SERVER["PHP_SELF"], ["/show_bin.php"])):?>
                       <li class="dropdown">
                              <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                    ADD/DELETE
                              <span class="caret"></span></button>
                              <ul class="dropdown-menu">
                                    <li><a href='add_bin.php'>ADD BIN</a></li>
                                    <li><a href='delete_bin.php'>DELETE BIN</a></li>
                              </ul>
                      </li>
<?php else:?>
                        <li><button class="btn btn-primary dropdown-toggle" type="button"><a href="show_bin.php" style="color:white;text-decoration: none;">SMART BIN</a></button></li>
<?php endif?>
                        <li><button class="btn btn-primary dropdown-toggle" type="button"><a href="give_path.php" style="color:white;text-decoration: none;">SMART PATH</a></button></li>
                        
						<li><button class="btn btn-primary dropdown-toggle" type="button">
						<?php if (!empty($_SESSION["id"])){
						$conn = dbconnect();
						$query="SELECT * FROM users WHERE id=".$_SESSION['id'].";";
						$result = $conn->query($query);
							if($result->num_rows >0){
							$row = $result -> fetch_assoc();
                                                        echo '<a href="#" style="color:white;text-decoration: none;">';
							echo '<strong>HI '.strtoupper($row['name']).'</strong>';
                                                        echo '</a>';
							}
						} 
						?>
						</button>
						</li>
						<li><button class="btn btn-primary dropdown-toggle" type="button"><a href="wstation.php" style="color:white;text-decoration: none;">WEATHER STATION</a></button></li>
                        <!--<li><a href="https://www.google.com" target="_blank">GOOGLE</a></li>-->
                        <!--<li><a href="https://www.facebook.com" target="_blank">FACEBOOK</a></li>-->
                        <li><button class="btn btn-primary dropdown-toggle" type="button"><a href="https://www.linkedin.com/in/arun-siddharth-a5709a123/" target="_blank" style="color:white;text-decoration: none;">ABOUT CREATOR</a></button></li>
                        <li><button class="btn btn-primary dropdown-toggle" type="button"><a href="logout.php" style="color:white;text-decoration: none;"><strong>LOG OUT</strong></a></button></li>
                    </ul>
                <?php endif ?>
            </div>

            <div id="middle">