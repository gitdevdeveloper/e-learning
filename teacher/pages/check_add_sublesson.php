<?php
        include('../../config/conn.php');
        session_start();
        date_default_timezone_set('Asia/Bangkok');

        if(isset($_POST['add-sub'])){

            $sub_id = rand();
            $main_id = $_POST['main_id'];
            $sub_name = $_POST['sub_name'];
            $sub_detail = $_POST['sub_detail'];
            $video = $_FILES['video'];
            $date = date("d-m-Y");


                $videoNew = $_FILES['video']['name'];
                $file_size =$_FILES['video']['size'];
                $file_tmp =$_FILES['video']['tmp_name'];
                $file_type=$_FILES['video']['type'];  
                move_uploaded_file($file_tmp,"../../upload/video/".$videoNew);


    
            $sql = $conn->prepare("INSERT INTO db_sub_lesson (sub_id,main_id,sub_name,video,sub_detail,date) VALUES(:sub_id,:main_id,:sub_name,:video,:sub_detail,:date)" );
    
                $sql->bindParam(":sub_id",$sub_id);
                $sql->bindParam(":main_id",$main_id);
                $sql->bindParam(":sub_name",$sub_name);
                $sql->bindParam(":sub_detail",$sub_detail);
                $sql->bindParam(":video",$videoNew);
                $sql->bindParam(":date",$date);
                $sql -> execute();
    
    
                if ($sql){
                    $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยเเล้ว";
                    header("location:sub-lesson");
    
                }else{
                    $_SESSION['error'] = "เพิ่มข้อมูลไม่สำเร็จ กรุณาติดต่อDevelorper";
                    header("location:sub-lesson");
                }

    
        }else{
            $_SESSION['error'] = "เพิ่มข้อมูลไม่สำเร็จ กรุณาติดต่อDevelorper";
            header("location:sub-lesson");
        }



?>