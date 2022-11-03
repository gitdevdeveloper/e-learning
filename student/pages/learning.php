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





?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>บทเรียน</title>
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
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <style>
                        .box-card {
                            margin-top: 50px;
                        }

                        .box-card .d-flex {
                            float: right;
                        }

                        .grid-course {
                            display: grid;
                            grid-template-columns: repeat(3, 1fr);
                        }

                        .grid-course a {
                            margin: auto;
                        }

                        .grid-course a .card {
                            transition: 0.3s ease-in;
                            width: 90%;

                        }

                        .grid-course a .card:hover {
                            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
                            transition: 0.3s ease-in;
                            transform: scale(1.03);
                        }

                        .grid-course a .card-body {
                            margin: auto;
                        }

                        .grid-course a .card-body h5 {
                            font-size: 22px;
                        }

                        @media (max-width:900px) {
                            .box-card {
                                margin-top: 20px;
                            }

                            .box-card .d-flex {
                                float: right;
                            }

                            .grid-course {
                                display: grid;
                                grid-template-columns: repeat(2, 1fr);
                            }

                            .grid-course a {
                                margin: auto;
                            }

                            .grid-course a .card {
                                transition: 0.3s ease-in;
                                width: 100%;

                            }

                            .grid-course a .card:hover {
                                box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
                                transition: 0.3s ease-in;
                                transform: scale(1.03);
                            }

                            .grid-course a .card-body {
                                margin: auto;
                            }

                            .grid-course a .card-body h5 {
                                font-size: 22px;
                            }
                        }

                        @media (max-width:480px) {
                            .box-card {
                                margin-top: 20px;
                            }

                            .box-card .d-flex {
                                float: right;
                            }

                            .grid-course {
                                display: grid;
                                grid-template-columns: repeat(1, 1fr);
                            }

                            .grid-course a {
                                margin: auto;
                            }

                            .grid-course a .card {
                                transition: 0.3s ease-in;
                                width: 100%;

                            }

                            .grid-course a .card:hover {
                                box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
                                transition: 0.3s ease-in;
                                transform: scale(1.03);
                            }

                            .grid-course a .card-body {
                                margin: auto;
                            }

                            .grid-course a .card-body h5 {
                                font-size: 22px;
                            }
                        }
                    </style>

                    <div class="box-card">
                        <div class="card">
                            <div class="card-header">
                                <form class="d-flex" action="" name="frmSearch" method="get">
                                    <input class="form-control me-2" type="search" name="q" placeholder="Search" aria-label="Search">
                                    <button class="btn btn-outline-success" type="submit">Search</button>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="grid-course">

                                    <?php
                                    //ถ้ามีการส่ง $_GET['q'] 
                                    if (isset($_GET['q'])) {
                                        //ประกาศตัวแปรรับค่าจากฟอร์ม
                                        $q = "%{$_GET['q']}%";
                                        $stmt = $conn->prepare("SELECT * FROM db_main_lesson WHERE name LIKE ?");
                                        $stmt->execute([$q]);
                                        $result = $stmt->fetchAll(); //แสดงข้อมูลทั้งหมด
                                        //ถ้าเจอข้อมูลมากกว่า 0
                                        if ($stmt->rowCount() > 0) {
                                            foreach ($result as $allmain) {
                                    ?>
                                                <a href="./classroom?id=<?= $allmain['main_id']; ?>">
                                                    <div class="card">
                                                        <img src="../../upload/images/<?= $allmain['images']; ?>" class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="card-title"><?= $allmain['name']; ?></h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            <?php
                                            }
                                        } else {
                                            echo "ไม่พบข้อมูล";
                                        }
                                    } else {
                                        $stmt = $conn->query("SELECT * FROM db_main_lesson ");
                                        $stmt->execute();
                                        $db_main_lesson = $stmt->fetchAll();
                                        if (!$db_main_lesson) {
                                        } else {
                                            foreach ($db_main_lesson as $allmain) {
                                            ?>
                                                <a href="./classroom?id=<?= $allmain['main_id']; ?>">
                                                    <div class="card">
                                                        <img src="../../upload/images/<?= $allmain['images']; ?>" class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="card-title"><?= $allmain['name']; ?></h5>
                                                        </div>
                                                    </div>
                                                </a>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>


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