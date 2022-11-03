<?php
        include('../../config/conn.php');
        session_start();
        date_default_timezone_set('Asia/Bangkok');

        if(isset($_POST['add-map'])){

            $main_id = $_POST['main_id'];
            $mindmap = $_FILES['mindmap'];


                // images
                $allow = array('jpg', 'jpeg', 'png','svg');
                $extension = explode('.', $mindmap['name']);
                $fileActExt = strtolower(end($extension));
                $fileNew = rand() . "." . $fileActExt;  // rand function create the rand number 
                $filePath = '../../upload/mindmap/'.$fileNew;
       
                if (in_array($fileActExt, $allow)) {
                    if ($mindmap['size'] > 0 && $mindmap['error'] == 0) {
                       move_uploaded_file($mindmap['tmp_name'], $filePath);
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

    
    
                $sql = $conn->prepare("INSERT INTO db_mindmap (main_id,mindmap) VALUES(:main_id,:mindmap)" );
    
                $sql->bindParam(":main_id",$main_id);
                $sql->bindParam(":mindmap",$fileNew);
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
