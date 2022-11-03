<?php
include('../../config/conn.php');
session_start();


$_SESSION['status'] = $_SESSION['status'] == "admin";


if (empty($_SESSION['status'])) {
    $_SESSION['error'] = "คุณไม่ได้รับสิทธิ์ให้เข้าใช้งานหน้านี้";
    header('Location: ../../index');
    exit();
}

// delete

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deletestmt = $conn->query("DELETE FROM db_main_lesson WHERE main_id = $delete_id");
    $deletestmt->execute();

    if ($deletestmt) {
        $delete_id = $_GET['delete'];
        $deletestmt = $conn->query("DELETE FROM db_sub_lesson WHERE main_id = $delete_id");
        $deletestmt->execute();

        echo "<script>alert('Data has been deleted successfully');</script>";
        header("refresh:3; url=main-lesson");
    }
}



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

    thead,
    tbody {
        text-align: center;
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
                        <a href="./account" class="d-block">Admin</a>
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

                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-file-pen"></i>
                                <p>
                                    จัดการบทเรียน
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./main-lesson" class="nav-link active">
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

                        <li class="nav-item ">
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
                            <h1 class="m-0">บทเรียนหลัก</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">บทเรียนหลัก</li>
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
                        <h5 class="card-header"><i class="fa-solid fa-file-pen"></i> บทเรียนหลัก
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModaladdmain">
                                <i class="fa-solid fa-plus"></i> เพิ่มบทเรียน
                            </button>
                        </h5>
                        <div class="card-body">

                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">รูปภาพปก</th>
                                        <th scope="col">ชื่อบทเรียน</th>
                                        <th scope="col">คำอธิบาย</th>
                                        <th scope="col">เสียงบรรยาย</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $conn->query("SELECT * FROM db_main_lesson ");
                                    $stmt->execute();
                                    $db_main_lesson = $stmt->fetchAll();

                                    $num = 0;
                                    $data_id = "";
                                    if (!$db_main_lesson) {
                                    } else {
                                        foreach ($db_main_lesson as $data_main) {
                                            $num++;
                                            $data_id = $data_main['main_id'];
                                    ?>
                                            <tr>
                                                <td><?= $num; ?></td>
                                                <td><?= $data_main['main_id']; ?></td>
                                                <td>
                                                    <img src="../../upload/images/<?= $data_main['images']; ?>" alt="" style="border-radius:5px ;" width="100">
                                                </td>
                                                <td><?= $data_main['name']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModaldetail<?= $num; ?>">
                                                        <i class="fa-solid fa-book"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <audio controls>
                                                        <source src="../../upload/audio/<?= $data_main['audio']; ?>">
                                                    </audio>
                                                </td>


                                                <td>
                                                    <a href="#" role="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModaledit<?= $data_main['main_id']; ?>"><i class="far fa-edit "></i></a>
                                                </td>

                                                <td>
                                                    <a data-id="<?php echo $data_main['main_id']; ?>" href="?delete=<?php echo $data_main['main_id']; ?>" class="delete-btn btn btn-danger"><i class="fas fa-trash-alt "></i></a>
                                                </td>


                                            </tr>


                                            <!-- Modal detail-->
                                            <div class="modal fade" id="exampleModaldetail<?= $num; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">คำอธิบายบทเรียนหลัก
                                                                #<?= $data_main['name']; ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?= $data_main['detail']; ?>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal edtit-->
                                            <div class="modal fade" id="exampleModaledit<?= $data_main['main_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">แก้ไข
                                                                | <?= $data_main['name']; ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <form action="update_main_lesson" method="post" enctype="multipart/form-data">
                                                            <div class="modal-body">

                                                                <div class="mb-3" style="display:none ;">
                                                                    <input class="form-control" type="text" value="<?= $data_main['main_id']; ?>" name="main_id">


                                                                    <input class="form-control" type="text" value="<?= $data_main['audio']; ?>" name="audio2">

                                                                    <input class="form-control" type="text" value="<?= $data_main['images']; ?>" name="img2">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="" class="form-label">ชื่อบท</label>
                                                                    <input class="form-control" type="text" placeholder="Name" value="<?= $data_main['name']; ?>" name="name" required aria-label="default input example">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlTextarea1">คำบรรยายบทเรียนหลัก</label>
                                                                    <textarea class="form-control" id="summernote<?= $num; ?>" rows="3" name="detail"><?= $data_main['detail']; ?></textarea>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="formFile" class="form-label">เสียงบรรยาย</label>
                                                                    <input class="form-control" type="file" id="" name="audio" accept="audio/*">
                                                                </div>


                                                                <div class="mb-3">
                                                                    <label for="formFile" class="form-label">เลือกภาพปก</label>
                                                                    <input class="form-control" type="file" id="imgInput2" name="images" accept="image/*">
                                                                    <img src="" id="previewImg2" style="border-radius: 5px; width:25%;" alt="">
                                                                </div>

                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="submit" name="update" class="btn btn-danger"><i class="fa-solid fa-pen-to-square"></i>
                                                                    บันทึก</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>

                                    <?php
                                        }
                                    }
                                    ?>


                                </tbody>
                            </table>


                        </div>

                    </div>
                    <!-- map -->
                    <div class="card">
                        <h5 class="card-header">แผนผัง
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModaladdmindmap">
                                <i class="fa-solid fa-plus"></i> เพิ่มแผนผัง
                            </button>

                        </h5>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">แผนผัง</th>
                                        <th scope="col">ชื่อบทเรียน</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $conn->query("SELECT * FROM db_mindmap INNER JOIN  db_main_lesson ON db_mindmap.main_id = db_main_lesson.main_id  ");
                                    $stmt->execute();
                                    $db_mindmap = $stmt->fetchAll();
                                    $num = 0;
                                    if (!$db_mindmap) {
                                    } else {
                                        foreach ($db_mindmap as $data_mindmap) {
                                            $num++;
                                    ?>

                                            <tr>
                                                <th style="width:5% ;"><?= $num; ?></th>
                                                <td style="width:10% ;"><img src="../../upload/mindmap/<?= $data_mindmap['mindmap']; ?>" alt="" width="250"></td>
                                                <td><?= $data_mindmap['name']; ?></td>

                                                <td style="width:5% ;">
                                                    <a href="#" role="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalmap<?= $num; ?>"><i class="far fa-edit "></i></a>
                                                    <!-- mindmap -->
                                                    <div class="modal fade" id="exampleModalmap<?= $num; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">แก้ไข Mindmap
                                                                        #<?= $data_mindmap['name']; ?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="check_update_mindmap" method="post" enctype="multipart/form-data">
                                                                    <div class="modal-body">
                                                                        <input class="form-control" type="hidden" value="<?= $data_mindmap['main_id']; ?>" name="main_id">
                                                                        <div class="mb-3 text-left">
                                                                            <label for="formFile" class="form-label">เลือกรูป</label>
                                                                            <input class="form-control" type="file" id="formFile" name="mindmap">
                                                                        </div>
                                                                        <div class="mb-3 text-left">
                                                                            <input type="hidden" type="text" name="img2" value="<?= $data_mindmap['mindmap']; ?>">
                                                                            <img src="../../upload/mindmap/<?= $data_mindmap['mindmap']; ?>" alt="" style="width: 35%;">
                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" name="update" class="btn btn-danger"><i class="fa-solid fa-pen-to-square"></i>
                                                                            บันทึก</button>
                                                                    </div>

                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width:5% ;">
                                                    <button type="button" class="btn btn-danger" onclick="mindmap<?= $data_mindmap['id']; ?>()"><i class="fas fa-trash-alt "></i></button>
                                                    <script>
                                                        function mindmap<?= $data_mindmap['id']; ?>() {
                                                            Swal.fire({
                                                                title: 'คุณแน่ใจไหม?',
                                                                text: "จะถูกลบอย่างถาวร!",
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#3085d6',
                                                                cancelButtonColor: '#d33',
                                                                confirmButtonText: 'Yes, delete',
                                                                showLoaderOnConfirm: true,
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    Swal.fire(
                                                                        'Deleted!',
                                                                        'Your file has been deleted.',
                                                                        'success'
                                                                    ), setInterval(() => {
                                                                        window.location = '?map_id=<?= $data_mindmap["id"]; ?>';
                                                                    }, 800);
                                                                }
                                                            })
                                                        }
                                                    </script>
                                                </td>
                                            </tr>
                                    <?php  }
                                    } ?>
                                </tbody>
                            </table>
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

    <!-- Modal addcours -->
    <div class="modal fade" id="exampleModaladdmain" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มบทเรียนหลัก</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="check_add_mainlesson" method="post" enctype="multipart/form-data">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="" class="form-label">ชื่อบท</label>
                            <input class="form-control" type="text" placeholder="Name" name="name" required aria-label="default input example">
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1">คำบรรยายบทเรียนหลัก</label>
                            <textarea class="form-control" id="summernote" rows="3" name="detail"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="formFile" class="form-label">เสียงบรรยาย</label>
                            <input class="form-control" type="file" id="" name="audio" accept="audio/*">
                        </div>

                        <div class="mb-3">
                            <label for="formFile" class="form-label">เลือกภาพปก</label>
                            <input class="form-control" type="file" id="imgInput" name="images" accept="image/*" required>
                            <img src="" id="previewImg" style="border-radius: 5px; width:25%;" alt="">
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="add-main" class="btn btn-primary"><i class="fa-solid fa-square-plus"></i>
                            เพิ่ม</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal mindmap -->
    <div class="modal fade" id="exampleModaladdmindmap" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มแผนผัง</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="check_mindmap" method="post" enctype="multipart/form-data">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="" class="form-label">เลือกบทเรียน</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="main_id" required>
                                <option value="">- เลือกบทเรียนหลัก -</option>
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
                            <label for="formFile" class="form-label">เลือกภาพ</label>
                            <input class="form-control" type="file" id="imgInput" name="mindmap" accept="image/*" required>
                            <img src="" id="previewImg" style="border-radius: 5px; width:25%;" alt="">
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="add-map" class="btn btn-primary"><i class="fa-solid fa-square-plus"></i>
                            เพิ่ม</button>
                    </div>
                </form>
            </div>
        </div>
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




    <?php
    $stmt = $conn->query("SELECT * FROM db_main_lesson ");
    $stmt->execute();
    $db_main_lesson = $stmt->fetchAll();
    $num = 0;
    if (!$db_main_lesson) {
    } else {
        foreach ($db_main_lesson as $data_main) {
            $num++;
    ?>
            <script>
                // Summernote
                $('#summernote<?= $num; ?>').summernote({
                    height: 100
                })
            </script>
    <?php
        }
    }

    ?>


    <script>
        // Summernote

        $('#summernote').summernote({
            height: 200
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

    <!-- user-delete -->
    <script>
        // Delete
        $(".delete-btn").click(function(e) {
            var mainId = $(this).data('id');
            e.preventDefault();
            deleteConfirm(mainId);
        })

        function deleteConfirm(mainId) {
            Swal.fire({
                title: 'คุณแน่ใจไหม?',
                text: "จะถูกลบอย่างถาวร!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete',
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: 'main-lesson',
                                type: 'GET',
                                data: 'delete=' + mainId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'success',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว!',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'main-lesson';
                                })
                            })
                            .fail(function() {
                                Swal.fire('Oops...', 'Something went wrong with ajax !', 'error')
                                window.location.reload();
                            });
                    });
                },
            });
        }

        // show img
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        }

        // show img
        let imgInput2 = document.getElementById('imgInput2');
        let previewImg2 = document.getElementById('previewImg2');

        imgInput2.onchange = evt => {
            const [file] = imgInput2.files;
            if (file) {
                previewImg2.src = URL.createObjectURL(file);
            }
        }
    </script>



</body>

</html>