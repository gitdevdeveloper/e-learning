<?php
        include('config/conn.php');
        session_start();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- google font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito">

    <!-- css -->
    <link rel="stylesheet" href="css/login.css">
</head>


<body>
    <section class="login">
            <div class="grid-login">
                <div class="box">
                </div>
                <div class="box-login">
                    <!-- alert -->

                    <?php if(isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php
                             echo $_SESSION['error']; 
                            //  unset($_SESSION['error']);
                            ?>
                    </div>
                    <?php }?>
                    <h3>เข้าสู่ระบบ</h3>
                    <form action="check_login" method="post">
                        <div class="mb-3">
                            <label for="Username" class="form-label">ชื่อผู้ใช้</label>
                            <input type="text" class="form-control" id="Username" name="username" placeholder="Username" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">รหัสผ่าน</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                                required>
                            <input type="checkbox" style="margin-top:15px; margin-left: 20px;" onclick="myFunction1()">
                            เเสดงรหัสผ่าน

                            <script>
                            function myFunction1() {
                                var x = document.getElementById("password");
                                if (x.type === "password") {
                                    x.type = "text";
                                } else {
                                    x.type = "password";
                                }
                            }
                            </script>

                        </div>

                        <div class="btnn">
                        <button type="reset" name="login" class="btn btn-outline-secondary"><i class="fa-solid fa-arrows-rotate"></i> รีเซ็ท</button>
                            <button type="submit" name="login" class="btn btn-primary"><i class="fa-solid fa-arrow-right-to-bracket"></i> เข้าสู่ระบบ</button>
                        </div>

                    </form>
                </div>
        </div>
    </section>
<!--  -->


    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <!-- aos -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/59b81ffa56.js" crossorigin="anonymous"></script>

    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script>
    AOS.init();
    </script>
    <script>
    function myFunction1() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    </script>
</body>

</html>