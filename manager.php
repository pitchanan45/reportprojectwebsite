<?php

    require 'includes/connection.php';
    require 'includes/allow-manager.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>รายงานสรุปผล</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
    
    <link href="css/style.css" rel="stylesheet">
    <script>
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (!this.responseText) {
                    window.location.href = '/projectx/default-route.php';
                }
            }
        };
        xmlhttp.open("GET", "/projectx/check.php?support=manager", true);
        xmlhttp.send();
    </script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />

    <style>
        .fc-event, .fc-event:hover {
            color: #fff !important
        }

        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
        }
        
        tr:nth-child(even) {
          background-color: #dddddd;
        }
    </style>
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


        <!--**********************************
            Nav header start
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
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">    
            <div class="header-content clearfix">
                
                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-left">
                    <!-- <div class="input-group icons">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                        </div>
                        <input type="search" class="form-control" placeholder="Search Dashboard" aria-label="Search Dashboard">
                        <div class="drop-down   d-md-none">
							<form action="#">
								<input type="text" class="form-control" placeholder="Search">
							</form>
                        </div>
                    </div> -->
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
                                        <li><a href="/projectx/logout.php"><i class="icon-key"></i> <span>Logout</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li>
                        <a href="#" aria-expanded="false" onclick="workspace(event, 'calendar');">
                            <i class='far fa-calendar-check' style='font-size:24px'></i><span class="nav-text">Calendar</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" aria-expanded="false" onclick="workspace(event, 'report')">
                            <i class='far fa-copy' style='font-size:24px'></i><span class="nav-text">Report</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <!-- <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                    </ol>
                </div>
            </div> -->
            <!-- row -->
            
            <div class="container-fluid">
                <div id="calendar" class="tabcontent">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Calendar</h4>
                                    <div style="padding: 10px 10px">
                                        <iframe id="calendarIframe" src="/projectx/calendar-view.html" style="width: 100%; height: 900px;"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="report" class="tabcontent">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Chart</h4>
                                    <canvas id="myChart" width="200" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Export</h4>
                                    <form method="POST">
                                        <label class="control-label">ปีงบประมาณ</label>
                                        <div class="form-group">
                                            <select class="form-control form-control-lg" id="budgetYear" name="budgetYear">
                                                <!-- <option value="" disabled selected hidden>เลือกหน่วยงาน</option> -->
                                                <?php

                                                $sql = "SELECT id, year FROM budget_year";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    while($row = $result->fetch_assoc()) {
                                                        echo "<option value='".$row["year"]."'>".$row["year"]."</option>";
                                                    }
                                                }

                                                ?>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control form-control-lg" id="quarter" name="quarter">
                                                <option value="0">ทุกไตรมาส</option>
                                                <option value="1">ไตรมาส 1</option>
                                                <option value="2">ไตรมาส 2</option>
                                                <option value="3">ไตรมาส 3</option>
                                                <option value="4">ไตรมาส 4</option>
                                            </select>
                                        </div>
                                        <button type="submit" id="report-query-btn" class="btn btn-primary">ค้นหา</button>
                                    </form>

                                    <?php
                                        $isReportQuery = true;

                                        if (isset($_POST['budgetYear'])) {
                                            $budgetYear = $_POST['budgetYear'];
                                        } else {
                                            $isReportQuery = false;
                                        }

                                        if (isset($_POST['quarter'])) {
                                            $quarter = $_POST['quarter'];
                                        } else {
                                            $isReportQuery = false;
                                        }

                                        if ($isReportQuery) {
                                            require 'excel.php';
                                        }
                                    ?>

                                    <br><br>
                                    แผนปฏิบัติการโครงการตามยุทธศาสตร์ คณะวิทยาการจัดการ
                                    <style>
                                        th {
                                            background-color: #f0f0f0
                                        }
                                    </style>
                                    <table id="rpt-1-table">
                                        <tr>
                                            <th colspan="13" class="text-center">แผนปฏิบัติการโครงการตามยุทธศาสตร์ คณะวิทยาการจัดการ <?php if (isset($budgetYear)) echo "ประจำปีงบประมาณ พ.ศ. ".$budgetYear; ?> <?php if (isset($quarter) && $quarter != 0) echo " ไตรมาสที่ ".$quarter; ?></th>
                                        </tr>
                                        <tr>
                                            <th rowspan="2" class="text-center">ยุทธศาสตร์/โครงการ</th>
                                            <th rowspan="2" class="text-center">หน่วยงานที่รับผิดชอบ</th>
                                            <th colspan="2" class="text-center">ช่วงเวลาดำเนินการ</th>
                                            <th colspan="2" class="text-center">งบประมาณ</th>
                                            <th rowspan="2" class="text-center">สถานะการดำเนินการ</th>
                                            <th colspan="2" class="text-center">ผลการจัดโครงการ</th>
                                            <th rowspan="2" class="text-center">หมายเหตุ</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">แผน</th>
                                            <th class="text-center">ดำเนินการจริง</th>
                                            <th class="text-center">จัดสรร</th>
                                            <th class="text-center">จ่ายจริง</th>
                                            <th class="text-center">จำนวนผู้เข้าร่วม</th>
                                            <th class="text-center">ความพึงพอใจในภาพรวม</th>
                                        </tr>
                                        <?php
                                            function group_by($key, $data) {
                                                $result = array();
                                            
                                                foreach($data as $val) {
                                                    if(array_key_exists($key, $val)){
                                                        $result[$val[$key]][] = $val;
                                                    }else{
                                                        $result[""][] = $val;
                                                    }
                                                }
                                            
                                                return $result;
                                            }
                                        ?>
                                        <?php
                                            if ($isReportQuery) {

                                                $strategyIndex = 0;
                                                foreach ($phpObj as $strategyObj) {

                                                    $strategyIndex++;

                                                    echo '<tr style="background-color: #fafafa">
                                                        <td>ยุทธศาสตร์ที่ '.$strategyIndex.' '.$strategyObj["strategyName"].'</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>';

                                                    $projectGroupByType = group_by("projectType", $strategyObj["projects"]);
                                                    
                                                    if (isset($projectGroupByType)) {

                                                        $projectIndex = 0;
                                                        foreach ($projectGroupByType as $key => $value) {
                                                            $projectType = "ไม่ระบุประเภทงบประมาณ";
                                                            if ($key == "operating") {
                                                                $projectType = "งบดำเนินงาน";
                                                            } else if ($key == "investment") {
                                                                $projectType = "งบลงทุน";
                                                            }

                                                            echo '<tr style="background-color: #e69797">
                                                                    <td>'. $projectType .'</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>';
                                                            
                                                            foreach ($value as $project) {
                                                                $projectIndex++;

                                                                echo '<tr>
                                                                    <td>'.$strategyIndex.'.'.$projectIndex.' '.$project["projectName"].'</td>
                                                                    <td>'.$project["departmentName"].'</td>
                                                                    <td>'.date("d/m/Y", strtotime($project["projectStart"])).' - '.date("d/m/Y", strtotime($project["projectFinish"])).'</td>
                                                                    <td>'.date("d/m/Y", strtotime($project["workingDate"])).'</td>
                                                                    <td>'.$project["budget"].'</td>
                                                                    <td>'.$project["paid"].'</td>
                                                                    <td>'.$project["statusProject"].'</td>
                                                                    <td>'.$project["participant"].'</td>
                                                                    <td>'.$project["satisfaction"].'</td>
                                                                    <td></td>
                                                                </tr>';
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        ?>
                                    </table>
                                    <br>
                                    <button id="export-rpt-1" class="btn btn-primary">Export</button>
                                    <br><br>
                                    รายงานการใช้จ่ายงบประมาณรายจ่ายที่สอดคล้องกับยุทธศาสตร์ของคณะวิทยาการจัดการ
                                    <table id="rpt-2-table">
                                        <tr>
                                            <th colspan="4" class="text-center">รายงานการใช้จ่ายงบประมาณรายจ่ายที่สอดคล้องกับยุทธศาสตร์ของคณะ</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-center">คณะวิทยาการจัดการ มหาวิทยาลัยสงขลานครินทร์</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-center">แหล่งเงินตัดจ่าย เงินรายได้คณะ</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-center"><?php if (isset($budgetYear)) echo "ประจำงบประมาณ พ.ศ. ".$budgetYear; ?> <?php if (isset($quarter) && $quarter != 0) echo "ไตรมาสที่ ".$quarter; ?></th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-center">
                                                <?php
                                                    if (isset($quarter)) {
                                                        if ($quarter == 1) {
                                                            echo "ระหว่างวันที่ 1 ตุลาคม ".($budgetYear - 1)." ถึง วันที่ 31 ธันวาคม ".($budgetYear - 1);
                                                        } else if ($quarter == 2) {
                                                            echo "ระหว่างวันที่ 1 มกราคม ".$budgetYear." ถึง วันที่ 31 มีนาคม ".$budgetYear;
                                                        } else if ($quarter == 3) {
                                                            echo "ระหว่างวันที่ 1 เมษายน ".$budgetYear." ถึง วันที่ 30 มิถุนายน ".$budgetYear;
                                                        } else if ($quarter == 4) {
                                                            echo "ระหว่างวันที่ 1 กรกฎาคม ".$budgetYear." ถึง วันที่ 30 กันยายน ".$budgetYear;
                                                        } else {
                                                            echo "ระหว่างวันที่ 1 ตุลาคม ".($budgetYear - 1)." ถึง วันที่ 30 ธันวาคม ".$budgetYear;
                                                        }
                                                    }
                                                ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th rowspan="2" class="text-center">ยุทธศาสตร์ของคณะ / โครงการ</th>
                                            <th colspan="3" class="text-center">ผลการดำเนินงาน (ตั้งค้างจ่าย)</th>
                                        </tr>
                                        <tr>
                                            <th>แผน</th>
                                            <th>ผล</th>
                                            <th>คงเหลือ</th>
                                        </tr>
                                        <?php
                                            if ($isReportQuery) {

                                                $sumAllBudget = 0;
                                                $sumAllPaid = 0;
                                                foreach ($phpObj as $strategyObj) {    
                                                    foreach ($strategyObj["projects"] as $project) {
                                                        $sumAllBudget += $project["budget"];
                                                        $sumAllPaid += $project["paid"];
                                                    }
                                                }
                                            }
                                        ?>
                                        <tr>
                                            <th class="text-center">รวมทั้งสิ้น</th>
                                            <th><?php echo $sumAllBudget; ?></th>
                                            <th><?php echo $sumAllPaid; ?></th>
                                            <th><?php echo ($sumAllBudget-$sumAllPaid); ?></th>
                                        </tr>

                                        <?php
                                            if ($isReportQuery) {

                                                $strategyIndex = 0;
                                                $projectIndex = 0;
                                                foreach ($phpObj as $strategyObj) {

                                                    $strategyIndex++;
                                                    
                                                    $sumBudget = 0;
                                                    $sumPaid = 0;
                                                    foreach ($strategyObj["projects"] as $project) {
                                                        $sumBudget += $project["budget"];
                                                        $sumPaid += $project["paid"];
                                                    }

                                                    echo '<tr>
                                                        <td>ยุทธศาสตร์ที่ '.$strategyIndex.' '.$strategyObj["strategyName"].'</td>
                                                        <td>'.$sumBudget.'</td>
                                                        <td>'.$sumPaid.'</td>
                                                        <td>'.($sumBudget-$sumPaid).'</td>
                                                    </tr>';

                                                    foreach ($strategyObj["projects"] as $project) {
                                                        $projectIndex++;
                                                        echo '<tr>
                                                            <td>'.$projectIndex.'. '.$project["projectName"].'</td>
                                                            <td>'.$project["budget"].'</td>
                                                            <td>'.$project["paid"].'</td>
                                                            <td>'.($project["budget"]-$project["paid"]).'</td>
                                                        </tr>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </table>
                                    <br>
                                    <button id="export-rpt-2" class="btn btn-primary">Export</button>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Line Chart -->
                        <div class="col-lg-12">
                            <!-- <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Line chart</h4>
                                    <canvas id="lineChart" width="500" height="250"></canvas>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>       
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        
        
        
           
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <div class="modal fade none-border" id="chart_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Table #<span id="chart_project_status_index"></span></strong></h4>
                </div>
                <div class="modal-body">
                    <table id="projectByStatusList">
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อโครงการ</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>

    <script src="./plugins/chart.js/Chart.bundle.min.js"></script>
    <script src="./js/plugins-init/chartjs-init.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

    <script src="js/jquery.table2excel.min.js"></script>

    <script>
        
        init();

        function init() {
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 1; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
        }

        function workspace(evt, area) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            document.getElementById(area).style.display = "block";
        }
    </script>

    <script>
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == "") {
                    // failed                      
                } else {
                    // successed
                    var result = JSON.parse(this.responseText)

                    var ctx = document.getElementById('myChart');
                    var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['ยังไม่ดำเนินการ', 'อยู่ระหว่างดำเนินการ', 'ดำเนินการเสร็จแล้ว'],
                            datasets: [{
                                label: '# of Votes',
                                data: [result["startedyet"].length, result["process"].length, result["success"].length],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(0, 255, 0, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(0, 255, 0, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            events: ['click'],
                            onClick: function (_, event) {
                                if (event.length) {
                                    var statusIndex = event[0]['_index'];
                                
                                    var statusProject = '';
                                    if (statusIndex == 0) {
                                        statusProject = 'ยังไม่ดำเนินการ';
                                    } else if (statusIndex == 1) {
                                        statusProject = 'อยู่ระหว่างดำเนินการ';
                                    } else if (statusIndex == 2) {
                                        statusProject = 'ดำเนินการเสร็จแล้ว';
                                    }

                                    $('#chart_project_status_index').text(statusProject);

                                    var xmlhttp = new XMLHttpRequest();
                                    xmlhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            if (this.responseText == "") {
                                                var rows = '<tr><th>ลำดับ</th><th>ชื่อโครงการ</th></tr>';
                                                document.getElementById('projectByStatusList').innerHTML = rows;
                                                // failed                      
                                            } else {
                                                // successed
                                                var result = JSON.parse(this.responseText)

                                                var rows = '<tr><th>ลำดับ</th><th>ชื่อโครงการ</th></tr>';
                                                for (var project of result) {
                                                    rows += '<tr><td>' + project.projectId + '</td><td>' + project.projectName + '</td></tr>';
                                                }
                                                document.getElementById('projectByStatusList').innerHTML = rows;
                                            }

                                            $('#chart_modal').modal('show');
                                        }
                                    };
                                    xmlhttp.open("GET", "/projectx/chart-project-status.php?statusProject=" + statusProject, true);
                                    xmlhttp.send();
                                }
                            }
                        }
                    });
                }
            }
        };
        xmlhttp.open("GET", "/projectx/chart.php", true);
        xmlhttp.send();
    </script>

    <script>
        function reloadCalendar() {
            var iframe = document.getElementById('calendarIframe');
            iframe.src = iframe.src;
        }

        <?php
            if ($isReportQuery) {
                echo "$('#budgetYear').val('$budgetYear');";
                echo "$('#quarter').val('$quarter');";
                echo "workspace(null, 'report');";
                echo "reloadCalendar();";
            }
        ?>
    </script>

    <script>
        $("#export-rpt-1").click(function(){
            $("#rpt-1-table").table2excel({
                name: "แผนปฏิบัติการโครงการตามยุทธศาสตร์ คณะวิทยาการจัดการ",
                filename: "แผนปฏิบัติการโครงการตามยุทธศาสตร์ คณะวิทยาการจัดการ",
                fileext: ".xls"
            }); 
        });

        $("#export-rpt-2").click(function(){
            $("#rpt-2-table").table2excel({
                name: "รายงานการใช้จ่ายงบประมาณรายจ่ายที่สอดคล้องกับยุทธศาสตร์ของคณะวิทยาการจัดการ",
                filename: "รายงานการใช้จ่ายงบประมาณรายจ่ายที่สอดคล้องกับยุทธศาสตร์ของคณะวิทยาการจัดการ",
                fileext: ".xls"
            }); 
        });
    </script>
</body>

</html>

<?php
    $conn->close();
?>