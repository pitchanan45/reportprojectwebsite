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

	$isFormCompleted = true;
    
  if (isset($_POST['projectId'])) {
		$projectId = $_POST["projectId"];
	} else {
		$isFormCompleted = false;
  }

  if (isset($_POST['projectName'])) {
		$projectName = $_POST["projectName"];
	} else {
		$isFormCompleted = false;
  }

  if (isset($_POST['projectStart'])) {
		$projectStart = $_POST["projectStart"];
	} else {
		$isFormCompleted = false;
  }

  if (isset($_POST['projectFinish'])) {
		$projectFinish = $_POST["projectFinish"];
	} else {
		$isFormCompleted = false;
  }

  if (isset($_POST['budget'])) {
		$budget = $_POST["budget"];
	} else {
		$isFormCompleted = false;
  }

  if (isset($_POST['responId'])) {
		$responId = $_POST["responId"];
	} else {
		$isFormCompleted = false;
  }

  if (isset($_POST['strategyId'])) {
		$strategyId = $_POST["strategyId"];
	} else {
		$isFormCompleted = false;
  }

  if (isset($_POST['projectType'])) {
		$projectType = $_POST["projectType"];
	} else {
		$isFormCompleted = false;
  }
    
	if ($isFormCompleted)
	{
        $sql = "UPDATE project 
                SET projectName = '$projectName', 
                    projectStart = STR_TO_DATE('$projectStart', '%Y-%m-%d'), 
                    projectFinish = STR_TO_DATE('$projectFinish', '%Y-%m-%d'), 
                    budget = $budget, 
                    responId = $responId, 
                    strategyId = $strategyId, 
                    projectType = '$projectType'
                WHERE projectId = $projectId";
                
        $result = $conn->query($sql);
        
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
                    window.location.href = '/projectx/default-route.php';
                }, 2000);
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
                
                setTimeout(function () {
                    window.location.href = '/projectx/default-route.php';
                }, 2000);
			</script>
		";
    }
?>

</body>