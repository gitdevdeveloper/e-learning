<?php
        include('../../config/conn.php');
        session_start();

 if (isset($_POST['update'])) {

            $sub_id = $_POST['sub_id'];
            $main_id = $_POST['main_id'];
            $sub_name = $_POST['sub_name'];
            $sub_detail = $_POST['sub_detail'];

            $video = $_FILES['video'];
            $video2 = $_POST['video2'];
            $upload2 = $_FILES['video']['name'];




            // video

            if($upload2 != ""){
                $videoNew = $_FILES['video']['name'];
                $file_size =$_FILES['video']['size'];
                $file_tmp =$_FILES['video']['tmp_name'];
                $file_type=$_FILES['video']['type'];  
                move_uploaded_file($file_tmp,"../../upload/video/".$videoNew);
            }else{
                $videoNew = $video2;
            }


       
       
            $sql = $conn->prepare("UPDATE db_sub_lesson SET main_id = :main_id, sub_name = :sub_name,sub_detail = :sub_detail,video = :video   WHERE sub_id = :sub_id");
            $sql->bindParam(":sub_id", $sub_id);
            $sql->bindParam(":main_id", $main_id);
            $sql->bindParam(":sub_name", $sub_name);
            $sql->bindParam(":sub_detail", $sub_detail);
            $sql->bindParam(":video", $videoNew);
            $sql->execute();
       
            if ($sql) {
                $_SESSION['success'] = "อัพเดทข้อมูลเรียบร้อยเเล้ว";
                header("location: sub-lesson");
            } else {
                $_SESSION['error'] = "อัพเดทข้อมูลไม่สำเร็จ";
                header("location: sub-lesson");
            }
        }

?>