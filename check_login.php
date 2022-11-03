<?php 
    session_start();
    require_once "config/conn.php";

            if(isset($_POST['login'])  ){
                $username = $_POST['username'];
                $password = $_POST['password'];
                
                //check username  & password
                $stmt = $conn->prepare("SELECT * FROM db_user WHERE username = :username AND password = :password");
                $stmt->bindParam(':username', $username , PDO::PARAM_STR);
                $stmt->bindParam(':password', $password , PDO::PARAM_STR);
                $stmt->execute();
                
                    //กรอก username & password ถูกต้อง
                    if($stmt->rowCount() == 1){
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['password'] = $row['password'];
                        $_SESSION['status'] = $row['status'];


                        if ($_SESSION["status"] == "admin") { // admin 
                            Header("Location: admin/index");
                        }

                        if ($_SESSION["status"] == "teacher") { // teacher 
                            Header("Location: teacher/index");
                        }

                        if ($_SESSION["status"] == "student") { // student 
                            $_SESSION['login'] = "ยินดีต้อนรับ";
                            Header("Location: student/index");
                        }
                        
                    }else{ 
                        $_SESSION['error'] = " username or password ไม่ถูกต้อง !!!";
                        Header("Location: index");
                    } 
        }else{
            $_SESSION['error'] = " username or password ไม่ถูกต้อง !!!";
            Header("Location: index");
        }
   

?>