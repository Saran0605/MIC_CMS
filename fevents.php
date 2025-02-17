<?php
include("config.php");
include("session.php");
$status = [
    0 => "Applied",
    1 => "HOD",
    2 => "IQAC",
    3 => "HOD",
    4 => "IQAC",
];

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
                    <li class="breadcrumb-item"><a href="main.php#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Events</li>
                </ol>
            </nav>
        </div>


        <!-- Content Area -->
        <div class="container-fluid">
            <div class="custom-tabs">
                <ul class="nav navs-tabs justify-content-center " role="tablist">
                    <li class="nav-item" role="presentation" style="margin-right: 10px;">
                        <!-- Add margin between tabs -->
                        <a class="nav-link active" style="font-size: 0.9em;" id="edit-bus-tab" data-bs-toggle="tab" href="#org_events"
                            role="tab" aria-selected="true">
                            <i class="fas fa-clipboard tab-icon"></i> Pre Event Organisation</span>

                        </a>
                    </li>
                    <li class="nav-item " role="presentation">
                        <!-- Add margin between tabs -->
                        <a class="nav-link" id="edit-bus-tab" data-bs-toggle="tab" style="font-size: 0.9em;" href="#org_completed_events"
                            role="tab" aria-selected="false">
                            <i class="fas fa-clipboard tab-icon"></i> Post Event Organisation</span>

                        </a>
                    </li>
                    <li class="nav-item " role="presentation">
                        <!-- Add margin between tabs -->
                        <a class="nav-link" id="edit-bus-tab" data-bs-toggle="tab" style="font-size: 0.9em;" href="#parti_events"
                            role="tab" aria-selected="false">
                            <i class="fas fa-clipboard tab-icon"></i> Event Participation</span>

                        </a>
                    </li>
                    <li class="nav-item " role="presentation">
                        <!-- Add margin between tabs -->
                        <a class="nav-link" id="edit-bus-tab" data-bs-toggle="tab" style="font-size: 0.9em;"
                            href="#parti_completed_events" role="tab" aria-selected="false">

                            <i class="fas fa-clipboard tab-icon"></i> Event Completed</span>
                        </a>
                    </li>
                    <li class="nav-item " role="presentation">
                        <!-- Add margin between tabs -->
                        <a class="nav-link" id="edit-bus-tab" data-bs-toggle="tab" style="font-size: 0.9em;" href="#claim_events"
                            role="tab" aria-selected="false">
                            <i class="fas fa-clipboard tab-icon"></i> Claim form</span>

                        </a>
                    </li>
                </ul>



                <div class="tab-content">

                    <div class="tab-pane p-20 active" id="org_events" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">

                                        <button type="button" style="float: right;" class="btn btn-primary style-yQg7i mr-3"
                                            data-bs-toggle="modal" data-bs-target="#preEventOrg_Model" id="style-yQg7i">
                                            Add Event Details
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div class="custom-table">
                                                <table id="preEventOrg_table" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr class="gradient-header">
                                                            <th><b>S.No</b></th>
                                                            <th><b>Organizer<b></th>
                                                            <th><b>Events</b></th>
                                                            <th><b>Academic Year</b></th>
                                                            <th><b>Brochure</b></th>
                                                            <th><b>Guest</b></th>
                                                            <th><b>Fund</b></th>
                                                            <th><b>Post Event</b></th>
                                                            <th><b>Status</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT * FROM user";
                                                        $result = mysqli_query($conn, $sql);
                                                        $status = [
                                                            0 => "Pre Event Applied",
                                                            1 => "Approved by HOD",
                                                            2 => 'Approved by <img src="assets/images/iqac.png" style="width:30px; height:30px;">',
                                                            3 => "Approved by PRINCIPAL",
                                                            4 => "Post Event Applied",
                                                            5 => "Post Event Approved by HOD",
                                                            6 => "Post Event Approved by IQAC ",
                                                            7 => "Event Completed",
                                                            8 => "Rejection by HOD",
                                                            9 => "Rejection by IQAC",
                                                            10 => "Rejection by PRINCIPAL",
                                                            11 => "Post Event Rejection by HOD",
                                                            12 => "Post Event Rejection by IQAC",
                                                            13 => "Post Event Rejection by PRINCIPAL",
                                                            14 => "DeadLine Passed",
                                                            15 => "Lock",
                                                        ];
                                                        $s = 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $s; ?></td>
                                                                <td><?php echo $row['organizer']; ?></td>
                                                                <td><?php echo $row['eventname']; ?></td>
                                                                <!-- <td><?php echo $row['dept']; ?></td> -->
                                                                <td><?php echo $row['academia']; ?></td>
                                                                <!-- <td><?php echo $row['venue']; ?></td> -->
                                                                <!-- <td><?php echo $row['starting_date']; ?></td> -->
                                                                <!-- <td><?php echo $row['ending_date']; ?></td> -->
                                                                <!-- <td><?php echo $row['total']; ?></td> -->
                                                                <!-- <td><?php echo $row['chief_guest']; ?></td> -->
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    <button type="button" data-pdf='<?php echo $row['brochure']; ?>'
                                                                        id="eventbrochure" style="border: none; background: transparent;"
                                                                        onclick="changeColor(this)" data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" title="View Event Brochure">
                                                                        <i class="far fa-address-card brochure-icon"
                                                                            style="font-size: 30px; color: #00aaff;"></i>
                                                                    </button>
                                                                </td>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    <button type="button"
                                                                        data-pdf="<?php echo $row['about_chief_guest']; ?>" id="openguest"
                                                                        style="border: none; background: none;" data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" title="View Chief Guest Details">
                                                                        <i class="fas fa-user   "
                                                                            style="font-size: 20px; color: #2255a4;"></i>
                                                                        <!-- <img src="img/speaker2.png" style="width:30px; height:30px;" alt="Open Guest PDF"> -->
                                                                    </button>
                                                                </td>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    <button type="button" data-pdf="<?php echo $row['fund_details']; ?>"
                                                                        id="fund" style="border: none; background: none;"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="View Fund Details">
                                                                        <img src="img/fund2.png" width="30" height="30" alt="Open Fund PDF">
                                                                    </button>
                                                                </td>
                                                                <!-- // fas fa-print -->
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    <?php
                                                                    if (($row["status_no"] >= 11 || $row["status_no"] == 3) && ($row["status_no"] != 14)) {
                                                                        echo "<div class='d-flex align-items-center'>
                                                                                    <!-- Upload Icon Button -->
                                                                                    <button type='button' class='uploadDocuments' data-id='" . $row["id"] . "' data-bs-toggle='modal' data-bs-target='#postEventOrg_Modal' style='border: none; background: transparent;' data-bs-toggle='tooltip' data-bs-placement='top' title='Upload Post Event Document'>
                                                                                        <i class='fas fa-upload brochure-icon' style='font-size: 20px; color: green;'></i>
                                                                                    </button>

                                                                                    <!-- Print Icon and Button -->
                                                                                    <button type='button' class='printBtn' data-id='" . $row["id"] . "' style='border: none; background: transparent;' data-bs-toggle='tooltip' data-bs-placement='top' title='Approval Form'>
                                                                                        <i class='fas fa-print' style='font-size: 25px; color:#007bff;'></i>
                                                                                    </button>
                                                                                    </div>";
                                                                    } elseif ($row["status_no"] == 7) {
                                                                        echo "<div class='d-flex justify-content-center'>
                                                                                        <button type='button' class='downloadDocuments' data-download='" . $row["merged_pdf"] . "' style='border: none; background: transparent;line-height:1;' data-bs-toggle='tooltip' data-bs-placement='top' title='Download Documents'>
                                                                                            <i class='mdi mdi-arrow-down-bold-circle' style='font-size: 29px; color:#007bff;'></i>
                                                                                        </button>
                                                                                    </div>";
                                                                    } else if ($row["status_no"] == 14 || $row['status_no'] == 15) {

                                                                        echo "<div class='d-flex justify-content-center'>
                                                                                        <button type='button' disabled style='border: none; background: transparent;' data-bs-toggle='tooltip' data-bs-placement='top' title='Upload Disabled'>
                                                                                            <i class='fas fa-upload brochure-icon' style='font-size: 20px; color:#da542e;'></i>
                                                                                        </button>
                                                                                    </div>";
                                                                    } else {
                                                                        echo "<div class='d-flex justify-content-center'>
                                                                                        <button type='button' disabled style='border: none; background: transparent;' data-bs-toggle='tooltip' data-bs-placement='top' title='Upload Disabled'>
                                                                                            <i class='fas fa-upload brochure-icon' style='font-size: 20px; color:#da542e;'></i>
                                                                                        </button>
                                                                                    </div>";
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    <button type="button" style="height:40px;" class="btn w-100
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
                                                                                                } else {
                                                                                                    echo 'btn-warning';
                                                                                                }
                                                                                                ?>">
                                                                        <?php echo $status[$row['status_no']] ?? 'Unknown Status'; ?>
                                                                    </button>
                                                                </td>
                                                            <?php
                                                            $s++;
                                                        }
                                                            ?>
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

                    <div class="tab-pane p-20" id="org_completed_events" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">



                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div class="custom-table">
                                                <table id="org_completed_table" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr class="gradient-header">
                                                            <th><b>S.No</b></th>
                                                            <th><b>Organizer<b></th>
                                                            <th><b>Events</b></th>
                                                            <!-- <th><b>Department</b></th> -->
                                                            <th><b>Academic Year</b></th>
                                                            <!-- <th><b>Venue</b></th>  -->
                                                            <!-- <th><b>From</b></th> -->
                                                            <!-- <th><b>To</b></th> -->
                                                            <!-- <th><b>Total Days</b></th> -->
                                                            <!-- <th><b>Chief Guest</b></th> -->
                                                            <th><b>Brochure</b></th>
                                                            <th><b>Guest</b></th>
                                                            <th><b>Fund</b></th>
                                                            <th><b>Post Event</b></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php


                                                        $sql = "SELECT * FROM user where status_no=7";
                                                        $result = mysqli_query($conn, $sql);
                                                        $status = [
                                                            0 => "Pre Event Applied",
                                                            1 => "Approved by HOD",
                                                            2 => "Approved by IQAC",
                                                            3 => "Approved by PRINCIPAL",
                                                            4 => "Post Event Applied",
                                                            5 => "Post Event Approved by HOD",
                                                            6 => "Post Event Approved by IQAC",
                                                            7 => "Event Completed",
                                                            8 => "Rejection by HOD",
                                                            9 => "Rejection by IQAC",
                                                            10 => "Rejection by PRINCIPAL",
                                                            11 => "Post Event Rejection by HOD",
                                                            12 => "Post Event Rejection by IQAC",
                                                            13 => "Post Event Rejection by PRINCIPAL",
                                                        ];

                                                        $s = 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $s; ?></td>
                                                                <td><?php echo $row['organizer']; ?></td>
                                                                <td><?php echo $row['eventname']; ?></td>
                                                                <!-- <td><?php echo $row['dept']; ?></td> -->
                                                                <td><?php echo $row['academia']; ?></td>
                                                                <!-- <td><?php echo $row['venue']; ?></td> -->
                                                                <!-- <td><?php echo $row['starting_date']; ?></td> -->
                                                                <!-- <td><?php echo $row['ending_date']; ?></td> -->
                                                                <!-- <td><?php echo $row['total']; ?></td> -->
                                                                <!-- <td><?php echo $row['chief_guest']; ?></td> -->
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    <button type="button" data-pdf='<?php echo $row['brochure']; ?>'
                                                                        id="eventbrochure" style="border: none; background: transparent;"
                                                                        onclick="changeColor(this)" data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" title="View Event Brochure">
                                                                        <i class="far fa-address-card brochure-icon"
                                                                            style="font-size: 30px; color: #00aaff;"></i>
                                                                    </button>
                                                                </td>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    <button type="button"
                                                                        data-pdf="<?php echo $row['about_chief_guest']; ?>" id="openguest"
                                                                        style="border: none; background: none;" data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" title="View Chief Guest Details">
                                                                        <i class="fas fa-user   "
                                                                            style="font-size: 20px; color: #2255a4;"></i>
                                                                    </button>
                                                                </td>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    <button type="button" data-pdf="<?php echo $row['fund_details']; ?>"
                                                                        id="fund" style="border: none; background: none;"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="View Fund Details">
                                                                        <img src="img/fund2.png" width="30" height="30" alt="Open Fund PDF">
                                                                    </button>
                                                                </td>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    <?php
                                                                    if ($row["status_no"] == 7) {
                                                                        echo "<button type='button' class='btn btn-success downloadDocuments' data-download='" . $row["merged_pdf"] . "' data-bs-toggle='tooltip' data-bs-placement='top' title='Download Documents'>Download</button>";
                                                                    }
                                                                    ?>
                                                                </td>
                                                            <?php
                                                            $s++;
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
                    </div>

                    <div class="tab-pane p-20 active" id="parti_events" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>
                                            <button type="button" style="float: right;" class="btn btn-primary style-yQg7i mr-3"
                                                data-bs-toggle="modal" data-bs-target="#add_preEvent_parti" id="style-yQg7i">
                                                Add Event Details
                                            </button>

                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">

                                            <table id="participated_events" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr class="gradient-header">

                                                        <th>Staff Name</th>
                                                        <th>Event Name</th>
                                                        <th>Event Organizer</th>
                                                        <th>Venue</th>
                                                        <th>Academic</th>
                                                        <!-- <th>To</th> -->
                                                        <th>Event Broucher</th>
                                                        <th>Documents</th>
                                                        <th>Status</th>

                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    $statusOptions = [
                                                        0 => "Forwarded to HOD",
                                                        1 => "Approved by HOD",
                                                        2 => "Approved by IQAC",
                                                        3 => "Approved by Principal",
                                                        4 => "Post Event Forwarded to HOD",
                                                        5 => "Post Event Approved by HOD",
                                                        6 => "Post Event Approved by IQAC",
                                                        7 => "Post Event Approved by Principal",
                                                        8 => "Rejected by HOD",
                                                        9 => "Rejected by IQAC",
                                                        10 => "Rejected by Principal",
                                                        11 => "Post Event Rejected by HOD",
                                                        12 => "Post Event Rejected by IQAC",
                                                        13 => "Post Event Rejected by Principal",
                                                        14 => "Deadline Passed",
                                                        15 => "Locked",
                                                        16 => "Claim not Required",
                                                        17 => "Claim Required",
                                                        18 => "Claim Applied",
                                                        19 => "Claim Approved",
                                                        20 => "Claim Rejected",
                                                        21 => "Claim Deleted",

                                                    ];
                                                    $sql = "SELECT * FROM pre_event_form  where status!=7 ORDER BY `s_no` DESC ";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td>" . $row["staff_name"] . "</td>";
                                                            echo "<td>" . $row["event_name"] . "</td>";
                                                            echo "<td>" . $row["organizer_name"] . "</td>";
                                                            echo "<td>" . $row["venue"] . "</td>";
                                                            echo "<td>" . $row["academic_year"] . "</td>";
                                                            // echo "<td>" .  date('d-m-Y', strtotime(($row["start_date"]))) . "</td>";
                                                            // echo "<td>" .  date('d-m-Y', strtotime(($row["end_date"]))) . "</td>";


                                                            // Event Brochure Button
                                                            echo "<td><button type='button' class='btn btn-info viewBrochure' data-event-brochure='" . $row["event_broucher"] . "'>View</button></td>";
                                                            echo "<td>";
                                                            // Upload Documents Button
                                                            if (($row["status"] >= 11 && $row["status"] < 14) || ($row["status"] == 19 || $row["status"] == 16 || $row["status"] == 21)) {


                                                                echo "<div class='row' style='display: flex;
                                                                         -ms-flex-wrap: wrap; padding-left: 1rem ; padding-right: 1rem ; 
                                                                          align-content: stretch;flex-direction: row;
                                                                          justify-content: space-between;align-items: center;'>
                                                                        <button type='button' class='btn btn-success uploadDocuments col-md-8' 
                                                                        data-id='" . $row["s_no"] . "'   data-bs-toggle='modal' data-bs-target='#add_postEvent_parti'>Upload</button>

                                                                        <button type='button' class='printBtn col-md-4' data-id='" . $row["s_no"] . "' style='border: none; background: transparent;' data-bs-toggle='tooltip' data-bs-placement='top' title='Approval Form'>
                                                                                        <i class='fas fa-print' style='font-size: 25px; color:#007bff;'></i>
                                                                                    </button></div>";
                                                            } else if ($row["status"] == 7) {
                                                                echo "<button type='button' class='btn btn-success downloadDocuments' data-download='" . $row["merged_pdf"] . "' >Download</button>";
                                                            } else if (($row["status"] == 14 || $row['status'] == 15) || !($row["status"] >= 17 && $row["status"] < 22)) {



                                                                echo "<button type='button' class='btn btn-success' disabled>Documents</button>";
                                                            } else {

                                                                echo "<button type='button' class='btn btn-success' disabled>Documents</button>";
                                                            }

                                                            echo "</td>";
                                                            echo "<td>";
                                                            $k = $row["status"];
                                                            $status = $statusOptions[$row["status"]] ?? "Unknown status";

                                                            if (in_array($row["status"], [8, 9, 10, 11, 12, 13])) {
                                                                echo "<button type='button' class='btn btn-danger w-100 viewFeedback' style='height: 40px;' data-feedback='" . htmlspecialchars($row["feedback"]) . "'>" . $status . "</button>";
                                                            } elseif (in_array($row["status"], [14, 15])) {
                                                                echo "<button type='button' class='btn btn-warning w-100' style='height: 40px;'>" . $status . "</button>";
                                                            } else {
                                                                echo "<button type='button' class='btn btn-success w-100' style='height: 40px;'>" . $status . "</button>";
                                                            }

                                                            echo "</td>";

                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                        echo "<tr>No data available</tr>";
                                                    }

                                                    ?>

                                                    <!-- Modal for Event Brochure or Feedback -->



                                                </tbody>

                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-20 " id="parti_completed_events" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">

                                    <div class="card-body">
                                        <div class="table-responsive">

                                            <table id="completed_events_Table" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr class="gradient-header">

                                                        <th>Staff Name</th>
                                                        <th>Event Name</th>
                                                        <th>Event Organizer</th>
                                                        <th>Venue</th>
                                                        <th>From</th>
                                                        <th>To</th>

                                                        <th>Event Broucher</th>
                                                        <th>Documents</th>
                                                        <th>Status</th>

                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    $sql1 = "SELECT * FROM pre_event_form where status = 7 ORDER BY `s_no` DESC ";
                                                    $result1 = $conn->query($sql1);
                                                    if ($result1->num_rows > 0) {
                                                        while ($row = $result1->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td>" . $row["staff_name"] . "</td>";
                                                            echo "<td>" . $row["event_name"] . "</td>";
                                                            echo "<td>" . $row["organizer_name"] . "</td>";
                                                            echo "<td>" . $row["venue"] . "</td>";
                                                            echo "<td>" .  date('d-m-Y', strtotime(($row["start_date"]))) . "</td>";
                                                            echo "<td>" .  date('d-m-Y', strtotime(($row["end_date"]))) . "</td>";


                                                            // Event Brochure Button
                                                            echo "<td><button type='button' class='btn btn-info viewBrochure1' data-event-brochure='" . $row["event_broucher"] . "'>View</button></td>";
                                                            echo "<td>";
                                                            // Upload Documents Button
                                                            if ($row["status"] >= 11 || $row["status"] == 3) {

                                                                echo "<div class='row' style='display: flex;
                                                                         -ms-flex-wrap: wrap;margin-right: -10px;margin-left: -10px;
                                                                          align-content: stretch;flex-direction: row;
                                                                          justify-content: space-between;align-items: center;'>
                                                                        <button type='button' class='btn btn-success uploadDocuments col-md-8' 
                                                                        data-id='" . $row["s.no"] . "'   data-bs-toggle='modal' data-bs-target='#add_postEvent_parti'>Upload</button>
                                                                        <img class='printBtn col-md-4'  src='img/printer.png' data-id='" . $row["s.no"] . "' 
                                                                        alt='Print' width='25' height='25'></div>";
                                                            } else if ($row["status"] == 7) {
                                                                echo "<button type='button' class='btn btn-success downloadDocuments1' data-download='" . $row["merged_pdf"] . "' >Download</button>";
                                                            } else {
                                                                echo "<button type='button' class='btn btn-success' disabled>Documents</button>";
                                                            }
                                                            echo "</td>";
                                                            echo "<td>";
                                                            $k = $row["status"];
                                                            $status = $statusOptions[$row["status"]] ?? "Unknown status";
                                                            if (in_array($row["status"], [8, 9, 10, 11, 12, 13])) {
                                                                echo "
                                                                        <button type='button' class='btn btn-danger viewFeedback' data-feedback='" . htmlspecialchars($row["feedback"]) . "'>" . $status . "</button>";
                                                            } else if ($row['status'] == 14 || $row['status'] == 15) {

                                                                echo "
                                                                        <button type='button' class='btn btn-danger' >" . $status . "</button>";
                                                            } else {
                                                                echo "
                                                                        <button type='button' class='btn btn-success' >" . $status . "</button>";
                                                            }
                                                            echo "</td>";




                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                        echo "<tr>No data available</tr>";
                                                    }

                                                    ?>

                                                    <!-- Modal for Event Brochure or Feedback -->



                                                </tbody>

                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-20 " id="claim_events" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">

                                    <div class="card-body">
                                        <div class="table-responsive">

                                            <table id="claim_events_Table" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr class="gradient-header">

                                                        <th>Staff Name</th>
                                                        <th>Event Name</th>
                                                        <th>Event Organizer</th>
                                                        <th>Venue</th>
                                                        <th>From</th>
                                                        <th>To</th>

                                                        <th>Event Broucher</th>
                                                        <th>Documents</th>
                                                        <th>Status</th>

                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    $sql2 = "SELECT * FROM pre_event_form WHERE status = 3 || status >=17 ORDER BY s_no DESC";

                                                    $result2 = $conn->query($sql2);
                                                    if ($result2->num_rows > 0) {
                                                        while ($row = $result2->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td>" . $row["staff_name"] . "</td>";
                                                            echo "<td id='eventName1'data-eventname='" . $row["event_name"] . "'>" . $row["event_name"] . "</td>";
                                                            echo "<td>" . $row["organizer_name"] . "</td>";
                                                            echo "<td>" . $row["venue"] . "</td>";
                                                            echo "<td  id='eventDate1' data-eventdate='" . date('d-m-Y', strtotime(($row["start_date"]))) . "'>" .  date('d-m-Y', strtotime(($row["start_date"]))) . "</td>";
                                                            echo "<td>" .  date('d-m-Y', strtotime(($row["end_date"]))) . "</td>";


                                                            // Event Brochure Button
                                                            echo "<td><button type='button' class='btn btn-info viewBrochure2' data-event-brochure='" . $row["event_broucher"] . "'>View</button></td>";
                                                            echo "<td>";
                                                            // Upload Documents Button
                                                            if ($row["status"] == 17 || $row["status"] == 20) {

                                                                echo "<div>
                                                                        <button type='button' class='btn btn-success uploadDocuments2' 
                                                                        data-id='" . $row["s_no"] . "'   data-bs-toggle='modal' data-bs-target='#expense_claim_form'>Apply Claim</button>
                                                                        </div>";
                                                            } else if ($row["status"] == 18) {
                                                                echo "<div class='d-flex'><button class='btn btn-success btn-icon mr-2 approvedClaimBtn'  data-id='" . $row["s_no"] . "'aria-label='Correct' title='Claim Approved Manualy' data-bs-toggle='tooltip'>
                                                                                        <i class='fas fa-check'></i>
                                                                                    </button>
                                                                                    <button class='btn  btn-icon mr-2 editClaimBtn'  data-id='" . $row["s_no"] . " 'aria-label='edit' title='Edit Claim' data-bs-toggle='tooltip'>
                                                                                        <i class='fas fa-edit'></i>
                                                                                    </button>
                                                                                    <button class='btn btn-danger btn-icon deleteClaimBtn'  data-id='" . $row["s_no"] . " 'aria-label='Wrong' title='Delete Claim Form' data-bs-toggle='tooltip'>
                                                                                        <i class='fas fa-times'></i>
                                                                                    </button>
                                                                                </div>";
                                                            } else if ($row["status"] == 22) {
                                                                echo "<button type='button' class='btn btn-success downloadDocuments2' data-download='" . $row["merged_pdf"] . "' >Download</button>";
                                                            } else {
                                                                echo "<button type='button' class='btn btn-success' disabled>Documents</button>";
                                                            }
                                                            echo "</td>";
                                                            echo "<td>";


                                                            $k = $row["status"];
                                                            $status = $statusOptions[$row["status"]] ?? "Unknown status";


                                                            if ($row['status'] == 3) {
                                                                // echo "<td>";
                                                                echo "<div class='d-flex'><button class='btn btn-success btn-icon mr-2 claimapproveBtn'  data-id='" . $row["s_no"] . "'aria-label='Correct' title='Claim Required' data-bs-toggle='tooltip'>
                                                                                        <i class='fas fa-check'></i>
                                                                                    </button>
                                                                                    <button class='btn btn-danger btn-icon claimrejectBtn'  data-id='" . $row["s_no"] . " 'aria-label='Wrong' title='Claim Not Required' data-bs-toggle='tooltip'>
                                                                                        <i class='fas fa-times'></i>
                                                                                    </button>
                                                                                </div>
                                                                            ";
                                                                //  echo "</td>";
                                                            } else {
                                                                if (in_array($row["status"], [8, 9, 10, 11, 12, 13])) {
                                                                    echo "
                                                                                <button type='button' class='btn btn-danger viewFeedback2' data-feedback='" . htmlspecialchars($row["feedback"]) . "'>" . $status . "</button>";
                                                                } else if ($row['status'] == 14 || $row['status'] == 15) {

                                                                    echo "
                                                                                <button type='button' class='btn btn-danger' >" . $status . "</button>";
                                                                } else {
                                                                    echo "
                                                                                <button type='button' class='btn btn-success' >" . $status . "</button>";
                                                                }
                                                            }




                                                            echo "</td>";






                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                        echo "<tr>No data available</tr>";
                                                    }

                                                    ?>

                                                    <!-- Modal for Event Brochure or Feedback -->



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
<?php include 'event_tabs_model.php';?>
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
        /* get only current and previous month enable for date fields
    // Get the current date
    const today = new Date();

    // Get the year and month for the current month
    const currentYear = today.getFullYear();
    const currentMonth = String(today.getMonth() + 1).padStart(2, '0');

    // Get the year and month for the previous month
    const previousMonthDate = new Date(today.setMonth(today.getMonth() - 1));
    const previousYear = previousMonthDate.getFullYear();
    const previousMonth = String(previousMonthDate.getMonth() + 1).padStart(2, '0');

    // Set the min and max values for the input
    const monthYearInput = document.getElementById('month_year');
    monthYearInput.min = `${previousYear}-${previousMonth}`;
    monthYearInput.max = `${currentYear}-${currentMonth}`;
        */
    </script>
    <script>
        function fileValidation(inputElement) {
            const file = inputElement.files[0];
            const fileSizeLimit = 2 * 1024 * 1024; // 2 MB in bytes
            const labelElement = inputElement.nextElementSibling;
            const errorElement = inputElement.parentElement.nextElementSibling;
            if (file) {
                const fileType = file.type;
                // Check if the file is a PDF
                if (fileType !== 'application/pdf') {
                    errorElement.textContent = 'Only PDF files are allowed';
                    labelElement.textContent = 'Choose file';
                    inputElement.value = ""; // Clear the input
                    return;
                }
                // Check file size
                if (file.size > fileSizeLimit) {
                    errorElement.textContent = 'File size exceeds 2 MB';
                    labelElement.textContent = 'Choose file';
                    inputElement.value = ""; // Clear the input
                } else {
                    errorElement.textContent = '';
                    labelElement.textContent = file.name; // Display the file name
                }
            }
        }





        $(document).ready(function() {
            $(function() {
                $('[data-bs-toggle="tooltip"]').tooltip();
            });

            $('#event_Table').DataTable({
                "order": [] // No initial sorting
            });
            $('#event_completed_Table').DataTable();

            document.getElementById('claim_form_status').addEventListener('change', function() {
                const claim_form_field = document.querySelector('.claim_form_field');


                if (this.checked) {
                    claim_form_field.style.display = 'block';

                } else {
                    claim_form_field.style.display = 'none';

                }
            });


            const startYear = 2024;
            const currentYear = new Date().getFullYear();
            const endYear = currentYear + 5; // Add 5 more years
            const academiaYearSelect = $('#academic_year');

            for (let year = startYear; year <= endYear; year++) {
                let academicYear = `${year}-${year + 1}`;
                academiaYearSelect.append(new Option(academicYear, academicYear));
            }



            const today = new Date().toISOString().split('T')[0];
            $('#start_date').attr('min', today);
            $('#end_date').attr('min', today);

            // Enable End date of Event field after selecting Start date of Event
            $('#start_date').on('change', function() {
                const startDate = $(this).val();
                if (startDate) {
                    $('#end_date').attr('min', startDate);
                    $('#end_date').prop('disabled', false);
                } else {
                    $('#end_date').prop('disabled', true);
                }
            });

            // Calculate total days when dates are selected
            $('#start_date, #end_date').on('change', function() {
                const fromDate = new Date($('#start_date').val());
                const toDate = new Date($('#end_date').val());

                if (fromDate && toDate && fromDate <= toDate) {
                    const timeDifference = toDate.getTime() - fromDate.getTime();
                    const dayDifference = Math.ceil(timeDifference / (1000 * 3600 * 24)) +
                        1; // Add 1 to include both start and end date
                    $('#no_of_days').val(dayDifference);
                } else {
                    $('#no_of_days').val('Invalid date range');
                }
            });



            function calculateBalance() {
                var advanceAmount = parseFloat($("#advance_amount").val()) || 0;
                var eventAmount = parseFloat($("input[name='event_amount']").val()) || 0;

                // Calculate the total of the `amount[]` fields
                var expenseTotal = 0;
                $("input[name='amount[]']").each(function() {
                    expenseTotal += parseFloat($(this).val()) || 0;
                });

                // Calculate the total amount spent by adding eventAmount and expenseTotal
                var amountSpent = eventAmount + expenseTotal;
                $("#amount_spent").val(amountSpent);
                var balanceAmount = Math.abs(advanceAmount - amountSpent); // Use Math.abs() to remove minus sign
                $("#balance_amount").val(balanceAmount);
            }

            // Trigger calculation when advance_amount or amount_spent changes
            $("#advance_amount, input[name='event_amount'], input[name='amount[]']").on('input', function() {
                calculateBalance();
            });


            $(document).on('click', '.claimapproveBtn, .claimrejectBtn', function() {
                var applicantId = $(this).data('id');
                var action = $(this).hasClass('claimapproveBtn') ? 'required' : 'not required';

                if (action === 'required') {
                    // Confirmation for approval
                    Swal.fire({
                        title: 'Confirm Approval',
                        text: "Are you applying Claim for this event",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, approve it!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'approve.php',
                                method: 'POST',
                                data: {
                                    id: applicantId,
                                    action: action,
                                    page: 'staff',
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.status === 'success') {
                                        Swal.fire({
                                                icon: 'success',
                                                title: 'Approved',
                                                text: res.message
                                            })
                                            .then(() => {
                                                location.reload();
                                            });
                                        //$('#pre_event_Table').load(location.href + "#pre_event_Table");
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
                                        text: 'An error occurred while processing your request: ' +
                                            error
                                    });
                                }
                            });
                        }
                    });
                } else if (action === 'not required') {
                    // Input for rejection reason
                    Swal.fire({
                        title: 'Remove Claim',
                        text: "Please provide a reason for rejection:",
                        icon: 'warning',
                        input: 'textarea',
                        inputPlaceholder: 'Enter your reason here...',
                        showCancelButton: true,
                        confirmButtonText: 'Remove',
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
                                    page: 'staff'
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.status === 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Removed Claim process',
                                            text: res.message
                                        }).then(() => {
                                            location.reload();
                                        });


                                    } else {
                                        Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: res.message
                                            })
                                            .then(() => {
                                                location.reload();
                                            });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Request Failed',
                                        text: 'An error occurred while processing your request: ' +
                                            error
                                    });
                                }
                            });
                        }
                    });
                }
            });




            $(document).on('click', '.approvedClaimBtn, .deleteClaimBtn, .editClaimBtn', function() {
                var applicantId = $(this).data('id');


                var action;

                if ($(this).hasClass('approvedClaimBtn')) {
                    action = "approvedClaim";
                } else if ($(this).hasClass('deleteClaimBtn')) {
                    action = "deleteClaim";
                } else if ($(this).hasClass('editClaimBtn')) {
                    action = "editClaim";
                }

                if (action === 'approvedClaim') {
                    // Confirmation for approval
                    Swal.fire({
                        title: 'Confirm Approval',
                        text: "Are you completed the claim process Manualy",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Completed!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'approve.php',
                                method: 'POST',
                                data: {
                                    id: applicantId,
                                    action: action,
                                    page: 'staff',
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.status === 'success') {
                                        Swal.fire({
                                                icon: 'success',
                                                title: 'Approved',
                                                text: res.message
                                            })
                                            .then(() => {
                                                location.reload();
                                            });
                                        //$('#pre_event_Table').load(location.href + "#pre_event_Table");
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
                                        text: 'An error occurred while processing your request: ' +
                                            error
                                    });
                                }
                            });
                        }
                    });
                } else if (action === 'deleteClaim') {
                    // Input for rejection reason
                    Swal.fire({
                        title: 'Remove Claim',
                        text: "Please provide a reason for rejection:",
                        icon: 'warning',
                        input: 'textarea',
                        inputPlaceholder: 'Enter your reason here...',
                        showCancelButton: true,
                        confirmButtonText: 'Remove',
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
                                    page: 'staff'
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.status === 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Removed Claim process',
                                            text: res.message
                                        }).then(() => {
                                            location.reload();
                                        });


                                    } else {
                                        Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: res.message
                                            })
                                            .then(() => {
                                                location.reload();
                                            });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Request Failed',
                                        text: 'An error occurred while processing your request: ' +
                                            error
                                    });
                                }
                            });
                        }
                    });
                } else if (action === 'editClaim') {
                    // Confirmation for approval
                    Swal.fire({
                        title: 'Confirm Approval',
                        text: "Are you sure want to edit the claim form",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, allow it',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'approve.php',
                                method: 'POST',
                                data: {
                                    id: applicantId,
                                    action: action,
                                    page: 'staff',
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.status === 'success') {
                                        Swal.fire({
                                                icon: 'success',
                                                title: 'Approved',
                                                text: res.message
                                            })
                                            .then(() => {
                                                location.reload();
                                            });
                                        //$('#pre_event_Table').load(location.href + "#pre_event_Table");
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
                                        text: 'An error occurred while processing your request: ' +
                                            error
                                    });
                                }
                            });
                        }
                    });
                }
            });



            // handle pre_event form in model
            $('#add_preEvent_parti_form').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'eventparti_pre_submit.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Event Applied successfully!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#add_preEvent_parti_form')[0].reset();
                                    $('#add_preEvent_parti').modal('hide');
                                    location.reload();

                                }
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'warning',
                                text: 'Event Already added ' + error
                            });

                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Form submission failed: ' + error
                        });
                    }
                });




            });
            // handle post_event form in model
            $('#add_postEvent_parti_form').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'eventparti_post_submit.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Post Event Applied successfully!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#post_event_form')[0].reset();
                                    $('#add_postEvent_parti').modal('hide');
                                    location.reload();

                                }
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'warning',
                                text: 'Event Already added ' + error
                            });

                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Form submission failed: ' + error
                        });
                    }
                });




            });




            // handle claim_form in model
            $('#claim_form_new').submit(function(event) {

                event.preventDefault();

                var formData = new FormData(this);
                $.ajax({
                    url: 'claim_submit1.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Claim form Applied',
                                text: 'Please download the claim form !'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#claim_form_new')[0].reset();
                                    $('#expense_claim_form').modal('hide');
                                    location.reload();

                                }
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'warning',
                                text: 'Claim Already Applied ' + error
                            });

                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Form submission failed: ' + error
                        });
                    }
                });




            });


            let expenseType = $("#expenseType");

            // Function to update table headers based on the expense type




            // Add new row on '+' button click
            $("#addRow").click(function() {
                let type = $('#expenseType').val();

                var tableBody = document.querySelector('#expenseTable tbody');
                var newRow = document.createElement('tr');




                // Generate the row HTML based on the selected expense type
                if (type === "Travel") {
                    newRow.innerHTML = `<td><input type="date" name="date[]"  class="form-control">
       
                        <input type="hidden" name="type[]"  value='Travel'class="form-control">
                        </td>
                        <td><input type="text" name="bill_no[]"  class="form-control"></td>
                        <td><input type="text" name="description[]"  class="form-control"placeholder="Mode of Travel"></td>
                        <td><input type="number" name="amount[]"  class="form-control"></td>
                        <td><button type="button" class="removeRow form-control" >-</button></td>`;
                } else if (type === "Food") {
                    newRow.innerHTML = `<td><input type="date" name="date[]"  class="form-control">
                        <input type="hidden" name="type[]"  value='` + type + `'class="form-control">
                        </td>
                        <td><input type="text" name="bill_no[]"  class="form-control"></td>
                        <td><input type="text" name="description[]" placeholder="Food Description"  class="form-control"></td>
                        <td><input type="number" name="amount[]"  class="form-control"></td>
                        <td><button type="button" class="removeRow form-control" >-</button></td>`;
                } else if (type === "Others") {
                    newRow.innerHTML = `<td><input type="date" name="date[]"  class="form-control">
                        <input type="hidden" name="type[]"  value='` + type + `'class="form-control">
                        </td>
                        <td><input type="text" name="bill_no[]"  class="form-control"></td>
                        <td><input type="text" name="description[]" placeholder="Others Description"  class="form-control"></td>
                        <td><input type="number" name="amount[]"  class="form-control"></td>
                        <td><button type="button" class="removeRow form-control" >-</button></td>
                         `;
                }


                // Append the new row to the table
                tableBody.appendChild(newRow);
            });




            // Remove row on '-' button click
            $(document).on("click", ".removeRow", function() {
                $(this).closest("tr").remove();
            });









            // handle buttons in event tab(1st tab) 
            $(document).on('click', '.uploadDocuments', function() {
                var id = $(this).data('id');

                $('#id').val(id);

            });
            $(document).on('click', '.viewBrochure', function() {
                var brochureUrl = $(this).data('event-brochure');

                $('#viewPdfModalLabel').text('Event Brochure');
                $('#viewPdfModalBody').html('<iframe src="' + brochureUrl +
                    '" frameborder="0" style="width:100%; height:500px;"></iframe>');
                $('#viewPdfModal').modal('show');
            });

            // Feedback Button Click
            $(document).on('click', '.viewFeedback', function() {
                var feedback = $(this).data('feedback');

                $('#viewPdfModalLabel').text('Feedback');
                $('viewPdfModalBody').html('<input type="text" class="form-control" value="' + feedback +
                    '" readonly>');
                $('#viewPdfModal').modal('show');
            });
            $(document).on('click', '.downloadDocuments', function() {
                var downloadDocumentsUrl = $(this).data('download');

                $('#viewPdfModalLabel').text('Download Documents');
                $('#viewPdfModalBody').html('<iframe src="' + downloadDocumentsUrl +
                    '" frameborder="0" style="width:100%; height:500px;"></iframe>');
                $('#viewPdfModal').modal('show');
            });

            // handle buttons in completed event tab(2nd tab) 
            $(document).on('click', '.viewBrochure1', function() {
                var brochureUrl = $(this).data('event-brochure');

                $('#viewPdfModalLabel').text('Event Brochure');
                $('#viewPdfModalBody').html('<iframe src="' + brochureUrl +
                    '" frameborder="0" style="width:100%; height:500px;"></iframe>');
                $('#viewPdfModal').modal('show');
            });
            $(document).on('click', '.downloadDocuments1', function() {
                var downloadDocumentsUrl = $(this).data('download');

                $('#viewPdfModalLabel').text('Download Documents');
                $('#viewPdfModalBody').html('<iframe src="' + downloadDocumentsUrl +
                    '" frameborder="0" style="width:100%; height:500px;"></iframe>');
                $('#viewPdfModal').modal('show');
            });


            // handle buttons in claim event tab(3rd tab) 
            $(document).on('click', '.viewBrochure2', function() {
                var brochureUrl = $(this).data('event-brochure');

                $('#viewPdfModalLabel').text('Event Brochure');
                $('#viewPdfModalBody').html('<iframe src="' + brochureUrl +
                    '" frameborder="0" style="width:100%; height:500px;"></iframe>');
                $('#viewPdfModal').modal('show');
            });
            $(document).on('click', '.downloadDocuments2', function() {
                var downloadDocumentsUrl = $(this).data('download');

                $('#viewPdfModalLabel').text('Download Documents');
                $('#viewPdfModalBody').html('<iframe src="' + downloadDocumentsUrl +
                    '" frameborder="0" style="width:100%; height:500px;"></iframe>');
                $('#dviewPdfModal').modal('show');
            });
            $(document).on('click', '.viewFeedback2', function() {
                var feedback = $(this).data('feedback');

                $('#viewPdfModal').text('Feedback');
                $('#viewPdfModal').html('<input type="text" class="form-control" value="' + feedback +
                    '" readonly>');
                $('#viewPdfModal').modal('show');
            });



            $(document).on('click', '.printBtn', function() {
                var applicantId = $(this).data('id');
                // Open print.php in a new tab with the applicant ID as a query parameter
                window.open('print.php?id=' + applicantId, '_blank');
            });

            $(document).on('click', '.printBtn1', function() {
                var applicantId = $(this).data('id');
                // Open print.php in a new tab with the applicant ID as a query parameter
                window.open('print_claim2.php?id=' + applicantId, '_blank');
            });


            $(document).on('click', '.uploadDocuments2', function() {
                var id = $(this).data('id');

                $('#id').val(id);
                $('#id1').val(id);


            });

            $('#expense_claim_form').on('shown.bs.modal', function() {

                var id = $('#id1').val();

                $.ajax({
                    url: 'get_expense_data.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            // Assign the values to modal input fields 
                            $('#claim_event_name').val(data.event_name);
                            $('#claim_event_date').val(data.start_date);

                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + error);
                    }
                });
            })



        });


        // organisation js



        document.addEventListener("DOMContentLoaded", function() {
            const selectElement = document.getElementById('AcademiaYear');
            const currentYear = new Date().getFullYear();
            const startYear = 2018; // You can change this to the first year you want to include
            const endYear = currentYear + 4; // Including future years if needed
            for (let year = startYear; year <= endYear; year++) {
                const option = document.createElement('option');
                option.value = `${year}-${year + 1}`;
                option.textContent = `${year}-${year + 1}`;
                selectElement.appendChild(option);
            }
            const today = new Date().toISOString().split('T')[0];
            // Set the minimum date for "Start of Event" and "End of Event" to today's date
            document.getElementById('fromDate').setAttribute('min', today);
            document.getElementById('toDate').setAttribute('min', today);
            // Enable "End of Event" field after selecting "Start of Event"
            document.getElementById('fromDate').addEventListener('change', function() {
                const startDate = this.value;
                const toDate = document.getElementById('toDate');
                if (startDate) {
                    toDate.setAttribute('min', startDate);
                    toDate.disabled = false;
                } else {
                    toDate.disabled = true;
                }
            });
            // Calculate total days when dates are selected
            document.getElementById('fromDate').addEventListener('change', calculateDays);
            document.getElementById('toDate').addEventListener('change', calculateDays);

            function calculateDays() {
                const fromDate = new Date(document.getElementById('fromDate').value);
                const toDate = new Date(document.getElementById('toDate').value);
                const countElement = document.getElementById('count');

                if (fromDate && toDate && fromDate <= toDate) {
                    const timeDifference = toDate.getTime() - fromDate.getTime();
                    const dayDifference = Math.ceil(timeDifference / (1000 * 3600 * 24)) +
                        1; // Include both start and end dates
                    countElement.value = dayDifference;
                } else {
                    countElement.value = 'Invalid date range';
                }
            }
            document.getElementById('fundSwitch').addEventListener('change', function() {
                const fundAmountGroup = document.querySelector('.fund-amount-group');
                if (this.checked) {
                    fundAmountGroup.style.display = 'block';
                } else {
                    fundAmountGroup.style.display = 'none';
                }
            });
        });
        $(document).ready(function() {
            $('#eventSelect').change(function() {
                if ($(this).val() === 'Other') {
                    $('#otherEventInput').show(); // Show input field if 'Other' is selected
                } else {
                    $('#otherEventInput').hide(); // Hide input field for other options
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#preEventOrg_table').DataTable();
            $('#org_completed_table').DataTable();
        });
        $(document).on('submit', '#preEventOrg_Form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("save_preEventOrg_Form", true);
            console.log(formData)
            $.ajax({
                type: "POST",
                url: "evento_backend.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    console.log(res)
                    if (res.status == 200) {
                        $('#preEventOrg_Model').modal('hide');
                        $('#preEventOrg_Form')[0].reset();
                        //    $('#user').DataTable().ajax.reload();
                        $('#preEventOrg_table').load(location.href + " #preEventOrg_table");
                        Swal.fire({
                            title: 'Success',
                            text: 'Event Applied successfully',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else if (res.status == 500) {
                        $('#preEventOrg_Model').modal('hide');
                        $('#preEventOrg_Form')[0].reset();
                        console.error("Error:", res.message);
                        alert("Something Went wrong.! try again")
                    }
                }
            });
        });
        $(document).on('click', '#openguest', function() {
            var Chiefguest = $(this).data('pdf');
            $('#viewPdfModalLabel').text('Guest Details');
            $('#viewPdfModalBody').html('<iframe src="' + Chiefguest +
                ' "frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#viewPdfModal').modal('show');
        });


        $(document).on('click', '#fund', function() {
            var fund = $(this).data('pdf'); // Retrieve the PDF file URL from the data attribute

            if (fund) { // Check if the PDF URL is provided
                // Update the modal title
                $('#viewPdfModalLabel').text('Fund Details');

                // Embed the PDF in the modal's body using an iframe
                $('#viewPdfModalBody').html('<iframe src="' + fund +
                    '" frameborder="0" style="width:100%; height:500px;"></iframe>');

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
            $('#viewPdfModalLabel').text('Event Brochure'); // Update label if needed
            $('#viewPdfModalBody').html('<iframe src="' + brochures +
                '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#viewPdfModal').modal('show');
        });

        $(document).on('click', '.downloadDocuments', function() {
            var documents = $(this).data('download'); // Changed to data-download
            $('#viewPdfModalLabel6').text('Documents');
            $('#dynamicModalBody6').html('<iframe src="' + documents +
                '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#viewPdfModal6').modal('show');
        });

        $(document).on('click', '.printBtn', function() {
            var applicantId = $(this).data('id');
            // Open print.php in a new tab with the applicant ID as a query parameter
            window.open('print.php?id=' + applicantId, '_blank');
        });
        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
        $(document).on('click', '.viewFeedback', function() {
            var feedback = $(this).data('feedback');

            $('#viewPdfModalLabel').text('Feedback');
            $('#viewPdfModalBody').html('<input type="text" class="form-control" value="' + feedback + '" readonly>');
            $('#viewPdfModal').modal('show');
        });

        // Function to convert all table data to PDF using autoTable
        function convertTablesToPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            // Weakness data
            const weaknessIdentified = document.getElementById("weaknessIdentified").value;
            const weaknessRecommendations = document.getElementById("weaknessRecommendations").value;

            // Challenges data
            const challengesIdentified = document.getElementById("challengesIdentified").value;
            const challengesRecommendations = document.getElementById("challengeRecommendations").value;

            // Opportunities data
            const opportunitiesIdentified = document.getElementById("opportunitiesIdentified").value;
            const opportunitiesRecommendations = document.getElementById("opportunityRecommendations").value;

            // Generate PDF
            doc.text("Feedback Report", 14, 10);
            doc.autoTable({
                head: [
                    ["Weakness Identified", "Recommendations"]
                ],
                body: [
                    [weaknessIdentified, weaknessRecommendations]
                ],
                margin: {
                    top: 20
                },
                styles: {
                    halign: 'center',
                    valign: 'middle',
                    cellPadding: 3
                },
            });
            doc.autoTable({
                head: [
                    ["Challenges Identified", "Recommendations"]
                ],
                body: [
                    [challengesIdentified, challengesRecommendations]
                ],
                margin: {
                    top: 20
                },
                styles: {
                    halign: 'center',
                    valign: 'middle',
                    cellPadding: 3
                },
            });
            doc.autoTable({
                head: [
                    ["Opportunities Identified", "Recommendations"]
                ],
                body: [
                    [opportunitiesIdentified, opportunitiesRecommendations]
                ],
                margin: {
                    top: 20
                },
                styles: {
                    halign: 'center',
                    valign: 'middle',
                    cellPadding: 3
                },
            });

            // Save the PDF
            //doc.save("feedback_report.pdf");
            return doc.output('blob');
        }
        $('#PostEventDetailsForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var pdfBlob = convertTablesToPDF(); // Call the function to generate PDF
            formData.append('pdf[]', pdfBlob, "feedback_report.pdf"); // Append the blob with a filename
            $.ajax({
                url: 'post.php',
                type: 'POST',
                data: formData, // Pass formData directly
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting contentType
                success: function(res) {
                    // Handle response
                    if (res.success) {
                        // SweetAlert for success
                        Swal.fire({
                            title: 'Success!',
                            text: 'Post Event Form Submited Successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = res
                                    .download_link; // Redirect or open the merged PDF
                            }
                        });
                    } else {
                        // SweetAlert for error
                        Swal.fire({
                            title: 'Error!',
                            text: res.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function() {
                    // SweetAlert for AJAX error
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while processing your request.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
        $(document).on('click', '.uploadDocuments', function() {
            var id = $(this).data('id');
            $('#id').val(id);

        });
    </script>


</body>

</html>