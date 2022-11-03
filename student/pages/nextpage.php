<?php
include('../../config/conn.php');
session_start();

$_SESSION['status'] = $_SESSION['status'] == "student";

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
$sql = "SELECT count(*) FROM db_message where m_status='read' ";
$result = $conn->prepare($sql);
$result->execute();
$message = $result->fetchColumn();

if (isset($_GET['id'])) {
    $main_id = $_GET['id'];
    $stmt = $conn->query("SELECT * FROM db_main_lesson INNER JOIN  db_sub_lesson ON  db_main_lesson.main_id = db_sub_lesson.main_id  WHERE db_main_lesson.main_id = '$main_id'");
    $stmt->execute();
    $dataclass = $stmt->fetch();

    if ($dataclass['main_id'] == "") {
        $_SESSION['error'] = "เนื้อหาไม่พร้อมใช้งาน";
        header('Location: learning');
        exit();
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ห้องเรียน</title>
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
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/59b81ffa56.js" crossorigin="anonymous"></script>
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <!-- sweetalert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<style>
    body {
        font-family: 'Kanit';
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- alert -->
    <?php if (isset($_SESSION['success'])) { ?>
        <script>
            Swal.fire(
                '',
                '<?= $_SESSION['success']; ?>',
                'success'
            )
        </script>
        <?php
        unset($_SESSION['success']);
        ?>
    <?php } ?>

    <?php if (isset($_SESSION['error'])) { ?>
        <script>
            Swal.fire(
                '',
                '<?= $_SESSION['error']; ?>',
                'error'
            )
        </script>
        <?php
        unset($_SESSION['error']);
        ?>
    <?php } ?>
    <!-- alert -->
    <?php if (isset($_SESSION['login'])) { ?>
        <script>
            Swal.fire(
                '<?= $_SESSION['login']; ?>',
                '<?= $data['f_name'] . " " . $data['l_name']; ?>',
                'success'
            )
        </script>
        <?php
        unset($_SESSION['login']);
        ?>
    <?php } ?>
    <?php
    ini_set('display_errors', 1);
    error_reporting(~0);

    $strKeyword = null;

    if (isset($_POST["txtKeyword"])) {
        $strKeyword = $_POST["txtKeyword"];
    }
    ?>
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

                <li class="nav-item">
                    <a class="nav-link" onclick="logout()" href="#">
                        <i class="fa-solid fa-power-off" style="color: red;"></i>
                    </a>
                </li>

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
                        <a href="./account" class="d-block"><?= $data['f_name'] . " " . $data['l_name']; ?></a>
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

                        <li class="nav-item">
                            <a href="../index" class="nav-link ">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    หน้าแรก
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="./learning" class="nav-link active">
                                <i class="nav-icon fa-solid fa-book-open"></i>
                                <p>
                                    บทเรียน
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="./mindmap" class="nav-link ">
                                <i class="nav-icon fa-solid fa-diagram-project"></i>
                                <p>
                                    แผนผังสรุป
                                </p>
                            </a>
                        </li>

                        <!-- <li class="nav-item menu-open">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-file-pen"></i>
                                <p>
                                    แบบทดสอบ
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
                        </li> -->

                        <li class="nav-item">
                            <a href="./score" class="nav-link ">
                                <i class="nav-icon fa-solid fa-chart-column"></i>
                                <p>
                                    คะแนน
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
                <!-- /.sidebar-menu -->
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
                            <h1 class="m-0"><i class="fa-solid fa-book-open"></i> ห้องเรียน</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="learning">บทเรียน</a></li>
                                <li class="breadcrumb-item active">ห้องเรียน</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <?php
                        // Nextpage
                        $perpage = 1;
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }
                        $start = ($page - 1) * $perpage;

                        $sql = "SELECT count(*) FROM db_sub_lesson where main_id = $dataclass[main_id] ";
                        $result = $conn->prepare($sql);
                        $result->execute();
                        $total_record = $result->fetchColumn();
                        $total_page = ceil($total_record / $perpage);


                        $stmt = $conn->query("(SELECT * FROM db_sub_lesson WHERE  main_id = $dataclass[main_id]  limit {$start} , {$perpage})  ORDER BY id ASC ");
                        $stmt->execute();
                        $db_sub_lesson = $stmt->fetchAll();
                        if (!$db_sub_lesson) {
                        } else {
                            foreach ($db_sub_lesson as $sub_lesson) {
                        ?>
                                <style>
                                    .video {
                                        text-align: center;
                                        margin: 50px 0;
                                    }

                                    .video video {
                                        width: 50%;
                                        border-radius: 10px;
                                        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
                                    }
                                </style>


                                <h5 class="card-header"><?= $sub_lesson['sub_name']; ?></h5>
                                <div class="card-body">
                                    <div class="video">
                                        <video src="../../upload/video/<?= $sub_lesson['video']; ?>" controls></video>
                                    </div>

                                    <p>
                                        <?= $sub_lesson['sub_detail']; ?>
                                    </p>
                                </div>


                        <?php
                            }
                        }
                        ?>

                        <div class="modal-footer">
                            <div class="nextpage">
                                <div class="btn-group me-2" role="group" aria-label="First group">
                                    <a href="classroom?id=<?= $dataclass['main_id']; ?>" aria-label="Previous" class="btn btn-primary">
                                        <span aria-hidden="true"><i class="fa-solid fa-angles-left"></i></span>
                                    </a>
                                    <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                                        <a href="?id=<?= $dataclass['main_id']; ?>&page=<?php echo $i; ?>" class="btn btn-primary" aria-label="Second group"><?php echo $i; ?></a>
                                    <?php } ?>
                                    <!-- <a href="?id=<?= $dataclass['main_id']; ?>&page=<?php echo $total_page; ?>" class="btn btn-primary" aria-label="Next">
                                        <span aria-hidden="true"><i class="fa-solid fa-angles-right"></i></span>
                                    </a> -->
                                    <a href="post-test?id=<?=$dataclass['main_id']?>" class="btn btn-primary"><i class="fa-solid fa-angles-right"></i></a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="../plugins/chart.js/Chart.min.js"></script>
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


</body>

</html>