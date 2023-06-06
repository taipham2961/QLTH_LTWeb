<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['loaitk'] == 'gv') {
    echo "<script>window.location='login.php'</script>";
}

$username = $_SESSION['username'];
$conn = mysqli_connect('localhost', 'root', '', 'qlthuchanh') or die('Lỗi kết nối');
mysqli_query($conn, "set names 'utf8'");

$check = mysqli_num_rows(mysqli_query($conn, "Select * from thuchanh where masv='$username'"));
if ($check > 0) {
    echo '<script>alert("Tài khoản đã đăng ký đề tài trước đó!");';
    echo 'window.location.href="info_detai.php";</script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký đề tài</title>

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
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên đề tài</th>
                <th scope="col">Số lượng sinh viên</th>
                <th scope="col">Số lượng tối đa</th>
                <th scope="col">Thứ</th>
                <th scope="col">Giảng viên</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $limit = 5;
            $result = mysqli_query($conn, 'select count(id) as total from detai');
            $row = mysqli_fetch_assoc($result);
            $total_records = $row['total'];

            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            $total_page = ceil($total_records / $limit);

            if ($current_page > $total_page) {
                $current_page = $total_page;
            } else if ($current_page < 1) {
                $current_page = 1;
            }

            $start = ($current_page - 1) * $limit;
            $result = mysqli_query($conn, "SELECT * FROM detai LIMIT $start, $limit");

            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['soluongsv'] < $row['soluongtoida']) {
                    echo "<tr class='table-secondary'>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['tendetai'] . "</td>";
                    echo "<td>" . $row['soluongsv'] . "</td>";
                    echo "<td>" . $row['soluongtoida'] . "</td>";
                    echo "<td>" . $row['thu'] . "</td>";
                    $query_gv = mysqli_query($conn, "Select * from giangvien where magv= '" . $row['magv'] . "'");
                    $gv = mysqli_fetch_array($query_gv);
                    echo "<td>" . $gv['hoten'] . "</td>";
                    echo "<td><a class='btn btn-primary' href='dk_detai?id=" . $row['id'] . "'>Đăng ký</a></td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <div class="m-4">
        <nav>
            <ul class="pagination justify-content-center">
                <?php
                if ($current_page > 1 && $total_page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="dk_detai.php?page=' . ($current_page - 1) . '">Trước đó</a></li>';
                }
                for ($i = 1; $i <= $total_page; $i++) {
                    if ($i == $current_page) {
                        echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="dk_detai.php?page=' . $i . '">' . $i . '</a></li>';
                    }
                }
                if ($current_page < $total_page && $total_page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="dk_detai.php?page=' . ($current_page + 1) . '">Tiếp theo</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>

    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $insert = "Insert into thuchanh (id, masv) values ('$id','$username')";
        if (mysqli_query($conn, $insert)) {
            $update = "Update detai set soluongsv = soluongsv + 1 where id = '$id'";
            if (mysqli_query($conn, $update)) {
                echo '<script>alert("Đăng ký thành công.");';
                echo 'window.location.href="info_detai.php";</script>';
            } else {
                echo '<script>alert("Lỗi cập nhật số lượng sinh viên.")</script>';
            }
        } else {
            echo '<script>alert("Lỗi đăng ký đề tài")</script>';
        }
    }
    mysqli_close($conn);
    ?>
</body>

</html>