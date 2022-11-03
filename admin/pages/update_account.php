<?php
        include('../../config/conn.php');
        session_start();
        date_default_timezone_set('Asia/Bangkok');
        
        if (isset($_POST['update'])) {
            $user_id  = $_POST['user_id'];
            $f_name  = $_POST['f_name'];
            $l_name  = $_POST['l_name'];
            $prefix  = $_POST['prefix'];
            $gender  = $_POST['gender'];
            $birthday  = $_POST['birthday'];
            $username  = $_POST['username'];
            $password  = $_POST['password'];

       
            $sql = $conn->prepare("UPDATE db_user SET f_name = :f_name ,l_name = :l_name ,prefix = :prefix 
            ,gender = :gender ,birthday = :birthday ,username = :username ,password = :password   WHERE user_id  = :user_id ");
           
            $sql->bindParam(":user_id", $user_id );
            $sql->bindParam(":f_name", $f_name );
            $sql->bindParam(":l_name", $l_name );
            $sql->bindParam(":prefix", $prefix );
            $sql->bindParam(":gender", $gender );
            $sql->bindParam(":birthday", $birthday );
            $sql->bindParam(":username", $username );
            $sql->bindParam(":password", $password );
            $sql->execute();
       
            if ($sql) {
                $_SESSION['success'] = "อัพเดทข้อมูลเรียบร้อยเเล้ว";
                header("location: account");
            } else {
                $_SESSION['error'] = "อัพเดทข้อมูลไม่สำเร็จ";
                header("location: account");
            }
        }


?>

