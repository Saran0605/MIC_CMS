<?php
include("config.php");
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

        label[for][data-required]::after {
            content: " *";
            color: #dc3545;
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

        .placement-card,
        .higher-studies-card,
        .business-card,
        .entrepreneur-card {
            transition: transform 0.3s ease;
            margin: 15px 0;
        }

        .placement-card:hover,
        .higher-studies-card:hover,
        .business-card:hover,
        .entrepreneur-card:hover {
            transform: translateY(-5px);
        }




        .placement-card {
            background-color: #e3f2fd;
            /* Light Blue */
        }

        .higher-studies-card {
            background-color: #f3e5f5;
            /* Light Purple */
        }

        .business-card {
            background-color: #e8f5e9;
            /* Light Green */
        }

        .entrepreneur-card {
            background-color: #fff3e0;
            /* Light Orange */
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
                    <li class="breadcrumb-item active" aria-current="page">Academic Profile </li>
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
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="Asse-tab" data-bs-toggle="tab" href="#assessment" role="tab" aria-controls="assessment" aria-selected="false">
                                    <i class="fas fa-pencil-alt tab-icon"></i> Assessment Score
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="Co-Curr-tab" data-bs-toggle="tab" href="#posting" role="tab" aria-controls="posting" aria-selected="false">
                                    <i class="fas fa-book tab-icon"></i> Co-Curricular
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="Extra-Curr-tab" data-bs-toggle="tab" href="#train" role="tab" aria-controls="train" aria-selected="false">
                                    <i class="fas fa-gamepad tab-icon"></i> Extra-Curricular
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="lang-tab" data-bs-toggle="tab" href="#lang" role="tab" aria-controls="lang" aria-selected="false">
                                    <i class="fas fa-language tab-icon"></i> International Languages
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="Projects-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">
                                    <i class="fas fa-laptop tab-icon"></i> Projects Done
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link " id="acad-tab" data-bs-toggle="tab" href="#acad" role="tab" aria-controls="acad" aria-selected="true">
                                    <i class="fas fa-trophy tab-icon"></i> International Certifications
                                </a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                    <i class="fas fa-briefcase tab-icon"></i> Internship/Courses
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="plac-tab" data-bs-toggle="tab" href="#punish" role="tab" aria-controls="punish" aria-selected="false">
                                    <i class="fas fa-medal tab-icon"></i> Placement Details
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="sem6-tab" data-bs-toggle="tab" href="#career" role="tab" aria-controls="punish" aria-selected="false">
                                    <i class="fas fa-route    tab-icon"></i> career Development
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content tabcontent-border">
                            <!-- assessment tabs -->
                            <div class="tab-pane active p-20" id="assessment" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>

                                                    <button type="button" style="float: right;"
                                                        class="btn btn-secondary" data-bs-toggle="modal"
                                                        data-bs-target="#cpadd">
                                                        Add Assessment Score
                                                    </button>
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="myTablecp"
                                                        class="table table-bordered table-striped">
                                                        <thead class="gradient-header">
                                                            <tr>
                                                                <th><b>S.No</b></th>
                                                                <th><b>Date</b></th>
                                                                <th><b>HackerRank</b></th>
                                                                <th><b>SkillRack/Codetantra</b></th>
                                                                <th><b>Other</b></th>
                                                                <th><b>Action Taken</b></th>
                                                                <th align="center"><b>Action</b></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php

                                                            $query = "SELECT * FROM straining where sid='$s' ORDER BY uid DESC";
                                                            $query_run = mysqli_query($db, $query);

                                                            if (mysqli_num_rows($query_run) > 0) {
                                                                $sn = 1;
                                                                foreach ($query_run as $student) {

                                                            ?>
                                                                    <tr>
                                                                        <td><?= $sn ?></td>
                                                                        <td><?= $student['date'] ?></td>

                                                                        <td><?= $student['hack'] ?></td>
                                                                        <td><?= $student['skill'] ?></td>
                                                                        <td><?= $student['ict'] ?></td>
                                                                        <td><?php if ($student['status'] == 1) {
                                                                                echo $student['action'];
                                                                            }
                                                                            ?></td>
                                                                        <td align="center">


                                                                            <?php
                                                                            if ($student['status'] == 0) { ?>

                                                                                <button type="button"
                                                                                    value="<?= $student['uid']; ?>"
                                                                                    class="deletecpBtn btn btn-danger  btn-sm">Delete</button>
                                                                                <button type="button" value=""
                                                                                    class="btn btn-warning btn-sm">Pending</button>
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <button type="button" value=""
                                                                                    class="btn btn-success btn-sm">Approved</button>
                                                                            <?php
                                                                            }
                                                                            ?>
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

                            <!-- posting tabs -->
                            <div class="tab-pane  p-20" id="posting" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>

                                                    <button type="button" style="float: right;"
                                                        class="btn btn-secondary" data-bs-toggle="modal"
                                                        data-bs-target="#postingadd">
                                                        Add Co-Curricular
                                                    </button>
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="myTablecc"
                                                        class="table table-bordered table-striped">
                                                        <thead class="gradient-header">
                                                            <tr>
                                                                <th><b>S.No</b></th>
                                                                <th><b>Academic Year</b></th>
                                                                <th><b>Name of the event</b></th>
                                                                <th><b>Level</b></th>
                                                                <th><b>Organizer</b></th>
                                                                <th><b>Prize</b></th>
                                                                <th><b>View</b></th>
                                                                <th align="center"><b>Action</b></th>
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
                                                                        <td><?= $student['ayear'] ?></td>
                                                                        <td><?= $student['event'] ?></td>
                                                                        <td><?= $student['level'] ?></td>
                                                                        <td><?= $student['organiser'] ?></td>
                                                                        <td><?= $student['prize'] ?></td>
                                                                        <td align="center"><button type="button"
                                                                                id="ledonof" value="<?= $student['uid']; ?>"
                                                                                class="btnimgco btn btn-info btn-sm"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#studentViewModalco">View</button>
                                                                        </td>
                                                                        <td align="center">
                                                                            <?php if ($student['status'] == 1): ?>
                                                                                <button type="button"
                                                                                    class="btn btn-success btn-sm">Approved</button>
                                                                            <?php else: ?>
                                                                                <button type="button"
                                                                                    value="<?= $student['uid']; ?>"
                                                                                    class="deletecoBtn btn btn-danger btn-sm">Delete</button>
                                                                            <?php endif; ?>
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

                            <!-- Extra Curricular tab -->

                            <div class="tab-pane p-20" id="train" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>

                                                    <button type="button" style="float: right;"
                                                        class="btn btn-secondary" data-bs-toggle="modal"
                                                        data-bs-target="#extraadd">
                                                        Add Extra-Curricular
                                                    </button>
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="myTableex"
                                                        class="table table-bordered table-striped">
                                                        <thead class="gradient-header">
                                                            <tr>
                                                                <th><b>S.No</b></th>
                                                                <th><b>Academic Year</b></th>
                                                                <th><b>Name of the event</b></th>
                                                                <th><b>Level</b></th>
                                                                <th><b>Organizer</b></th>
                                                                <th><b>Prize</b></th>
                                                                <th><b>View</b></th>
                                                                <th align="center"><b>Action</b></th>
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
                                                                        <td><?= $student['ayear'] ?></td>
                                                                        <td><?= $student['event'] ?></td>
                                                                        <td><?= $student['level'] ?></td>
                                                                        <td><?= $student['organiser'] ?></td>
                                                                        <td><?= $student['prize'] ?></td>
                                                                        <td align="center"><button type="button"
                                                                                id="ledonof" value="<?= $student['uid']; ?>"
                                                                                class="btnimgex btn btn-info btn-sm"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#studentViewModalex">View</button>
                                                                        </td>
                                                                        <td align="center">
                                                                            <?php if ($student['status'] == 1): ?>
                                                                                <button type="button"
                                                                                    class="btn btn-success btn-sm">Approved</button>
                                                                            <?php else: ?>
                                                                                <button type="button"
                                                                                    value="<?= $student['uid']; ?>"
                                                                                    class="deleteexBtn btn btn-danger btn-sm">Delete</button>
                                                                            <?php endif; ?>
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

                            <!-- Language tab start -->
                            <div class="tab-pane p-20" id="lang" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>

                                                    <button type="button" style="float: right;"
                                                        class="btn btn-secondary" data-bs-toggle="modal"
                                                        data-bs-target="#lanadd">
                                                        Add Language Details
                                                    </button>
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="myTablelan"
                                                        class="table table-bordered table-striped">
                                                        <thead class="gradient-header">
                                                            <tr>
                                                                <th><b>S.No</b></th>.
                                                                <th><b>Academic Year</b></th>
                                                                <th><b>Language</b></th>
                                                                <th><b>Level</b></th>
                                                                <th><b>View</b></th>
                                                                <th align="center"><b>Action</b></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php

                                                            $query = "SELECT * FROM slang where uid='$s'";
                                                            $query_run = mysqli_query($db, $query);

                                                            if (mysqli_num_rows($query_run) > 0) {
                                                                $sn = 1;
                                                                foreach ($query_run as $student) {

                                                            ?>
                                                                    <tr>
                                                                        <td><?= $sn ?></td>
                                                                        <td><?= $student['ayear'] ?></td>
                                                                        <td><?= $student['lang'] ?></td>
                                                                        <td><?= $student['level'] ?></td>
                                                                        <td align="center">
                                                                            <button type="button" id="ledonof"
                                                                                value="<?= $student['id']; ?>"
                                                                                class="btnimglang btn btn-info btn-sm"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#studentViewModallanu">
                                                                                View
                                                                            </button>
                                                                        </td>
                                                                        <td align="center">
                                                                            <?php if ($student['status'] == 1): ?>
                                                                                <button type="button"
                                                                                    class="btn btn-success btn-sm">Approved</button>
                                                                            <?php else: ?>
                                                                                <button type="button"
                                                                                    value="<?= $student['id']; ?>"
                                                                                    class="deletelangBtn btn btn-danger btn-sm">Delete</button>
                                                                            <?php endif; ?>
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

                            <!-- Project tab start -->
                            <div class="tab-pane p-20" id="home" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>

                                                    <button type="button" style="float: right;"
                                                        class="btn btn-secondary" data-bs-toggle="modal"
                                                        data-bs-target="#projectadd">
                                                        Add Project
                                                    </button>
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="myTable0" class="table table-bordered table-striped">
                                                        <thead class="gradient-header">
                                                            <tr>
                                                                <th><b>S.No</b></th>
                                                                <th><b>Academic Year</b></th>
                                                                <th><b>Semester</b></th>
                                                                <th><b>Title of the project</b></th>
                                                                <th
                                                                    style="word-wrap: break-word; white-space: normal; max-width: 50px;">
                                                                    <b>Github link</b>
                                                                </th>
                                                                <th><b>Remarks</b></th>
                                                                <th><b>Action</b></th>
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
                                                                        <td><?= $student['ayear'] ?></td>
                                                                        <td><?= $student['semester'] ?></td>
                                                                        <td><?= $student['title'] ?></td>
                                                                        <td
                                                                            style="word-wrap: break-word; max-width: 150px; overflow-wrap: break-word;">
                                                                            <?= $student['github'] ?>
                                                                        </td>
                                                                        <td><?= $student['remark'] ?></td>
                                                                        <td align="center">
                                                                            <?php if ($student['status'] == 1): ?>
                                                                                <button type="button"
                                                                                    class="btn btn-success btn-sm">Approved</button>
                                                                            <?php else: ?>
                                                                                <button type="button"
                                                                                    value="<?= $student['uid']; ?>"
                                                                                    class="deletePrBtn btn btn-danger btn-sm">Delete</button>
                                                                            <?php endif; ?>
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

                            <!-- International Certifications tab start -->
                            <div class="tab-pane p-20" id="acad" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>

                                                    <button type="button" style="float: right;"
                                                        class="btn btn-secondary" data-bs-toggle="modal"
                                                        data-bs-target="#pcadd">
                                                        Add Certifications Details
                                                    </button>
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="myTablepr"
                                                        class="table table-bordered table-striped">
                                                        <thead class="gradient-header">
                                                            <tr>
                                                                <th><b>S.No</b></th>.
                                                                <th><b>Academic Year</b></th>
                                                                <th><b>Name of the Certificate</b></th>
                                                                <th><b>Duration</b></th>
                                                                <th><b>Organizer</b></th>

                                                                <th><b>View</b></th>
                                                                <th align="center"><b>Action</b></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php

                                                            $query = "SELECT * FROM s_i_certification where sid='$s'";
                                                            $query_run = mysqli_query($db, $query);

                                                            if (mysqli_num_rows($query_run) > 0) {
                                                                $sn = 1;
                                                                foreach ($query_run as $student) {

                                                            ?>
                                                                    <tr>
                                                                        <td><?= $sn ?></td>
                                                                        <td><?= $student['ayear'] ?></td>
                                                                        <td><?= $student['cname'] ?></td>
                                                                        <td><?= $student['duration'] ?></td>
                                                                        <td><?= $student['organiser'] ?></td>

                                                                        <td align="center"><button type="button"
                                                                                id="ledonof" value="<?= $student['uid']; ?>"
                                                                                class="btnimgcert btn btn-info btn-sm"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#studentViewModal4">View</button>
                                                                        </td>
                                                                        <td align="center">
                                                                            <?php if ($student['status'] == 1): ?>
                                                                                <button type="button"
                                                                                    class="btn btn-success btn-sm">Approved</button>
                                                                            <?php else: ?>
                                                                                <button type="button"
                                                                                    value="<?= $student['uid']; ?>"
                                                                                    class="deletepcBtn btn btn-danger btn-sm">Delete</button>
                                                                            <?php endif; ?>
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

                            <!-- Internship / Course tab start -->
                            <div class="tab-pane  p-20" id="profile" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>

                                                    <button type="button" style="float: right;"
                                                        class="btn btn-secondary" data-bs-toggle="modal"
                                                        data-bs-target="#iadd">
                                                        Add Internship / Course Details
                                                    </button>
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="myTablei" class="table table-bordered table-striped">
                                                        <thead class="gradient-header">
                                                            <tr>
                                                                <th><b>S.No</b></th>
                                                                <th><b>Academic Year</b></th>
                                                                <th><b>Name of the Program / Title</b></th>
                                                                <th><b>Type</b></th>
                                                                <th><b>Organizer</b></th>
                                                                <th><b>Duration</b></th>
                                                                <th><b>Remarks</b></th>
                                                                <th><b>View</b></th>
                                                                <th align="center"><b>Action</b></th>
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
                                                                        <td><?= $student['ayear'] ?></td>
                                                                        <td><?= $student['iname'] ?></td>
                                                                        <td><?= $student['type'] ?></td>
                                                                        <td><?= $student['org'] ?></td>
                                                                        <td><?= $student['dur'] ?></td>
                                                                        <td><?= $student['rem'] ?></td>
                                                                        <td align="center"><button type="button"
                                                                                id="ledonof" value="<?= $student['uid']; ?>"
                                                                                class="btnimgi btn btn-info btn-sm"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#studentViewModali">View</button>
                                                                        </td>
                                                                        <!-- 
                                        <td align="center">
                                            <button type="button" id="ledonof"
                                                data-uid="<?= $student['uid']; ?>"
                                                data-cert="sintern"
                                                class="btnimgcert btn-success btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#studentViewModal4">
                                                View
                                            </button>
                                        </td> -->

                                                                        <td align="center">
                                                                            <?php if ($student['status'] == 1): ?>
                                                                                <button type="button"
                                                                                    class="btn btn-success btn-sm">Approved</button>
                                                                            <?php else: ?>
                                                                                <button type="button"
                                                                                    value="<?= $student['uid']; ?>"
                                                                                    class="deleteiBtn btn btn-danger btn-sm">Delete</button>
                                                                            <?php endif; ?>
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

                            <!--Punish tab starts -->
                            <div class="tab-pane  p-20" id="punish" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">
                                            <div class="card-header" style="border: none;">
                                                <h4>

                                                    <button type="button" style="float: right;"
                                                        class="btn btn-secondary" data-bs-toggle="modal"
                                                        data-bs-target="#placeadd">
                                                        Add Placement
                                                    </button>
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="myTablep" class="table table-bordered table-striped">
                                                        <thead class="gradient-header">
                                                            <tr>
                                                                <th><b>S.No</b></th>
                                                                <th><b>Academic Year</b></th>
                                                                <th><b>Date</b></th>
                                                                <th><b>Name of the Company</b></th>
                                                                <th><b>Designation & Salary Package</b></th>
                                                                <th><b>Performance / Result</b></th>

                                                                <th align="center"><b>Action</b></th>
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
                                                                        <td><?= $student['ayear'] ?></td>
                                                                        <td><?= $student['date'] ?></td>
                                                                        <td><?= $student['np'] ?></td>
                                                                        <td><?= $student['ds'] ?></td>
                                                                        <td><?= $student['pr'] ?></td>

                                                                        <td align="center">
                                                                            <?php if ($student['status'] == 1): ?>
                                                                                <button type="button"
                                                                                    class="btn btn-success btn-sm">Approved</button>
                                                                            <?php else: ?>
                                                                                <button type="button"
                                                                                    value="<?= $student['uid']; ?>"
                                                                                    class="deleteplBtn btn btn-danger btn-sm">Delete</button>
                                                                            <?php endif; ?>
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

                            <!--career tab starts -->
                            <div class="tab-pane  p-20" id="career" role="tabpanel">
                                <div class="row">
                                    <!-- Placement Detail Card -->
                                    <div class="col-md-3">
                                        <div class="card text-center placement-card">
                                            <div class="card-body">
                                                <i class="fas fa-briefcase fa-3x mb-3" style="color: #2196f3;"></i>

                                                <h5 class="card-title">Placement</h5>
                                                <p class="card-text">Explore job opportunities and placement details.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Higher Study Detail Card -->
                                    <div class="col-md-3">
                                        <div class="card text-center higher-studies-card">
                                            <div class="card-body">
                                                <i class="fas fa-user-graduate fa-3x mb-3" style="color: #2196f3;"></i>
                                                <h5 class="card-title">Higher Studies</h5>
                                                <p class="card-text">Get guidance for further education.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Business Detail Card -->
                                    <div class="col-md-3">
                                        <div class="card text-center business-card">
                                            <div class="card-body">
                                                <i class="fas fa-lightbulb fa-3x mb-3" style="color: #2196f3;"></i>
                                                <h5 class="card-title">Business</h5>
                                                <p class="card-text">Plan and start your business journey.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Entrepreneur Detail Card -->
                                    <div class="col-md-3">
                                        <div class="card text-center entrepreneur-card">
                                            <div class="card-body">
                                                <i class="fas fa-chart-line fa-3x mb-3" style="color: #2196f3;"></i>
                                                <h5 class="card-title">Entrepreneur</h5>
                                                <p class="card-text">Build your startup and innovate.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>







                            </div>

                        </div>

                    </div>
                    <!-- Tabs content -->
                </div>
            </div>

        </div>

        <!-- assessment form -->
        <div class="modal fade" id="cpadd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Add Assessment Score </strong></h5>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="savecp">
                        <div class="modal-body">
                            <div id="errorMessagecp" class="alert alert-warning d-none">
                            </div>
                            <div class="mb-3">
                                <label for="" data-required class="form-label">Date</label>
                                <input type="Date" name="dt" class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">HackerRank</label>
                                <input type="text" name="hr" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label for="" data-required class="form-label">SkillRack/Codetantra </label>
                                <input type="text" name="sr" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Other</label>
                                <input type="text" name="ict" placeholder="Ex: Codechef:80"
                                    class="form-control" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save
                                details</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add posting -->
        <div class="modal fade" id="postingadd" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Add Co-Curricular Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="savepost">
                        <div class="modal-body">

                            <div id="errorMessagepost" class="alert alert-warning d-none">
                            </div>
                            <div class="mb-3">
                                <label for="" data-required class="form-label">Academic Year</label>
                                <select class="form-control" name="ayear" id="ayear"
                                    required>
                                    <?php
                                    include 'get_academic_years.php';
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" data-required class="form-label">Name of the event</label>
                                <input type="text" name="event" class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Level</label>
                                <select class="form-control" name="level" id="type"
                                    required>
                                    <option value="">Select type</option>
                                    <option value="School Level">School Level</option>
                                    <option value="College Level">College Level</option>
                                    <option value="Zonal Level">Zonal Level</option>
                                    <option value="State Level">State Level</option>
                                    <option value="National Level">National Level</option>
                                    <option value="International Level">International Level
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Organizer</label>
                                <input type="text" name="organiser" class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Prize</label>
                                <select class="form-control" name="prize" id="type"
                                    required>
                                    <option value="">Select type</option>
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="Participation">Participation</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" data-required class="form-label">Certificate</label>
                                <label for="">(upload less than 2 mb)</label> </br>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control" name="cert"
                                        id="uploadFile" onchange="return fileValidation2()"
                                        aria-describedby="inputGroupPrepend" required>
                                    <label class="custom-file-label" for="customFile"></label>
                                </div>
                                <p style="color:red;" id="tutorial"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save
                                details</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="studentViewModalco" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> View Certificate </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="imagei2" src="" alt="Certificate" class="img-fluid"
                            style="max-width:80%; max-height:70vh;">
                        <iframe id="pdfi2" src=""
                            style="width:100%; height:70vh; border:none; display:none;"></iframe>
                        <div id="noContentMessage2" class="alert alert-info"
                            style="display:none;">
                            No content available
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="extraadd" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Add Extra-Curricular Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="saveextra">
                        <div class="modal-body">

                            <div id="errorMessagepost" class="alert alert-warning d-none">
                            </div>
                            <div class="mb-3">
                                <label for="" data-required class="form-label">Academic Year</label>
                                <select class="form-control" name="ayear" id="ayear"
                                    required>
                                    <?php
                                    include 'get_academic_years.php';
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" data-required class="form-label">Name of the event</label>
                                <input type="text" name="event" class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Level</label>
                                <select class="form-control" name="level" id="type"
                                    required>
                                    <option value="">Select type</option>
                                    <option value="School Level">School Level</option>
                                    <option value="College Level">College Level</option>
                                    <option value="Zonal Level">Zonal Level</option>
                                    <option value="State Level">State Level</option>
                                    <option value="National Level">National Level</option>
                                    <option value="International Level">International Level
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Organizer</label>
                                <input type="text" name="organiser" class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Prize</label>
                                <select class="form-control" name="prize" id="type"
                                    required>
                                    <option value="">Select type</option>
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="Participation">Participation</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" data-required class="form-label">Certificate</label>
                                <label for="">(upload less than 2 mb)</label> </br>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control" name="cert"
                                        id="uploadFile" onchange="return fileValidation2()"
                                        aria-describedby="inputGroupPrepend" required>
                                    <label class="custom-file-label" for="customFile"></label>
                                </div>
                                <p style="color:red;" id="tutorial"></p>
                            </div>




                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save
                                details</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="studentViewModalex" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> View Certificate</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="imagei3" src="" alt="Certificate" class="img-fluid"
                            style="max-width:80%; max-height:70vh;">
                        <iframe id="pdfi3" src=""
                            style="width:100%; height:70vh; border:none; display:none;"></iframe>
                        <div id="noContentMessage3" class="alert alert-info"
                            style="display:none;">
                            No content available
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="studentViewModallanu" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> View Certificate</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="imagei4" src="" alt="Certificate" class="img-fluid"
                            style="max-width:80%; max-height:70vh;">
                        <iframe id="pdfi4" src=""
                            style="width:100%; height:70vh; border:none; display:none;"></iframe>
                        <div id="noContentMessage3" class="alert alert-info"
                            style="display:none;">
                            No content available
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="lanadd" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Add International Language Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="lanaddf">
                        <div class="modal-body">

                            <div id="errorMessage5" class="alert alert-warning d-none">
                            </div>


                            <div class="mb-3">
                                <label for="" data-required class="form-label">Academic Year</label>
                                <select class="form-control" name="ayear" id="ayear"
                                    required>
                                    <?php
                                    include 'get_academic_years.php';
                                    ?>
                                </select>
                            </div>


                            <!-- <div class="mb-3">
                                                        <label for="">Name of the event *</label>
                                                        <input type="text" name="event" class="form-control" />
                                                    </div> -->

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Language</label>
                                <select class="form-control" name="language" id="type"
                                    required>
                                    <option value="">Select type</option>
                                    <option value="Japanese">Japanese</option>
                                    <option value="German">German</option>
                                    <option value="Chinese">Chinese</option>
                                    <!-- <option value="State Level">State Level</option>
                                                            <option value="National Level">National Level</option>
                                                            <option value="International Level">International Level -->
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Level</label>
                                <input type="text" name="level" class="form-control" />
                            </div>


                            <div class="mb-3">
                                <label for="" data-required class="form-label">Certificate</label>
                                <label for="">(upload less than 2 mb)</label> </br>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control" name="cert"
                                        id="uploadFile5" onchange="return fileValidation5()"
                                        aria-describedby="inputGroupPrepend" required>
                                    <label class="custom-file-label" for="customFile"></label>
                                </div>
                                <p style="color:red;" id="tutorial5"></p>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Data</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <div class="modal fade" id="ViewModal4" tabindex="-1"
            aria-labelledby="documentPreviewLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="documentPreviewLabel"><strong> Document Preview </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Container for image/PDF -->
                        <div id="documentContainer" class="text-center">
                            <!-- Content will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="studentViewModal4" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> View Prizes </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

        <!-- Add porject -->
        <div class="modal fade" id="projectadd" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Add Project Details </strong> </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="saveproject">
                        <div class="modal-body">

                            <div id="errorMessagepost" class="alert alert-warning d-none">
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Academic Year</label>
                                <select class="form-control" name="ayear" id="ayear"
                                    required>
                                    <?php
                                    include 'get_academic_years.php';
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3"><label for="" data-required class="form-label">Semester</label>
                                <select class="form-control" name="sem" id="cs" required>
                                    <option value="">Select</option>
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
                                <label for="" data-required class="form-label">Title of the Project</label>
                                <input type="text" name="ti" class="form-control"
                                    required />
                            </div>
                            <div class="mb-3">
                                <label for="" data-required class="form-label">Github Link</label>
                                <input type="text" name="gl" class="form-control"
                                    required />
                            </div>
                            <div class="mb-3">
                                <label for="" data-required class="form-label">Remarks</label>
                                <input type="text" name="rm" class="form-control"
                                    required />
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save
                                details</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="pcadd" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Add International Certifications Details</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="pcadd2">
                        <div class="modal-body">

                            <div id="errorMessage" class="alert alert-warning d-none"></div>


                            <div class="mb-3">
                                <label for="" data-required class="form-label">Academic Year</label>
                                <select class="form-control" name="ayear" id="ayear"
                                    required>
                                    <?php
                                    include 'get_academic_years.php';
                                    ?>
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="" data-required class="form-label">Name of the Certification</label>
                                <input type="text" name="cname" class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Duration</label>
                                <input type="text" name="duration" class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Organizer</label>
                                <input type="text" name="organiser" class="form-control" />
                            </div>


                            <div class="mb-3">
                                <label for="" data-required class="form-label">Certificate</label>
                                <label for="">(upload less than 2 mb)</label> </br>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control" name="cert"
                                        id="uploadFile" onchange="return fileValidation2()"
                                        aria-describedby="inputGroupPrepend" required>
                                    <label class="custom-file-label" for="customFile"></label>
                                </div>
                                <p style="color:red;" id="tutorial"></p>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Data</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <div class="modal fade" id="studentViewModal4" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> View Certificate</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

        <div class="modal fade" id="iadd" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Add Internship / Course Details </strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="iadd2">
                        <div class="modal-body">

                            <div id="errorMessagei" class="alert alert-warning d-none">
                            </div>
                            <div class="mb-3">
                                <label for="" data-required class="form-label">Academic Year</label>
                                <select class="form-control" name="ayear" id="ayear"
                                    required>
                                    <?php
                                    include 'get_academic_years.php';
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Name of the Program / Title</label>
                                <input type="text" name="event" class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Type</label>
                                <select class="form-control" name="type" id="type" required>
                                    <option value="">Select type</option>
                                    <option value="Internship">Internship</option>
                                    <option value="Course">Course</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Organizer</label>
                                <input type="text" name="organiser" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label for="" data-required class="form-label">Duration</label>
                                <input type="text" name="dur" class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Remarks </label>
                                <input type="text" name="rem" class="form-control" />
                            </div>


                            <div class="mb-3">
                                <label for="" data-required class="form-label">Certificate</label>
                                <label for="">(upload less than 2 mb)</label> </br>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control" name="cert"
                                        id="uploadFile" onchange="return fileValidation2()"
                                        aria-describedby="inputGroupPrepend" required>
                                    <label class="custom-file-label" for="customFile"></label>
                                </div>
                                <p style="color:red;" id="tutorial"></p>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Data</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- <div class="modal fade" id="studentViewModali" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Certificate</h5>
                        <button type="button" class="btn" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="mdi mdi-close"></i>
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
        </div> -->

        <div class="modal fade" id="studentViewModali" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> View Certificate</strong></h5>
                        <button type="button" class="btn" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="mdi mdi-close"></i>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="imagei" src="" alt="Certificate" class="img-fluid"
                            style="max-width:80%; max-height:70vh;">
                        <iframe id="pdfi" src=""
                            style="width:100%; height:70vh; border:none; display:none;"></iframe>
                        <div id="noContentMessage" class="alert alert-info"
                            style="display:none;">
                            No content available
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add posting -->
        <div class="modal fade" id="placeadd" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong> Add Placement Details</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="saveplace">
                        <div class="modal-body">

                            <div id="errorMessagep" class="alert alert-warning d-none">
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Academic Year</label>
                                <select class="form-control" name="ayear" id="ayear"
                                    required>
                                    <?php
                                    include 'get_academic_years.php';
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Date </label>
                                <input type="date" name="dt" class="form-control"
                                    required />
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Name of the Company </label>
                                <input type="text" name="nc" class="form-control"
                                    required />
                            </div>

                            <div class="mb-3">
                                <label for="" data-required class="form-label">Designation & Salary Package</label>
                                <input type="text" name="ds" class="form-control"
                                    required />
                            </div>


                            <div class="mb-3">
                                <label for="" data-required class="form-label">Result </label>
                                <select class="form-control" name="pr" id="type" required>
                                    <option value="">Select type</option>
                                    <option value="Selected">Selected</option>
                                    <option value="Not Selected">Not Selected</option>

                                </select>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save
                                details</button>
                        </div>
                    </form>
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
        function showContent(type, source) {
            // Reset all content
            document.getElementById('imagei').style.display = 'none';
            document.getElementById('pdfi').style.display = 'none';
            document.getElementById('noContentMessage').style.display = 'none';

            // Show appropriate content
            if (type === 'image') {
                const imgElement = document.getElementById('imagei');
                imgElement.src = source;
                imgElement.style.display = 'block';
            } else if (type === 'pdf') {
                const pdfElement = document.getElementById('pdfi');
                pdfElement.src = source;
                pdfElement.style.display = 'block';
            } else {
                document.getElementById('noContentMessage').style.display = 'block';
            }

            // Show the modal
            var modal = new bootstrap.Modal(document.getElementById('studentViewModali'));
            modal.show();
        }





        $(document).on('submit', '#saveexp', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_exp", true);

            $.ajax({
                type: "POST",
                url: "Acode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessage').removeClass('d-none');
                        $('#errorMessage').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorMessage').addClass('d-none');
                        $('#studentAddModal').modal('hide');
                        $('#saveexp')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTable2').load(location.href + " #myTable2");


                    } else if (res.status == 500) {
                        $('#errorMessage').addClass('d-none');
                        $('#studentAddModal').modal('hide');
                        $('#saveexp')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        //prize and awards		

        $(document).on('submit', '#pcadd2', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_i_certification", true);
            console.log(formData);

            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessage4').removeClass('d-none');
                        $('#errorMessage4').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorMessage4').addClass('d-none');
                        $('#pcadd').modal('hide');
                        $('#pcadd2')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTablepr').load(location.href + " #myTablepr");


                    } else if (res.status == 500) {
                        $('#errorMessage4').addClass('d-none');
                        $('#pcadd').modal('hide');
                        $('#pcadd2')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        $(document).on('click', '.deletepcBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id5 = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_i_certification': true,
                        'student_id5': student_id5
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#myTablepr').load(location.href + " #myTablepr");
                        }
                    }
                });
            }
        });

        $(document).on('click', '.btnimgcert', function() {

            var student_id222 = $(this).val();
            console.log(student_id222);
            $.ajax({
                type: "GET",
                url: "scode.php?student_i_certification=" + student_id222,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {

                        alert(res.message);
                    } else if (res.status == 200) {


                        $("#imagepr").attr("src", res.data.cert);

                        $('#studentViewModal4').modal('show');
                    }
                }
            });
        });


        //prize awards ends


        //language starts

        $(document).on('submit', '#lanaddf', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_lang", true);
            console.log(formData);

            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessage5').removeClass('d-none');
                        $('#errorMessage5').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorMessage5').addClass('d-none');
                        $('#lanadd').modal('hide');
                        $('#lanaddf')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTablelan').load(location.href + " #myTablelan");


                    } else if (res.status == 500) {
                        $('#errorMessage5').addClass('d-none');
                        $('#lanadd').modal('hide');
                        $('#lanaddf')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        $(document).on('click', '.deletelangBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id5 = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_lang': true,
                        'student_id5': student_id5
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#myTablelan').load(location.href + " #myTablelan");
                        }
                    }
                });
            }
        });

        // $(document).on('click', '.btnimgpr', function () {

        //     var student_id222 = $(this).val();
        //     $.ajax({
        //         type: "GET",
        //         url: "scode.php?student_id222=" + student_id222,
        //         success: function (response) {

        //             var res = jQuery.parseJSON(response);
        //             if (res.status == 404) {

        //                 alert(res.message);
        //             } else if (res.status == 200) {


        //                 $("#imagepr").attr("src", res.data.cert);

        //                 $('#studentViewModal4').modal('show');
        //             }
        //         }
        //     });
        // });


        //language ends

        //------------------------------------------
        //projects starts

        $(document).on('submit', '#saveproject', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_project", true);
            console.log(formData);

            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessagepost').removeClass('d-none');
                        $('#errorMessagepost').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorMessagepost').addClass('d-none');
                        $('#projectadd').modal('hide');
                        $('#saveproject')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTable0').load(location.href + " #myTable0");

                    } else if (res.status == 500) {
                        $('#errorMessagepost').addClass('d-none');
                        $('#projectadd').modal('hide');
                        $('#saveproject')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });


        $(document).on('click', '.deletePrBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id9 = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_project': true,
                        'student_id9': student_id9
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#myTable0').load(location.href + " #myTable0");
                        }
                    }
                });
            }
        });




        //projects ends
        //---------------------------------------------

        //internship		

        $(document).on('submit', '#iadd2', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_i", true);

            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessagei').removeClass('d-none');
                        $('#errorMessagei').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorMessagei').addClass('d-none');
                        $('#iadd').modal('hide');
                        $('#iadd2')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTablei').load(location.href + " #myTablei");


                    } else if (res.status == 500) {
                        $('#errorMessagei').addClass('d-none');
                        $('#iadd').modal('hide');
                        $('#iadd2')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        $(document).on('click', '.deleteiBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_idi = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_i': true,
                        'student_idi': student_idi
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#myTablei').load(location.href + " #myTablei");
                        }
                    }
                });
            }
        });


        //view intern image

        $(document).on('click', '.btnimgi', function() {
            var student_idii = $(this).val();
            $.ajax({
                type: "GET",
                url: "scode.php?student_idiintern=" + student_idii,
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {
                        alert(res.message);
                    } else if (res.status == 200) {
                        $('#pdfi').hide();
                        $('#noContentMessage').hide();

                        if (res.data.cert.toLowerCase().endsWith('.pdf')) {
                            $('#pdfi').attr('src', res.data.cert).show();
                            $('#imagei').hide();
                        } else {
                            $('#imagei').attr("src", res.data.cert).show();
                            $('#pdfi').hide();
                        }
                        $('#studentViewModali').modal('show');
                    }
                }
            });
        });


        //internship ends
        //---------------------------------------------------
        //co-curricular starts

        $(document).on('submit', '#savepost', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_post", true);
            console.log(formData);

            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessagepost').removeClass('d-none');
                        $('#errorMessagepost').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorMessagepost').addClass('d-none');
                        $('#postingadd').modal('hide');
                        $('#savepost')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTablecc').load(location.href + " #myTablecc");

                    } else if (res.status == 500) {
                        $('#errorMessagepost').addClass('d-none');
                        $('#postingadd').modal('hide');
                        $('#savepost')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });


        $(document).on('click', '.deletecoBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_idi = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_co': true,
                        'student_idi': student_idi
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#myTablecc').load(location.href + " #myTablecc");
                        }
                    }
                });
            }
        });


        $(document).on('click', '.btnimgco', function() {

            var student_idco = $(this).val();
            $.ajax({
                type: "GET",
                url: "scode.php?student_idco=" + student_idco,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {

                        alert(res.message);
                    } else if (res.status == 200) {

                        $('#pdfi2').hide();
                        $('#noContentMessage2').hide();

                        if (res.data.cert.toLowerCase().endsWith('.pdf')) {
                            $('#pdfi2').attr('src', res.data.cert).show();
                            $('#imagei2').hide();
                        } else {
                            $('#imagei2').attr("src", res.data.cert).show();
                            $('#pdfi2').hide();
                        }

                        $('#studentViewModalco').modal('show');
                    }
                }
            });
        });

        //co-curricular ends       
        //---------------------------------------------------

        //extra-curricular starts

        $(document).on('submit', '#saveextra', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_extra", true);
            console.log(formData);

            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessagepost').removeClass('d-none');
                        $('#errorMessagepost').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorMessagepost').addClass('d-none');
                        $('#extraadd').modal('hide');
                        $('#saveextra')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTableex').load(location.href + " #myTableex");

                    } else if (res.status == 500) {
                        $('#errorMessagepost').addClass('d-none');
                        $('#extraadd').modal('hide');
                        $('#saveextra')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });


        $(document).on('click', '.deleteexBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_idi = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_ex': true,
                        'student_idi': student_idi
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#myTableex').load(location.href + " #myTableex");
                        }
                    }
                });
            }
        });


        $(document).on('click', '.btnimgex', function() {

            var student_idex = $(this).val();
            $.ajax({
                type: "GET",
                url: "scode.php?student_idex=" + student_idex,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {

                        alert(res.message);
                    } else if (res.status == 200) {
                        $('#pdfi3').hide();
                        $('#noContentMessage3').hide();

                        if (res.data.cert.toLowerCase().endsWith('.pdf')) {
                            $('#pdfi3').attr('src', res.data.cert).show();
                            $('#imagei3').hide();
                        } else {
                            $('#imagei3').attr("src", res.data.cert).show();
                            $('#pdfi3').hide();
                        }

                        $('#studentViewModalex').modal('show');
                    }
                }
            });
        });

        //extra-curricular ends       
        //---------------------------------------------------
        //carrier progress starts

        $(document).on('submit', '#savecp', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_cp", true);
            console.log(formData);

            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessagecp').removeClass('d-none');
                        $('#errorMessagecp').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorMessagecp').addClass('d-none');
                        $('#cpadd').modal('hide');
                        $('#savecp')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTablecp').load(location.href + " #myTablecp");

                    } else if (res.status == 500) {
                        $('#errorMessagecp').addClass('d-none');
                        $('#cpadd').modal('hide');
                        $('#savecp')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });


        $(document).on('click', '.deletecpBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_idcp = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_cp': true,
                        'student_idcp': student_idcp
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#myTablecp').load(location.href + " #myTablecp");
                        }
                    }
                });
            }
        });




        //carrier progress ends       
        //---------------------------------------------------
        //placement starts

        $(document).on('submit', '#saveplace', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_place", true);


            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessagep').removeClass('d-none');
                        $('#errorMessagep').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorMessagep').addClass('d-none');
                        $('#placeadd').modal('hide');
                        $('#saveplace')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTablep').load(location.href + " #myTablep");

                    } else if (res.status == 500) {
                        $('#errorMessagep').addClass('d-none');
                        $('#placeadd').modal('hide');
                        $('#saveplace')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });


        $(document).on('click', '.deleteplBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_idp = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_pl': true,
                        'student_idp': student_idp
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#myTablep').load(location.href + " #myTablep");
                        }
                    }
                });
            }
        });




        //placement ends       
        //---------------------------------------------------




        $(document).on('click', '.editStudentBtn', function() {

            var student_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "code.php?student_id=" + student_id,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {

                        alert(res.message);
                    } else if (res.status == 200) {

                        $('#student_id').val(res.data.uid);

                        // $('#course2').val(res.data.course);
                        //$('#degree2').val(res.data.Degree);
                        $('#branch').val(res.data.branch);
                        $('#name').val(res.data.iname);

                        $('#univ').val(res.data.univ);
                        $('#state').val(res.data.state);
                        $('#ms').val(res.data.mos);
                        $('#mes').val(res.data.mes);

                        $('#yc').val(res.data.yc);
                        $('#cs').val(res.data.cs);
                        $('#score').val(res.data.score);
                        $('#cnum').val(res.data.cnum);
                        //$('#uploadFile').val(res.data.cert);

                        $('#studentEditModal').modal('show');
                    }

                }
            });

        });

        $(document).on('submit', '#updateStudent', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_student", true);

            $.ajax({
                type: "POST",
                url: "code.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessageUpdate').removeClass('d-none');
                        $('#errorMessageUpdate').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorMessageUpdate').addClass('d-none');

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#studentEditModal').modal('hide');
                        $('#updateStudent')[0].reset();

                        $('#myTable').load(location.href + " #myTable");

                    } else if (res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });

        $(document).on('click', '.viewStudentBtn', function() {

            var student_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "code.php?student_id=" + student_id,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {

                        alert(res.message);
                    } else if (res.status == 200) {

                        $('#view_Course').text(res.data.course);
                        $('#view_Degree').text(res.data.Degree);
                        $('#view_branch').text(res.data.branch);
                        $('#view_iname').text(res.data.iname);
                        $('#view_univ').text(res.data.univ);

                        $('#view_state').text(res.data.state);
                        $('#view_mos').text(res.data.mos);
                        $('#view_mes').text(res.data.mes);
                        $('#view_yc').text(res.data.yc);

                        $('#view_cs').text(res.data.cs);
                        $('#view_score').text(res.data.score);
                        $('#view_cn').text(res.data.cnum);


                        $('#studentViewModal').modal('show');
                    }
                }
            });
        });

        $(document).on('click', '.btnimg', function() {

            var student_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "Acode.php?student_id=" + student_id,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {

                        alert(res.message);
                    } else if (res.status == 200) {


                        $("#image").attr("src", res.data.cert);

                        $('#studentViewModal2').modal('show');
                    }
                }
            });
        });


        $(document).on('click', '.btnimg1', function() {

            var student_id22 = $(this).val();
            $.ajax({
                type: "GET",
                url: "Acode.php?student_id22=" + student_id22,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {

                        alert(res.message);
                    } else if (res.status == 200) {


                        $("#image2").attr("src", res.data.paper);

                        $('#studentViewModal3').modal('show');
                    }
                }
            });
        });

        $(document).on('click', '.btnimgpr', function() {

            var student_id222 = $(this).val();
            $.ajax({
                type: "GET",
                url: "scode.php?student_id222=" + student_id222,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {

                        alert(res.message);
                    } else if (res.status == 200) {


                        $("#imagepr").attr("src", res.data.cert);

                        $('#studentViewModal4').modal('show');
                    }
                }
            });
        });


        $(document).on('click', '.deleteStudentBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "Acode.php",
                    data: {
                        'delete_student': true,
                        'student_id': student_id
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#myTable2').load(location.href + " #myTable2");
                        }
                    }
                });
            }
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

        function fileValidation5() {
            var fileInput =
                document.getElementById('uploadFile5');
            var fileSize = ((document.getElementById('uploadFile5').files[0].size) / 1024);
            var filePath = fileInput.value;
            document.getElementById("tutorial5").innerHTML = " ";
            // Allowing file type
            var allowedExtensions =
                /(\.jpg|\.jpeg|\.png|\.gif)$/i;

            if (!allowedExtensions.exec(filePath)) {
                var msg = "Only images are allowed!";
                fileInput.value = '';
                document.getElementById("tutorial5").innerHTML = msg;
            } else {
                if (fileSize > 2000) {
                    var msg = "File size should be less than 2MB!";
                    fileInput.value = '';
                    document.getElementById("tutorial5").innerHTML = msg;
                }
            }



        }
    </script>


    <script>
        $(document).on('submit', '#basic', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_basic", true);

            $.ajax({
                type: "POST",
                url: "code.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessageUpdate2').removeClass('d-none');
                        $('#errorMessageUpdate2').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorMessageUpdate2').addClass('d-none');

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);



                    } else if (res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });

        $(document).on('submit', '#assessment', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_research", true);

            $.ajax({
                type: "POST",
                url: "Acode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorresearch').removeClass('d-none');
                        $('#errorresearch').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorresearch').addClass('d-none');

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);



                    } else if (res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });


        $(document).on('submit', '#aprofile', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_aprofile", true);

            $.ajax({
                type: "POST",
                url: "Acode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#erroraprofile').removeClass('d-none');
                        $('#erroraprofile').text(res.message);

                    } else if (res.status == 200) {

                        $('#erroraprofile').addClass('d-none');

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);



                    } else if (res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });








        $(document).on('submit', '#savejournal', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_journal", true);

            $.ajax({
                type: "POST",
                url: "Acode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessage').removeClass('d-none');
                        $('#errorMessage').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorMessage').addClass('d-none');
                        $('#studentAddModal2').modal('hide');
                        $('#savejournal')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTable3').load(location.href + " #myTable3");

                    } else if (res.status == 500) {
                        $('#errorMessage').addClass('d-none');
                        $('#studentAddModal2').modal('hide');
                        $('#savejournal')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });


        $(document).on('submit', '#savepost', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_post", true);
            console.log(formData);

            $.ajax({
                type: "POST",
                url: "Acode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessagepost').removeClass('d-none');
                        $('#errorMessagepost').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorMessagepost').addClass('d-none');
                        $('#postingadd').modal('hide');
                        $('#savepost')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTable5').load(location.href + " #myTable5");

                    } else if (res.status == 500) {
                        $('#errorMessagepost').addClass('d-none');
                        $('#postingadd').modal('hide');
                        $('#savepost')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        $(document).on('submit', '#savepunish', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_punish", true);
            console.log(formData);

            $.ajax({
                type: "POST",
                url: "Acode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessagepost9').removeClass('d-none');
                        $('#errorMessagepost9').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorMessagepost9').addClass('d-none');
                        $('#punishadd').modal('hide');
                        $('#savepunish')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTable9').load(location.href + " #myTable9");

                    } else if (res.status == 500) {
                        $('#errorMessagepost').addClass('d-none');
                        $('#punishadd').modal('hide');
                        $('#savepunish')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });




        $(document).on('click', '.editfamilyBtn', function() {

            var student_id2 = $(this).val();

            $.ajax({
                type: "GET",
                url: "code.php?student_id2=" + student_id2,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {

                        alert(res.message);
                    } else if (res.status == 200) {

                        $('#student_id2').val(res.data.uid);

                        $('#name2').val(res.data.name);
                        $('#gender').val(res.data.gender);

                        $('#relationship').val(res.data.relationship);
                        $('#mobile').val(res.data.mobile);


                        $('#studentEditModal2').modal('show');
                    }

                }
            });

        });

        $(document).on('submit', '#updatefamily', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_family", true);

            $.ajax({
                type: "POST",
                url: "code.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessageUpdate').removeClass('d-none');
                        $('#errorMessageUpdate').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorMessageUpdate').addClass('d-none');

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#studentEditModal2').modal('hide');
                        $('#updatefamily')[0].reset();

                        $('#myTable1').load(location.href + " #myTable1");

                    } else if (res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });


        $(document).on('click', '.deletefamilyBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id3 = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "code.php",
                    data: {
                        'delete_family': true,
                        'student_id3': student_id3
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#myTable1').load(location.href + " #myTable1");
                        }
                    }
                });
            }
        });



        $(document).on('click', '.deletejBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id4 = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "Acode.php",
                    data: {
                        'delete_journal': true,
                        'student_id4': student_id4
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#myTable3').load(location.href + " #myTable3");
                        }
                    }
                });
            }
        });




        $(document).on('click', '.deletepBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id6 = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "Acode.php",
                    data: {
                        'delete_post': true,
                        'student_id6': student_id6
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#myTable5').load(location.href + " #myTable5");
                        }
                    }
                });
            }
        });
    </script>

    <script>
        $(document).on('click', '.btnimglang', function() {

var student_Language = $(this).val();
$.ajax({
    type: "GET",
    url: "scode.php?student_Language=" + student_Language,
    success: function(response) {

        var res = jQuery.parseJSON(response);
        if (res.status == 404) {

            alert(res.message);
        } else if (res.status == 200) {
            $('#pdfi4').hide();
            $('#noContentMessage4').hide();

            if (res.data.cert.toLowerCase().endsWith('.pdf')) {
                $('#pdfi4').attr('src', res.data.cert).show();
                $('#imagei4').hide();
            } else {
                $('#imagei4').attr("src", res.data.cert).show();
                $('#pdfi4').hide();
            }

            $('#studentViewModallanu').modal('show');
        }
    }
});
});
    </script>
</body>

</html>