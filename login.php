<?php
session_start();
if (isset($_SESSION['username'])) {
    if ($_SESSION['loaitk'] == 'gv') {
        echo "<script>window.location='index.php'</script>";
    } else {
        echo "<script>window.location='info_detai.php'</script>";
    }
}
$conn = mysqli_connect('localhost', 'root', '', 'qlthuchanh') or die('Lỗi kết nối');
mysqli_query($conn, "set names 'utf8'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>

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
            <div class="form-container col-12 col-sm-6 col-md-4">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <legend class="form-label mt-4">Đăng nhập tài khoản</legend>
                    <?php if (isset($_GET['error'])) echo '<label class="error">' . $_GET['error'] . '</label>'; ?>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="username" required>
                        <label for="username">Tên đăng nhập</label>
                    </div>

                    <div class="form-floating">
                        <input type="password" class="form-control" name="password" required>
                        <label for="password">Mật khẩu</label>
                    </div>

                    <input type="submit" name="login" class="btn btn-secondary mt-4 w-100" value="Đăng nhập">
                </form>
                <input type="submit" name="signup" class="btn btn-secondary mt-4 w-100" value="Đăng ký" onclick="document.location.href='signup.php'">
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = mysqli_query($conn, "Select * from sinhvien where masv = '$username' and matkhau = '$password'");
        $row = mysqli_fetch_array($query);
        if (is_array($row)) {
            $_SESSION['username'] = $row['masv'];
            $_SESSION['loaitk'] = 'sv';
            echo "<script>window.location='info_detai.php'</script>";
            die();
        }

        $query = mysqli_query($conn, "Select * from giangvien where magv = '$username' and matkhau = '$password'");
        $row = mysqli_fetch_array($query);
        if (is_array($row)) {
            $_SESSION['username'] = $row['magv'];
            $_SESSION['loaitk'] = 'gv';
            echo "<script>window.location='index.php'</script>";
            die();
        }

        echo "<script>window.location='login.php?error=Sai tên đăng nhập hoặc mật khẩu!'</script>";
    }
    mysqli_close($conn);
    ?>
</body>

</html>