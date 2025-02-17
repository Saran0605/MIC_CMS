<?php
require 'config.php';
include("session.php");
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
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
            /* text-align: left;
            font-size: 0.9em;
            vertical-align: middle; */
            text-align: center;
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

        .row {
            margin-bottom: 0.6rem !important;
        }

        .gradient-header {
            --bs-table-bg: transparent;
            --bs-table-color: white;
            background: linear-gradient(135deg, #4CAF50, #2196F3) !important;

            text-align: center;
            font-size: 0.9em;
        }

        .custom-header {
            background: linear-gradient(135deg, #6366f1, #3b82f6) !important;
            color: white;
        }

        .table> :not(caption)>*>* {
            padding: 1rem 0.75rem;
        }

        .mark-input-btn {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #6366f1;
            transition: all 0.3s ease;
        }

        .mark-input-btn:hover {
            background-color: #6366f1;
            color: white;
        }

        .add-subject-btn {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #6366f1;
            transition: all 0.3s ease;
        }

        .add-subject-btn:hover {
            background-color: #6366f1;
            color: white;
        }

        .button-container {
            padding: 1rem;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
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
        <div class="breadcrumb-area">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="smain.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Academic Exam </li>
                </ol>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="container-fluid">
            <?php
            $query = "SELECT * FROM basic WHERE id='$s'";
            $query_run = mysqli_query($db, $query);

            if (mysqli_num_rows($query_run) >= 0) {
                $student = mysqli_fetch_array($query_run);
            }

            $query2 = "SELECT * FROM faculty WHERE id='$s'";
            $query_run2 = mysqli_query($db, $query2);

            if (mysqli_num_rows($query_run2) >= 0) {
                $student2 = mysqli_fetch_array($query_run2);
            }
            ?>


            <div class="card" style="border: none;">
                <div class="card-body wizard-content">
                    <div class="card" style="border: none;">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="sem1-tab" data-bs-toggle="tab" href="#sem1" role="tab">
                                    <span class="d-none d-sm-inline"><i class="fas fa-pencil-alt"></i> Semester 1</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="sem2-tab" data-bs-toggle="tab" href="#sem2" role="tab">
                                    <span class="d-none d-sm-inline"><i class="fas fa-pencil-alt"></i> Semester 2</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="sem3-tab" data-bs-toggle="tab" href="#sem3" role="tab">
                                    <span class="d-none d-sm-inline"><i class="fas fa-pencil-alt"></i> Semester 3</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="sem4-tab" data-bs-toggle="tab" href="#sem4" role="tab">
                                    <span class="d-none d-sm-inline"><i class="fas fa-pencil-alt"></i> Semester 4</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="sem5-tab" data-bs-toggle="tab" href="#sem5" role="tab">
                                    <span class="d-none d-sm-inline"><i class="fas fa-pencil-alt"></i> Semester 5</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="sem6-tab" data-bs-toggle="tab" href="#sem6" role="tab">
                                    <span class="d-none d-sm-inline"><i class="fas fa-pencil-alt"></i> Semester 6</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="sem7-tab" data-bs-toggle="tab" href="#sem7" role="tab">
                                    <span class="d-none d-sm-inline"><i class="fas fa-pencil-alt"></i> Semester 7</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="sem8-tab" data-bs-toggle="tab" href="#sem8" role="tab">
                                    <span class="d-none d-sm-inline"><i class="fas fa-pencil-alt"></i> Semester 8</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content tabcontent-border">

                            <!-- sem1 tabs -->

                            <div class="tab-pane active p-20" id="sem1" role="tabpanel">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>Semester 1 Exam Details
                                                    <!--  
                                                        <button type="button" style="float: right;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subadd">
                                                            Add Semester 1 Exam Details
                                                        </button>						
                                                        -->
                                                </h4>
                                            </div>
                                            <div class="card-body">

                                                <div class="button-container">
                                                    <div class="row g-2">
                                                        <div class="col">
                                                            <button type="button" class="btn add-subject-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#subadd">
                                                                <strong> Add Subject </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#ms1ms1">
                                                                <strong> Enter MS 1/CIA 1 Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#ms1ms2">
                                                                <strong> Enter MS 2/CIA 2 Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#ms1prep">
                                                                <strong> Enter Preparatory Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#ms1sem">
                                                                <strong> Enter Semester Mark </strong> </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">

                                                    <table id="myTables1ms1"
                                                        class="table table-bordered table-striped">
                                                        <thead class="gradient-header">
                                                            <tr>
                                                                <th rowspan="2" class="centered-text"><b>S.No</b>
                                                                </th>
                                                                <th><b>Subject Name</b></th>
                                                                <th><b>MS 1/CIA 1</b></th>
                                                                <th><b>MS 2/CIA 2</b></th>
                                                                <th><b>Preparatory(R2018 alone)</b></th>
                                                                <th><b>Semester</b></th>
                                                                <th rowspan="2" align="center"><b>Action</b></th>
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
                                                                        <td align="center"><?= $student['sem'] ?></td>
                                                                        <td align="center">

                                                                            <button type="button"
                                                                                value="<?= $student['uid']; ?>"
                                                                                class="deletes1Btn btn btn-danger btn-sm">Delete</button>
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
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>GPA /CGPA / Attendance
                                                    <!--  
                                                        <button type="button" style="float: right;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subadd">
                                                            Add Semester 1 Exam Details
                                                        </button>						
                                                        -->
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="sem1sgpa" class="table table-bordered table-striped">
                                                        <thead class="gradient-header">
                                                            <tr>
                                                                <th><b>GPA</b></th>
                                                                <th><b>CGPA</b></th>
                                                                <th><b>Current Arrear</b></th>
                                                                <th><b>Overall Arrear</b></th>
                                                                <th><b>MS 1/CIA 1-Attendance</b></th>
                                                                <th><b>MS 2/CIA 2-Attendance</b></th>

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
                                                                        <td align="center"><?= $student['ova'] ?></td>
                                                                    </tr>
                                                            <?php
                                                                    $sn = $sn + 1;
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td colspan="8"><button type="button"
                                                                        class="btn btn-success"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#sem1SG">
                                                                        Enter</button></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- sem2 tabs -->

                            <div class="tab-pane p-20" id="sem2" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>Semester 2 Exam Details
                                                    <!--  
                                                        <button type="button" style="float: right;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subadd">
                                                            Add Semester 1 Exam Details
                                                        </button>						
                                                        -->
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="button-container">
                                                    <div class="row g-2">
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem2madd">
                                                                <strong> Add Subject </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem2ms1">
                                                                <strong> Enter MS1 Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem2ms2">
                                                                <strong> Enter MS2 Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem2prep">
                                                                <strong> Enter Preparatory Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem2sem">
                                                                <strong> Enter Semester Mark </strong></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table id="sem2table"
                                                        class="table table-bordered table-striped">
                                                        <thead class="gradient-header">
                                                            <tr>
                                                                <th rowspan="2" class="centered-text"><b>S.No</b>
                                                                </th>
                                                                <th><b>Subject Name</b></th>
                                                                <th><b>MS 1/CIA 1</b></th>
                                                                <th><b>MS 2/CIA 2</b></th>
                                                                <th><b>Preparatory(R2018 alone)</b></th>
                                                                <th><b>Semester</b></th>
                                                                <th rowspan="2" align="center"><b>Action</b></th>
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
                                                                        <td align="center"><?= $student['sem'] ?></td>
                                                                        <td align="center">

                                                                            <button type="button"
                                                                                value="<?= $student['uid']; ?>"
                                                                                class="sem2deleteBtn btn btn-danger btn-sm">Delete</button>
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
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>GPA /CGPA / Attendance
                                                    <!--  
                                                            <button type="button" style="float: right;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subadd">
                                                                Add Semester 1 Exam Details
                                                            </button>						
                                                            -->
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="sem2sgpa" class="table table-bordered table-striped">
                                                        <thead class="gradient-header">
                                                            <tr>
                                                                <th><b>GPA</b></th>
                                                                <th><b>CGPA</b></th>
                                                                <th><b>Current Arrear</b></th>
                                                                <th><b>Overall Arrear</b></th>
                                                                <th><b>MS 1/CIA 1-Attendance</b></th>
                                                                <th><b>MS 2/CIA 2-Attendance</b></th>

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

                                                                        <td align="center"><?= $student['ova'] ?></td>
                                                                    </tr>
                                                            <?php
                                                                    $sn = $sn + 1;
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td colspan="8"><button type="button"
                                                                        class="btn btn-success"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#sem1SG">
                                                                        Enter</button></td>


                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- sem3 tabs -->

                            <div class="tab-pane  p-20" id="sem3" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>Semester 3 Exam Details
                                                    <!--  
                                                            <button type="button" style="float: right;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subadd">
                                                                Add Semester 1 Exam Details
                                                            </button>						
                                                            -->
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="button-container">
                                                    <div class="row g-2">
                                                        <div class="col">
                                                            <button type="button" class="btn add-subject-btn w-100 position-relative" data-bs-toggle="modal" data-bs-target="#sem3madd" onclick="setActiveButton(this)">
                                                                <strong> Add Subject </strong>
                                                            </button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" data-bs-toggle="modal" data-bs-target="#sem3ms1" onclick="setActiveButton(this)">
                                                                <strong> Enter MS1 Mark </strong>
                                                            </button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" data-bs-toggle="modal" data-bs-target="#sem3ms2" onclick="setActiveButton(this)">
                                                                <strong> Enter MS2 Mark </strong>
                                                            </button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" data-bs-toggle="modal" data-bs-target="#sem3prep" onclick="setActiveButton(this)">
                                                                <strong> Enter Preparatory Mark </strong>
                                                            </button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" data-bs-toggle="modal" data-bs-target="#sem3sem" onclick="setActiveButton(this)">
                                                                <strong> Enter Semester Mark </strong>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">

                                                    <table id="sem3table"
                                                        class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr class="gradient-header">
                                                                <th rowspan="2" class="centered-text"><b>S.No</b>
                                                                </th>
                                                                <th><b>Subject Name</b></th>
                                                                <th><b>MS 1/CIA 1</b></th>
                                                                <th><b>MS 2/CIA 2</b></th>
                                                                <th><b>Preparatory(R2018 alone)</b></th>
                                                                <th><b>Semester</b></th>
                                                                <th rowspan="2" align="center"><b>Action</b></th>
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
                                                                        <td class="text-center" ;><?= $student['sname'] ?></td>
                                                                        <td class="text-center" ;><?= $student['ms1'] ?></td>
                                                                        <td class="text-center" ;><?= $student['ms2'] ?></td>
                                                                        <td class="text-center" ;><?= $student['prep'] ?></td>
                                                                        <td align="center"><?= $student['sem'] ?></td>
                                                                        <td align="center">

                                                                            <button type="button"
                                                                                value="<?= $student['uid']; ?>"
                                                                                class="sem3deleteBtn btn btn-danger btn-sm">Delete</button>
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
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>GPA /CGPA / Attendance
                                                    <!--  
                                                                    <button type="button" style="float: right;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subadd">
                                                                        Add Semester 1 Exam Details
                                                                    </button>						
                                                                    -->
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="sem3sgpa" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr class="gradient-header">
                                                                <th><b>GPA</b></th>
                                                                <th><b>CGPA</b></th>
                                                                <th><b>Current Arrear</b></th>
                                                                <th><b>Overall Arrear</b></th>
                                                                <th><b>MS 1/CIA 1-Attendance</b></th>
                                                                <th><b>MS 2/CIA 2-Attendance</b></th>

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

                                                                        <td align="center"><?= $student['ova'] ?></td>
                                                                    </tr>
                                                            <?php
                                                                    $sn = $sn + 1;
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td colspan="8"><button type="button"
                                                                        class="btn btn-success"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#sem1SG">
                                                                        Enter</button></td>


                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- sem4 tabs -->

                            <div class="tab-pane  p-20" id="sem4" role="tabpanel">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>Semester 4 Exam Details
                                                    <!--  
                                                        <button type="button" style="float: right;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subadd">
                                                            Add Semester 1 Exam Details
                                                        </button>						
                                                        -->
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="button-container">
                                                    <div class="row g-2">
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem4madd">
                                                                <strong> Add Subject </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem4ms1">
                                                                <strong> Enter MS1 Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem4ms2">
                                                                <strong> Enter MS2 Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem4prep">
                                                                <strong> Enter Preparatory Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem4sem">
                                                                <strong> Enter Semester Mark </strong> </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table id="sem4table"
                                                        class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr class="gradient-header">
                                                                <th rowspan="2" class="centered-text"><b>S.No</b>
                                                                </th>
                                                                <th><b>Subject Name</b></th>
                                                                <th><b>MS 1/CIA 1</b></th>
                                                                <th><b>MS 2/CIA 2</b></th>
                                                                <th><b>Preparatory(R2018 alone)</b></th>
                                                                <th><b>Semester</b></th>
                                                                <th rowspan="2" align="center"><b>Action</b></th>
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
                                                                        <td align="center"><?= $student['sem'] ?></td>
                                                                        <td align="center">

                                                                            <button type="button"
                                                                                value="<?= $student['uid']; ?>"
                                                                                class="sem4deleteBtn btn btn-danger btn-sm">Delete</button>
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
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>GPA /CGPA / Attendance
                                                    <!--  
                                                        <button type="button" style="float: right;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subadd">
                                                            Add Semester 1 Exam Details
                                                        </button>						
                                                        -->
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="sem4sgpa" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr class="gradient-header">
                                                                <th><b>GPA</b></th>
                                                                <th><b>CGPA</b></th>
                                                                <th><b>Current Arrear</b></th>
                                                                <th><b>Overall Arrear</b></th>
                                                                <th><b>MS 1/CIA 1-Attendance</b></th>
                                                                <th><b>MS 2/CIA 2-Attendance</b></th>

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

                                                                        <td align="center"><?= $student['ova'] ?></td>
                                                                    </tr>
                                                            <?php
                                                                    $sn = $sn + 1;
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td colspan="8"><button type="button"
                                                                        class="btn btn-success"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#sem1SG">
                                                                        Enter</button></td>


                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- sem5 tabs -->

                            <div class="tab-pane  p-20" id="sem5" role="tabpanel">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>Semester 5 Exam Details
                                                    <!--  
                                                    <button type="button" style="float: right;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subadd">
                                                        Add Semester 1 Exam Details
                                                    </button>						
                                                    -->
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="button-container">
                                                    <div class="row g-2">
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem5madd">
                                                                <strong> Add Subject </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem5ms1">
                                                                <strong> Enter MS1 Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem5ms2">
                                                                <strong> Enter MS2 Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem5prep">
                                                                <strong> Enter Preparatory Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem5sem">
                                                                <strong> Enter Semester Mark </strong></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table id="sem5table"
                                                        class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr class="gradient-header">
                                                                <th rowspan="2" class="centered-text"><b>S.No</b>
                                                                </th>
                                                                <th><b>Subject Name</b></th>
                                                                <th><b>MS 1/CIA 1</b></th>
                                                                <th><b>MS 2/CIA 2</b></th>
                                                                <th><b>Preparatory(R2018 alone)</b></th>
                                                                <th><b>Semester</b></th>
                                                                <th rowspan="2" align="center"><b>Action</b></th>
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
                                                                        <td align="center"><?= $student['sem'] ?></td>
                                                                        <td align="center">

                                                                            <button type="button"
                                                                                value="<?= $student['uid']; ?>"
                                                                                class="sem5deleteBtn btn btn-danger btn-sm">Delete</button>
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
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>GPA /CGPA / Attendance
                                                    <!--  
                                                        <button type="button" style="float: right;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subadd">
                                                            Add Semester 1 Exam Details
                                                        </button>						
                                                        -->
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="sem5sgpa" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr class="gradient-header">
                                                                <th><b>GPA</b></th>
                                                                <th><b>CGPA</b></th>
                                                                <th><b>Current Arrear</b></th>
                                                                <th><b>Overall Arrear</b></th>
                                                                <th><b>MS 1/CIA 1-Attendance</b></th>
                                                                <th><b>MS 2/CIA 2-Attendance</b></th>

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

                                                                        <td align="center"><?= $student['ova'] ?></td>
                                                                    </tr>
                                                            <?php
                                                                    $sn = $sn + 1;
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td colspan="8"><button type="button"
                                                                        class="btn btn-success"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#sem1SG">
                                                                        Enter</button></td>


                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- sem6 tabs -->

                            <div class="tab-pane p-20" id="sem6" role="tabpanel">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>Semester 6 Exam Details
                                                    <!--  
                                                        <button type="button" style="float: right;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subadd">
                                                            Add Semester 1 Exam Details
                                                        </button>						
                                                        -->
                                                </h4>
                                            </div>
                                            <div class="card-body">

                                                <div class="button-container">
                                                    <div class="row g-2">
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem6madd">
                                                                <strong> Add Subject </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem6ms1">
                                                                <strong> Enter MS 1/CIA 1 Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem6ms2">
                                                                <strong> Enter MS 2/CIA 2 Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem6prep">
                                                                <strong> Enter Preparatory Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem6sem">
                                                                <strong> Enter Semester Mark </strong> </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table id="sem6table"
                                                        class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr class="gradient-header">
                                                                <th rowspan="2" class="centered-text"><b>S.No</b>
                                                                </th>
                                                                <th><b>Subject Name</b></th>
                                                                <th><b>MS 1/CIA 1</b></th>
                                                                <th><b>MS 2/CIA 2</b></th>
                                                                <th><b>Preparatory(R2018 alone)</b></th>
                                                                <th><b>Semester</b></th>
                                                                <th rowspan="2" align="center"><b>Action</b></th>
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
                                                                        <td align="center"><?= $student['sem'] ?></td>
                                                                        <td align="center">

                                                                            <button type="button"
                                                                                value="<?= $student['uid']; ?>"
                                                                                class="sem6deleteBtn btn btn-danger btn-sm">Delete</button>
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
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>GPA /CGPA / Attendance
                                                    <!--  
                                                        <button type="button" style="float: right;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subadd">
                                                            Add Semester 1 Exam Details
                                                        </button>						
                                                        -->
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="sem6sgpa" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr class="gradient-header">
                                                                <th><b>GPA</b></th>
                                                                <th><b>CGPA</b></th>
                                                                <th><b>Current Arrear</b></th>
                                                                <th><b>Overall Arrear</b></th>
                                                                <th><b>MS 1/CIA 1-Attendance</b></th>
                                                                <th><b>MS 2/CIA 2-Attendance</b></th>

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

                                                                        <td align="center"><?= $student['ova'] ?></td>
                                                                    </tr>
                                                            <?php
                                                                    $sn = $sn + 1;
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td colspan="8"><button type="button"
                                                                        class="btn btn-success"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#sem1SG">
                                                                        Enter</button></td>


                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- sem7 tabs -->

                            <div class="tab-pane p-20" id="sem7" role="tabpanel">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>Semester 7 Exam Details
                                                    <!--  
                                                    <button type="button" style="float: right;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subadd">
                                                        Add Semester 1 Exam Details
                                                    </button>						
                                                    -->
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="button-container">
                                                    <div class="row g-2">
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"

                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem7madd">
                                                                <strong> Add Subject </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"

                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem7ms1">
                                                                <strong> Enter MS1 Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"

                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem7ms2">
                                                                <strong> Enter MS2 Mark </strong></button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"

                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem7prep">
                                                                <strong> Enter Preparatory Mark </strong>
                                                            </button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"

                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem7sem">
                                                                <strong> Enter Semester Mark </strong></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table id="sem7table"
                                                        class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr class="gradient-header">
                                                                <th rowspan="2" class="centered-text"><b>S.No</b>
                                                                </th>
                                                                <th><b>Subject Name</b></th>
                                                                <th><b>MS 1/CIA 1</b></th>
                                                                <th><b>MS 2/CIA 2</b></th>
                                                                <th><b>Preparatory(R2018 alone)</b></th>
                                                                <th><b>Semester</b></th>
                                                                <th rowspan="2" align="center"><b>Action</b></th>
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
                                                                        <td align="center"><?= $student['sem'] ?></td>
                                                                        <td align="center">

                                                                            <button type="button"
                                                                                value="<?= $student['uid']; ?>"
                                                                                class="sem7deleteBtn btn btn-danger btn-sm">Delete</button>
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
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>GPA /CGPA / Attendance
                                                    <!--  
                                                        <button type="button" style="float: right;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subadd">
                                                            Add Semester 1 Exam Details
                                                        </button>						
                                                        -->
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="sem7sgpa" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr class="gradient-header">
                                                                <th><b>GPA</b></th>
                                                                <th><b>CGPA</b></th>
                                                                <th><b>Current Arrear</b></th>
                                                                <th><b>Overall Arrear</b></th>
                                                                <th><b>MS 1/CIA 1-Attendance</b></th>
                                                                <th><b>MS 2/CIA 2-Attendance</b></th>

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

                                                                        <td align="center"><?= $student['ova'] ?></td>
                                                                    </tr>
                                                            <?php
                                                                    $sn = $sn + 1;
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td colspan="8"><button type="button"
                                                                        class="btn btn-success"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#sem1SG">
                                                                        Enter</button></td>


                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- sem8 tabs -->

                            <div class="tab-pane p-20" id="sem8" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>Semester 8 Exam Details
                                                    <!--  
                                                        <button type="button" style="float: right;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subadd">
                                                            Add Semester 1 Exam Details
                                                        </button>						
                                                        -->
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="button-container">
                                                    <div class="row g-2">
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"

                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem8madd">
                                                                <strong> Add Subject </strong>
                                                            </button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"

                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem8ms1">
                                                                <strong> Enter MS1 Mark </strong>
                                                            </button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"

                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem8ms2">
                                                                <strong> Enter MS2 Mark </strong>
                                                            </button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"

                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem8prep">
                                                                <strong> Enter Preparatory Mark </strong>
                                                            </button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn mark-input-btn w-100 position-relative" onclick="setActiveButton(this)"

                                                                data-bs-toggle="modal"
                                                                data-bs-target="#sem8sem">
                                                                <strong> Enter Semester Mark </strong>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table id="sem8table"
                                                        class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr class="gradient-header">
                                                                <th rowspan="2" class="centered-text"><b>S.No</b>
                                                                </th>
                                                                <th><b>Subject Name</b></th>
                                                                <th><b>MS 1/CIA 1</b></th>
                                                                <th><b>MS 2/CIA 2</b></th>
                                                                <th><b>Preparatory(R2018 alone)</b></th>
                                                                <th><b>Semester</b></th>
                                                                <th rowspan="2" align="center"><b>Action</b></th>
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
                                                                        <td align="center"><?= $student['sem'] ?></td>
                                                                        <td align="center">

                                                                            <button type="button"
                                                                                value="<?= $student['uid']; ?>"
                                                                                class="sem8deleteBtn btn btn-danger btn-sm">Delete</button>
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
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>GPA /CGPA / Attendance
                                                    <!--  
                                                        <button type="button" style="float: right;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subadd">
                                                            Add Semester 1 Exam Details
                                                        </button>						
                                                        -->
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="sem8sgpa" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr class="gradient-header">
                                                                <th><b>GPA</b></th>
                                                                <th><b>CGPA</b></th>
                                                                <th><b>Current Arrear</b></th>
                                                                <th><b>Overall Arrear</b></th>
                                                                <th><b>MS 1/CIA 1-Attendance</b></th>
                                                                <th><b>MS 2/CIA 2-Attendance</b></th>

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

                                                                        <td align="center"><?= $student['ova'] ?></td>
                                                                    </tr>
                                                            <?php
                                                                    $sn = $sn + 1;
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td colspan="8"><button type="button"
                                                                        class="btn btn-success"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#sem1SG">
                                                                        Enter</button></td>


                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>


        </div>

        <!---CGPA Modal Starts -->
        <div class="modal fade" id="sem1SG" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> GPA /CGPA / Attendance </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem1SGf">
                        <div class="modal-body">
                            <div id="sem1SGMessage" class="alert alert-warning d-none"></div>



                            <div class="mb-3">
                                <label for="" class="form-label">Semester *</label>
                                <select class="form-control" name="sem" id="sem" required>
                                    <option value="">Select Semester</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Select *</label>
                                <select class="form-control" name="type" id="type" required>
                                    <option value="">Select</option>
                                    <option value="sgpa">GPA</option>
                                    <option value="cgpa">CGPA</option>
                                    <option value="ca">Current Arrear</option>
                                    <option value="oa">Overall Arrear</option>
                                    <option value="ms1a">MS1-Attendance</option>
                                    <option value="ms2a">MS2-Attendance</option>

                                    <option value="ova">Overall-Attendance</option>
                                </select>
                            </div>

                            <div class="mb-3" id="sg">
                                <label for="SGPA" class="form-label">GPA* : </label>
                                <input type="text" name="sgpa" class="form-control">
                            </div>
                            <div class="mb-3" id="cg">
                                <label for="CGPA" class="form-label">CGPA* : </label>
                                <input type="text" name="cgpa" class="form-control">
                            </div>
                            <div class="mb-3" id="ca">
                                <label for="CA" class="form-label">Current Arrear* : </label>
                                <input type="text" name="ca" class="form-control">
                            </div>
                            <div class="mb-3" id="oa">
                                <label for="OA" class="form-label">Overall Arrear* : </label>
                                <input type="text" name="oa" class="form-control">
                            </div>
                            <div class="mb-3" id="ms1">
                                <label for="SGPA" class="form-label">MS1-Attendance* : </label>
                                <input type="text" name="ms1" class="form-control">
                            </div>
                            <div class="mb-3" id="ms2">
                                <label for="SGPA" class="form-label">MS2-Attendance* : </label>
                                <input type="text" name="ms2" class="form-control">
                            </div>

                            <div class="mb-3" id="ova">
                                <label for="SGPA" class="form-label">Overall-Attendance* : </label>
                                <input type="text" name="ova" class="form-control">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!-- SEM 1 modal -->
        <div class="modal fade" id="subadd" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Add Semester 1 Exam Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="pcex">
                        <div class="modal-body">

                            <div id="sem1Message" class="alert alert-warning d-none"></div>

                            <div id="input-container">
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        name="dynamic_input[]" placeholder="Subject 1">

                                </div>

                            </div>
                            <button type="button" class="btn btn-primary" id="add-input">Add
                                Subject</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success"
                                id="submit-form">Submit</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 1 Add MS1 modal -->
        <div class="modal fade" id="ms1ms1" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> MS 1/CIA 1 Mark Details </strong> </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="s1ms1">
                        <div class="modal-body">

                            <div id="s1ms1Message" class="alert alert-warning d-none"></div>

                            <?php
                            $query = "SELECT * FROM ss1 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                $i = 1;
                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";

                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";

                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                    $i = $i + 1;
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 1 MS1 modal end -->


        <!--SEM 1 Add MS2 modal -->
        <div class="modal fade" id="ms1ms2" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> MS 2/CIA 2 Mark Details</strong> </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="s1ms2">
                        <div class="modal-body">

                            <div id="s1ms2Message" class="alert alert-warning d-none"></div>

                            <?php
                            $query = "SELECT * FROM ss1 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 1 MS2 modal end -->


        <!--SEM 1 Add prep modal -->
        <div class="modal fade" id="ms1prep" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong>Preparatory(R2018 alone) Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="s1prep">
                        <div class="modal-body">

                            <div id="s1prepMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss1 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 1 prep modal end -->


        <!--SEM 1 Add sem modal -->
        <div class="modal fade" id="ms1sem" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Semester Mark Details</strong> </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="s1sem">
                        <div class="modal-body">

                            <div id="s1semMessage" class="alert alert-warning d-none"></div>

                            <?php
                            $query = "SELECT * FROM ss1 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 1 sem modal end -->



        <!-- SEM 2 modal -->

        <div class="modal fade" id="sem2madd" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong>Add Semester 2 Exam Details</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem2fex">
                        <div class="modal-body">

                            <div id="sem1Message" class="alert alert-warning d-none"></div>

                            <div id="input-container2">
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        name="dynamic_input[]" placeholder="Subject 1">

                                </div>

                            </div>
                            <button type="button" class="btn btn-primary"
                                id="add-input2">Add Subject</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success"
                                id="submit-form2">Submit</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 2 Add MS1 modal -->
        <div class="modal fade" id="sem2ms1" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong>MS 1/CIA 1 Mark Details</strong> </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem2fms1">
                        <div class="modal-body">

                            <div id="sem2fms1Message" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss2 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                $i = 1;
                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                    $i = $i + 1;
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 2 MS1 modal end -->


        <!--SEM 2 Add MS2 modal -->
        <div class="modal fade" id="sem2ms2" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> MS 2/CIA 2 Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem2ms2f">
                        <div class="modal-body">

                            <div id="sem2ms2fMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss2 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 2 MS2 modal end -->


        <!--SEM 2 Add prep modal -->
        <div class="modal fade" id="sem2prep" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Preparatory(R2018 alone) Mark Details</strong> </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem2prepf">
                        <div class="modal-body">

                            <div id="sem2prepfMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss2 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 2 prep modal end -->


        <!--SEM 2 Add sem modal -->
        <div class="modal fade" id="sem2sem" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong>Semester Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem2semf">
                        <div class="modal-body">

                            <div id="sem2semfMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss2 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!-- sem modal end -->

        <!--SEM 3 modal-->

        <div class="modal fade" id="sem3madd" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong>Add Semester 3 Subject Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem3fex">
                        <div class="modal-body">

                            <div id="sem1Message" class="alert alert-warning d-none"></div>

                            <div id="input-container3">
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        name="dynamic_input[]" placeholder="Subject 1">

                                </div>

                            </div>
                            <button type="button" class="btn btn-primary"
                                id="add-input3">Add Subject</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success"
                                id="submit-form3">Submit</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 3 Add MS1 modal -->
        <div class="modal fade" id="sem3ms1" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> MS 1/CIA 1 Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem3fms1">
                        <div class="modal-body">

                            <div id="sem3fms1Message" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss3 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                $i = 1;
                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                    $i = $i + 1;
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 3 MS1 modal end -->


        <!--SEM 3 Add MS2 modal -->
        <div class="modal fade" id="sem3ms2" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> MS 2/CIA 2 Mark Details </strong></h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem3ms2f">
                        <div class="modal-body">

                            <div id="sem3ms2fMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss3 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 3 MS2 modal end -->


        <!--SEM 3 Add prep modal -->
        <div class="modal fade" id="sem3prep" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> Preparatory(R2018 alone) Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem3prepf">
                        <div class="modal-body">

                            <div id="sem3prepfMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss3 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 3 prep modal end -->


        <!--SEM 3 Add sem modal -->
        <div class="modal fade" id="sem3sem" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem3semf">
                        <div class="modal-body">

                            <div id="sem3semfMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss3 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 3 sem modal end -->



        <!--SEM 4 modal-->

        <div class="modal fade" id="sem4madd" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Add Semester 4 Subject Details</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem4fex">
                        <div class="modal-body">

                            <div id="sem1Message" class="alert alert-warning d-none"></div>

                            <div id="input-container4">
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        name="dynamic_input[]" placeholder="Subject 1">

                                </div>

                            </div>
                            <button type="button" class="btn btn-primary"
                                id="add-input4">Add Subject</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success"
                                id="submit-form4">Submit</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 4 Add MS1 modal -->
        <div class="modal fade" id="sem4ms1" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> MS 1/CIA 1 Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem4fms1">
                        <div class="modal-body">

                            <div id="sem4fms1Message" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss4 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                $i = 1;
                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                    $i = $i + 1;
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 4 MS1 modal end -->


        <!--SEM 4 Add MS2 modal -->
        <div class="modal fade" id="sem4ms2" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> MS 2/CIA 2 Mark Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem4ms2f">
                        <div class="modal-body">

                            <div id="sem4ms2fMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss4 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 4 MS2 modal end -->


        <!--SEM 4 Add prep modal -->
        <div class="modal fade" id="sem4prep" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Preparatory(R2018 alone) Mark Details </strong></h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem4prepf">
                        <div class="modal-body">

                            <div id="sem4prepfMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss4 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 4 prep modal end -->


        <!--SEM 4 Add sem modal -->
        <div class="modal fade" id="sem4sem" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem4semf">
                        <div class="modal-body">

                            <div id="sem4semfMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss4 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 4 sem modal end -->


        <!--SEM 5 sem modal end -->

        <div class="modal fade" id="sem5madd" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Add Semester 5 Subject Details</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem5fex">
                        <div class="modal-body">

                            <div id="sem1Message" class="alert alert-warning d-none"></div>

                            <div id="input-container5">
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        name="dynamic_input[]" placeholder="Subject 1">

                                </div>

                            </div>
                            <button type="button" class="btn btn-primary"
                                id="add-input5">Add Subject</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success"
                                id="submit-form5">Submit</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 5 Add MS1 modal -->
        <div class="modal fade" id="sem5ms1" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> MS 1/CIA 1 Mark Details </strong></h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem5fms1">
                        <div class="modal-body">

                            <div id="sem5fms1Message" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss5 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                $i = 1;
                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                    $i = $i + 1;
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 5 MS1 modal end -->


        <!--SEM 5 Add MS2 modal -->
        <div class="modal fade" id="sem5ms2" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> MS 2/CIA 2 Mark Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem5ms2f">
                        <div class="modal-body">

                            <div id="sem5ms2fMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss5 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 5 MS2 modal end -->


        <!--SEM 5 Add prep modal -->
        <div class="modal fade" id="sem5prep" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> Preparatory(R2018 alone) Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem5prepf">
                        <div class="modal-body">

                            <div id="sem5prepfMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss5 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 5 prep modal end -->


        <!--SEM 5 Add sem modal -->
        <div class="modal fade" id="sem5sem" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem5semf">
                        <div class="modal-body">

                            <div id="sem5semfMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss5 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 5 sem modal end -->


        <!--SEM 6 modal-->
        <div class="modal fade" id="sem6madd" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Add Semester 6 Subject Details </strong></h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem6fex">
                        <div class="modal-body">

                            <div id="sem1Message" class="alert alert-warning d-none"></div>

                            <div id="input-container6">
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        name="dynamic_input[]" placeholder="Subject 1">

                                </div>

                            </div>
                            <button type="button" class="btn btn-primary"
                                id="add-input6">Add Subject</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success"
                                id="submit-form6">Submit</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 6 Add MS1 modal -->
        <div class="modal fade" id="sem6ms1" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> MS 1/CIA 1 Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem6fms1">
                        <div class="modal-body">

                            <div id="sem6fms1Message" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss6 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                $i = 1;
                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                    $i = $i + 1;
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 6 MS1 modal end -->


        <!--SEM 6 Add MS2 modal -->
        <div class="modal fade" id="sem6ms2" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> MS 1/CIA 1 Mark Details </strong></h5>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem6ms2f">
                        <div class="modal-body">

                            <div id="sem6ms2fMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss6 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 6 MS2 modal end -->


        <!--SEM 6 Add prep modal -->
        <div class="modal fade" id="sem6prep" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> Preparatory(R2018 alone) Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem6prepf">
                        <div class="modal-body">

                            <div id="sem6prepfMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss6 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 6 prep modal end -->


        <!--SEM 6 Add sem modal -->
        <div class="modal fade" id="sem6sem" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem6semf">
                        <div class="modal-body">

                            <div id="sem6semfMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss6 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
        <!--SEM 6 sem modal end -->



        <!--SEM 7 modal-->

        <div class="modal fade" id="sem7madd" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Add Semester 7 Subject Details</strong></h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem7fex">
                        <div class="modal-body">

                            <div id="sem1Message" class="alert alert-warning d-none"></div>

                            <div id="input-container7">
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        name="dynamic_input[]" placeholder="Subject 1">

                                </div>

                            </div>
                            <button type="button" class="btn btn-primary"
                                id="add-input7">Add Subject</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success"
                                id="submit-form7">Submit</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 7 Add MS1 modal -->
        <div class="modal fade" id="sem7ms1" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> MS 1/CIA 1 Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem7fms1">
                        <div class="modal-body">

                            <div id="sem7fms1Message" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss7 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                $i = 1;
                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                    $i = $i + 1;
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 7 MS1 modal end -->


        <!--SEM 7 Add MS2 modal -->
        <div class="modal fade" id="sem7ms2" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> MS 1/CIA 1 Mark Details </strong></h5>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem7ms2f">
                        <div class="modal-body">

                            <div id="sem7ms2fMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss7 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 7 MS2 modal end -->


        <!--SEM 7 Add prep modal -->
        <div class="modal fade" id="sem7prep" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> Preparatory(R2018 alone) Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem7prepf">
                        <div class="modal-body">

                            <div id="sem7prepfMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss7 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 7 prep modal end -->


        <!--SEM 7 Add sem modal -->
        <div class="modal fade" id="sem7sem" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem7semf">
                        <div class="modal-body">

                            <div id="sem7semfMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss7 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 7 sem modal end -->


        <!--SEM 8 modal -->

        <div class="modal fade" id="sem8madd" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Add Semester 8 Marks </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem8fex">
                        <div class="modal-body">

                            <div id="sem1Message" class="alert alert-warning d-none"></div>

                            <div id="input-container8">
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        name="dynamic_input[]" placeholder="Subject 1">

                                </div>

                            </div>
                            <button type="button" class="btn btn-primary"
                                id="add-input8">Add Subject</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success"
                                id="submit-form8">Submit</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 8 Add MS1 modal -->
        <div class="modal fade" id="sem8ms1" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> MS 1/CIA 1 Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem8fms1">
                        <div class="modal-body">

                            <div id="sem8fms1Message" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss8 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                $i = 1;
                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                    $i = $i + 1;
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 8 MS1 modal end -->


        <!--SEM 8 Add MS2 modal -->
        <div class="modal fade" id="sem8ms2" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> MS 1/CIA 1 Mark Details </strong></h5>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem8ms2f">
                        <div class="modal-body">

                            <div id="sem8ms2fMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss8 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 8 MS2 modal end -->


        <!--SEM 8 Add prep modal -->
        <div class="modal fade" id="sem8prep" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> Preparatory(R2018 alone) Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem8prepf">
                        <div class="modal-body">

                            <div id="sem8prepfMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss8 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 8 prep modal end -->


        <!--SEM 8 Add sem modal -->
        <div class="modal fade" id="sem8sem" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <strong> Mark Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sem8semf">
                        <div class="modal-body">

                            <div id="sem8semfMessage" class="alert alert-warning d-none">
                            </div>

                            <?php
                            $query = "SELECT * FROM ss8 WHERE sid='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) > 0) {

                                while ($student = mysqli_fetch_assoc($query_run)) {

                                    echo "<div class='mb-3'>";
                                    echo "<label for='" . $student['sname'] . "' class='form-label'>" . $student['sname'] . "</label>";
                                    echo "<input type='text' class='form-control' name='" . $student['uid'] . "' required>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-md">Update
                                details</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!--SEM 8  modal end -->

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
        document.addEventListener('DOMContentLoaded', function() {
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
            window.onload = function() {
                clearTimeout(loadingTimeout);

                // Add a small delay to ensure smooth transition
                setTimeout(hideLoader, 500);
            };

            // Error handling
            window.onerror = function(msg, url, lineNo, columnNo, error) {
                clearTimeout(loadingTimeout);
                showError();
                return false;
            };
        });

        document.addEventListener("DOMContentLoaded", function() {
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const typeDropdown = document.getElementById("type");
            const sgDiv = document.getElementById("sg");
            const cgDiv = document.getElementById("cg");
            const caDiv = document.getElementById("ca");
            const oaDiv = document.getElementById("oa");
            const ms1Div = document.getElementById("ms1");
            const ms2Div = document.getElementById("ms2");

            const ovaDiv = document.getElementById("ova");

            typeDropdown.addEventListener("change", function() {
                const selectedValue = typeDropdown.value;

                sgDiv.style.display = "none";
                cgDiv.style.display = "none";
                caDiv.style.display = "none";
                oaDiv.style.display = "none";
                ms1Div.style.display = "none";
                ms2Div.style.display = "none";

                ovaDiv.style.display = "none";

                if (selectedValue === "sgpa") {
                    sgDiv.style.display = "block";
                } else if (selectedValue === "cgpa") {
                    cgDiv.style.display = "block";
                } else if (selectedValue === "ca") {
                    caDiv.style.display = "block";
                } else if (selectedValue === "oa") {
                    oaDiv.style.display = "block";
                } else if (selectedValue === "ms1a") {
                    ms1Div.style.display = "block";
                } else if (selectedValue === "ms2a") {
                    ms2Div.style.display = "block";
                } else if (selectedValue === "ova") {
                    ovaDiv.style.display = "block";
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            let counter = 2;

            $('#add-input').click(function() {
                $('#input-container').append(`
                    <div class="mb-3">
                        <input type="text" class="form-control" name="dynamic_input[]" placeholder="Subject ${counter}">
                    </div>
                `);
                counter++;
            });

            $('#submit-form').click(function() {
                const formData = $('#pcex').serialize();
                const customFlag = 'save_s1=true';
                const formDataWithFlag = formData + '&' + customFlag;
                $.ajax({
                    type: 'POST',
                    url: 'scode.php',
                    data: formDataWithFlag,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {

                            $('#sem1Message').addClass('d-none');
                            $('#subadd').modal('hide');
                            $('#pcex')[0].reset();

                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            // Reload the content of all modals
                            $('#myTables1ms1').load(location.href + " #myTables1ms1");
                            $('#ms1ms1 .modal-content').load(location.href + " #ms1ms1 .modal-content");
                            $('#ms1ms2 .modal-content').load(location.href + " #ms1ms2 .modal-content");
                            $('#ms1prep .modal-content').load(location.href + " #ms1prep .modal-content");
                            $('#ms1sem .modal-content').load(location.href + " #ms1sem .modal-content");





                        }
                    }
                });
            });
        });
    </script>

    <script>
        //sem2 
        $(document).ready(function() {
            let counter = 2;

            $('#add-input2').click(function() {
                $('#input-container2').append(`
                    <div class="mb-3">
                        <input type="text" class="form-control" name="dynamic_input[]" placeholder="Subject ${counter}">
                    </div>
                `);
                counter++;
            });

            $('#submit-form2').click(function() {
                console.log("kalai");
                const formData = $('#sem2fex').serialize();
                const customFlag = 'save_s2=true';
                const formDataWithFlag = formData + '&' + customFlag;
                $.ajax({
                    type: 'POST',
                    url: 'scode.php',
                    data: formDataWithFlag,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {

                            $('#sem1Message').addClass('d-none');
                            $('#sem2madd').modal('hide');
                            $('#sem2fex')[0].reset();

                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            // Reload the content of all modals
                            $('#sem2table').load(location.href + " #sem2table");
                            $('#sem2ms1 .modal-content').load(location.href + " #sem2ms1 .modal-content");
                            $('#sem2ms2 .modal-content').load(location.href + " #sem2ms2 .modal-content");
                            $('#sem2prep .modal-content').load(location.href + " #sem2prep .modal-content");
                            $('#sem2sem .modal-content').load(location.href + " #sem2sem .modal-content");





                        }
                    }
                });
            });
        });


        //sem3 
        $(document).ready(function() {
            let counter = 2;

            $('#add-input3').click(function() {
                $('#input-container3').append(`
                    <div class="mb-3">
                        <input type="text" class="form-control" name="dynamic_input[]" placeholder="Subject ${counter}">
                    </div>
                `);
                counter++;
            });

            $('#submit-form3').click(function() {

                const formData = $('#sem3fex').serialize();
                const customFlag = 'save_s3=true';
                const formDataWithFlag = formData + '&' + customFlag;
                $.ajax({
                    type: 'POST',
                    url: 'scode.php',
                    data: formDataWithFlag,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {

                            $('#sem1Message').addClass('d-none');
                            $('#sem3madd').modal('hide');
                            $('#sem3fex')[0].reset();

                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            // Reload the content of all modals
                            $('#sem3table').load(location.href + " #sem3table");
                            $('#sem3ms1 .modal-content').load(location.href + " #sem3ms1 .modal-content");
                            $('#sem3ms2 .modal-content').load(location.href + " #sem3ms2 .modal-content");
                            $('#sem3prep .modal-content').load(location.href + " #sem3prep .modal-content");
                            $('#sem3sem .modal-content').load(location.href + " #sem3sem .modal-content");





                        }
                    }
                });
            });
        });
    </script>
    <script>
        //sem 1 

        //ms1
        $(document).on('submit', '#s1ms1', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_s1ms1", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#s1ms1Message').addClass('d-none');
                        $('#ms1ms1').modal('hide');
                        $('#s1ms1')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTables1ms1').load(location.href + " #myTables1ms1");


                    } else if (res.status == 500) {
                        $('#s1ms1Message').addClass('d-none');
                        $('#ms1ms1').modal('hide');
                        $('#s1ms1')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //MS 2/CIA 2	

        $(document).on('submit', '#s1ms2', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_s1ms2", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#s1ms2Message').addClass('d-none');
                        $('#ms1ms2').modal('hide');
                        $('#s1ms2')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTables1ms1').load(location.href + " #myTables1ms1");


                    } else if (res.status == 500) {
                        $('#s1ms2Message').addClass('d-none');
                        $('#ms1ms2').modal('hide');
                        $('#s1ms2')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });


        //prep

        $(document).on('submit', '#s1prep', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_s1prep", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#s1prepMessage').addClass('d-none');
                        $('#ms1prep').modal('hide');
                        $('#s1prep')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTables1ms1').load(location.href + " #myTables1ms1");


                    } else if (res.status == 500) {
                        $('#s1prepMessage').addClass('d-none');
                        $('#ms1prep').modal('hide');
                        $('#s1prep')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //end sem

        $(document).on('submit', '#s1sem', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_s1sem", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#s1semMessage').addClass('d-none');
                        $('#ms1sem').modal('hide');
                        $('#s1sem')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTables1ms1').load(location.href + " #myTables1ms1");


                    } else if (res.status == 500) {
                        $('#s1semMessage').addClass('d-none');
                        $('#ms1sem').modal('hide');
                        $('#s1sem')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //delete

        $(document).on('click', '.deletes1Btn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id5 = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_s1': true,
                        'student_id5': student_id5
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            // Reload the content of all modals
                            $('#myTables1ms1').load(location.href + " #myTables1ms1");
                            $('#ms1ms1 .modal-content').load(location.href + " #ms1ms1 .modal-content");
                            $('#ms1ms2 .modal-content').load(location.href + " #ms1ms2 .modal-content");
                            $('#ms1prep .modal-content').load(location.href + " #ms1prep .modal-content");
                            $('#ms1sem .modal-content').load(location.href + " #ms1sem .modal-content");
                        }
                    }
                });
            }
        });


        //sem2

        //ms1
        $(document).on('submit', '#sem2fms1', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem2fms1", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem2fms1Message').addClass('d-none');
                        $('#sem2ms1').modal('hide');
                        $('#sem2fms1')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem2table').load(location.href + " #sem2table");


                    } else if (res.status == 500) {
                        $('#sem2fms1Message').addClass('d-none');
                        $('#sem2ms1').modal('hide');
                        $('#sem2fms1')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //MS 2/CIA 2	

        $(document).on('submit', '#sem2ms2f', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem2ms2f", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem2ms2fMessage').addClass('d-none');
                        $('#sem2ms2').modal('hide');
                        $('#sem2ms2f')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem2table').load(location.href + " #sem2table");


                    } else if (res.status == 500) {
                        $('#sem2ms2fMessage').addClass('d-none');
                        $('#sem2ms2').modal('hide');
                        $('#sem2ms2f')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //prep

        $(document).on('submit', '#sem2prepf', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem2prepf", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem2prepfMessage').addClass('d-none');
                        $('#sem2prep').modal('hide');
                        $('#sem2prepf')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem2table').load(location.href + " #sem2table");


                    } else if (res.status == 500) {
                        $('#sem2prepfMessage').addClass('d-none');
                        $('#sem2prep').modal('hide');
                        $('#sem2prepf')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });


        //end sem

        $(document).on('submit', '#sem2semf', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem2semf", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem2semfMessage').addClass('d-none');
                        $('#sem2sem').modal('hide');
                        $('#sem2semf')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem2table').load(location.href + " #sem2table");


                    } else if (res.status == 500) {
                        $('#sem2semfMessage').addClass('d-none');
                        $('#sem2sem').modal('hide');
                        $('#sem2semf')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //delete
        $(document).on('click', '.sem2deleteBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id5 = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_s2': true,
                        'student_id5': student_id5
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);
                            // Reload the content of all modals
                            $('#sem2table').load(location.href + " #sem2table");
                            $('#sem2ms1 .modal-content').load(location.href + " #sem2ms1 .modal-content");
                            $('#sem2ms2 .modal-content').load(location.href + " #sem2ms2 .modal-content");
                            $('#sem2prep .modal-content').load(location.href + " #sem2prep .modal-content");
                            $('#sem2sem .modal-content').load(location.href + " #sem2sem .modal-content");
                        }
                    }
                });
            }
        });

        //sem 3


        //ms1
        $(document).on('submit', '#sem3fms1', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem3fms1", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem3fms1Message').addClass('d-none');
                        $('#sem3ms1').modal('hide');
                        $('#sem3fms1')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem3table').load(location.href + " #sem3table");


                    } else if (res.status == 500) {
                        $('#sem3fms1Message').addClass('d-none');
                        $('#sem3ms1').modal('hide');
                        $('#sem3fms1')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //MS 2/CIA 2	

        $(document).on('submit', '#sem3ms2f', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem3ms2f", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem3ms2fMessage').addClass('d-none');
                        $('#sem3ms2').modal('hide');
                        $('#sem3ms2f')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem3table').load(location.href + " #sem3table");


                    } else if (res.status == 500) {
                        $('#sem3ms2fMessage').addClass('d-none');
                        $('#sem3ms2').modal('hide');
                        $('#sem3ms2f')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //prep

        $(document).on('submit', '#sem3prepf', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem3prepf", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem3prepfMessage').addClass('d-none');
                        $('#sem3prep').modal('hide');
                        $('#sem3prepf')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem3table').load(location.href + " #sem3table");


                    } else if (res.status == 500) {
                        $('#sem3prepfMessage').addClass('d-none');
                        $('#sem3prep').modal('hide');
                        $('#sem3prepf')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });


        //end sem

        $(document).on('submit', '#sem3semf', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem3semf", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem3semfMessage').addClass('d-none');
                        $('#sem3sem').modal('hide');
                        $('#sem3semf')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem3table').load(location.href + " #sem3table");


                    } else if (res.status == 500) {
                        $('#sem3semfMessage').addClass('d-none');
                        $('#sem3sem').modal('hide');
                        $('#sem3semf')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //delete
        $(document).on('click', '.sem3deleteBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id5 = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_s3': true,
                        'student_id5': student_id5
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            // Reload the content of all modals
                            $('#sem3table').load(location.href + " #sem3table");
                            $('#sem3ms1 .modal-content').load(location.href + " #sem3ms1 .modal-content");
                            $('#sem3ms2 .modal-content').load(location.href + " #sem3ms2 .modal-content");
                            $('#sem3prep .modal-content').load(location.href + " #sem3prep .modal-content");
                            $('#sem3sem .modal-content').load(location.href + " #sem3sem .modal-content");
                        }
                    }
                });
            }
        });


        //sem 4

        //sem4 
        $(document).ready(function() {
            let counter = 2;

            $('#add-input4').click(function() {
                $('#input-container4').append(`
                    <div class="mb-3">
                        <input type="text" class="form-control" name="dynamic_input[]" placeholder="Subject ${counter}">
                    </div>
                `);
                counter++;
            });

            $('#submit-form4').click(function() {

                const formData = $('#sem4fex').serialize();
                const customFlag = 'save_s4=true';
                const formDataWithFlag = formData + '&' + customFlag;
                $.ajax({
                    type: 'POST',
                    url: 'scode.php',
                    data: formDataWithFlag,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {

                            $('#sem1Message').addClass('d-none');
                            $('#sem4madd').modal('hide');
                            $('#sem4fex')[0].reset();

                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            // Reload the content of all modals
                            $('#sem4table').load(location.href + " #sem4table");
                            $('#sem4ms1 .modal-content').load(location.href + " #sem4ms1 .modal-content");
                            $('#sem4ms2 .modal-content').load(location.href + " #sem4ms2 .modal-content");
                            $('#sem4prep .modal-content').load(location.href + " #sem4prep .modal-content");
                            $('#sem4sem .modal-content').load(location.href + " #sem4sem .modal-content");





                        }
                    }
                });
            });
        });




        //ms1
        $(document).on('submit', '#sem4fms1', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem4fms1", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem4fms1Message').addClass('d-none');
                        $('#sem4ms1').modal('hide');
                        $('#sem4fms1')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem4table').load(location.href + " #sem4table");


                    } else if (res.status == 500) {
                        $('#sem4fms1Message').addClass('d-none');
                        $('#sem4ms1').modal('hide');
                        $('#sem4fms1')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //MS 2/CIA 2	

        $(document).on('submit', '#sem4ms2f', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem4ms2f", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem4ms2fMessage').addClass('d-none');
                        $('#sem4ms2').modal('hide');
                        $('#sem4ms2f')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem4table').load(location.href + " #sem4table");


                    } else if (res.status == 500) {
                        $('#sem4ms2fMessage').addClass('d-none');
                        $('#sem4ms2').modal('hide');
                        $('#sem4ms2f')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //prep

        $(document).on('submit', '#sem4prepf', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem4prepf", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem4prepfMessage').addClass('d-none');
                        $('#sem4prep').modal('hide');
                        $('#sem4prepf')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem4table').load(location.href + " #sem4table");


                    } else if (res.status == 500) {
                        $('#sem4prepfMessage').addClass('d-none');
                        $('#sem4prep').modal('hide');
                        $('#sem4prepf')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });


        //end sem

        $(document).on('submit', '#sem4semf', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem4semf", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem4semfMessage').addClass('d-none');
                        $('#sem4sem').modal('hide');
                        $('#sem4semf')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem4table').load(location.href + " #sem4table");


                    } else if (res.status == 500) {
                        $('#sem4semfMessage').addClass('d-none');
                        $('#sem4sem').modal('hide');
                        $('#sem4semf')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //delete
        $(document).on('click', '.sem4deleteBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id5 = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_s4': true,
                        'student_id5': student_id5
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            // Reload the content of all modals
                            $('#sem4table').load(location.href + " #sem4table");
                            $('#sem4ms1 .modal-content').load(location.href + " #sem4ms1 .modal-content");
                            $('#sem4ms2 .modal-content').load(location.href + " #sem4ms2 .modal-content");
                            $('#sem4prep .modal-content').load(location.href + " #sem4prep .modal-content");
                            $('#sem4sem .modal-content').load(location.href + " #sem4sem .modal-content");
                        }
                    }
                });
            }
        });


        //sem5

        //sem5 
        $(document).ready(function() {
            let counter = 2;

            $('#add-input5').click(function() {
                $('#input-container5').append(`
                    <div class="mb-3">
                        <input type="text" class="form-control" name="dynamic_input[]" placeholder="Subject ${counter}">
                    </div>
                `);
                counter++;
            });

            $('#submit-form5').click(function() {

                const formData = $('#sem5fex').serialize();
                const customFlag = 'save_s5=true';
                const formDataWithFlag = formData + '&' + customFlag;
                $.ajax({
                    type: 'POST',
                    url: 'scode.php',
                    data: formDataWithFlag,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {

                            $('#sem1Message').addClass('d-none');
                            $('#sem5madd').modal('hide');
                            $('#sem5fex')[0].reset();

                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            // Reload the content of all modals
                            $('#sem5table').load(location.href + " #sem5table");
                            $('#sem5ms1 .modal-content').load(location.href + " #sem5ms1 .modal-content");
                            $('#sem5ms2 .modal-content').load(location.href + " #sem5ms2 .modal-content");
                            $('#sem5prep .modal-content').load(location.href + " #sem5prep .modal-content");
                            $('#sem5sem .modal-content').load(location.href + " #sem5sem .modal-content");





                        }
                    }
                });
            });
        });




        //ms1
        $(document).on('submit', '#sem5fms1', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem5fms1", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem5fms1Message').addClass('d-none');
                        $('#sem5ms1').modal('hide');
                        $('#sem5fms1')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem5table').load(location.href + " #sem5table");


                    } else if (res.status == 500) {
                        $('#sem5fms1Message').addClass('d-none');
                        $('#sem5ms1').modal('hide');
                        $('#sem5fms1')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //MS 2/CIA 2	

        $(document).on('submit', '#sem5ms2f', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem5ms2f", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem5ms2fMessage').addClass('d-none');
                        $('#sem5ms2').modal('hide');
                        $('#sem5ms2f')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem5table').load(location.href + " #sem5table");


                    } else if (res.status == 500) {
                        $('#sem5ms2fMessage').addClass('d-none');
                        $('#sem5ms2').modal('hide');
                        $('#sem5ms2f')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //prep

        $(document).on('submit', '#sem5prepf', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem5prepf", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem5prepfMessage').addClass('d-none');
                        $('#sem5prep').modal('hide');
                        $('#sem5prepf')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem5table').load(location.href + " #sem5table");


                    } else if (res.status == 500) {
                        $('#sem5prepfMessage').addClass('d-none');
                        $('#sem5prep').modal('hide');
                        $('#sem5prepf')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });


        //end sem

        $(document).on('submit', '#sem5semf', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem5semf", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem5semfMessage').addClass('d-none');
                        $('#sem5sem').modal('hide');
                        $('#sem5semf')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem5table').load(location.href + " #sem5table");


                    } else if (res.status == 500) {
                        $('#sem5semfMessage').addClass('d-none');
                        $('#sem5sem').modal('hide');
                        $('#sem5semf')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //delete
        $(document).on('click', '.sem5deleteBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id5 = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_s5': true,
                        'student_id5': student_id5
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            // Reload the content of all modals
                            $('#sem5table').load(location.href + " #sem5table");
                            $('#sem5ms1 .modal-content').load(location.href + " #sem5ms1 .modal-content");
                            $('#sem5ms2 .modal-content').load(location.href + " #sem5ms2 .modal-content");
                            $('#sem5prep .modal-content').load(location.href + " #sem5prep .modal-content");
                            $('#sem5sem .modal-content').load(location.href + " #sem5sem .modal-content");
                        }
                    }
                });
            }
        });

        //sem6 
        $(document).ready(function() {
            let counter = 2;

            $('#add-input6').click(function() {
                $('#input-container6').append(`
                    <div class="mb-3">
                        <input type="text" class="form-control" name="dynamic_input[]" placeholder="Subject ${counter}">
                    </div>
                `);
                counter++;
            });

            $('#submit-form6').click(function() {

                const formData = $('#sem6fex').serialize();
                const customFlag = 'save_s6=true';
                const formDataWithFlag = formData + '&' + customFlag;
                $.ajax({
                    type: 'POST',
                    url: 'scode.php',
                    data: formDataWithFlag,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {

                            $('#sem1Message').addClass('d-none');
                            $('#sem6madd').modal('hide');
                            $('#sem6fex')[0].reset();

                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            // Reload the content of all modals
                            $('#sem6table').load(location.href + " #sem6table");
                            $('#sem6ms1 .modal-content').load(location.href + " #sem6ms1 .modal-content");
                            $('#sem6ms2 .modal-content').load(location.href + " #sem6ms2 .modal-content");
                            $('#sem6prep .modal-content').load(location.href + " #sem6prep .modal-content");
                            $('#sem6sem .modal-content').load(location.href + " #sem6sem .modal-content");





                        }
                    }
                });
            });
        });




        //ms1
        $(document).on('submit', '#sem6fms1', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem6fms1", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem6fms1Message').addClass('d-none');
                        $('#sem6ms1').modal('hide');
                        $('#sem6fms1')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem6table').load(location.href + " #sem6table");


                    } else if (res.status == 500) {
                        $('#sem6fms1Message').addClass('d-none');
                        $('#sem6ms1').modal('hide');
                        $('#sem6fms1')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //MS 2/CIA 2	

        $(document).on('submit', '#sem6ms2f', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem6ms2f", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem6ms2fMessage').addClass('d-none');
                        $('#sem6ms2').modal('hide');
                        $('#sem6ms2f')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem6table').load(location.href + " #sem6table");


                    } else if (res.status == 500) {
                        $('#sem6ms2fMessage').addClass('d-none');
                        $('#sem6ms2').modal('hide');
                        $('#sem6ms2f')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //prep

        $(document).on('submit', '#sem6prepf', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem6prepf", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem6prepfMessage').addClass('d-none');
                        $('#sem6prep').modal('hide');
                        $('#sem6prepf')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem6table').load(location.href + " #sem6table");


                    } else if (res.status == 500) {
                        $('#sem6prepfMessage').addClass('d-none');
                        $('#sem6prep').modal('hide');
                        $('#sem6prepf')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });


        //end sem

        $(document).on('submit', '#sem6semf', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem6semf", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem6semfMessage').addClass('d-none');
                        $('#sem6sem').modal('hide');
                        $('#sem6semf')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem6table').load(location.href + " #sem6table");


                    } else if (res.status == 500) {
                        $('#sem6semfMessage').addClass('d-none');
                        $('#sem6sem').modal('hide');
                        $('#sem6semf')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //delete
        $(document).on('click', '.sem6deleteBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id5 = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_s6': true,
                        'student_id5': student_id5
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            // Reload the content of all modals
                            $('#sem6table').load(location.href + " #sem6table");
                            $('#sem6ms1 .modal-content').load(location.href + " #sem6ms1 .modal-content");
                            $('#sem6ms2 .modal-content').load(location.href + " #sem6ms2 .modal-content");
                            $('#sem6prep .modal-content').load(location.href + " #sem6prep .modal-content");
                            $('#sem6sem .modal-content').load(location.href + " #sem6sem .modal-content");
                        }
                    }
                });
            }
        });

        //sem7 
        $(document).ready(function() {
            let counter = 2;

            $('#add-input7').click(function() {
                $('#input-container7').append(`
                    <div class="mb-3">
                        <input type="text" class="form-control" name="dynamic_input[]" placeholder="Subject ${counter}">
                    </div>
                `);
                counter++;
            });

            $('#submit-form7').click(function() {

                const formData = $('#sem7fex').serialize();
                const customFlag = 'save_s7=true';
                const formDataWithFlag = formData + '&' + customFlag;
                $.ajax({
                    type: 'POST',
                    url: 'scode.php',
                    data: formDataWithFlag,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {

                            $('#sem7Message').addClass('d-none');
                            $('#sem7madd').modal('hide');
                            $('#sem7fex')[0].reset();

                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            // Reload the content of all modals
                            $('#sem7table').load(location.href + " #sem7table");
                            $('#sem7ms1 .modal-content').load(location.href + " #sem7ms1 .modal-content");
                            $('#sem7ms2 .modal-content').load(location.href + " #sem7ms2 .modal-content");
                            $('#sem7prep .modal-content').load(location.href + " #sem7prep .modal-content");
                            $('#sem7sem .modal-content').load(location.href + " #sem7sem .modal-content");





                        }
                    }
                });
            });
        });




        //ms1
        $(document).on('submit', '#sem7fms1', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem7fms1", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem7fms1Message').addClass('d-none');
                        $('#sem7ms1').modal('hide');
                        $('#sem7fms1')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem7table').load(location.href + " #sem7table");


                    } else if (res.status == 500) {
                        $('#sem7fms1Message').addClass('d-none');
                        $('#sem7ms1').modal('hide');
                        $('#sem7fms1')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //MS 2/CIA 2	

        $(document).on('submit', '#sem7ms2f', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem7ms2f", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem7ms2fMessage').addClass('d-none');
                        $('#sem7ms2').modal('hide');
                        $('#sem7ms2f')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem7table').load(location.href + " #sem7table");


                    } else if (res.status == 500) {
                        $('#sem7ms2fMessage').addClass('d-none');
                        $('#sem7ms2').modal('hide');
                        $('#sem7ms2f')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //prep

        $(document).on('submit', '#sem7prepf', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem7prepf", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem7prepfMessage').addClass('d-none');
                        $('#sem7prep').modal('hide');
                        $('#sem7prepf')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem7table').load(location.href + " #sem7table");


                    } else if (res.status == 500) {
                        $('#sem7prepfMessage').addClass('d-none');
                        $('#sem7prep').modal('hide');
                        $('#sem7prepf')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });


        //end sem

        $(document).on('submit', '#sem7semf', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem7semf", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem7semfMessage').addClass('d-none');
                        $('#sem7sem').modal('hide');
                        $('#sem7semf')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem7table').load(location.href + " #sem7table");


                    } else if (res.status == 500) {
                        $('#sem7semfMessage').addClass('d-none');
                        $('#sem7sem').modal('hide');
                        $('#sem7semf')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //delete
        $(document).on('click', '.sem7deleteBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id5 = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_s7': true,
                        'student_id5': student_id5
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            // Reload the content of all modals
                            $('#sem7table').load(location.href + " #sem7table");
                            $('#sem7ms1 .modal-content').load(location.href + " #sem7ms1 .modal-content");
                            $('#sem7ms2 .modal-content').load(location.href + " #sem7ms2 .modal-content");
                            $('#sem7prep .modal-content').load(location.href + " #sem7prep .modal-content");
                            $('#sem7sem .modal-content').load(location.href + " #sem7sem .modal-content");
                        }
                    }
                });
            }
        });

        //sem8 
        $(document).ready(function() {
            let counter = 2;

            $('#add-input8').click(function() {
                $('#input-container8').append(`
                    <div class="mb-3">
                        <input type="text" class="form-control" name="dynamic_input[]" placeholder="Subject ${counter}">
                    </div>
                `);
                counter++;
            });

            $('#submit-form8').click(function() {

                const formData = $('#sem8fex').serialize();
                const customFlag = 'save_s8=true';
                const formDataWithFlag = formData + '&' + customFlag;
                $.ajax({
                    type: 'POST',
                    url: 'scode.php',
                    data: formDataWithFlag,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {

                            $('#sem8Message').addClass('d-none');
                            $('#sem8madd').modal('hide');
                            $('#sem8fex')[0].reset();

                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            // Reload the content of all modals
                            $('#sem8table').load(location.href + " #sem8table");
                            $('#sem8ms1 .modal-content').load(location.href + " #sem8ms1 .modal-content");
                            $('#sem8ms2 .modal-content').load(location.href + " #sem8ms2 .modal-content");
                            $('#sem8prep .modal-content').load(location.href + " #sem8prep .modal-content");
                            $('#sem8sem .modal-content').load(location.href + " #sem8sem .modal-content");





                        }
                    }
                });
            });
        });




        //ms1
        $(document).on('submit', '#sem8fms1', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem8fms1", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem8fms1Message').addClass('d-none');
                        $('#sem8ms1').modal('hide');
                        $('#sem8fms1')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem8table').load(location.href + " #sem8table");


                    } else if (res.status == 500) {
                        $('#sem8fms1Message').addClass('d-none');
                        $('#sem8ms1').modal('hide');
                        $('#sem8fms1')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //MS 2/CIA 2	

        $(document).on('submit', '#sem8ms2f', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem8ms2f", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem8ms2fMessage').addClass('d-none');
                        $('#sem8ms2').modal('hide');
                        $('#sem8ms2f')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem8table').load(location.href + " #sem8table");


                    } else if (res.status == 500) {
                        $('#sem8ms2fMessage').addClass('d-none');
                        $('#sem8ms2').modal('hide');
                        $('#sem8ms2f')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //prep

        $(document).on('submit', '#sem8prepf', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem8prepf", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem8prepfMessage').addClass('d-none');
                        $('#sem8prep').modal('hide');
                        $('#sem8prepf')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem8table').load(location.href + " #sem8table");


                    } else if (res.status == 500) {
                        $('#sem8prepfMessage').addClass('d-none');
                        $('#sem8prep').modal('hide');
                        $('#sem8prepf')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });


        //end sem

        $(document).on('submit', '#sem8semf', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem8semf", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        $('#sem8semfMessage').addClass('d-none');
                        $('#sem8sem').modal('hide');
                        $('#sem8semf')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem8table').load(location.href + " #sem8table");


                    } else if (res.status == 500) {
                        $('#sem8semfMessage').addClass('d-none');
                        $('#sem8sem').modal('hide');
                        $('#sem8semf')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //delete
        $(document).on('click', '.sem8deleteBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id5 = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_s8': true,
                        'student_id5': student_id5
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            // Reload the content of all modals
                            $('#sem8table').load(location.href + " #sem8table");
                            $('#sem8ms1 .modal-content').load(location.href + " #sem8ms1 .modal-content");
                            $('#sem8ms2 .modal-content').load(location.href + " #sem8ms2 .modal-content");
                            $('#sem8prep .modal-content').load(location.href + " #sem8prep .modal-content");
                            $('#sem8sem .modal-content').load(location.href + " #sem8sem .modal-content");
                        }
                    }
                });
            }
        });
    </script>

    <script>
        $(document).on('submit', '#sem1SGf', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sem1SGf", true);
            console.log(formData);
            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    console.log(res.status);
                    if (res.status == 422) {
                        $('#sem1SGMessage').removeClass('d-none');
                        $('#sem1SGMessage').text(res.message);

                    } else if (res.status == 200) {

                        $('#sem1SGMessage').addClass('d-none');
                        $('#sem1SG').modal('hide');
                        $('#sem1SGf')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#sem1sgpa').load(location.href + " #sem1sgpa");
                        $('#sem2sgpa').load(location.href + " #sem2sgpa");
                        $('#sem3sgpa').load(location.href + " #sem3sgpa");
                        $('#sem4sgpa').load(location.href + " #sem4sgpa");
                        $('#sem5sgpa').load(location.href + " #sem5sgpa");
                        $('#sem6sgpa').load(location.href + " #sem6sgpa");
                        $('#sem7sgpa').load(location.href + " #sem74sgpa");
                        $('#sem8sgpa').load(location.href + " #sem8sgpa");

                    } else if (res.status == 500) {
                        $('#sem1SGMessage').addClass('d-none');
                        $('#sem1SG').modal('hide');
                        $('#sem1SGf')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });
    </script>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
    <script>
        // Basic Example with form
        var form = $("#example-form");
        form.validate({
            errorPlacement: function errorPlacement(error, element) {
                element.before(error);
            },
            rules: {
                confirm: {
                    equalTo: "#password"
                }
            }
        });

        jQuery('.mydatepicker').datepicker();
        jQuery('#datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true
        });
    </script>

    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
    <script>
        function fileValidation() {
            var fileInput =
                document.getElementById('validationCustomUsername');
            var fileSize = ((document.getElementById('validationCustomUsername').files[0].size) / 1024);
            var filePath = fileInput.value;

            // Allowing file type
            var allowedExtensions =
                /(\.jpg|\.jpeg|\.png|\.gif)$/i;

            if (!allowedExtensions.exec(filePath)) {
                swal("OOPS!", "Only Image Files are allowed!", "error");
                fileInput.value = '';
                return false;
            } else {
                if (fileSize > 2000) {
                    swal("OOPS!", "File size should be less than 2MB!", "error");
                    fileInput.value = '';
                    return false;
                }
            }

        }

        function fileValidation2() {
            var fileInput =
                document.getElementById('uploadFile');
            var fileSize = ((document.getElementById('uploadFile').files[0].size) / 1024);
            var filePath = fileInput.value;
            document.getElementById("tutorial").innerHTML = " ";
            // Allowing file type
            var allowedExtensions =
                /(\.jpg|\.jpeg|\.png|\.gif)$/i;

            if (!allowedExtensions.exec(filePath)) {
                var msg = "Only Image Files are allowed!";
                fileInput.value = '';
                document.getElementById("tutorial").innerHTML = msg;
            } else {
                if (fileSize > 2000) {
                    var msg = "File size should be less than 2MB!";
                    fileInput.value = '';
                    document.getElementById("tutorial").innerHTML = msg;
                }
            }



        }


        function fileValidation3() {
            var fileInput =
                document.getElementById('uploadFile2');
            var fileSize = ((document.getElementById('uploadFile2').files[0].size) / 1024);
            var filePath = fileInput.value;
            document.getElementById("tutorial2").innerHTML = " ";
            // Allowing file type
            var allowedExtensions =
                /(\.jpg|\.jpeg|\.png|\.gif)$/i;

            if (!allowedExtensions.exec(filePath)) {
                var msg = "Only images are allowed!";
                fileInput.value = '';
                document.getElementById("tutorial2").innerHTML = msg;
            } else {
                if (fileSize > 2000) {
                    var msg = "File size should be less than 2MB!";
                    fileInput.value = '';
                    document.getElementById("tutorial2").innerHTML = msg;
                }
            }



        }

        function fileValidation4() {
            var fileInput =
                document.getElementById('uploadFile4');
            var fileSize = ((document.getElementById('uploadFile4').files[0].size) / 1024);
            var filePath = fileInput.value;
            document.getElementById("tutorial4").innerHTML = " ";
            // Allowing file type
            var allowedExtensions =
                /(\.jpg|\.jpeg|\.png|\.gif)$/i;

            if (!allowedExtensions.exec(filePath)) {
                var msg = "Only images are allowed!";
                fileInput.value = '';
                document.getElementById("tutorial4").innerHTML = msg;
            } else {
                if (fileSize > 2000) {
                    var msg = "File size should be less than 2MB!";
                    fileInput.value = '';
                    document.getElementById("tutorial4").innerHTML = msg;
                }
            }



        }
    </script>


</body>

</html>