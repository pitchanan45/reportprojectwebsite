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
    
    if (isset($_POST['responFirstname'])) {
		$responFirstname = $_POST["responFirstname"];
	} else {
		$isFormCompleted = false;
    }

    if (isset($_POST['responLastname'])) {
		$responLastname = $_POST["responLastname"];
	} else {
		$isFormCompleted = false;
    }

    if (isset($_POST['responUsername'])) {
		$responUsername = $_POST["responUsername"];
	} else {
		$isFormCompleted = false;
    }

    if (isset($_POST['responPassword'])) {
		$responPassword = $_POST["responPassword"];
	} else {
		$isFormCompleted = false;
    }

    if (isset($_POST['departmentId'])) {
		$departmentId = $_POST["departmentId"];
	} else {
		$isFormCompleted = false;
    }

    if (isset($_POST['role'])) {
		$role = $_POST["role"];
	} else {
		$isFormCompleted = false;
    }


    if ($isFormCompleted) {
        $sql = "INSERT INTO person (responFirstname, responLastname, responUsername, responPassword, departmentId, role) VALUES ('$responFirstname', '$responLastname', '$responUsername', '$responPassword', $departmentId, '$role')";
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
                    window.location.href = '/projectx/user.php';
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
                    window.location.href = '/projectx/user.php';
                }, 2000);
			</script>
		";
    }
?>

</body>