<?php

    require 'includes/connection.php';
    require 'includes/allow-admin-respon.php';
    
    $id = $_GET["id"];

    if (trim($id) == "")
	{
        echo "";
    } else {
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
                LEFT JOIN department ON department.departmentId = person.departmentId
                WHERE projectId = $id";
        $result = $conn->query($sql);

        $json_result = "";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                // get doc
                $sql = "SELECT name
                        FROM upload 
                        WHERE projectId = $id AND type = 'doc'";
                        
                $_result = $conn->query($sql);

                $uploadArray = [];
                if ($_result->num_rows > 0) {
                    while ($_row = $_result->fetch_assoc()) {
                        array_push($uploadArray, $_row["name"]);
                    }
                }
                $row["docFiles"] = $uploadArray;

                // get evidence
                $sql = "SELECT name
                        FROM upload 
                        WHERE projectId = $id AND type = 'evidence'";
                        
                $_result = $conn->query($sql);

                $uploadArray = [];
                if ($_result->num_rows > 0) {
                    while ($_row = $_result->fetch_assoc()) {
                        array_push($uploadArray, $_row["name"]);
                    }
                }
                $row["evidenceFiles"] = $uploadArray;

                $json_result = json_encode($row, JSON_UNESCAPED_UNICODE);
            }
        }
    
        $conn->close();

        echo $json_result;
    }
?>