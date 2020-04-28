<?php

    require 'includes/connection.php';
    require 'includes/allow-admin.php';
	
    $id = $_POST["id"];

    if (trim($id) == "")
	{
        echo "";
    } else {
        $sql = "DELETE FROM person WHERE responId = $id";
        $result = $conn->query($sql);
        
        $conn->close();

        if ($result == 1) {
            echo $id;
        } else {
            echo "";
        }
    }
?>