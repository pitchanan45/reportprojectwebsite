<?php

    require 'includes/connection.php';
    require 'includes/allow-manager.php';
    
    $sql = "SELECT  projectId, 
                    projectName, 
                    projectStart, 
                    projectFinish, 
                    budget, 
                    project.responId,
                    CONCAT(person.responFirstname, ' ', person.responLastname) as responName,
                    department.departmentName,
                    department.supervisor,
                    strategy.strategyId,
                    strategy.strategyName,
                    strategy.investmentBudget,
                    strategy.operatingBudget,
                    projectType,
                    workingDate,
                    participant,
                    statusProject,
                    satisfaction,
                    paid
                    
            FROM project 
            LEFT JOIN strategy ON strategy.strategyId = project.strategyId
            LEFT JOIN person ON person.responId = project.responId
            LEFT JOIN department ON department.departmentId = person.departmentId";
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
?>