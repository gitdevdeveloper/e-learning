<?php
        include('../../config/conn.php');
        session_start();

 if (isset($_POST['update'])) {

            $main_id = $_POST['main_id'];
            $images = $_FILES['images'];
            $name = $_POST['name'];
            $detail = $_POST['detail'];
            $img2 = $_POST['img2'];


            $upload = $_FILES['images']['name'];

            $audio = $_FILES['audio'];
            $audio2 = $_POST['audio2'];
            $upload3 = $_FILES['audio']['name'];



            if ($upload != '') {
                $allow = array('jpg', 'jpeg', 'png');
                $extension = explode('.', $images['name']);
                $fileActExt = strtolower(end($extension));
                $fileNew = rand() . "." . $fileActExt;  // rand function create the rand number 
                $filePath = '../../upload/images/'.$fileNew;
       
                if (in_array($fileActExt, $allow)) {
                    if ($images['size'] > 0 && $images['error'] == 0) {
                       move_uploaded_file($images['tmp_name'], $filePath);
                    }
                }else{
                    $_SESSION['error'] = "อัพเดทข้อมูลไม่สำเร็จ 'jpg', 'jpeg', 'png'";
                    header("location: main-lesson");
                    exit();
                }
       
            } else {
                $fileNew = $img2;
            }

            // audio

            if($upload3 != ""){
                $audioNew = $_FILES['audio']['name'];
                $file_size =$_FILES['audio']['size'];
                $file_tmp =$_FILES['audio']['tmp_name'];
                $file_type=$_FILES['audio']['type'];  
                move_uploaded_file($file_tmp,"../../upload/audio/".$audioNew);
            }else{
                $audioNew = $audio2;
            }

         
       
            $sql = $conn->prepare("UPDATE db_main_lesson SET images = :images ,name = :name,detail = :detail,audio = :audio  WHERE main_id = :main_id");
            $sql->bindParam(":main_id", $main_id);
            $sql->bindParam(":images", $fileNew);
            $sql->bindParam(":name", $name);
            $sql->bindParam(":detail", $detail);
            $sql->bindParam(":audio", $audioNew);
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