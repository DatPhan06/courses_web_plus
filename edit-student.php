<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {

    $stid = intval($_GET['stid']);

    if (isset($_POST['submit'])) {
        $studentname = $_POST['fullanme'];
        $roolid = $_POST['rollid'];
        $studentemail = $_POST['emailid'];
        $gender = $_POST['gender'];
        $classid = $_POST['class'];
        $dob = $_POST['dob'];
        $status = $_POST['status'];
        $sql = "update students set StudentName=:studentname,RollId=:roolid,StudentEmail=:studentemail,Gender=:gender,DOB=:dob,Status=:status where StudentId=:stid ";
        $query = $dbh->prepare($sql);
        $query->bindParam(':studentname', $studentname, PDO::PARAM_STR);
        $query->bindParam(':roolid', $roolid, PDO::PARAM_STR);
        $query->bindParam(':studentemail', $studentemail, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':stid', $stid, PDO::PARAM_STR);
        $query->execute();

        $msg = "Cập nhật thông tin học sinh thành công";
    }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SRMS Admin | Sửa học sinh </title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">

        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php'); ?>
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">

                <!-- ========== LEFT SIDEBAR ========== -->
                <?php include('includes/leftbar.php'); ?>
                <!-- /.left-sidebar -->

                <div class="main-page">

                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Cập nhật thông tin học sinh</h2>

                            </div>

                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Trang chủ</a></li>
                                    <li><a href="#">Học sinh</a></li>
                                    <li><a href="#">Quản lí học sinh</a></li>
                                    <li class="active">Cập nhật thông tin học sinh</li>
                                </ul>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5>Cập nhật thông tin học sinh</h5>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php if ($msg) { ?>
                                        <div class="alert alert-success left-icon-alert" role="alert">
                                            <strong> Tuyệt vời!</strong><?php echo htmlentities($msg); ?>
                                        </div><?php } else if ($error) { ?>
                                        <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Ôi không!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                        <form class="form-horizontal" method="post">
                                            <?php

                                                $sql = "SELECT students.StudentName,students.RollId,students.RegDate,students.StudentId,students.Status,students.StudentEmail,students.Gender,students.DOB,classes.ClassName,classes.Section from students join classes on classes.id=students.ClassId where students.StudentId=:stid";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':stid', $stid, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {  ?>


                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Tên đầy đủ</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="fullanme" class="form-control"
                                                        id="fullanme"
                                                        value="<?php echo htmlentities($result->StudentName) ?>"
                                                        required="required" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Mã học sinh</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="rollid" class="form-control" id="rollid"
                                                        value="<?php echo htmlentities($result->RollId) ?>"
                                                        maxlength="5" required="required" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" name="emailid" class="form-control" id="email"
                                                        value="<?php echo htmlentities($result->StudentEmail) ?>"
                                                        required="required" autocomplete="off">
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Giới tính</label>
                                                <div class="col-sm-10">
                                                    <?php $gndr = $result->Gender;
                                                                if ($gndr == "Male") {
                                                                ?>
                                                    <input type="radio" name="gender" value="Male" required="required"
                                                        checked>Nam <input type="radio" name="gender" value="Female"
                                                        required="required">Nữ <input type="radio" name="gender"
                                                        value="Other" required="required">Khác
                                                    <?php } ?>
                                                    <?php
                                                                if ($gndr == "Female") {
                                                                ?>
                                                    <input type="radio" name="gender" value="Male"
                                                        required="required">Nam <input type="radio" name="gender"
                                                        value="Female" required="required" checked>Nữ <input
                                                        type="radio" name="gender" value="Other"
                                                        required="required">Khác
                                                    <?php } ?>
                                                    <?php
                                                                if ($gndr == "Other") {
                                                                ?>
                                                    <input type="radio" name="gender" value="Male"
                                                        required="required">Nam <input type="radio" name="gender"
                                                        value="Female" required="required">Nữ <input type="radio"
                                                        name="gender" value="Other" required="required" checked>Khác
                                                    <?php } ?>


                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Lớp</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="classname" class="form-control"
                                                        id="classname"
                                                        value="<?php echo htmlentities($result->ClassName) ?>(<?php echo htmlentities($result->Section) ?>)"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="date" class="col-sm-2 control-label">Ngày sinh</label>
                                                <div class="col-sm-10">
                                                    <input type="date" name="dob" class="form-control"
                                                        value="<?php echo htmlentities($result->DOB) ?>" id="date">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Ngày đăng kí
                                                </label>
                                                <div class="col-sm-10">
                                                    <?php echo htmlentities($result->RegDate) ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Trạng thái</label>
                                                <div class="col-sm-10">
                                                    <?php $stats = $result->Status;
                                                                if ($stats == "1") {
                                                                ?>
                                                    <input type="radio" name="status" value="1" required="required"
                                                        checked>Kích hoạt <input type="radio" name="status" value="0"
                                                        required="required">Khóa
                                                    <?php } ?>
                                                    <?php
                                                                if ($stats == "0") {
                                                                ?>
                                                    <input type="radio" name="status" value="1" required="required">Kích
                                                    hoạt <input type="radio" name="status" value="0" required="required"
                                                        checked>Khóa
                                                    <?php } ?>



                                                </div>
                                            </div>

                                            <?php }
                                                } ?>


                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" name="submit" class="btn btn-primary">Cập
                                                        nhật</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script>
        $(function($) {
            $(".js-states").select2();
            $(".js-states-limit").select2({
                maximumSelectionLength: 2
            });
            $(".js-states-hide").select2({
                minimumResultsForSearch: Infinity
            });
        });
        </script>

        <!-- Footer-->
        <footer class="py-5 bg-dark">
        </footer>
</body>

</html>
<?PHP } ?>