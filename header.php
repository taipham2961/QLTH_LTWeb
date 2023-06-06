<html xmlns="http://www.w3.org/1999/xhtml">

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $_SERVER['PHP_SELF']; ?>">Quản lý thực hành</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor02">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dk_detai.php">Đăng kí đề tài</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="info_detai.php">Thông tin đề tài</a>
                    </li>
                </ul>
                <form class="d-flex" method="POST">
                    <a class="navbar-brand" href="info.php">Chào - <?php echo $_SESSION['username'] ?></a>
                    <input name="logout" class="btn btn-secondary my-2 my-sm-0" type="submit" value="Đăng xuất">
                    <?php
                    if (isset($_POST['logout'])) {
                        session_destroy();
                        echo "<script>window.location='login.php'</script>";
                    }
                    ?>
                </form>
            </div>
        </div>
    </nav>
</body>

</html>