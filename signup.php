<?php
$conn = mysqli_connect('localhost', 'root', '', 'qlthuchanh') or die('Lỗi kết nối');
mysqli_query($conn, "set names 'utf8'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>

    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js"></script>
    <style>
        .form-container {
            position: relative;
            top: 10vh;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px #000;
        }

        .error {
            background: #F2DEDE;
            color: #A94442;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            margin: 20px auto;
        }

        legend {
            display: block;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="form-container col-12 col-sm-6 col-md-5">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <legend class="form-label mt-4">Đăng ký tài khoản</legend>
                    <?php if (isset($_GET['error'])) echo '<label class="error">' . $_GET['error'] . '</label>'; ?>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="username" required>
                        <label for="username">Mã sinh viên</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="password" required>
                        <label for="password">Mật khẩu</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="repass" required>
                        <label for="repass">Nhập lại mật khẩu</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="hoten" required>
                        <label for="hoten">Họ tên</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="lop" required>
                        <label for="lop">Lớp</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" name="ngaysinh" required>
                        <label for="ngaysinh">Ngày sinh</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="gioitinh" required>
                        <label for="gioitinh">Giới tính</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="quequan" required>
                        <label for="quequan">Quê quán</label>
                    </div>

                    <div class="form-floating">
                        <input type="email" class="form-control" name="email" required>
                        <label for="email">Địa chỉ email</label>
                    </div>

                    <input type="submit" name="signup" class="btn btn-secondary mt-4 w-100" value="Đăng ký">
                </form>
                <p class="mt-4">Đã có tài khoản?<a href="login.php">Đăng nhập</a></p>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['signup'])) {
        $username = $_POST['username'];

        $check_masvdk = mysqli_num_rows(mysqli_query($conn, "Select * from dsdk where masv='$username'"));
        if ($check_masvdk <= 0) {
            echo "<script>window.location='signup.php?error=Mã sinh viên không cho phép đăng ký!'</script>";
            die();
        }

        $password = $_POST['password'];
        $repass = $_POST['repass'];
        $hoten = $_POST['hoten'];
        $lop = $_POST['lop'];
        $ngaysinh = $_POST['ngaysinh'];
        $gioitinh = $_POST['gioitinh']  == 'Nam' ? 0 : 1;
        $quequan = $_POST['quequan'];
        $email = $_POST['email'];

        if ($password != $repass) {
            echo "<script>window.location='signup.php?error=Mật khẩu nhập lại không khớp!'</script>";
            die();
        }
        $check_masv = mysqli_num_rows(mysqli_query($conn, "Select * from sinhvien where masv='$username'"));
        if ($check_masv > 0) {
            echo "<script>window.location='signup.php?error=Mã sinh viên nhập đã đăng ký trước đó!'</script>";
            die();
        }

        $insert = "INSERT INTO sinhvien (masv, matkhau, hoten, lop, ngaysinh, gioitinh, quequan, email)
                    VALUES ('$username', '$password', '$hoten', '$lop', '$ngaysinh', '$gioitinh', '$quequan', '$email')";

        if (mysqli_query($conn, $insert)) {
            echo '<script>alert("Đăng ký thành công. Quay về trang đăng nhập");';
            echo 'window.location.href="login.php";</script>';
        } else {
            echo "<script>window.location='signup.php?error=Lỗi đăng ký tài khoản!'</script>";
        }
    }
    mysqli_close($conn);
    ?>
</body>

</html>