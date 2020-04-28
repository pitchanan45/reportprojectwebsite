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
    require 'includes/allow-guest.php';
    
    $isFormCompleted = true;

    if (isset($_POST["username"])) {
        $username = $_POST["username"];
    } else {
        $isFormCompleted = false;
    }

    if (isset($_POST["password"])) {
        $password = $_POST["password"];
    } else {
        $isFormCompleted = false;
    }

    if ($isFormCompleted) {

        $sql = "SELECT responUsername, role FROM person WHERE responUsername = '$username' AND responPassword = '$password'";
        $result = $conn->query($sql);
        $conn->close();

        if ($result->num_rows > 0) {

            $role = "";
            while ($row = $result->fetch_assoc()) { // rows = 1
                $role = $row["role"];
            }

            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;

            echo "
            <script>
                window.location.href = '/projectx/default-route.php';
            </script>
            ";
        } else {
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Username or Password incorrect!'
                })

                setTimeout(function () {
                    window.location.href = '/projectx/default-route.php';
                }, 2000);
            </script>
            ";
        }

    } else {
        echo "
			<script>
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Username or Password incorrect!'
                })

                setTimeout(function () {
                    window.location.href = '/projectx/default-route.php';
                }, 2000);
                
			</script>
		";
    }
?>

</body>