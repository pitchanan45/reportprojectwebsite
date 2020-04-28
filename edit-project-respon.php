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
    require 'includes/allow-respon.php';

	$isFormCompleted = true;
    
    if (isset($_POST['projectId'])) {
        $projectId = $_POST["projectId"];
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

    if (isset($_POST['workingDate'])) {
        $workingDate = $_POST["workingDate"];
    } else {
        $isFormCompleted = false;
    }

    if (isset($_POST['participant'])) {
        $participant = $_POST["participant"];
    } else {
        $isFormCompleted = false;
    }

    if (isset($_POST['statusProject'])) {
        $statusProject = $_POST["statusProject"];
    } else {
        $isFormCompleted = false;
    }

    if (isset($_POST['satisfaction'])) {
        $satisfaction = $_POST["satisfaction"];
    } else {
        $isFormCompleted = false;
    }

    if (isset($_POST['paid'])) {
        $paid = $_POST["paid"];
    } else {
        $isFormCompleted = false;
    }

	if ($isFormCompleted)
	{
        if ($participant == NULL) {
            $participant = 'NULL';
        }

        $sql = "UPDATE project
                SET projectStart = STR_TO_DATE('$projectStart', '%Y-%m-%d'), 
                    projectFinish = STR_TO_DATE('$projectFinish', '%Y-%m-%d'), 
                    workingDate = STR_TO_DATE('$workingDate', '%Y-%m-%d'), 
                    participant = $participant,
                    statusProject = '$statusProject',
                    satisfaction = '$satisfaction',
                    paid = $paid

                WHERE projectId = $projectId";
        
        $result = $conn->query($sql);

        if ($result == 1) {

            // upload doc files
            $uploadCompleted = true;
            $total = count($_FILES['upload_doc']['name']);

            for ($i = 0; $i < $total; $i++) {

                $tmpFilePath = $_FILES['upload_doc']['tmp_name'][$i];
        
                if ($tmpFilePath != "") {
                    
                    $name = $_FILES['upload_doc']['name'][$i];
                    $_name = explode(".", $name);
                    $ext = end($_name);
                    $onlyName = date("Y-m-d-H-i-s") . ".$ext";
                    $newFilePath = "./upload/doc/" . $projectId . "/";

                    if (!file_exists($newFilePath)) {
                        mkdir($newFilePath, 0755, true);
                    }

                    $newFilePath = $newFilePath . $onlyName;

                    if (!move_uploaded_file($tmpFilePath, $newFilePath)) {
                        $uploadCompleted = false;
                        break;
                    } else {
                        $sql = "INSERT INTO upload 
                                (
                                    name, 
                                    projectId,
                                    type
                                ) VALUES 
                                (
                                    '$onlyName', 
                                    $projectId,
                                    'doc'
                                )";
                        
                        $result = $conn->query($sql);

                        if ($result != 1) {
                            $uploadCompleted = false;
                            break;
                        }
                    }
                }
            }

            // upload evidence files
            $uploadCompleted = true;
            $total = count($_FILES['upload_evidence']['name']);

            for ($i = 0; $i < $total; $i++) {

                $tmpFilePath = $_FILES['upload_evidence']['tmp_name'][$i];
        
                if ($tmpFilePath != "") {
                    
                    $name = $_FILES['upload_evidence']['name'][$i];
                    $_name = explode(".", $name);
                    $ext = end($_name);
                    $onlyName = date("Y-m-d-H-i-s") . ".$ext";
                    $newFilePath = "./upload/evidence/" . $projectId . "/";

                    if (!file_exists($newFilePath)) {
                        mkdir($newFilePath, 0755, true);
                    }

                    $newFilePath = $newFilePath . $onlyName;

                    if (!move_uploaded_file($tmpFilePath, $newFilePath)) {
                        $uploadCompleted = false;
                        break;
                    } else {
                        $sql = "INSERT INTO upload 
                                (
                                    name, 
                                    projectId,
                                    type
                                ) VALUES 
                                (
                                    '$onlyName', 
                                    $projectId,
                                    'evidence'
                                )";
                        
                        $result = $conn->query($sql);

                        if ($result != 1) {
                            $uploadCompleted = false;
                            break;
                        }
                    }
                }
            }

            if (!$uploadCompleted) {
                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        })
                    </script>
                ";
            } else {
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
            }

            
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

        $conn->close();

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