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

	// php upload file example
	// https://codewithawa.com/posts/image-upload-using-php-and-mysql-database
	
	require 'includes/connection.php';
    require 'includes/allow-admin.php';

	$isFormCompleted = true;

	if (isset($_FILES['image'])) {
		$image = $_FILES["image"];

		// check image type supported
		$imageInfo = getimagesize($image['tmp_name']);
		if (($imageInfo[2] !== IMAGETYPE_GIF) && ($imageInfo[2] !== IMAGETYPE_JPEG) && ($imageInfo[2] !== IMAGETYPE_PNG)) {
			$isFormCompleted = false;
		}
	} else {
		$isFormCompleted = false;
	}
    
	if ($isFormCompleted)
	{
		$imgName = $image['name'];
		$target = "upload/".basename($imgName);

		if (move_uploaded_file($image['tmp_name'], $target)) {
			$msg = "Image uploaded successfully";
		} else{
			$msg = "Failed to upload image";
		}

		echo $imgName;
	  
		// $sql = "INSERT INTO project (strategyName, projectNumber, operatingBudget, investmentBudget, startDate, finishDate, year) VALUES ('".$strategyName."', ".$projectNumber.", ".$operatingBudget.", ".$investmentBudget.", STR_TO_DATE('".$startDate."', '%Y-%m-%d'), STR_TO_DATE('".$finishDate."', '%Y-%m-%d'), ".$year.")";
        // $result = $conn->query($sql);
    
        //$conn->close();

        // if ($result == 1) {
        //     echo "
        //     <script>
        //         Swal.fire({
        //             position: 'center',
        //             icon: 'success',
        //             title: 'saved',
        //             showConfirmButton: false,
        //             timer: 1500
        //         })
        //     </script>
        //     ";
        // } else {
        //     echo "
        //     <script>
        //         Swal.fire({
        //             icon: 'error',
        //             title: 'Oops...',
        //             text: 'Something went wrong!'
        //         })
        //     </script>
        //     ";
        // }

        // echo "
        //     <script>
        //         setTimeout(function () {
        //             window.location.href = '/projectx/default-route.php';
        //         }, 2000);
        //     </script>
        // ";
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
?>

</body>