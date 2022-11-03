<?php 
    
    session_start();
    require_once "../../config/conn.php";
    date_default_timezone_set('Asia/Bangkok');

    if(isset($_POST['add'])){
        $user_id = rand(999999, 111111);
        $username = $_POST['username'];
        $password = $_POST['password'];
        $f_name = $_POST['f_name'];
        $l_name = $_POST['l_name'];
        $prefix = $_POST['prefix'];
        $gender = $_POST['gender'];
        $birthday = $_POST['birthday'];
        $status = "teacher";


        $result  = $conn->prepare("SELECT SQL_CALC_FOUND_ROWS  username FROM db_user WHERE username = '$username'");
        $result->execute();
        $result = $conn->prepare("SELECT FOUND_ROWS()"); 
        $result->execute();
        $row_count =$result->fetchColumn();

        if ($row_count > 0) {
            $_SESSION['error'] = "มีชื่อบัญชีผู้ใช้นี้อยู่เเล้ว";
            header("location:user");
        }else{
            $sql = $conn->prepare("INSERT INTO db_user (user_id,username,password,f_name,l_name,prefix,gender,birthday,status) 
            VALUES(:user_id,:username,:password,:f_name,:l_name,:prefix,:gender,:birthday,:status)" );
    
                $sql->bindParam(":user_id",$user_id);
                $sql->bindParam(":username",$username);
                $sql->bindParam(":password",$password);
                $sql->bindParam(":f_name",$f_name);
                $sql->bindParam(":l_name",$l_name);
                $sql->bindParam(":prefix",$prefix);
                $sql->bindParam(":gender",$gender);
                $sql->bindParam(":birthday",$birthday);
                $sql->bindParam(":status",$status);
                $sql -> execute();

                if ($sql){
                    $_SESSION['success'] = "ลงทะเบียนเรียบร้อยเเล้ว";
                    header("location:user");
    
                    
                }else{
                    $_SESSION['error'] = "ลงทะเบียนไม่สำเร็จ กรุณาลองใหม่อีกครั้ง";
                    header("location:user");
                }
        }

    }else{
        $_SESSION['error'] = "ลงทะเบียนไม่สำเร็จ กรุณาลองใหม่อีกครั้ง";
        header("location:user");
    }



?>