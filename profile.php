<?php

require 'config.php';
include("session.php");

$query = "SELECT * FROM basic WHERE id='$s'";
$query_run = mysqli_query($db, $query);

if (mysqli_num_rows($query_run) == 1) {
    $student = mysqli_fetch_array($query_run);
    if ($student['photo'] == "") {
        $k = ".\assets\images\images.jpg";
    } else {
        $k = $student['photo'];
        $type = pathinfo($k, PATHINFO_EXTENSION);
        $data = file_get_contents($k);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    $n = $student['fname'] . ' ' . $student['lname'];
    $g = $student['gender'];
    $e = $student['email'];
    $d2 = $student['dob'];
    $exp = explode('-', $d2);
    $newStr = trim($exp[2]) . ' - ' . trim($exp[1]) . ' - ' . trim($exp[0]);
    $d = $newStr;
    $m = $student['mobile'];
    $a = $student['paddress'] . ',' . $student['city'] . '-' . $student['zip'];
} else {

    $n = " ";
    $g = " ";
    $e = " ";
    $d = " ";
    $m = " ";
    $a = " ";
}

$query = "SELECT * FROM research WHERE id='$s'";
$query_run = mysqli_query($db, $query);

if (mysqli_num_rows($query_run) == 1) {
    $research = mysqli_fetch_array($query_run);
    $oid = $research['oid'];
    $sid = $research['sid'];
    $rid = $research['rid'];
    $gsid = $research['gsid'];
    $hid = $research['hid'];
    $iid = $research['iid'];
    $gi = $research['gi'];
    $cs = $research['cs'];
    $cgs = $research['cgs'];
} else {
    $oid = "0000-0000";
    $sid = "0000-0000";
    $rid = "0000-0000";
    $gsid = "0000-0000";
    $hid = "0";
    $iid = "0";
    $gi = "0";
    $cs = "0";
    $cgs = "0";
}


$query7 = "SELECT design,dept FROM faculty WHERE id='$s'";
$query_run7 = mysqli_query($db, $query7);
if (mysqli_num_rows($query_run7) > 0) {
    $row7 = mysqli_fetch_assoc($query_run7);
    $de = $row7['design'];
    $dep = "Department of " . $row7['dept'];
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

        /* Table Styles */
        .gradient-header {
            --bs-table-bg: transparent;
            --bs-table-color: white;
            background: linear-gradient(135deg, #4CAF50, #2196F3) !important;

            text-align: center;
            font-size: 0.9em;
        }

        
.table thead tr {
            background: linear-gradient(135deg, #4CAF50, #2196F3);
        }

        .table thead th {
            color: white;
            font-weight: 600;
            border: none;
        }

        .export-buttons {
            margin: 20px 0;
            text-align: right;
            padding: 0 15px;
        }

        .btn-export {
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s;
            margin-left: 10px;
        }

        .btn-pdf {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .btn-pdf:hover {
            background-color: #c82333;
            transform: translateY(-1px);
        }

        .profile-section {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php include 'side.php'; ?>

    <!-- Main Content -->
    <div class="content">

        <div class="loader-container" id="loaderContainer">
            <div class="loader"></div>
        </div>

        <!-- Topbar -->
        <?php include 'ftopbar.php'; ?>

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
        <div class="export-buttons">
            <button class="btn btn-export btn-pdf" onclick="exportToPDF()">
                <i class="fas fa-file-pdf"></i> Download PDF
            </button>
        </div>
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
                                    <!-- <img src=".\assets\images\profile\1152018.jpg" alt="Admin" class="rounded-circle" width="150">-->
                                    <img src="<?php echo $base64; ?>" alt="" class="rounded-circle" width="150">
                                    <div class="mt-3">
                                        <h4><?php echo $n; ?></h4>
                                        <p class="text-secondary mb-1"><?php echo $de; ?></p>
                                        <p class="text-muted font-size-sm"><?php echo $dep; ?></p>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card mt-3">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">ORCID</h6>
                                    <span class="text-secondary"><?php echo $oid; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Scopus ID</h6>
                                    <span class="text-secondary"><?php echo $sid; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Researcher ID</h6>
                                    <span class="text-secondary"><?php echo $rid; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Google Scholar ID</h6>
                                    <span class="text-secondary"><?php echo $gsid; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">H-Index</h6>
                                    <span class="text-secondary"><?php echo $hid; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">i10-Index</h6>
                                    <span class="text-secondary"><?php echo $iid; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">G-Index</h6>
                                    <span class="text-secondary"><?php echo $gi; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Citations Scopus</h6>
                                    <span class="text-secondary"><?php echo $cs; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Citations Google Scholar</h6>
                                    <span class="text-secondary"><?php echo $cgs; ?></span>
                                </li>
                            </ul>
                        </div>

                    </div>


                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Full Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo $n; ?>
                                    </div>
                                </div>
                                <hr>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Gender</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo $g; ?>
                                    </div>
                                </div>
                                <hr>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo $e; ?>
                                    </div>
                                </div>
                                <hr>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Date of Birth</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo $d; ?>
                                    </div>
                                </div>
                                <hr>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Mobile</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo $m; ?>
                                    </div>
                                </div>
                                <hr>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo $a; ?>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row gutters-sm">
                            <div class="col-sm-19 mb-20">
                                <div class="card h-100">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title m-b-0">Educational Details</h5>
                                        </div>
                                        <table id="zero_config" class="table table-striped table-bordered">
                                        <thead class="gradient-header">
                                                <tr>
                                                    <th scope="col"><b>Course</b></th>
                                                    <th scope="col"><b>Institutions</b></th>
                                                    <th scope="col"><b>Year</b></th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $records = mysqli_query($db, "select *from academic where id='$s'");
                                            while ($data = mysqli_fetch_array($records)) {
                                            ?>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $data['course']; ?></td>
                                                        <td><?php echo $data['iname']; ?></td>
                                                        <td><?php echo $data['yc']; ?></td>
                                                    </tr>
                                                </tbody>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>

                   


                    <!-- Family Details Section -->
                    <div class="col-sm-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Family Details</h5>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead class="gradient-header">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Name</th>
                                                <th>Relationship</th>
                                                <th>Mobile</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query2 = "SELECT * FROM family WHERE id='$s'";
                                            $query_run2 = mysqli_query($db, $query2);

                                            if (mysqli_num_rows($query_run2) > 0) {
                                                $sn = 1;
                                                foreach ($query_run2 as $student2) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $sn; ?></td>
                                                        <td><?= htmlspecialchars($student2['name']); ?></td>
                                                        <td><?= htmlspecialchars($student2['relationship']); ?></td>
                                                        <td><?= htmlspecialchars($student2['mobile']); ?></td>
                                                    </tr>
                                            <?php
                                                    $sn++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='4' class='text-center'>No records found</td></tr>";
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
                    <div class="col-sm-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-decoration-underline">Experience Details</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="gradient-header">
                                            <tr>
                                                <th scope="col">S.No</th>
                                                <th scope="col">Institution/Corporate Name</th>
                                                <th scope="col">Designation</th>
                                                <th scope="col">From</th>
                                                <th scope="col">To</th>
                                                <th scope="col">Duration</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM exp WHERE id='$s'";
                                            $query_run = mysqli_query($db, $query);
                                            $sn = 1; // Serial Number

                                            if (mysqli_num_rows($query_run) > 0) {
                                                foreach ($query_run as $row) {
                                                    // Handle "To" date when it is "0000-00-00"
                                                    $to_date = ($row['tod'] == "0000-00-00") ? "Current" : htmlspecialchars($row['tod']);
                                            ?>
                                                    <tr>
                                                        <td><?php echo $sn++; ?></td>
                                                        <td><?php echo htmlspecialchars($row['iname']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['design']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['fromd']); ?></td>
                                                        <td><?php echo $to_date; ?></td>
                                                        <td><?php echo htmlspecialchars($row['exp']); ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='6' class='text-center'>No experience records found</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- exp end -->
                    <!-- posting Start -->

                    <!-- Posting Details Section -->
                    <div class="col-sm-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-decoration-underline">Posting Details</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="gradient-header">
                                            <tr>
                                                <th scope="col">S.No</th>
                                                <th scope="col">Level</th>
                                                <th scope="col">Posting Name</th>
                                                <th scope="col">From</th>
                                                <th scope="col">To</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM posting WHERE id='$s'";
                                            $query_run = mysqli_query($db, $query);
                                            $sn = 1; // Serial Number

                                            if (mysqli_num_rows($query_run) > 0) {
                                                foreach ($query_run as $row) {
                                                    // Handle "To" date when it is "0000-00-00"
                                                    $to_date = ($row['tod'] == "0000-00-00") ? "Current" : htmlspecialchars($row['tod']);
                                            ?>
                                                    <tr>
                                                        <td><?php echo $sn++; ?></td>
                                                        <td><?php echo htmlspecialchars($row['level']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['pname']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['fromd']); ?></td>
                                                        <td><?php echo $to_date; ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='5' class='text-center'>No posting records found</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- posting end -->



                    <!-- Training Details Section -->
                    <div class="col-sm-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-decoration-underline">Training Details</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="gradient-header">
                                            <tr>
                                                <th scope="col">S.No</th>
                                                <th scope="col">Type of Training</th>
                                                <th scope="col">Name of the Organization</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">From</th>
                                                <th scope="col">To</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM training WHERE id='$s'";
                                            $query_run = mysqli_query($db, $query);
                                            $sn = 1; // Serial Number

                                            if (mysqli_num_rows($query_run) > 0) {
                                                foreach ($query_run as $row) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $sn++; ?></td>
                                                        <td><?php echo htmlspecialchars($row['type']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['no']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['fromd']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['tod']); ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='6' class='text-center'>No training records found</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- training end -->
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

        function exportToPDF() {
    if (typeof html2canvas === 'undefined' || typeof jspdf === 'undefined') {
        Swal.fire({
            icon: 'error',
            title: 'Library Missing',
            text: 'PDF generation libraries are not loaded. Please refresh the page and try again.',
        });
        return;
    }

    Swal.fire({
        title: 'Generating PDF...',
        text: 'Please wait while we prepare your document',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const contentElement = document.querySelector('.main-body');
    
    const options = {
        scale: 2,
        useCORS: true,
        logging: false,
        allowTaint: true,
        backgroundColor: '#ffffff'
    };
    
    html2canvas(contentElement, options).then(canvas => {
        try {
            const { jsPDF } = jspdf;
            
            const pdf = new jsPDF({
                orientation: 'portrait',
                unit: 'mm',
                format: 'a4'
            });

            // Define margins (in mm)
            const margin = {
                top: 20,
                bottom: 20,
                left: 20,
                right: 20
            };

            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();
            
            // Calculate dimensions while maintaining aspect ratio
            const imgWidth = pageWidth - margin.left - margin.right;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            
            let heightLeft = imgHeight;
            let position = margin.top;

            // Add first page content
            pdf.addImage(
                canvas.toDataURL('image/jpeg', 1.0),
                'JPEG',
                margin.left,
                margin.top,
                imgWidth,
                imgHeight
            );

            // Add subsequent pages if needed
            while (heightLeft >= pageHeight) {
                position = -(pageHeight - margin.top);
                heightLeft -= pageHeight;

                pdf.addPage();
                pdf.addImage(
                    canvas.toDataURL('image/jpeg', 1.0),
                    'JPEG',
                    margin.left,
                    position,
                    imgWidth,
                    imgHeight
                );
            }

            // Generate filename
            const facultyName = document.querySelector('.card-body h4')?.textContent || 'faculty';
            const cleanName = facultyName.trim().replace(/\s+/g, '-').toLowerCase();
            const filename = `${cleanName}-profile-${new Date().toISOString().split('T')[0]}.pdf`;
            
            pdf.save(filename);
            Swal.close();
            
            Swal.fire({
                icon: 'success',
                title: 'PDF Generated',
                text: 'Your document has been created successfully.',
                timer: 2000
            });
            
        } catch (error) {
            console.error('PDF generation error:', error);
            Swal.fire({
                icon: 'error',
                title: 'PDF Generation Failed',
                text: 'There was an error creating your PDF. Please try again later.',
            });
        }
    }).catch(error => {
        console.error('Canvas generation error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to capture the page content. Please try again.',
        });
    });
}
    </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</body>

</html>