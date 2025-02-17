<?php
require "config.php";
include ("session.php");
$worker_id = $s;


// fetching worker details using department in session
$qry = "SELECT * FROM worker_details WHERE worker_id='$worker_id'";
$qry_run = mysqli_query($db, $qry);
$srow  = mysqli_fetch_array($qry_run);
$dept = $srow['worker_dept'];


$qry = "SELECT * FROM worker_details WHERE worker_id='$worker_id'";
$qry_run = mysqli_query($db, $qry);
$row  = mysqli_fetch_array($qry_run);

//New task query
$sql = "
    SELECT 
        cd.id,
        cd.faculty_id,
        faculty.name,
        faculty.dept,
        cd.block_venue,
        cd.venue_name,
        cd.type_of_problem,
        cd.problem_description,
        cd.images,
        cd.date_of_reg,
        cd.days_to_complete,
        cd.task_completion,
        cd.status,
        cd.feedback,
        m.task_id,
        m.priority
    FROM 
        complaints_detail AS cd
    JOIN 
        manager AS m ON cd.id = m.problem_id
    JOIN 
        faculty ON cd.faculty_id = faculty.id
    WHERE 
        (m.worker_dept='$dept')
    AND 
        cd.status = '9'
";

$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$newcount = mysqli_num_rows($result);


//inprogress query
$sql1 = "
    SELECT 
        cd.id,
        cd.faculty_id,
        faculty.name,
        faculty.dept,
        cd.block_venue,
        cd.venue_name,
        cd.type_of_problem,
        cd.problem_description,
        cd.images,
        cd.date_of_reg,
        cd.days_to_complete,
        cd.task_completion,
        cd.status,
        cd.feedback,
        m.task_id,
        m.priority
    FROM 
        complaints_detail AS cd
    JOIN 
        manager AS m ON cd.id = m.problem_id
    JOIN 
        faculty ON cd.faculty_id = faculty.id
    WHERE 
        (m.worker_dept='$dept')
    AND 
        cd.status = '10'
";

$stmt = $db->prepare($sql1);
$stmt->execute();
$result1 = $stmt->get_result();
$progcount = mysqli_num_rows($result1);


//waiting for approval query
$sql2 = "
    SELECT 
        cd.id,
        cd.faculty_id,
        faculty.name,
        faculty.dept,
        cd.block_venue,
        cd.venue_name,
        cd.type_of_problem,
        cd.problem_description,
        cd.images,
        cd.date_of_reg,
        cd.days_to_complete,
        cd.task_completion,
        cd.status,
        cd.feedback,
        m.task_id,
        m.priority
    FROM 
        complaints_detail AS cd
    JOIN 
        manager AS m ON cd.id = m.problem_id
    JOIN 
        faculty ON cd.faculty_id = faculty.id
    WHERE 
        (m.worker_dept='$dept')
    AND 
        (cd.status = '11' OR cd.status = '18')
";

$stmt = $db->prepare($sql2);
$stmt->execute();
$result2 = $stmt->get_result();
$waitcount = mysqli_num_rows($result2);


//completed query
$sql3 = "
    SELECT 
        cd.id,
        cd.faculty_id,
        faculty.name,
        faculty.dept,
        cd.block_venue,
        cd.venue_name,
        cd.type_of_problem,
        cd.problem_description,
        cd.images,
        cd.date_of_reg,
        cd.days_to_complete,
        cd.task_completion,
        cd.status,
        cd.feedback,
        m.task_id,
        m.priority
    FROM 
        complaints_detail AS cd
    JOIN 
        manager AS m ON cd.id = m.problem_id
    JOIN 
        faculty ON cd.faculty_id = faculty.id
    WHERE 
        (m.worker_dept='$dept')
    AND 
        cd.status = '16'
";

$stmt = $db->prepare($sql3);
$stmt->execute();
$result3 = $stmt->get_result();
$compcount = mysqli_num_rows($result3);


//not approved query
$sql4 = "
    SELECT 
        cd.id,
        cd.faculty_id,
        faculty.name,
        faculty.dept,
        cd.block_venue,
        cd.venue_name,
        cd.type_of_problem,
        cd.problem_description,
        cd.images,
        cd.date_of_reg,
        cd.days_to_complete,
        cd.task_completion,
        cd.status,
        cd.feedback,
        m.task_id,
        m.priority
    FROM 
        complaints_detail AS cd
    JOIN 
        manager AS m ON cd.id = m.problem_id
    JOIN 
        faculty ON cd.faculty_id = faculty.id
    WHERE 
        (m.worker_dept='$dept')
    AND 
        cd.status = '15'
";


$stmt = $db->prepare($sql4);
$stmt->execute();
$result4 = $stmt->get_result();
$notcount = mysqli_num_rows($result4);

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
    <link rel="stylesheet" href="dboardstyles.css">


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
    <?php include 'wsidebar.php'; ?>

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
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $worker_id; ?></li>
                </ol>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-hover">
                            <div class="box bg-danger text-center">
                                <h1 class="font-light text-white"><i class="fas fa-user"></i></h1>
                                <h3 class="text-white"><b> Name <br></b></h3>
                                <h5 class="text-white" id="workerName"><?php echo $row['worker_first_name'] ?></h5>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-hover">
                            <div class="box bg-success text-center">
                                <h1 class="font-light text-white"><i class="fa-solid fa-building-user"></i></h1>
                                <h3 class="text-white"><b>Worker Department<br></b></h3>
                                <h5 class="text-white" id="employmentType"><?php echo $row['worker_dept'] ?></h5>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-hover">
                            <div class="box bg-warning text-center">
                                <h1 class="font-light text-white"><i class="fa-solid fa-briefcase   "></i></h1>
                                <h3 class="text-white"><b>Designation<br></b></h3>
                                <h5 id="workerdepartment" class="text-white">Worker-Head</h5>


                            </div>
                        </div>
                    </div>
                </div><br>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title m-b-0"></h4><br>
                        <div class="row">
                            <div class="col-12 col-md-3 mb-3">
                                <div class="cir">
                                    <div class="bo">
                                        <div class="content1">
                                            <div class="stats-box text-center p-3"
                                                style="background-color:rgb(252, 119, 71);">
                                                <i class="fas fa-bell m-b-5 font-20"></i>
                                                <h1 class="m-b-0 m-t-5"><?php echo $compcount ?></h1>
                                                <small class="font-light">Task Completed</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <div class="cir">
                                    <div class="bo">
                                        <div class="content1">
                                            <div class="stats-box text-center p-3"
                                                style="background-color:rgb(241, 74, 74);">
                                                <i class="fas fa-exclamation m-b-5 font-16"></i>
                                                <h1 class="m-b-0 m-t-5"><?php echo $newcount ?></h1>
                                                <small class="font-light">New Tasks</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <div class="cir">
                                    <div class="bo">
                                        <div class="content1">
                                            <div class="stats-box text-center p-3"
                                                style="background-color:rgb(70, 160, 70);">
                                                <i class="fas fa-check m-b-5 font-20"></i>
                                                <h1 class="m-b-0 m-t-5"><?php echo $progcount; ?></h1>
                                                <small class="font-light">Task in progress</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <div class="cir">
                                    <div class="bo">
                                        <div class="content1">
                                            <div class="stats-box text-center p-3"
                                                style="background-color: rgb(187, 187, 35);">
                                                <i class="fas fa-redo m-b-5 font-20"></i>
                                                <h1 class="m-b-0 m-t-5"><?php echo $waitcount ?></h1>
                                                <small class="font-light">Tasks waiting for approval</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Before Image Modal Starts -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabels" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Complaint Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Image" class="img-fluid">
                    <!-- src will be set dynamically -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Before Image Model Ends -->

     <!-- View Complaint Modal Starts -->
     <div class="modal fade" id="complaintDetailsModal" tabindex="-1" role="dialog"
        aria-labelledby="complaintDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="complaintDetailsModalLabels">
                        📋 Complaint Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <!-- Modal Body with reduced padding -->
                <div class="modal-body" style="padding: 15px; font-size: 1.1em; color: #333; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

                    <!-- Complaint Info Section with minimized spacing -->
                    <ul class="list-group " style="margin-bottom: 0;">
                                               
                                                <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Faculty Name</div>
                                                        <b><span id="faculty_name" style="color: #555;"></span></b>
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Mobile Number</div>
                                                        <b><span id="faculty_contact" style="color: #555;"></span></b>
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">E-mail</div>
                                                        <b><span id="faculty_mail" style="color: #555;"></span></b>
                                                    </div>
                                                </li>

                                                <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Type of Problem</div>
                                                        <b><span id="type_of_problem" style="color: #555;"></span></b>
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Problem Description</div>
                                                        <div class="alert alert-light" role="alert" style="border-radius: 6px; background-color: #f1f1f1; padding: 15px; color: #333;">
                                                            <b><span id="problem_description"></span></b>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                </div>

                <!-- Modal Footer with Save Button -->
                <div class="modal-footer" style="border-top: none; justify-content: center; padding: 10px;">
                    <button type="button" class="btn btn-primary btn-lg" data-bs-dismiss="modal" style="border-radius: 25px; padding: 10px 30px; font-size: 1.1em; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- View Complaint Modal Ends -->

        <!-- Footer -->
        <?php include 'footer.php'; ?>
    </div>




    <script src="script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    


</body>

</html>