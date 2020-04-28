<?php

    require 'includes/connection.php';
    require 'includes/allow-manager.php';
    
    if (!isset($_GET['statusProject']))
	{
        echo "";
    } else {

        $statusProject = $_GET["statusProject"];

        $sql = "SELECT  projectId, 
                        projectName
                FROM project 
                WHERE statusProject = '$statusProject'";
        $result = $conn->query($sql);

        $json_result = "";
        if ($result->num_rows > 0) {
            $projectArr = [];
            while ($row = $result->fetch_assoc()) {
                array_push($projectArr, $row);
            }

            $json_result = json_encode($projectArr, JSON_UNESCAPED_UNICODE);
        }
    
        $conn->close();

        echo $json_result;
    }
?>