<?php

    require 'includes/connection.php';
    require 'includes/allow-admin.php';
	
    $id = $_POST["id"];

    if (trim($id) == "")
	{
        echo "";
    } else {
        $sql = "DELETE FROM strategy WHERE strategyId = $id";
        $result = $conn->query($sql);
    
        $conn->close();

        echo $id;
    }
?>