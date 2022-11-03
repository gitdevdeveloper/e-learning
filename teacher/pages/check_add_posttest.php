<?php 
    
    session_start();
    require_once "../../config/conn.php";
    date_default_timezone_set('Asia/Bangkok');

    if(isset($_POST['pretest'])){
        $post_id = rand(999999, 111111);
        $main_id = $_POST['main_id'];
        $question = $_POST['question'];
        $answer = $_POST['answer'];

        // addcoice

        $choice_id = rand(999999, 111111);
        $post_id = $post_id ;
        $choice1 = $_POST['choice1'];
        $choice2 = $_POST['choice2'];
        $choice3 = $_POST['choice3'];
        $choice4 = $_POST['choice4'];
        
        


        $sql = $conn->prepare("INSERT INTO db_posttest (post_id,main_id,question,answer) VALUES(:post_id,:main_id,:question,:answer)" );

            $sql->bindParam(":post_id",$post_id);
            $sql->bindParam(":main_id",$main_id);
            $sql->bindParam(":question",$question);
            $sql->bindParam(":answer",$answer);
            $sql -> execute();

            if ($sql){

                $sql2 = $conn->prepare("INSERT INTO db_posttest_choice (choice_id,post_id,choice1,choice2,choice3,choice4) VALUES(:choice_id,:post_id,:choice1,:choice2,:choice3,:choice4)" );

                $sql2->bindParam(":choice_id",$choice_id);
                $sql2->bindParam(":post_id",$post_id);
                $sql2->bindParam(":choice1",$choice1);
                $sql2->bindParam(":choice2",$choice2);
                $sql2->bindParam(":choice3",$choice3);
                $sql2->bindParam(":choice4",$choice4);
                $sql2 -> execute();


                $_SESSION['success'] = "บันทึกข้อมูลเรียบร้อยเเล้ว";
                header("location:post-test");
            
            }else{
                $_SESSION['error'] = "บันทึกข้อมูลไม่สำเร็จ กรุณาลองใหม่อีกครั้ง";
                header("location:post-test");
            }


    }else{
        $_SESSION['error'] = "บันทึกข้อมูลไม่สำเร็จ กรุณาลองใหม่อีกครั้ง";
        header("location:post-test");
    }



?>