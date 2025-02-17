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
        body {
            min-height: 100vh;
            margin: 0 20px;
            background: var(--light-bg);
            overflow-x: hidden;
            padding-bottom: var(--footer-height);
            position: relative;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

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

        .form-label::after {
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
                    <li class="breadcrumb-item active" aria-current="page">Profile Information</li>
                </ol>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="container-fluid">
            

            <?php
            $query = "SELECT * FROM basic WHERE id='$s'";
            $query_run = mysqli_query($db, $query);
            $q = mysqli_query($db, $query);

            if (mysqli_num_rows($query_run) >= 0) {
                $student = mysqli_fetch_array($query_run);
                $m = $student;
            }
            ?>




            <!-- Nav tabs -->

            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="basic-tab" data-bs-toggle="tab" href="#home" role="tab">
                        <i class="fas fa-user tab-icon"></i> Basic
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link " id="academic-tab" data-bs-toggle="tab" href="#profile" role="tab">
                        <i class="fas fa-book tab-icon"></i>Academic Information
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="family-tab" data-bs-toggle="tab" href="#messages" role="tab">
                        <i class="fas fa-users tab-icon"></i> Family Details
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="parents-tab" data-bs-toggle="tab" href="#parents" role="tab">
                        <i class="fas fa-home tab-icon"></i> Parents Meeting
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="counselling-tab" data-bs-toggle="tab" href="#nominee" role="tab">
                        <i class="fas fa-clipboard-check tab-icon"></i> Counselling Details
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="medical-tab" data-bs-toggle="tab" href="#medical" role="tab">
                        <i class="fas fa-notes-medical tab-icon"></i>Medical Leave
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="swot-tab" data-bs-toggle="tab" href="#swot" role="tab">
                        <i class="fas fa-chart-bar tab-icon"></i>SWOT Analysis
                    </a>
                </li>
            </ul>

            <div class="tab-content tabcontent-border">

                <!-- tab 1 -->
                <div class="tab-pane active" id="home" role="tabpanel">
                    <?php
                    $query = "SELECT * FROM sbasic WHERE sid='$s'";
                    $query_run = mysqli_query($db, $query);
                    $q = mysqli_query($db, $query);

                    if (mysqli_num_rows($query_run) >= 0) {
                        $student = mysqli_fetch_array($query_run);
                        $m = $student;
                    }


                    ?>

                    <form id="basic" class="needs-validation" novalidate>
                        <div id="errorbasic" class="alert alert-warning d-none"></div>
                        <div class="card-header">
                            <h4>Personal Information </h4>
                        </div>
                        <!--name-->
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="validationCustom03" class="form-label">First name</label>
                                <input type="text" name="fname" class="form-control"
                                    id="validationCustom03" placeholder="First Name" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                                                echo $student['fname'];
                                                                                            } else {
                                                                                                echo "";
                                                                                            } ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom04" class="form-label">Last name</label>
                                <input type="text" class="form-control" name="lname"
                                    id="validationCustom04" placeholder="Last Name" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                                                echo $student['lname'];
                                                                                            } else {
                                                                                                echo "";
                                                                                            } ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label">Gender</label>
                                <select class="select2 form-control form-select"
                                    name="gender" value="<?php echo $student['gender']; ?>"
                                    id="validationCustom01" placeholder="First name" required>
                                    <option value="">Select</option>
                                    <option value="Male" <?php if ($student['gender'] == "Male")
                                                                echo 'selected="selected"'; ?>>Male</option>
                                    <option value="Female" <?php if ($student['gender'] == "Female")
                                                                echo 'selected="selected"'; ?>>Female</option>
                                    <option value="Transgender" <?php if ($student['gender'] == "Transgender")
                                                                    echo 'selected="selected"'; ?>>Transgender</option>
                                </select>

                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please select gender.
                                </div>
                            </div>
                        </div>
                        <!--Register number -->
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="validationCustom02" class="form-label">Register number </label>
                                <input type="text" class="form-control" name="id"
                                    id="validationCustom02" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['sid'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Enter your Register number" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustomUsername" class="form-label">Programme</label>
                                <div class="input-group">
                                    <select class="select2 form-control form-select" name="programme"
                                        style="width: 100%; height:36px;" required>
                                        <option value="">Select</option>
                                        <option value="Bachelor of Engineering(BE)" <?php if ($student['programme'] == "Bachelor of Engineering(BE)")
                                                                                        echo 'selected="selected"'; ?>>Bachelor of Engineering(BE)
                                        </option>
                                        <option value="Bachelor of Technology(B.Tech)" <?php if ($student['programme'] == "Bachelor of Technology(B.Tech)")
                                                                                            echo 'selected="selected"'; ?>>Bachelor of
                                            Technology(B.Tech)</option>
                                        <option value="Master of Business Administration(MBA)" <?php if ($student['programme'] == "Master of Business Administration(MBA)")
                                                                                                    echo 'selected="selected"'; ?>>Master
                                            of Business Administration(MBA)</option>
                                        <option value="Master of Computer Apllications(MCA)" <?php if ($student['programme'] == "Master of Computer Apllications(MCA)")
                                                                                                    echo 'selected="selected"'; ?>>Master of
                                            Computer Apllications(MCA)"</option>

                                    </select>

                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustomUsername" class="form-label">Department </label>
                                <div class="input-group">
                                    <select class="select2 form-control form-select" name="department"
                                        style="width: 100%; height:36px;" required>
                                        <option value="">Select</option>
                                        <?php include "get_departments.php"; ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <!--Date of Admission -->
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="validationCustom02" class="form-label">Date of Admission </label>
                                <input type="date" class="form-control" name="doadmission"
                                    id="validationCustom02" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['doadmission'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Date of Admission" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom02" class="form-label">Admission Category </label>
                                <select class="select2 form-control form-select"
                                    name="admcate" id="validationCustom01" placeholder="First name"
                                    required>
                                    <option value="">Select Type</option>
                                    <option value="Counselling" <?php if ($student['admcate'] == "Counselling")
                                                                    echo 'selected="selected"'; ?>>Counselling </option>
                                    <option value="Management" <?php if ($student['admcate'] == "Management")
                                                                    echo 'selected="selected"'; ?>>Management</option>

                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="validationCustom02" class="form-label">Admission Type </label>
                                <select class="select2 form-control form-select"
                                    name="admtype" id="validationCustom01" placeholder="First name"
                                    required>
                                    <option value="">Select Type</option>
                                    <option value="Regular" <?php if ($student['admtype'] == "Regular")
                                                                echo 'selected="selected"'; ?>>Regular </option>
                                    <option value="Lateral" <?php if ($student['admtype'] == "Lateral")
                                                                echo 'selected="selected"'; ?>>Lateral </option>
                                    <option value="Transfer" <?php if ($student['admtype'] == "Transfer")
                                                                    echo 'selected="selected"'; ?>>Transfer </option>
                                    <option value="Readmission" <?php if ($student['admtype'] == "Readmission")
                                                                    echo 'selected="selected"'; ?>>Readmission </option>

                                </select>
                            </div>


                        </div>

                        <!--batch -->
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="validationCustom02" class="form-label">Batch </label>
                                <input type="text" class="form-control" name="batch"
                                    id="validationCustom02" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['batch'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom02" class="form-label">DOB </label>
                                <input type="date" class="form-control" name="dob"
                                    id="validationCustom02" placeholder="DOB" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                                            echo $student['dob'];
                                                                                        } else {
                                                                                            echo "";
                                                                                        } ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label">Blood Group </label>
                                <select class="select2 form-control form-select"
                                    name="blood" id="validationCustom01" placeholder="First name"
                                    required>


                                    <option value="">Select Blood Group</option>
                                    <option value="A+VE" <?php if ($student['blood'] == "A+VE")
                                                                echo 'selected="selected"'; ?>>A+VE</option>
                                    <option value="A-VE" <?php if ($student['blood'] == "A-VE")
                                                                echo 'selected="selected"'; ?>>A-VE</option>
                                    <option value="B+VE" <?php if ($student['blood'] == "B+VE")
                                                                echo 'selected="selected"'; ?>>B+VE</option>
                                    <option value="B-VE" <?php if ($student['blood'] == "B-VE")
                                                                echo 'selected="selected"'; ?>>B-VE</option>
                                    <option value="O+VE" <?php if ($student['blood'] == "O+VE")
                                                                echo 'selected="selected"'; ?>>O+VE</option>
                                    <option value="O-VE" <?php if ($student['blood'] == "O-VE")
                                                                echo 'selected="selected"'; ?>>O-VE</option>
                                    <option value="AB+VE" <?php if ($student['blood'] == "AB+VE")
                                                                echo 'selected="selected"'; ?>>AB+VE</option>
                                    <option value="AB-VE" <?php if ($student['blood'] == "AB-VE")
                                                                echo 'selected="selected"'; ?>>AB-VE</option>
                                </select>


                            </div>
                        </div>
                        <!--Religion -->
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="validationCustomUsername" class="form-label">Religion </label>
                                <div class="input-group">
                                    <select class="select2 form-control form-select" name="religion"
                                        style="width: 100%; height:36px;" required>
                                        <option value="">Select</option>
                                        <option value="Buddhism" <?php if (isset($student['religion']) && $student['religion'] == "Buddhism")
                                                                        echo 'selected="selected"'; ?>>Buddhism</option>
                                        <option value="Christian" <?php if (isset($student['religion']) && $student['religion'] == "Christian")
                                                                        echo 'selected="selected"'; ?>>Christian</option>
                                        <option value="Hinduism" <?php if (isset($student['religion']) && $student['religion'] == "Hinduism")
                                                                        echo 'selected="selected"'; ?>>Hinduism</option>
                                        <option value="Islam" <?php if (isset($student['religion']) && $student['religion'] == "Islam")
                                                                    echo 'selected="selected"'; ?>>Islam</option>
                                        <option value="Jainism" <?php if (isset($student['religion']) && $student['religion'] == "Jainism")
                                                                    echo 'selected="selected"'; ?>>Jainism</option>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please choose a religion.
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label">Social Strata </label>
                                <select class="select2 form-control form-select"
                                    name="socstrata" id="validationCustom01" placeholder="First name"
                                    required>

                                    <option value="">Select</option>
                                    <option value="BC" <?php if (isset($student['social']) && $student['social'] == "BC")
                                                            echo 'selected="selected"'; ?>>BC</option>
                                    <option value="BCM" <?php if (isset($student['social']) && $student['social'] == "BCM")
                                                            echo 'selected="selected"'; ?>>BCM</option>
                                    <option value="MBC" <?php if (isset($student['social']) && $student['social'] == "MBC")
                                                            echo 'selected="selected"'; ?>>MBC</option>
                                    <option value="OC" <?php if (isset($student['social']) && $student['social'] == "OC")
                                                            echo 'selected="selected"'; ?>>OC</option>
                                    <option value="SS" <?php if (isset($student['social']) && $student['social'] == "SS")
                                                            echo 'selected="selected"'; ?>>SC / ST</option>
                                </select>

                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please select social strata.
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom02" class="form-label">Caste </label>
                                <input type="text" class="form-control" name="caste"
                                    id="validationCustom02" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['caste'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>"

                                    placeholder="Enter your caste" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please enter Caste.
                                </div>
                            </div>
                        </div>
                        <!--Nationality -->
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="validationCustom02" class="form-label">Nationality </label>
                                <input type="text" class="form-control" name="nationality"
                                    id="validationCustom02" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['nationality'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Enter Nationality" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label">First Graduate </label>
                                <select class="select2 form-control form-select"
                                    name="firstgra" id="validationCustom01"
                                    required>
                                    <option value="">Select</option>
                                    <option value="Yes" <?php if ($student['firstgra'] == "Yes")
                                                            echo 'selected="selected"'; ?>>Yes</option>
                                    <option value="No" <?php if ($student['firstgra'] == "No")
                                                            echo 'selected="selected"'; ?>>No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label">Educational Loan </label>
                                <select class="select2 form-control form-select"
                                    name="eduloan" id="validationCustom01"
                                    required>
                                    <option value="">Select</option>
                                    <option value="applicable" <?php if ($student['eduloan'] == "applicable")
                                                                    echo 'selected="selected"'; ?>>Applicable</option>
                                    <option value="not_applicable" <?php if ($student['eduloan'] == "not_applicable")
                                                                        echo 'selected="selected"'; ?>>Not Applicable</option>

                                </select>
                            </div>
                        </div>
                        <!--Scholarship -->
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="scholarship_category" class="form-label">Scholarship Type</label>
                                <select class="form-control" name="scholarship" id="scholarship_category" onchange="toggleScholarshipOptions()" required>
                                    <option value="">Select</option>
                                    <option value="government">Government</option>
                                    <option value="institution">Institution</option>
                                    <option value="ngo">NGO</option>
                                    <option value="general">General</option>
                                    <option value="nill">NILL</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="govtScholarship" style="display: none;">
                                <label for="govt_scholarship" class="form-label">Select Government Scholarship</label>
                                <select class="form-control" name="scholartype" id="govt_scholarship">
                                    <option value="">Select</option>
                                    <option value="pmms">PMMS</option>
                                    <option value="7.5">7.5%</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="instScholarship" style="display: none;">
                                <label for="inst_scholarship" class="form-label">Select Institution Scholarship</label>
                                <select class="form-control" name="scholartype" id="inst_scholarship">
                                    <option value="">Select</option>
                                    <option value="sports">Sports</option>
                                    <option value="je">JE</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="ngoScholarship" style="display: none;">
                                <label for="ngo_scholarship" class="form-label">Select NGO Scholarship</label>
                                <select class="form-control" name="scholartype" id="ngo_scholarship">
                                    <option value="">Select</option>
                                    <option value="csr">CSR</option>
                                    <option value="trust_fund">Trust Fund</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="genScholarship" style="display: none;">
                                <label for="gen_scholarship" class="form-label">Select General Scholarship</label>
                                <select class="form-control" name="scholartype" id="gen_scholarship">
                                    <option value="">Select</option>
                                    <option value="merit">Merit-Based</option>
                                    <option value="need">Need-Based</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <!-- NEET/JEE Exam Status -->

                            <div class="form-group col-md-4">
                                <label for="exam_status" class="form-label">Clear NEET/JEE</label>
                                <select class="form-control" name="exam_status" id="exam_status" onchange="document.getElementById('markField').style.display = (this.value === 'NEET' || this.value === 'JEE') ? 'block' : 'none';" required>
                                    <option value="">Select</option>
                                    <option value="NEET">NEET</option>
                                    <option value="JEE">JEE</option>
                                    <option value="NILL">NILL</option>
                                </select>
                            </div>

                            <!-- Hidden Mark Input Field -->
                            <div class="form-group col-md-4" id="markField" style="display: none;">
                                <label for="exam_mark" class="form-label">Enter Mark</label>
                                <input type="text" name="exam_mark" id="exam_mark" class="form-control">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label">Cut-Off Mark</label>
                                <input type="text" class="form-control" name="cutoff"
                                    id="validationCustom01" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['cutoff'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Enter Cut-Off Mark" required>
                            </div>

                        </div>

                        <!--Mobile Number-->
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" name="mobile"
                                    id="validationCustom01" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['mobile'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Enter Mobile Number" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label">Personal Mail_Id </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="email"
                                        id="validationCustom01" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                            echo $student['email'];
                                                                        } else {
                                                                            echo "";
                                                                        } ?>" placeholder="Enter Email ID" required>

                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label">Offical Mail_Id </label>
                                <input type="text" class="form-control" name="offemail"
                                    id="validationCustom01" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['offemail'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Enter Offical Email ID" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label">Parent Mobile Number </label>
                                <input type="text" class="form-control" name="pmobile"
                                    id="validationCustom01" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['pmobile'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Enter Mobile Number" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label"> EMIS No </label>
                                <input type="text" class="form-control" name="emis"
                                    id="validationCustom01" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['emis'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Enter EMIS Number" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label">UMIS No </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="umis"
                                        id="validationCustom01" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                            echo $student['umis'];
                                                                        } else {
                                                                            echo "";
                                                                        } ?>" placeholder="Enter UMIS Number" required>

                                </div>
                            </div>

                        </div>
                        <!--Languages known class="form-label"-->
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label">Languages known </label>
                                <input type="text" class="form-control" name="language"
                                    id="validationCustom01" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['languages'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Enter Languages known" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label">Aadhar Number </label>
                                <input type="text" class="form-control" name="aadhar"
                                    id="validationCustom01" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['aadhar'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Enter Aadhar Number" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label">Pan Number </label>
                                <input type="text" class="form-control" name="pan"
                                    id="validationCustom01" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['pan'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Enter Pan Number" required>
                            </div>
                        </div>
                        <!--Hostel or dayscholor-->

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label">Physical Identification 1</label>
                                <input type="text" class="form-control" name="phyident1" id="validationCustom01" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                                                                            echo $student['phyident1'];
                                                                                                                        } else {
                                                                                                                            echo "";
                                                                                                                        } ?>" required
                                    placeholder="Enter Physical Identification Mark 1">
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter Physical Identification Mark 1.</div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom01" class="form-label">Physical Identification 2</label>
                                <input type="text" class="form-control" name="phyident2" id="validationCustom01" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                                                                            echo $student['phyident2'];
                                                                                                                        } else {
                                                                                                                            echo "";
                                                                                                                        } ?>" required
                                    placeholder="Enter Physical Identification Mark 2">
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter Physical Identification Mark 2.</div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="status" class="form-label">Hosteller/Dayscholar</label>
                                <select class="form-control custom-select" name="hosday" id="status" onchange="toggleFields()">
                                    <option value="">Select</option>
                                    <option value="Hosteller" <?php if ($student['hosday'] == "Hosteller") echo 'selected="selected"'; ?>>Hosteller</option>
                                    <option value="Dayscholar" <?php if ($student['hosday'] == "Dayscholar") echo 'selected="selected"'; ?>>Dayscholar</option>
                                </select>
                            </div>
                        </div>

                        <!-- Dayscholar Fields -->
                        <div class="row">
                            <div class="form-group col-md-4" id="transportField" style="display: none;">
                                <label for="transport_mode" class="form-label">Mode of Transportation</label>
                                <select name="transport_mode" class="select2 form-control custom-select" id="transport_mode">
                                    <option value="">Select Mode</option>
                                    <option value="Own Vehicle" <?php if (isset($student['transport_mode']) && $student['transport_mode'] == "Own Vehicle") echo 'selected="selected"'; ?>>Own Vehicle</option>
                                    <option value="Public Transport" <?php if (isset($student['transport_mode']) && $student['transport_mode'] == "Public Transport") echo 'selected="selected"'; ?>>Public Transport</option>
                                    <option value="College Bus" <?php if (isset($student['transport_mode']) && $student['transport_mode'] == "College Bus") echo 'selected="selected"'; ?>>College Bus</option>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please select mode of transportation.</div>
                            </div>

                            <div class="form-group col-md-4" id="boardingField" style="display: none;">
                                <label for="boarding_point" class="form-label">Boarding Point</label>
                                <input type="text" name="stay" class="form-control" id="boarding_point"
                                    placeholder="Enter Boarding Point" value="<?php echo (isset($student['stay'])) ? $student['stay'] : ""; ?>">
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter boarding point.</div>
                            </div>

                            <div class="form-group col-md-4" id="busNo" style="display: none;">
                                <label for="bus_no" class="form-label">Bus Number</label>
                                <input type="text" name="busno" class="form-control" id="bus_no"
                                    placeholder="Enter Bus Number" value="<?php echo (isset($student['bus_no'])) ? $student['bus_no'] : ""; ?>">
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter bus number.</div>
                            </div>
                        </div>

                        <!-- Hosteller Fields -->
                        <div class="row">
                            <div class="form-group col-md-4" id="hostelContainer" style="display: none;">
                                <label for="hostel_name" class="form-label">Hostel</label>
                                <select name="hosname" class="select2 form-control custom-select" id="hostel_name">
                                    <option value="">Select Hostel</option>
                                    <option value="Vedha" <?php if (isset($student['hostel_name']) && $student['hostel_name'] == "Vedha") echo 'selected="selected"'; ?>>Vedha</option>
                                    <option value="Octa" <?php if (isset($student['hostel_name']) && $student['hostel_name'] == "Octa") echo 'selected="selected"'; ?>>Octa</option>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please select hostel.</div>
                            </div>

                            <div class="form-group col-md-4" id="roomField" style="display: none;">
                                <label for="room" class="form-label">Room No</label>
                                <input type="text" name="room" class="form-control" id="room_no"
                                    placeholder="Enter Room Number" value="<?php echo (isset($student['room'])) ? $student['room'] : ""; ?>">
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter room number.</div>
                            </div>
                        </div>

                        <!--address-->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="validationCustom03" class="form-label">Permanent Address </label>
                                <input type="text" class="form-control" name="paddress"
                                    id="validationCustom03" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['paddress'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Permanent Address" required>

                            </div>
                            <div class="form-group col-md-6">
                                <label for="validationCustom04" class="form-label">Temporary Address </label>
                                <input type="text" class="form-control" name="taddress"
                                    id="validationCustom04" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['taddress'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Temporary Address" required>

                            </div>

                        </div>
                        <!--State -->
                        <div class="row">

                            <div class="form-group col-md-3">
                                <label for="validationCustom04" class="form-label">State </label>
                                <select class="select2 form-control custom-select" name="state"
                                    id="inputState" required>
                                    <option value="">Select State</option>
                                    <option value="Andra Pradesh">Andra Pradesh</option>
                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                    <option value="Assam">Assam</option>
                                    <option value="Bihar">Bihar</option>
                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                    <option value="Goa">Goa</option>
                                    <option value="Gujarat">Gujarat</option>
                                    <option value="Haryana">Haryana</option>
                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                    <option value="Jharkhand">Jharkhand</option>
                                    <option value="Karnataka">Karnataka</option>
                                    <option value="Kerala">Kerala</option>
                                    <option value="Madya Pradesh">Madya Pradesh</option>
                                    <option value="Maharashtra">Maharashtra</option>
                                    <option value="Manipur">Manipur</option>
                                    <option value="Meghalaya">Meghalaya</option>
                                    <option value="Mizoram">Mizoram</option>
                                    <option value="Nagaland">Nagaland</option>
                                    <option value="Orissa">Orissa</option>
                                    <option value="Punjab">Punjab</option>
                                    <option value="Rajasthan">Rajasthan</option>
                                    <option value="Sikkim">Sikkim</option>
                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                    <option value="Telangana">Telangana</option>
                                    <option value="Tripura">Tripura</option>
                                    <option value="Uttaranchal">Uttaranchal</option>
                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                    <option value="West Bengal">West Bengal</option>
                                    <option disabled style="background-color:#aaa; color:#fff">UNION
                                        Territories</option>
                                    <option value="Andaman and Nicobar Islands">Andaman and Nicobar
                                        Islands</option>
                                    <option value="Chandigarh">Chandigarh</option>
                                    <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli
                                    </option>
                                    <option value="Daman and Diu">Daman and Diu</option>
                                    <option value="Delhi">Delhi</option>
                                    <option value="Lakshadeep">Lakshadeep</option>
                                    <option value="Pondicherry">Pondicherry</option>
                                </select>

                            </div>


                            <div class="form-group col-md-3">
                                <label for="validationCustom04" class="form-label">City </label>
                                <select class="select2 form-control custom-select" name="city"
                                    id="inputDistrict" required>
                                    <option value="">-- select one -- </option>
                                </select>

                            </div>

                            <div class="form-group col-md-3">
                                <label for="validationCustom05" class="form-label">Zip </label>
                                <input type="text" class="form-control" name="zip"
                                    id="validationCustom05" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['zip'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Zip" required>

                            </div>
                            <div class="form-group col-md-3">
                                <label for="validationCustom05" class="form-label">Country </label>
                                <select class="select2 form-control custom-select" id="country"
                                    name="country" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Åland Islands">Åland Islands</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="American Samoa">American Samoa</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Anguilla">Anguilla</option>
                                    <option value="Antarctica">Antarctica</option>
                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                    <option value="Argentina">Argentina</option>
                                    <option value="Armenia">Armenia</option>
                                    <option value="Aruba">Aruba</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                    <option value="Azerbaijan">Azerbaijan</option>
                                    <option value="Bahamas">Bahamas</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="Barbados">Barbados</option>
                                    <option value="Belarus">Belarus</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Belize">Belize</option>
                                    <option value="Benin">Benin</option>
                                    <option value="Bermuda">Bermuda</option>
                                    <option value="Bhutan">Bhutan</option>
                                    <option value="Bolivia">Bolivia</option>
                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina
                                    </option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Bouvet Island">Bouvet Island</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="British Indian Ocean Territory">British Indian Ocean
                                        Territory</option>
                                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Cape Verde">Cape Verde</option>
                                    <option value="Cayman Islands">Cayman Islands</option>
                                    <option value="Central African Republic">Central African Republic
                                    </option>
                                    <option value="Chad">Chad</option>
                                    <option value="Chile">Chile</option>
                                    <option value="China">China</option>
                                    <option value="Christmas Island">Christmas Island</option>
                                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands
                                    </option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Comoros">Comoros</option>
                                    <option value="Congo">Congo</option>
                                    <option value="Congo, The Democratic Republic of The">Congo, The
                                        Democratic Republic of The</option>
                                    <option value="Cook Islands">Cook Islands</option>
                                    <option value="Costa Rica">Costa Rica</option>
                                    <option value="Cote D'ivoire">Cote D'ivoire</option>
                                    <option value="Croatia">Croatia</option>
                                    <option value="Cuba">Cuba</option>
                                    <option value="Cyprus">Cyprus</option>
                                    <option value="Czech Republic">Czech Republic</option>
                                    <option value="Denmark">Denmark</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Dominica">Dominica</option>
                                    <option value="Dominican Republic">Dominican Republic</option>
                                    <option value="Ecuador">Ecuador</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="El Salvador">El Salvador</option>
                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                    <option value="Eritrea">Eritrea</option>
                                    <option value="Estonia">Estonia</option>
                                    <option value="Ethiopia">Ethiopia</option>
                                    <option value="Falkland Islands (Malvinas)">Falkland Islands
                                        (Malvinas)</option>
                                    <option value="Faroe Islands">Faroe Islands</option>
                                    <option value="Fiji">Fiji</option>
                                    <option value="Finland">Finland</option>
                                    <option value="France">France</option>
                                    <option value="French Guiana">French Guiana</option>
                                    <option value="French Polynesia">French Polynesia</option>
                                    <option value="French Southern Territories">French Southern
                                        Territories</option>
                                    <option value="Gabon">Gabon</option>
                                    <option value="Gambia">Gambia</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Gibraltar">Gibraltar</option>
                                    <option value="Greece">Greece</option>
                                    <option value="Greenland">Greenland</option>
                                    <option value="Grenada">Grenada</option>
                                    <option value="Guadeloupe">Guadeloupe</option>
                                    <option value="Guam">Guam</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Guernsey">Guernsey</option>
                                    <option value="Guinea">Guinea</option>
                                    <option value="Guinea-bissau">Guinea-bissau</option>
                                    <option value="Guyana">Guyana</option>
                                    <option value="Haiti">Haiti</option>
                                    <option value="Heard Island and Mcdonald Islands">Heard Island and
                                        Mcdonald Islands</option>
                                    <option value="Holy See (Vatican City State)">Holy See (Vatican City
                                        State)</option>
                                    <option value="Honduras">Honduras</option>
                                    <option value="Hong Kong">Hong Kong</option>
                                    <option value="Hungary">Hungary</option>
                                    <option value="Iceland">Iceland</option>
                                    <option value="India">India</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Iran, Islamic Republic of">Iran, Islamic Republic of
                                    </option>
                                    <option value="Iraq">Iraq</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Isle of Man">Isle of Man</option>
                                    <option value="Israel">Israel</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Jersey">Jersey</option>
                                    <option value="Jordan">Jordan</option>
                                    <option value="Kazakhstan">Kazakhstan</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Kiribati">Kiribati</option>
                                    <option value="Korea, Democratic People's Republic of">Korea,
                                        Democratic People's Republic of</option>
                                    <option value="Korea, Republic of">Korea, Republic of</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                    <option value="Lao People's Democratic Republic">Lao People's
                                        Democratic Republic</option>
                                    <option value="Latvia">Latvia</option>
                                    <option value="Lebanon">Lebanon</option>
                                    <option value="Lesotho">Lesotho</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya
                                    </option>
                                    <option value="Liechtenstein">Liechtenstein</option>
                                    <option value="Lithuania">Lithuania</option>
                                    <option value="Luxembourg">Luxembourg</option>
                                    <option value="Macao">Macao</option>
                                    <option value="Macedonia, The Former Yugoslav Republic of">
                                        Macedonia, The Former Yugoslav Republic of</option>
                                    <option value="Madagascar">Madagascar</option>
                                    <option value="Malawi">Malawi</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Maldives">Maldives</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Malta">Malta</option>
                                    <option value="Marshall Islands">Marshall Islands</option>
                                    <option value="Martinique">Martinique</option>
                                    <option value="Mauritania">Mauritania</option>
                                    <option value="Mauritius">Mauritius</option>
                                    <option value="Mayotte">Mayotte</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Micronesia, Federated States of">Micronesia,
                                        Federated States of</option>
                                    <option value="Moldova, Republic of">Moldova, Republic of</option>
                                    <option value="Monaco">Monaco</option>
                                    <option value="Mongolia">Mongolia</option>
                                    <option value="Montenegro">Montenegro</option>
                                    <option value="Montserrat">Montserrat</option>
                                    <option value="Morocco">Morocco</option>
                                    <option value="Mozambique">Mozambique</option>
                                    <option value="Myanmar">Myanmar</option>
                                    <option value="Namibia">Namibia</option>
                                    <option value="Nauru">Nauru</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="Netherlands">Netherlands</option>
                                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                                    <option value="New Caledonia">New Caledonia</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Nicaragua">Nicaragua</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="Niue">Niue</option>
                                    <option value="Norfolk Island">Norfolk Island</option>
                                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                    <option value="Norway">Norway</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palau">Palau</option>
                                    <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                    <option value="Panama">Panama</option>
                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                    <option value="Paraguay">Paraguay</option>
                                    <option value="Peru">Peru</option>
                                    <option value="Philippines">Philippines</option>
                                    <option value="Pitcairn">Pitcairn</option>
                                    <option value="Poland">Poland</option>
                                    <option value="Portugal">Portugal</option>
                                    <option value="Puerto Rico">Puerto Rico</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Reunion">Reunion</option>
                                    <option value="Romania">Romania</option>
                                    <option value="Russian Federation">Russian Federation</option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="Saint Helena">Saint Helena</option>
                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                    <option value="Saint Lucia">Saint Lucia</option>
                                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                    <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                                    <option value="Samoa">Samoa</option>
                                    <option value="San Marino">San Marino</option>
                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="Serbia">Serbia</option>
                                    <option value="Seychelles">Seychelles</option>
                                    <option value="Sierra Leone">Sierra Leone</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Slovakia">Slovakia</option>
                                    <option value="Slovenia">Slovenia</option>
                                    <option value="Solomon Islands">Solomon Islands</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Sri Lanka">Sri Lanka</option>
                                    <option value="Sudan">Sudan</option>
                                    <option value="Suriname">Suriname</option>
                                    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen </option>
                                    <option value="Swaziland">Swaziland</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                    <option value="Taiwan">Taiwan</option>
                                    <option value="Tajikistan">Tajikistan</option>
                                    <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Timor-leste">Timor-leste</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Tokelau">Tokelau</option>
                                    <option value="Tonga">Tonga</option>
                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                    <option value="Tunisia">Tunisia</option>
                                    <option value="Turkey">Turkey</option>
                                    <option value="Turkmenistan">Turkmenistan</option>
                                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                    <option value="Tuvalu">Tuvalu</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States">United States</option>
                                    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                    <option value="Uruguay">Uruguay</option>
                                    <option value="Uzbekistan">Uzbekistan</option>
                                    <option value="Vanuatu">Vanuatu</option>
                                    <option value="Venezuela">Venezuela</option>
                                    <option value="Viet Nam">Viet Nam</option>
                                    <option value="Virgin Islands, British">Virgin Islands, British</option>
                                    <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                    <option value="Wallis and Futuna">Wallis and Futuna</option>
                                    <option value="Western Sahara">Western Sahara</option>
                                    <option value="Yemen">Yemen</option>
                                    <option value="Zambia">Zambia</option>
                                    <option value="Zimbabwe">Zimbabwe</option>
                                </select>

                            </div>
                        </div>
                        <!-- Guardian Fields -->
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="validationCustom03" class="form-label">Guardian Name </label>
                                <input type="text" class="form-control" name="guarname"
                                    id="validationCustom03" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['guarname'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Guardian Name " required>

                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom04" class="form-label">Guardian Phone No </label>
                                <input type="text" class="form-control" name="guarmobile"
                                    id="validationCustom04" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['guarmobile'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Guardian Phone No" required>

                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationCustom03" class="form-label">Guardian Address </label>
                                <input type="text" class="form-control" name="guaraddress"
                                    id="validationCustom03" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                        echo $student['guaraddress'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?>" placeholder="Guardian Address" required>

                            </div>

                        </div>
                        <!--Photo -->
                        <div class="row">
                            <!--profile photo-->
                            <div class="form-group col-md-4">
                                <label for="validationCustomUsername" class="form-label">Profile Photo</label>
                                <div class="input-group">
                                    <input type="file" class="form-control"
                                        name="pphoto" id="validationCustomUsername"
                                        onchange="return fileValidation()" placeholder="Username"
                                        aria-describedby="inputGroupPrepend" required>
                                    <label class="custom-file-label" for="customFile"></label>

                                </div>
                            </div>

                            <!--father pic-->
                            <div class="form-group col-md-4">
                                <label for="validationCustomUsername2" class="form-label">Father's Photo</label>
                                <div class="input-group">
                                    <input type="file" class="form-control"
                                        name="fphoto" id="validationCustomUsername2"
                                        onchange="return fileValidation3()" placeholder="Username"
                                        aria-describedby="inputGroupPrepend" required>
                                    <label class="custom-file-label" for="customFile"></label>

                                </div>
                            </div>



                            <!--mother pic-->

                            <div class="form-group col-md-4">
                                <label for="validationCustomUsername3" class="form-label">Mother's Photo</label>
                                <div class="input-group">
                                    <input type="file" class="form-control"
                                        name="mphoto" id="validationCustomUsername3"
                                        onchange="return fileValidation4()" placeholder="Username"
                                        aria-describedby="inputGroupPrepend" required>
                                    <label class="custom-file-label" for="customFile"></label>

                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="validationCustomUsername" class="form-label">Guardian Photo</label>
                                <div class="input-group">
                                    <input type="file" class="form-control"
                                        name="gphoto" id="validationCustomUsername"
                                        onchange="return fileValidation()" placeholder="Username"
                                        aria-describedby="inputGroupPrepend" required>
                                    <label class="custom-file-label" for="customFile"></label>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="validationCustomUsername" class="form-label">Aadhar Photo</label>
                                <div class="input-group">
                                    <input type="file" class="form-control"
                                        name="saadhar" id="validationCustomUsername"
                                        onchange="return fileValidation()" placeholder="Username"
                                        aria-describedby="inputGroupPrepend" required>
                                    <label class="custom-file-label" for="customFile"></label>

                                </div>
                            </div>


                            <div class="form-group col-md-4">
                                <label for="validationCustomUsername2" class="form-label">Pan Photo</label>
                                <div class="input-group">
                                    <input type="file" class="form-control"
                                        name="span" id="validationCustomUsername2"
                                        onchange="return fileValidation3()" placeholder="Username"
                                        aria-describedby="inputGroupPrepend" required>
                                    <label class="custom-file-label" for="customFile"></label>

                                </div>
                            </div>
                        </div>

                        <br>
                        <?php
                        if ($student['status'] == 0) {
                        ?>
                            <button class="btn btn-primary" type="submit">Submit</button> <button
                                type="button" value="<?= $student['sid']; ?>"
                                class="apppcBtn btn btn-success">Approve</button>
                        <?php
                        }
                        ?>
                    </form>

                </div>

                <!-- tab2 -->
                <!-- Academic details Tab Starts -->

                <div class="tab-pane  p-20" id="profile" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" style="border: none;">
                                <div class="card-header" style="border: none;">
                                    <h4>
                                        <button type="button" style="float: right;"
                                            class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#studentAcademic">
                                            Add details
                                        </button>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="myTable" class="table table-bordered table-striped">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>Course</b></th>
                                                    <th><b>Institution Name</b></th>
                                                    <th><b>Board/University</b></th>
                                                    <th><b>Year of Passing</b></th>
                                                    <th><b>Percentage/CGPA</b></th>
                                                    <th><b>Certificate </b></th>
                                                    <th><b>Action</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php


                                                $query = "SELECT * FROM sacademic where sid='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    foreach ($query_run as $student) {
                                                ?>
                                                        <tr>
                                                            <td align="center"><?= $student['course'] ?></td>
                                                            <td><?= $student['iname'] ?></td>
                                                            <td align="center"><?= $student['board'] ?></td>
                                                            <td align="center"><?= $student['yc'] ?></td>

                                                            <td align="center"><?= $student['score'] ?></td>
                                                            <td align="center"><img
                                                                    src="images/icon/certificate.png"
                                                                    class="action-icon btnimg" alt="View"
                                                                    data-action="cert"
                                                                    data-student-id="<?= $student['uid']; ?>"
                                                                    title="View Certificate"
                                                                    style="cursor: pointer;">


                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                    value="<?= $student['uid']; ?>"
                                                                    class="editStudentBtn btn btn-warning btn-sm">Edit</button>
                                                                <button type="button"
                                                                    value="<?= $student['uid']; ?>"
                                                                    class="deleteStudentBtn btn btn-danger btn-sm">Delete</button>
                                                            </td>
                                                        </tr>
                                                <?php
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

                <!-- tab3 -->
                <div class="tab-pane p-20" id="messages" role="tabpanel">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" style="border: none;">
                                <div class="card-header" style="border: none;">
                                    <h4>
                                        <button type="button" style="float: right;"
                                            class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#familyadd">
                                            Add Family Members
                                        </button>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="myTable1" class="table table-bordered table-striped">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>S.No</b></th>
                                                    <th><b>Name</b></th>
                                                    <th><b>Relationship</b></th>
                                                    <th><b>Occupation</b></th>
                                                    <th><b>Organization</b></th>
                                                    <th><b>Mobile Number</b></th>
                                                    <th align="center"><b>Action</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php


                                                $query = "SELECT * FROM sfamily where sid='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    $sss = 1;
                                                    foreach ($query_run as $student) {

                                                ?>
                                                        <tr>
                                                            <td align="center"><?= $sss ?></td>
                                                            <td><?= $student['name'] ?></td>
                                                            <td align="center"><?= $student['relationship'] ?>
                                                            </td>
                                                            <td align="center"><?= $student['occu'] ?></td>
                                                            <td align="center"><?= $student['org'] ?></td>
                                                            <td align="center"><?= $student['mobile'] ?></td>
                                                            <td align="center">
                                                                <button type="button"
                                                                    value="<?= $student['uid']; ?>"
                                                                    class="editfamilyBtn btn btn-warning btn-sm">Edit</button>
                                                                <button type="button"
                                                                    value="<?= $student['uid']; ?>"
                                                                    class="deletefamilyBtn btn btn-danger btn-sm">Delete</button>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        $sss = $sss + 1;
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

                <!-- tab4 -->
                <div class="tab-pane p-20" id="parents" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" style="border: none;">
                                <div class="card-header" style="border: none;">
                                    <h4>
                                        <button type="button" style="float: right;"
                                            class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#studentAddParentMeetingDetails">
                                            Add details
                                        </button>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="myTable30"
                                            class="table table-bordered table-striped">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>Date</b></th>
                                                    <th><b>Purpose of Meeting</b></th>
                                                    <th><b>Points Discussed</b></th>
                                                    <th><b>Action</b></th>
                                                    <th><b>Status</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php


                                                $query = "SELECT * FROM parentmeeting where sid='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    foreach ($query_run as $student) {
                                                ?>
                                                        <tr>
                                                            <td><?= $student['datee'] ?></td>
                                                            <td><?= $student['purpose'] ?></td>
                                                            <td><?= $student['suggestion'] ?></td>
                                                            <td>
                                                                <?php
                                                                if ($student['status'] == 0) {
                                                                ?>

                                                                    <button type="submit"
                                                                        value="<?= $student['uid']; ?>"
                                                                        class="updateSBtn btn btn-success btn-md m-r-5">Update</button>
                                                                    <button type="submit"
                                                                        value="<?= $student['uid']; ?>"
                                                                        class="deleteSBtn btn btn-danger btn-md m-l-5">Delete</button>

                                                                <?php
                                                                } else {
                                                                    if ($student['status'] == 1) {
                                                                        echo "Approved on " . $student['adate'];
                                                                    }
                                                                }
                                                                ?>
                                                            </td>




                                                            <td><?php if ($student['status'] == 0): ?>
                                                                    <span class="btn btn-warning">Pending</span>
                                                                <?php elseif ($student['status'] == 1): ?>
                                                                    <span class="btn btn-success">Approved</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                <?php

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

                <!-- tab5 -->
                <div class="tab-pane p-20" id="nominee" role="tabpanel">
                    <div class="row">
                        <div class="col -md-12">
                            <div class="card" style="border: none;">
                                <div class="card-header" style="border: none;">
                                    <h4>

                                        <button type="button" style="float: right;"
                                            class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#mod">
                                            Add Counselling Details
                                        </button>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="myTablec" class="table table-bordered table-striped">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>S.No</b></th>
                                                    <th><b>Date</b></th>
                                                    <th><b>Point Discussed</b></th>
                                                    <th><b>Suggestion Given</b></th>
                                                    <th><b>Action</b></th>
                                                    <th><b>Status</b></th>
                                                </tr>
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
                                                            <td>
                                                                <?php
                                                                if ($student['adate'] == "") {
                                                                ?>
                                                                    <button type="submit"
                                                                        value="<?= $student['uid']; ?>"
                                                                        class="deletedetails btn btn-danger btn-sm m-l-5">Delete</button>
                                                                <?php
                                                                } else if ($student['status'] == 2) {
                                                                    echo "Forwared to HOD on " . $student['adate'] . " by " . $student['aname'];
                                                                } else if ($student['status'] == 3) {
                                                                    echo "Forwared to Principal on " . $student['adate'] . " by " . $student['aname'];
                                                                } else {
                                                                    echo "Approved on " . $student['adate'] . " by " . $student['aname'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php if ($student['status'] == 0): ?>
                                                                    <span
                                                                        class="btn btn-warning btn-sm">Pending</span>

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
                    </div>



                </div>

                <!-- tab6 -->
                <div class="tab-pane p-20" id="medical" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" style="border: none;">
                                <div class="card-header" style="border: none;">
                                    <h4>

                                        <button type="button" style="float: right;"
                                            class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#smmedical">
                                            Add Medical Leave Details
                                        </button>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="smedic" class="table table-bordered table-striped">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>S.No</b></th>
                                                    <th><b>From</b></th>
                                                    <th><b>To</b></th>
                                                    <th><b>Total Days</b></th>
                                                    <th><b>Reason</b></th>
                                                    <th><b>View</b></th>
                                                    <th><b>Action</b></th>
                                                    <th><b>Status</b></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT * FROM smedical where sid='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    $sss = 1;
                                                    foreach ($query_run as $student) {

                                                ?>
                                                        <tr>
                                                            <td><?= $sss ?></td>
                                                            <td><?= $student['fdate'] ?></td>
                                                            <td><?= $student['tdate'] ?></td>
                                                            <td><?= $student['tdays'] ?></td>
                                                            <td><?= $student['reason'] ?></td>
                                                            <td align="center"><button type="button"
                                                                    id="ledonof" value="<?= $student['uid']; ?>"
                                                                    class="btnsmedi btn-success btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#studentViewModalms">View</button>
                                                            </td>

                                                            <td>
                                                                <?php
                                                                if ($student['status'] == 1) {
                                                                    echo "Approved on " . $student['adate'];
                                                                } else if ($student['status'] == 2) {
                                                                    echo "Forwarded on " . $student['adate'];
                                                                } else if ($student['status'] == 3) {
                                                                    echo "Rejected on " . $student['adate'];
                                                                }

                                                                ?>
                                                            </td>

                                                            <td><?php if ($student['status'] == 0): ?>

                                                                    <button type="button"
                                                                        value="<?= $student['uid']; ?>"
                                                                        class="deletesmBtn btn btn-danger btn-sm">Delete</button>
                                                                    <span
                                                                        class="btn btn-warning btn-sm">Pending</span>

                                                                <?php elseif ($student['status'] == 1): ?>
                                                                    <span class="btn btn-primary">Approved by
                                                                        HOD</span>
                                                                <?php elseif ($student['status'] == 2): ?>
                                                                    <span class="btn btn-primary">Forwarded to
                                                                        HOD</span>
                                                                <?php elseif ($student['status'] == 3): ?>
                                                                    <span class="btn btn-danger">Rejected</span>
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
                    </div>
                </div>

                <!-- tab7 -->
                <div class="tab-pane p-20" id="swot" role="tabpanel">
                    <?php
                    $query = "SELECT * FROM sbasic WHERE sid='$s'";
                    $query_run = mysqli_query($db, $query);

                    if (mysqli_num_rows($query_run) >= 0) {
                        $student = mysqli_fetch_array($query_run);
                    }


                    ?>

                    <form id="swot" class="needs-validation" novalidate>
                        <div id="swotmsg" class="alert alert-warning d-none"></div>

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="validationCustom01" class="form-label">Strengths</label>
                                <input type="text" name="Strengths" class="form-control"
                                    id="validationCustom01" placeholder="Strengths" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                                                echo $student['Strengths'];
                                                                                            } else {
                                                                                                echo "";
                                                                                            } ?>">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="validationCustom02" class="form-label">Weaknesses</label>
                                <input type="text" class="form-control" name="Weaknesses"
                                    id="validationCustom02" placeholder="Weaknesses" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                                                echo $student['Weaknesses'];
                                                                                            } else {
                                                                                                echo "";
                                                                                            } ?>">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="validationCustom02" class="form-label">Opportunities</label>
                                <input type="text" class="form-control" name="Opportunities"
                                    id="validationCustom02" placeholder="Opportunities" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                                                    echo $student['Opportunities'];
                                                                                                } else {
                                                                                                    echo "";
                                                                                                } ?>">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="validationCustom02" class="form-label">Threats</label>
                                <input type="text" class="form-control" name="Threats"
                                    id="validationCustom02" placeholder="Threats" value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                                                                echo $student['Threats'];
                                                                                            } else {
                                                                                                echo "";
                                                                                            } ?>">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>

                        </div>
                        <div class="form-row">

                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>

                    </form>

                </div>

            </div>

        </div>
        <!-- Footer -->
        <?php include 'footer.php'; ?>
    </div>

    <div class="modal fade" id="studentViewModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="image" src="" alt="Certificate Preview" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Student academic -->
    <div class="modal fade" id="studentAcademic" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong> Add Academic Details</strong> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="sacademic">
                    <div class="modal-body">

                        <div id="errorsacademic" class="alert alert-warning d-none">
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Course</label>
                            <select class="form-control" name="course" id="course"
                                onchange="toggleDivVisibility()" required>
                                <option value="">Select Course</option>
                                <option value="SSLC">SSLC</option>
                                <option value="HSC">HSC</option>
                                <option value="ITI">ITI</option>
                                <option value="DIPLOMA">DIPLOMA</option>
                                <option value="UG">UG</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="validationCustom03" class="form-label">Degree </label>
                            <select class="form-control" name="degree" id="degree"
                                required>
                                <option value="">Select Degree</option>
                            </select>
                        </div>

                        <div class="mb-3" id="spec" style="display: none;">
                            <label for="" class="form-label">Specialization / Branch </label>
                            <input type="text" name="branch" id="branch"
                                class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Institution Name </label>
                            <input type="text" name="iname" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Board/University </label>
                            <input type="text" name="univ" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Medium of Study </label>
                            <input type="text" name="mes" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Year of Completion </label>
                            <input type="text" name="yc" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Place of Institution </label>
                            <input type="text" name="pins" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Percentage (%)/CGPA</label>
                            <input type="text" name="score" class="form-control" />
                        </div>




                        <div class="mb-3">
                            <label for="" class="form-label">Certificate</label>
                            <label for="">(upload less than 2 mb)</label>
                            <div class="input-group">
                                <input type="file"
                                    class="form-control" name="cert"
                                    id="uploadFile2"
                                    onchange="return fileValidationcert()"
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


                    <div id="test"> </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="studentEditModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateStudent">
                    <div class="modal-body">

                        <div id="errorMessageUpdate" class="alert alert-warning d-none">
                        </div>

                        <input type="hidden" name="student_id" id="student_id">

                        <div class="mb-3">
                            <label for="">Course *</label>
                            <select class="form-control" name="course" id="course2"
                                onchange="toggleDivVisibility1()" required>
                                <option value="">Select Course</option>
                                <option value="SSLC">SSLC</option>
                                <option value="HSC">HSC</option>
                                <option value="ITI">ITI</option>
                                <option value="DIPLOMA">DIPLOMA</option>
                                <option value="UG">UG</option>
                                <option value="PG">PG</option>
                                <option value="PHD">PHD</option>
                                <option value="PDF">PDF</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="validationCustom03">Degree *</label>
                            <select class="form-control" name="degree" id="degree2"
                                required>
                                <option value="">Select Degree</option>
                            </select>
                        </div>

                        <div class="mb-3" id="spec2">
                            <label for="">Specialization / Branch *</label>
                            <input type="text" name="branch" id="branch"
                                class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="">Institution Name *</label>
                            <input type="text" name="name" id="name"
                                class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="">Board/University *</label>
                            <input type="text" name="univ" id="univ"
                                class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="">Medium of Study *</label>
                            <input type="text" name="mes" id="mes"
                                class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="">Year of Completion *</label>
                            <input type="text" name="yc" id="yc" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Place of Institution </label>
                            <input type="text" name="pins" id="pins" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="">Percentage (%)/CGPA*</label>
                            <input type="text" name="score" id="score"
                                class="form-control" />
                        </div>


                        <div class="mb-3">
                            <label for="">Certificate*</label>
                            <label for="">(upload less than 2 mb)</label>
                            <div class="input-group">
                                <input type="file"
                                    class="form-control custom-file-input" name="cert"
                                    id="uploadFile3"
                                    onchange="return fileValidationucert()"
                                    aria-describedby="inputGroupPrepend" required>
                                <label class="custom-file-label" for="customFile"></label>
                            </div>
                            <p style="color:red;" id="tutorial"></p>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update
                            details</button>
                    </div>

                </form>


            </div>
        </div>
    </div>

    <!-- Add family Model -->
    <div class="modal fade" id="familyadd" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add family Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="familyadd2">
                    <div class="modal-body">

                        <div id="errorMessage" class="alert alert-warning d-none"></div>


                        <div class="mb-3">
                            <label for="" class="form-label">Name </label>
                            <input type="text" name="name" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Gender </label>
                            <select class="form-control" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Transgender">Transgender</option>
                            </select>
                        </div>
                        <div class="mb-3"><label class="form-label">Relationship </label>
                            <select class="form-control" name="relationship">
                                <option value="">Select Relationship</option>
                                <option value="Brother">Brother</option>
                                <option value="Brother-in-Law">Brother-in-Law</option>
                                <option value="Daughter">Daughter</option>
                                <option value="Daughter-in-Law">Daughter-in-Law</option>
                                <option value="Father">Father</option>
                                <option value="Father-in-Law">Father-in-Law</option>
                                <option value="Grand-Daughter">Grand-Daughter</option>
                                <option value="Grand-Father">Grand-Father</option>
                                <option value="Grand-Mother">Grand-Mother</option>
                                <option value="Grand-Son">Grand-Son</option>
                                <option value="Husband">Husband</option>
                                <option value="Mother">Mother</option>
                                <option value="Mother-in-Law">Mother-in-Law</option>
                                <option value="Others">Others</option>
                                <option value="Sister">Sister</option>
                                <option value="Sister-in-Law">Sister-in-Law</option>
                                <option value="Son">Son</option>
                                <option value="Son-in-Law">Son-in-Law</option>
                                <option value="Uncle">Uncle</option>
                                <option value="Wife">Wife</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Occupation </label>
                            <input type="text" name="occu" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Organization </label>
                            <input type="text" name="org" class="form-control" />
                        </div>



                        <div class="mb-3">
                            <label for="" class="form-label">Mobile </label>
                            <input type="text" name="mobile" class="form-control" />
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add
                            member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit family Model -->
    <div class="modal fade" id="studentEditModal2" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updatefamily">
                    <div class="modal-body">

                        <div id="errorMessageUpdate" class="alert alert-warning d-none">
                        </div>

                        <input type="hidden" name="student_id2" id="student_id2">


                        <div class="mb-3">
                            <label for="" class="form-label">Name </label>
                            <input type="text" name="name" id="name2"
                                class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Gender</label>
                            <select class="form-control" name="gender" id="gender"
                                required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Transgender">Transgender</option>
                            </select>
                        </div>
                        <div class="mb-3"><label class="form-label">Relationship </label>
                            <select class="form-control" name="relationship"
                                id="relationship">
                                <option value="">Select Relationship</option>
                                <option value="Brother">Brother</option>
                                <option value="Brother-in-Law">Brother-in-Law</option>
                                <option value="Daughter">Daughter</option>
                                <option value="Daughter-in-Law">Daughter-in-Law</option>
                                <option value="Father">Father</option>
                                <option value="Father-in-Law">Father-in-Law</option>
                                <option value="Grand-Daughter">Grand-Daughter</option>
                                <option value="Grand-Father">Grand-Father</option>
                                <option value="Grand-Mother">Grand-Mother</option>
                                <option value="Grand-Son">Grand-Son</option>
                                <option value="Husband">Husband</option>
                                <option value="Mother">Mother</option>
                                <option value="Mother-in-Law">Mother-in-Law</option>
                                <option value="Others">Others</option>
                                <option value="Sister">Sister</option>
                                <option value="Sister-in-Law">Sister-in-Law</option>
                                <option value="Son">Son</option>
                                <option value="Son-in-Law">Son-in-Law</option>
                                <option value="Uncle">Uncle</option>
                                <option value="Wife">Wife</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="" class="form-label">Occupation </label>
                            <input type="text" name="occu" id="occu"
                                class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Organization </label>
                            <input type="text" name="org" id="org"
                                class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Mobile </label>
                            <input type="text" name="mobile" id="mobile"
                                class="form-control" />
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update
                            Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add ParentMeeting Model -->
    <div class="modal fade" id="studentAddParentMeetingDetails" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong> Add Parents-Meeting </strong>
                        Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="saveparentsmeetingdetails">
                    <div class="modal-body">

                        <div id="errorparentsMessage"
                            class="alert alert-warning d-none"></div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date </label>
                            <input type="date" name="pmdate" id="pmdate"
                                class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="purpose-meeting" class="form-label">Purpose of Meeting </label>
                            <input type="text" name="purpose" id="purpose-meeting"
                                class="form-control" required>
                        </div>

                        <!--	<div class="mb-3">
                            <label for="suggestion">Points Discussed* : </label>
                            <input type="text" name="suggestion" id="suggestion" class="form-control"  required>
                        </div>
                        -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit ParentMeeting Model -->
    <div class="modal fade" id="parenteditmodel" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong> Edit Meeting </strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updparent">
                    <div class="modal-body">

                        <div id="errorMessageUpdate" class="alert alert-warning d-none">
                        </div>

                        <input type="hidden" name="student_id3" id="student_id3">

                        <div class="mb-3">
                            <label for="date" class="form-label">Date </label>
                            <input type="date" name="pmdate2" id="pmdate2"
                                class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="purpose-meeting" class="form-label">Purpose of Meeting </label>
                            <br>
                            <input type="text" name="purpose-meeting2"
                                id="purpose-meeting2" class="form-control" required>
                        </div>

                        <!--		<div class="mb-3">
                                <label for="suggestion">Points Discussed* : </label>
                                <br>
                                <input type="text" name="suggestion2" id="suggestion2" class="form-control" required>
                            </div>
                          -->
                        <input type="hidden" name="status2" id="status2">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-md"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-md">Update
                            details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add nominee Model -->
    <div class="modal fade" id="mod" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong> Add Counselling Details</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="cform">
                    <div class="modal-body">

                        <div id="errorMessagec" class="alert alert-warning d-none">
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Date </label>
                            <input type="Date" name="datee" class="form-control"
                                required />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Point Discussed </label>
                            <textarea type="text" name="feedback" class="form-control"
                                required></textarea>
                        </div>
                        <!--
                                        <div class="mb-3">
                                            <label for="taken">Actions taken *</label>
                                            <textarea name="taken" class="form-control" required></textarea>
                                        </div>  
                                        -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="cform" id="cform"
                            class=" cform btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- View medical Model -->
    <div class="modal fade" id="studentViewModalms" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong> View Certificate </strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="imagems" src="" alt="Co-Curricular" class="center"
                        style="width:80%;height:80%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add medical Model -->
    <div class="modal fade" id="smmedical" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong> Add Medical Leave Details </strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="smedical">
                    <div class="modal-body">

                        <div id="smedimsg" class="alert alert-warning d-none"></div>

                        <div class="mb-3">
                            <label for="" class="form-label">From Date </label>
                            <input type="Date" name="fdatee" id="fromDate"
                                class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">To Date </label>
                            <input type="Date" name="tdatee" id="toDate"
                                class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Total Days</label>
                            <input type="text" name="tdays" id="totalDays"
                                class="form-control" required readonly/>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Reason </label>
                            <textarea type="text" name="reason" class="form-control"
                                required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Medical Certificate</label>
                            <label for="">(upload less than 2 mb)</label> </br>
                            <div class="input-group">
                                <input type="file"
                                    class="form-control " name="mcert"
                                    id="uploadFile" onchange="return fileValidation2()"
                                    aria-describedby="inputGroupPrepend" required>
                                <label class="custom-file-label" for="customFile"></label>
                            </div>
                            <p style="color:red;" id="tutorial"></p>
                        </div>
                        <!--
                                            <div class="mb-3">
                                                <label for="taken">Actions taken *</label>
                                                <textarea name="taken" class="form-control" required></textarea>
                                            </div>  
                                            -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="cform" id="cform"
                            class=" cform btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
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
    <!-- <script>
            function toggleMarkField() {
                let status = document.getElementById("exam_status").value;
                let markField = document.getElementById("markField");

                if (status === "NEET" || status === "JEE") {
                    markField.style.display = "block";
                } else {
                    markField.style.display = "none";
                }
            }
        </script> -->
    <script>
        function toggleFields() {
            const status = document.getElementById('status').value;

            // Get all toggleable fields
            const transportField = document.getElementById('transportField');
            const boardingField = document.getElementById('boardingField');
            const hostelField = document.getElementById('hostelContainer');
            const roomField = document.getElementById('roomField');
            const busNo = document.getElementById('busNo');

            // Hide all fields first
            transportField.style.display = 'none';
            boardingField.style.display = 'none';
            hostelField.style.display = 'none';
            roomField.style.display = 'none';
            busNo.style.display = 'none';

            // Show relevant fields based on selection
            if (status === 'Dayscholar') {
                transportField.style.display = 'block';
                boardingField.style.display = 'block';
                busNo.style.display = 'block';

                // Reset hosteller fields
                document.getElementById('hostel_name').value = '';
                document.getElementById('room_no').value = '';

            } else if (status === 'Hosteller') {
                hostelField.style.display = 'block';
                roomField.style.display = 'block';

                // Reset dayscholar fields
                document.getElementById('transport_mode').value = '';
                document.getElementById('boarding_point').value = '';
                document.getElementById('bus_no').value = '';
            }
        }

        function toggleScholarshipOptions() {
            var category = document.getElementById("scholarship_category").value;

            document.getElementById("govtScholarship").style.display = (category === "government") ? "block" : "none";
            document.getElementById("instScholarship").style.display = (category === "institution") ? "block" : "none";
            document.getElementById("ngoScholarship").style.display = (category === "ngo") ? "block" : "none";
            document.getElementById("genScholarship").style.display = (category === "general") ? "block" : "none";
        }
    </script>
    <script>
        //basic Starts

        $(document).on('submit', '#basic', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_basic", true);

            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorbasic').removeClass('d-none');
                        $('#errorbasic').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorbasic').addClass('d-none');

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                        //$('#basic')[0].reset();
                        //$('#basic').load(location.href + " #basic");




                    } else if (res.status == 500) {
                        alert(res.message);
                        //$('#basic')[0].reset();
                    }
                }
            });

        });

        //approve button in basic profile		

        $(document).on('click', '.apppcBtn', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                html: "You won't be able to revert this! <span style='color:red';><br><br><i> <b>Note</b>: Before approving the form, make sure that you have <b>submitted </b>it.</i></span>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var student_id = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "scode.php",
                        data: {
                            'approve_student': true,
                            'student_id': student_id
                        },
                        success: function(response) {
                            console.log(response);
                            var res = jQuery.parseJSON(response);
                            console.log(res.status);
                            if (res.status == 500) {
                                Swal.fire('Error', res.message, 'error');
                            } else if (res.status == 200) {
                                alertify.set('notifier', 'position', 'top-right');
                                alertify.success(res.message);
                                $('#basic').load(location.href + " #basic");
                            } else if (res.status == 205) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Submit the form before Approve it'
                                });
                            }
                        }
                    });
                }
            });
        });






        //basic ends


        //Academic starts
        $(document).on('submit', '#sacademic', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_sacademic", true);
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
                    $('#test').html(res);
                    if (res.status == 422) {
                        $('#errorsacademic').removeClass('d-none');
                        $('#errorsacademic').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorsacademic').addClass('d-none');
                        $('#studentAcademic').modal('hide');
                        $('#sacademic')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTable').load(location.href + " #myTable");

                    } else if (res.status == 500) {
                        $('#errorsacademic').addClass('d-none');
                        $('#studentAcademic').modal('hide');
                        $('#sacademic')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });


        $(document).on('click', '.editStudentBtn', function() {

            var student_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "scode.php?student_id=" + student_id,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {

                        alert(res.message);
                    } else if (res.status == 200) {

                        $('#student_id').val(res.data.uid);

                        //$('#course2').val(res.data.course);
                        //$('#degree2').val(res.data.Degree);
                        $('#branch').val(res.data.branch);
                        $('#name').val(res.data.iname);

                        $('#univ').val(res.data.board);

                        $('#mes').val(res.data.mos);

                        $('#yc').val(res.data.yc);
                        $('#pins').val(res.data.pins);
                        $('#exam_status_ed').val(res.data.exam_status);
                        $('#exam_mark_ed').val(res.data.exam_mark);
                        $('#cut1').val(res.data.cut);
                        $('#mark').val(res.data.mark);
                        $('#score').val(res.data.score);

                        $('#studentEditModal').modal('show');
                    }

                }
            });

        });

        $(document).on('submit', '#updateStudent', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_student", true);
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


        $(document).on('click', '.deleteStudentBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
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

                            $('#myTable').load(location.href + " #myTable");
                        }
                    }
                });
            }
        });


        $(document).on('click', '.btnimg', function() {

            var student_id = $(this).data('student-id');
            //var action = $(this).data('cert');
            $.ajax({
                type: "GET",
                url: "scode.php?student_id=" + student_id,
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





        //Academic ends	

        //-----------------------------------------------------------

        //Family Starts	
        $(document).on('submit', '#familyadd2', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_family", true);

            $.ajax({
                type: "POST",
                url: "scode.php",
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
                        $('#familyadd').modal('hide');
                        $('#familyadd2')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTable1').load(location.href + " #myTable1");
                       

                    } else if (res.status == 500) {
                        $('#errorMessage').addClass('d-none');
                        $('#familyadd').modal('hide');
                        $('#familyadd2')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });


        $(document).on('click', '.editfamilyBtn', function() {

            var student_id2 = $(this).val();
            console.log(student_id2);
            $.ajax({
                type: "GET",
                url: "scode.php?student_id2=" + student_id2,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {

                        alert(res.message);
                    } else if (res.status == 200) {

                        $('#student_id2').val(res.data.uid);

                        $('#name2').val(res.data.name);
                        $('#gender').val(res.data.gender);

                        $('#relationship').val(res.data.relationship);
                        $('#occu').val(res.data.occu);
                        $('#org').val(res.data.org);
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
                    url: "scode.php",
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
                            $('#nominee').load(location.href + " #nominee");
                        }
                    }
                });
            }
        });

        //Family ends

        //--------------------------------------------------------------
        //Parent Meeting Ajax Start//
        $(document).on('submit', '#saveparentsmeetingdetails', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_parentsmeeting", true);
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
                        $('#errorparentsMessage').removeClass('d-none');
                        $('#errorparentsMessage').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorparentsMessage').addClass('d-none');
                        $('#studentAddParentMeetingDetails').modal('hide');
                        $('#saveparentsmeetingdetails')[0].reset();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#myTable30').load(location.href + " #myTable30");
                      

                    } else if (res.status == 500) {
                        $('#errorparentsMessage').addClass('d-none');
                        $('#studentAddParentMeetingDetails').modal('hide');
                        $('#saveparentsmeetingdetails')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });

        });

        $(document).on('submit', '#updparent', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("upd_parent", true);
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
                        $('#errorparentsMessage').removeClass('d-none');
                        $('#errorparentsMessage').text(res.message);

                    } else if (res.status == 200) {

                        $('#errorparentsMessage').addClass('d-none');

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#parenteditmodel').modal('hide');
                        $('#updparent')[0].reset();

                        $('#myTable30').load(location.href + " #myTable30");

                    } else if (res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });



        $(document).on('click', '.updateSBtn', function(e) {
            var student_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "scode.php?uid_id=" + student_id,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {

                        alert(res.message);
                    } else if (res.status == 200) {
                        $('#student_id3').val(res.data.uid);
                        $('#pmdate2').val(res.data.datee)
                        $('#purpose-meeting2').val(res.data.purpose);
                        $('#suggestion2').val(res.data.suggestion);
                        $('#status2').val(res.data.status);
                        $('#parenteditmodel').modal('show');
                    }

                }
            });
        });



        $(document).on('click', '.deleteSBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var delete_meeting = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_parentmeeting': true,
                        'delete_meeting': delete_meeting
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.error(res.message);

                            $('#myTable30').load(location.href + " #myTable30");
                        }
                    }
                });
            }
        });

        //Parent meeting Ajax End		

        //-----------------------------------------------------------

        //Counselling starts

        $(document).on('submit', '#cform', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("save_counselling", true);
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
                        // Show the error message if the status is 422
                        $('#errorMessagec').removeClass('d-none');
                        $('#errorMessagec').text(res.message);
                    } else if (res.status == 200) {
                        // Show a success message if the status is 200
                        $('#errorMessagec').addClass('d-none');

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        // Clear the form with id 'familyadd2'
                        $('#cform')[0].reset();
                        $('#mod').modal('hide');

                        // Refresh the table with updated data
                        $('#myTablec').load(location.href + " #myTablec");
                    } else if (res.status == 500) {
                        // Show an alert message if the status is 500
                        alert(res.message);
                    }

                }
            });
        });

        $(document).on('click', '.deletedetails', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id3 = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_details': true,
                        'student_id3': student_id3
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#myTablec').load(location.href + " #myTablec");

                        }
                    }
                });
            }
        });







        //Counselling ends		

        //medical Leave
        //--------------------------------

        //total days calculation

        document.getElementById("fromDate").addEventListener("change", function() {
            let fromDate = new Date(this.value);
            if (!isNaN(fromDate)) {
                let nextDay = new Date(fromDate);
                nextDay.setDate(fromDate.getDate() + 1);
                let formattedNextDay = nextDay.toISOString().split('T')[0];
                document.getElementById("toDate").min = formattedNextDay;
                document.getElementById("toDate").value = formattedNextDay;
                calculateDays();
            }
        });

        document.getElementById("toDate").addEventListener("change", calculateDays);

        function calculateDays() {
            let fromDate = new Date(document.getElementById("fromDate").value);
            let toDate = new Date(document.getElementById("toDate").value);

            if (!isNaN(fromDate) && !isNaN(toDate) && toDate >= fromDate) {
                let diffTime = toDate.getTime() - fromDate.getTime();
                let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // Convert milliseconds to days
                document.getElementById("totalDays").value = diffDays;
            } else {
                document.getElementById("totalDays").value = "";
            }
        }

        //save form datas

        $(document).on('submit', '#smedical', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_smedical", true);

            $.ajax({
                type: "POST",
                url: "scode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#smedimsg').removeClass('d-none');
                        $('#smedimsg').text(res.message);

                    } else if (res.status == 200) {

                        $('#smedimsg').addClass('d-none');

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);

                        $('#smedical')[0].reset();

                        $('#smedic').load(location.href + " #smedic");

                        $('#smmedical').modal('hide');

                    } else if (res.status == 500) {
                        alert(res.message);
                        $('#smedical')[0].reset();

                        $('#smmedical').modal('hide');
                    }
                }
            });

        });

        //view Certificate*

        $(document).on('click', '.btnsmedi', function() {

            var student_idsm = $(this).val();
            $.ajax({
                type: "GET",
                url: "scode.php?student_idsm=" + student_idsm,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {

                        alert(res.message);
                    } else if (res.status == 200) {


                        $("#imagems").attr("src", res.data.mcert);

                        $('#studentViewModalms').modal('show');
                    }
                }
            });
        });

        //Delete
        $(document).on('click', '.deletesmBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_idi = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "scode.php",
                    data: {
                        'delete_sm': true,
                        'student_idi': student_idi
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#smedic').load(location.href + " #smedic");
                        }
                    }
                });
            }
        });

        //----------------------------------------
        //medical leave ends

        //----------------------------------------------------
        //SWOT

        $(document).on('submit', '#swot', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_swot", true);

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
                        $('#swotmsg').removeClass('d-none');
                        $('#swotmsg').text(res.message);

                    } else if (res.status == 200) {

                        $('#swotmsg').addClass('d-none');

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);



                    } else if (res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });



        //swot ends
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
        var AndraPradesh = ["Anantapur", "Chittoor", "East Godavari", "Guntur", "Kadapa", "Krishna", "Kurnool", "Prakasam", "Nellore", "Srikakulam", "Visakhapatnam", "Vizianagaram", "West Godavari"];
        var ArunachalPradesh = ["Anjaw", "Changlang", "Dibang Valley", "East Kameng", "East Siang", "Kra Daadi", "Kurung Kumey", "Lohit", "Longding", "Lower Dibang Valley", "Lower Subansiri", "Namsai", "Papum Pare", "Siang", "Tawang", "Tirap", "Upper Siang", "Upper Subansiri", "West Kameng", "West Siang", "Itanagar"];
        var Assam = ["Baksa", "Barpeta", "Biswanath", "Bongaigaon", "Cachar", "Charaideo", "Chirang", "Darrang", "Dhemaji", "Dhubri", "Dibrugarh", "Goalpara", "Golaghat", "Hailakandi", "Hojai", "Jorhat", "Kamrup Metropolitan", "Kamrup (Rural)", "Karbi Anglong", "Karimganj", "Kokrajhar", "Lakhimpur", "Majuli", "Morigaon", "Nagaon", "Nalbari", "Dima Hasao", "Sivasagar", "Sonitpur", "South Salmara Mankachar", "Tinsukia", "Udalguri", "West Karbi Anglong"];
        var Bihar = ["Araria", "Arwal", "Aurangabad", "Banka", "Begusarai", "Bhagalpur", "Bhojpur", "Buxar", "Darbhanga", "East Champaran", "Gaya", "Gopalganj", "Jamui", "Jehanabad", "Kaimur", "Katihar", "Khagaria", "Kishanganj", "Lakhisarai", "Madhepura", "Madhubani", "Munger", "Muzaffarpur", "Nalanda", "Nawada", "Patna", "Purnia", "Rohtas", "Saharsa", "Samastipur", "Saran", "Sheikhpura", "Sheohar", "Sitamarhi", "Siwan", "Supaul", "Vaishali", "West Champaran"];
        var Chhattisgarh = ["Balod", "Baloda Bazar", "Balrampur", "Bastar", "Bemetara", "Bijapur", "Bilaspur", "Dantewada", "Dhamtari", "Durg", "Gariaband", "Janjgir Champa", "Jashpur", "Kabirdham", "Kanker", "Kondagaon", "Korba", "Koriya", "Mahasamund", "Mungeli", "Narayanpur", "Raigarh", "Raipur", "Rajnandgaon", "Sukma", "Surajpur", "Surguja"];
        var Goa = ["North Goa", "South Goa"];
        var Gujarat = ["Ahmedabad", "Amreli", "Anand", "Aravalli", "Banaskantha", "Bharuch", "Bhavnagar", "Botad", "Chhota Udaipur", "Dahod", "Dang", "Devbhoomi Dwarka", "Gandhinagar", "Gir Somnath", "Jamnagar", "Junagadh", "Kheda", "Kutch", "Mahisagar", "Mehsana", "Morbi", "Narmada", "Navsari", "Panchmahal", "Patan", "Porbandar", "Rajkot", "Sabarkantha", "Surat", "Surendranagar", "Tapi", "Vadodara", "Valsad"];
        var Haryana = ["Ambala", "Bhiwani", "Charkhi Dadri", "Faridabad", "Fatehabad", "Gurugram", "Hisar", "Jhajjar", "Jind", "Kaithal", "Karnal", "Kurukshetra", "Mahendragarh", "Mewat", "Palwal", "Panchkula", "Panipat", "Rewari", "Rohtak", "Sirsa", "Sonipat", "Yamunanagar"];
        var HimachalPradesh = ["Bilaspur", "Chamba", "Hamirpur", "Kangra", "Kinnaur", "Kullu", "Lahaul Spiti", "Mandi", "Shimla", "Sirmaur", "Solan", "Una"];
        var JammuKashmir = ["Anantnag", "Bandipora", "Baramulla", "Budgam", "Doda", "Ganderbal", "Jammu", "Kargil", "Kathua", "Kishtwar", "Kulgam", "Kupwara", "Leh", "Poonch", "Pulwama", "Rajouri", "Ramban", "Reasi", "Samba", "Shopian", "Srinagar", "Udhampur"];
        var Jharkhand = ["Bokaro", "Chatra", "Deoghar", "Dhanbad", "Dumka", "East Singhbhum", "Garhwa", "Giridih", "Godda", "Gumla", "Hazaribagh", "Jamtara", "Khunti", "Koderma", "Latehar", "Lohardaga", "Pakur", "Palamu", "Ramgarh", "Ranchi", "Sahebganj", "Seraikela Kharsawan", "Simdega", "West Singhbhum"];
        var Karnataka = ["Bagalkot", "Bangalore Rural", "Bangalore Urban", "Belgaum", "Bellary", "Bidar", "Vijayapura", "Chamarajanagar", "Chikkaballapur", "Chikkamagaluru", "Chitradurga", "Dakshina Kannada", "Davanagere", "Dharwad", "Gadag", "Gulbarga", "Hassan", "Haveri", "Kodagu", "Kolar", "Koppal", "Mandya", "Mysore", "Raichur", "Ramanagara", "Shimoga", "Tumkur", "Udupi", "Uttara Kannada", "Yadgir"];
        var Kerala = ["Alappuzha", "Ernakulam", "Idukki", "Kannur", "Kasaragod", "Kollam", "Kottayam", "Kozhikode", "Malappuram", "Palakkad", "Pathanamthitta", "Thiruvananthapuram", "Thrissur", "Wayanad"];
        var MadhyaPradesh = ["Agar Malwa", "Alirajpur", "Anuppur", "Ashoknagar", "Balaghat", "Barwani", "Betul", "Bhind", "Bhopal", "Burhanpur", "Chhatarpur", "Chhindwara", "Damoh", "Datia", "Dewas", "Dhar", "Dindori", "Guna", "Gwalior", "Harda", "Hoshangabad", "Indore", "Jabalpur", "Jhabua", "Katni", "Khandwa", "Khargone", "Mandla", "Mandsaur", "Morena", "Narsinghpur", "Neemuch", "Panna", "Raisen", "Rajgarh", "Ratlam", "Rewa", "Sagar", "Satna",
            "Sehore", "Seoni", "Shahdol", "Shajapur", "Sheopur", "Shivpuri", "Sidhi", "Singrauli", "Tikamgarh", "Ujjain", "Umaria", "Vidisha"
        ];
        var Maharashtra = ["Ahmednagar", "Akola", "Amravati", "Aurangabad", "Beed", "Bhandara", "Buldhana", "Chandrapur", "Dhule", "Gadchiroli", "Gondia", "Hingoli", "Jalgaon", "Jalna", "Kolhapur", "Latur", "Mumbai City", "Mumbai Suburban", "Nagpur", "Nanded", "Nandurbar", "Nashik", "Osmanabad", "Palghar", "Parbhani", "Pune", "Raigad", "Ratnagiri", "Sangli", "Satara", "Sindhudurg", "Solapur", "Thane", "Wardha", "Washim", "Yavatmal"];
        var Manipur = ["Bishnupur", "Chandel", "Churachandpur", "Imphal East", "Imphal West", "Jiribam", "Kakching", "Kamjong", "Kangpokpi", "Noney", "Pherzawl", "Senapati", "Tamenglong", "Tengnoupal", "Thoubal", "Ukhrul"];
        var Meghalaya = ["East Garo Hills", "East Jaintia Hills", "East Khasi Hills", "North Garo Hills", "Ri Bhoi", "South Garo Hills", "South West Garo Hills", "South West Khasi Hills", "West Garo Hills", "West Jaintia Hills", "West Khasi Hills"];
        var Mizoram = ["Aizawl", "Champhai", "Kolasib", "Lawngtlai", "Lunglei", "Mamit", "Saiha", "Serchhip", "Aizawl", "Champhai", "Kolasib", "Lawngtlai", "Lunglei", "Mamit", "Saiha", "Serchhip"];
        var Nagaland = ["Dimapur", "Kiphire", "Kohima", "Longleng", "Mokokchung", "Mon", "Peren", "Phek", "Tuensang", "Wokha", "Zunheboto"];
        var Odisha = ["Angul", "Balangir", "Balasore", "Bargarh", "Bhadrak", "Boudh", "Cuttack", "Debagarh", "Dhenkanal", "Gajapati", "Ganjam", "Jagatsinghpur", "Jajpur", "Jharsuguda", "Kalahandi", "Kandhamal", "Kendrapara", "Kendujhar", "Khordha", "Koraput", "Malkangiri", "Mayurbhanj", "Nabarangpur", "Nayagarh", "Nuapada", "Puri", "Rayagada", "Sambalpur", "Subarnapur", "Sundergarh"];
        var Punjab = ["Amritsar", "Barnala", "Bathinda", "Faridkot", "Fatehgarh Sahib", "Fazilka", "Firozpur", "Gurdaspur", "Hoshiarpur", "Jalandhar", "Kapurthala", "Ludhiana", "Mansa", "Moga", "Mohali", "Muktsar", "Pathankot", "Patiala", "Rupnagar", "Sangrur", "Shaheed Bhagat Singh Nagar", "Tarn Taran"];
        var Rajasthan = ["Ajmer", "Alwar", "Banswara", "Baran", "Barmer", "Bharatpur", "Bhilwara", "Bikaner", "Bundi", "Chittorgarh", "Churu", "Dausa", "Dholpur", "Dungarpur", "Ganganagar", "Hanumangarh", "Jaipur", "Jaisalmer", "Jalore", "Jhalawar", "Jhunjhunu", "Jodhpur", "Karauli", "Kota", "Nagaur", "Pali", "Pratapgarh", "Rajsamand", "Sawai Madhopur", "Sikar", "Sirohi", "Tonk", "Udaipur"];
        var Sikkim = ["East Sikkim", "North Sikkim", "South Sikkim", "West Sikkim"];
        var TamilNadu = ["Ariyalur", "Chengalpattu", "Chennai", "Coimbatore", "Cuddalore", "Dharmapuri", "Dindigul", "Erode", "Kallakurichi", "Kancheepuram", "Kanyakumari", "Karur", "Krishnagiri", "Madurai", "Mayiladuthurai", "Nagapattinam", "Namakkal", "Nilgiris", "Perambalur", "Pudukkottai", "Ramanathapuram", "Ranipet", "Salem", "Sivagangai", "Tenkasi", "Thanjavur", "Theni", "Thoothukudi", "Tiruchirappalli", "Tirunelveli", "Tirupathur", "Tiruppur", "Tiruvallur", "Tiruvannamalai", "Tiruvarur", "Vellore", "Viluppuram", "Virudhunagar"];
        var Telangana = ["Adilabad", "Bhadradri Kothagudem", "Hyderabad", "Jagtial", "Jangaon", "Jayashankar", "Jogulamba", "Kamareddy", "Karimnagar", "Khammam", "Komaram Bheem", "Mahabubabad", "Mahbubnagar", "Mancherial", "Medak", "Medchal", "Nagarkurnool", "Nalgonda", "Nirmal", "Nizamabad", "Peddapalli", "Rajanna Sircilla", "Ranga Reddy", "Sangareddy", "Siddipet", "Suryapet", "Vikarabad", "Wanaparthy", "Warangal Rural", "Warangal Urban", "Yadadri Bhuvanagiri"];
        var Tripura = ["Dhalai", "Gomati", "Khowai", "North Tripura", "Sepahijala", "South Tripura", "Unakoti", "West Tripura"];
        var UttarPradesh = ["Agra", "Aligarh", "Allahabad", "Ambedkar Nagar", "Amethi", "Amroha", "Auraiya", "Azamgarh", "Baghpat", "Bahraich", "Ballia", "Balrampur", "Banda", "Barabanki", "Bareilly", "Basti", "Bhadohi", "Bijnor", "Budaun", "Bulandshahr", "Chandauli", "Chitrakoot", "Deoria", "Etah", "Etawah", "Faizabad", "Farrukhabad", "Fatehpur", "Firozabad", "Gautam Buddha Nagar", "Ghaziabad", "Ghazipur", "Gonda", "Gorakhpur", "Hamirpur", "Hapur", "Hardoi", "Hathras", "Jalaun", "Jaunpur", "Jhansi", "Kannauj", "Kanpur Dehat", "Kanpur Nagar", "Kasganj", "Kaushambi", "Kheri", "Kushinagar", "Lalitpur", "Lucknow", "Maharajganj", "Mahoba", "Mainpuri", "Mathura", "Mau", "Meerut", "Mirzapur", "Moradabad", "Muzaffarnagar", "Pilibhit", "Pratapgarh", "Raebareli", "Rampur", "Saharanpur", "Sambhal", "Sant Kabir Nagar", "Shahjahanpur", "Shamli", "Shravasti", "Siddharthnagar", "Sitapur", "Sonbhadra", "Sultanpur", "Unnao", "Varanasi"];
        var Uttarakhand = ["Almora", "Bageshwar", "Chamoli", "Champawat", "Dehradun", "Haridwar", "Nainital", "Pauri", "Pithoragarh", "Rudraprayag", "Tehri", "Udham Singh Nagar", "Uttarkashi"];
        var WestBengal = ["Alipurduar", "Bankura", "Birbhum", "Cooch Behar", "Dakshin Dinajpur", "Darjeeling", "Hooghly", "Howrah", "Jalpaiguri", "Jhargram", "Kalimpong", "Kolkata", "Malda", "Murshidabad", "Nadia", "North 24 Parganas", "Paschim Bardhaman", "Paschim Medinipur", "Purba Bardhaman", "Purba Medinipur", "Purulia", "South 24 Parganas", "Uttar Dinajpur"];
        var AndamanNicobar = ["Nicobar", "North Middle Andaman", "South Andaman"];
        var Chandigarh = ["Chandigarh"];
        var DadraHaveli = ["Dadra Nagar Haveli"];
        var DamanDiu = ["Daman", "Diu"];
        var Delhi = ["Central Delhi", "East Delhi", "New Delhi", "North Delhi", "North East Delhi", "North West Delhi", "Shahdara", "South Delhi", "South East Delhi", "South West Delhi", "West Delhi"];
        var Lakshadweep = ["Lakshadweep"];
        var Puducherry = ["Karaikal", "Mahe", "Puducherry", "Yanam"];


        $("#inputState").change(function() {
            var StateSelected = $(this).val();
            var optionsList;
            var htmlString = "";

            switch (StateSelected) {
                case "Andra Pradesh":
                    optionsList = AndraPradesh;
                    break;
                case "Arunachal Pradesh":
                    optionsList = ArunachalPradesh;
                    break;
                case "Assam":
                    optionsList = Assam;
                    break;
                case "Bihar":
                    optionsList = Bihar;
                    break;
                case "Chhattisgarh":
                    optionsList = Chhattisgarh;
                    break;
                case "Goa":
                    optionsList = Goa;
                    break;
                case "Gujarat":
                    optionsList = Gujarat;
                    break;
                case "Haryana":
                    optionsList = Haryana;
                    break;
                case "Himachal Pradesh":
                    optionsList = HimachalPradesh;
                    break;
                case "Jammu and Kashmir":
                    optionsList = JammuKashmir;
                    break;
                case "Jharkhand":
                    optionsList = Jharkhand;
                    break;
                case "Karnataka":
                    optionsList = Karnataka;
                    break;
                case "Kerala":
                    optionsList = Kerala;
                    break;
                case "Madya Pradesh":
                    optionsList = MadhyaPradesh;
                    break;
                case "Maharashtra":
                    optionsList = Maharashtra;
                    break;
                case "Manipur":
                    optionsList = Manipur;
                    break;
                case "Meghalaya":
                    optionsList = Meghalaya;
                    break;
                case "Mizoram":
                    optionsList = Mizoram;
                    break;
                case "Nagaland":
                    optionsList = Nagaland;
                    break;
                case "Orissa":
                    optionsList = Orissa;
                    break;
                case "Punjab":
                    optionsList = Punjab;
                    break;
                case "Rajasthan":
                    optionsList = Rajasthan;
                    break;
                case "Sikkim":
                    optionsList = Sikkim;
                    break;
                case "Tamil Nadu":
                    optionsList = TamilNadu;
                    break;
                case "Telangana":
                    optionsList = Telangana;
                    break;
                case "Tripura":
                    optionsList = Tripura;
                    break;
                case "Uttaranchal":
                    optionsList = Uttaranchal;
                    break;
                case "Uttar Pradesh":
                    optionsList = UttarPradesh;
                    break;
                case "West Bengal":
                    optionsList = WestBengal;
                    break;
                case "Andaman and Nicobar Islands":
                    optionsList = AndamanNicobar;
                    break;
                case "Chandigarh":
                    optionsList = Chandigarh;
                    break;
                case "Dadar and Nagar Haveli":
                    optionsList = DadraHaveli;
                    break;
                case "Daman and Diu":
                    optionsList = DamanDiu;
                    break;
                case "Delhi":
                    optionsList = Delhi;
                    break;
                case "Lakshadeep":
                    optionsList = Lakshadeep;
                    break;
                case "Pondicherry":
                    optionsList = Pondicherry;
                    break;
            }


            for (var i = 0; i < optionsList.length; i++) {
                htmlString = htmlString + "<option value='" + optionsList[i] + "'>" + optionsList[i] + "</option>";
            }
            $("#inputDistrict").html(htmlString);

        });

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
                document.getElementById('validationCustomUsername2');
            var fileSize = ((document.getElementById('validationCustomUsername2').files[0].size) / 1024);
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

        function fileValidation4() {
            var fileInput =
                document.getElementById('validationCustomUsername3');
            var fileSize = ((document.getElementById('validationCustomUsername3').files[0].size) / 1024);
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

        function fileValidationcert() {
            var fileInput =
                document.getElementById('uploadFile2');
            var fileSize = ((document.getElementById('uploadFile2').files[0].size) / 1024);
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

        function fileValidationucert() {
            var fileInput =
                document.getElementById('uploadFile3');
            var fileSize = ((document.getElementById('uploadFile3').files[0].size) / 1024);
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
    </script>
    <script>
        var UG = ["BE", "B.Tech", "B.Arch", "B.S", "B.A", "B.Sc", "BBA", "BCA", "B.Com", "B.Com(CA)", "BBM"];
        var PG = ["ME", "M.Tech", "M.Arch", "M.S", "M.A", "M.Sc", "MBA", "MCA", "M.Com", "M.Phil"];
        var ITI = ["ITI"];
        var DIPLOMA = ["Diploma"];
        var SSLC = ["SSLC"];
        var HSC = ["HSC"];
        var PHD = ["PHD"];
        var PDF = ["PDF"];

        $("#course").change(function() {
            var StateSelected = $(this).val();
            var optionsList;
            var htmlString = "";

            switch (StateSelected) {
                case "SSLC":
                    optionsList = SSLC;
                    break;
                case "HSC":
                    optionsList = HSC;
                    break;
                case "ITI":
                    optionsList = ITI;
                    break;
                case "DIPLOMA":
                    optionsList = DIPLOMA;
                    break;
                case "UG":
                    optionsList = UG;
                    break;
                case "PG":
                    optionsList = PG;
                    break;
                case "PHD":
                    optionsList = PHD;
                    break;
                case "PDF":
                    optionsList = PDF;
                    break;
            }


            for (var i = 0; i < optionsList.length; i++) {
                htmlString = htmlString + "<option value='" + optionsList[i] + "'>" + optionsList[i] + "</option>";
            }
            $("#degree").html(htmlString);
        });
    </script>

    <script>
        var UG = ["BE", "B.Tech", "B.Arch", "B.S", "B.A", "B.Sc", "BBA", "BCA", "B.Com", "B.Com(CA)", "BBM"];
        var PG = ["ME", "M.Tech", "M.Arch", "M.S", "M.A", "M.Sc", "MBA", "MCA", "M.Com", "M.Phil"];
        var ITI = ["ITI"];
        var DIPLOMA = ["Diploma"];
        var SSLC = ["SSLC"];
        var HSC = ["HSC"];
        var PHD = ["PHD"];
        var PDF = ["PDF"];

        $("#course2").change(function() {
            var StateSelected = $(this).val();
            var optionsList;
            var htmlString = "";

            switch (StateSelected) {
                case "SSLC":
                    optionsList = SSLC;
                    break;
                case "HSC":
                    optionsList = HSC;
                    break;
                case "ITI":
                    optionsList = ITI;
                    break;
                case "DIPLOMA":
                    optionsList = DIPLOMA;
                    break;
                case "UG":
                    optionsList = UG;
                    break;
                case "PG":
                    optionsList = PG;
                    break;
                case "PHD":
                    optionsList = PHD;
                    break;
                case "PDF":
                    optionsList = PDF;
                    break;
            }


            for (var i = 0; i < optionsList.length; i++) {
                htmlString = htmlString + "<option value='" + optionsList[i] + "'>" + optionsList[i] + "</option>";
            }
            $("#degree2").html(htmlString);

        });
    </script>

    <script>
        // $(document).on('submit', '#basic', function(e) {
        //     e.preventDefault();

        //     var formData = new FormData(this);
        //     formData.append("update_basic", true);

        //     $.ajax({
        //         type: "POST",
        //         url: "code.php",
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {

        //             var res = jQuery.parseJSON(response);
        //             if (res.status == 422) {
        //                 $('#errorbasic').removeClass('d-none');
        //                 $('#errorbasic').text(res.message);

        //             } else if (res.status == 200) {

        //                 $('#errorbasic').addClass('d-none');

        //                 alertify.set('notifier', 'position', 'top-right');
        //                 alertify.success(res.message);



        //             } else if (res.status == 500) {
        //                 alert(res.message);
        //             }
        //         }
        //     });

        // });



        // $(document).on('submit', '#medical', function(e) {
        //     e.preventDefault();

        //     var formData = new FormData(this);
        //     formData.append("update_medical", true);

        //     console.log(formData);

        //     $.ajax({
        //         type: "POST",
        //         url: "code.php",
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {

        //             var res = jQuery.parseJSON(response);
        //             if (res.status == 422) {
        //                 $('#errorMessageUpdate2').removeClass('d-none');
        //                 $('#errorMessageUpdate2').text(res.message);

        //             } else if (res.status == 200) {

        //                 $('#errorMessageUpdate2').addClass('d-none');

        //                 alertify.set('notifier', 'position', 'top-right');
        //                 alertify.success(res.message);



        //             } else if (res.status == 500) {
        //                 alert(res.message);
        //             }
        //         }
        //     });

        // });


        // $(document).on('submit', '#nominee', function(e) {
        //     e.preventDefault();

        //     var formData = new FormData(this);
        //     formData.append("update_nominee", true);

        //     console.log(formData);

        //     $.ajax({
        //         type: "POST",
        //         url: "code.php",
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {

        //             var res = jQuery.parseJSON(response);
        //             if (res.status == 422) {
        //                 $('#errornominee').removeClass('d-none');
        //                 $('#errornominee').text(res.message);

        //             } else if (res.status == 200) {

        //                 $('#errornominee').addClass('d-none');

        //                 alertify.set('notifier', 'position', 'top-right');
        //                 alertify.success(res.message);



        //             } else if (res.status == 500) {
        //                 alert(res.message);
        //             }
        //         }
        //     });

        // });



        function toggleMarkField() {
            var examStatus = document.getElementById("exam_status").value;
            var markFieldDiv = document.getElementById("markField");

            if (examStatus === "NEET" || examStatus === "JEE") {
                markFieldDiv.style.display = "block";
            } else {
                markFieldDiv.style.display = "none";
            }
        }


        //hide sslc & HSC


        //hide sslc & HSC

        function toggleDivVisibility() {
            var selectElement = document.getElementById("course");
            var divElement = document.getElementById("spec");

            if (selectElement.value === "SSLC" || selectElement.value === "HSC") {
                divElement.style.display = "none";
            } else {
                divElement.style.display = "block";
            }
        }

        //hide sslc & HSC

        function toggleDivVisibility1() {
            var selectElement = document.getElementById("course2");
            var divElement = document.getElementById("spec2");

            if (selectElement.value === "SSLC" || selectElement.value === "HSC") {
                divElement.style.display = "none";
            } else {
                divElement.style.display = "block";
            }
        }
    </script>

</body>

</html>