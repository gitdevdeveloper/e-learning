<?php
        include('../../config/conn.php');
        session_start();

 if (isset($_POST['update'])) {

            $main_id = $_POST['main_id'];
            $mindmap = $_FILES['mindmap'];
            $img2 = $_POST['img2'];

            $upload = $_FILES['mindmap']['name'];

            if ($upload != '') {
                $allow = array('jpg', 'jpeg', 'png');
                $extension = explode('.', $mindmap['name']);
                $fileActExt = strtolower(end($extension));
                $fileNew = rand() . "." . $fileActExt;  // rand function create the rand number 
                $filePath = '../../upload/mindmap/'.$fileNew;
       
                if (in_array($fileActExt, $allow)) {
                    if ($mindmap['size'] > 0 && $mindmap['error'] == 0) {
                       move_uploaded_file($mindmap['tmp_name'], $filePath);
                    }
                }else{
                    $_SESSION['error'] = "อัพเดทข้อมูลไม่สำเร็จ 'jpg', 'jpeg', 'png'";
                    header("location: main-lesson");
                    exit();
                }
       
            } else {
                $fileNew = $img2;
            }

            $sql = $conn->prepare("UPDATE db_mindmap SET mindmap = :mindmap  WHERE main_id = :main_id");
            $sql->bindParam(":main_id", $main_id);
            $sql->bindParam(":mindmap", $fileNew);
            $sql->execute();
       
            if ($sql) {
                $_SESSION['success'] = "อัพเดทข้อมูลเรียบร้อยเเล้ว";
                header("location: main-lesson");
            } else {
                $_SESSION['error'] = "อัพเดทข้อมูลไม่สำเร็จ";
                header("location: main-lesson");
            }
        }

?>