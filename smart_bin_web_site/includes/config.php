<?php

    // enable sessions
    session_start();
    // requirements
    require("helpers.php");
    if (!in_array($_SERVER["PHP_SELF"], ["/login.php", "/logout.php", "/register.php","/sociallogin.php","./rgbdisplay.php","/sensor.php","/collectionapi.php"]))
    {
        if (empty($_SESSION["id"]))
        {
            redirect("login.php");
        }
    }
?>