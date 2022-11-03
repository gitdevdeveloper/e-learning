<?php 
    
    session_start();
    require_once "../../config/conn.php";
    date_default_timezone_set('Asia/Bangkok');

    if(isset($_POST['send'])){
        $m_id = rand(999999, 111111);
        
        $user_id = $_POST['user_id'];
        $sub_name = $_POST['sub_name'];
        $message = $_POST['message'];
        $m_date = date("d/m/Y h:i");
        $m_status = "notread";

        $allms_id = rand(999999, 111111);
        $reply = $message;
        $date_reply = $m_date;


      


        
            $sql = $conn->prepare("INSERT INTO db_message (m_id,user_id,sub_name,message,m_date,m_status) 
            VALUES(:m_id,:user_id,:sub_name,:message,:m_date,:m_status)" );
    
                $sql->bindParam(":m_id",$m_id);
                $sql->bindParam(":user_id",$user_id);
                $sql->bindParam(":sub_name",$sub_name);
                $sql->bindParam(":message",$message);
                $sql->bindParam(":m_date",$m_date);
                $sql->bindParam(":m_status",$m_status);
                $sql -> execute();

                if ($sql){

                    $sql2 = $conn->prepare("INSERT INTO db_all_message (allms_id,m_id,user_id,reply,date_reply) 
                    VALUES(:allms_id,:m_id,:user_id,:reply,:date_reply)" );
            
                        $sql2->bindParam(":allms_id",$allms_id);
                        $sql2->bindParam(":m_id",$m_id);
                        $sql2->bindParam(":user_id",$user_id);
                        $sql2->bindParam(":reply",$reply);
                        $sql2->bindParam(":date_reply",$date_reply);
                        $sql2 -> execute();
                        

                        if($sql2){
                            $_SESSION['success'] = "ส่งข้อความเรียบร้อยเเล้ว";
                            header("location:message");
                        }else{
                            $_SESSION['error'] = "ส่งข้อความไม่สำเร็จ กรุณาลองใหม่อีกครั้ง";
                            header("location:message");
                        }


                }else{
                    $_SESSION['error'] = "ส่งข้อความไม่สำเร็จ กรุณาลองใหม่อีกครั้ง";
                    header("location:message");
                }

    }else{
        $_SESSION['error'] = "ส่งข้อความไม่สำเร็จ กรุณาลองใหม่อีกครั้ง";
        header("location:message");
    }



?>