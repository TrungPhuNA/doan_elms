<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['apply'])) {
        $empid       = 3;
        $leavetype   = $_POST['leavetype'];
        $fromdate    = $_POST['fromdate'];
        $todate      = $_POST['todate'];
        $description = $_POST['description'];
        $status      = 0;
        $isread      = 0;
        $id = intval($_GET['id']);
        if ($fromdate > $todate) {
            $error = " ToDate should be greater than FromDate ";
        }
        $sql   = "UPDATE  tblleaves set LeaveType=:leavetype, ToDate=:todate, FromDate=:fromdate, Description=:description, Status=:status, IsRead=:isread, empid=:empid  where id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
        $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
        $query->bindParam(':todate', $todate, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':isread', $isread, PDO::PARAM_STR);
        $query->bindParam(':empid', $empid, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_STR);

        $query->execute();
        $count = $query->rowCount();

        if ($count == 1) {
            $msg = "Leave applied successfully";
        } else {
            $error = "Error !";
        }


    }

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>

        <!-- Title -->
        <title>Employee | Apply Leave</title>

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
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css"
              integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw=="
              crossorigin="anonymous"/>
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
                <div class="page-title">Apply for Leave</div>
            </div>
            <div class="col s12 m12 l8">
                <div class="card">
                    <div class="card-content">

                        <?php
                        $lid   = intval($_GET['id']);
                        $sql   = "SELECT * from tblleaves where id=:lid";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':lid', $lid, PDO::PARAM_STR);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt     = 1;
                        if ($query->rowCount() > 0) {
                            foreach ($results

                                     as $resultLeave) { ?>

                                <form id="example-form" method="post" name="addemp" autocomplete="false">
                                    <div>
                                        <h3>Edit for Leave</h3>
                                        <section>
                                            <div class="wizard-content">
                                                <div class="row">
                                                    <div class="col m12">
                                                        <div class="row">
                                                            <?php if ($error) { ?>
                                                                <div class="errorWrap"><strong>ERROR </strong>
                                                                :<?php echo htmlentities($error); ?>
                                                                </div><?php } else if ($msg) { ?>
                                                                <div class="succWrap"><strong>SUCCESS</strong>
                                                                :<?php echo htmlentities($msg); ?> </div><?php } ?>


                                                            <div class="input-field col  s12">
                                                                <select name="leavetype" autocomplete="off">
                                                                    <option value="">Select leave type...</option>
                                                                    <?php $sql = "SELECT  LeaveType from tblleavetype";
                                                                    $query     = $dbh->prepare($sql);
                                                                    $query->execute();
                                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                                    $cnt     = 1;
                                                                    if ($query->rowCount() > 0) {
                                                                        foreach ($results as $result) { ?>
                                                                            <option value="<?php echo htmlentities($result->LeaveType); ?>" <?= htmlentities($resultLeave->LeaveType) == htmlentities($result->LeaveType) ? "selected" : "" ?>><?php echo htmlentities($result->LeaveType); ?></option>
                                                                        <?php }
                                                                    } ?>
                                                                </select>
                                                            </div>


                                                            <div class="input-field col m6 s12">
                                                                <label for="fromdate">From Date</label>
                                                                <input placeholder="" id="mask1" name="fromdate"
                                                                       class="masked datetimepicker" type="text"
                                                                       value="<?= htmlentities($resultLeave->ToDate) ?>"
                                                                       data-inputmask="'alias': 'date'" required>
                                                            </div>
                                                            <div class="input-field col m6 s12">
                                                                <label for="todate">To Date</label>
                                                                <input placeholder="" id="mask1" name="todate"
                                                                       class="masked datetimepicker"
                                                                       type="text" data-inputmask="'alias': 'date'"
                                                                       required
                                                                       value="<?= htmlentities($resultLeave->FromDate) ?>">
                                                            </div>
                                                            <div class="input-field col m12 s12">
                                                                <label for="description">Reason</label>

                                                                <textarea id="textarea1" name="description"
                                                                          class="materialize-textarea"
                                                                          length="500"
                                                                          required><?= htmlentities($resultLeave->Description) ?></textarea>
                                                            </div>

                                                        </div>
                                                        <button type="submit" name="apply" id="apply"
                                                                class="waves-effect waves-light btn indigo m-b-xs">
                                                            Update
                                                        </button>

                                                    </div>
                                                </div>
                                        </section>


                                        </section>
                                    </div>
                                </form>
                            <?php }
                        } ?>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
            integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.js"
            integrity="sha512-9yoLVdmrMyzsX6TyGOawljEm8rPoM5oNmdUiQvhJuJPTk1qoycCK7HdRWZ10vRRlDlUVhCA/ytqCy78+UujHng=="
            crossorigin="anonymous"></script>
    <script>
        $(function () {
            jQuery.datetimepicker.setLocale('vi');
            jQuery.datetimepicker.setDateFormatter({
                parseDate: function (date, format) {
                    var d = moment(date, format);
                    return d.isValid() ? d.toDate() : false;
                },
                formatDate: function (date, format) {
                    return moment(date).format(format);
                }
            });
            $('.datetimepicker').datetimepicker({
                format: "YYYY-M-D H:mm:00",
                formatTime: 'H:mm',
                formatDate: 'Y-mm-d',
                enabledHours: [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
                step: 60,
                allowTimes: [
                    '8:00', '9:00', '10:00', '11:00', '12:00',
                    '14:00', '15:05', '16:20', '17:00', '18:00'
                ]
            });
        })
    </script>

    </body>
    </html>
<?php } ?>