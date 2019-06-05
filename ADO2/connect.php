<?php 

    $servername = "localhost";
    $username = "daniel";
    $dbpassword = "danielfellipe";
    $dbname = "ADO2";

    // Create connection
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>