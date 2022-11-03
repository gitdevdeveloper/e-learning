<?php
include('../../config/conn.php');
session_start();


$_SESSION['status'] = $_SESSION['status'] == "teacher";


if (empty($_SESSION['status'])) {
    $_SESSION['error'] = "คุณไม่ได้รับสิทธิ์ให้เข้าใช้งานหน้านี้";
    header('Location: ../../index');
    exit();
}

// data_loginuser
$stmt = $conn->query("SELECT * FROM db_user WHERE username='$_SESSION[username]'");
$stmt->execute();
$data = $stmt->fetch();


// db_message
$sql2 = "SELECT count(*) FROM db_message where m_status='notread' ";
$result2 = $conn->prepare($sql2);
$result2->execute();
$message = $result2->fetchColumn();






?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>แผงควบคุม</title>
    <link rel="shortcut icon" href="../../images/favicon.ico" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <!-- google font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pormpt">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/59b81ffa56.js" crossorigin="anonymous"></script>
    <!-- summernote -->
    <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
    <!-- sweetalert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>




</head>

<style>
    body {
        font-family: 'Kanit';
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">


                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">
                        <a href="#" class="nav-link" data-toggle="modal" data-target="#exampleModal"><i class="fa-solid fa-user-plus"></i></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" onclick="logout()" href="#">
                            <i class="fa-solid fa-power-off" style="color: red;"></i>
                        </a>
                    </li>

                </ul>




            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="../index" class="brand-link">
                <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">E-learning science</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../dist/img/avatar.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="./account" class="d-block"><?= $data['username']; ?></a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="../index" class="nav-link ">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    หน้าแรก
                                </p>
                            </a>

                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-file-pen"></i>
                                <p>
                                    จัดการบทเรียน
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./main-lesson" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>บทเรียนหลัก</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="./sub-lesson" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>บทเรียนย่อย</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-file-pen"></i>
                                <p>
                                    จัดการแบบทดสอบ
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./pre-test" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>แบบทดสอบก่อนเรียน</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="./post-test" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>แบบทดสอบหลังเรียน</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="./user" class="nav-link ">
                                <i class="nav-icon fa-solid fa-users"></i>
                                <p>
                                    จัดการข้อมูลผู้ใช้
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="./score" class="nav-link active">
                                <i class="nav-icon fa-solid fa-chart-column"></i>
                                <p>
                                    ตรวจสอบคะแนน
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="./message" class="nav-link">
                                <i class="nav-icon fa-solid fa-message"></i>
                                <p>
                                    ถามตอบ Q&A
                                </p>
                                <span class="right badge badge-danger"><?= $message; ?></span>

                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" onclick="logout()" class="nav-link  btn-danger">
                                <i class="nav-icon fa-solid fa-right-from-bracket" style="color: #fff;"></i>
                                <p style="color: #fff;">
                                    ออกจากระบบ
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu  -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">ตรวจสอบคะแนน</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">ตรวจสอบคะแนน</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <h5 class="card-header"><i class="fa-solid fa-chart-column"></i> ตรวจสอบคะแนน</h5>
                        <div class="card-body">

                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" style="text-align:center ;">#</th>
                                        <th scope="col">ชื่อ - นามสกุล</th>
                                        <th scope="col">ชื่อผู้ใช้</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $conn->query("SELECT * FROM db_user where status = 'student' ");
                                    $stmt->execute();
                                    $db_user = $stmt->fetchAll();
                                    $count = 0;
                                    if (!$db_user) {
                                    } else {
                                        foreach ($db_user as $alldata) {
                                            $count++;
                                    ?>
                                            <tr>
                                                <td style="width: 5%;text-align:center ;"><?= $count; ?></td>
                                                <td><?= $alldata['prefix'] . " " . $alldata['f_name'] . " " . $alldata['l_name']; ?></td>
                                                <td style="width: 10%;"><?= $alldata['username']; ?></td>
                                                <td style="text-align:center ;width: 5%;">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?= $alldata['user_id']; ?>">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModal<?= $alldata['user_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">ตารางคะแนนของ : <?= $alldata['prefix'] . " " . $alldata['f_name'] . " " . $alldata['l_name']; ?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body" style="text-align: left;">
                                                                    <h4>คะแนนก่อนเรียน</h4>
                                                                    <table class="table table-bordered table-hover" id="example1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">บทเรียน</th>
                                                                                <th scope="col">เวลา</th>
                                                                                <th scope="col">คะเเนน</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $stmt = $conn->query("SELECT * FROM score_pretest INNER JOIN db_main_lesson ON score_pretest.s_main_id = db_main_lesson.main_id
                                                                                WHERE score_pretest.user_id = '$alldata[user_id]' ORDER BY db_main_lesson.main_id   DESC  ");
                                                                            $stmt->execute();
                                                                            $score_pretest = $stmt->fetchAll();
                                                                            $num = 0;
                                                                            if (!$score_pretest) {
                                                                            } else {
                                                                                foreach ($score_pretest as $score) {
                                                                                    $num++;
                                                                            ?>
                                                                                    <tr>
                                                                                        <td style="width:5%;"><?= $num; ?></td>
                                                                                        <td><?= $score['name']; ?></td>
                                                                                        <td><?= $score['date_time']; ?></td>
                                                                                        <td><?= $score['score']; ?></td>

                                                                                    </tr>

                                                                            <?php
                                                                                }
                                                                            }
                                                                            ?>


                                                                        </tbody>
                                                                    </table>
                                                                    <h4>คะแนนหลังเรียน</h4>
                                                                    <table class="table table-bordered table-hover" id="example1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">บทเรียน</th>
                                                                                <th scope="col">เวลา</th>
                                                                                <th scope="col">คะเเนน</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $stmt = $conn->query("SELECT * FROM score_posttest INNER JOIN db_main_lesson ON score_posttest.s_main_id = db_main_lesson.main_id
                                                                                                    WHERE score_posttest.user_id = '$alldata[user_id]' ORDER BY db_main_lesson.main_id   DESC  ");
                                                                            $stmt->execute();
                                                                            $score_posttest = $stmt->fetchAll();
                                                                            $num = 0;
                                                                            if (!$score_posttest) {
                                                                            } else {
                                                                                foreach ($score_posttest as $score) {
                                                                                    $num++;
                                                                            ?>
                                                                                    <tr>
                                                                                        <td style="width:5%;"><?= $num; ?></td>
                                                                                        <td><?= $score['name']; ?></td>
                                                                                        <td><?= $score['date_time']; ?></td>
                                                                                        <td><?= $score['score']; ?></td>

                                                                                    </tr>

                                                                            <?php
                                                                                }
                                                                            }
                                                                            ?>


                                                                        </tbody>
                                                                    </table>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>


                                </tbody>
                            </table>

                        </div>

                    </div>

                    <!-- chart -->

                    <div class="card">
                        <h5 class="card-header"><i class="fa-solid fa-chart-simple"></i> กราฟเเสดงคะแนนแบบทดสอบก่อนเรียน</h5>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="bar-chart1" width="800px" height="300px"></canvas>
                            </div>
                        </div>

                    </div>

                    <div class="card">
                        <h5 class="card-header"><i class="fa-solid fa-chart-simple"></i> กราฟเเสดงคะแนนแบบทดสอบหลังเรียน</h5>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="bar-chart2" width="800px" height="300px"></canvas>
                            </div>
                        </div>

                    </div>



                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <!-- <script src="../plugins/chart.js/Chart.min.js"></script> -->
    <!-- Sparkline -->
    <script src="../plugins/sparklines/sparkline.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../plugins/jszip/jszip.min.js"></script>
    <script src="../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>



    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="../plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.js"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../dist/js/pages/dashboard.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php

    $stmt = $conn->query("SELECT * FROM score_pretest  INNER JOIN  db_user ON score_pretest.user_id =  db_user.user_id ORDER BY score_pretest.score DESC ");
    $stmt->execute();
    $score_pretest = $stmt->fetchAll();
    if (!$score_pretest) {
    } else {
        foreach ($score_pretest as $score_pre) {
            $name_student[] = "\"" . $score_pre['f_name'] . "\"";
            $score_student[] = "\"" . $score_pre['score'] . "\"";
        }
        $name_student = implode(",", $name_student);
        $score_student = implode(",", $score_student);
    }
    ?>
    <script>
        // Bar chart
        new Chart(document.getElementById("bar-chart1"), {
            type: 'bar',
            data: {
                labels: [<?php echo $name_student; ?>],
                datasets: [{
                    label: "คะแนนสูง",
                    // backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    data: [<?php echo $score_student; ?>]
                }]
            },
            options: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: ''
                }
            }
        });
    </script>


    <!-- chart -->

    <?php

    $stmt = $conn->query("SELECT * FROM score_posttest  INNER JOIN  db_user ON score_posttest.user_id =  db_user.user_id ORDER BY score_posttest.score DESC ");
    $stmt->execute();
    $score_posttest = $stmt->fetchAll();
    if (!$score_posttest) {
    } else {
        foreach ($score_posttest as $score_post) {
            $name_student2[] = "\"" . $score_post['f_name'] . "\"";
            $score_student2[] = "\"" . $score_post['score'] . "\"";
        }
        $name_student2 = implode(",", $name_student2);
        $score_student2 = implode(",", $score_student2);
    }
    ?>
    <script>
        // Bar chart
        new Chart(document.getElementById("bar-chart2"), {
            type: 'bar',
            data: {
                labels: [<?php echo $name_student2; ?>],
                datasets: [{
                    label: "คะแนนสูง",
                    // backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    data: [<?php echo $score_student2; ?>]
                }]
            },
            options: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: ''
                }
            }
        });
    </script>





    <script>
        // Summernote
        $('#summernote').summernote({
            height: 300
        })
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });
    </script>
    <script>
        function logout() {

            Swal.fire({
                title: 'คุณแน่ใจไหม?',
                text: "คุณต้องการที่จะออกจากระบบ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                showLoaderOnConfirm: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = ('../../logout')
                }
            })
        }
    </script>

    <!-- Modal add user -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-plus"></i> เพิ่มนักเรียน
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="./check_add_student" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col" style="max-width:150px ;">
                                    <label for=" " class="form-label">คำนำหน้า</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="prefix" required>
                                        <option value="">-- เลือก --</option>
                                        <option value="เด็กชาย">เด็กชาย</option>
                                        <option value="เด็กหญิง">เด็กหญิง</option>
                                    </select>

                                </div>
                                <div class="col" style="max-width:410px ;">
                                    <label for=" " class="form-label">ชื่อ</label>
                                    <input type="text" class="form-control" placeholder="First name" required name="f_name" aria-label="First name">
                                </div>
                                <div class="col">
                                    <label for=" " class="form-label">นามสกุล</label>
                                    <input type="text" class="form-control" placeholder="Last name" required name="l_name" aria-label="Last name">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col">
                                    <label for=" " class="form-label">เพศ</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="gender" required>
                                        <option value="">-- เลือก --</option>
                                        <option value="ชาย">ชาย</option>
                                        <option value="หญิง">หญิง</option>
                                        <option value="ไม่ต้องการตอบ">ไม่ต้องการตอบ</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for=" " class="form-label">วันเกิด</label>
                                    <input type="date" class="form-control" placeholder="Birthday" required name="birthday" aria-label="birthday">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">

                                <div class="col">
                                    <label for=" " class="form-label">ชื่อผู้ใช้</label>
                                    <input type="text" class="form-control" placeholder="Username" required name="username" aria-label="Username">
                                </div>
                                <div class="col">
                                    <label for=" " class="form-label">รหัสผ่าน</label>
                                    <input type="password" class="form-control" placeholder="Password" required name="password" aria-label="Password">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i>
                            เพิ่ม</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>