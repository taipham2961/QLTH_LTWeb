<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['loaitk'] == 'sv') {
    echo "<script>window.location='login.php'</script>";
}
$conn = mysqli_connect('localhost', 'root', '', 'qlthuchanh') or die('Lỗi kết nối');
mysqli_query($conn, "set names 'utf8'");
$magv = $_SESSION['username'];

$id = $_GET['id'];
$query_dt = mysqli_query($conn, "Select * from detai where id='$id'");
$row_dt = mysqli_fetch_array($query_dt);

if ($row_dt['magv'] != $magv) {
    echo "<script>alert('Đề tài không do giảng viên tạo ra!')</script>";
    echo "<script>window.location='index.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đề tài</title>

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
    <div id="col-1 justify-content-center">
        <table class="table table-hover">
            <tr>
                <td colspan="2" align="center">
                    <legend>Thông tin đề tài</legend>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="col-form-label">Mã đề tài:</div>
                </td>
                <td><input class="form-control-plaintext" type="text" name="id" value="<?php echo $row_dt['id']; ?>" readonly></td>
            </tr>

            <tr>
                <td>
                    <div class="col-form-label">Tên đề tài:</div>
                </td>
                <td><input class="form-control-plaintext" type="text" name="tendetai" value="<?php echo $row_dt['tendetai']; ?>" readonly></td>
            </tr>

            <tr>
                <td>
                    <div class="col-form-label">Số lượng sinh viên:</div>
                </td>
                <td><input class="form-control-plaintext" type="text" name="soluongsv" value="<?php echo $row_dt['soluongsv']; ?>" readonly></td>
            </tr>

            <tr>
                <td>
                    <div class="col-form-label">Số lượng tối đa:</div>
                </td>
                <td><input class="form-control-plaintext" type="text" name="soluongtoida" value="<?php echo $row_dt['soluongtoida']; ?>" readonly></td>
            </tr>

            <tr>
                <td>
                    <div class="col-form-label">Ngày học:</div>
                </td>
                <td><input class="form-control-plaintext" type="text" name="thu" value="<?php echo 'Thứ ' . $row_dt['thu']; ?>" readonly></td>
            </tr>

            <?php
            $query_gv = mysqli_query($conn, "Select * from giangvien where magv= '" . $row_dt['magv'] . "'");
            $gv = mysqli_fetch_array($query_gv);
            ?>
            <tr>
                <td>
                    <div class="col-form-label">Giảng viên:</div>
                </td>
                <td><input class="form-control-plaintext" type="text" name="hoten_gv" value="<?php echo $gv['hoten']; ?>" readonly></td>
            </tr>
        </table>
    </div>

    <div id="col-2 justify-content-center">
        <legend>Danh sách sinh viên</legend>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Mã sinh viên</th>
                    <th scope="col">Họ tên sinh viên</th>
                    <th scope="col">Lớp</th>
                    <th scope="col">Nộp bài</th>
                    <th scope="col">Nhận xét</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query_dsmasv = mysqli_query($conn, "Select * from thuchanh where id='$id' limit 0,4");
                while ($row = mysqli_fetch_assoc($query_dsmasv)) {
                    echo "<tr class='table-secondary'>";
                    echo "<td>" . $row['masv'] . "</td>";
                    $query_ttsv = mysqli_query($conn, "Select * from sinhvien where masv = " . $row['masv']);
                    $sv = mysqli_fetch_array($query_ttsv);
                    echo "<td>" . $sv['hoten'] . "</td>";
                    echo "<td>" . $sv['lop'] . "</td>";
                    if ($row['nopbai'] == null) {
                        echo "<td>Chưa nộp bài</td>";
                    } else {
                        echo "<td>" . $row['nopbai'] . "</td>";
                    }
                    echo "<td><textarea name='nhanxet' class='form-control-plaintext'>" . $row['nhanxet'] . "</textarea></td>";
                    echo "<td><a class='btn btn-primary' href='nhanxet.php?id=" . $id . "&&masv=" . $row['masv'] . "'>Nhận xét</a></td>";
                    echo "<td><a class='btn btn-danger' href='info_detai_gv.php?id=" . $id . "&&masv=" . $row['masv'] . "&&deleted'>Xóa</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
        if (isset($_GET['deleted'])) {
            $masv = $_GET['masv'];
            $delete = "Delete from thuchanh where masv='$masv'";
            $update = "Update detai set soluongsv = soluongsv - 1 where id = '$id'";
            if (mysqli_query($conn, $delete) && mysqli_query($conn, $update)) {
                echo '<script>alert("Xóa sinh viên ra khỏi nhóm thành công!");';
                echo 'window.location.href="info_detai_gv.php?id=' . $id . '&&masv=' . $masv . '";</script>';
            } else {
                echo '<script>alert("Xóa sinh viên ra khỏi nhóm thất bại!")</script>';
            }
        }
        mysqli_close($conn);
        ?>
    </div>
</body>

</html>