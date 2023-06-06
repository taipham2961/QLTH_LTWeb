<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['loaitk'] == 'gv') {
    echo "<script>window.location='login.php'</script>";
}
$conn = mysqli_connect('localhost', 'root', '', 'qlthuchanh') or die('Lỗi kết nối');
mysqli_query($conn, "set names 'utf8'");

if (isset($_GET['changed'])) {
    echo "<script>alert('Cập nhật thông tin thành công');</script>";
}

if (isset($_GET['error'])) {
    echo "<script>alert('Lỗi cập nhật thông tin');</script>";
}

function info()
{
    $masv = $_SESSION['username'];
    $connect = mysqli_connect("localhost", "root", "", "qlthuchanh") or die("Không kết nối được");
    mysqli_query($connect, "set names'utf8'");
    $sql = "Select * from sinhvien where masv = '$masv'";
    $result = mysqli_query($connect, $sql) or die("Lỗi!");
    $row = mysqli_fetch_assoc($result);
    mysqli_close($connect);
    return $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin</title>

    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js"></script>
    <style>
        legend {
            display: block;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include('header.php') ?>
    <table class="table table-hover">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <tr>
                <td colspan="2" align="center">
                    <legend>Thông tin sinh viên</legend>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="col-form-label">Mã sinh viên:</div>
                </td>
                <td><input class="form-control-plaintext" type="text" name="masv" value="<?php echo info()['masv']; ?>" readonly></td>
            </tr>
            <tr>
                <td>
                    <div class="col-form-label">Họ tên sinh viên:</div>
                </td>
                <td><input class="form-control" type="text" name="hoten" required value="<?php echo info()['hoten']; ?>"></td>
            </tr>
            <tr>
                <td>
                    <div class="col-form-label">Lớp:</div>
                </td>
                <td><input class="form-control" type="text" name="lop" required value="<?php echo info()['lop']; ?>"></td>
            </tr>
            <tr>
                <td>
                    <div class="col-form-label">Ngày sinh:</div>
                </td>
                <td><input class="form-control" required type="date" name="ngaysinh" value="<?php echo info()['ngaysinh']; ?>"></td>
            </tr>
            <tr>
                <td>
                    <div class="col-form-label">Giới tính:</div>
                </td>
                <td><input class="form-control" required type="text" name="gioitinh" value="<?php echo info()['gioitinh'] == false ? 'Nam' : 'Nữ'; ?>"></td>
            </tr>
            <tr>
                <td>
                    <div class="col-form-label">Quê quán:</div>
                </td>
                <td><input class="form-control" required type="text" name="quequan" value="<?php echo info()['quequan']; ?>"></td>
            </tr>
            <tr>
                <td>
                    <div class="col-form-label">Địa chỉ email:</div>
                </td>
                <td><input class="form-control" required type="text" name="email" value="<?php echo info()['email']; ?>"></td>
            </tr>
            <tr>
                <td align="center"><input class="btn btn-secondary" type="submit" name="change_info" value="Cập nhật thông tin"></td>
                <td align="center"><input class="btn btn-secondary" type="submit" name="change_pass" value="Thay đổi mật khẩu"></td>
            </tr>
        </form>
    </table>

    <?php
    if (isset($_POST['change_info'])) {
        $masv = $_SESSION['username'];
        $hoten = $_POST['hoten'];
        $lop = $_POST['lop'];
        $ngaysinh = $_POST['ngaysinh'];
        $gioitinh = $_POST['gioitinh']  == 'Nam' ? 0 : 1;
        $quequan = $_POST['quequan'];
        $email = $_POST['email'];

        $update = "Update sinhvien set hoten = '" . $hoten . "',lop = '" . $lop . "', ngaysinh = '" . $ngaysinh . "',
        gioitinh = '" . $gioitinh . "', quequan = '" . $quequan . "', email = '" . $email . "' where masv = '$masv'";

        if (mysqli_query($conn, $update)) {
            echo "<script>window.location='info.php?changed'</script>";
            die();
        } else {
            echo "<script>window.location='info.php?error'</script>";
            die();
        }
    }

    if (isset($_POST['change_pass'])) {
        echo "<script>window.location='change_pass.php'</script>";
    }
    mysqli_close($conn);
    ?>
</body>

</html>