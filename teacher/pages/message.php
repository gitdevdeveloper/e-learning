<?php
        include('../../config/conn.php');
        session_start();
        date_default_timezone_set('Asia/Bangkok');



        $_SESSION['status'] = $_SESSION['status'] == "teacher";


        if(empty($_SESSION['status']) ){
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

                // delete

        if (isset($_GET['delete'])) {
            $delete_id = $_GET['delete'];
            $deletestmt = $conn->query("DELETE FROM db_message WHERE m_id = $delete_id");
            $deletestmt->execute();
            
            if ($deletestmt) {
                $delete_id = $_GET['delete'];
                $deletestmt = $conn->query("DELETE FROM db_all_message WHERE m_id = $delete_id");
                $deletestmt->execute();
                echo "<script>alert('Data has been deleted successfully');</script>";
                header("refresh:3; url=message");
            }
        }

        if (isset($_GET['deletems'])) {
            $id = $_GET['deletems'];
            $msdelete = $conn->query("DELETE FROM db_all_message WHERE allms_id = $id ");
            $msdelete->execute();
            echo "<script>alert('Data has been deleted successfully');</script>";
            header("refresh:3; url=message");
        }

        if(isset($_POST["updatems"])){
            $reply = $_POST["reply"];
            $allms_id = $_POST["allms_id"];

            $sql = $conn->prepare("UPDATE db_all_message SET reply = :reply WHERE allms_id  = :allms_id ");
            $sql->bindParam(":reply", $reply );
            $sql->bindParam(":allms_id", $allms_id );
            $sql->execute();
            if($sql){
                $_SESSION['success'] = "อัพเดทข้อมูลเรียบร้อยเเล้ว";
                header("location: message");
            }else{
                $_SESSION['error'] = "อัพเดทข้อมูลไม่สำเร็จ";
                header("location: message");
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
                        <a href="#" class="nav-link" data-toggle="modal" data-target="#exampleModal"><i
                                class="fa-solid fa-user-plus"></i></a>
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
                <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
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
                        <a href="./account" class="d-block"><?=$data['username'];?></a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
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
                            <a href="./score" class="nav-link ">
                                <i class="nav-icon fa-solid fa-chart-column"></i>
                                <p>
                                    ตรวจสอบคะแนน
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="./message" class="nav-link active">
                                <i class="nav-icon fa-solid fa-message"></i>
                                <p>
                                    ถามตอบ Q&A
                                </p>
                                <span class="right badge badge-danger"><?=$message;?></span>

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
                            <h1 class="m-0">ถามตอบ Q&A </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">ถามตอบ Q&A </li>
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
                        <?php if(isset($_SESSION['success'])) { ?>
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
                        <?php }?>

                        <?php if(isset($_SESSION['error'])) { ?>
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
                        <?php }?>
                        <h5 class="card-header"><i class="fa-solid fa-message"></i> ถามตอบ Q&A </h5>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">ผู้ถาม</th>
                                        <th scope="col">บทเรียน</th>
                                        <th scope="col">คำถาม</th>
                                        <th scope="col">สถานะ</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                                $stmt = $conn->query("SELECT * FROM db_message  INNER JOIN db_sub_lesson ON  db_message.sub_name = db_sub_lesson.sub_id    
                                                                                                INNER JOIN db_user ON  db_message.user_id = db_user.user_id 
                                                                                                ORDER BY db_message.id DESC  ");
                                                $stmt -> execute();
                                                $db_message = $stmt->fetchAll();
                                                $count = 0 ;
                                                if(!$db_message){
                                                }else{
                                                    foreach($db_message as $allms){ 
                                                        $count++;
                                    ?>
                                    <tr>
                                        <th scope="row"><?=$count;?></th>
                                        <td><?=$allms['f_name']." ".$allms['l_name'];?></td>
                                        <td><?=$allms['sub_name'];?></td>
                                        <td><?=$allms['message'];?></td>
                                        <td>
                                            <?php
                                                if($allms['m_status'] == "notread"){
                                                    ?>
                                            <span class="badge badge-pill badge-danger"><i
                                                    class="fa-solid fa-spinner fa-spin "></i> ยังไม่ตอบ</span>
                                            <?php
                                                }else{
                                                    ?>
                                            <span class="badge badge-pill badge-success"><i
                                                    class="fa-solid fa-circle-check"></i> ตอบกลับเเล้ว</span>
                                            <?php
                                                }
                                            ?>

                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#exampleModal<?=$allms['m_id'];?>">
                                                <i class="fa-solid fa-comment-dots"></i>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal<?=$allms['m_id'];?>" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">คำถาม :
                                                                <?=$allms['message'];?>
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <style>
                                                        .direct-chat .modal-body {
                                                            overflow: auto;
                                                            height: 480px;

                                                        }
                                                        </style>

                                                        <!-- DIRECT CHAT -->
                                                        <div class="direct-chat direct-chat-primary ">
                                                            <div class="modal-body">
                                                                <?php
                                                                $stmt = $conn->query("SELECT * FROM db_all_message  INNER JOIN db_user ON  db_all_message.user_id = db_user.user_id  WHERE  db_all_message.m_id = '$allms[m_id]'  ORDER BY db_all_message.id ASC ");
                                                                $stmt -> execute();
                                                                $db_all_message = $stmt->fetchAll();
                                                                if(!$db_all_message){
                                                                }else{
                                                                    foreach($db_all_message as $ms){ 

                                                                ?>
                                                                <!-- Message. Default to the left -->
                                                                <?php
                                                                    if($ms["status"] == "student"){
                                                                        ?>
                                                                <div class="direct-chat-msg">
                                                                    <div class="direct-chat-infos clearfix">
                                                                        <span
                                                                            class="direct-chat-name float-left"><?=$ms['f_name'];?>
                                                                        </span>
                                                                        <span class="direct-chat-timestamp float-right">
                                                                            <i class="fa-solid fa-clock"></i>
                                                                            <?=$ms['date_reply'];?></span>
                                                                    </div>
                                                                    <!-- /.direct-chat-infos -->
                                                                    <img class="direct-chat-img"
                                                                        src="../dist/img/avatar5.png"
                                                                        alt="message user image">
                                                                    <!-- /.direct-chat-img -->
                                                                    <div class="direct-chat-text"
                                                                        style="text-align: left;">
                                                                        <?=$ms['reply'];?>
                                                                    </div>
                                                                    <!-- /.direct-chat-text -->
                                                                </div>
                                                                <?php
                                                                    }else{
                                                                        if($ms["user_id"] == $data["user_id"]){
                                                                            ?>
                                                                <!-- Message to the right -->
                                                                <div class="direct-chat-msg right">
                                                                    <div class="direct-chat-infos clearfix">
                                                                        <span
                                                                            class="direct-chat-name float-right badge-pill badge-danger"><?=$ms['f_name'];?>
                                                                        </span>
                                                                        <span
                                                                            class="direct-chat-timestamp float-left"><i
                                                                                class="fa-solid fa-clock"></i>
                                                                            <?=$ms['date_reply'];?>
                                                                            <a href="#" role="button" data-toggle="modal" data-target="#exampleModal<?=$ms["allms_id"];?>">แก้ไข</a> 
                                                                            <!-- Modal -->
<div class="modal fade" id="exampleModal<?=$ms["allms_id"];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อความ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
          <form action="message" method="post">
          <div class="modal-body">
            <input type="hidden" value="<?=$ms["allms_id"];?>" name="allms_id">
          <input class="form-control" type="text" placeholder="Default input" name="reply" value="<?=$ms["reply"];?>" required>

      </div>
      <div class="modal-footer">
        <button type="submit" name="updatems" class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i> แก้ไข</button>
      </div>
          </form>                                                                      
    </div>
  </div>
</div>



                                                                            |
                                                                             <a
                                                                                href="JavaScript:if(confirm('คุณเเน่ใจใช่ไหม ที่จะลบข้อความนี้ ?')==true){window.location='message?deletems=<?php echo $ms['allms_id'];?>';}"
                                                                                style="color:red;">ลบ</a></span>
                                                                    </div>
                                                                    <!-- /.direct-chat-infos -->
                                                                    <img class="direct-chat-img"
                                                                        src="../dist/img/avatar.png"
                                                                        alt="message user image">
                                                                    <!-- /.direct-chat-img -->
                                                                    <div class="direct-chat-text"
                                                                        style="text-align: right;">
                                                                        <?=$ms['reply'];?>
                                                                    </div>
                                                                    <!-- /.direct-chat-text -->
                                                                </div>
                                                                <?php

                                                                        }else{
                                                                            ?>
                                                                <div class="direct-chat-msg">
                                                                    <div class="direct-chat-infos clearfix">
                                                                        <span
                                                                            class="direct-chat-name float-left badge-pill badge-danger"><?=$ms['f_name'];?>
                                                                        </span>
                                                                        <span class="direct-chat-timestamp float-right">
                                                                            <i class="fa-solid fa-clock"></i>
                                                                            <?=$ms['date_reply'];?></span>
                                                                    </div>
                                                                    <!-- /.direct-chat-infos -->
                                                                    <img class="direct-chat-img"
                                                                        src="../dist/img/avatar5.png"
                                                                        alt="message user image">
                                                                    <!-- /.direct-chat-img -->
                                                                    <div class="direct-chat-text"
                                                                        style="text-align: left;">
                                                                        <?=$ms['reply'];?>
                                                                    </div>
                                                                    <!-- /.direct-chat-text -->
                                                                </div>
                                                                <?php

                                                                        }
                                                                        ?>

                                                                <?php
                                                                    }
                                                                }}
                                                                ?>
                                                            </div>
                                                            <!--/.direct-chat -->
                                                        </div>
                                                        <div class="modal-footer" style="display:block;">

                                                            <form action="check_send_reply" method="post">
                                                                <div class="input-group">
                                                                    <input type="hidden" name="m_id"
                                                                        value="<?=$ms['m_id'];?>">
                                                                    <input type="hidden" name="user_id"
                                                                        value="<?=$data['user_id'];?>">
                                                                    <input type="text" name="reply" required
                                                                        placeholder="Type Message ..."
                                                                        class="form-control">
                                                                    <span class="input-group-append">
                                                                        <button type="submit" name="update"
                                                                            class="btn btn-primary">Send</button>
                                                                    </span>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                        </td>
                                        <td>
                                            <a data-id="<?php echo $allms['m_id'];?>"
                                                href="?delete=<?php echo $allms['m_id'];?>"
                                                class="delete-btn btn btn-danger"><i class="fas fa-trash-alt "></i></a>
                                        </td>
                                    </tr>

                                    <?php }}?>

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

    // Delete
    $(".delete-btn").click(function(e) {
        var mId = $(this).data('id');
        e.preventDefault();
        deleteConfirm(mId);
    })

    function deleteConfirm(mId) {
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
                            url: 'message',
                            type: 'GET',
                            data: 'delete=' + mId,
                        })
                        .done(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'ลบข้อมูลเรียบร้อยแล้ว!',
                                icon: 'success',
                            }).then(() => {
                                document.location.href = 'message';
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
                                    <input type="text" class="form-control" placeholder="First name" required
                                        name="f_name" aria-label="First name">
                                </div>
                                <div class="col">
                                    <label for=" " class="form-label">นามสกุล</label>
                                    <input type="text" class="form-control" placeholder="Last name" required
                                        name="l_name" aria-label="Last name">
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
                                    <input type="date" class="form-control" placeholder="Birthday" required
                                        name="birthday" aria-label="birthday">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">

                                <div class="col">
                                    <label for=" " class="form-label">ชื่อผู้ใช้</label>
                                    <input type="text" class="form-control" placeholder="Username" required
                                        name="username" aria-label="Username">
                                </div>
                                <div class="col">
                                    <label for=" " class="form-label">รหัสผ่าน</label>
                                    <input type="password" class="form-control" placeholder="Password" required
                                        name="password" aria-label="Password">
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



</body>

</html>