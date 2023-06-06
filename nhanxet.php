<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['loaitk'] == 'sv') {
    echo "<script>window.location='login.php'</script>";
}
if (isset($_GET['masv'])) $_SESSION['masv'] = $_GET['masv'];
if (isset($_GET['id']))  $_SESSION['id'] = $_GET['id'];

$conn = mysqli_connect('localhost', 'root', '', 'qlthuchanh') or die('Lỗi kết nối');
mysqli_query($conn, "set names 'utf8'");
$magv = $_SESSION['username'];
$masv = $_SESSION['masv'];

$id = $_SESSION['id'];
$query_th = mysqli_query($conn, "Select * from thuchanh where id='$id' and masv = '$masv'");
$row_th = mysqli_fetch_array($query_th);

$query_dt = mysqli_query($conn, "Select * from detai where id='$id'");
$row_dt = mysqli_fetch_array($query_dt);
if ($row_dt['magv'] != $magv) {
    echo "<script>alert('Đề tài không do giảng viên tạo ra!')</script>";
    echo "<script>window.location='index.php'</script>";
}

$ttsv = mysqli_query($conn, "Select * from sinhvien where masv='$masv'");
$row_sv = mysqli_fetch_array($ttsv);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhận xét</title>

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
    <?php include('header_gv.php') ?>

    <table class="table table-hover">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <tr>
                <td colspan="2" align="center">
                    <legend>Nhận xét sinh viên</legend>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="col-form-label">Mã sinh viên:</div>
                </td>
                <td><input class="form-control-plaintext" type="text" name="masv" value="<?php echo $masv ?>" readonly></td>
            </tr>
            <tr>
                <td>
                    <div class="col-form-label">Họ tên sinh viên:</div>
                </td>
                <td><input class="form-control-plaintext" type="text" name="hoten" readonly value="<?php echo $row_sv['hoten'] ?>"></td>
            </tr>
            <tr>
                <td>
                    <div class="col-form-label">Lớp:</div>
                </td>
                <td><input class="form-control-plaintext" type="text" name="lop" readonly value="<?php echo $row_sv['lop']; ?>"></td>
            </tr>
            <tr>
                <td>
                    <div class="col-form-label">Nộp bài:</div>
                </td>
                <td><input class="form-control-plaintext" readonly type="text" name="nopbai" value="<?php echo $row_th['nopbai'] ?>"></td>
            </tr>
            <tr>
                <td>
                    <div class="col-form-label">Nhận xét:</div>
                </td>
                <td><textarea class="form-control" name="nhanxet"><?php echo $row_th['nhanxet'] ?></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td align="center"><input class="btn btn-secondary" type="submit" name="submit" value="Gửi nhận xét"></td>
            </tr>
        </form>
    </table>
    <div>
        <?php echo "<td><a class='btn btn-secondary' href='info_detai_gv.php?id=" . $id . "'>Quay lại</a></td>"; ?>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $nhanxet = $_POST['nhanxet'];

        $update_nx = "Update thuchanh set nhanxet='$nhanxet' where id = '$id' and masv = '$masv'";
        if (mysqli_query($conn, $update_nx)) {
            echo "<script>alert('Cập nhật nhận xét thành công!')</script>";
            echo "<script>window.location='nhanxet.php?id=" . $id . "&&masv=" . $masv . "'</script>";
            die();
        } else {
            echo "<script>alert('Cập nhật nhận xét thất bại!')</script>";
        }
    }
    mysqli_close($conn);
    ?>
</body>

</html>