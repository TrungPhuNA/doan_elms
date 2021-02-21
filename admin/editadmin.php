<?php
session_start();
//error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['update'])) {
        $lid         = intval($_GET['lid']);
        $username = $_POST['UserName'];
        $password = md5($_POST['password']);
        $level    = $_POST['level'];
        $avatar = '';

        if ( isset($_FILES['avatar']))
        {
            $file_name = $_FILES['avatar']['name'];
            $file_tmp  = $_FILES['avatar']['tmp_name'];
            $file_type = $_FILES['avatar']['type'];
            $file_erro = $_FILES['avatar']['error'];

            if ($file_erro == 0)
            {
                $part = ROOT;
                $avatar = $file_name;
                move_uploaded_file($file_tmp,$part.$file_name);
            }
        }

        if($_POST['password'])
        {
            $sql         = "update admin set UserName=:UserName,level=:level, password=:password";
        }else{
            $sql         = "update admin set UserName=:UserName,level=:level";
        }


        if($avatar)
            $sql .= ", avatar=:avatar";

        $sql .= " where id =:lid";

        $query       = $dbh->prepare($sql);
        $query->bindParam(':UserName', $username, PDO::PARAM_STR);
        $query->bindParam(':level', $level, PDO::PARAM_STR);
        if($_POST['password'])
        {
            $query->bindParam(':password', $password, PDO::PARAM_STR);
        }
        if($avatar)
        {
            $query->bindParam(':avatar', $avatar, PDO::PARAM_STR);
        }
        $query->bindParam(':lid', $lid, PDO::PARAM_STR);
        $query->execute();

//        $query->debugDumpParams();
        $msg = "Leave type updated Successfully";
    }

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>

        <!-- Title -->
        <title>Admin | Edit Admin</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template"/>
        <meta name="keywords" content="admin,dashboard"/>
        <meta name="author" content="Steelcoders"/>

        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #dd3d36;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #5cb85c;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }
        </style>
    </head>
    <body>
    <?php include('includes/header.php'); ?>

    <?php include('includes/sidebar.php'); ?>
    <main class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="page-title">Edit Leave Type</div>
            </div>
            <div class="col s12 m12 l6">
                <div class="card">
                    <div class="card-content">

                        <div class="row">
                            <form class="col s12" name="chngpwd" method="post" enctype="multipart/form-data">
                                <?php if (isset($error)) { ?>
                                    <div class="errorWrap"><strong>ERROR</strong> : <?php echo htmlentities($error); ?>
                                    </div><?php } else if (isset($msg)) { ?>
                                    <div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?>
                                    </div><?php } ?>
                                <?php
                                $lid   = intval($_GET['lid']);
                                $sql   = "SELECT * from admin where id=:lid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':lid', $lid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt     = 1;
                                if ($query->rowCount() > 0)
                                {
                                foreach ($results

                                as $result)
                                { ?>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="leavetype" type="text" class="validate" autocomplete="off"
                                               name="UserName" value="<?php echo htmlentities($result->UserName); ?>"
                                               required>
                                        <label for="Username">Username</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="leavetype" type="text" class="validate" autocomplete="off"
                                               name="password" value=""
                                               >
                                        <label for="Password">Password</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <select name="level" id="">
                                            <option value="">Level</option>
                                            <option value="1" <?= $result->level == 1 ? "selected" : "" ?>>Admin</option>
                                            <option value="2" <?= $result->level == 2 ? "selected" : "" ?>>Supper - Admin</option>
                                        </select>
                                        <label for="password">Level</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <div class="form-group">
                                            <i class="fa fa-file-image-o"></i> Update profile picture
                                            <input type="file" accept="image/*" name="avatar" class="form-control">
                                        </div>
                                        <img src="/public/uploads/<?= $result->avatar ?>"  style="width: 80px;height: 80px;border-radius: 50%" alt="">
                                    </div>

                                    <?php }
                                    } ?>


                                    <div class="input-field col s12">
                                        <button type="submit" name="update"
                                                class="waves-effect waves-light btn indigo m-b-xs">Update
                                        </button>

                                    </div>


                                </div>

                            </form>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </main>

    </div>
    <div class="left-sidebar-hover"></div>

    <!-- Javascripts -->
    <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
    <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
    <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
    <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
    <script src="../assets/js/alpha.min.js"></script>
    <script src="../assets/js/pages/form_elements.js"></script>

    </body>
    </html>
<?php } ?>