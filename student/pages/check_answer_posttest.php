<?php
if (isset($_POST["submit"])) {

    session_start();
    require_once "../../config/conn.php";
    date_default_timezone_set('Asia/Bangkok');
    // score_pretest
    $s_id = rand(999999, 111111);
    $s_main_id = $_POST["s_main_id"];
    $date_time = date("d M Y H:s:i");

    // db_user_answer_posttest
    $answer_id = rand(999999, 111111);
    $user_id = $_POST["user_id"];
    $a_main_id = $_POST["s_main_id"];
    $a_post_id = $_POST["a_post_id"];

    for ($count = 0; $count < count($_POST["answer"]); $count++) {

        $a_snswer = $_POST['answer'][$count];
        $a_post_id = $_POST['a_post_id'][$count];

        $sql = $conn->prepare("INSERT INTO db_user_answer_posttest (answer_id,a_post_id,user_id,a_main_id,a_snswer) VALUES(:answer_id,:a_post_id,:user_id,:a_main_id,:a_snswer)");

        $sql->bindParam(":answer_id", $answer_id);
        $sql->bindParam(":a_post_id", $a_post_id);
        $sql->bindParam(":user_id", $user_id);
        $sql->bindParam(":a_main_id", $a_main_id);
        $sql->bindParam(":a_snswer", $a_snswer);
        $sql->execute();
    }

    $stmt2 = $conn->query("SELECT * FROM db_posttest INNER JOIN  db_user_answer_posttest  ON  db_posttest.post_id = db_user_answer_posttest.a_post_id 
        WHERE db_user_answer_posttest.answer_id = '$answer_id'");
    $stmt2->execute();
    $db_posttest = $stmt2->fetchAll();
    $score = 0;
    if (!$db_posttest) {
    } else {
        foreach ($db_posttest as $data) {
            // เท่ากับ
            if ($data["a_main_id"] == $data["main_id"]) {
                if ($data["answer"] == $data["a_snswer"]) {
                    $score++;
                }
            }
        }
    }

    $sql2 = $conn->prepare("INSERT INTO score_posttest (s_id,user_id,s_main_id,score,date_time) VALUES(:s_id,:user_id,:s_main_id,:score,:date_time)");
    $sql2->bindParam(":s_id", $s_id);
    $sql2->bindParam(":user_id", $user_id);
    $sql2->bindParam(":s_main_id", $s_main_id);
    $sql2->bindParam(":score", $score);
    $sql2->bindParam(":date_time", $date_time);
    $sql2->execute();

    if ($sql2) {
        $_SESSION['success'] = "บันทึกข้อมูลเรียบร้อยเเล้ว";
        header("location:score");
        exit();
    } else {
        $_SESSION['error'] = "บันทึกข้อมูลไม่สำเร็จ กรุณาลองใหม่อีกครั้ง";
        header("location:score");
        exit();
    }
}else{
    $_SESSION['error'] = "บันทึกข้อมูลไม่สำเร็จ กรุณาลองใหม่อีกครั้ง";
    header("location:score");
    exit();
}
