
<?php
        include('../../config/conn.php');
        session_start();
        date_default_timezone_set('Asia/Bangkok');
        
        if (isset($_POST['update'])) {
            $allms_id = rand(999999, 111111);
            $m_id = $_POST['m_id'];
            $user_id = $_POST['user_id'];
            $reply = $_POST['reply'];
            $date_reply = date("d/m/Y h:i");

            // update
            $m_status  = "read";


            $sql2 = $conn->prepare("INSERT INTO db_all_message (allms_id,m_id,user_id,reply,date_reply) 
            VALUES(:allms_id,:m_id,:user_id,:reply,:date_reply)" );
    
                $sql2->bindParam(":allms_id",$allms_id);
                $sql2->bindParam(":m_id",$m_id);
                $sql2->bindParam(":user_id",$user_id);
                $sql2->bindParam(":reply",$reply);
                $sql2->bindParam(":date_reply",$date_reply);
                $sql2 -> execute();
       
            if ($sql2) {
                $sql = $conn->prepare("UPDATE db_message SET m_status = :m_status WHERE m_id  = :m_id ");
                $sql->bindParam(":m_id", $m_id );
                $sql->bindParam(":m_status", $m_status );
                $sql->execute();

                if($sql2){
                    $_SESSION['success'] = "อัพเดทข้อมูลเรียบร้อยเเล้ว";
                    header("location: message");
                }else{
                    $_SESSION['error'] = "อัพเดทข้อมูลไม่สำเร็จ";
                    header("location: message");
                }



            } else {
                $_SESSION['error'] = "อัพเดทข้อมูลไม่สำเร็จ";
                header("location: message");
            }
        }


?>



