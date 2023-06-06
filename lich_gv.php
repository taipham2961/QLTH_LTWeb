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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch</title>

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

    <legend>Lịch thực hành các đề tài</legend>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Thứ</th>
                <th scope="col">Đề tài</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table-active">
                <th scope="row">Thứ 2</th>
                <td>
                    <?php
                    $select_t2 = mysqli_query($conn, "Select * from detai where thu = 2 and magv = '$magv'");
                    while ($row = mysqli_fetch_assoc($select_t2)) {
                        echo "<a href=info_detai_gv.php?id=" . $row['id'] . ">" . $row['id'] . " - " . $row['tendetai'] . "</a>";
                        echo '<br/>';
                    }
                    ?>
                </td>
            </tr>
            <tr class="table-active">
                <th scope="row">Thứ 3</th>
                <td>
                    <?php
                    $select_t3 = mysqli_query($conn, "Select * from detai where thu = 3 and magv = '$magv'");
                    while ($row = mysqli_fetch_assoc($select_t3)) {
                        echo "<a href=info_detai_gv.php?id=" . $row['id'] . ">" . $row['id'] . " - " . $row['tendetai'] . "</a>";
                        echo '<br/>';
                    }
                    ?>
                </td>
            </tr>
            <tr class="table-active">
                <th scope="row">Thứ 4</th>
                <td>
                    <?php
                    $select_t4 = mysqli_query($conn, "Select * from detai where thu = 4 and magv = '$magv'");
                    while ($row = mysqli_fetch_assoc($select_t4)) {
                        echo "<a href=info_detai_gv.php?id=" . $row['id'] . ">" . $row['id'] . " - " . $row['tendetai'] . "</a>";
                        echo '<br/>';
                    }
                    ?>
                </td>
            </tr>
            <tr class="table-active">
                <th scope="row">Thứ 5</th>
                <td>
                    <?php
                    $select_t5 = mysqli_query($conn, "Select * from detai where thu = 5 and magv = '$magv'");
                    while ($row = mysqli_fetch_assoc($select_t5)) {
                        echo "<a href=info_detai_gv.php?id=" . $row['id'] . ">" . $row['id'] . " - " . $row['tendetai'] . "</a>";
                        echo '<br/>';
                    }
                    ?>
                </td>
            </tr>
            <tr class="table-active">
                <th scope="row">Thứ 6</th>
                <td>
                    <?php
                    $select_t6 = mysqli_query($conn, "Select * from detai where thu = 6 and magv = '$magv'");
                    while ($row = mysqli_fetch_assoc($select_t6)) {
                        echo "<a href=info_detai_gv.php?id=" . $row['id'] . ">" . $row['id'] . " - " . $row['tendetai'] . "</a>";
                        echo '<br/>';
                    }
                    ?>
                </td>
            </tr>
            <tr class="table-active">
                <th scope="row">Thứ 7</th>
                <td>
                    <?php
                    $select_t7 = mysqli_query($conn, "Select * from detai where thu = 7 and magv = '$magv'");
                    while ($row = mysqli_fetch_assoc($select_t7)) {
                        echo "<a href=info_detai_gv.php?id=" . $row['id'] . ">" . $row['id'] . " - " . $row['tendetai'] . "</a>";
                        echo '<br/>';
                    }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php mysqli_close($conn) ?>
</body>

</html>