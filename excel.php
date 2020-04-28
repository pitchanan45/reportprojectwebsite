<?php

    //require 'includes/connection.php';
    require 'includes/allow-manager.php';
    
    $isFormCompleted = true;

    if (isset($_POST['budgetYear'])) {
        $budgetYear = $_POST['budgetYear'];
    } else {
        $isFormCompleted = false;
    }

    if (isset($_POST['quarter'])) {
        $be = (int)$budgetYear - 543;
        $quarter = $_POST['quarter'];
        if ($quarter == 1) {
            $be = $be - 1;
            $startDate = "$be/10/01";
            $endDate = "$be/12/31";
        } else if ($quarter == 2) {
            $startDate = "$be/01/01";
            $endDate = "$be/03/31";
        } else if ($quarter == 3) {
            $startDate = "$be/04/01";
            $endDate = "$be/06/30";
        } else if ($quarter == 4) {
            $startDate = "$be/07/01";
            $endDate = "$be/09/30";
        } else {
            $be = $be - 1;
            $startDate = "$be/10/01";

            $be = $be + 1;
            $endDate = "$be/09/30";
        }
    } else {
        $be = (int)$budgetYear - 543;
        $be = $be - 1;
        $startDate = "$be/10/01";

        $be = $be + 1;
        $endDate = "$be/09/30";
    }

    if (!$isFormCompleted) {
        echo "";
    } else {
        $sql = "SELECT  strategy.strategyId, 
                        strategy.strategyName,
                        strategy.investmentBudget,
                        strategy.operatingBudget
                FROM strategy
                LEFT JOIN budget_year ON budget_year.id = strategy.year
                WHERE budget_year.year = '$budgetYear'";

            $result = $conn->query($sql);

            $json_result = "";
            $phpObj = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $sql = "SELECT 
                        projectId, 
                        projectName, 
                        projectStart, 
                        projectFinish, 
                        budget, 
                        project.responId,
                        CONCAT(person.responFirstname, ' ', person.responLastname) as responName,
                        department.departmentName,
                        department.supervisor,
                        projectType,
                        workingDate,
                        participant,
                        statusProject,
                        satisfaction,
                        paid
                    FROM project 
                    LEFT JOIN strategy ON strategy.strategyId = project.strategyId
                    LEFT JOIN budget_year ON budget_year.id = strategy.year
                    LEFT JOIN person ON person.responId = project.responId
                    LEFT JOIN department ON department.departmentId = person.departmentId
                    WHERE strategy.strategyId = " . (int)$row["strategyId"] . 
                    " AND workingDate >= '$startDate' AND workingDate <= '$endDate'";

                    $subResult = $conn->query($sql);

                    $projectArr = [];
                    if ($subResult->num_rows > 0) {
                        while ($subRow = $subResult->fetch_assoc()) {
                            array_push($projectArr, $subRow);
                        }
                    }

                    $strategy = array(
                        'strategyId' => $row["strategyId"],
                        'strategyName' => $row["strategyName"],
                        'investmentBudget' => $row["investmentBudget"],
                        'operatingBudget' => $row["operatingBudget"],
                        'projects' => $projectArr
                    );

                    array_push($phpObj, $strategy);
                }
            }

            $json_result = json_encode($phpObj, JSON_UNESCAPED_UNICODE);

            // $conn->close();

            // echo $json_result;
    }
?>