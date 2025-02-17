<?php


include("../../config.php");
include("../../session.php");
include '../../event_update_deadline.php';
$sqlcount1 = "SELECT COUNT(*) AS total_rows1 FROM user WHERE status_no = 0";
$resultcount1 = $conn->query($sqlcount1);
$row1 = $resultcount1->fetch_assoc();
$total_rows1 = $row1['total_rows1'];
$sqlcount2 = "SELECT COUNT(*) AS total_rows2 FROM user WHERE status_no = 4";
$resultcount2 = $conn->query($sqlcount2);
$row2 = $resultcount2->fetch_assoc();
$total_rows2 = $row2['total_rows2'];
$total_sum = $total_rows1 + $total_rows2;
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <style>
        .btn-icon {
            width: 1.5rem;
            height: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            padding: 0;
            font-size: 1rem;
            border-radius: 50%;
        }

        .btn-correct {
            background-color: green;
            color: rgb(255, 255, 255);
        }

        .btn-wrong {
            background-color: red;
            color: white;
        }

        .test {
            width: 20px;
            height: 20px;
            background-color: black;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-size: 0.875rem;
            margin-left: 10px;
        }

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

        .breadcrumb-area {
            background: white;
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

        .tab-header {

            font-size: 0.9em;

        }

        .gradient-header {
            --bs-table-bg: transparent;
            --bs-table-color: white;
            background: linear-gradient(135deg, #4CAF50, #2196F3) !important;

            text-align: center;
            font-size: 0.9em;


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
        <?php include '../../ftopbar.php'; ?>


        <!-- Breadcrumb -->
        <div class="breadcrumb-area custom-gradient">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Events</li>
                </ol>
            </nav>
        </div>


        <div class="modal fade" id="view_Modal" tabindex="-1"
            role="dialog" aria-labelledby="view_ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="view_ModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body text-center" id="view_ModalBody">
                        <!-- Content will be loaded dynamically here -->
                    </div>
                </div>
            </div>
        </div>




        <!-- Content Area -->
        <div class="container-fluid">
            <div class="custom-tabs">

                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#org_preEvent" id="dash-bus-tab" role="tab" aria-selected="true">
                            <span class="hidden-xs-down"><i class="fas fa-calendar-alt"></i><b> Pre Event (<?php echo htmlspecialchars($total_rows1); ?>) </b></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#org_postEvent" id="pend-bus-tab" role="tab" aria-selected="false">
                            <span class="hidden-xs-down"><i class="fas fa-calendar-check"></i><b> Post Event(<?php echo htmlspecialchars($total_rows2); ?>)</b></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#org_rejectionEvent" id="work-bus-tabb" role="tab" aria-selected="false">
                            <span class="hidden-xs-down"><i class="fas fa-times-circle"></i><b> Rejected Event</b></span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane p-20 active" id="org_preEvent" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="user" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr class="gradient-header">
                                                        <!-- <th><b>S.No</b></th> -->
                                                        <th><b>Organizer<b></th>
                                                        <th><b>Events</b></th>
                                                        <!-- <th><b>Department</b></th> -->
                                                        <th><b>Academic Year</b></th>
                                                        <!-- <th><b>Venue</b></th> 
                                                                    <th><b>From</b></th>
                                                                    <th><b>To</b></th>
                                                                    <th><b>Total Days</b></th>
                                                                    <th><b>Chief Guest</b></th> -->
                                                        <th><b>Brochure</b></th>
                                                        <th><b>Guest </b></th>
                                                        <th><b>Fund</b></th>
                                                        <th><b>Action</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                  
                                                    $sql = "SELECT * FROM user WHERE status_no=0";
                                                    $result = mysqli_query($conn, $sql);

                                                    $s = 1;
                                                    while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                        <tr>
                                                            <!-- <td><?php echo $s; ?></td> -->
                                                            <td><?php echo $row['organizer']; ?></td>
                                                            <td><?php echo $row['eventname']; ?></td>
                                                            <!-- <td><?php echo $row['dept']; ?></td> -->
                                                            <td><?php echo $row['academia']; ?></td>
                                                            <!-- <td><?php echo $row['venue']; ?></td>
                                                                            <td><?php echo $row['starting_date']; ?></td>
                                                                            <td><?php echo $row['ending_date']; ?></td>
                                                                            <td><?php echo $row['total']; ?></td>
                                                                            <td><?php echo $row['chief_guest']; ?></td> -->

                                                            <td style="text-align: center; vertical-align: middle;">
                                                                <button type="button" data-pdf='<?php echo $row['brochure']; ?>' id="eventbrochure" style="border: none; background: transparent;" onclick="changeColor(this)" data-bs-toggle="tooltip" data-bs-placement="top" title="View Event Brochure">
                                                                    <i class="far fa-address-card brochure-icon" style="font-size: 30px; color: #00aaff;"></i>
                                                                </button>
                                                            </td>
                                                            <td style="text-align: center; vertical-align: middle;">
                                                                <button type="button" data-pdf="<?php echo $row['about_chief_guest']; ?>" id="openguest_event" style="border: none; background: none;" data-bs-toggle="tooltip" data-bs-placement="top" title="View Chief Guest Details">
                                                                    <i class="fas fa-user   " style="font-size: 20px; color: #2255a4;"></i>
                                                                </button>
                                                            </td>
                                                            <td style="text-align: center; vertical-align: middle;">
                                                                <button type="button" data-pdf="<?php echo $row['fund_details']; ?>" id="fund" style="border: none; background: none;" data-bs-toggle="tooltip" data-bs-placement="top" title="View Fund Details">
                                                                    <img src="img/fund2.png" width="30" height="30" alt="Open Fund PDF">
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex">
                                                                    <button class="btn btn-success btn-icon mr-2 postapproveBtn" aria-label="Correct" data-id="<?php echo $row['id']; ?>">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                    <button class="btn btn-danger btn-icon postrejectBtn" aria-label="Wrong" data-id="<?php echo $row['id']; ?>">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </div>

                                                            </td>


                                                        </tr>
                                                    <?php
                                                        $s++;
                                                    };
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-20" id="org_postEvent" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="postevent" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr class="gradient-header">
                                                        <!-- <th><b>S.No</b></th> -->
                                                        <th><b>Organizer<b></th>
                                                        <th><b>Events</b></th>

                                                        <th><b>Academic Year</b></th>
                                                        <!-- <th><b>Venue</b></th> 
                                                                    <th><b>From</b></th>
                                                                    <th><b>To</b></th>
                                                                    <th><b>Total Days</b></th>
                                                                    <th><b>Chief Guest</b></th> -->
                                                        <th><b>Brochure</b></th>
                                                        <th><b> Guest</b></th>
                                                        <th><b>Fund</b></th>
                                                        <th><b>Document</b></th>
                                                        <th><b>Action</b></th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                   
                                                    $sql = "SELECT * FROM user WHERE status_no=4";
                                                    $result = mysqli_query($conn, $sql);
                                                    $s = 1;
                                                    while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                        <tr>
                                                            <!-- <td><?php echo $s; ?></td> -->
                                                            <td><?php echo $row['organizer']; ?></td>
                                                            <td><?php echo $row['eventname']; ?></td>
                                                            <!-- <td><?php echo $row['dept']; ?></td> -->
                                                            <td><?php echo $row['academia']; ?></td>
                                                            <!-- <td><?php echo $row['venue']; ?></td>
                                                                            <td><?php echo $row['starting_date']; ?></td>
                                                                            <td><?php echo $row['ending_date']; ?></td>
                                                                            <td><?php echo $row['total']; ?></td>
                                                                            <td><?php echo $row['chief_guest']; ?></td> -->

                                                            <td style="text-align: center; vertical-align: middle;">
                                                                <button type="button" data-pdf='<?php echo $row['brochure']; ?>' id="eventbrochure" style="border: none; background: transparent;" onclick="changeColor(this)" data-bs-toggle="tooltip" data-bs-placement="top" title="View Event Brochure">
                                                                    <i class="far fa-address-card brochure-icon" style="font-size: 30px; color: #00aaff;"></i>
                                                                </button>
                                                            </td>
                                                            <td style="text-align: center; vertical-align: middle;">
                                                                <button type="button" data-pdf="<?php echo $row['about_chief_guest']; ?>" id="openguest_pevent" style="border: none; background: none;" data-bs-toggle="tooltip" data-bs-placement="top" title="View Chief Guest Details">
                                                                    <i class="fas fa-user   " style="font-size: 20px; color: #2255a4;"></i>
                                                                </button>
                                                            </td>
                                                            <td style="text-align: center; vertical-align: middle;">
                                                                <button type="button" data-pdf="<?php echo $row['fund_details']; ?>" id="fund" style="border: none; background: none;" data-bs-toggle="tooltip" data-bs-placement="top" title="View Fund Details">
                                                                    <img src="img/fund2.png" width="30" height="30" alt="Open Fund PDF">
                                                                </button>
                                                            </td>
                                                            <td style="text-align: center; vertical-align: middle;">
                                                                <button type="button" class="btn btn-link" data-pdf='<?php echo $row['merged_pdf']; ?>' id="viewDocuments" style="border: none; background: none;" data-bs-toggle="tooltip" data-bs-placement="top" title="View Post EventDetails">
                                                                    <i class="fas fa-file" style="padding: 0; color:#00aaff; font-size: 25px;"></i>
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex">
                                                                    <button class="btn btn-success btn-icon mr-2 postapproveBtn" aria-label="Correct" data-id="<?php echo $row['id']; ?>">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                    <button class="btn btn-danger btn-icon postrejectBtn" aria-label="Wrong" data-id="<?php echo $row['id']; ?>">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </div>
                                                            </td>


                                                        </tr>
                                                    <?php
                                                        $s++;
                                                    };
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-20" id="org_rejectionEvent" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="rejectionevent" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr class="gradient-header">
                                                        <!-- <th><b>S.No</b></th> -->
                                                        <th><b>Organizer<b></th>
                                                        <th><b>Events</b></th>

                                                        <th><b>Academic Year</b></th>
                                                        <!-- <th><b>Venue</b></th> 
                                                                    <th><b>From</b></th>
                                                                    <th><b>To</b></th>
                                                                    <th><b>Total Days</b></th>
                                                                    <th><b>Chief Guest</b></th> -->
                                                        <th><b>Brochure</b></th>
                                                        <th><b> Guest</b></th>
                                                        <th><b>Fund</b></th>
                                                        <th><b>Document</b></th>
                                                        <th><b>Action</b></th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                   
                                                    $sql = "SELECT * FROM user WHERE status_no=9 || status_no = 10 || status_no = 12 || status_no = 13";
                                                    $result = mysqli_query($conn, $sql);
                                                    $s = 1;
                                                    $status = [
                                                        0 => "Event Applied",
                                                        1 => "Approved by HOD",
                                                        2 => "Approved by IQAC",
                                                        3 => "Approved by PRINCIPAL",
                                                        4 => "Post Event Forwarded to HOD",
                                                        5 => "Post Event Approved by HOD",
                                                        6 => "Post Event Approved by IQAC",
                                                        7 => "Event Completed",
                                                        8 => "Rejection by HOD",
                                                        9 => "Rejection by IQAC",
                                                        10 => "Rejection by PRINCIPAL",
                                                        11 => "Post Event Rejection by HOD",
                                                        12 => "Post Event Rejection by IQAC",
                                                        13 => "Post Event Rejection by PRINCIPAL",
                                                        14 => "DeadLine Past",
                                                        15 => "Lock",
                                                    ];
                                                    while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                        <tr>
                                                            <!-- <td><?php echo $s; ?></td> -->
                                                            <td><?php echo $row['organizer']; ?></td>
                                                            <td><?php echo $row['eventname']; ?></td>
                                                            <!-- <td><?php echo $row['dept']; ?></td> -->
                                                            <td><?php echo $row['academia']; ?></td>
                                                            <!-- <td><?php echo $row['venue']; ?></td>
                                                                            <td><?php echo $row['starting_date']; ?></td>
                                                                            <td><?php echo $row['ending_date']; ?></td>
                                                                            <td><?php echo $row['total']; ?></td>
                                                                            <td><?php echo $row['chief_guest']; ?></td> -->

                                                            <td style="text-align: center; vertical-align: middle;">
                                                                <button type="button" data-pdf='<?php echo $row['brochure']; ?>' id="eventbrochure" style="border: none; background: transparent;" onclick="changeColor(this)" data-bs-toggle="tooltip" data-bs-placement="top" title="View Event Brochure">
                                                                    <i class="far fa-address-card brochure-icon" style="font-size: 30px; color: #00aaff;"></i>
                                                                </button>
                                                            </td>
                                                            <td style="text-align: center; vertical-align: middle;">
                                                                <button type="button" data-pdf="<?php echo $row['about_chief_guest']; ?>" id="openguest_cevent" style="border: none; background: none;" data-bs-toggle="tooltip" data-bs-placement="top" title="View Chief Guest Details">
                                                                    <i class="fas fa-user   " style="font-size: 20px; color: #2255a4;"></i>
                                                                </button>
                                                            </td>
                                                            <td style="text-align: center; vertical-align: middle;">
                                                                <button type="button" data-pdf="<?php echo $row['fund_details']; ?>" id="fund" style="border: none; background: none;" data-bs-toggle="tooltip" data-bs-placement="top" title="View Fund Details">
                                                                    <img src="img/fund2.png" width="30" height="30" alt="Open Fund PDF">
                                                                </button>
                                                            </td>
                                                            <td style="text-align: center; vertical-align: middle;">
                                                                <?php
                                                                if ($row["status_no"] >= 11 || $row["status_no"] == 3) {
                                                                    echo "<button type='button' class='btn btn-link' data-pdf='" . $row['merged_pdf'] . "' id='viewDocuments' style='border: none; background: none;' data-bs-toggle='tooltip' data-bs-placement='top' title='View Post Event Details'>
                                                                                                            <i class='fas fa-file' style='padding: 0; color:#00aaff; font-size: 25px;'></i>
                                                                                                        </button>";
                                                                } elseif ($row["status_no"] > 4) {
                                                                    echo "<button type='button' disabled style='border: none; background: transparent;' data-bs-toggle='tooltip' data-bs-placement='top' title='Upload Disabled'> 
                                                                                                            <i class='fas fa-upload brochure-icon' style='font-size: 20px; color:#da542e;'></i>
                                                                                                        </button>";
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="text-align: center; vertical-align: middle;">
                                                                <button type="button"
                                                                    class="btn 
                                                                                                <?php
                                                                                                if (in_array($row['status_no'], [1, 2, 5, 6])) {
                                                                                                    echo 'btn-success';
                                                                                                } elseif (in_array($row['status_no'], [8, 9, 10, 11, 12, 13])) {
                                                                                                    // Echo both the class and data-feedback attribute in one line
                                                                                                    echo 'btn-danger viewFeedback" data-feedback="' . htmlspecialchars($row['feedback']) . '"';
                                                                                                } elseif (in_array($row['status_no'], [3, 7])) {
                                                                                                    echo 'btn-info';
                                                                                                } elseif (in_array($row['status_no'], [0, 4])) {
                                                                                                    echo 'btn-secondary';
                                                                                                }
                                                                                                ?>">
                                                                    <?php echo $status[$row['status_no']] ?? 'Unknown Status'; ?>
                                                                </button>
                                                            </td>


                                                        </tr>
                                                    <?php
                                                        $s++;
                                                    };
                                                    ?>
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

        <!-- Footer -->
        <?php include '../../footer.php'; ?>
    </div>

    <div class="modal fade" id="viewPdfModal" tabindex="-1" role="document" aria-labelledby="viewPdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPdfModalLabel">View PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body" id="dynamicModalBody1">

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
   
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

        // Toggle Sidebar
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const body = document.body;
        const mobileOverlay = document.getElementById('mobileOverlay');

        function toggleSidebar() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('mobile-show');
                mobileOverlay.classList.toggle('show');
                body.classList.toggle('sidebar-open');
            } else {
                sidebar.classList.toggle('collapsed');
            }
        }
        hamburger.addEventListener('click', toggleSidebar);
        mobileOverlay.addEventListener('click', toggleSidebar);
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

        // Toggle Submenu
        const menuItems = document.querySelectorAll('.has-submenu');
        menuItems.forEach(item => {
            item.addEventListener('click', () => {
                const submenu = item.nextElementSibling;
                item.classList.toggle('active');
                submenu.classList.toggle('active');
            });
        });

        // Handle responsive behavior
        window.addEventListener('resize', () => {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('collapsed');
                sidebar.classList.remove('mobile-show');
                mobileOverlay.classList.remove('show');
                body.classList.remove('sidebar-open');
            } else {
                sidebar.style.transform = '';
                mobileOverlay.classList.remove('show');
                body.classList.remove('sidebar-open');
            }
        });
    </script>

    <script>
       $(document).on('click', '#openguest_event, #openguest_cevent, #openguest_pevent', function() { 
    var Chiefguest = $(this).data('pdf');
    $('#viewPdfModalLabel').text('pdf');
    $('#viewPdfModalBody1').html('<iframe src="' + Chiefguest + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
    $('#viewPdfModal').modal('show');
});

        $(document).on('click', '#fund', function() {
            var fund = $(this).data('pdf'); // Retrieve the PDF file URL from the data attribute

            if (fund) { // Check if the PDF URL is provided
                // Update the modal title
                $('#viewPdfModalLabel').text('Fund Details PDF');

                // Embed the PDF in the modal's body using an iframe
                $('#viewPdfModalBody').html('<iframe src="' + fund + '" frameborder="0" style="width:100%; height:500px;"></iframe>');

                // Show the modal
                $('#viewPdfModal').modal('show');
            } else {
                // Handle case where no PDF is available
                $('#viewPdfModalLabel').text('No Fund Details PDF Available');
                $('#viewPdfModalBody').html('<p>No PDF has been uploaded for the Fund Details.</p>');

                // Show the modal
                $('#viewPdfModal').modal('show');
            }
        });
        $(document).on('click', '#eventbrochure', function() {
            var brochures = $(this).data('pdf');
            $('#viewPdfModalLabel').text('View PDF'); // Update label if needed
            $('#viewPdfModalBody').html('<iframe src="' + brochures + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#viewPdfModal').modal('show');
        });
        $(document).on('click', '#viewDocuments', function() {
            var documents = $(this).data('pdf'); // Use data-pdf instead of data-documents
            $('#viewPdfModalLabel').text('View PDF');
            $('#viewPdfModalBody').html('<iframe src="' + documents + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#viewPdfModal').modal('show');
        });
        $(document).on('click', '.viewFeedback', function() {
            var feedback = $(this).data('feedback');

            $('#viewPdfModalLabel').text('Feedback');
            $('#viewPdfModalBody').html('<input type="text" class="form-control" value="' + feedback + '" readonly>');
            $('#viewPdfModal').modal('show');
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialize DataTables for #user and #postevent tables
            var userTable = $('#user').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'fetchurl.php', // Replace with your user data source URL
                    type: 'POST',
                    data: {
                        table: 'preprincipal'
                    } // Pass the table name
                }
            });

            var postEventTable = $('#postevent').DataTable({
                processing: true,
                serverSide: true,
                "autoWidth": false,
                ajax: {
                    url: 'fetchurl.php', // Replace with your postevent data source URL
                    type: 'POST',
                    data: {
                        table: 'postprincipal'
                    } // Pass the table name
                }
            });

            $(document).on('click', '.preapproveBtn, .prerejectBtn', function() {
                var applicantId = $(this).data('id');
                var action = $(this).hasClass('preapproveBtn') ? 'approve' : 'reject';

                if (action === 'approve') {
                    // Confirmation for approval
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to accept this Event?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Accept it!',
                        cancelButtonText: 'No, cancel!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'approve.php',
                                method: 'POST',
                                data: {
                                    id: applicantId,
                                    action: action,
                                    page: 'principal'
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Accepted!',
                                            text: res.message
                                        }).then(() => {
                                            userTable.ajax.reload(null, false);
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: res.message
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Request Failed',
                                        text: 'An error occurred while processing your request: ' + error
                                    });
                                }
                            });
                        }
                    });
                } else if (action === 'reject') {
                    // Confirmation for rejection and reason input
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to Reject this Event?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Reject it!',
                        cancelButtonText: 'No, cancel!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Reject Event',
                                text: "Please provide a reason for rejection:",
                                icon: 'warning',
                                input: 'textarea',
                                inputPlaceholder: 'Enter your reason here...',
                                showCancelButton: true,
                                confirmButtonText: 'Reject',
                                cancelButtonText: 'Cancel',
                                reverseButtons: true,
                                inputValidator: (value) => {
                                    if (!value) {
                                        return 'You need to provide a reason!';
                                    }
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var rejectionReason = result.value;

                                    $.ajax({
                                        url: 'approve.php',
                                        method: 'POST',
                                        data: {
                                            id: applicantId,
                                            action: action,
                                            reason: rejectionReason,
                                            page: 'principal'
                                        },
                                        dataType: 'json',
                                        success: function(res) {
                                            if (res.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Rejected',
                                                    text: res.message
                                                }).then(() => {
                                                    userTable.ajax.reload(null, false);
                                                });
                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: res.message
                                                });
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Request Failed',
                                                text: 'An error occurred while processing your request: ' + error
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            });

            $(document).on('click', '.postapproveBtn, .postrejectBtn', function() {
                var applicantId = $(this).data('id');
                var action = $(this).hasClass('postapproveBtn') ? 'approve' : 'reject';

                if (action === 'approve') {
                    // Confirmation for approval
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to accept this Event?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Accept it!',
                        cancelButtonText: 'No, cancel!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading overlay
                            $("#loadingOverlay").show();

                            $.ajax({
                                url: 'approve.php',
                                method: 'POST',
                                data: {
                                    id: applicantId,
                                    action: action,
                                    page: 'principal'
                                },
                                dataType: 'json',
                                success: function(res) {
                                    // Hide loading overlay
                                    $("#loadingOverlay").hide();

                                    if (res.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Accepted!',
                                            text: res.message
                                        }).then(() => {
                                            postEventTable.ajax.reload(null, false);
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: res.message
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    // Hide loading overlay
                                    $("#loadingOverlay").hide();

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Request Failed',
                                        text: 'An error occurred while processing your request: ' + error
                                    });
                                }
                            });
                        }
                    });
                } else if (action === 'reject') {
                    // Confirmation for rejection and reason input
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to Reject this Event?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Reject it!',
                        cancelButtonText: 'No, cancel!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Reject Event',
                                text: "Please provide a reason for rejection:",
                                icon: 'warning',
                                input: 'textarea',
                                inputPlaceholder: 'Enter your reason here...',
                                showCancelButton: true,
                                confirmButtonText: 'Reject',
                                cancelButtonText: 'Cancel',
                                reverseButtons: true,
                                inputValidator: (value) => {
                                    if (!value) {
                                        return 'You need to provide a reason!';
                                    }
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var rejectionReason = result.value;

                                    $.ajax({
                                        url: 'approve.php',
                                        method: 'POST',
                                        data: {
                                            id: applicantId,
                                            action: action,
                                            reason: rejectionReason,
                                            page: 'principal'
                                        },
                                        dataType: 'json',
                                        success: function(res) {
                                            if (res.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Rejected',
                                                    text: res.message
                                                }).then(() => {
                                                    postEventTable.ajax.reload(null, false);
                                                });
                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: res.message
                                                });
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Request Failed',
                                                text: 'An error occurred while processing your request: ' + error
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            });

        });
    </script>




</body>

</html>