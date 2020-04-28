<?php

    require 'includes/connection.php';
    require 'includes/allow-admin.php';

    if (isset($_POST["year"])) {
        $budgetYear = $_POST["year"];
        $_SESSION["budget_year"] = $budgetYear;
    } else {
        if (isset($_SESSION["budget_year"])) {
            $budgetYear = $_SESSION["budget_year"];
        } else {
            $budgetYear = 1;
            $_SESSION["budget_year"] = 1;
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>แอดมิน</title>

    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link href="./plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script
    src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (!this.responseText) {
                    window.location.href = '/projectx/default-route.php';
                }
            }
        };
        xmlhttp.open("GET", "/projectx/check.php?support=admin", true);
        xmlhttp.send();
    </script>
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

        <div class="header-left">
            <div class="form-group">
                    <div class="basic-form">
                        
                    <form id="budgetYearListForm" method="post">
                        <div class="form-group">
                            <select class="form-control form-control-lg" id="budget-year-select" name="year">
                            
                            <?php

                            $sql = "SELECT id, year FROM budget_year";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='".$row["id"]."'>แผนปฏิบัติการโครงการตามยุทธศาสตร์ คณะวิทยาการจัดการ ประจำปีงบประมาณ พ.ศ. ". $row["year"] ."</option>";
                                }
                            }

                            echo "
                                <script>
                                    $('#budget-year-select').val('".$budgetYear."');
                                </script>
                            ";

                            ?>

                            </select>
                        </div>
                    </form>
                    <script>
                        $('#budget-year-select').change(function(){
                            $('#budgetYearListForm').submit();
                        });
                    </script>
            <a href="#" data-toggle="modal" data-target="#add-strategy" class="btn btn-primary"></i><h3>+เพิ่มยุทธศาสตร์</h3></a>

            <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        
                        <?php

                        $sql = "SELECT strategyId, strategyName, projectNumber, operatingBudget, investmentBudget FROM strategy WHERE year = ". $budgetYear;
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {

                                $sql = "SELECT  p.projectId, 
                                                p.projectName, 
                                                b.year as year, 
                                                p.budget, 
                                                concat(date_format(projectStart, '%d/%m/%Y'), ' - ', date_format(projectFinish, '%d/%m/%Y'))  as rangeDate, 
                                                dp.departmentName as department, 
                                                dp.supervisor as supervisor,
                                                p.statusProject
                                                FROM project as p
                                                INNER JOIN strategy as s ON s.strategyId = p.strategyId 
                                                INNER JOIN budget_year as b ON b.id = s.year 
                                                LEFT JOIN person ON person.responId = p.responId 
                                                LEFT JOIN department as dp ON dp.departmentId = person.departmentId 
                                                WHERE p.strategyId = ". $row["strategyId"];

                                $subResult = $conn->query($sql);

                                echo '<div class="card-body">';
                                echo    '<h4>#'. $row["strategyId"] .' - '. $row["strategyName"] .'</h4>';
                                echo    '<div class="d-sm-flex justify-content-between mb-2"><h5 class="mb-sm-0"> <small class="text-muted ml-3"></small></h5>';
                                echo        '<div class="media-reply__link"><a href="#" data-toggle="modal" data-target="#edit-strategy" onclick="StrategyLookup('. $row["strategyId"] .');"><button class="btn btn-transparent text-dark font-weight-bold p-0 ml-2">Edit</button></a><button class="btn btn-transparent text-dark font-weight-bold p-0 ml-2" onclick="ConfirmDeleteStrategy('. $row["strategyId"] .')">Delete</button></div>';
                                echo    '</div>';
                                echo    '<table class="table table-striped table-bordered zero-configuration">';
                                echo    '<div class="card-body"><h4>งบประมาณ  '. ((int)$row["operatingBudget"] + (int)$row["investmentBudget"]) .' บาท</h4><h4>จำนวนโครงการทั้งสิ้น '. $row["projectNumber"] .' โครงการ</h4>';
                                echo    '<a href="#" data-toggle="modal" data-target="#add-project" class="btn btn-primary" onclick="OpenAddProjectPopup('. $row["strategyId"] .', \''. $row["strategyName"] .'\', '. $row["operatingBudget"] .', '. $row["investmentBudget"] .')"><i class="ti-plus f-s-12 m-r-5"></i>โครงการ</a>';
                                echo        '<thead>';
                                echo            '<tr>';
                                echo                '<th>หัวข้อโครงการ</th>';
                                echo                '<th>ประจำปีงบประมาณ พ.ศ.</th>';
                                echo                '<th>งบประมาณที่จัดสรร</th>';
                                echo                '<th>ช่วงเวลาที่ดำเนินการ</th>';
                                echo                '<th>หน่วยงานที่รับผิดชอบ</th>';
                                echo                '<th>ผู้บริหารที่กำกับดูแล</th>';
                                echo                '<th>สถานะของโครงการ</th>';
                                echo                '<th>Action</th>';
                                                
                                echo            '</tr>';
                                echo        '</thead>';
                                echo        '<tbody>';

                                    if ($subResult->num_rows > 0) {
                                        while($subRow = $subResult->fetch_assoc()) {
                                            echo '<tr>';
                                                echo '<td>'.$subRow["projectName"].'</td>';
                                                echo '<td>'.$subRow["year"].'</td>';
                                                echo '<td>'.$subRow["budget"].'</td>';
                                                echo '<td>'.$subRow["rangeDate"].'</td>';
                                                echo '<td>'.$subRow["department"].'</td>';
                                                echo '<td>'.$subRow["supervisor"].'</td>';
                                                echo '<td>'.$subRow["statusProject"].'</td>';
                                                echo '<td width="15%">
                                                    <a href="#" data-toggle="modal" data-target="#edit-project" onclick="ProjectLookup('. $subRow["projectId"] .')"><button type="button" class="btn btn-primary">Edit</button></a>
                                                    <button type="button" class="btn btn-primary" onclick="DeleteProject('.$subRow["projectId"].')">Delete</button>
                                                    </td>';
                                            echo '</tr>';
                                        }
                                    }
                                    
                                echo        '</tbody>';
                                echo    '</table>';
                                echo '</div>';
                            } 
                        }

                        ?>

                    </div>
                </div>
            </div>
    
        </div>
    
    </div>

    <div class="modal fade none-border" id="add-budget-year">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Add a new budget year</strong></h4>
                </div>
                <div class="modal-body">
                    <form id="budgetYearForm" method="post" action="add-budget-year.php">
                        <div class="row">
                            <div class="col-md-12">
                                
                                    <label class="control-label">ปีงบประมาณ</label>
                                    <input class="form-control form-white" placeholder="ปีงบประมาณ" type="text" name="year"/>
                               
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button id="addBudgetYearSubmit" type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">เพิ่ม</button>
                </div>

                <!-- Jquery submit form -->
                <script>
                    $('#addBudgetYearSubmit').click(function(){
                        $('#budgetYearForm').submit();
                    });
                </script>
            </div>
        </div>
    </div>
    
    <div class="modal fade none-border" id="add-strategy">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Add a new strategy</strong></h4>
                </div>
                <div class="modal-body">
                    <form id="addStrategyForm" method="post" action="add-strategy.php">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">ยุทธศาสตร์</label>
                                <input class="form-control form-white" placeholder="ยุทธศาสตร์" type="text" name="strategyName" id="strategyName">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">จำนวนโครงการ</label>
                                <input class="form-control form-white" placeholder="จำนวนโครงการ" type="number" name="projectNumber" id="projectNumber">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">งบดำเนินงาน</label>
                                <input class="form-control form-white" placeholder="งบดำเนินงาน" type="number" name="operatingBudget" id="operatingBudget">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">งบลงทุน</label>
                                <input class="form-control form-white" placeholder="งบลงทุน" type="number" name="investmentBudget" id="investmentBudget">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">งบประมาณ</label>
                                <input class="form-control form-white" placeholder="งบประมาณ" type="number" name="budget" id="budget" disabled>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">เวลาที่เริ่มดำเนินการ</label>
                                <input class="form-control form-white" placeholder="เวลาที่เริ่มดำเนินการ" type="date" name="startDate" id="startDate">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">เวลาสิ้นสุดยุทธศาสตร์</label>
                                <input class="form-control form-white" placeholder="เวลาสิ้นสุดยุทธศาสตร์" type="date" name="finishDate" id="finishDate">
                            </div>
                            <input type="text" id="strategyYear" name="strategyYear" style="display: none;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">ยกเลิก</button>
                    <button id="addStrategySubmit" type="button" class="btn btn-danger waves-effect waves-light save-category">สร้าง</button>
                </div>

                <!-- Jquery submit form -->
                <script>

                    $('#operatingBudget').on("keyup", function(){
                        $('#budget').val(add($('#operatingBudget').val(), $('#investmentBudget').val()));
                    });

                    $('#investmentBudget').on("keyup", function(){
                        $('#budget').val(add($('#operatingBudget').val(), $('#investmentBudget').val()));
                    });

                    function add(a, b) {
                        return Number(a) + Number(b);
                    }

                    $('#addStrategySubmit').click(function(){

                        let isFilled = true;
                        
                        if (!$('#strategyName').val()) {
                            alert('strategyName');
                            isFilled = false;
                        }

                        if (!$('#projectNumber').val()) {
                            alert('projectNumber');
                            isFilled = false;
                        }

                        if (!$('#operatingBudget').val()) {
                            alert('operatingBudget');
                            isFilled = false;
                        }

                        if (!$('#investmentBudget').val()) {
                            alert('investmentBudget');
                            isFilled = false;
                        }

                        if (!$('#startDate').val()) {
                            alert('startDate');
                            isFilled = false;
                        }

                        if (!$('#finishDate').val()) {
                            alert('finishDate');
                            isFilled = false;
                        }

                        $('#strategyYear').val($('#budget-year-select').val());

                        if (isFilled) {
                            $('#addStrategyForm').submit();
                        }
                        
                    });
                </script>
            </div>
        </div>
    </div>

    <div class="modal fade none-border" id="edit-strategy">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Edit a strategy #<span id="edit_strategy_id"></span></strong></h4>
                </div>
                <div class="modal-body">
                    <form id="editStrategyForm" method="post" action="edit-strategy.php">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">ยุทธศาสตร์</label>
                                <input class="form-control form-white" placeholder="ยุทธศาสตร์" type="text" name="strategyName" id="edit_strategyName">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">จำนวนโครงการ</label>
                                <input class="form-control form-white" placeholder="จำนวนโครงการ" type="number" name="projectNumber" id="edit_projectNumber">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">งบดำเนินงาน</label>
                                <input class="form-control form-white" placeholder="งบดำเนินงาน" type="number" name="operatingBudget" id="edit_operatingBudget">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">งบลงทุน</label>
                                <input class="form-control form-white" placeholder="งบลงทุน" type="number" name="investmentBudget" id="edit_investmentBudget">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">งบประมาณ</label>
                                <input class="form-control form-white" placeholder="งบประมาณ" type="number" name="budget" id="edit_budget" disabled>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">เวลาที่เริ่มดำเนินการ</label>
                                <input class="form-control form-white" placeholder="เวลาที่เริ่มดำเนินการ" type="date" name="startDate" id="edit_startDate">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">เวลาสิ้นสุดยุทธศาสตร์</label>
                                <input class="form-control form-white" placeholder="เวลาสิ้นสุดยุทธศาสตร์" type="date" name="finishDate" id="edit_finishDate">
                            </div>
                            <input type="text" id="edit_strategyId" name="strategyId" style="display: none;">
                            <input type="text" id="edit_strategyYear" name="strategyYear" style="display: none;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">ยกเลิก</button>
                    <button id="editStrategySubmit" type="button" class="btn btn-danger waves-effect waves-light save-category">แก้ไข</button>
                </div>

                <!-- Jquery submit form -->
                <script>

                    $('#edit_operatingBudget').on("keyup", function(){
                        $('#edit_budget').val(add($('#edit_operatingBudget').val(), $('#edit_investmentBudget').val()));
                    });

                    $('#edit_investmentBudget').on("keyup", function(){
                        $('#edit_budget').val(add($('#edit_operatingBudget').val(), $('#edit_investmentBudget').val()));
                    });

                    function add(a, b) {
                        return Number(a) + Number(b);
                    }

                    $('#editStrategySubmit').click(function(){

                        let isFilled = true;

                        $('#edit_strategyId').val($('#edit_strategy_id').text());
                        
                        if (!$('#edit_strategyName').val()) {
                            alert('strategyName');
                            isFilled = false;
                        }

                        if (!$('#edit_projectNumber').val()) {
                            alert('projectNumber');
                            isFilled = false;
                        }

                        if (!$('#edit_operatingBudget').val()) {
                            alert('operatingBudget');
                            isFilled = false;
                        }

                        if (!$('#edit_investmentBudget').val()) {
                            alert('investmentBudget');
                            isFilled = false;
                        }

                        if (!$('#edit_startDate').val()) {
                            alert('startDate');
                            isFilled = false;
                        }

                        if (!$('#edit_finishDate').val()) {
                            alert('finishDate');
                            isFilled = false;
                        }

                        $('#edit_strategyYear').val($('#budget-year-select').val());

                        if (isFilled) {
                            $('#editStrategyForm').submit();
                        }
                        
                    });
                </script>
            </div>
        </div>
    </div>

    <!-- Modal Add Project -->
    <div class="modal fade none-border" id="add-project">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Add a new project</strong></h4>
                </div>
                <div class="modal-body">
                    <form id="addProjectForm" method="POST" action="add-project.php">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">ยุทธศาสตร์</label>
                                <input class="form-control form-white" placeholder="ยุทธศาสตร์" type="text" name="strategy" id="add_project_strategyName" disabled>
                            </div>
                            <input type="text" id="add_project_strategyId" name="strategyId" style="display: none;">
                            <div class="col-md-12">
                                <label class="control-label">งบประมาณรวม</label>
                                <input class="form-control form-white" placeholder="งบประมาณรวม" type="number" name="strategyBudget" id="add_project_strategy_budget" disabled>
                            </div>
                            <div class="col-md-12">
                                <br>
                                <input type="radio" name="budgetType" value="operating" checked> งบสำหรับดำเนินการ<br>
                                <input type="radio" name="budgetType" value="investment"> งบสำหรับลงทุน<br>
                                <br>
                            </div>
                            <input type="text" id="projectType" name="projectType" style="display: none;">
                            <input type="text" id="operatingBudgetTemp" style="display: none;">
                            <input type="text" id="investmentBudgetTemp" style="display: none;">
                            <div class="col-md-12">
                                <label class="control-label" id="budgetTypeLabel">งบดำเนินการ</label>
                                <input class="form-control form-white" type="number" id="add_project_strategy_budgetType" name="budget" disabled>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">ชื่อโครงการ</label>
                                <input class="form-control form-white" placeholder="ชื่อโครงการ" type="text" name="projectName">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">เลือกผู้รับผิดชอบโครงการ</label>
                                <select class="form-control form-control-lg" id="add_project_respon_list">
                                    <option value="" disabled selected hidden>ผู้รับผิดชอบโครงการ</option>
                                </select>
                            </div>
                            <div class="col-md-12" style="display: none">
                                <label class="control-label">ค้นหาผู้รับผิดชอบโครงการ</label>
                                <input class="form-control form-white" placeholder="กรุณาระบุรหัสผู้รับผิดชอบโครงการ" type="number" id="add_project_responId_query">
                                <button type="button" class="btn btn-primary" onclick="SearchResponseForAddForm()">ค้นหา</button>
                            </div>
                            <input type="text" id="add_project_responId" name="responId" style="display: none;">
                            <div class="col-md-12">
                                <label class="control-label">ชื่อผู้รับผิดชอบโครงการ</label>
                                <input class="form-control form-white" id="add_project_responName" type="text" disabled>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">หน่วยงานที่รับผิดชอบ</label>
                                <input class="form-control form-white" type="text" id="add_project_department" disabled>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">ผู้บริหารที่กำกับดูแล</label>
                                <input class="form-control form-white" type="text" id="add_project_supervisor" disabled>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">วันที่เริ่มดำเนินการ</label>
                                <input class="form-control form-white" placeholder="วันที่เริ่มดำเนินการ" type="date" name="projectStart">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">วันที่สิ้นสุดโครงการ</label>
                                <input class="form-control form-white" placeholder="วันที่สิ้นสุดโครงการ" type="date" name="projectFinish">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">งบประมาณจัดสรร</label>
                                <input class="form-control form-white" placeholder="งบประมาณจัดสรร" type="number" name="budget">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button id="addProjectSubmit" type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                </div>

                <!-- Jquery submit form -->
                <script>

                    $("input[name='budgetType']").change(function(){
                        var budgetType = $("input[name='budgetType']:checked").val();
                        $("#projectType").val(budgetType);

                        if (budgetType == "operating") {
                            $("label#budgetTypeLabel").text('งบดำเนินการ');
                            $("#add_project_strategy_budgetType").val($("#operatingBudgetTemp").val());
                        } else {
                            $("label#budgetTypeLabel").text('งบลงทุน');
                            $("#add_project_strategy_budgetType").val($("#investmentBudgetTemp").val());
                        }
                        
                    });

                    $('#addProjectSubmit').click(function(){
                        $('#addProjectForm').submit();
                    });
                </script>
            </div>
        </div>
    </div>
    <!-- END MODAL -->
    
    <!-- Modal Edit Project -->
    <div class="modal fade none-border" id="edit-project">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Edit a project #<span id="edit_project_id"></span></strong></h4>
                </div>
                <div class="modal-body">
                    <form id="editProjectForm" method="POST" action="edit-project.php">
                        <div class="row">
                        <input type="text" id="edit_project_projectId" name="projectId" style="display: none;">
                            <div class="col-md-12">
                                <label class="control-label">ยุทธศาสตร์</label>
                                <input class="form-control form-white" placeholder="ยุทธศาสตร์" type="text" name="strategy" id="edit_project_strategyName" disabled>
                            </div>
                            <input type="text" id="edit_project_strategyId" name="strategyId" style="display: none;">
                            <div class="col-md-12">
                                <label class="control-label">งบประมาณรวม</label>
                                <input class="form-control form-white" placeholder="งบประมาณรวม" type="number" name="strategyBudget" id="edit_project_strategy_budget" disabled>
                            </div>
                            <div class="col-md-12">
                                <br>
                                <input type="radio" name="edit_project_budgetType" value="operating" checked> งบสำหรับดำเนินการ<br>
                                <input type="radio" name="edit_project_budgetType" value="investment"> งบสำหรับลงทุน<br>
                                <br>
                            </div>
                            <input type="text" id="edit_project_projectType" name="projectType" style="display: none;">
                            <input type="text" id="edit_project_operatingBudgetTemp" style="display: none;">
                            <input type="text" id="edit_project_investmentBudgetTemp" style="display: none;">
                            <div class="col-md-12">
                                <label class="control-label" id="edit_project_budgetTypeLabel">งบดำเนินการ</label>
                                <input class="form-control form-white" type="number" id="edit_project_strategy_budgetType" name="budget" readonly>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">ชื่อโครงการ</label>
                                <input class="form-control form-white" placeholder="ชื่อโครงการ" type="text" name="projectName" id="edit_project_projectName">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">เลือกผู้รับผิดชอบโครงการ</label>
                                <select class="form-control form-control-lg" id="edit_project_respon_list">
                                    <option value="" disabled selected hidden>ผู้รับผิดชอบโครงการ</option>
                                </select>
                            </div>
                            <div class="col-md-12" style="display: none">
                                <label class="control-label">ค้นหาผู้รับผิดชอบโครงการ</label>
                                <input class="form-control form-white" placeholder="กรุณาระบุรหัสผู้รับผิดชอบโครงการ" type="number" id="edit_project_responId_query">
                                <button type="button" class="btn btn-primary" onclick="SearchResponseForEditForm()">ค้นหา</button>
                            </div>
                            <input type="text" id="edit_project_responId" name="responId" style="display: none;">
                            <div class="col-md-12">
                                <label class="control-label">ชื่อผู้รับผิดชอบโครงการ</label>
                                <input class="form-control form-white" id="edit_project_responName" type="text" disabled>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">หน่วยงานที่รับผิดชอบ</label>
                                <input class="form-control form-white" type="text" id="edit_project_department" disabled>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">ผู้บริหารที่กำกับดูแล</label>
                                <input class="form-control form-white" type="text" id="edit_project_supervisor" disabled>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">วันที่เริ่มดำเนินการ</label>
                                <input class="form-control form-white" placeholder="วันที่เริ่มดำเนินการ" type="date" name="projectStart" id="edit_project_projectStart">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">วันที่สิ้นสุดโครงการ</label>
                                <input class="form-control form-white" placeholder="วันที่สิ้นสุดโครงการ" type="date" name="projectFinish" id="edit_project_projectFinish">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">วันที่ดำเนินการจริง</label>
                                <input class="form-control form-white" placeholder="วันที่ดำเนินการจริง" type="date" name="workingDate" id="edit_project_workingDate" readonly>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">จำนวนผู้เข้าร่วมโครงการ</label>
                                <input class="form-control form-white" placeholder="จำนวนผู้เข้าร่วมโครงการ" type="number" name="participant" id="edit_project_participant" readonly>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">งบประมาณจัดสรร</label>
                                <input class="form-control form-white" placeholder="งบประมาณจัดสรร" type="number" name="budget" id="edit_project_budget" readonly>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">รายละเอียดโครงการ</label>
                                <br>
                                <div id="edit_project_doc_gallery"></div>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">สถานะของโครงการ</label>
                                <br>
                                <input type="radio" name="edit_project_statusProject" value="ยังไม่ดำเนินการ" disabled> ยังไม่ดำเนินการ<br>
                                <input type="radio" name="edit_project_statusProject" value="อยู่ระหว่างดำเนินการ" disabled> อยู่ระหว่างดำเนินการ<br>
                                <input type="radio" name="edit_project_statusProject" value="ดำเนินการเสร็จแล้ว" disabled> ดำเนินการเสร็จแล้ว<br>
                                <br>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">ประเมินความพึงพอใจของโครงการ</label>
                                <br>
                                <input type="radio" name="edit_project_satisfaction" value="5" disabled> ดีมาก<br>
                                <input type="radio" name="edit_project_satisfaction" value="4" disabled> ดี<br>
                                <input type="radio" name="edit_project_satisfaction" value="3" disabled> ปานกลาง<br>
                                <input type="radio" name="edit_project_satisfaction" value="2" disabled> น้อย<br>
                                <input type="radio" name="edit_project_satisfaction" value="1" disabled> น้อยที่สุด<br>
                                <br>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">หลักฐานการดำเนินงาน</label>
                                <br>
                                <div id="edit_project_evidence_gallery"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button id="editProjectSubmit" type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                </div>

                <!-- Jquery submit form -->
                <script>

                    $("input[name='edit_project_budgetType']").change(function(){
                        
                        var budgetType = $("input[name='edit_project_budgetType']:checked").val();
                        $("#edit_project_projectType").val(budgetType);

                        if (budgetType == "operating") {
                            $("label#edit_project_budgetTypeLabel").text('งบดำเนินการ');
                            $("#edit_project_strategy_budgetType").val($("#edit_project_operatingBudgetTemp").val());
                        } else {
                            $("label#edit_project_budgetTypeLabel").text('งบลงทุน');
                            $("#edit_project_strategy_budgetType").val($("#edit_project_investmentBudgetTemp").val());
                        }
                        
                    });

                    $('#editProjectSubmit').click(function() {
                        $('#editProjectForm').submit();
                    });
                </script>
            </div>
        </div>
    </div>
    <!-- END MODAL -->


    <script>
        function StrategyLookup(id) {
            $("#edit_strategy_id").text(id);

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {

                    if (this.responseText == "") {
                        // failed                      
                    } else {
                        // successed
                        var result = JSON.parse(this.responseText)
                        $("#edit_strategyName").val(result.strategyName);
                        $("#edit_projectNumber").val(result.projectNumber);
                        $("#edit_operatingBudget").val(result.operatingBudget);
                        $("#edit_investmentBudget").val(result.investmentBudget);
                        $("#edit_startDate").val(result.startDate);
                        $("#edit_finishDate").val(result.finishDate);
                    }
                }
            };
            xmlhttp.open("GET", "/projectx/lookup-strategy.php?id=" + id, true);
            xmlhttp.send();
        }
        
        function ConfirmDeleteStrategy(id) {
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
                                    window.location.href = '/projectx/default-route.php';
                                }, 2000);
                           } 
                        }
                    };
                    xmlhttp.open("POST", "/projectx/delete-strategy.php", true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlhttp.send("id=" + id);
                }
            })
        }

        function OpenAddProjectPopup(strategyId, strategyName, operatingBudget, investmentBudget) {

            AddResponList();

            $("#add_project_strategyName").val(strategyName);
            $("#add_project_strategyId").val(strategyId);
            $("#add_project_strategy_budget").val(Number(operatingBudget) + Number(investmentBudget));

            $("#operatingBudgetTemp").val(operatingBudget);
            $("#investmentBudgetTemp").val(investmentBudget);
            $("#add_project_strategy_budgetType").val($("#operatingBudgetTemp").val());
        }

        function SearchResponseForAddForm() {
            var q = $("#add_project_responId_query").val();

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == "") {
                        // failed                      
                    } else {
                        // successed
                        var result = JSON.parse(this.responseText)

                        $("#add_project_responId").val($("#add_project_responId_query").val());
                        $("#add_project_responName").val(result.responName);
                        $("#add_project_department").val(result.department);
                        $("#add_project_supervisor").val(result.supervisor);
                    }
                }
            };
            xmlhttp.open("GET", "/projectx/lookup-respon.php?id=" + q, true);
            xmlhttp.send();
        }

        function SearchResponseForEditForm() {
            var q = $("#edit_project_responId_query").val();

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == "") {
                        // failed                      
                    } else {
                        // successed
                        var result = JSON.parse(this.responseText)

                        $("#edit_project_responId").val($("#edit_project_responId_query").val());
                        $("#edit_project_responName").val(result.responName);
                        $("#edit_project_department").val(result.department);
                        $("#edit_project_supervisor").val(result.supervisor);
                    }
                }
            };
            xmlhttp.open("GET", "/projectx/lookup-respon.php?id=" + q, true);
            xmlhttp.send();
        }
        
        function ProjectLookup(id) {

            EditResponList();

            $("#edit_project_id").text(id);
            $("#edit_project_projectId").val(id);

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {

                    if (this.responseText == "") {
                        // failed                      
                    } else {
                        // successed
                        var result = JSON.parse(this.responseText)
                        $("#edit_project_strategyId").val(result.strategyId);
                        $("#edit_project_strategyName").val(result.strategyName);
                        $("#edit_project_strategy_budget").val(Number(result.operatingBudget) + Number(result.investmentBudget));
                        $("input[name='budgetType'][value='" + result.projectType + "']").prop('checked', true);
                        $("#edit_project_projectType").val(result.projectType);

                        $("#edit_project_operatingBudgetTemp").val(result.operatingBudget);
                        $("#edit_project_investmentBudgetTemp").val(result.investmentBudget);
                        
                        var budgetType = $("input[name='edit_project_budgetType']:checked").val();
                        if (budgetType == "operating") {
                            $("label#edit_project_budgetTypeLabel").text('งบดำเนินการ');
                            $("#edit_project_strategy_budgetType").val(result.operatingBudget);
                        } else {
                            $("label#edit_project_budgetTypeLabel").text('งบลงทุน');
                            $("#edit_project_strategy_budgetType").val(result.investmentBudget);
                        }

                        $("#edit_project_projectName").val(result.projectName);
                        $("#edit_project_responId_query").val(result.responId);
                        $("#edit_project_responId").val(result.responId);
                        $("#edit_project_responName").val(result.responName);
                        $("#edit_project_department").val(result.departmentName);
                        $("#edit_project_supervisor").val(result.supervisor);

                        $("#edit_project_projectStart").val(result.projectStart);
                        $("#edit_project_projectFinish").val(result.projectFinish);
                        $("#edit_project_workingDate").val(result.workingDate);
                        $("#edit_project_participant").val(result.participant);

                        // radio assign value
                        $("input[name='edit_project_statusProject'][value='" + result.statusProject + "']").prop('checked', true);
                        $("#edit_project_statusProject").val(result.statusProject );
                        $("input[name='edit_project_satisfaction'][value='" + result.satisfaction + "']").prop('checked', true);
                        $("#edit_project_satisfaction").val(result.satisfaction);

                        $("#edit_project_budget").val(result.budget);

                        // upload
                        for (var name of result.docFiles) {
                            $('#edit_project_doc_gallery').append("<a href='/projectx/upload/doc/" + result.projectId + "/" + name + "' target='_blank'>"+ name +"</a><br>");
                        }

                        for (var name of result.evidenceFiles) {
                            $('#edit_project_evidence_gallery').append("<a href='/projectx/upload/evidence/" + result.projectId + "/" + name + "' target='_blank'>"+ name +"</a><br>");
                        }
                    }
                }
            };
            xmlhttp.open("GET", "/projectx/lookup-project.php?id=" + id, true);
            xmlhttp.send();
        }

        function AddResponList() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var json = JSON.parse(this.responseText);
                    for (element of json) {
                        $('#add_project_respon_list').append($('<option>').val(element.responId).text(element.responName + " (" + element.department + ")"));
                    }
                }
            };
            xmlhttp.open("GET", "/projectx/respon-list.php", true);
            xmlhttp.send();
        }

        $('#add_project_respon_list').change(function() {
            $("#add_project_responId_query").val($('#add_project_respon_list').val());
            SearchResponseForAddForm();
        });

        function EditResponList() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var json = JSON.parse(this.responseText);
                    for (element of json) {
                        $('#edit_project_respon_list').append($('<option>').val(element.responId).text(element.responName + " (" + element.department + ")"));
                    }
                }
            };
            xmlhttp.open("GET", "/projectx/respon-list.php", true);
            xmlhttp.send();
        }

        $('#edit_project_respon_list').change(function() {
            $("#edit_project_responId_query").val($('#edit_project_respon_list').val());
            SearchResponseForEditForm();
        });

        function DeleteProject(id) {
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
                                    window.location.href = '/projectx/admin.php';
                                }, 2000);
                        } 
                        }
                    };
                    xmlhttp.open("POST", "/projectx/delete-project.php", true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlhttp.send("id=" + id);
                }
            })
        }

        
    </script>

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>

    <script src="./plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="./plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="./plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
</body>
</html>

<?php
    $conn->close();
?>