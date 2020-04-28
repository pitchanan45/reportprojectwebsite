<?php

    require 'includes/connection.php';
    require 'includes/allow-admin.php';
	
    $id = $_GET["id"];

    if (trim($id) == "")
	{
        echo "";
    } else {
        $sql = "SELECT strategyName, projectNumber, operatingBudget, investmentBudget, startDate, finishDate FROM strategy WHERE strategyId = $id";
        $result = $conn->query($sql);

        $json_result = "";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $json_result = json_encode($row, JSON_UNESCAPED_UNICODE);
            }
        }
    
        $conn->close();

        echo $json_result;
    }
?>