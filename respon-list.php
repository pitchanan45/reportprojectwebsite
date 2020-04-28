<?php

    require 'includes/connection.php';
    require 'includes/allow-admin.php';
	
    $sql = "SELECT responId, CONCAT(p.responFirstname, ' ', p.responLastName) as responName, dp.departmentName as department, dp.supervisor
    FROM person as p 
    LEFT JOIN department as dp ON dp.departmentId = p.departmentId
    WHERE p.role = 'respon'";
    $result = $conn->query($sql);

    $json_result = "";
    if ($result->num_rows > 0) {
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            array_push($arr, $row);
        }

        $json_result = json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

    $conn->close();

    echo $json_result;
?>