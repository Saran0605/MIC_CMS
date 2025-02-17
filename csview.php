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
    <link href="check2.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

    <script type="text/javascript">
        function CheckColors(val) {
            if (val.value == 'Patent') {
                document.getElementById('pstatus').classList.remove('d-none');
                document.getElementById('cstatus').classList.add('d-none');
            } else if (val.value == 'Copyright') {
                document.getElementById('pstatus').classList.add('d-none');
                document.getElementById('cstatus').classList.remove('d-none');
            } else {
                document.getElementById('pstatus').classList.add('d-none');
                document.getElementById('cstatus').classList.add('d-none');
            }
        }
    </script>

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
            text-align: center;
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

        .alertify-notifier .ajs-message {
            color: white;
            /* Change to your desired color */
        }

        /* Customize Excel button */
        .dt-buttons .buttons-excel {
            background-color: #4CAF50;
            /* Green */
            border-color: #4CAF50;
            /* Green */
            color: white;
        }

        /* Hover effect */
        .dt-buttons .buttons-excel:hover {
            background-color: #45a049;
            /* Darker Green */
            border-color: #45a049;
            /* Darker Green */
            color: black;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php include 'side.php'; ?>
    <div id="mentorModal" class="modal modal1">
        <div class="modal-content modal-content1">
            <div class="modal-header modal-header1">
                <h2 class="modal-title modal-title1">Mentor Details</h2>
                <button type="button" class="btn-close close-modal1" aria-label="Close"></button>

            </div>
            <div id="mentorList" class="mentor-list"></div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">

        <div class="loader-container" id="loaderContainer">
            <div class="loader"></div>
        </div>

        <!-- Topbar -->
        <?php include 'ftopbar.php'; ?>

        <!-- Breadcrumb -->
        <div class="breadcrumb-area">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="main.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Mentor-Mentee </li>
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
            } ?>
            <div class="card" style="border: none;">
                <div class="card-body wizard-content" style="border: none;">

                    <div class="card" style="border: none;">
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="Asse-tab" data-bs-toggle="tab" href="#home" role="tab">
                                    <i class="fas fa-user tab-icon"></i> View Students
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Extra-Curr-tab" data-bs-toggle="tab" href="#stdsum" role="tab">
                                    <i class="fas fa-chart-bar tab-icon"></i> Students Summary
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Co-Curr-tab" data-bs-toggle="tab" href="#profile" role="tab">
                                    <i class="fas fa-user-graduate tab-icon"></i> Student Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Projects-tab" data-bs-toggle="tab" href="#couns" role="tab">
                                    <i class="fas fa-sync-alt tab-icon"></i> Reset
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="lang-tab" data-bs-toggle="tab" href="#smedi" role="tab">
                                    <i class="fas fa-code tab-icon"></i> HackerRank
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#regc" role="tab">
                                    <i class="fas fa-edit tab-icon"></i> Reg Num Change
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content tabcontent-border">

                            <div class="tab-pane active" id="home" role="tabpanel">


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">

                                            <div class="card-body">




                                                <div class="table-responsive">
                                                    <table id="myTable2" class="table table-bordered table-striped">
                                                        <thead class="gradient-header">
                                                            <tr>
                                                                <th><b>S.No</b></th>
                                                                <th><b>Student ID</b></th>
                                                                <th><b>Name</b></th>
                                                                <th><b>Basic Profile</b></th>
                                                                <th><b>Academic Profile</b></th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $query = "SELECT * FROM student";
                                                            $query_run = mysqli_query($db, $query);


                                                            if (mysqli_num_rows($query_run) > 0) {
                                                                $sn = 1;
                                                                foreach ($query_run as $student) {
                                                            ?>
                                                                    <tr>
                                                                        <td><?php echo $sn; ?></td>
                                                                        <td><?= $student['sid'] ?> </td>
                                                                        <td><span><?= $student['sname'] ?></span></td>
                                                                        <td><span><?= $student['bc'] ?></span></td>
                                                                        <td><span><?= $student['ac'] ?></span></td>
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

                            <div class="tab-pane  p-20" id="profile" role="tabpanel">

                                <form id="fsearch" class="needs-validation" novalidate>
                                    <div id="fasearch" class="alert alert-warning d-none"></div>
                                    <div class="form-row">

                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom01" class="form-label">Student ID *</label>
                                            <input type="text" name="fid" class="form-control"
                                                id="validationCustom01" placeholder="Student ID">
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>

                                    </div>

                                    <button class="btn btn-primary" type="submit">Submit</button>


                                </form>



                                <div id="result"></div>


                            </div>

                            <!--profile tab end -->

                            <div class="tab-pane  p-20" id="stdsum" role="tabpanel">

                                <form id="aprofile" class="needs-validation" novalidate>

                                    <div class="mb-3" id="deptt">
                                        <label for="" class="form-label">Department *</label>
                                        <select class="form-control" name="dept" id="dept">
                                            <option value="">Select department</option>
                                            <?php include('get_departments.php'); ?>
                                        </select>
                                    </div>

                                    <div class="mb-3" id="kalai">

                                    </div>


                                </form>

                            </div>

                            <!-- student summary end -->

                            <div class="tab-pane" id="couns" role="tabpanel">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: none;">

                                            <div class="card-body">

                                                <div class="table-responsive">
                                                    <table id="myTablereset"
                                                        class="table table-bordered table-striped">
                                                        <thead class="gradient-header">
                                                            <tr>
                                                                <th><b>S.No</b></th>
                                                                <th><b>Student ID</b></th>
                                                                <th><b>Name</b></th>
                                                                <th><b>Dept</b></th>
                                                                <th><b>Status</b></th>
                                                                <th><b>Action</b></th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $query = "SELECT * FROM sbasic where status !=2";
                                                            $query_run = mysqli_query($db, $query);


                                                            if (mysqli_num_rows($query_run) > 0) {
                                                                $sn = 1;
                                                                foreach ($query_run as $student) {


                                                            ?>
                                                                    <tr>
                                                                        <td><?php echo $sn; ?></td>
                                                                        <td><?= $student['sid'] ?> </td>
                                                                        <td><span><?= $student['fname'] ?></span></td>
                                                                        <td><span><?= $student['department'] ?></span></td>
                                                                        <td><?php if ($student['status'] == 0): ?>
                                                                                <span class="btn btn-warning">Pending</span>
                                                                            <?php elseif ($student['status'] == 1): ?>
                                                                                <span class="btn btn-success">Approved</span>
                                                                            <?php endif; ?>
                                                                        </td>




                                                                        <td>
                                                                            <?php if ($student['status'] == 1): ?>
                                                                                <button type="submit"
                                                                                    value="<?= $student['sid']; ?>"
                                                                                    class="resetBtn btn btn-info btn-md m-r-5"> <i class="fas fa-sync-alt"></i></button>

                                                                            <?php endif; ?>
                                                                            <button type="submit"
                                                                                value="<?= $student['sid']; ?>"
                                                                                class="presetBtn btn btn-dark btn-md m-r-5"
                                                                                style="background-color: #522D5E; color: white;"><i class="fas fa-key"></i></button>

                                                                            <button type="submit"
                                                                                value="<?= $student['sid']; ?>"
                                                                                class="pdeleteBtn btn btn-danger btn-md m-r-5">
                                                                                <i class="fas fa-trash-alt"></i></button>


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

                            <div class="tab-pane  p-20" id="smedi" role="tabpanel">


                                <div class="col-12">
                                    <h2 class="mb-4">HackerRank Scores</h2>

                                    <!-- Department Selection Card -->
                                    <div class="card border-primary mb-4">
                                        <div class="card-header bg-primary text-white">
                                            Select Department and Batch
                                        </div>
                                        <div class="card-body">
                                            <form id="deptForm">
                                                <div class="mb-3">
                                                    <label for="deptSelect" class="form-label">Choose Department:</label>
                                                    <select class="form-select" id="deptSelect" name="dept">
                                                        <option value="AIML">AIML</option>
                                                        <option value="CSE">CSE</option>
                                                        <option value="CSBS">CSBS</option>
                                                        <option value="EEE">EEE</option>
                                                        <option value="EE(VLSI)">EE(VLSI)</option>
                                                        <option value="ECE">ECE</option>
                                                        <option value="IT">IT</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="batchSelect" class="form-label">Choose Batch:</label>
                                                    <select class="form-select" id="batchSelect" name="batch">
                                                        <option value="Batch 1">Batch 1</option>
                                                        <option value="Batch 2">Batch 2</option>
                                                        <option value="Batch 3">Batch 3</option>
                                                        <option value="Batch 4">Batch 4</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Loading Spinner -->
                                    <div id="loading" class="text-center mb-4" style="display: none;">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <p>Loading HackerRank scores...</p>
                                    </div>

                                    <!-- Student Table -->
                                    <div class="table-responsive">
                                        <table id="studentTable" class="table table-striped table-bordered">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Reg Number</th>
                                                    <th>Name</th>
                                                    <th>C Score</th>
                                                    <th>Java Score</th>
                                                    <th>Python Score</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>



                            </div>

                            <div class="tab-pane  p-20" id="regc" role="tabpanel">
                                <?php include 'cregno.php'; ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--sprofileprinc Online / Internship / Course Certification Details -->

        <div class="modal fade" id="studentViewModali" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Certificate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="imagei" src="" alt="Certificate" class="img-fluid"
                            style="max-width:80%; max-height:70vh;">
                        <iframe id="pdfi" src=""
                            style="width:100%; height:70vh; border:none; display:none;"></iframe>
                        <div id="noContentMessage" class="alert alert-info" style="display:none;">
                            No content available
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



        <!--sprofileprinc Co – Curricular Activity -->

        <div class="modal fade" id="studentViewModalco" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Certificate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="imagei2" src="" alt="Certificate" class="img-fluid"
                            style="max-width:80%; max-height:70vh;">
                        <iframe id="pdfi2" src=""
                            style="width:100%; height:70vh; border:none; display:none;"></iframe>
                        <div id="noContentMessage" class="alert alert-info" style="display:none;">
                            No content available
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!--sprofileprinc Extra – Curricular / Extension Activity-->

        <div class="modal fade" id="studentViewModalex" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Certificate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="imagei3" src="" alt="Certificate" class="img-fluid"
                            style="max-width:80%; max-height:70vh;">
                        <iframe id="pdfi3" src=""
                            style="width:100%; height:70vh; border:none; display:none;"></iframe>
                        <div id="noContentMessage" class="alert alert-info" style="display:none;">
                            No content available
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include 'footer.php'; ?>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

        <!-- DataTables Buttons -->
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>

        <!-- JSZip for Excel export -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

        <!-- Excel Buttons -->
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
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
            $(document).on('submit', '#fsearch', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append("f_search", true);
                console.log(formData);

                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        $('#result').html(res);

                    }
                });

            });


            $(document).ready(function() {
                // Fetch academic year options on page load
                $.ajax({
                    url: "scode.php?action=academic_years", // PHP script for academic years
                    method: "GET",
                    success: function(response) {
                        $("#academic-year").html(response);
                        $("#academic-year1").html(response);
                    }
                });

                // Fetch faculty names on page load
                $.ajax({
                    url: "scode.php?action=faculty_names", // PHP script for faculty names
                    method: "GET",
                    success: function(response) {
                        $("#faculty").html(response);
                        $("#faculty1").html(response);
                    }
                });


                // Listen for changes in academic year dropdown
                $("#dept2").change(function() {
                    var dept = $(this).val();

                    $.ajax({
                        url: "pcode.php", // Your PHP script to fetch students based on academic year
                        method: "POST",
                        data: {
                            'sel_std': true,
                            batch: dept
                        },
                        success: function(response) {


                            $("#batch").html(response);
                        }
                    });
                });


                $("#dept").change(function() {
                    var dept = $(this).val();
                    //var dept = $("#dept").val(); 

                    $.ajax({
                        url: "pcode.php", // Your PHP script to fetch students based on academic year
                        method: "POST",
                        data: {
                            'sel_std1': true,
                            adept: dept
                        },
                        success: function(response) {
                            $("#kalai").html(response);
                        }
                    });
                });






                $("#faculty1").change(function() {

                    $("#academic-year1").val("");
                    $('#student-checkboxes1').load(location.href + " #student-checkboxes1");


                });



                $("#batch").change(function() {
                    //var selectedYear1 = $(this).val();
                    //var selectedFaculty = $("#faculty1").val(); 

                    $.ajax({
                        url: "scode.php", // Your PHP script to fetch students based on academic year
                        method: "POST",
                        data: {
                            'sel_std1': true,
                            academic_year1: selectedYear1,
                            fac: selectedFaculty
                        },
                        success: function(response) {
                            $("#kalai").html(response);
                        }
                    });
                });
            });






            //submit mentees form

            $(document).on('submit', '#stdname', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append("save_stdname", true);

                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 422) {
                            $('#menteemsg').removeClass('d-none');
                            $('#menteemsg').text(res.message);

                        } else if (res.status == 200) {

                            $('#menteemsg').addClass('d-none');

                            $('#stdname')[0].reset();

                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#student-checkboxes').load(location.href + " #student-checkboxes");

                        } else if (res.status == 502) {
                            $('#menteemsg').addClass('d-none');

                            $('#stdname')[0].reset();
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.error(res.message);
                        }
                    }
                });

            });


            //add students csv
            $(document).on('submit', '#csv', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append("save_csv", true);
                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        console.log(res.status);
                        if (res.status == 500) {
                            $('#stdmsg').removeClass('d-none');
                            $('#stdmsg').text(res.message);

                        } else if (res.status == 200) {

                            $('#stdmsg').addClass('d-none');

                            $('#csv')[0].reset();

                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#addstd').modal('hide');

                        } else if (res.status == 502) {
                            $('#stdmsg').addClass('d-none');

                            $('#csv')[0].reset();
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.error(res.message);
                            $('#addstd').modal('hide');
                        }
                    }
                });

            });


            //delete mentees		

            $(document).on('submit', '#stdname1', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append("save_stdname1", true);
                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 422) {
                            $('#delmsg').removeClass('d-none');
                            $('#delmsg').text(res.message);

                        } else if (res.status == 200) {

                            $('#delmsg').addClass('d-none');

                            $('#stdname1')[0].reset();

                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#student-checkboxes1').load(location.href + " #student-checkboxes1");

                            $('#delmentee').modal('hide');

                        } else if (res.status == 502) {
                            $('#delmsg').addClass('d-none');

                            $('#stdname1')[0].reset();
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.error(res.message);
                        }
                    }
                });

            });




            //faculty search

            $(document).on('submit', '#fsearch', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append("save_ssearch", true);

                console.log(formData);

                $.ajax({
                    type: "POST",
                    url: "sprofileprinc.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        $("#result").html(response);
                    }
                });

            });


            //feedback enter by HOD


            //getting enter button value to modal

            $(document).ready(function() {

                $('#enterButton').click(function() {

                    var studentUID = $(this).attr('value');


                    $('#uidc').val(studentUID);
                });

                // Additional code for form submission, validation, etc., can be added here.
            });


            $(document).on('submit', '#caction', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append("save_caction", true);
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        //$("#check").html(response);
                        var res = jQuery.parseJSON(response);

                        if (res.status == 422) {
                            $('#actionmsg').removeClass('d-none');
                            $('#actionmsg').text(res.message);

                        } else if (res.status == 200) {

                            $('#actionmsg').addClass('d-none');

                            $('#caction')[0].reset();

                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#addaction').modal('hide');
                            $('#zero_config3').load(location.href + " #zero_config3");

                        } else if (res.status == 500) {
                            $('#actionmsg').addClass('d-none');

                            $('#caction')[0].reset();
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.error(res.message);
                            $('#addaction').modal('hide');
                        }
                    }
                });

            });

            //Faculty Approve	

            $(document).on('click', '.approveBtn', function() {

                var fc = $(this).val();

                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'approve_c': true,
                        'fc': fc
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);

                        console.log(res.status);
                        if (res.status == 404) {

                            alert(res.message);
                        } else if (res.status == 200) {

                            $('#approvemsg').addClass('d-none');


                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#zero_config3').load(location.href + " #zero_config3");

                        }

                    }
                });

            });

            //mentor approve end	

            //mentor forward to principal

            $(document).on('click', '.forwardhBtn', function() {

                var fc = $(this).val();

                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'forwardh_c': true,
                        'fc': fc
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);

                        console.log(res.status);
                        if (res.status == 404) {

                            alert(res.message);
                        } else if (res.status == 200) {

                            $('#approvemsg').addClass('d-none');


                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#zero_config3').load(location.href + " #zero_config3");

                        }

                    }
                });

            });

            //medical leave rejected

            $(document).on('click', '.rejectmlBtn', function() {

                var fc = $(this).val();

                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'rejec_ml': true,
                        'fc': fc
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);

                        console.log(res.status);
                        if (res.status == 404) {

                            alert(res.message);
                        } else if (res.status == 200) {

                            $('#approvemsg').addClass('d-none');


                            alertify.set('notifier', 'position', 'top-right');
                            alertify.error(res.message);

                            $('#zero_config5').load(location.href + " #zero_config5");

                        }

                    }
                });

            });


            //approve medical leave
            $(document).on('click', '.approvemlBtn', function() {

                var fc = $(this).val();

                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'approve_ml': true,
                        'fc': fc
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);

                        console.log(res.status);
                        if (res.status == 404) {

                            alert(res.message);
                        } else if (res.status == 200) {

                            $('#approvemsg').addClass('d-none');


                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#zero_config5').load(location.href + " #zero_config5");

                        }

                    }
                });

            });

            //reset		

            $(document).on('click', '.resetBtn', function(e) {
                var student_id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "scode.php?sid_id=" + student_id,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 404) {

                            alert(res.message);
                        } else if (res.status == 200) {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);
                            //$('#myTablereset').load(location.href + " #myTablereset");

                        }

                    }
                });
            });


            //Pass_reset		

            $(document).on('click', '.presetBtn', function(e) {
                var student_id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "scode.php?sid_idpass=" + student_id,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 404) {

                            alert(res.message);
                        } else if (res.status == 200) {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);
                            //$('#myTablereset').load(location.href + " #myTablereset");

                        }

                    }
                });
            });

            //delete student 

            $(document).on('click', '.pdeleteBtn', function(e) {
                var student_id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "scode.php?sid_iddelete=" + student_id,
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 404) {

                            alert(res.message);
                        } else if (res.status == 200) {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);
                            //$('#myTablereset').load(location.href + " #myTablereset");

                        }

                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#deptForm').submit(function(event) {
                    event.preventDefault(); // Prevent the form from submitting traditionally

                    var dept = $('#deptSelect').val();
                    var batch = $('#batchSelect').val();
                    $('#loading').show();

                    // Fetch data from the HackerRank API for the selected department
                    $.ajax({
                        url: 'fetch_scores.php',
                        type: 'POST',
                        data: {
                            dept: dept,
                            batch: batch
                        },
                        dataType: 'json',
                        success: function(data) {
                            // Handle the JSON response here
                            $('#loading').hide();

                            // Populate the table with the received data
                            populateTable(data);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            $('#loading').hide();
                        }
                    });
                });

                // Initialize DataTable with buttons for Excel export
                $('#studentTable').DataTable({
                    dom: 'Bfrtip', // Show buttons for Excel export
                    buttons: [
                        'excelHtml5' // Excel button
                    ]
                });
            });

            function populateTable(data) {
                var table = $('#studentTable').DataTable();
                table.clear().draw();

                var count = 1;
                $.each(data, function(index, student) {
                    table.row.add([
                        count++,
                        student.regno,
                        student.name,
                        student.cScore,
                        student.javaScore,
                        student.pythonScore
                    ]).draw();
                });
            }
        </script>




        <script>
            /****************************************
             *       Basic Table                   *
             ****************************************/
            $('#myTable2').DataTable();
            $('#myTablereset').DataTable();
        </script>


</body>

</html>