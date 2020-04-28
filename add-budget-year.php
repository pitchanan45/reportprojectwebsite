<?php

    require 'includes/connection.php';
    require 'includes/allow-admin.php';

    $year = $_POST["year"];
    if (trim($year) == "")
	{
        echo "
        <script>
            alert('Year is empty!, please assign');
            window.location.href = '/projectx/default-route.php';
        </script>
        ";
    } else {
        $sql = "INSERT INTO budget_year (year) VALUES ($year)";
        $result = $conn->query($sql);

        // $result == 1 // success
        // $result == 0, '' // fail
        if ($result == 1) {
            $sql = "SELECT id FROM budget_year ORDER BY id DESC LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $_SESSION["budget_year"] = $row["id"];
                }
            }
        }
        
        $conn->close();

        header("Location: /projectx/default-route.php");
    }
?>