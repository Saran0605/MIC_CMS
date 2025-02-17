<?php

require 'config.php';
include("session.php");

$query = "SELECT * FROM sbasic WHERE sid='$s'";
$query_run = mysqli_query($db, $query);

if (mysqli_num_rows($query_run) == 1) {
    $student = mysqli_fetch_array($query_run);

    if ($student['pphoto'] == "") {
        $k = ".\assets\images\images.jpg";
    } else {
        $k = $student['pphoto'];
        $type = pathinfo($k, PATHINFO_EXTENSION);
        $data = file_get_contents($k);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }


    if ($student['fphoto'] == "") {
        $fa = ".\assets\images\images.jpg";
    } else {
        $fa = $student['fphoto'];
        $type1 = pathinfo($fa, PATHINFO_EXTENSION);
        $data1 = file_get_contents($fa);
        $base641 = 'data:image/' . $type1 . ';base64,' . base64_encode($data1);
    }


    if ($student['mphoto'] == "") {
        $mo = ".\assets\images\images.jpg";
    } else {
        $mo = $student['mphoto'];
        $type2 = pathinfo($mo, PATHINFO_EXTENSION);
        $data2 = file_get_contents($mo);
        $base642 = 'data:image/' . $type2 . ';base64,' . base64_encode($data2);
    }



    $n = $student['fname'] . ' ' . $student['lname'];
    $batch = $student['batch'];
    $de = $student['programme'];
    $dep = $student['department'];
    $g = $student['gender'];
    $e = $student['email'];
    $d2 = $student['dob'];
    $exp = explode('-', $d2);
    $newStr = trim($exp[2]) . ' - ' . trim($exp[1]) . ' - ' . trim($exp[0]);
    $dob = $newStr;
    $blood = $student['blood'];
    $m = $student['mobile'];
    $a = $student['paddress'] . ',' . $student['city'] . '-' . $student['zip'];
    $ta = $student['taddress'];
    $lang = $student['languages'];
    $hstl = $student['room'];
    $aadhar = $student['aadhar'];
} else {

    $n = " ";
    $de = " ";
    $k = "images/user.png";
    $fa = "images/dad.png";
    $mo = "images/women.png";
    $dep = " ";
    $g = " ";
    $e = " ";
    $dob = " ";
    $m = " ";
    $a = " ";
    $batch = " ";
    $ta = " ";
    $lang = " ";
    $blood = " ";
    $hstl = "NA";
    $aadhar = "NA";
}





?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIC</title>
    <link rel="icon" type="image/png" sizes="32x32" href="image/icons/mkce_s.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-5/bootstrap-5.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
            --topbar-height: 60px;
            --footer-height: 60px;
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --dark-bg: #1a1c23;
            --light-bg: #f8f9fc;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* General Styles with Enhanced Typography */

        /* Content Area Styles */
        .content {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        /* Content Navigation */
        .content-nav {
            background: linear-gradient(45deg, #4e73df, #1cc88a);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .content-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 20px;
            overflow-x: auto;
        }

        .content-nav li a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .content-nav li a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar.collapsed+.content {
            margin-left: var(--sidebar-collapsed-width);
        }








        td {
            text-align: left;
            font-size: 0.9em;
            vertical-align: middle;
            /* For vertical alignment */
        }






        /* Responsive Styles */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width) !important;
            }

            .sidebar.mobile-show {
                transform: translateX(0);
            }

            .topbar {
                left: 0 !important;
            }

            .mobile-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display: none;
            }

            .mobile-overlay.show {
                display: block;
            }

            .content {
                margin-left: 0 !important;
            }

            .brand-logo {
                display: block;
            }

            .user-profile {
                margin-left: 0;
            }

            .sidebar .logo {
                justify-content: center;
            }

            .sidebar .menu-item span,
            .sidebar .has-submenu::after {
                display: block !important;
            }

            body.sidebar-open {
                overflow: hidden;
            }

            .footer {
                left: 0 !important;
            }

            .content-nav ul {
                flex-wrap: nowrap;
                overflow-x: auto;
                padding-bottom: 5px;
            }

            .content-nav ul::-webkit-scrollbar {
                height: 4px;
            }

            .content-nav ul::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.3);
                border-radius: 2px;
            }
        }

        .container-fluid {
            padding: 20px;
        }


        /* loader */
        .loader-container {
            position: fixed;
            left: var(--sidebar-width);
            right: 0;
            top: var(--topbar-height);
            bottom: var(--footer-height);
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            /* Changed from 'none' to show by default */
            justify-content: center;
            align-items: center;
            z-index: 1000;
            transition: left 0.3s ease;
        }

        .sidebar.collapsed+.content .loader-container {
            left: var(--sidebar-collapsed-width);
        }

        @media (max-width: 768px) {
            .loader-container {
                left: 0;
            }
        }

        /* Hide loader when done */
        .loader-container.hide {
            display: none;
        }

        /* Loader Animation */
        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-radius: 50%;
            border-top: 5px solid var(--primary-color);
            border-right: 5px solid var(--success-color);
            border-bottom: 5px solid var(--primary-color);
            border-left: 5px solid var(--success-color);
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Hide content initially */
        .content-wrapper {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Show content when loaded */
        .content-wrapper.show {
            opacity: 1;
        }

        .custom-gradient {
            background: linear-gradient(to bottom, rgb(255, 255, 255), #00f2fe);
            /* Vertical gradient */
            padding: 10px 15px;
            /* Adjust padding as needed */
            border-radius: 5px;
            /* Optional: Rounded corners */
        }

        .custom-table {
            border-radius: 10px;
        }

        
        .breadcrumb-area {
            background-image: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            margin: 20px;
            padding: 15px 20px;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb-item a:hover {
            color: #224abe;
        }
        .gradient-header {
            --bs-table-bg: transparent;
            --bs-table-color: white;
            background: linear-gradient(135deg, #4CAF50, #2196F3) !important;

            text-align: center;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content">

        <div class="loader-container" id="loaderContainer">
            <div class="loader"></div>
        </div>

        <!-- Topbar -->
        <?php include 'topbar.php'; ?>

        <!-- Breadcrumb -->
        <div class="breadcrumb-area custom-gradient">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">

                    <li class="breadcrumb-item active" aria-current="page">Dashboard (Welcome <?php echo $s; ?>)</li>
                </ol>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="container-fluid">
                <div class="main-body">

                    <!-- Breadcrumb -->

                                <!--
                    <nav aria-label="breadcrumb" class="main-breadcrumb">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                        </ol>
                    </nav>
                    /Breadcrumb -->

                    <div class="row gutters-sm">
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body colr">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <!-- <img src=".\assets\images\profile\1152018.jpg" alt="Admin" class="rounded-circle" width="150"> -->
                                        <img src="<?php echo $base64; ?>" alt="" class="rounded-circle test" width="150">
                                        <div class="mt-3">
                                            <h4><?php echo $n; ?></h4>
                                            <p class="text-white mb-1"><?php echo $de; ?></p>
                                            <p class="text-white font-size-sm"><?php echo $dep; ?></p>
                                            <p class="text-warning font-size-sm"><b><?php echo $batch; ?></b></p>
                                            <hr>
                                            <img src="<?php echo $base641; ?>" alt="" class="rounded-circle test"
                                                width="150"> &nbsp;&nbsp;&nbsp;&nbsp;

                                            <img src="<?php echo $base642; ?>" alt="" class="rounded-circle test"
                                                width="150">

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card mt-3">

                            </div>



                        </div>
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Full Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $n; ?>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Register Number</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $s; ?>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Gender</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $g; ?>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0"> Date of Birth</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $dob; ?>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0"> Blood Group</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $blood; ?>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Mobile</h6>
                                        </div>
                                        <div class="col-sm-3 text-secondary">
                                            <?php echo $m; ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-3 text-secondary">
                                            <?php echo $e; ?>
                                        </div>
                                    </div>
                                    <hr>



                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Language Known</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $lang; ?>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Communication Address</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $ta; ?>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Permanent Address</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $a; ?>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Aadhar Number</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $aadhar; ?>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Hostel Room</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $hstl; ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <div class="card h-100">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title m-b-0"><u>Educational Details</u></h5>
                                    </div>
                                    <table class="table">
                                        <thead class="gradient-header">
                                            <tr>
                                                <th scope="col"><b>Course</b></th>

                                                <th scope="col"><b>Institution</b></th>

                                                <th scope="col"><b>Board</b></th>
                                                <th scope="col"><b>Medium of study</b></th>
                                                <th scope="col"><b>Year</b></th>

                                                <th scope="col"><b>Percentage</b></th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $records = mysqli_query($db, "select *from sacademic where sid='$s'");
                                        while ($data = mysqli_fetch_array($records)) {
                                        ?>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $data['course']; ?></td>

                                                    <td><?php echo $data['iname']; ?></td>

                                                    <td><?php echo $data['board']; ?></td>
                                                    <td><?php echo $data['mos']; ?></td>
                                                    <td><?php echo $data['yc']; ?></td>

                                                    <td><?php echo $data['score']; ?>%</td>
                                                </tr>
                                            </tbody>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <!-- family Start -->

                        <div class="col-sm-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><u>Family Details</u></h5>
                                    <div class="table-responsive">
                                        <table id="zero_config1" class="table table-striped table-bordered">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>S.No</b></th>
                                                    <th><b>Name</b></th>
                                                    <th><b>Gender</b></th>
                                                    <th><b>Relationship</b></th>
                                                    <th><b>Occupation</b></th>
                                                    <th><b>Organization</b></th>
                                                    <th><b>Mobile</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query2 = "SELECT * FROM sfamily where sid='$s'";
                                                $query_run2 = mysqli_query($db, $query2);

                                                if (mysqli_num_rows($query_run2) > 0) {
                                                    $sn = 1;
                                                    foreach ($query_run2 as $student2) {
                                                ?>

                                                        <tr>
                                                            <td><?php echo $sn; ?></td>
                                                            <td><?= $student2['name'] ?></td>
                                                            <td><?= $student2['gender'] ?></td>
                                                            <td><?= $student2['relationship'] ?></td>
                                                            <td><?= $student2['occu'] ?></td>
                                                            <td><?= $student2['org'] ?></td>
                                                            <td><?= $student2['mobile'] ?></td>



                                                            </td>

                                                        </tr>

                                                <?php
                                                        $sn = $sn + 1;
                                                    }
                                                }
                                                ?>
                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- family end -->

                        <!-- exp Start -->

                        <!-- <div class="col-sm-12 mb-3">

                            <div class="modal fade" id="studentViewModal4" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">View Prizes</h5>
                                            <button type="button" class="btn" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <i class="mdi mdi-close"></i> 
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img id="imagepr" src="" alt="prizes" class="center"
                                                style="width:80%;height:80%;">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><u>Prizes / Awards Details</u></h5>
                                    <div class="table-responsive">
                                        <table id="zero_config" class="table table-striped table-bordered">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>S.No</b></th>
                                                    <th><b>Name of the event</b></th>
                                                    <th><b>Level</b></th>
                                                    <th><b>Organizer</b></th>
                                                    <th><b>Prize</b></th>
                                                    <th><b>View</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                $query = "SELECT * FROM sprize where sid='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    $sn = 1;
                                                    foreach ($query_run as $student) {

                                                ?>
                                                        <tr>
                                                            <td><?= $sn ?></td>
                                                            <td><?= $student['event'] ?></td>
                                                            <td><?= $student['level'] ?></td>
                                                            <td><?= $student['organiser'] ?></td>
                                                            <td><?= $student['prize'] ?></td>
                                                            <td align="center"><button type="button" id="ledonof"
                                                                    value="<?= $student['uid']; ?>"
                                                                    class="btnimgpr btn-success btn-sm" data-bs-toggle="modal"
                                                                    data-bs-target="#studentViewModal4">View</button></td>

                                                        </tr>
                                                        <?php
                                                        $sn = $sn + 1;
                                                    }
                                                }
                                                        ?>

                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div> -->

                        <!-- exp end -->

                        <!-- posting Start -->

                        <div class="col-sm-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><u>Parents-Meeting Details</u></h5>
                                    <div class="table-responsive">
                                        <table id="zero_config2" class="table table-striped table-bordered">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>S.No</b></th>
                                                    <th><b>Date</b></th>
                                                    <th><b>Purpose of Meeting</b></th>
                                                    <th><b>Suggestions</b></th>
                                                    <th><b>Status</b>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php


                                                $query = "SELECT * FROM parentmeeting where sid='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    $sn = 1;
                                                    foreach ($query_run as $student) {
                                                ?>
                                                        <tr>
                                                            <td><?= $sn ?></td>
                                                            <td><?= $student['datee'] ?></td>
                                                            <td><?= $student['purpose'] ?></td>
                                                            <td><?= $student['suggestion'] ?></td>

                                                            <td><?php if ($student['status'] == 0): ?>
                                                                    <span class="btn btn-warning">Pending</span>
                                                                <?php elseif ($student['status'] == 1): ?>
                                                                    <span class="btn btn-success">Approved</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        $sn++;
                                                    }
                                                }
                                                ?>

                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- posting end -->


                        <!-- Training Start -->

                        <div class="col-sm-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><u>Counselling Details</u></h5>
                                    <div class="table-responsive">
                                        <table id="zero_config3" class="table table-striped table-bordered">
                                            <thead class="gradient-header">
                                                <th><b>S.No</b></th>
                                                <th><b>Date</b></th>
                                                <th><b>FeedBack</b></th>
                                                <th><b>Actions Taken</b></th>
                                                <th><b>Status</b></th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT * FROM counselling where sid='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    $sss = 1;
                                                    foreach ($query_run as $student) {
                                                        $actionsValue = $student['actions'];
                                                        $buttonText = ($actionsValue == 0) ? 'Pending' : 'Verified';
                                                        $buttonClass = ($actionsValue == 0) ? 'btn-warning' : 'btn-success';
                                                ?>
                                                        <tr>
                                                            <td><?= $sss ?></td>
                                                            <td><?= $student['datee'] ?></td>
                                                            <td><?= $student['feedback'] ?></td>
                                                            <td><?= $student['actions'] ?></td>

                                                            <td><?php if ($student['status'] == 0): ?>
                                                                    <span class="btn btn-warning btn-sm">Pending</span>
                                                                <?php elseif ($student['status'] == 1): ?>
                                                                    <span class="btn btn-success">Approved</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        $sss = $sss + 1;
                                                    }
                                                }
                                                ?>
                                            </tbody>


                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- training end -->

                        <!-- Projects Start -->

                        <div class="col-sm-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><u>Projects Done</u></h5>
                                    <div class="table-responsive">
                                        <table id="zero_config4" class="table table-striped table-bordered">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>S.No</b></th>
                                                    <th><b>Semester</b></th>
                                                    <th><b>Title of the project</b></th>
                                                    <th><b>Github link</b></th>
                                                    <th><b>Remarks</b></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php


                                                $query = "SELECT * FROM sproject WHERE sid='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    $sn = 1;
                                                    foreach ($query_run as $student) {

                                                ?>
                                                        <tr>
                                                            <td><?= $sn ?></td>
                                                            <td><?= $student['semester'] ?></td>
                                                            <td><?= $student['title'] ?></td>
                                                            <td><?= $student['github'] ?></td>
                                                            <td><?= $student['remark'] ?></td>

                                                        </tr>
                                                <?php
                                                        $sn = $sn + 1;
                                                    }
                                                }
                                                ?>

                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>




                        <!-- internship Start -->

                        <div class="col-sm-12 mb-3">

                            <div class="modal fade" id="studentViewModali" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">View Certificate</h5>
                                            <button type="button" class="btn" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <i class="mdi mdi-close"></i> <!-- Font Awesome close icon -->
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img id="imagei" src="" alt="prizes" class="center"
                                                style="width:80%;height:80%;">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><u>Online / Internship / Course Certification Details</u>
                                    </h5>
                                    <div class="table-responsive">
                                        <table id="zero_config5" class="table table-striped table-bordered">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>S.No</b></th>
                                                    <th><b>Name of the Program / Title</b></th>
                                                    <th><b>Type</b></th>
                                                    <th><b>Organizer</b></th>
                                                    <th><b>Duration</b></th>
                                                    <th><b>Remarks</b></th>
                                                    <th><b>View</b></th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                $query = "SELECT * FROM sintern where sid='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    $sn = 1;
                                                    foreach ($query_run as $student) {

                                                ?>
                                                        <tr>
                                                            <td><?= $sn ?></td>
                                                            <td><?= $student['iname'] ?></td>
                                                            <td><?= $student['type'] ?></td>
                                                            <td><?= $student['org'] ?></td>
                                                            <td><?= $student['dur'] ?></td>
                                                            <td><?= $student['rem'] ?></td>
                                                            <td align="center"><button type="button" id="ledonof"
                                                                    value="<?= $student['uid']; ?>"
                                                                    class="btnimgi btn-success btn-sm" data-bs-toggle="modal"
                                                                    data-bs-target="#studentViewModali">View</button></td>

                                                        </tr>
                                                <?php
                                                        $sn = $sn + 1;
                                                    }
                                                }
                                                ?>

                                            </tbody>


                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>




                        <!-- co-curricular Start -->

                        <div class="col-sm-12 mb-3">

                            <div class="modal fade" id="studentViewModalco" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">View Certificate</h5>
                                            <button type="button" class="btn" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <i class="mdi mdi-close"></i> <!-- Font Awesome close icon -->
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img id="imageco" src="" alt="Co-Curricular" class="center"
                                                style="width:80%;height:80%;">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><u>Co – Curricular Activity</u></h5>
                                    <div class="table-responsive">
                                        <table id="zero_config6" class="table table-striped table-bordered">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>S.No</b></th>
                                                    <th><b>Name of the event</b></th>
                                                    <th><b>Level</b></th>
                                                    <th><b>Organizer</b></th>
                                                    <th><b>Prize</b></th>
                                                    <th><b>View</b></th>


                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                $query = "SELECT * FROM scocu where sid='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    $sn = 1;
                                                    foreach ($query_run as $student) {

                                                ?>
                                                        <tr>
                                                            <td><?= $sn ?></td>
                                                            <td><?= $student['event'] ?></td>
                                                            <td><?= $student['level'] ?></td>
                                                            <td><?= $student['organiser'] ?></td>
                                                            <td><?= $student['prize'] ?></td>
                                                            <td align="center"><button type="button" id="ledonof"
                                                                    value="<?= $student['uid']; ?>"
                                                                    class="btnimgco btn-success btn-sm" data-bs-toggle="modal"
                                                                    data-bs-target="#studentViewModalco">View</button></td>

                                                        </tr>
                                                <?php
                                                        $sn = $sn + 1;
                                                    }
                                                }
                                                ?>

                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- posting end -->


                        <!-- Training Start -->

                        <div class="col-sm-12 mb-3">

                            <div class="modal fade" id="studentViewModalex" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">View Certificate</h5>
                                            <button type="button" class="btn" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <i class="mdi mdi-close"></i> <!-- Font Awesome close icon -->
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img id="imageex" src="" alt="Co-Curricular" class="center"
                                                style="width:80%;height:80%;">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><u>Extra – Curricular / Extension Activity</u></h5>
                                    <div class="table-responsive">
                                        <table id="zero_config7" class="table table-striped table-bordered">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>S.No</b></th>
                                                    <th><b>Name of the event</b></th>
                                                    <th><b>Level</b></th>
                                                    <th><b>Organizer</b></th>
                                                    <th><b>Prize</b></th>
                                                    <th><b>View</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                $query = "SELECT * FROM st_extra where sid='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    $sn = 1;
                                                    foreach ($query_run as $student) {

                                                ?>
                                                        <tr>
                                                            <td><?= $sn ?></td>
                                                            <td><?= $student['event'] ?></td>
                                                            <td><?= $student['level'] ?></td>
                                                            <td><?= $student['organiser'] ?></td>
                                                            <td><?= $student['prize'] ?></td>
                                                            <td align="center"><button type="button" id="ledonof"
                                                                    value="<?= $student['uid']; ?>"
                                                                    class="btnimgex btn-success btn-sm" data-bs-toggle="modal"
                                                                    data-bs-target="#studentViewModalex">View</button></td>

                                                        </tr>
                                                <?php
                                                        $sn = $sn + 1;
                                                    }
                                                }
                                                ?>

                                            </tbody>


                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- posting Start -->

                        <div class="col-sm-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><u>Assessment Scores</u></h5>
                                    <div class="table-responsive">
                                        <table id="zero_config8" class="table table-striped table-bordered">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>S.No</b></th>
                                                    <th><b>Date</b></th>

                                                    <th><b>HackerRank</b></th>
                                                    <th><b>SkillRack/Codetantra</b></th>
                                                    <th><b>Others</b></th>
                                                    <th><b>Action Taken</b></th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                $query = "SELECT * FROM straining where sid='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    $sn = 1;
                                                    foreach ($query_run as $student) {

                                                ?>
                                                        <tr>
                                                            <td><?= $sn ?></td>
                                                            <td><?= $student['date'] ?></td>
                                                            <td><?= $student['ict'] ?></td>
                                                            <td><?= $student['hack'] ?></td>
                                                            <td><?= $student['skill'] ?></td>
                                                            <td><?= $student['action'] ?> </td>

                                                        </tr>
                                                <?php
                                                        $sn = $sn + 1;
                                                    }
                                                }
                                                ?>

                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- posting end -->


                        <!-- placement Start -->

                        <div class="col-sm-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><u>Placement Details</u></h5>
                                    <div class="table-responsive">
                                        <table id="zero_config9" class="table table-striped table-bordered">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>S.No</b></th>
                                                    <th><b>Date</b></th>
                                                    <th><b>Name of the Company</b></th>
                                                    <th><b>Designation & Salary Package</b></th>
                                                    <th><b>Performance / Result</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php


                                                $query = "SELECT * FROM splacement where sid='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    $sn = 1;
                                                    foreach ($query_run as $student) {

                                                ?>
                                                        <tr>
                                                            <td><?= $sn ?></td>
                                                            <td><?= $student['date'] ?></td>
                                                            <td><?= $student['np'] ?></td>
                                                            <td><?= $student['ds'] ?></td>
                                                            <td><?= $student['pr'] ?></td>

                                                        </tr>
                                                <?php
                                                        $sn = $sn + 1;
                                                    }
                                                }
                                                ?>

                                            </tbody>


                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <!-- MArk Start -->
                        <div class="col-sm-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><u>Exam Marks and Attendance Details</u></h5>

                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs mb-3" role="tablist">
                                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#sem1"
                                                role="tab"><span class="hidden-sm-up"></span> <span
                                                    class="hidden-xs-down"><i class="ti-pencil-alt"></i><b> Semester
                                                        1</b></span></a> </li>

                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#sem2"
                                                role="tab"><span class="hidden-sm-up"></span> <span
                                                    class="hidden-xs-down"><i class="ti-pencil-alt"></i><b> Semester
                                                        2</b></span></a> </li>

                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#sem3"
                                                role="tab"><span class="hidden-sm-up"></span> <span
                                                    class="hidden-xs-down"><i class="ti-pencil-alt"></i><b> Semester
                                                        3</b></span></a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#sem4"
                                                role="tab"><span class="hidden-sm-up"></span> <span
                                                    class="hidden-xs-down"><i class="ti-pencil-alt"></i><b> Semester
                                                        4</b></span></a> </li>

                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#sem5"
                                                role="tab"><span class="hidden-sm-up"></span> <span
                                                    class="hidden-xs-down"><i class="ti-pencil-alt"></i><b> Semester
                                                        5</b></span></a> </li>

                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#sem6"
                                                role="tab"><span class="hidden-sm-up"></span> <span
                                                    class="hidden-xs-down"><i class="ti-pencil-alt"></i><b> Semester
                                                        6</b></span></a> </li>

                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#sem7"
                                                role="tab"><span class="hidden-sm-up"></span> <span
                                                    class="hidden-xs-down"><i class="ti-pencil-alt"></i><b> Semester
                                                        7</b></span></a> </li>

                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#sem8"
                                                role="tab"><span class="hidden-sm-up"></span> <span
                                                    class="hidden-xs-down"><i class="ti-pencil-alt"></i><b> Semester
                                                        8</b></span></a> </li>

                                    </ul>

                                    <!--tab conetent -->

                                    <div class="tab-content tabcontent-border">


                                        <!-- Tab 1 -->
                                        <div class="tab-pane active p-20" id="sem1" role="tabpanel">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>Semester 1 Exam Details

                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="myTables1ms1"
                                                                    class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th><b>S.No</b></th>
                                                                            <th><b>Subject Name</b></th>
                                                                            <th><b>MS 1</b></th>
                                                                            <th><b>MS 2</b></th>
                                                                            <th><b>Preparatory</b></th>
                                                                            <th><b>Semester</b></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        <?php

                                                                        $query = "SELECT * FROM ss1 where sid='$s'";
                                                                        $query_run = mysqli_query($db, $query);

                                                                        if (mysqli_num_rows($query_run) > 0) {
                                                                            $sn = 1;
                                                                            foreach ($query_run as $student) {

                                                                        ?>
                                                                                <tr>
                                                                                    <td><?= $sn ?></td>
                                                                                    <td><?= $student['sname'] ?></td>



                                                                                    <td><?= $student['ms1'] ?></td>
                                                                                    <td><?= $student['ms2'] ?></td>
                                                                                    <td><?= $student['prep'] ?></td>
                                                                                    <td align="center"><?= $student['sem'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $sn = $sn + 1;
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- CGAP/SGPA/Attendance -->

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>SGPA /CGPA / Attendance
                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="sem1sgpa"
                                                                    class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th><b>SGPA</b></th>
                                                                            <th><b>CGPA</b></th>
                                                                            <th><b>Current Arrear</b></th>
                                                                            <th><b>Overall Arrear</b></th>
                                                                            <th><b>MS 1-Attendance</b></th>
                                                                            <th><b>MS 2-Attendance</b></th>
                                                                            <th><b>Prep-Attendance </b></th>
                                                                            <th><b>Overall-Attendance</b></th>
                                                                        </tr>

                                                                    </thead>
                                                                    <tbody>

                                                                        <?php

                                                                        $query = "SELECT * FROM sgrade where sid='$s' and sem='1'";
                                                                        $query_run = mysqli_query($db, $query);

                                                                        if (mysqli_num_rows($query_run) > 0) {
                                                                            $sn = 1;
                                                                            foreach ($query_run as $student) {

                                                                        ?>
                                                                                <tr>

                                                                                    <td><?= $student['sgpa'] ?></td>



                                                                                    <td><?= $student['cgpa'] ?></td>
                                                                                    <td><?= $student['CA'] ?></td>



                                                                                    <td><?= $student['OA'] ?></td>


                                                                                    <td><?= $student['ms1a'] ?></td>
                                                                                    <td><?= $student['ms2a'] ?></td>
                                                                                    <td align="center"><?= $student['prepa'] ?>
                                                                                    </td>
                                                                                    <td align="center"><?= $student['ova'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $sn = $sn + 1;
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <!-- Tab 1 end -->


                                        <!-- Tab 2 -->
                                        <div class="tab-pane  p-20" id="sem2" role="tabpanel">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>Semester 2 Exam Details

                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="myTables1ms1"
                                                                    class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th><b>S.No</b></th>
                                                                            <th><b>Subject Name</b></th>
                                                                            <th><b>MS 1</b></th>
                                                                            <th><b>MS 2</b></th>
                                                                            <th><b>Preparatory</b></th>
                                                                            <th><b>Semester</b></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        <?php

                                                                        $query = "SELECT * FROM ss2 where sid='$s'";
                                                                        $query_run = mysqli_query($db, $query);

                                                                        if (mysqli_num_rows($query_run) > 0) {
                                                                            $sn = 1;
                                                                            foreach ($query_run as $student) {

                                                                        ?>
                                                                                <tr>
                                                                                    <td><?= $sn ?></td>
                                                                                    <td><?= $student['sname'] ?></td>



                                                                                    <td><?= $student['ms1'] ?></td>
                                                                                    <td><?= $student['ms2'] ?></td>
                                                                                    <td><?= $student['prep'] ?></td>
                                                                                    <td align="center"><?= $student['sem'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $sn = $sn + 1;
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- CGAP/SGPA/Attendance -->

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>SGPA /CGPA / Attendance
                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="sem1sgpa"
                                                                    class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th><b>SGPA</b></th>
                                                                            <th><b>CGPA</b></th>
                                                                            <th><b>Current Arrear</b></th>
                                                                            <th><b>Overall Arrear</b></th>
                                                                            <th><b>MS 1-Attendance</b></th>
                                                                            <th><b>MS 2-Attendance</b></th>
                                                                            <th><b>Prep-Attendance </b></th>
                                                                            <th><b>Overall-Attendance</b></th>
                                                                        </tr>

                                                                    </thead>
                                                                    <tbody>

                                                                        <?php

                                                                        $query = "SELECT * FROM sgrade where sid='$s' and sem='2'";
                                                                        $query_run = mysqli_query($db, $query);

                                                                        if (mysqli_num_rows($query_run) > 0) {
                                                                            $sn = 1;
                                                                            foreach ($query_run as $student) {

                                                                        ?>
                                                                                <tr>

                                                                                    <td><?= $student['sgpa'] ?></td>



                                                                                    <td><?= $student['cgpa'] ?></td>
                                                                                    <td><?= $student['CA'] ?></td>



                                                                                    <td><?= $student['OA'] ?></td>


                                                                                    <td><?= $student['ms1a'] ?></td>
                                                                                    <td><?= $student['ms2a'] ?></td>
                                                                                    <td align="center"><?= $student['prepa'] ?>
                                                                                    </td>
                                                                                    <td align="center"><?= $student['ova'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $sn = $sn + 1;
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <!-- Tab 2 end -->


                                        <!-- Tab 3 -->
                                        <div class="tab-pane p-20" id="sem3" role="tabpanel">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>Semester 3 Exam Details

                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="myTables1ms1"
                                                                    class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th><b>S.No</b></th>
                                                                            <th><b>Subject Name</b></th>
                                                                            <th><b>MS 1</b></th>
                                                                            <th><b>MS 2</b></th>
                                                                            <th><b>Preparatory</b></th>
                                                                            <th><b>Semester</b></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        <?php

                                                                        $query = "SELECT * FROM ss3 where sid='$s'";
                                                                        $query_run = mysqli_query($db, $query);

                                                                        if (mysqli_num_rows($query_run) > 0) {
                                                                            $sn = 1;
                                                                            foreach ($query_run as $student) {

                                                                        ?>
                                                                                <tr>
                                                                                    <td><?= $sn ?></td>
                                                                                    <td><?= $student['sname'] ?></td>



                                                                                    <td><?= $student['ms1'] ?></td>
                                                                                    <td><?= $student['ms2'] ?></td>
                                                                                    <td><?= $student['prep'] ?></td>
                                                                                    <td align="center"><?= $student['sem'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $sn = $sn + 1;
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- CGAP/SGPA/Attendance -->

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>SGPA /CGPA / Attendance
                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="sem1sgpa"
                                                                    class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th><b>SGPA</b></th>
                                                                            <th><b>CGPA</b></th>
                                                                            <th><b>Current Arrear</b></th>
                                                                            <th><b>Overall Arrear</b></th>
                                                                            <th><b>MS 1-Attendance</b></th>
                                                                            <th><b>MS 2-Attendance</b></th>
                                                                            <th><b>Prep-Attendance </b></th>
                                                                            <th><b>Overall-Attendance</b></th>
                                                                        </tr>

                                                                    </thead>
                                                                    <tbody>

                                                                        <?php

                                                                        $query = "SELECT * FROM sgrade where sid='$s' and sem='3'";
                                                                        $query_run = mysqli_query($db, $query);

                                                                        if (mysqli_num_rows($query_run) > 0) {
                                                                            $sn = 1;
                                                                            foreach ($query_run as $student) {

                                                                        ?>
                                                                                <tr>

                                                                                    <td><?= $student['sgpa'] ?></td>



                                                                                    <td><?= $student['cgpa'] ?></td>
                                                                                    <td><?= $student['CA'] ?></td>



                                                                                    <td><?= $student['OA'] ?></td>


                                                                                    <td><?= $student['ms1a'] ?></td>
                                                                                    <td><?= $student['ms2a'] ?></td>
                                                                                    <td align="center"><?= $student['prepa'] ?>
                                                                                    </td>
                                                                                    <td align="center"><?= $student['ova'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $sn = $sn + 1;
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <!-- Tab 3 end -->

                                        <!-- Tab 4 -->
                                        <div class="tab-pane p-20" id="sem4" role="tabpanel">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>Semester 4 Exam Details

                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="myTables1ms1"
                                                                    class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th><b>S.No</b></th>
                                                                            <th><b>Subject Name</b></th>
                                                                            <th><b>MS 1</b></th>
                                                                            <th><b>MS 2</b></th>
                                                                            <th><b>Preparatory</b></th>
                                                                            <th><b>Semester</b></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        <?php

                                                                        $query = "SELECT * FROM ss4 where sid='$s'";
                                                                        $query_run = mysqli_query($db, $query);

                                                                        if (mysqli_num_rows($query_run) > 0) {
                                                                            $sn = 1;
                                                                            foreach ($query_run as $student) {

                                                                        ?>
                                                                                <tr>
                                                                                    <td><?= $sn ?></td>
                                                                                    <td><?= $student['sname'] ?></td>



                                                                                    <td><?= $student['ms1'] ?></td>
                                                                                    <td><?= $student['ms2'] ?></td>
                                                                                    <td><?= $student['prep'] ?></td>
                                                                                    <td align="center"><?= $student['sem'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $sn = $sn + 1;
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- CGAP/SGPA/Attendance -->

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>SGPA /CGPA / Attendance
                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="sem1sgpa"
                                                                    class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th><b>SGPA</b></th>
                                                                            <th><b>CGPA</b></th>
                                                                            <th><b>Current Arrear</b></th>
                                                                            <th><b>Overall Arrear</b></th>
                                                                            <th><b>MS 1-Attendance</b></th>
                                                                            <th><b>MS 2-Attendance</b></th>
                                                                            <th><b>Prep-Attendance </b></th>
                                                                            <th><b>Overall-Attendance</b></th>
                                                                        </tr>

                                                                    </thead>
                                                                    <tbody>

                                                                        <?php

                                                                        $query = "SELECT * FROM sgrade where sid='$s' and sem='4'";
                                                                        $query_run = mysqli_query($db, $query);

                                                                        if (mysqli_num_rows($query_run) > 0) {
                                                                            $sn = 1;
                                                                            foreach ($query_run as $student) {

                                                                        ?>
                                                                                <tr>

                                                                                    <td><?= $student['sgpa'] ?></td>



                                                                                    <td><?= $student['cgpa'] ?></td>
                                                                                    <td><?= $student['CA'] ?></td>



                                                                                    <td><?= $student['OA'] ?></td>


                                                                                    <td><?= $student['ms1a'] ?></td>
                                                                                    <td><?= $student['ms2a'] ?></td>
                                                                                    <td align="center"><?= $student['prepa'] ?>
                                                                                    </td>
                                                                                    <td align="center"><?= $student['ova'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $sn = $sn + 1;
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <!-- Tab 4 end -->

                                        <!-- Tab 5 -->
                                        <div class="tab-pane p-20" id="sem5" role="tabpanel">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>Semester 5 Exam Details

                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="myTables1ms1"
                                                                    class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th><b>S.No</b></th>
                                                                            <th><b>Subject Name</b></th>
                                                                            <th><b>MS 1</b></th>
                                                                            <th><b>MS 2</b></th>
                                                                            <th><b>Preparatory</b></th>
                                                                            <th><b>Semester</b></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        <?php

                                                                        $query = "SELECT * FROM ss5 where sid='$s'";
                                                                        $query_run = mysqli_query($db, $query);

                                                                        if (mysqli_num_rows($query_run) > 0) {
                                                                            $sn = 1;
                                                                            foreach ($query_run as $student) {

                                                                        ?>
                                                                                <tr>
                                                                                    <td><?= $sn ?></td>
                                                                                    <td><?= $student['sname'] ?></td>



                                                                                    <td><?= $student['ms1'] ?></td>
                                                                                    <td><?= $student['ms2'] ?></td>
                                                                                    <td><?= $student['prep'] ?></td>
                                                                                    <td align="center"><?= $student['sem'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $sn = $sn + 1;
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- CGAP/SGPA/Attendance -->

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>SGPA /CGPA / Attendance
                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="sem1sgpa"
                                                                    class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th><b>SGPA</b></th>
                                                                            <th><b>CGPA</b></th>
                                                                            <th><b>Current Arrear</b></th>
                                                                            <th><b>Overall Arrear</b></th>
                                                                            <th><b>MS 1-Attendance</b></th>
                                                                            <th><b>MS 2-Attendance</b></th>
                                                                            <th><b>Prep-Attendance </b></th>
                                                                            <th><b>Overall-Attendance</b></th>
                                                                        </tr>

                                                                    </thead>
                                                                    <tbody>

                                                                        <?php

                                                                        $query = "SELECT * FROM sgrade where sid='$s' and sem='5'";
                                                                        $query_run = mysqli_query($db, $query);

                                                                        if (mysqli_num_rows($query_run) > 0) {
                                                                            $sn = 1;
                                                                            foreach ($query_run as $student) {

                                                                        ?>
                                                                                <tr>

                                                                                    <td><?= $student['sgpa'] ?></td>



                                                                                    <td><?= $student['cgpa'] ?></td>
                                                                                    <td><?= $student['CA'] ?></td>



                                                                                    <td><?= $student['OA'] ?></td>


                                                                                    <td><?= $student['ms1a'] ?></td>
                                                                                    <td><?= $student['ms2a'] ?></td>
                                                                                    <td align="center"><?= $student['prepa'] ?>
                                                                                    </td>
                                                                                    <td align="center"><?= $student['ova'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $sn = $sn + 1;
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <!-- Tab 5 end -->

                                        <!-- Tab 6 -->
                                        <div class="tab-pane p-20" id="sem6" role="tabpanel">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>Semester 6 Exam Details

                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="myTables1ms1"
                                                                    class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th><b>S.No</b></th>
                                                                            <th><b>Subject Name</b></th>
                                                                            <th><b>MS 1</b></th>
                                                                            <th><b>MS 2</b></th>
                                                                            <th><b>Preparatory</b></th>
                                                                            <th><b>Semester</b></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        <?php

                                                                        $query = "SELECT * FROM ss6 where sid='$s'";
                                                                        $query_run = mysqli_query($db, $query);

                                                                        if (mysqli_num_rows($query_run) > 0) {
                                                                            $sn = 1;
                                                                            foreach ($query_run as $student) {

                                                                        ?>
                                                                                <tr>
                                                                                    <td><?= $sn ?></td>
                                                                                    <td><?= $student['sname'] ?></td>



                                                                                    <td><?= $student['ms1'] ?></td>
                                                                                    <td><?= $student['ms2'] ?></td>
                                                                                    <td><?= $student['prep'] ?></td>
                                                                                    <td align="center"><?= $student['sem'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $sn = $sn + 1;
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- CGAP/SGPA/Attendance -->

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>SGPA /CGPA / Attendance
                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="sem1sgpa"
                                                                    class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th><b>SGPA</b></th>
                                                                            <th><b>CGPA</b></th>
                                                                            <th><b>Current Arrear</b></th>
                                                                            <th><b>Overall Arrear</b></th>
                                                                            <th><b>MS 1-Attendance</b></th>
                                                                            <th><b>MS 2-Attendance</b></th>
                                                                            <th><b>Prep-Attendance </b></th>
                                                                            <th><b>Overall-Attendance</b></th>
                                                                        </tr>

                                                                    </thead>
                                                                    <tbody>

                                                                        <?php

                                                                        $query = "SELECT * FROM sgrade where sid='$s' and sem='6'";
                                                                        $query_run = mysqli_query($db, $query);

                                                                        if (mysqli_num_rows($query_run) > 0) {
                                                                            $sn = 1;
                                                                            foreach ($query_run as $student) {

                                                                        ?>
                                                                                <tr>

                                                                                    <td><?= $student['sgpa'] ?></td>



                                                                                    <td><?= $student['cgpa'] ?></td>
                                                                                    <td><?= $student['CA'] ?></td>



                                                                                    <td><?= $student['OA'] ?></td>


                                                                                    <td><?= $student['ms1a'] ?></td>
                                                                                    <td><?= $student['ms2a'] ?></td>
                                                                                    <td align="center"><?= $student['prepa'] ?>
                                                                                    </td>
                                                                                    <td align="center"><?= $student['ova'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $sn = $sn + 1;
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <!-- Tab 6 end -->

                                        <!-- Tab 7 -->
                                        <div class="tab-pane p-20" id="sem7" role="tabpanel">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>Semester 7 Exam Details

                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="myTables1ms1"
                                                                    class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th><b>S.No</b></th>
                                                                            <th><b>Subject Name</b></th>
                                                                            <th><b>MS 1</b></th>
                                                                            <th><b>MS 2</b></th>
                                                                            <th><b>Preparatory</b></th>
                                                                            <th><b>Semester</b></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        <?php

                                                                        $query = "SELECT * FROM ss7 where sid='$s'";
                                                                        $query_run = mysqli_query($db, $query);

                                                                        if (mysqli_num_rows($query_run) > 0) {
                                                                            $sn = 1;
                                                                            foreach ($query_run as $student) {

                                                                        ?>
                                                                                <tr>
                                                                                    <td><?= $sn ?></td>
                                                                                    <td><?= $student['sname'] ?></td>



                                                                                    <td><?= $student['ms1'] ?></td>
                                                                                    <td><?= $student['ms2'] ?></td>
                                                                                    <td><?= $student['prep'] ?></td>
                                                                                    <td align="center"><?= $student['sem'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $sn = $sn + 1;
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- CGAP/SGPA/Attendance -->

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>SGPA /CGPA / Attendance
                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="sem1sgpa"
                                                                    class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th><b>SGPA</b></th>
                                                                            <th><b>CGPA</b></th>
                                                                            <th><b>Current Arrear</b></th>
                                                                            <th><b>Overall Arrear</b></th>
                                                                            <th><b>MS 1-Attendance</b></th>
                                                                            <th><b>MS 2-Attendance</b></th>
                                                                            <th><b>Prep-Attendance </b></th>
                                                                            <th><b>Overall-Attendance</b></th>
                                                                        </tr>

                                                                    </thead>
                                                                    <tbody>

                                                                        <?php

                                                                        $query = "SELECT * FROM sgrade where sid='$s' and sem='7'";
                                                                        $query_run = mysqli_query($db, $query);

                                                                        if (mysqli_num_rows($query_run) > 0) {
                                                                            $sn = 1;
                                                                            foreach ($query_run as $student) {

                                                                        ?>
                                                                                <tr>

                                                                                    <td><?= $student['sgpa'] ?></td>



                                                                                    <td><?= $student['cgpa'] ?></td>
                                                                                    <td><?= $student['CA'] ?></td>



                                                                                    <td><?= $student['OA'] ?></td>


                                                                                    <td><?= $student['ms1a'] ?></td>
                                                                                    <td><?= $student['ms2a'] ?></td>
                                                                                    <td align="center"><?= $student['prepa'] ?>
                                                                                    </td>
                                                                                    <td align="center"><?= $student['ova'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $sn = $sn + 1;
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <!-- Tab 7 end -->

                                        <!-- Tab 8 -->
                                        <div class="tab-pane p-20" id="sem8" role="tabpanel">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>Semester 8 Exam Details

                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="myTables1ms1"
                                                                    class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th><b>S.No</b></th>
                                                                            <th><b>Subject Name</b></th>
                                                                            <th><b>MS 1</b></th>
                                                                            <th><b>MS 2</b></th>
                                                                            <th><b>Preparatory</b></th>
                                                                            <th><b>Semester</b></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        <?php

                                                                        $query = "SELECT * FROM ss8 where sid='$s'";
                                                                        $query_run = mysqli_query($db, $query);

                                                                        if (mysqli_num_rows($query_run) > 0) {
                                                                            $sn = 1;
                                                                            foreach ($query_run as $student) {

                                                                        ?>
                                                                                <tr>
                                                                                    <td><?= $sn ?></td>
                                                                                    <td><?= $student['sname'] ?></td>



                                                                                    <td><?= $student['ms1'] ?></td>
                                                                                    <td><?= $student['ms2'] ?></td>
                                                                                    <td><?= $student['prep'] ?></td>
                                                                                    <td align="center"><?= $student['sem'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $sn = $sn + 1;
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- CGAP/SGPA/Attendance -->

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>SGPA /CGPA / Attendance
                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="sem1sgpa"
                                                                    class="table table-bordered table-striped">
                                                                    <thead class="gradient-header">
                                                                        <tr>
                                                                            <th><b>SGPA</b></th>
                                                                            <th><b>CGPA</b></th>
                                                                            <th><b>Current Arrear</b></th>
                                                                            <th><b>Overall Arrear</b></th>
                                                                            <th><b>MS 1-Attendance</b></th>
                                                                            <th><b>MS 2-Attendance</b></th>
                                                                            <th><b>Prep-Attendance </b></th>
                                                                            <th><b>Overall-Attendance</b></th>
                                                                        </tr>

                                                                    </thead>
                                                                    <tbody>

                                                                        <?php

                                                                        $query = "SELECT * FROM sgrade where sid='$s' and sem='8'";
                                                                        $query_run = mysqli_query($db, $query);

                                                                        if (mysqli_num_rows($query_run) > 0) {
                                                                            $sn = 1;
                                                                            foreach ($query_run as $student) {

                                                                        ?>
                                                                                <tr>

                                                                                    <td><?= $student['sgpa'] ?></td>



                                                                                    <td><?= $student['cgpa'] ?></td>
                                                                                    <td><?= $student['CA'] ?></td>



                                                                                    <td><?= $student['OA'] ?></td>


                                                                                    <td><?= $student['ms1a'] ?></td>
                                                                                    <td><?= $student['ms2a'] ?></td>
                                                                                    <td align="center"><?= $student['prepa'] ?>
                                                                                    </td>
                                                                                    <td align="center"><?= $student['ova'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                                $sn = $sn + 1;
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <!-- Tab 8 end -->





                                    </div>
                                    <!--tab content end -->





                                </div>
                            </div>
                        </div>



                    </div>

                </div>
            </div>

        <!-- Footer -->
        <?php include 'footer.php'; ?>
    </div>
    <script>

        const loaderContainer = document.getElementById('loaderContainer');

        function showLoader() {
            loaderContainer.classList.add('show');
        }

        function hideLoader() {
            loaderContainer.classList.remove('show');
        }

        //    automatic loader
        document.addEventListener('DOMContentLoaded', function () {
            const loaderContainer = document.getElementById('loaderContainer');
            const contentWrapper = document.getElementById('contentWrapper');
            let loadingTimeout;

            function hideLoader() {
                loaderContainer.classList.add('hide');
                contentWrapper.classList.add('show');
            }

            function showError() {
                console.error('Page load took too long or encountered an error');
                // You can add custom error handling here
            }

            // Set a maximum loading time (10 seconds)
            loadingTimeout = setTimeout(showError, 10000);

            // Hide loader when everything is loaded
            window.onload = function () {
                clearTimeout(loadingTimeout);

                // Add a small delay to ensure smooth transition
                setTimeout(hideLoader, 500);
            };

            // Error handling
            window.onerror = function (msg, url, lineNo, columnNo, error) {
                clearTimeout(loadingTimeout);
                showError();
                return false;
            };
        });

        document.addEventListener("DOMContentLoaded", function () {
            // Cache DOM elements
            const elements = {
                hamburger: document.getElementById('hamburger'),
                sidebar: document.getElementById('sidebar'),
                mobileOverlay: document.getElementById('mobileOverlay'),
                menuItems: document.querySelectorAll('.menu-item'),
                submenuItems: document.querySelectorAll('.submenu-item') // Add submenu items to cache
            };

            // Set active menu item based on current path
            function setActiveMenuItem() {
                const currentPath = window.location.pathname.split('/').pop();

                // Clear all active states first
                elements.menuItems.forEach(item => item.classList.remove('active'));
                elements.submenuItems.forEach(item => item.classList.remove('active'));

                // Check main menu items
                elements.menuItems.forEach(item => {
                    const itemPath = item.getAttribute('href')?.replace('/', '');
                    if (itemPath === currentPath) {
                        item.classList.add('active');
                        // If this item has a parent submenu, activate it too
                        const parentSubmenu = item.closest('.submenu');
                        const parentMenuItem = parentSubmenu?.previousElementSibling;
                        if (parentSubmenu && parentMenuItem) {
                            parentSubmenu.classList.add('active');
                            parentMenuItem.classList.add('active');
                        }
                    }
                });

                // Check submenu items
                elements.submenuItems.forEach(item => {
                    const itemPath = item.getAttribute('href')?.replace('/', '');
                    if (itemPath === currentPath) {
                        item.classList.add('active');
                        // Activate parent submenu and its trigger
                        const parentSubmenu = item.closest('.submenu');
                        const parentMenuItem = parentSubmenu?.previousElementSibling;
                        if (parentSubmenu && parentMenuItem) {
                            parentSubmenu.classList.add('active');
                            parentMenuItem.classList.add('active');
                        }
                    }
                });
            }

            // Handle mobile sidebar toggle
            function handleSidebarToggle() {
                if (window.innerWidth <= 768) {
                    elements.sidebar.classList.toggle('mobile-show');
                    elements.mobileOverlay.classList.toggle('show');
                    document.body.classList.toggle('sidebar-open');
                } else {
                    elements.sidebar.classList.toggle('collapsed');
                }
            }

            // Handle window resize
            function handleResize() {
                if (window.innerWidth <= 768) {
                    elements.sidebar.classList.remove('collapsed');
                    elements.sidebar.classList.remove('mobile-show');
                    elements.mobileOverlay.classList.remove('show');
                    document.body.classList.remove('sidebar-open');
                } else {
                    elements.sidebar.style.transform = '';
                    elements.mobileOverlay.classList.remove('show');
                    document.body.classList.remove('sidebar-open');
                }
            }

            // Toggle User Menu
            const userMenu = document.getElementById('userMenu');
            const dropdownMenu = userMenu.querySelector('.dropdown-menu');
            userMenu.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', () => {
                dropdownMenu.classList.remove('show');
            });

            // Enhanced Toggle Submenu with active state handling
            const menuItems = document.querySelectorAll('.has-submenu');
            menuItems.forEach(item => {
                item.addEventListener('click', (e) => {
                    e.preventDefault(); // Prevent default if it's a link
                    const submenu = item.nextElementSibling;

                    // Toggle active state for the clicked menu item and its submenu
                    item.classList.toggle('active');
                    submenu.classList.toggle('active');

                    // Handle submenu item clicks
                    const submenuItems = submenu.querySelectorAll('.submenu-item');
                    submenuItems.forEach(submenuItem => {
                        submenuItem.addEventListener('click', (e) => {
                            // Remove active class from all submenu items
                            submenuItems.forEach(si => si.classList.remove('active'));
                            // Add active class to clicked submenu item
                            submenuItem.classList.add('active');
                            e.stopPropagation(); // Prevent event from bubbling up
                        });
                    });
                });
            });

            // Initialize event listeners
            function initializeEventListeners() {
                // Sidebar toggle for mobile and desktop
                if (elements.hamburger && elements.mobileOverlay) {
                    elements.hamburger.addEventListener('click', handleSidebarToggle);
                    elements.mobileOverlay.addEventListener('click', handleSidebarToggle);
                }
                // Window resize handler
                window.addEventListener('resize', handleResize);
            }

            // Initialize everything
            setActiveMenuItem();
            initializeEventListeners();
        });
    </script>

</body>

</html>