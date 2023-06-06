<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['loaitk'] == 'sv') {
    echo "<script>window.location='login.php'</script>";
}

if (isset($_GET['changed'])) {
    echo "<script>alert('Thay đổi mật khẩu thành công');</script>";
}

$conn = mysqli_connect('localhost', 'root', '', 'qlthuchanh') or die('Lỗi kết nối');
mysqli_query($conn, "set names 'utf8'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thay đổi mật khẩu</title>

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
    <?php include('header_gv.php') ?>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="form-container col-12 col-sm-6 col-md-4">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <legend class="form-label mt-4">Đổi mật khẩu</legend>
                    <?php if (isset($_GET['error'])) echo '<label class="error">' . $_GET['error'] . '</label>'; ?>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="mkcu" required>
                        <label for="mkcu">Mật khẩu cũ</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="mkmoi" required>
                        <label for="mkmoi">Mật khẩu mới</label>
                    </div>

                    <div class="form-floating">
                        <input type="password" class="form-control" name="xnmkmoi" required>
                        <label for="xnmkmoi">Xác nhận mật khẩu mới</label>
                    </div>

                    <input type="submit" name="change_pass" class="btn btn-secondary mt-4 w-100" value="Thay đổi mật khẩu">
                </form>
                <p class="mt-4"><a href="info_gv.php">Quay lại</a></p>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['change_pass'])) {
        $magv = $_SESSION['username'];
        $mkcu = $_POST['mkcu'];
        $mkmoi = $_POST['mkmoi'];
        $xnmkmoi = $_POST['xnmkmoi'];

        if ($mkmoi != $xnmkmoi) {
            echo "<script>window.location='change_pass_gv.php?error=Mật khẩu nhập lại không khớp!'</script>";
            die();
        }

        $check_mk = mysqli_num_rows(mysqli_query($conn, "Select * from giangvien where magv='$magv' and matkhau='$mkcu'"));
        if ($check_mk == 0) {
            echo "<script>window.location='change_pass_gv.php?error=Mật khẩu cũ nhập lại không đúng!'</script>";
            die();
        }

        $update = "Update giangvien set matkhau = '" . $mkmoi . "' where magv = '$magv'";

        if (mysqli_query($conn, $update)) {
            echo "<script>window.location='change_pass_gv.php?changed'</script>";
            die();
        } else {
            echo "<script>window.location='change_pass_gv.php?error=Lỗi thay đổi mật khẩu!'</script>";
            die();
        }
    }
    mysqli_close($conn);
    ?>
</body>
</html>