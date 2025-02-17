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
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Research</li>
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

                <ul class="nav nav-tabs" role="tablist"> <!-- Center the main tabs -->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" id="edit-bus-tab" href="#publication" role="tab" aria-selected="true">
                            <span class="hidden-xs-down tab-header"><i class="fas fa-book tab-icon"></i> Publication </span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#main_patent" role="tab" aria-selected="false">
                            <span class="hidden-xs-down tab-header"><i class="fas fa-clipboard tab-icon"></i> Patent </span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#main_project" role="tab" aria-selected="false">
                            <span class="hidden-xs-down tab-header"><i class="fas fa-clipboard tab-icon"></i> Project </span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#main_consultancy" role="tab" aria-selected="false">
                            <span class="hidden-xs-down  tab-header"><i class="fas fa-briefcase mr-2 tab-icon"></i> Consultancy </span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#activity" role="tab" aria-selected="false">
                            <span class="hidden-xs-down  tab-header"><i class="fas fa-tasks tab-icon"></i> Activity </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#course_certificate" role="tab" aria-selected="false">
                            <span class="hidden-xs-down  tab-header"><i class="fas fa-graduation-cap tab-icon"></i>
                                Course Certification </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#report" role="tab" aria-selected="false">
                            <span class="hidden-xs-down"><i class="fas fa-file-alt tab-icon"></i>
                                Report </span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">

                    <div class="tab-pane fade show active" id="publication" role="tabpanel">
                        <!-- <div class="card"> -->
                        <!-- Nested Tabs for Publication -->
                        <ul class="nav navs-tabs justify-content-center mb-3">
                            <li class="nav-item" style="margin-right: 10px;"> <!-- Add margin between tabs -->
                                <a class="nav-link active tab-header" id="add-bus-tab" data-bs-toggle="tab" href="#journal" role="tab" aria-selected="true">
                                    Journal
                                </a>
                            </li>
                            <li class="nav-item "> <!-- Add margin between tabs -->
                                <a class="nav-link tab-header" id="add-bus-tab" data-bs-toggle="tab" href="#conference" role="tab" aria-selected="false">
                                    Conference
                                </a>
                            </li>
                            <li class="nav-item "> <!-- Add margin between tabs -->
                                <a class="nav-link tab-header" id="add-bus-tab" data-bs-toggle="tab" href="#book" role="tab" aria-selected="false">
                                    Book
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane p-20 active" id="journal" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">


                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="journal_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane p-20" id="conference" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">


                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="conference_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>




                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane p-20" id="book" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">


                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="book_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>




                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Patent Tab -->
                    <div class="tab-pane" id="main_patent" role="tabpanel">
                        <ul class="nav navs-tabs  justify-content-center" role="tablist">
                            <li class="nav-item" role="presentation" style="margin-right: 15px;"> <!-- Add margin between tabs -->
                                <a class="nav-link active" id="add-bus-tab" data-bs-toggle="tab" href="#patents" role="tab" aria-selected="true">
                                    <span class="hidden-xs-down tab-header"> Patent </span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation"> <!-- Add margin between tabs -->
                                <a class="nav-link" id="add-bus-tab" data-bs-toggle="tab" href="#copyrights" role="tab" aria-selected="false">
                                    <span class="hidden-xs-down tab-header"> Copyrights </span>
                                </a>
                            </li>
                        </ul>

                        <!-- Patent Tab -->
                        <div class="tab-content">

                            <div class="tab-pane p-20 active" id="patents" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="patent_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane p-20" id="copyrights" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="copyright_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       
                                                    </tbody>
                                                </table>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="main_project" role="tabpanel">
                        <ul class="nav navs-tabs  justify-content-center" role="tablist">
                            <li class="nav-item" role="presentation" style="margin-right: 15px;"> <!-- Add margin between tabs -->
                                <a class="nav-link active" id="add-bus-tab" data-bs-toggle="tab" href="#project" role="tab" aria-selected="true">
                                    <span class="hidden-xs-down tab-header"> Project </span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation"> <!-- Add margin between tabs -->
                                <a class="nav-link" id="add-bus-tab" data-bs-toggle="tab" href="#project_guidance" role="tab" aria-selected="false">
                                    <span class="hidden-xs-down tab-header"> Project Guidance </span>
                                </a>
                            </li>
                        </ul>

                        <!-- Patent Tab -->
                        <div class="tab-content">

                            <div class="tab-pane p-20 active" id="project" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="project_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane p-20" id="project_guidance" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="project_guidance_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       
                                                    </tbody>
                                                </table>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Consultancy Tab -->
                    <div class="tab-pane" id="main_consultancy" role="tabpanel">
                        <ul class="nav navs-tabs  justify-content-center" role="tablist">
                            <li class="nav-item" role="presentation" style="margin-right: 15px;"> <!-- Add margin between tabs -->
                                <a class="nav-link active" id="add-bus-tab" data-bs-toggle="tab" href="#consultancy" role="tab" aria-selected="true">
                                    <span class="hidden-xs-down tab-header"> Consultancy </span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation"> <!-- Add margin between tabs -->
                                <a class="nav-link" id="add-bus-tab" data-bs-toggle="tab" href="#industry_consultancy" role="tab" aria-selected="false">
                                    <span class="hidden-xs-down tab-header"> Industry Consultancy </span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane p-20 active" id="consultancy" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="consultancy_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                            

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                      

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane p-20" id="industry_consultancy" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">


                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="iconsultancy_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                       

                                                       



                                                    </tbody>
                                                </table>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Activity Tab -->
                    <div class="tab-pane" id="activity" role="tabpanel">

                        <ul class="nav navs-tabs justify-content-center mb-3">
                            <li class="nav-item" style="margin-right: 15px;"> <!-- Add margin between tabs -->
                                <a class="nav-link active" id="add-bus-tab" data-bs-toggle="tab" href="#researchguideship" role="tab" aria-selected="true">
                                    Research Guideship
                                </a>
                            </li>
                            <li class="nav-item"> <!-- Add margin between tabs -->
                                <a class="nav-link" id="add-bus-tab" data-bs-toggle="tab" href="#researchguidance" role="tab" aria-selected="false">
                                    Research Guidance
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane p-20 active" id="researchguideship" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">


                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="r_guideship_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>


                                            </div>
                                        </div>





                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane p-20" id="researchguidance" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="card-body">
                                            <div class="table-responsive">

                                                <table id="r_guidance_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                          
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                                                </tbody>
                                                </table>


                                            </div>
                                        </div>





                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Certification Tab -->
                    <div class="tab-pane" id="course_certificate" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="certificate_table" class="table table-striped table-bordered">
                                            <thead class="gradient-header">
                                                <tr>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                               

                                            </tbody>
                                        </table>



                                    </div>
                                </div>




                            </div>
                        </div>
                    </div>


                    <div class="tab-pane p-20" id="report" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <form id="selectReport" onsubmit="fetchFilteredData(event)" class="d-flex flex-wrap align-items-end">
                                            <!-- Department Dropdown -->
                                            <div class="row">

                                                <div class="form-group col-md-3 mb-3">
                                                    <label for="deptSelect" class="text-black">Departments</label>
                                                    <select id="deptSelect" class="select2 form-control custom-select" name="department" required>
                                                        <option value="">Select Department</option>
                                                        <option value="all">All Departments</option>
                                                        <option value="Artificial Intelligence and Data Science">Artificial Intelligence and Data Science</option>
                                                        <option value="Artificial Intelligence and Machine Learning">Artificial Intelligence and Machine Learning</option>
                                                        <option value="Civil Engineering">Civil Engineering</option>
                                                        <option value="Computer Science and Business Systems">Computer Science and Business Systems</option>
                                                        <option value="Computer Science and Engineering">Computer Science and Engineering</option>
                                                        <option value="Electrical and Electronics Engineering">Electrical and Electronics Engineering</option>
                                                        <option value="Freshmen Engineering">Freshmen Engineering</option>
                                                        <option value="Electronics and Communication Engineering">Electronics and Communication Engineering</option>
                                                        <option value="Information Technology">Information Technology</option>
                                                        <option value="Mechanical Engineering">Mechanical Engineering</option>
                                                        <option value="Master of Business Administration">Master of Business Administration</option>
                                                        <option value="Master of Computer Applications">Master of Computer Applications</option>
                                                        <option value="Technology Innovation Hub">Technology Innovation Hub</option>
                                                    </select>
                                                </div>

                                                <!-- Academic Year Dropdown -->
                                                <div class="form-group col-md-3 mb-3">
                                                    <label for="academic_yearSelect" class="text-black">Academic Year</label>
                                                    <select id="academic_yearSelect" class="form-control">
                                                        <option value="">-- Select Year --</option>
                                                        <option value="2024-2025">2024-2025</option>
                                                        <option value="2025-2026">2025-2026</option>
                                                    </select>
                                                </div>

                                                <!-- Event Status Dropdown -->
                                                <div class="form-group col-md-3 mb-3">
                                                    <label for="statusSelect" class="text-black">Status</label>
                                                    <select id="statusSelect" class="select2 form-control custom-select" name="status_type">
                                                        <option value="">Select Status</option>
                                                        <option value="all">All Research</option>
                                                        <option value="completed">Completed </option>
                                                        <option value="process">Ongoing </option>
                                                        <option value="reject">Rejected </option>

                                                    </select>
                                                </div>

                                                <!-- Event Type Dropdown -->
                                                <div class="form-group col-md-3 mb-3">
                                                    <label for="researchSelect" class="text-black">Research Type</label>
                                                    <select id="researchSelect" class="select2 form-control custom-select" name="research_type">
                                                        <option value="">Select</option>
                                                        <option value="Journal">Journal</option>
                                                        <option value="Conference">Conference</option>
                                                        <option value="Patent">Patent</option>
                                                        <option value="Consultancy">Consultancy</option>
                                                        <option value="Industry Consultancy">Industry Consultancy</option>
                                                        <option value="Research Guideship">Research Guideship</option>
                                                        <option value="Research Guidance">Research Guidance</option>
                                                        <option value="Certificate">Certificate</option>
                                                    </select>
                                                </div>


                                                <div class="form-group ">
                                                    <!-- Submit Button -->
                                                    <button type="submit" class="btn btn-primary md-4">
                                                        Fetch Report
                                                    </button>
                                                    <button onclick="downloadExcel()" id="downloadButton" class="btn btn-primary md-4" disabled>Download Excel</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>


                                    <div class="table-responsive mt-3">
                                        <table id="research_report" class="table table-striped table-bordered">
                                            <thead class="gradient-header">
                                                <tr>


                                                </tr>
                                            </thead>
                                            <tbody>


                                            </tbody>
                                        </table>

                                        <div class="modal fade" id="dynamicModal3" tabindex="-1" role="dialog" aria-labelledby="dynamicModalLabel3" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="dynamicModalLabel3">Modal Title</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-center" id="dynamicModalBody3">
                                                        <!-- Content will be loaded dynamically here -->
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
        $(document).on('click', '.view_conference_paper', function() {
            var conference_paper_id_Url = $(this).data('conference_paper_id');
            $('#view_ModalLabel').text('View Documents');
            $('#view_ModalBody').html('<iframe src="' + conference_paper_id_Url + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });
        $(document).on('click', '.view_journal_paper', function() {
            var journal_paper_id_Url = $(this).data('journal_paper_id');
            $('#view_ModalLabel').text('View Documents');
            $('#view_ModalBody').html('<iframe src="' + journal_paper_id_Url + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });
        $(document).on('click', '.view_book_paper', function() {
            var book_paper_id_Url = $(this).data('book_documents');
            $('#view_ModalLabel').text('View Documents');
            $('#view_ModalBody').html('<iframe src="' + book_paper_id_Url + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });


        $(document).on('click', '.view-conference-details', function() {
            var paperId = $(this).data('id');
            var formData = new FormData();
            formData.append("action", "conference_details");
            formData.append("id", paperId);
            $.ajax({
                url: 'fetch_details.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#view_ModalLabel').text('View Conference Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });
        $(document).on('click', '.view-journal-details', function() {
            var paperId = $(this).data('id');
            var formData = new FormData();
            formData.append("action", "journal_details");
            formData.append("id", paperId);
            $.ajax({
                url: 'fetch_details.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#view_ModalLabel').text('View Journal Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });
        $(document).on('click', '.view_book_details', function() {
            var paperId = $(this).data('id');
            var formData = new FormData();
            formData.append("action", "book_details");
            formData.append("id", paperId);
            $.ajax({
                url: 'fetch_details.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#view_ModalLabel').text('View Book Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });


        $(document).on('click', '.view_patent_paper', function() {
            var patent_paper_id_Url = $(this).data('patent_paper_id');
            $('#view_ModalLabel').text('View documents');
            $('#view_ModalBody').html('<iframe src="' + patent_paper_id_Url + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });

        $(document).on('click', '.view-patent-details', function() {
            var paperId = $(this).data('id'); // Assume each 'view' button has a data-id attribute
            // Create a FormData object
            var formData = new FormData();

            formData.append("action", "patent_details");
            formData.append("id", paperId);
            $.ajax({
                url: 'fetch_details.php', // Backend script to fetch data
                type: 'POST',
                data: formData,
                contentType: false, // Required for FormData
                processData: false, // Required for FormData
                success: function(response) {
                    $('#view_ModalLabel').text('View Patent Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });

        $(document).on('click', '.view_copyright_details', function() {
            var paperId = $(this).data('id');
            var formData = new FormData();
            formData.append("action", "copyrights_details");
            formData.append("id", paperId);
            $.ajax({
                url: 'fetch_details.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#view_ModalLabel').text('View Copyright Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });
        $(document).on('click', '.view_copyright_paper', function() {
            var copyright_paper_id_Url = $(this).data('copyright_id');
            $('#view_ModalLabel').text('View documents');
            $('#view_ModalBody').html('<iframe src="' + copyright_paper_id_Url + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });

        $(document).on('click', '.view_project_details', function() {
            var paperId = $(this).data('id');
            var formData = new FormData();
            formData.append("action", "project_details");
            formData.append("id", paperId);
            $.ajax({
                url: 'fetch_details.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#view_ModalLabel').text('View Project Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });
        $(document).on('click', '.view_project_paper', function() {
            var copyright_paper_id_Url = $(this).data('project_id');
            $('#view_ModalLabel').text('View documents');
            $('#view_ModalBody').html('<iframe src="' + copyright_paper_id_Url + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });

        $(document).on('click', '.view_project_guidance_details', function() {
            var paperId = $(this).data('id');
            var formData = new FormData();
            formData.append("action", "project_guidance_details");
            formData.append("id", paperId);
            $.ajax({
                url: 'fetch_details.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#view_ModalLabel').text('View Project Guidance Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });
        $(document).on('click', '.view_project_guidance_paper', function() {
            var project_guidance_id_Url = $(this).data('project_guidance_id');
            $('#view_ModalLabel').text('View documents');
            $('#view_ModalBody').html('<iframe src="' + project_guidance_id_Url + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });

        $(document).on('click', '.consultancy_viewdetails', function() {
            var id = $(this).data('id');
            var formData = new FormData();
            formData.append("action", "consultancy_viewdetails");
            formData.append("id", id);
            $.ajax({
                url: 'fetch_details.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#view_ModalLabel').text('View Consultancy Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });

        $(document).on('click', '.consultancy_viewBroucher', function() {
            var uploaded_files = $(this).data('consultancy_documents');

            $('#view_ModalLabel').text('View Documents');
            $('#view_ModalBody').html('<iframe src="' + uploaded_files + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });

        $(document).on('click', '.iconsultancy_viewdetails1', function() {
            var id = $(this).data('id');
            var formData = new FormData();
            formData.append("action", "iconsultancy_viewdetails1");
            formData.append("id", id);
            $.ajax({
                url: 'fetch_details.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#view_ModalLabel').text('View Industry Consultancy Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });

        $(document).on('click', '.iconsultancy_viewBrochure1', function() {
            var uploaded_files = $(this).data('iconsultancy_documents');

            $('#view_ModalLabel').text('Event Brochure');
            $('#view_ModalBody').html('<iframe src="' + uploaded_files + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });


        $(document).on('click', '.view_r_guideship_paper', function() {
            var r_guideship_id_Url = $(this).data('r_guideship_id');
            $('#view_ModalLabel').text('View Documents');
            $('#view_ModalBody').html('<iframe src="' + r_guideship_id_Url + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });

        $(document).on('click', '.view_r_guideship_details', function() {
            var paperId = $(this).data('id'); // Assume each 'view' button has a data-id attribute
            // Create a FormData object
            var formData = new FormData();
            formData.append("action", "r_guideship_details");
            formData.append("id", paperId);
            $.ajax({
                url: 'fetch_details.php', // Backend script to fetch data
                type: 'POST',
                data: formData,
                contentType: false, // Required for FormData
                processData: false, // Required for FormData
                success: function(response) {
                    $('#view_ModalLabel').text('View Research Guideship Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });


        $(document).on('click', '.view_rguidance_paper', function() {
            // Retrieve the research PDF URL from the button's data attribute
            var researchPaperUrl = $(this).data('rguidance-paper-id');

            // Update the modal content dynamically
            $('#view_ModalLabel').text('View Documents');
            $('#view_ModalBody').html('<iframe src="' + researchPaperUrl + '" frameborder="0" style="width:100%; height:500px;"></iframe>');

            // Show the modal
            $('#view_Modal').modal('show');
        });

        $(document).on('click', '.view-rguidance-details', function() {
            var paperId = $(this).data('id');
            var formData = new FormData();
            formData.append("action", "rguidance_details");
            formData.append("id", paperId);
            $.ajax({
                url: 'fetch_details.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#view_ModalLabel').text('View Research Guidance Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });



        $(document).on('click', '.view_certificate_details', function() {
            var paperId = $(this).data('id'); // Assume each 'view' button has a data-id attribute
            // Create a FormData object
            var formData = new FormData();
            formData.append("action", "certificate_details");
            formData.append("id", paperId);
            $.ajax({
                url: 'fetch_details.php', // Backend script to fetch data
                type: 'POST',
                data: formData,
                contentType: false, // Required for FormData
                processData: false, // Required for FormData
                success: function(response) {
                    $('#view_ModalLabel').text('View Certificate Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });

        $(document).on('click', '.view_certificate', function() {
            var certificateUrl = $(this).data('certificate_id'); // Get the file URL from data attribute
            var fileType = certificateUrl.split('.').pop().toLowerCase(); // Get file extension
            var modalBody = $('#view_ModalBody');

            $('#view_ModalLabel').text('Certificate');
            modalBody.empty();
            if (fileType === 'pdf') {
                // Display PDF in iframe
                modalBody.html('<iframe src="' + certificateUrl + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            } else if (['jpg', 'jpeg', 'png', 'gif'].includes(fileType)) {

                modalBody.html('<img src="' + certificateUrl + '" alt="Certificate" style="width:100%; height:auto;">');
            } else {
                // Handle unsupported file types
                modalBody.html('<p class="text-danger">Unsupported file format. Please upload a valid PDF or image file.</p>');
            }

            // Show the modal
            $('#view_Modal').modal('show');
        });
    </script>
    <script>
        function fetchFilteredData(event) {
            event.preventDefault(); // Prevent form submission

            // Get filter values from the dropdowns
            const researchType = document.getElementById("researchSelect").value;
            const department = document.getElementById("deptSelect").value;
            const status = document.getElementById("statusSelect").value;
            const academicYear = document.getElementById("academic_yearSelect").value;

            // Map the status to specific values based on your conditions
            let status1 = [];
            if (status === "completed") {
                status1 = [2];
            } else if (status === "process") {
                status1 = [0, 1];
            } else if (status === "reject") {
                status1 = [3, 4];
            } else {
                // All events
                status1 = [0, 1, 2, 3, 4];
            }

            // Make an AJAX request to fetch data
            $.ajax({
                url: "get_report.php", // The PHP file that processes the request
                method: "POST",
                data: {
                    research_type: researchType,
                    department: department,
                    status: status1,
                    academic_year: academicYear
                },
                success: function(response) {
                    // Populate the table with the returned data
                    $("#research_report tbody").html(response);
                    checkDataAndToggleButton();
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }




        function checkDataAndToggleButton() {
            const table = document.getElementById('research_report');
            const downloadButton = document.getElementById('downloadButton');

            // Check if the table has any rows in the body other than the header
            const rows = table.getElementsByTagName('tbody')[0].rows;

            if (rows.length >= 1) {
                downloadButton.disabled = false; // Enable the button if data exists
            } else {
                downloadButton.disabled = true; // Disable the button if no data
            }
        }


        // Function to download the table as an Excel file
        function downloadExcel() {
            if (typeof XLSX === 'undefined') {
                console.error('XLSX is not defined. Please check the library loading.');
                return;
            }

            const table = document.getElementById('research_report');
            const ws = XLSX.utils.table_to_sheet(table);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Research Details");
            XLSX.writeFile(wb, 'research_details.xlsx');
        }


        $(document).ready(function() {

            $('#journal_table').DataTable({
                "autoWidth": false,
                ajax: {
                    url: 'fetch_user.php', // Your PHP endpoint for fetching data
                    type: 'POST',
                    data: function(d) {
                        d.status_no = 0;
                        d.tab = 'journal'; // Filter by status_no if necessary
                    }
                },
                language: {
                    emptyTable: "No data found",
                    loadingRecords: "Loading data...",
                    zeroRecords: "No matching data found"
                },
                columns: [{
                        data: null,
                        title: 'S.No',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
					{
                        data: 'staff_id',
                        title: 'Staff Id'
                    },
					{
                        data: 'staff_name',
                        title: 'Staff Name'
                    },
                    {
                        data: 'j_paper_title',
                        title: 'Paper Title'
                    },
                    
                    {
                        data: null,
                        title: 'Details',
                        render: function(data, type, row) {
                            return `<button class="btn btn-sm btn-info view-journal-details" data-id="${row.id}">View</button>`;
                        }
                    },
                    {
                        data: 'journal_pdf',
                        title: 'Document',
                        render: function(data, type, row) {
                            return `<button type='button' class='btn btn-sm btn-info view_journal_paper' data-journal_paper_id="${data}">View</button>`;
                        }
                    },
                    {
                        data: null,
                        title: 'Action',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex">
                                <button class="btn btn-correct btn-icon mr-2 journalapproveBtn" aria-label="Correct" data-id="${row.id}">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>&nbsp;
                                                                            <button class="btn btn-wrong btn-icon journalrejectBtn" aria-label="Wrong" data-id="${row.id}">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                            </div>
                        `;
                        }
                    }
                ]
            });
            $('#conference_table').DataTable({
                "autoWidth": false,
                ajax: {
                    url: 'fetch_user.php', // Your PHP endpoint for fetching data
                    type: 'POST',
                    data: function(d) {
                        d.status_no = 0;
                        d.tab ='conference';// Filter by status_no if necessary
                    }
                },
                language: {
                    emptyTable: "No data found",
                    loadingRecords: "Loading data...",
                    zeroRecords: "No matching data found"
                },
                columns: [{
                        data: null,
                        title: 'S.No',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
					{
                        data: 'staff_id',
                        title: 'Staff Id'
                    },
					{
                        data: 'staff_name',
                        title: 'Staff Name'
                    },
                    {
                        data: 'title_of_paper',
                        title: 'Paper Title'
                    },
                    
                    {
                        data: null,
                        title: 'Details',
                        render: function(data, type, row) {
                            return `<button class="btn btn-sm btn-info view-conference-details" data-id="${row.id}">View</button>`;
                        }
                    },
                    {
                        data: 'conference_pdf',
                        title: 'Document',
                        render: function(data, type, row) {
                            return `<button type='button' class='btn btn-sm btn-info view_conference_paper' data-conference_paper_id="${data}">View</button>`;
                        }
                    },
                    {
                        data: null,
                        title: 'Action',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex">
                                <button class="btn btn-correct btn-icon mr-2 conferenceapproveBtn" aria-label="Correct" data-id="${row.id}">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>&nbsp;
                                                                            <button class="btn btn-wrong btn-icon conferencerejectBtn" aria-label="Wrong" data-id="${row.id}">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                            </div>
                        `;
                        }
                    }
                ]
            });

            $('#book_table').DataTable({
                "autoWidth": false,
                ajax: {
                    url: 'fetch_user.php', // Your PHP endpoint for fetching data
                    type: 'POST',
                    data: function(d) {
                        d.status_no = 0;
                        d.tab = 'book';// Filter by status_no if necessary
                    }
                },
                language: {
                    emptyTable: "No data found",
                    loadingRecords: "Loading data...",
                    zeroRecords: "No matching data found"
                },
                columns: [{
                        data: null,
                        title: 'S.No',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
					{
                        data: 'staff_id',
                        title: 'Staff Id'
                    },
					{
                        data: 'staff_name',
                        title: 'Staff Name'
                    },
                    {
                        data: 'book_title',
                        title: 'Title'
                    },
                    
                    {
                        data: null,
                        title: 'Details',
                        render: function(data, type, row) {
                            return `<button class="btn btn-sm btn-info view_book_details" data-id="${row.id}">View</button>`;
                        }
                    },
                    {
                        data: 'documents',
                        title: 'Document',
                        render: function(data, type, row) {
                            return `<button type='button' class='btn btn-sm btn-info view_book_paper' data-book_documents="${data}">View</button>`;
                        }
                    },
                    {
                        data: null,
                        title: 'Action',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex">
                                <button class="btn btn-correct btn-icon mr-2 bookapproveBtn" aria-label="Correct" data-id="${row.id}">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>&nbsp;
                                                                            <button class="btn btn-wrong btn-icon bookrejectBtn" aria-label="Wrong" data-id="${row.id}">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                            </div>
                        `;
                        }
                    }
                ]
            });
			
			  $('#patent_table').DataTable({
                "autoWidth": false,
                ajax: {
                    url: 'fetch_user.php', // Your PHP endpoint for fetching data
                    type: 'POST',
                    data: function(d) {
                        d.status_no = 0;
                        d.tab = 'patent';// Filter by status_no if necessary
                    }
                },
                language: {
                    emptyTable: "No data found",
                    loadingRecords: "Loading data...",
                    zeroRecords: "No matching data found"
                },
                columns: [{
                        data: null,
                        title: 'S.No',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
					{
                        data: 'staff_id',
                        title: 'Staff Name'
                    },
					{
                        data: 'staff_name',
                        title: 'Staff Name'
                    },
                    {
                        data: 'patent_title',
                        title: 'Patent Title'
                    },
                    {
                        data: 'application_number',
                        title: 'Application Number'
                    },
                    {
                        data: null,
                        title: 'Details',
                        render: function(data, type, row) {
                            return `<button class="btn btn-sm btn-info view-patent-details" data-id="${row.id}">View</button>`;
                        }
                    },
                    {
                        data: 'patent_pdf',
                        title: 'Document',
                        render: function(data, type, row) {
                            return `<button type='button' class='btn btn-sm btn-info view_patent_paper' data-patent_paper_id="${data}">View</button>`;
                        }
                    },
                    {
                        data: null,
                        title: 'Action',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex">
                                <button class="btn btn-correct btn-icon mr-2 patentapproveBtn" aria-label="Correct" data-id="${row.id}">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>&nbsp;
                                                                            <button class="btn btn-wrong btn-icon patentrejectBtn" aria-label="Wrong" data-id="${row.id}">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                            </div>
                        `;
                        }
                    }
                ]
            });
			
			 $('#copyright_table').DataTable({
                "autoWidth": false,
                ajax: {
                    url: 'fetch_user.php', // Your PHP endpoint for fetching data
                    type: 'POST',
                    data: function(d) {
                        d.status_no = 0;
                        d.tab = 'copyright';// Filter by status_no if necessary
                    }
                },
                language: {
                    emptyTable: "No data found",
                    loadingRecords: "Loading data...",
                    zeroRecords: "No matching data found"
                },
                columns: [{
                        data: null,
                        title: 'S.No',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
					{
                        data: 'staff_id',
                        title: 'Staff Id'
                    },
					{
                        data: 'staff_name',
                        title: 'Staff Name'
                    },
                    {
                        data: 'copy_title',
                        title: 'Copyright Title'
                    },
                    
                    {
                        data: null,
                        title: 'Details',
                        render: function(data, type, row) {
                            return `<button class="btn btn-sm btn-info view_copyright_details" data-id="${row.id}">View</button>`;
                        }
                    },
                    {
                        data: 'copy_pdf',
                        title: 'Document',
                        render: function(data, type, row) {
                            return `<button type='button' class='btn btn-sm btn-info view_copyright_paper' data-copyright_id="${data}">View</button>`;
                        }
                    },
                    {
                        data: null,
                        title: 'Action',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex">
                                <button class="btn btn-correct btn-icon mr-2 copyrightapproveBtn" aria-label="Correct" data-id="${row.id}">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>&nbsp;
                                                                            <button class="btn btn-wrong btn-icon copyrightrejectBtn" aria-label="Wrong" data-id="${row.id}">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                            </div>
                        `;
                        }
                    }
                ]
            });

            $('#project_table').DataTable({
                "autoWidth": false,
                ajax: {
                    url: 'fetch_user.php', // Your PHP endpoint for fetching data
                    type: 'POST',
                    data: function(d) {
                        d.status_no = 0;
                        d.tab = 'projects';// Filter by status_no if necessary
                    }
                },
                language: {
                    emptyTable: "No data found",
                    loadingRecords: "Loading data...",
                    zeroRecords: "No matching data found"
                },
                columns: [{
                        data: null,
                        title: 'S.No',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
					{
                        data: 'staff_id',
                        title: 'Staff Id'
                    },
					{
                        data: 'staff_name',
                        title: 'Staff Name'
                    },
                    {
                        data: 'title',
                        title: 'Project Title'
                    },
                    
                    {
                        data: null,
                        title: 'Details',
                        render: function(data, type, row) {
                            return `<button class="btn btn-sm btn-info view_project_details" data-id="${row.id}">View</button>`;
                        }
                    },
                    {
                        data: 'project_pdf',
                        title: 'Document',
                        render: function(data, type, row) {
                            return `<button type='button' class='btn btn-sm btn-info view_project_paper' data-project_id="${data}">View</button>`;
                        }
                    },
                    {
                        data: null,
                        title: 'Action',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex">
                                <button class="btn btn-correct btn-icon mr-2 projectapproveBtn" aria-label="Correct" data-id="${row.id}">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>&nbsp;
                                                                            <button class="btn btn-wrong btn-icon projectrejectBtn" aria-label="Wrong" data-id="${row.id}">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                            </div>
                        `;
                        }
                    }
                ]
            });
			
            $('#project_guidance_table').DataTable({
                "autoWidth": false,
                ajax: {
                    url: 'fetch_user.php', // Your PHP endpoint for fetching data
                    type: 'POST',
                    data: function(d) {
                        d.status_no = 0;
                        d.tab = 'project_guidance';// Filter by status_no if necessary
                    }
                },
                language: {
                    emptyTable: "No data found",
                    loadingRecords: "Loading data...",
                    zeroRecords: "No matching data found"
                },
                columns: [{
                        data: null,
                        title: 'S.No',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
					{
                        data: 'staff_id',
                        title: 'Staff Id'
                    },
					{
                        data: 'staff_name',
                        title: 'Staff Name'
                    },
                    {
                        data: 'no_of_teams',
                        title: 'Total Teams'
                    },
                    
                    {
                        data: null,
                        title: 'Details',
                        render: function(data, type, row) {
                            return `<button class="btn btn-sm btn-info view_project_guidance_details" data-id="${row.id}">View</button>`;
                        }
                    },
                    {
                        data: 'documents',
                        title: 'Document',
                        render: function(data, type, row) {
                            return `<button type='button' class='btn btn-sm btn-info view_project_guidance_paper' data-copyright_id="${data}">View</button>`;
                        }
                    },
                    {
                        data: null,
                        title: 'Action',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex">
                                <button class="btn btn-correct btn-icon mr-2 project_guidanceapproveBtn" aria-label="Correct" data-id="${row.id}">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>&nbsp;
                                                                            <button class="btn btn-wrong btn-icon project_guidancerejectBtn" aria-label="Wrong" data-id="${row.id}">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                            </div>
                        `;
                        }
                    }
                ]
            });
			

			


			 $('#consultancy_table').DataTable({
                "autoWidth": false,
                ajax: {
                    url: 'fetch_user.php', // Your PHP endpoint for fetching data
                    type: 'POST',
                    data: function(d) {
                        d.status_no = 0;
                        d.tab = 'consultancy';// Filter by status_no if necessary
                    }
                },
                language: {
                    emptyTable: "No data found",
                    loadingRecords: "Loading data...",
                    zeroRecords: "No matching data found"
                },
                columns: [{
                        data: null,
                        title: 'S.No',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
					{
                        data: 'staff_id',
                        title: 'Staff Id'
                    },
					{
                        data: 'staff_name',
                        title: 'Staff Name'
                    },
                    {
                        data: 'title',
                        title: 'Title'
                    },
                    
                    {
                        data: null,
                        title: 'Details',
                        render: function(data, type, row) {
                            return `<button class="btn btn-sm btn-info consultancy_viewdetails" data-id="${row.id}">View</button>`;
                        }
                    },
                    {
                        data: 'consultancy_documents',
                        title: 'Document',
                        render: function(data, type, row) {
                            return `<button type='button' class='btn btn-sm btn-info consultancy_viewBroucher' data-consultancy_documents="${data}">View</button>`;
                        }
                    },
                    {
                        data: null,
                        title: 'Action',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex">
                                <button class="btn btn-correct btn-icon mr-2 consultancyapproveBtn" aria-label="Correct" data-id="${row.id}">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>&nbsp;
                                                                            <button class="btn btn-wrong btn-icon consultancyrejectBtn" aria-label="Wrong" data-id="${row.id}">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                            </div>
                        `;
                        }
                    }
                ]
            });
			
			
			 $('#iconsultancy_table').DataTable({
                "autoWidth": false,
                ajax: {
                    url: 'fetch_user.php', // Your PHP endpoint for fetching data
                    type: 'POST',
                    data: function(d) {
                        d.status_no = 0;
                        d.tab = 'iconsultancy';// Filter by status_no if necessary
                    }
                },
                language: {
                    emptyTable: "No data found",
                    loadingRecords: "Loading data...",
                    zeroRecords: "No matching data found"
                },
                columns: [{
                        data: null,
                        title: 'S.No',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
					{
                        data: 'staff_id',
                        title: 'Staff Id'
                    },
					{
                        data: 'staff_name',
                        title: 'Staff Name'
                    },
                    {
                        data: 'iconsultancy_title',
                        title: 'Title'
                    },
                   
                    {
                        data: null,
                        title: 'Details',
                        render: function(data, type, row) {
                            return `<button class="btn btn-sm btn-info iconsultancy_viewdetails1" data-id="${row.id}">View</button>`;
                        }
                    },
                    {
                        data: 'iconsultancy_documents',
                        title: 'Document',
                        render: function(data, type, row) {
                            return `<button type='button' class='btn btn-sm btn-info iconsultancy_viewBroucher1' data-iconsultancy_documents="${data}">View</button>`;
                        }
                    },
                    {
                        data: null,
                        title: 'Action',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex">
                                <button class="btn btn-correct btn-icon mr-2 iconsultancyapproveBtn" aria-label="Correct" data-id="${row.id}">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>&nbsp;
                                                                            <button class="btn btn-wrong btn-icon iconsultancyrejectBtn" aria-label="Wrong" data-id="${row.id}">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                            </div>
                        `;
                        }
                    }
                ]
            });
			
			
			
			 $('#r_guideship_table').DataTable({
                "autoWidth": false,
                ajax: {
                    url: 'fetch_user.php', // Your PHP endpoint for fetching data
                    type: 'POST',
                    data: function(d) {
                        d.status_no = 0;
                        d.tab = 'r_guideship';// Filter by status_no if necessary
                    }
                },
                language: {
                    emptyTable: "No data found",
                    loadingRecords: "Loading data...",
                    zeroRecords: "No matching data found"
                },
                columns: [{
                        data: null,
                        title: 'S.No',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'universityname',
                        title: 'University Name '
                    },
                    {
                        data: 'faculty',
                        title: 'Staff Name'
                    },
                    {
                        data: null,
                        title: 'Details',
                        render: function(data, type, row) {
                            return `<button class="btn btn-sm btn-info view_r_guideship_details" data-id="${row.id}">View</button>`;
                        }
                    },
                    {
                        data: 'r_guideship_pdf',
                        title: 'Document',
                        render: function(data, type, row) {
                            return `<button type='button' class='btn btn-sm btn-info view_r_guideship_paper' data-guideship_paper_id="${data}">View</button>`;
                        }
                    },
                    {
                        data: null,
                        title: 'Action',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex">
                                <button class="btn btn-correct btn-icon mr-2 r_guideshipapproveBtn" aria-label="Correct" data-id="${row.id}">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>&nbsp;
                                                                            <button class="btn btn-wrong btn-icon r_guideshiprejectBtn" aria-label="Wrong" data-id="${row.id}">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                            </div>
                        `;
                        }
                    }
                ]
            });
			
		
			 $('#r_guidance_table').DataTable({
                "autoWidth": false,
                ajax: {
                    url: 'fetch_user.php', // Your PHP endpoint for fetching data
                    type: 'POST',
                    data: function(d) {
                        d.status_no = 0;
                        d.tab = 'r_guidance';// Filter by status_no if necessary
                    }
                },
                language: {
                    emptyTable: "No data found",
                    loadingRecords: "Loading data...",
                    zeroRecords: "No matching data found"
                },
                columns: [{
                        data: null,
                        title: 'S.No',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    
					{
                        data: 'staff_name',
                        title: 'Staff Name'
                    },
					{
                        data: 'university_name',
                        title: 'University Name'
                    },
                    {
                        data: 'no_of_scholars',
                        title: 'Number of Scholars'
                    },
                    {
                        data: null,
                        title: 'Details',
                        render: function(data, type, row) {
                            return `<button class="btn btn-sm btn-info view_r_guidance_details" data-id="${row.id}">View</button>`;
                        }
                    },
                    {
                        data: 'patent_pdf',
                        title: 'Document',
                        render: function(data, type, row) {
                            return `<button type='button' class='btn btn-sm btn-info view_r_guidance_paper' data-guidance_paper_id="${data}">View</button>`;
                        }
                    },
                    {
                        data: null,
                        title: 'Action',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex">
                                <button class="btn btn-correct btn-icon mr-2 r_guidanceapproveBtn" aria-label="Correct" data-id="${row.id}">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>&nbsp;
                                                                            <button class="btn btn-wrong btn-icon r_guidancerejectBtn" aria-label="Wrong" data-id="${row.id}">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                            </div>
                        `;
                        }
                    }
                ]
            });
			
			
			 $('#certificate_table').DataTable({
                "autoWidth": false,
                ajax: {
                    url: 'fetch_user.php', // Your PHP endpoint for fetching data
                    type: 'POST',
                    data: function(d) {
                        d.status_no = 0;
                        d.tab = 'certification';// Filter by status_no if necessary
                    }
                },
                language: {
                    emptyTable: "No data found",
                    loadingRecords: "Loading data...",
                    zeroRecords: "No matching data found"
                },
                columns: [{
                        data: null,
                        title: 'S.No',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
					 {
                        data: 'staff_id',
                        title: 'Staff Id'
                    },
					 {
                        data: 'staff_name',
                        title: 'Staff Name'
                    },
                    {
                        data: 'event_name',
                        title: 'Certification '
                    },
                    {
                        data: 'certification_duration',
                        title: 'Duration'
                    },
                    {
                        data: null,
                        title: 'Details',
                        render: function(data, type, row) {
                            return `<button class="btn btn-sm btn-info view_certificate_details" data-id="${row.id}">View</button>`;
                        }
                    },
                    {
                        data: 'certificate_document',
                        title: 'Document',
                        render: function(data, type, row) {
                            return `<button type='button' class='btn btn-sm btn-info view_certificate' data-certificate_id="${data}">View</button>`;
                        }
                    },
                    {
                        data: null,
                        title: 'Action',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex">
                                <button class="btn btn-correct btn-icon mr-2 certificateapproveBtn" aria-label="Correct" data-id="${row.id}">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>&nbsp;
                                                                            <button class="btn btn-wrong btn-icon certificaterejectBtn" aria-label="Wrong" data-id="${row.id}">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                            </div>
                        `;
                        }
                    }
                ]
            });
			
			
			
            $(document).on('click', '.journalapproveBtn, .journalrejectBtn', function() {
                var applicantId = $(this).data('id');
                var action = $(this).hasClass('journalapproveBtn') ? 'approve' : 'reject';

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
                                    data: 'journal',
                                    page: 'hod'
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Accepted!',
                                            text: res.message
                                        }).then(() => {
                                            var table =   $('#journal_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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
                                            data: 'journal',
                                            page: 'hod'
                                        },
                                        dataType: 'json',
                                        success: function(res) {
                                            if (res.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Rejected',
                                                    text: res.message
                                                }).then(() => {
                                                    var table = $('#journal_table').DataTable();
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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

            $(document).on('click', '.conferenceapproveBtn, .conferencerejectBtn', function() {
                var applicantId = $(this).data('id');
                var action = $(this).hasClass('conferenceapproveBtn') ? 'approve' : 'reject';
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
                                    data: 'conference',
                                    page: 'hod'
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Accepted!',
                                            text: res.message
                                        }).then(() => {
                                            var table = $('#conference_table').DataTable();
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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
                                            data: 'conference',
                                            page: 'hod'
                                        },
                                        dataType: 'json',
                                        success: function(res) {
                                            if (res.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Rejected',
                                                    text: res.message
                                                }).then(() => {
                                                    var table = $('#conference_table').DataTable();
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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

            $(document).on('click', '.bookapproveBtn, .bookrejectBtn', function() {
                var applicantId = $(this).data('id');
                var action = $(this).hasClass('bookapproveBtn') ? 'approve' : 'reject';

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
                                    data: 'book',
                                    page: 'hod'
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Accepted!',
                                            text: res.message
                                        }).then(() => {
                                            var table =   $('#book_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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
                                            data: 'book',
                                            page: 'hod'
                                        },
                                        dataType: 'json',
                                        success: function(res) {
                                            if (res.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Rejected',
                                                    text: res.message
                                                }).then(() => {
                                                    var table =   $('#book_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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

            $(document).on('click', '.patentapproveBtn, .patentrejectBtn', function() {
                var applicantId = $(this).data('id');
                var action = $(this).hasClass('patentapproveBtn') ? 'approve' : 'reject';

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
                                    data: 'patent',
                                    page: 'hod'
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Accepted!',
                                            text: res.message
                                        }).then(() => {
                                            var table =   $('#patent_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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
                                            data: 'patent',
                                            page: 'hod'
                                        },
                                        dataType: 'json',
                                        success: function(res) {
                                            if (res.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Rejected',
                                                    text: res.message
                                                }).then(() => {
                                                    var table =   $('#patent_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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

            $(document).on('click', '.copyrightapproveBtn, .copyrightrejectBtn', function() {
                var applicantId = $(this).data('id');
                var action = $(this).hasClass('copyrightapproveBtn') ? 'approve' : 'reject';

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
                                    data: 'copyright',
                                    page: 'hod'
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Accepted!',
                                            text: res.message
                                        }).then(() => {
                                            var table =   $('#copyright_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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
                                            data: 'copyright',
                                            page: 'hod'
                                        },
                                        dataType: 'json',
                                        success: function(res) {
                                            if (res.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Rejected',
                                                    text: res.message
                                                }).then(() => {
                                                    var table =   $('#copyright_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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

            $(document).on('click', '.projectapproveBtn, .projectrejectBtn', function() {
                var applicantId = $(this).data('id');
                var action = $(this).hasClass('projectapproveBtn') ? 'approve' : 'reject';

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
                                    data: 'project',
                                    page: 'hod'
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Accepted!',
                                            text: res.message
                                        }).then(() => {
                                            var table =   $('#project_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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
                                            data: 'project',
                                            page: 'hod'
                                        },
                                        dataType: 'json',
                                        success: function(res) {
                                            if (res.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Rejected',
                                                    text: res.message
                                                }).then(() => {
                                                    var table =   $('#project_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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

            $(document).on('click', '.project_guidanceapproveBtn, .project_guidancerejectBtn', function() {
                var applicantId = $(this).data('id');
                var action = $(this).hasClass('project_guidanceapproveBtn') ? 'approve' : 'reject';

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
                                    data: 'project_guidance',
                                    page: 'hod'
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Accepted!',
                                            text: res.message
                                        }).then(() => {
                                            var table =   $('#project_guidance_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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
                                            data: 'project_guidance',
                                            page: 'hod'
                                        },
                                        dataType: 'json',
                                        success: function(res) {
                                            if (res.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Rejected',
                                                    text: res.message
                                                }).then(() => {
                                                    var table =   $('#project_guidance_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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

            // handle approve and reject action on consultancy and industry consultancy tab 
            $(document).on('click', '.consultancyapproveBtn, .consultancyrejectBtn', function() {
               
                alert(action);
                alert(applicantId);
                 var applicantId = $(this).data('id');
                var action = $(this).hasClass('consultancyapproveBtn') ? 'approve' : 'reject';

                if (action === 'approve') {
                    // Confirmation for approval
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to approve this Event?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Approve it!',
                        cancelButtonText: 'No, Cancel!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'approve.php',
                                method: 'POST',
                                data: {
                                    id: applicantId,
                                    action: action,
                                    data: 'consultancy',
                                    page: 'hod'
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Approved!',
                                            text: res.message
                                        }).then(() => {
                                            var table =   $('#consultancy_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
                                           
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
                        text: "Do you want to reject this Event?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Reject it!',
                        cancelButtonText: 'No, Cancel!'
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
                                            data: 'consultancy',
                                            page: 'hod'
                                        },
                                        dataType: 'json',
                                        success: function(res) {
                                            if (res.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Rejected!',
                                                    text: res.message
                                                }).then(() => {
                                                    var table =   $('#consultancy_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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


            $(document).on('click', '.iconsultancyapproveBtn, .iconsultancyrejectBtn', function() {
                var applicantId = $(this).data('id');
                var action = $(this).hasClass('iconsultancyapproveBtn') ? 'approve' : 'reject';

                if (action === 'approve') {
                    // Confirmation for approval
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to approve this Event?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Approve it!',
                        cancelButtonText: 'No, Cancel!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'approve.php',
                                method: 'POST',
                                data: {
                                    id: applicantId,
                                    action: action,
                                    data: 'iconsultancy',
                                    page: 'hod'
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Approved!',
                                            text: res.message
                                        }).then(() => {
                                            var table =   $('#iconsultancy_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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
                        text: "Do you want to reject this Event?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Reject it!',
                        cancelButtonText: 'No, Cancel!'
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
                                            data: 'iconsultancy',
                                            page: 'hod'
                                        },
                                        dataType: 'json',
                                        success: function(res) {
                                            if (res.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Rejected!',
                                                    text: res.message
                                                }).then(() => {
                                                    var table =   $('#iconsultancy_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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



            $(document).on('click', '.r_guideshipapproveBtn, .r_guideshiprejectBtn', function() {
                var applicantId = $(this).data('id');
                var action = $(this).hasClass('r_guideshipapproveBtn') ? 'approve' : 'reject';

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
                                    data: 'researchguideship',
                                    page: 'hod'
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Accepted!',
                                            text: res.message
                                        }).then(() => {
                                            var table =   $('#r_guideship_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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
                                            data: 'researchguideship',
                                            page: 'hod'
                                        },
                                        dataType: 'json',
                                        success: function(res) {
                                            if (res.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Rejected',
                                                    text: res.message
                                                }).then(() => {
                                                    var table =   $('#r_guideship_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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

            $(document).on('click', '.r_guidanceapproveBtn, .r_guidancerejectBtn', function() {
                var applicantId = $(this).data('id');
                var action = $(this).hasClass('r_guidanceapproveBtn') ? 'approve' : 'reject';

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
                                    data: 'activityr_guidance',
                                    page: 'hod'
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Accepted!',
                                            text: res.message
                                        }).then(() => {
                                            var table =   $('#r_guidance_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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
                                            data: 'activityr_guidance',
                                            page: 'hod'
                                        },
                                        dataType: 'json',
                                        success: function(res) {
                                            if (res.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Rejected',
                                                    text: res.message
                                                }).then(() => {
                                                    var table =   $('#r_guidance_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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


            $(document).on('click', '.certificateapproveBtn, .certificaterejectBtn', function() {
                var applicantId = $(this).data('id');
                var action = $(this).hasClass('certificateapproveBtn') ? 'approve' : 'reject';

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
                                    data: 'certificate',
                                    page: 'hod'
                                },
                                dataType: 'json',
                                success: function(res) {
                                    if (res.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Accepted!',
                                            text: res.message
                                        }).then(() => {
                                            var table =   $('#certificate_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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
                                            data: 'certificate',
                                            page: 'hod'
                                        },
                                        dataType: 'json',
                                        success: function(res) {
                                            if (res.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Rejected',
                                                    text: res.message
                                                }).then(() => {
                                                    var table =   $('#certificate_table').DataTable().ajax.reload(null, false);
                                            var row = table.row($(`button[data-id='${applicantId}']`).parents('tr'));
                                            row.remove().draw(false);
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

            // Handle click on "viewdocuments" button on reports tab
            $(document).on('click', '.viewBrochure_report', function() {
                var brochureUrl = $(this).data('event-brochure');

                $('#view_ModalLabel').text('Event Brochure');
                $('#view_ModalBody').html('<iframe src="' + brochureUrl + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
                $('#view_Modal').modal('show');
            });
            $(document).on('click', '.viewDocuments_reports', function() {
                var documentsUrl = $(this).data('documents1');

                $('#view_ModalLabel').text('Event Documents');
                $('#view_ModalBody').html('<iframe src="' + documentsUrl + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
                $('#view_Modal').modal('show');
            });
            $(document).on('click', '.viewFeedback_reports', function() {
                var feedback = $(this).data('feedback');

                $('#view_ModalLabel').text('Feedback');
                $('#view_ModalBody').html('<input type="text" class="form-control" value="' + feedback + '" readonly>');
                $('#view_Modal').modal('show');
            });


        });
    </script>
</body>

</html>