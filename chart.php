<?php

    require 'includes/connection.php';
    require 'includes/allow-manager.php';
    
    $sql = "SELECT  projectId, 
                    projectName, 
                    statusProject
            FROM project";
    $result = $conn->query($sql);

    $json_result = "";
    if ($result->num_rows > 0) {

        $groupByStatus = array(
            'startedyet' => [],
            'process' => [],
            'success' => []
        );

        while ($row = $result->fetch_assoc()) {

            if ($row['statusProject'] == 'ยังไม่ดำเนินการ') {
                array_push($groupByStatus['startedyet'], $row);
            } else if ($row['statusProject'] == 'อยู่ระหว่างดำเนินการ') {
                array_push($groupByStatus['process'], $row);
            } else if ($row['statusProject'] == 'ดำเนินการเสร็จแล้ว') {
                array_push($groupByStatus['success'], $row);
            }
        }

        $json_result = json_encode($groupByStatus, JSON_UNESCAPED_UNICODE);
    }

    $conn->close();

    echo $json_result;
?>