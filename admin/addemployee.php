<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['add'])) {
        $empid         = $_POST['empcode'];
        $fname         = $_POST['firstName'];
        $lname         = $_POST['lastName'];
        $fullname      = $fname . ' ' . $lname;
        $email         = $_POST['email'];
        $password      = md5($_POST['password']);
        $gender        = $_POST['gender'];
        $dob           = $_POST['dob'];
        $department    = $_POST['department'];
        $address       = $_POST['address'];
        $city          = $_POST['city'];
        $country       = $_POST['country'];
        $some_holidays = $_POST['some_holidays'];
        $phonenumber   = $_POST['phonenumber'];
        $status        = 1;

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


        $sql   = "INSERT INTO tblemployees(EmpId,FirstName,LastName,SortName,EmailId,Password,Gender,Dob,Department,Address,City,Country,Status,Phonenumber,SomeHolidays, avatar) VALUES(:empid,:fname,:lname,:fullname,:email,:password,:gender,:dob,:department,:address,:city,:country,:status,:phonenumber,:some_holidays, :avatar)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':empid', $empid, PDO::PARAM_STR);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':lname', $lname, PDO::PARAM_STR);
        $query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':department', $department, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':some_holidays', $some_holidays, PDO::PARAM_STR);
        $query->bindParam(':avatar', $avatar, PDO::PARAM_STR);
        $query->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $msg = "Employee record added Successfully";
        } else {
            var_dump($query->errorInfo());
            $error = "Something went wrong. Please try again";
        }

    }

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>

        <!-- Title -->
        <title>Admin | Add Employee</title>

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
        <script type="text/javascript">
            function valid() {
                if (document.addemp.password.value != document.addemp.confirmpassword.value) {
                    alert("New Password and Confirm Password Field do not match  !!");
                    document.addemp.confirmpassword.focus();
                    return false;
                }
                return true;
            }
        </script>

        <script>
            function checkAvailabilityEmpid() {
                $("#loaderIcon").show();
                jQuery.ajax({
                    url: "check_availability.php",
                    data: 'empcode=' + $("#empcode").val(),
                    type: "POST",
                    success: function (data) {
                        $("#empid-availability").html(data);
                        $("#loaderIcon").hide();
                    },
                    error: function () {
                    }
                });
            }
        </script>

        <script>
            function checkAvailabilityEmailid() {
                $("#loaderIcon").show();
                jQuery.ajax({
                    url: "check_availability.php",
                    data: 'emailid=' + $("#email").val(),
                    type: "POST",
                    success: function (data) {
                        $("#emailid-availability").html(data);
                        $("#loaderIcon").hide();
                    },
                    error: function () {
                    }
                });
            }
        </script>


    </head>
    <body>
    <?php include('includes/header.php'); ?>

    <?php include('includes/sidebar.php'); ?>
    <main class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="page-title">Add employee</div>
            </div>
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <form id="example-form" method="post" name="addemp" enctype="multipart/form-data">
                            <div>
                                <h3>Employee Info</h3>
                                <section>
                                    <div class="wizard-content">
                                        <div class="row">
                                            <div class="col m6">
                                                <div class="row">
                                                    <?php if ($error) { ?>
                                                        <div class="errorWrap"><strong>ERROR</strong>
                                                        :<?php echo htmlentities($error); ?>
                                                        </div><?php } else if ($msg) { ?>
                                                        <div class="succWrap"><strong>SUCCESS</strong>
                                                        :<?php echo htmlentities($msg); ?> </div><?php } ?>


                                                    <div class="input-field col  s12">
                                                        <label for="empcode">Employee Code(Must be unique)</label>
                                                        <input name="empcode" id="empcode"
                                                               onBlur="checkAvailabilityEmpid()" type="text"
                                                               autocomplete="off" required>
                                                        <span id="empid-availability" style="font-size:12px;"></span>
                                                    </div>


                                                    <div class="input-field col m6 s12">
                                                        <label for="firstName">First name</label>
                                                        <input id="firstName" name="firstName" type="text" required>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="lastName">Last name</label>
                                                        <input id="lastName" name="lastName" type="text"
                                                               autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col s12">
                                                        <label for="email">Email</label>
                                                        <input name="email" type="email" id="email"
                                                               onBlur="checkAvailabilityEmailid()" autocomplete="off"
                                                               required>
                                                        <span id="emailid-availability" style="font-size:12px;"></span>
                                                    </div>

                                                    <div class="input-field col s12">
                                                        <label for="password">Password</label>
                                                        <input id="password" name="password" type="password"
                                                               autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col s12">
                                                        <label for="confirm">Confirm password</label>
                                                        <input id="confirm" name="confirmpassword" type="password"
                                                               autocomplete="off" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col m6">
                                                <div class="row">
                                                    <div class="input-field col m6 s12">
                                                        <select name="gender" autocomplete="off">
                                                            <option value="">Gender...</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="birthdate">Birthdate</label>
                                                        <input id="birthdate" name="dob" type="date" class="datepicker"
                                                               autocomplete="off">
                                                    </div>


                                                    <div class="input-field col m6 s12">
                                                        <select name="department" autocomplete="off">
                                                            <option value="">Department...</option>
                                                            <?php $sql = "SELECT DepartmentName from tbldepartments";
                                                            $query     = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            $cnt     = 1;
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) { ?>
                                                                    <option value="<?php echo htmlentities($result->DepartmentName); ?>"><?php echo htmlentities($result->DepartmentName); ?></option>
                                                                <?php }
                                                            } ?>
                                                        </select>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="address">Address</label>
                                                        <input id="address" name="address" type="text"
                                                               autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="city">City/Town</label>
                                                        <input id="city" name="city" type="text" autocomplete="off"
                                                               required>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="country">Country</label>
                                                        <input id="country" name="country" type="text"
                                                               autocomplete="off" required>
                                                    </div>


                                                    <div class="input-field col s12">
                                                        <label for="phone">Phone Number</label>
                                                        <input id="phonenumber" name="phonenumber" type="text"
                                                               maxlength="10" autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col s12">
                                                        <label for="phone">Total Leave</label>
                                                        <input id="some_holidays" name="some_holidays" type="number"
                                                               maxlength="10" autocomplete="off" required>
                                                    </div>
                                                    <div class="input-field col s12">
                                                        <div class="form-group">
                                                            <i class="fa fa-file-image-o"></i> Profile Picture
                                                            <input type="file" accept="image/*" name="avatar" class="form-control">
                                                        </div>
                                                    </div>


                                                    <div class="input-field col s12">
                                                        <button type="submit" name="add" onclick="return valid();"
                                                                id="add"
                                                                class="waves-effect waves-light btn indigo m-b-xs">ADD
                                                        </button>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>


                                </section>
                            </div>
                        </form>
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