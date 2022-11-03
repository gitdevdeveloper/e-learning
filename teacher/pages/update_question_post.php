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

if (isset($_GET['question'])) {
    $question = $_GET['question'];
    $stmt = $conn->query("SELECT * FROM db_posttest INNER JOIN  db_posttest_choice ON  db_posttest.post_id = db_posttest_choice.post_id 
                                                            INNER JOIN db_main_lesson ON db_posttest.main_id = db_main_lesson.main_id
                                                            WHERE db_posttest.question = '$question'");
    $stmt->execute();
    $pertest = $stmt->fetch();

    if ($pertest['question'] == "") {
        $_SESSION['error'] = "เนื้อหาไม่พร้อมใช้งาน";
        header('Location: pre-test');
        exit();
    }
}


if (isset($_POST['update'])) {
    $post_id  = $_POST['post_id'];
    // $main_id  = $_POST['main_id'];
    $question  = $_POST['question'];
    $answer  = $_POST['answer'];
    // db_pretest_choice

    $choice_id  = $_POST['choice_id'];
    $choice1  = $_POST['choice1'];
    $choice2  = $_POST['choice2'];
    $choice3  = $_POST['choice3'];
    $choice4  = $_POST['choice4'];




    $sql = $conn->prepare("UPDATE db_posttest SET question = :question ,answer = :answer  WHERE post_id  = :post_id ");
    $sql->bindParam(":post_id", $post_id);
    // $sql->bindParam(":main_id", $main_id );
    $sql->bindParam(":question", $question);
    $sql->bindParam(":answer", $answer);
    $sql->execute();

    if ($sql) {

        $sql2 = $conn->prepare("UPDATE db_posttest_choice SET post_id = :post_id ,choice1 = :choice1 ,choice2 = :choice2 ,choice3 = :choice3 ,choice4 = :choice4   WHERE choice_id  = :choice_id ");
        $sql2->bindParam(":choice_id", $choice_id);
        $sql2->bindParam(":post_id", $post_id);
        $sql2->bindParam(":choice1", $choice1);
        $sql2->bindParam(":choice2", $choice2);
        $sql2->bindParam(":choice3", $choice3);
        $sql2->bindParam(":choice4", $choice4);
        $sql2->execute();

        $_SESSION['success'] = "อัพเดทข้อมูลเรียบร้อยเเล้ว";
        header("location: post-test");
    } else {
        $_SESSION['error'] = "อัพเดทข้อมูลไม่สำเร็จ";
        header("location: post-test");
    }
}







?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>แผงควบคุม</title>

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

                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fa-solid fa-file-pen"></i>
                                <p>
                                    จัดการแบบทดสอบ
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./pre-test" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>แบบทดสอบก่อนเรียน</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="./post-test" class="nav-link active">
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
                            <h1 class="m-0">แบบทดสอบหลังเรียน</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item "><a href="pre-test">แบบทดสอบหลังเรียน</a></li>
                                <li class="breadcrumb-item active">แก้ไขแบบทดสอบหลังเรียน</li>
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
                        <h5 class="card-header"><i class="fa-solid fa-pen-to-square"></i> แบบทดสอบหลังเรียน</h5>

                        <form action="" method="post">
                            <div class="card-body">
                                <input type="hidden" class="form-control" id="" name="post_id" value="<?= $pertest['post_id']; ?>">

                                <input type="hidden" class="form-control" id="" name="choice_id" value="<?= $pertest['choice_id']; ?>">

                                <div class="mb-3">
                                    <select class="form-control" id="exampleFormControlSelect1" name="main_id" required>
                                        <option value="<?= $pertest['question']; ?>">- <?= $pertest['name']; ?> -</option>
                                        <option value="">-------------------------------</option>
                                        <?php
                                        $stmt = $conn->query("SELECT * FROM db_main_lesson ");
                                        $stmt->execute();
                                        $db_main_lesson = $stmt->fetchAll();
                                        if (!$db_main_lesson) {
                                        } else {
                                            foreach ($db_main_lesson as $data_main) {
                                        ?>
                                                <option value="<?= $data_main['main_id']; ?>"><?= $data_main['name']; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="formGroupExampleInput" class="form-label">คำถาม</label>
                                    <input type="text" class="form-control" id="formGroupExampleInput" name="question" value="<?= $pertest['question']; ?>" required>
                                </div>
                                <div class="choice" style="margin-left:50px ;">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">ก</span>
                                        <input type="text" class="form-control" value="<?= $pertest['choice1']; ?>" name="choice1" required>
                                    </div>
                                </div>

                                <div class="choice" style="margin-left:50px ;">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">ข</span>
                                        <input type="text" class="form-control" name="choice2" value="<?= $pertest['choice2']; ?>" required>
                                    </div>
                                </div>

                                <div class="choice" style="margin-left:50px ;">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">ค</span>
                                        <input type="text" class="form-control" name="choice3" value="<?= $pertest['choice3']; ?>" required>
                                    </div>
                                </div>

                                <div class="choice" style="margin-left:50px ;">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">ง</span>
                                        <input type="text" class="form-control" name="choice4" value="<?= $pertest['choice4']; ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlSelect1">คำตอบ</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="answer" required>
                                        <option value="<?= $pertest['answer']; ?>">- <?= $pertest['answer']; ?> -</option>
                                        <option value="ก">ก</option>
                                        <option value="ข">ข</option>
                                        <option value="ค">ค</option>
                                        <option value="ง">ง</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="update" class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i> บันทึก</button>
                            </div>
                        </form>


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

    <!-- Modal add user -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-plus"></i> เพิ่มครูผู้สอน
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="./check_add_teacher" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col" style="max-width:150px ;">
                                    <label for=" " class="form-label">คำนำหน้า</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="prefix" required>
                                        <option value="">-- เลือก --</option>
                                        <option value="นาย">นาย</option>
                                        <option value="นาง">นาง</option>
                                        <option value="นางสาว">นางสาว</option>
                                    </select>

                                </div>
                                <div class="col">
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
    <!-- ----------------------------------------------- -->

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





    <!-- ----------------------------------------------- -->
</body>

</html>