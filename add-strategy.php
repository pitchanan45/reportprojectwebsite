<!DOCTYPE html>
<html lang="en">
<head>
    <script
    src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>
<body>

<?php

    require 'includes/connection.php';
    require 'includes/allow-admin.php';
	
    $strategyName = $_POST["strategyName"];
    $projectNumber = $_POST["projectNumber"];
    $operatingBudget = $_POST["operatingBudget"];
    $investmentBudget = $_POST["investmentBudget"];
    $startDate = $_POST["startDate"];
    $finishDate = $_POST["finishDate"];
    $year = $_POST["strategyYear"];
    
    if (trim($strategyName) == "")
	{
        echo "
        <script>
            alert('strategyName is empty!, please assign');
            window.location.href = '/projectx/default-route.php';
        </script>
        ";
    } else {
        $sql = "INSERT INTO strategy (strategyName, projectNumber, operatingBudget, investmentBudget, startDate, finishDate, year) VALUES ('$strategyName', $projectNumber, $operatingBudget, $investmentBudget, STR_TO_DATE('$startDate', '%Y-%m-%d'), STR_TO_DATE('$finishDate', '%Y-%m-%d'), $year)";
        $result = $conn->query($sql);

        echo $result;
    
        $conn->close();

        if ($result == 1) {
            echo "
            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'saved',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>
            ";
        } else {
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                })
            </script>
            ";
        }

        echo "
            <script>
                setTimeout(function () {
                    //window.location.href = '/projectx/default-route.php';
                }, 2000);
            </script>
        ";
    }
?>

</body>