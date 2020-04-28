<?php

    require 'includes/connection.php';
    require 'includes/allow-respon.php';

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
    <title>ผู้รับผิดชอบโครงการ</title>

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
        xmlhttp.open("GET", "/projectx/check.php?support=respon", true);
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

            <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        
                        <?php

                        $sql = "SELECT  s.strategyId, 
                                        s.strategyName, 
                                        s.projectNumber, 
                                        s.operatingBudget, 
                                        s.investmentBudget 
                                FROM strategy as s
                                INNER JOIN project as p ON p.strategyId = s.strategyId
                                INNER JOIN person  ON person.responId = p.responId
                                WHERE 
                                    s.year = $budgetYear
                                    AND person.responUsername = '". $_SESSION['username']. "'";

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
                                                WHERE 
                                                    p.strategyId = ". $row['strategyId'] . "
                                                    AND person.responUsername = '". $_SESSION['username']. "'";

                                $subResult = $conn->query($sql);

                                echo '<div class="card-body">';
                                echo    '<h4>#'. $row["strategyId"] .' - '. $row["strategyName"] .'</h4>';
                                echo    '<div class="d-sm-flex justify-content-between mb-2"><h5 class="mb-sm-0"> <small class="text-muted ml-3"></small></h5>';
                                echo    '</div>';
                                echo    '<table class="table table-striped table-bordered zero-configuration">';
                                echo    '<div class="card-body"><h4>งบประมาณ  '. ((int)$row["operatingBudget"] + (int)$row["investmentBudget"]) .' บาท</h4><h4>จำนวนโครงการทั้งสิ้น '. $row["projectNumber"] .' โครงการ</h4>';
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
                                                echo '<td>
                                                    <a href="#" data-toggle="modal" data-target="#edit-project" onclick="ProjectLookup('. $subRow["projectId"] .')"><button type="button" class="btn btn-primary">Edit</button></a>
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
    
    <!-- Modal Edit Project -->
    <div class="modal fade none-border" id="edit-project">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Edit a project #<span id="edit_project_id"></span></strong></h4>
                </div>
                <div class="modal-body">
                    <form id="editProjectForm" method="POST" action="edit-project-respon.php" enctype='multipart/form-data'>
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
                                <label class="control-label">งบประมาณจัดสรร</label>
                                <input class="form-control form-white" placeholder="งบประมาณจัดสรร" type="number" name="budget" id="edit_project_budget" disabled>
                            </div>
                            <div class="col-md-12">
                                <br>
                                <input type="radio" name="edit_project_budgetType" value="operating" checked disabled> งบสำหรับดำเนินการ<br>
                                <input type="radio" name="edit_project_budgetType" value="investment" disabled> งบสำหรับลงทุน<br>
                                <br>
                            </div>
                            <input type="text" id="edit_project_operatingBudgetTemp" style="display: none;">
                            <input type="text" id="edit_project_investmentBudgetTemp" style="display: none;">
                            <div class="col-md-12">
                                <label class="control-label" id="edit_project_budgetTypeLabel">งบดำเนินการ</label>
                                <input class="form-control form-white" type="number" id="edit_project_strategy_budgetType" name="budget" disabled>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">ชื่อโครงการ</label>
                                <input class="form-control form-white" placeholder="ชื่อโครงการ" type="text" name="projectName" id="edit_project_projectName" disabled>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">งบประมาณที่ใช้ไป</label>
                                <input class="form-control form-white" placeholder="งบประมาณที่ใช้ไป" type="number" name="paid" id="edit_project_paid" >
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">รหัสผู้รับผิดชอบโครงการ</label>
                                <input class="form-control form-white" placeholder="รหัสผู้รับผิดชอบโครงการ" type="number" id="edit_project_responId_query" disabled>
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
                                <input class="form-control form-white" placeholder="วันที่ดำเนินการจริง" type="date" name="workingDate" id="edit_project_workingDate">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">จำนวนผู้เข้าร่วมโครงการ</label>
                                <input class="form-control form-white" placeholder="จำนวนผู้เข้าร่วมโครงการ" type="number" name="participant" id="edit_project_participant">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">รายละเอียดโครงการ</label>
                                <br>
                                <input name="upload_doc[]" type="file" multiple="multiple" />
                            </div>
                            <div class="col-md-12">
                                <div id="edit_project_doc_gallery"></div>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">สถานะของโครงการ</label>
                                <br>
                                <input type="radio" name="edit_project_statusProject" value="ยังไม่ดำเนินการ"> ยังไม่ดำเนินการ<br>
                                <input type="radio" name="edit_project_statusProject" value="อยู่ระหว่างดำเนินการ"> อยู่ระหว่างดำเนินการ<br>
                                <input type="radio" name="edit_project_statusProject" value="ดำเนินการเสร็จแล้ว"> ดำเนินการเสร็จแล้ว<br>
                                <br>
                            </div>
                            <input type="text" id="edit_project_statusProject" name="statusProject" style="display: none;">
                            <div class="col-md-12">
                                <label class="control-label">ประเมินความพึงพอใจของโครงการ</label>
                                <br>
                                <input type="radio" name="edit_project_satisfaction" value="5"> ดีมาก<br>
                                <input type="radio" name="edit_project_satisfaction" value="4"> ดี<br>
                                <input type="radio" name="edit_project_satisfaction" value="3"> ปานกลาง<br>
                                <input type="radio" name="edit_project_satisfaction" value="2"> น้อย<br>
                                <input type="radio" name="edit_project_satisfaction" value="1"> น้อยที่สุด<br>
                                <br>
                            </div>
                            <input type="text" id="edit_project_satisfaction" name="satisfaction" style="display: none;">
                            <div class="col-md-12">
                                <label class="control-label">หลักฐานการดำเนินงาน</label>
                                <br>
                                <input name="upload_evidence[]" type="file" multiple="multiple" />
                            </div>
                            <div class="col-md-12">
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

                    $("input[name='edit_project_statusProject']").change(function(){
                        var status = $("input[name='edit_project_statusProject']:checked").val();
                        $("#edit_project_statusProject").val(status);
                    });

                    $("input[name='edit_project_satisfaction']").change(function(){
                        var satisfaction = $("input[name='edit_project_satisfaction']:checked").val();
                        $("#edit_project_satisfaction").val(satisfaction);
                    });

                    $('#editProjectSubmit').click(function(){
                        $('#editProjectForm').submit();
                    });
                </script>
            </div>
        </div>
    </div>
    <!-- END MODAL -->


    <script>
        function ProjectLookup(id) {
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
                        $("#edit_project_paid").val(result.paid);
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