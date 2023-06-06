<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['loaitk'] == 'gv') {
    echo "<script>window.location='login.php'</script>";
}

$username = $_SESSION['username'];
$conn = mysqli_connect('localhost', 'root', '', 'qlthuchanh') or die('Lỗi kết nối');
mysqli_query($conn, "set names 'utf8'");

$query_sv = mysqli_query($conn, "Select * from thuchanh where masv='$username'");

$check = mysqli_num_rows($query_sv);
if ($check == 0) {
    echo '<script>alert("Tài khoản chưa đăng ký đề tài! Quay lại trang đăng ký đề tài");';
    echo 'window.location.href="dk_detai.php";</script>';
}

$row_sv = mysqli_fetch_array($query_sv);
$id = $row_sv['id'];
$query_dt = mysqli_query($conn, "Select * from detai where id='$id'");
$row_dt = mysqli_fetch_array($query_dt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin đề tài</title>

    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js"></script>
    <style>
        .container {
            display: flex;
        }

        #col-1,
        #col-2 {
            flex: 1;
        }

        legend {
            display: block;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>

    <div class="container">
        <div id="col-1">
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

                <tr>
                    <td></td>
                    <td>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                            <input type="submit" name="thoat_dt" class="btn btn-secondary w-100" value="Thoát nhóm đề tài">
                        </form>
                        <?php
                        if (isset($_GET['thoat_dt'])) {
                            $delete = "Delete from thuchanh where masv='$username'";
                            $update = "Update detai set soluongsv = soluongsv - 1 where id = '$id'";
                            if (mysqli_query($conn, $delete) && mysqli_query($conn, $update)) {
                                echo '<script>alert("Thoát nhóm thành công! Quay lại trang đăng ký đề tài");';
                                echo 'window.location.href="dk_detai.php";</script>';
                            } else {
                                echo '<script>alert("Thoát nhóm thất bại!")</script>';
                            }
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <div id="col-2">
            <legend>Danh sách sinh viên</legend>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Mã sinh viên</th>
                        <th scope="col">Họ tên sinh viên</th>
                        <th scope="col">Lớp</th>
                        <th scope="col">Nộp bài</th>
                        <th scope="col">Nhận xét</th>
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
                        echo "<td>" . $row['nhanxet'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="form-group">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                    <label for="upload_file" class="form-label mt-4">Nộp bài</label>
                    <input class="form-control" type="file" name="upload_file" id="upload_file">
                    <input class="btn btn-secondary mt-4" type="submit" name="upload" value="Upload file">
                </form>
                <?php
                if (isset($_POST['upload'])) {
                    $path = 'uploads/' . $id;
                    if (!is_dir($path)) {
                        mkdir($path);
                    }
                    $path = $path . '/' . $username;
                    if (!is_dir($path)) {
                        mkdir($path);
                    }
                    $file = $_FILES['upload_file'];
                    //Đổi tên
                    $filename = $file['name'];
                    $filename = explode('.', $filename);
                    $file_extension = end($filename);
                    date_default_timezone_set("Asia/Ho_Chi_Minh");
                    $new_file = $username . "-" . date("d-m-Y-H-i-s") . '.' . $file_extension;

                    //Upload file
                    $upload = move_uploaded_file($file['tmp_name'], $path . '/' . $new_file);
                    if ($upload) {
                        $update_nopbai = "Update thuchanh set nopbai = '$new_file' where id = '$id' and masv = '$username'";
                        mysqli_query($conn, $update_nopbai);
                        echo '<script>alert("Upload file thành công!");';
                        echo 'location.href="info_detai.php";</script>';
                    } else {
                        echo '<script>alert("Upload file thất bại!")</script>';
                    }
                }
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
</body>

</html>