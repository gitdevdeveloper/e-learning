<?php
        include('../../config/conn.php');
        session_start();
        date_default_timezone_set('Asia/Bangkok');

        if(isset($_POST['add-main'])){

            $main_id = rand();
            $images = $_FILES['images'];
            $name = $_POST['name'];
            $detail = $_POST['detail'];
            $audio = $_FILES['audio'];
            $status = "on";
            $date = date("d-m-Y");

                // images
                $allow = array('jpg', 'jpeg', 'png','svg');
                $extension = explode('.', $images['name']);
                $fileActExt = strtolower(end($extension));
                $fileNew = rand() . "." . $fileActExt;  // rand function create the rand number 
                $filePath = '../../upload/images/'.$fileNew;
       
                if (in_array($fileActExt, $allow)) {
                    if ($images['size'] > 0 && $images['error'] == 0) {
                       move_uploaded_file($images['tmp_name'], $filePath);
                    }else{
                        $_SESSION['error'] = "เพิ่มรูปภาพไม่สำเร็จ กรุณาเลือกรูปที่มีนามสกุลไฟล์ดังนี้ 'jpg', 'jpeg', 'png','svg' ";
                        header("location:main-lesson");
                        exit();
                    }
                }else{
                    $_SESSION['error'] = "เพิ่มรูปภาพไม่สำเร็จ กรุณาเลือกรูปที่มีนามสกุลไฟล์ดังนี้ 'jpg', 'jpeg', 'png','svg' ";
                    header("location:main-lesson");
                    exit();
                }

    
    
          
                $audioNew = $_FILES['audio']['name'];
                $file_size =$_FILES['audio']['size'];
                $file_tmp =$_FILES['audio']['tmp_name'];
                $file_type=$_FILES['audio']['type'];  
                move_uploaded_file($file_tmp,"../../upload/audio/".$audioNew);

    
    
                $sql = $conn->prepare("INSERT INTO db_main_lesson (main_id,images,name,detail,audio,status,date) VALUES(:main_id,:images,:name,:detail,:audio,:status,:date)" );
    
                $sql->bindParam(":main_id",$main_id);
                $sql->bindParam(":images",$fileNew);
                $sql->bindParam(":name",$name);
                $sql->bindParam(":detail",$detail);
                $sql->bindParam(":audio",$audioNew);
                $sql->bindParam(":status",$status);
                $sql->bindParam(":date",$date);
                $sql -> execute();
    
    
                if ($sql){
                    $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยเเล้ว";
                    header("location:main-lesson");
    
                }else{
                    $_SESSION['error'] = "เพิ่มข้อมูลไม่สำเร็จ กรุณาติดต่อDevelorper";
                    header("location:main-lesson");
                }
    
        }else{
            $_SESSION['error'] = "เพิ่มข้อมูลไม่สำเร็จ กรุณาติดต่อDevelorper";
            header("location:main-lesson");
        }



?>