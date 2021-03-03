<aside id="slide-out" class="side-nav white fixed">
    <div class="side-nav-wrapper">
        <div class="sidebar-profile">
            <div class="sidebar-profile-image">
                <img src="<?= $_SESSION['avatar'] ?>" class="circle" alt="">
            </div>
            <div class="sidebar-profile-info">

                <p><?= $_SESSION['alogin'] ?></p>


            </div>
        </div>

        <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
            <li class="no-padding"><a class="waves-effect waves-grey" href="dashboard.php"><i class="material-icons">settings_input_svideo</i>Dashboard</a>
            </li>
            <li class="no-padding"><a class="waves-effect waves-grey" href="changepassword.php"><i class="material-icons">settings_input_svideo</i>ChangePassword</a>
            </li>
            <?php if($_SESSION['level'] == 2) :?>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">apps</i>Admin<i
                            class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="addadmin.php">Add Admin</a></li>
                        <li><a href="listadmin.php">Manage Admin</a></li>
                    </ul>
                </div>
            </li>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">apps</i>Department<i
                            class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="adddepartment.php">Add Department</a></li>
                        <li><a href="managedepartments.php">Manage Department</a></li>
                    </ul>
                </div>
            </li>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">code</i>Leave Type<i
                            class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="addleavetype.php">Add Leave Type</a></li>
                        <li><a href="manageleavetype.php">Manage Leave Type</a></li>
                    </ul>
                </div>
            </li>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">account_box</i>Employees<i
                            class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="addemployee.php">Add Employee</a></li>
                        <li><a href="manageemployee.php">Manage Employee</a></li>

                    </ul>
                </div>
            </li>

            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">desktop_windows</i>Leave
                    Management<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="leaves.php">All Leaves </a></li>
                        <li><a href="pending-leavehistory.php">Pending Leaves </a></li>
                        <li><a href="approvedleave-history.php">Approved Leaves</a></li>
                        <li><a href="notapproved-leaves.php">Not Approved Leaves</a></li>

                    </ul>
                </div>
            </li>

            <?php else :?>
                <li class="no-padding">
                    <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">desktop_windows</i>Leave
                        Management<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="leaves.php">All Leaves </a></li>
                            <li><a href="pending-leavehistory.php">Pending Leaves </a></li>
                            <li><a href="approvedleave-history.php">Approved Leaves</a></li>
                            <li><a href="notapproved-leaves.php">Not Approved Leaves</a></li>

                        </ul>
                    </div>
                </li>
            <?php endif ; ?>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">apps</i>Leaves<i
                            class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="apply-leave.php">Apply Leave</a></li>
                        <li><a href="leavehistory.php">Leave History</a></li>
                    </ul>
                </div>
            </li>
            <li class="no-padding">
                <a class="waves-effect waves-grey" href="logout.php"><i class="material-icons">exit_to_app</i>Sign
                    Out</a>
            </li>


        </ul>
    </div>
</aside>