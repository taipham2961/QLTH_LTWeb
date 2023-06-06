<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['loaitk'] == 'sv') {
    echo "<script>window.location='login.php'</script>";
}
$conn = mysqli_connect('localhost', 'root', '', 'qlthuchanh') or die('Lỗi kết nối');
mysqli_query($conn, "set names 'utf8'");
$magv = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đề tài</title>

    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js"></script>
</head>

<body>
    <?php include('header_gv.php') ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="tendetai" class="col-form-label">Tên đề tài</label>
            </div>
            <div class="col-auto">
                <input type="text" name="tendetai" class="form-control" required>
            </div>

            <div class="col-auto">
                <label for="soluongtoida" class="col-form-label">Số lượng tối đa</label>
            </div>
            <div class="col-auto">
                <input type="text" name="soluongtoida" class="form-control" required>
            </div>

            <div class="col-auto">
                <label for="thu" class="col-form-label">Thứ</label>
            </div>
            <div class="col-auto">
                <select class="form-select" name="thu">
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                </select>
            </div>

            <div class="col-auto">
                <input type="submit" name="them_detai" class="btn btn-secondary" value="Thêm đề tài">
            </div>
        </div>
    </form>
    <?php
    if (isset($_POST['them_detai'])) {
        $tendetai = $_POST['tendetai'];
        $soluongtoida = $_POST['soluongtoida'];
        $thu = htmlentities($_POST['thu'], ENT_QUOTES, "UTF-8");;

        $insert_dt = "Insert into detai (id, tendetai, soluongsv, soluongtoida, thu, magv)
            values(null, '$tendetai', 0, '$soluongtoida', '$thu', '$magv')";
        if (mysqli_query($conn, $insert_dt)) {
            echo '<script>alert("Thêm đề tài thành công.");';
            echo 'window.location.href="index.php";</script>';
        } else {
            echo '<script>alert("Thêm đề tài thất bại!")</script>';
        }
    }
    ?>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên đề tài</th>
                <th scope="col">Số lượng sinh viên</th>
                <th scope="col">Số lượng tối đa</th>
                <th scope="col">Thứ</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $limit = 5;
            $result = mysqli_query($conn, "select count(id) as total from detai where magv = '$magv'");
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
            $result = mysqli_query($conn, "SELECT * FROM detai where magv = '$magv' LIMIT $start, $limit");

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr class='table-secondary'>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['tendetai'] . "</td>";
                echo "<td>" . $row['soluongsv'] . "</td>";
                echo "<td>" . $row['soluongtoida'] . "</td>";
                echo "<td>" . $row['thu'] . "</td>";
                echo "<td><a class='btn btn-danger' href='index?deleted=" . $row['id'] . "'>Xóa đề tài</a></td>";
                echo "<td><a class='btn btn-primary' href='info_detai_gv.php?id=" . $row['id'] . "'>Chi tiết</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="m-4">
        <nav>
            <ul class="pagination justify-content-center">
                <?php
                if ($current_page > 1 && $total_page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="index.php?page=' . ($current_page - 1) . '">Trước đó</a></li>';
                }
                for ($i = 1; $i <= $total_page; $i++) {
                    if ($i == $current_page) {
                        echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="index.php?page=' . $i . '">' . $i . '</a></li>';
                    }
                }
                if ($current_page < $total_page && $total_page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="index.php?page=' . ($current_page + 1) . '">Tiếp theo</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>

    <?php
    if (isset($_GET['deleted'])) {
        $id_deleted = $_GET['deleted'];
        $delete = "Delete from detai where id = '$id_deleted'";
        if (mysqli_query($conn, $delete)) {
            echo '<script>alert("Xóa đề tài thành công.");';
            echo 'window.location.href="index.php";</script>';
        } else {
            echo '<script>alert("Xóa đề tài thất bại!")</script>';
        }
    }
    mysqli_close($conn);
    ?>
</body>

</html>