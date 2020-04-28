<?php
    require 'includes/connection.php';
    require 'includes/allow-admin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>เพิ่มบัญชีผู้ใช้</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
    <link href="./plugins/jquery-steps/css/jquery.steps.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script
    src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    
    <!--**********************************
        Main wrapper start
    ***********************************-->
    

        <div class="nav-header">
            <div class="logo">
                <a href="index.html">
                    <b class="logo-abbr"><img src="images/logo.png" height="30" width="30" alt=""> </b>
                    <span class="logo-compact"><img src="./images/logo-compact.png" alt=""></span>
                    <span class="brand-title">
                        <img src="z/psu4.png" height="80" width="245" alt="">
                    </span>
                </a>
            </div>
        </div>

        <div class="header">    
            <div class="header-content clearfix">
                
                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-left">
                        
                </div>
                <div class="header-right">
                    <ul class="clearfix">
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
                                <span class="activity active"></span>
                                <img src="z/people.webp" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile   dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li><a href="/projectx/admin.php"><i class="icon-home"></i> <span>หน้าหลัก</span></a></li>
                                        <li><a href="/projectx/user.php"><i class="icon-user"></i> <span>บัญชีผู้ใช้</span></a></li>
                                        <li><a href="#" data-toggle="modal" data-target="#add-budget-year"><i class="icon-plus"></i> <span>เพิ่มปีงบประมาณ</span></a></li>
                                        <li><a href="/projectx/logout.php"><i class="icon-key"></i> <span>Logout</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form id="addPersonForm" method="POST" action="add-person.php">
                        <div><br>
                            <h4>เพิ่มบัญชีผู้ใช้</h4>
                            <section>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="col-md-12">
                                            <label class="control-label">ชื่อ</label>
                                                 <div class="form-group">
                                                    <input type="text" name="responFirstname" class="form-control" placeholder="Firstname" required>
                                                 </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="col-md-12">
                                            <label class="control-label">นามสกุล</label>
                                                <div class="form-group">
                                                    <input type="text" name="responLastname" class="form-control" placeholder="Lastname" required>
                                                </div>
                                        </div>  
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="col-md-12">
                                            <label class="control-label">ชื่อบัญชีผู้ใช้</label>
                                                <div class="form-group">
                                                    <input type="text" name="responUsername" class="form-control" placeholder="Username" required>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="col-md-12">
                                            <label class="control-label">รหัสผ่าน</label>
                                                <div class="form-group">
                                                    <input type="password" id="responPassword" name="responPassword" class="form-control" placeholder="Password" required>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="col-md-12">
                                            <label class="control-label">ยืนยันรหัสผ่าน</label>
                                                <div class="form-group">
                                                    <input type="password" id="responPasswordConfirm" name="responPasswordConfirm" class="form-control" placeholder="Confirm Password" required>
                                                </div>
                                        </div>
                                    </div>
                                    <style>
                                        select:invalid { color: gray; }
                                    </style>
                                    <div class="col-lg-6">
                                        <div class="col-md-12">
                                            <label class="control-label">หน่วยงาน</label>
                                                <div class="form-group">
                                                    <select class="form-control form-control-lg" id="departmentId" name="departmentId" required>
                                                        <option value="" disabled selected hidden>เลือกหน่วยงาน</option>
                                            <?php

                                            $sql = "SELECT departmentId, departmentName FROM department";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<option value='".$row["departmentId"]."'>".$row["departmentName"]."</option>";
                                                }
                                            }

                                            ?>

                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="col-md-12">
                                            <label class="control-label">สถานะ</label>
                                        <div class="form-group">
                                            <select class="form-control form-control-lg" name="role" required>
                                                <option value="" disabled selected hidden>เลือกสถานะ</option>
                                                <option value="admin">ผู้ดูแลระบบ</option>
                                                <option value="respon">ผู้รับผิดชอบโครงการ</option>
                                                <option value="manager">คณะผู้บริหาร</option>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6"><br>
                                    <div class="col-md-12">
                                        <button type="button" id="savePerson" class="btn mb-1 btn-success">Save</button>
                                        <button type="button" id="clearPerson" class="btn mb-1 btn-warning">Clear</button>
                                    </div>
                                        </div>

                                    <!-- Jquery submit form -->
                                    <script>

                                    // default value
                                    $("select[name='departmentId']").val("");
                                    $("select[name='role']").val("");

                                    $("#clearPerson").click(function() {
                                        $("input[name='responFirstname']").val("");
                                        $("input[name='responLastname']").val("");
                                        $("input[name='responUsername']").val("");
                                        $("input[name='responPassword']").val("");
                                        $("input[name='responPasswordConfirm']").val("");
                                        $("select[name='departmentId']").val("");
                                        $("select[name='role']").val("");
                                    });

                                    $('#savePerson').click(function() {

                                        var isFormCompleted = true;

                                        // check confirm password
                                        if ($("#responPassword").val() != $("#responPasswordConfirm").val()) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: 'Confirm password incorrected!'
                                            });

                                            isFormCompleted = false;
                                        }

                                        if (isFormCompleted) {
                                            $('#addPersonForm').submit();
                                        }
                                    });
                                    </script>
                            </section>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Basic Table</h4>
                            <div class="table-responsive">
                                <table class="table header-border">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">First Name</th>
                                            <th scope="col">Last Name</th>
                                            <th scope="col">User Name</th>
                                            <th scope="col">Department</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php

                                        $sql = "SELECT responId, responFirstname, responLastname, responUsername, dp.departmentName as department, role 
                                                FROM person as p
                                                LEFT JOIN department as dp ON dp.departmentId = p.departmentId";

                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo    "<th>".$row["responId"]."</th>";
                                                echo    "<td>".$row["responFirstname"]."</td>";
                                                echo    "<td>".$row["responLastname"]."</td>";
                                                echo    "<td>".$row["responUsername"]."</td>";
                                                echo    "<td>".$row["department"]."</td>";
                                                echo    "<td>".$row["role"]."</td>";
                                                echo    "<td>";
                                                echo        "<button type='button' class='btn mb-1 btn-danger' onclick='DeletePerson(".$row["responId"].")'>Delete</button>";
                                                echo    "</td>";
                                                echo "</tr>";
                                            }
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        
            function DeletePerson(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.value) {

                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {

                            if (this.responseText == "") {
                                    Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!'
                                    })                                

                            } else {
                                    Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                    );

                                    setTimeout(function() {
                                        window.location.href = '/projectx/user.php';
                                    }, 2000);
                            } 
                            }
                        };
                        xmlhttp.open("POST", "/projectx/delete-person.php", true);
                        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xmlhttp.send("id=" + id);
                    }
                })
            }

        </script>
        
    </div>

    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>


    <script src="./plugins/jquery-steps/build/jquery.steps.min.js"></script>
    <script src="./plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="./js/plugins-init/jquery-steps-init.js"></script>
    <br> <br> <br> <br>
    

</body>

</html>

<?php
    $conn->close();
?>