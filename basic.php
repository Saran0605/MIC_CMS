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

        .row {
            margin-bottom: 0.6rem !important;
        }

        .form-label {
            margin-bottom: 0.5rem;
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
        <div class="breadcrumb-area">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="main.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile Information</li>
                </ol>
            </nav>
        </div>

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
                    <a class="nav-link" id="academic-tab" data-bs-toggle="tab" href="#profile" role="tab">

                        <i class="fas fa-book tab-icon"></i>Academic Information
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="family-tab" data-bs-toggle="tab" href="#messages" role="tab">

                        <i class="fas fa-users tab-icon"></i> Family Details
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="medical-tab" data-bs-toggle="tab" href="#medical" role="tab">

                        <i class="fas fa-notes-medical tab-icon"></i>Medical Leave
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="counselling-tab" data-bs-toggle="tab" href="#nominee" role="tab">

                        <i class="fa fa-id-card tab-icon"></i> Nominee Details
                    </a>
                </li>
            </ul>



            <div class="tab-content tabcontent-border">
                <div class="tab-pane active" id="home" role="tabpanel">

                    <form id="basic" class="needs-validation" novalidate>
                        <div id="Abasic" class="alert alert-warning d-none"></div>
                        <div class="card-header mb-3">
                            <h4>Personal Information</h4>
                        </div>
                        <!-- Salutation -->
                        <div class="row">
                            <div class="form-group col-md-3 mb-3">
                                <label for="title" class="form-label">Salutation *</label>
                                <select name="title" class="select2 form-control form-select" id="title" required>
                                    <option value="">Select Title</option>
                                    <option value="Mr" <?php echo (isset($student['title']) && $student['title'] == "Mr") ? "selected" : ""; ?>>Mr</option>
                                    <option value="Miss" <?php echo (isset($student['title']) && $student['title'] == "Miss") ? "selected" : ""; ?>>Miss</option>
                                    <option value="Mrs" <?php echo (isset($student['title']) && $student['title'] == "Mrs") ? "selected" : ""; ?>>Mrs</option>
                                    <option value="Dr" <?php echo (isset($student['title']) && $student['title'] == "Dr") ? "selected" : ""; ?>>Dr</option>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="validationCustom01" class="form-label">First name *</label>
                                <input type="text" name="fname" class="form-control" id="validationCustom01" placeholder="First Name"
                                    value="<?php echo (mysqli_num_rows($query_run) == 1) ? $student['fname'] : ""; ?>" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="form-group col-md-3 mb-3">
                                <label for="validationCustom02" class="form-label">Initial *</label>
                                <input type="text" class="form-control" name="lname" id="validationCustom02" placeholder="Last Name"
                                    value="<?php echo (mysqli_num_rows($query_run) == 1) ? $student['lname'] : ""; ?>" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                        </div>

                        <!-- Profile Photo -->
                        <div class="row">
                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustomProfilePhoto" class="form-label">Profile Photo *</label>
                                <?php
                                $existing_file = (mysqli_num_rows($query_run) == 1) ? $student['photo'] : "";
                                ?>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="photo" id="validationCustomProfilePhoto"
                                        onchange="return fileValidation('validationCustomProfilePhoto')"
                                        <?php echo $existing_file ? '' : 'required'; ?>>

                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Please choose a profile photo.</div>
                                </div>
                                <?php if ($existing_file): ?>
                                    <div class="mt-2">
                                       
                                        <span class="text-muted">Current file: 
                <a href="<?php echo $existing_file; ?>" target="_blank"><?php echo basename($existing_file); ?></a>
            </span>
                                        <input type="hidden" name="existing_photo" value="<?php echo $existing_file; ?>">
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustom01" class="form-label">Gender *</label>
                                <select class="select2 form-control form-select" name="gender" id="validationCustom01" required>
                                    <option value="">Select</option>
                                    <option value="Male" <?php if (isset($student['gender']) && $student['gender'] == "Male") echo 'selected="selected"'; ?>>Male</option>
                                    <option value="Female" <?php if (isset($student['gender']) && $student['gender'] == "Female") echo 'selected="selected"'; ?>>Female</option>
                                    <option value="Transgender" <?php if (isset($student['gender']) && $student['gender'] == "Transgender") echo 'selected="selected"'; ?>>Transgender</option>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please select gender.</div>
                            </div>
                            <?php
                            function calculateAge($dob)
                            {
                                if (empty($dob)) {
                                    return "N/A";
                                }
                                $dobDate = new DateTime($dob);
                                $today = new DateTime();
                                $diff = $today->diff($dobDate);
                                return $diff->y . " Years, " . $diff->m . " Months";
                            }

                            $dob = isset($student['dob']) ? $student['dob'] : "";
                            $age = !empty($dob) ? calculateAge($dob) : "";
                            ?>

                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustom02" class="form-label">DOB *</label>
                                <input type="date" class="form-control" name="dob" id="dob" required
                                    value="<?php echo (mysqli_num_rows($query_run) == 1) ? $student['dob'] : ""; ?>">
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter DOB.</div>
                            </div>
                            <!-- DOB Input -->

                        </div>
                        <!-- Age -->
                        <div class="row">
                            <!-- Age Display -->
                            <div class="form-group col-md-4 mb-3">
                                <label for="age" class="form-label">Age *</label>
                                <input type="text" class="form-control" name="age" id="age" value="<?= $age; ?>" readonly>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustomUsername" class="form-label">Religion *</label>
                                <select class="select2 form-control form-select" name="religion" required>
                                    <option value="">Select</option>
                                    <option value="Buddhism" <?php if (isset($student['religion']) && $student['religion'] == "Buddhism") echo 'selected="selected"'; ?>>Buddhism</option>
                                    <option value="Christian" <?php if (isset($student['religion']) && $student['religion'] == "Christian") echo 'selected="selected"'; ?>>Christian</option>
                                    <option value="Hinduism" <?php if (isset($student['religion']) && $student['religion'] == "Hinduism") echo 'selected="selected"'; ?>>Hinduism</option>
                                    <option value="Islam" <?php if (isset($student['religion']) && $student['religion'] == "Islam") echo 'selected="selected"'; ?>>Islam</option>
                                    <option value="Jainism" <?php if (isset($student['religion']) && $student['religion'] == "Jainism") echo 'selected="selected"'; ?>>Jainism</option>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please choose a religion.</div>
                            </div>


                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustom01" class="form-label">Social Strata *</label>
                                <select class="select2 form-control form-select" name="social" required>
                                    <option value="">Select</option>
                                    <option value="BC" <?php if (isset($student['social']) && $student['social'] == "BC") echo 'selected="selected"'; ?>>BC</option>
                                    <option value="BCM" <?php if (isset($student['social']) && $student['social'] == "BCM") echo 'selected="selected"'; ?>>BCM</option>
                                    <option value="MBC" <?php if (isset($student['social']) && $student['social'] == "MBC") echo 'selected="selected"'; ?>>MBC</option>
                                    <option value="OC" <?php if (isset($student['social']) && $student['social'] == "OC") echo 'selected="selected"'; ?>>OC</option>
                                    <option value="SS" <?php if (isset($student['social']) && $student['social'] == "SS") echo 'selected="selected"'; ?>>SC / ST</option>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please select social strata.</div>
                            </div>
                        </div>
                        <!-- Caste -->
                        <div class="row">
                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustom02" class="form-label">Caste *</label>
                                <input type="text" class="form-control" name="caste" id="validationCustom02" required
                                    value="<?php echo (mysqli_num_rows($query_run) == 1) ? $student['caste'] : ""; ?>" placeholder="Enter your caste">
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter Caste.</div>
                            </div>



                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustomUsername" class="form-label">Marital status *</label>
                                <select class="select2 form-control form-select" name="ms" required>
                                    <option value="">Select</option>
                                    <option value="Single" <?php if (isset($student['ms']) && $student['ms'] == "Single") echo 'selected="selected"'; ?>>Single</option>
                                    <option value="Married" <?php if (isset($student['ms']) && $student['ms'] == "Married") echo 'selected="selected"'; ?>>Married</option>
                                    <option value="Widowed" <?php if (isset($student['ms']) && $student['ms'] == "Widowed") echo 'selected="selected"'; ?>>Widowed</option>
                                    <option value="Divorced" <?php if (isset($student['ms']) && $student['ms'] == "Divorced") echo 'selected="selected"'; ?>>Divorced</option>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please choose a Marital status.</div>
                            </div>

                            <!-- <div class="col-md-4 mb-3">
                                                <label for="validationCustomUsername">Physically / Mentally Challenged *</label>
                                                <select class="select2 form-control custom-select" name="pmc" required>
                                                    <option value="">Select</option>
                                                    <option value="No" <?php if (isset($student['pmc']) && $student['pmc'] == "No") echo 'selected="selected"'; ?>>No</option>
                                                    <option value="Yes" <?php if (isset($student['pmc']) && $student['pmc'] == "Yes") echo 'selected="selected"'; ?>>Yes</option>
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please choose physical status.</div>
                                            </div> -->


                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustom02" class="form-label">Physical Identification *</label>
                                <input type="text" class="form-control" name="pim1" id="validationCustom02" required
                                    value="<?php echo (mysqli_num_rows($query_run) == 1) ? $student['pim1'] : ""; ?>" placeholder="Enter Physical Identification Mark 1">
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter Physical Identification Mark 1.</div>
                            </div>

                        </div>
                        <!-- Blood Group -->
                        <div class="row">

                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustom01" class="form-label">Blood Group </label>
                                <select class="select2 form-control form-select" name="blood" id="validationCustom01" required>
                                    <option value="">Select Blood Group</option>
                                    <option value="A+VE" <?php if (isset($student['blood']) && $student['blood'] == "A+VE") echo 'selected="selected"'; ?>>A+VE</option>
                                    <option value="A-VE" <?php if (isset($student['blood']) && $student['blood'] == "A-VE") echo 'selected="selected"'; ?>>A-VE</option>
                                    <option value="B+VE" <?php if (isset($student['blood']) && $student['blood'] == "B+VE") echo 'selected="selected"'; ?>>B+VE</option>
                                    <option value="B-VE" <?php if (isset($student['blood']) && $student['blood'] == "B-VE") echo 'selected="selected"'; ?>>B-VE</option>
                                    <option value="O+VE" <?php if (isset($student['blood']) && $student['blood'] == "O+VE") echo 'selected="selected"'; ?>>O+VE</option>
                                    <option value="O-VE" <?php if (isset($student['blood']) && $student['blood'] == "O-VE") echo 'selected="selected"'; ?>>O-VE</option>
                                    <option value="AB+VE" <?php if (isset($student['blood']) && $student['blood'] == "AB+VE") echo 'selected="selected"'; ?>>AB+VE</option>
                                    <option value="AB-VE" <?php if (isset($student['blood']) && $student['blood'] == "AB-VE") echo 'selected="selected"'; ?>>AB-VE</option>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please select blood group.</div>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustom02" class="form-label">Official contact Number *</label>
                                <input type="text" class="form-control" name="mobile" id="validationCustom02"
                                    value="<?php echo (mysqli_num_rows($query_run) == 1) ? $student['mobile'] : ""; ?>" placeholder="Enter Mobile Number">
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter mobile number.</div>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustom02" class="form-label">Personal contact Number </label>
                                <input type="text" class="form-control" name="pmobile" id="validationCustom02"
                                    value="<?php echo (mysqli_num_rows($query_run) == 1) ? $student['pmobile'] : ""; ?>" placeholder="Enter Mobile Number">
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter mobile number.</div>
                            </div>

                        </div>
 <!-- Email -->
 <div class="row">
                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustomUsername" class="form-label">Offical Email ID* </label>
                                <div class="input-group">
                                    <input type="mail" class="form-control" name="email" id="validationCustom02"
                                        value="<?php echo (mysqli_num_rows($query_run) == 1) ? $student['email'] : ""; ?>" placeholder="Enter Email ID" required>
                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Please enter email id.</div>
                                </div>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="" class="form-label">Personal Email ID* </label>
                                <div class="input-group">
                                    <input type="mail" class="form-control" name="pemail" id="validationCustom02"
                                        value="<?php echo (mysqli_num_rows($query_run) == 1) ? $student['pemail'] : ""; ?>" placeholder="Enter Email ID" required>
                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Please enter email id.</div>
                                </div>
                            </div>





                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustom02" class="form-label">Aadhar Number *</label>
                                <input type="text" class="form-control" name="aadhar_num" id="validationCustom02"
                                    value="<?php echo (mysqli_num_rows($query_run) == 1) ? $student['aadhar_num'] : ""; ?>" placeholder="Aadhar_Number" required>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter Aadhar Number.</div>
                            </div>

                        </div>
                        <!-- AICTE ID -->
                        <div class="row">
                            <!-- AICTE ID -->

                            <div class="form-group col-md-4 mb-3">
                                <label for="aicte_id" class="form-label">AICTE ID *</label>
                                <input type="text" name="aicte_id" class="form-control" id="aicte_id" placeholder="Enter AICTE ID"
                                    value="<?php echo isset($student['aicte_id']) ? $student['aicte_id'] : ''; ?>" required>
                            </div>

                            <!-- VIDWAN ID -->

                            <div class="form-group col-md-4 mb-3">
                                <label for="vidwan_id" class="form-label">VIDWAN ID *</label>
                                <input type="text" name="vidwan_id" class="form-control" id="vidwan_id" placeholder="Enter VIDWAN ID"
                                    value="<?php echo isset($student['vidwan_id']) ? $student['vidwan_id'] : ''; ?>" required>
                            </div>

                            <!-- Anna University ID -->

                            <div class="form-group col-md-4 mb-3">
                                <label for="anna_univ_id" class="form-label">Anna University ID *</label>
                                <input type="text" name="anna_univ_id" class="form-control" id="anna_univ_id" placeholder="Enter Anna University ID"
                                    value="<?php echo isset($student['anna_univ_id']) ? $student['anna_univ_id'] : ''; ?>" required>
                            </div>
                        </div>
                        <!-- Address -->
                        <div class="row">
                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustom04" class="form-label">Temporary Address *</label>
                                <input type="text" class="form-control" name="taddress" id="validationCustom04" required
                                    value="<?php echo (mysqli_num_rows($query_run) == 1) ? $student['taddress'] : ""; ?>" placeholder="Temporary Address">
                                <div class="invalid-feedback">Please enter a temporary address.</div>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustom03" class="form-label">Permanent Address *</label>
                                <input type="text" class="form-control" name="paddress" id="validationCustom03" required
                                    value="<?php echo (mysqli_num_rows($query_run) == 1) ? $student['paddress'] : ""; ?>" placeholder="Permanent Address">
                                <div class="invalid-feedback">Please enter a permanent address.</div>
                            </div>

                            <!-- Dayscholar/Hosteller Status -->

                            <div class="form-group col-md-4 mb-3">
                                <label for="status" class="form-label">Accommodation Type *</label>
                                <select name="status" class="select2 form-control form-select" id="status" onchange="toggleFields()" required>
                                    <option value="">Select Status</option>
                                    <option value="Dayscholar" <?php if (isset($student['status']) && $student['status'] == "Dayscholar") echo 'selected="selected"'; ?>>Dayscholar</option>
                                    <option value="Hosteller" <?php if (isset($student['status']) && $student['status'] == "Hosteller") echo 'selected="selected"'; ?>>Hosteller</option>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please select faculty status.</div>
                            </div>
                        </div>
                        <!-- Dayscholar fields -->
                        <div class="row">
                            <div class="form-group col-md-4 mb-3" id="transportField" style="display: none;">
                                <label for="transport_mode" class="form-label">Mode of Transportation *</label>
                                <select name="transport_mode" class="select2 form-control form-select" id="transport_mode">
                                    <option value="">Select Mode</option>
                                    <option value="Own Vehicle" <?php if (isset($student['transport_mode']) && $student['transport_mode'] == "Own Vehicle") echo 'selected="selected"'; ?>>Own Vehicle</option>
                                    <option value="Public Transport" <?php if (isset($student['transport_mode']) && $student['transport_mode'] == "Public Transport") echo 'selected="selected"'; ?>>Public Transport</option>
                                    <option value="College Bus" <?php if (isset($student['transport_mode']) && $student['transport_mode'] == "College Bus") echo 'selected="selected"'; ?>>College Bus</option>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please select mode of transportation.</div>
                            </div>

                            <div class="form-group col-md-4 mb-3" id="boardingField" style="display: none;">
                                <label for="boarding_point" class="form-label">Boarding Point (if applicable)</label>
                                <input type="text" name="boarding_point" class="form-control" id="boarding_point"
                                    placeholder="Enter Boarding Point"
                                    value="<?php echo (isset($student['boarding_point'])) ? $student['boarding_point'] : ""; ?>">
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter boarding point.</div>
                            </div>

                            <!-- Hosteller fields -->

                            <div class="form-group col-md-4 mb-3" id="hostelField" style="display: none;">
                                <label for="hostel_name" class="form-label">Hostel *</label>
                                <select name="hostel_name" class="select2 form-control custom-select" id="hostel_name">
                                    <option value="">Select Hostel</option>
                                    <option value="Vedha" <?php if (isset($student['hostel_name']) && $student['hostel_name'] == "Vedha") echo 'selected="selected"'; ?>>Vedha</option>
                                    <option value="Octa" <?php if (isset($student['hostel_name']) && $student['hostel_name'] == "Octa") echo 'selected="selected"'; ?>>Octa</option>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please select hostel.</div>
                            </div>


                            <div class="form-group col-md-4 mb-3" id="roomField" style="display: none;">
                                <label for="room_no" class="form-label">Room No *</label>
                                <input type="text" name="room_no" class="form-control" id="room_no"
                                    placeholder="Enter Room Number"
                                    value="<?php echo (isset($student['room_no'])) ? $student['room_no'] : ""; ?>">
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter room number.</div>
                            </div>
                            <div class="form-group col-md-4 mb-3" id="busNo" style="display: none;">
                                <label for="busNo" class="form-label">Bus No (if applicable)</label>
                                <input type="text" name="busNo" class="form-control" id="bus_no"
                                    placeholder="Enter Bus No."
                                    value="<?php echo (isset($student['bus_no'])) ? $student['bus_no'] : ""; ?>">
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter bus number.</div>
                            </div>
                        </div>


                        <!-- State -->
                        <div class="row">

                            <div class="form-group col-md-3 mb-3">
                                <label for="validationCustom04" class="form-label">State *</label>
                                <select class="select2 form-control form-select" name="state" id="inputState" required>
                                    <option value="">Select State</option>
                                    <option value="Andra Pradesh" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Andra Pradesh') ? 'selected' : ''; ?>>Andra Pradesh</option>
                                    <option value="Arunachal Pradesh" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Arunachal Pradesh') ? 'selected' : ''; ?>>Arunachal Pradesh</option>
                                    <option value="Assam" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Assam') ? 'selected' : ''; ?>>Assam</option>
                                    <option value="Bihar" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Bihar') ? 'selected' : ''; ?>>Bihar</option>
                                    <option value="Chhattisgarh" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Chhattisgarh') ? 'selected' : ''; ?>>Chhattisgarh</option>
                                    <option value="Goa" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Goa') ? 'selected' : ''; ?>>Goa</option>
                                    <option value="Gujarat" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Gujarat') ? 'selected' : ''; ?>>Gujarat</option>
                                    <option value="Haryana" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Haryana') ? 'selected' : ''; ?>>Haryana</option>
                                    <option value="Himachal Pradesh" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Himachal Pradesh') ? 'selected' : ''; ?>>Himachal Pradesh</option>
                                    <option value="Jammu and Kashmir" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Jammu and Kashmir') ? 'selected' : ''; ?>>Jammu and Kashmir</option>
                                    <option value="Jharkhand" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Jharkhand') ? 'selected' : ''; ?>>Jharkhand</option>
                                    <option value="Karnataka" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Karnataka') ? 'selected' : ''; ?>>Karnataka</option>
                                    <option value="Kerala" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Kerala') ? 'selected' : ''; ?>>Kerala</option>
                                    <option value="Madya Pradesh" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Madya Pradesh') ? 'selected' : ''; ?>>Madya Pradesh</option>
                                    <option value="Maharashtra" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Maharashtra') ? 'selected' : ''; ?>>Maharashtra</option>
                                    <option value="Manipur" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Manipur') ? 'selected' : ''; ?>>Manipur</option>
                                    <option value="Meghalaya" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Meghalaya') ? 'selected' : ''; ?>>Meghalaya</option>
                                    <option value="Mizoram" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Mizoram') ? 'selected' : ''; ?>>Mizoram</option>
                                    <option value="Nagaland" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Nagaland') ? 'selected' : ''; ?>>Nagaland</option>
                                    <option value="Orissa" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Orissa') ? 'selected' : ''; ?>>Orissa</option>
                                    <option value="Punjab" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Punjab') ? 'selected' : ''; ?>>Punjab</option>
                                    <option value="Rajasthan" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Rajasthan') ? 'selected' : ''; ?>>Rajasthan</option>
                                    <option value="Sikkim" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Sikkim') ? 'selected' : ''; ?>>Sikkim</option>
                                    <option value="Tamil Nadu" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Tamil Nadu') ? 'selected' : ''; ?>>Tamil Nadu</option>
                                    <option value="Telangana" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Telangana') ? 'selected' : ''; ?>>Telangana</option>
                                    <option value="Tripura" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Tripura') ? 'selected' : ''; ?>>Tripura</option>
                                    <option value="Uttaranchal" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Uttaranchal') ? 'selected' : ''; ?>>Uttaranchal</option>
                                    <option value="Uttar Pradesh" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Uttar Pradesh') ? 'selected' : ''; ?>>Uttar Pradesh</option>
                                    <option value="West Bengal" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'West Bengal') ? 'selected' : ''; ?>>West Bengal</option>
                                    <option disabled style="background-color:#aaa; color:#fff">UNION Territories</option>
                                    <option value="Andaman and Nicobar Islands" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Andaman and Nicobar Islands') ? 'selected' : ''; ?>>Andaman and Nicobar Islands</option>
                                    <option value="Chandigarh" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Chandigarh') ? 'selected' : ''; ?>>Chandigarh</option>
                                    <option value="Dadar and Nagar Haveli" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Dadar and Nagar Haveli') ? 'selected' : ''; ?>>Dadar and Nagar Haveli</option>
                                    <option value="Daman and Diu" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Daman and Diu') ? 'selected' : ''; ?>>Daman and Diu</option>
                                    <option value="Delhi" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Delhi') ? 'selected' : ''; ?>>Delhi</option>
                                    <option value="Lakshadeep" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Lakshadeep') ? 'selected' : ''; ?>>Lakshadeep</option>
                                    <option value="Pondicherry" <?php echo (mysqli_num_rows($query_run) == 1 && $student['state'] == 'Pondicherry') ? 'selected' : ''; ?>>Pondicherry</option>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please choose state.</div>
                            </div>


                            <div class="form-group col-md-3 mb-3">
                                <label for="validationCustom04" class="form-label">City *</label>
                                <select class="select2 form-control custom-select" name="city" id="inputDistrict" required>
                                    <option value="">-- select one -- </option>
                                    <?php if (mysqli_num_rows($query_run) == 1 && !empty($student['city'])): ?>
                                        <option value="<?php echo $student['city']; ?>" selected><?php echo $student['city']; ?></option>
                                    <?php endif; ?>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please choose city.</div>
                            </div>


                            <div class="form-group col-md-3 mb-3">
                                <label for="validationCustom05" class="form-label">Zip *</label>
                                <input type="text" class="form-control" name="zip" id="validationCustom05" required
                                    value="<?php echo (mysqli_num_rows($query_run) == 1) ? $student['zip'] : ""; ?>" placeholder="Zip">
                                <div class="invalid-feedback">Please provide a valid zip.</div>
                            </div>

                            <div class="form-group col-md-3 mb-3">
                                <label for="validationCustom05" class="form-label">Country *</label>
                                <select class="select2 form-control form-select" id="country" name="country" required>
                                    <option value="">Select</option>
                                    <?php
                                    $countries = [
                                        "Afghanistan",
                                        "Åland Islands",
                                        "Albania",
                                        "Algeria",
                                        "American Samoa",
                                        "Andorra",
                                        "Angola",
                                        "Anguilla",
                                        "Antarctica",
                                        "Antigua and Barbuda",
                                        "Argentina",
                                        "Armenia",
                                        "Aruba",
                                        "Australia",
                                        "Austria",
                                        "Azerbaijan",
                                        "Bahamas",
                                        "Bahrain",
                                        "Bangladesh",
                                        "Barbados",
                                        "Belarus",
                                        "Belgium",
                                        "Belize",
                                        "Benin",
                                        "Bermuda",
                                        "Bhutan",
                                        "Bolivia",
                                        "Bosnia and Herzegovina",
                                        "Botswana",
                                        "Bouvet Island",
                                        "Brazil",
                                        "British Indian Ocean Territory",
                                        "Brunei Darussalam",
                                        "Bulgaria",
                                        "Burkina Faso",
                                        "Burundi",
                                        "Cambodia",
                                        "Cameroon",
                                        "Canada",
                                        "Cape Verde",
                                        "Cayman Islands",
                                        "Central African Republic",
                                        "Chad",
                                        "Chile",
                                        "China",
                                        "Christmas Island",
                                        "Cocos (Keeling) Islands",
                                        "Colombia",
                                        "Comoros",
                                        "Congo",
                                        "Congo, The Democratic Republic of The",
                                        "Cook Islands",
                                        "Costa Rica",
                                        "Cote D'ivoire",
                                        "Croatia",
                                        "Cuba",
                                        "Cyprus",
                                        "Czech Republic",
                                        "Denmark",
                                        "Djibouti",
                                        "Dominica",
                                        "Dominican Republic",
                                        "Ecuador",
                                        "Egypt",
                                        "El Salvador",
                                        "Equatorial Guinea",
                                        "Eritrea",
                                        "Estonia",
                                        "Ethiopia",
                                        "Falkland Islands (Malvinas)",
                                        "Faroe Islands",
                                        "Fiji",
                                        "Finland",
                                        "France",
                                        "French Guiana",
                                        "French Polynesia",
                                        "French Southern Territories",
                                        "Gabon",
                                        "Gambia",
                                        "Georgia",
                                        "Germany",
                                        "Ghana",
                                        "Gibraltar",
                                        "Greece",
                                        "Greenland",
                                        "Grenada",
                                        "Guadeloupe",
                                        "Guam",
                                        "Guatemala",
                                        "Guernsey",
                                        "Guinea",
                                        "Guinea-bissau",
                                        "Guyana",
                                        "Haiti",
                                        "Heard Island and Mcdonald Islands",
                                        "Holy See (Vatican City State)",
                                        "Honduras",
                                        "Hong Kong",
                                        "Hungary",
                                        "Iceland",
                                        "India",
                                        "Indonesia",
                                        "Iran, Islamic Republic of",
                                        "Iraq",
                                        "Ireland",
                                        "Isle of Man",
                                        "Israel",
                                        "Italy",
                                        "Jamaica",
                                        "Japan",
                                        "Jersey",
                                        "Jordan",
                                        "Kazakhstan",
                                        "Kenya",
                                        "Kiribati",
                                        "Korea, Democratic People's Republic of",
                                        "Korea, Republic of",
                                        "Kuwait",
                                        "Kyrgyzstan",
                                        "Lao People's Democratic Republic",
                                        "Latvia",
                                        "Lebanon",
                                        "Lesotho",
                                        "Liberia",
                                        "Libyan Arab Jamahiriya",
                                        "Liechtenstein",
                                        "Lithuania",
                                        "Luxembourg",
                                        "Macao"
                                    ];

                                    foreach ($countries as $country) {
                                        $selected = (mysqli_num_rows($query_run) == 1 && $student['country'] == $country) ? 'selected' : '';
                                        echo "<option value='" . $country . "' " . $selected . ">" . $country . "</option>";
                                    }
                                    ?>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please choose country.</div>
                            </div>

                        </div>
                       
                        <!-- Aadhar Section -->
                        <div class="row">

                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustomUsername" class="form-label">Aadhar Photo *</label>
                                <?php
                                $existing_aadhar = (mysqli_num_rows($query_run) == 1) ? $student['aadhar'] : "";
                                ?>
                                <div class="input-group">
                                    <input type="file" class="form-control custom-file-input" name="aadhar"
                                        id="validationCustomAadhar"
                                        onchange="return fileValidation('validationCustomAadhar')"
                                        <?php echo $existing_aadhar ? '' : 'required'; ?>>

                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Please choose an aadhar photo.</div>
                                </div>
                                <?php if ($existing_aadhar): ?>
                                    <div class="mb-2">
                                    <span class="text-muted">Current file: 
<a href="<?php echo $existing_aadhar; ?>" target="_blank"><?php echo basename($existing_aadhar); ?></a>
</span>
                                        
                                        <input type="hidden" name="existing_aadhar" value="<?php echo $existing_aadhar; ?>">
                                    </div>
                                <?php endif; ?>
                            </div>





                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustom02" class="form-label">Pan Number *</label>
                                <input type="text" class="form-control" name="pan_num" id="validationCustom02"
                                    value="<?php echo (mysqli_num_rows($query_run) == 1) ? $student['pan_num'] : ""; ?>" placeholder="Pan_Number" required>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter Pan Number.</div>
                            </div>

                            <!-- PAN Field -->

                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustomUsername" class="form-label">PAN Photo*</label>
                                <?php
                                $existing_pan = (mysqli_num_rows($query_run) == 1) ? $student['pan'] : "";
                                ?>
                                <div class="input-group">
                                    <input type="file" class="form-control custom-file-input" name="pan"
                                        id="validationCustomPAN"
                                        onchange="return fileValidation('validationCustomPAN')"
                                        <?php echo $existing_pan ? '' : 'required'; ?>>

                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Please choose a PAN photo.</div>
                                </div>
                                <?php if ($existing_pan): ?>
                                    <div class="mb-2">
                                    <span class="text-muted">Current file: 
<a href="<?php echo $existing_pan; ?>" target="_blank"><?php echo basename($existing_pan); ?></a>
</span>
                                        
                                        <input type="hidden" name="existing_pan" value="<?php echo $existing_pan; ?>">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 mb-3">
                                <label for="validationCustom02" class="form-label">Highest Qualification *</label>
                                <input type="text" class="form-control" name="highest_qualification" id="validationCustom02"
                                    value="<?php echo (mysqli_num_rows($query_run) == 1) ? $student['qualification'] : ""; ?>" placeholder="Aadhar_Number" required>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter Aadhar Number.</div>
                            </div>
                            <div class="form-group col-md-4 mb-3">
    <label for="net_status" class="form-label">NET Status *</label>
    <select class="form-control" name="net" id="net_status" required>
        <option value="">Select</option>
        <option value="clear"<?php if (isset($student['net']) && $student['net'] == "clear") echo ' selected="selected"'; ?>>Clear</option>
        <option value="not_clear"<?php if (isset($student['net']) && $student['net'] == "not_clear") echo ' selected="selected"'; ?>>Not Clear</option>
    </select>
    <div class="valid-feedback">Looks good!</div>
    <div class="invalid-feedback">Please select NET status.</div>
</div>

<!-- NET Certificate Upload -->
<div class="form-group col-md-4 mb-3" id="net_pdf_upload" style="display: none;">
    <label for="net_certificate" class="form-label">Upload NET Certificate *</label>
    <?php
    $existing_netcer = (mysqli_num_rows($query_run) == 1) ? $student['netcer'] : "";
    ?>
    <div class="input-group">
        <input type="file" class="form-control custom-file-input" name="netcer"
            id="net_certificate"
            onchange="return fileValidation('net_certificate')"
            <?php echo $existing_netcer ? '' : 'required'; ?>>

        <div class="valid-feedback">Looks good!</div>
        <div class="invalid-feedback">Please choose a NET certificate.</div>
    </div>

    <!-- Display existing file -->
    <?php if ($existing_netcer): ?>
        <div class="mb-2">
            <span class="text-muted">Current file: 
                <a href="<?php echo $existing_netcer; ?>" target="_blank"><?php echo basename($existing_netcer); ?></a>
            </span>
            <input type="hidden" name="existing_netcer" value="<?php echo $existing_netcer; ?>">
            
        </div>
    <?php endif; ?>
</div>

<div class="form-group col-md-4 mb-3">
    <label for="set_status" class="form-label">SET Status *</label>
    <select class="form-control" name="setexam" id="set_status" required>
        <option value="">Select</option>
        <option value="clear"<?php if (isset($student['setexam']) && $student['setexam'] == "clear") echo ' selected="selected"'; ?>>Clear</option>
        <option value="not_clear"<?php if (isset($student['setexam']) && $student['setexam'] == "not_clear") echo ' selected="selected"'; ?>>Not Clear</option>
    </select>
    <div class="valid-feedback">Looks good!</div>
    <div class="invalid-feedback">Please select SET status.</div>
</div>

<!-- SET Certificate Upload -->
<div class="form-group col-md-4 mb-3" id="set_pdf_upload" style="display: none;">
    <label for="set_certificate" class="form-label">Upload SET Certificate *</label>
    <?php
    $existing_setcer = (mysqli_num_rows($query_run) == 1) ? $student['setcer'] : "";
    ?>
    <div class="input-group">
        <input type="file" class="form-control custom-file-input" name="setcer"
            id="set_certificate"
            onchange="return fileValidation('set_certificate')"
            <?php echo $existing_setcer ? '' : 'required'; ?>>

        <div class="valid-feedback">Looks good!</div>
        <div class="invalid-feedback">Please choose a SET certificate.</div>
    </div>

    <!-- Display existing file -->
    <?php if ($existing_setcer): ?>
        <div class="mb-2">
            <span class="text-muted">Current file: 
                <a href="<?php echo $existing_setcer; ?>" target="_blank"><?php echo basename($existing_setcer); ?></a>
            </span>
            <input type="hidden" name="existing_setcer" value="<?php echo $existing_setcer; ?>">
        </div>
    <?php endif; ?>
</div>


                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
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
                                        <button type="button" style="float: right;" class="btn btn-secondary " data-bs-toggle="modal" data-bs-target="#studentAddModal">
                                            Add details
                                        </button>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="myTable" class="table table-bordered table-striped">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>Degree</b></th>
                                                    <th><b>Institution Name</b></th>
                                                    <th><b>Board/University</b></th>
                                                    <th></b>Mark</b></th>
                                                    <th class="text-center"><b>View Certificate</b></th>
                                                    <th></b>View Details</b></th>
                                                    <th class="text-center"><b>Action</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT * FROM academic WHERE id='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    foreach ($query_run as $student) {

                                                        $mark = empty($student['score']) ? "NA" : $student['score'];
                                                ?>
                                                        <tr>
                                                            <td><?= $student['Degree'] ?></td>
                                                            <td><?= $student['iname'] ?></td>
                                                            <td><?= $student['univ'] ?></td>
                                                            <td><?= $mark ?></td>
                                                            <td align="center" style="text-align: center; vertical-align: middle; height: 100px;">
                                                                <img src="images/icon/certificate.png"
                                                                    class="action-icon btnimg"
                                                                    alt="View"
                                                                    data-action="cert"
                                                                    data-student-id="<?= $student['uid']; ?>"
                                                                    title="View Certificate"
                                                                    style="cursor: pointer;">
                                                            </td>
<td class="text-center"> <button type="button" class="btn btn-sm btn-info viewStudentAction" data-action="view" data-student-id="<?= $student['uid']; ?>" title="View">
                                                                    View
                                                                </button></td>
                                                            <td class="text-center" style="width: 150px;">
                                                                <!-- View Button -->
                                                               

                                                                <!-- Edit Button -->
                                                                <button type="button" class="btn btn-sm btn-warning editStudentBtn" data-action="edit" data-student-id="<?= $student['uid']; ?>" title="Edit">
                                                                    Edit
                                                                </button>

                                                                <button type="button" class="btn btn-sm btn-danger  deleteStudentBtn" data-action="delete" data-student-id="<?= $student['uid']; ?>" title="Delete" >
                                                                    Delete
                                                                </button>

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




                    <!-- <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>NET/SET Clearance</h4>
                                </div>
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="" class="form-label">NET/SET Clearance *</label>
                                                <select class="select2 form-control form-select" name="net_set" required>
                                                    <option value="">Select</option>
                                                    <option value="Cleared">Cleared</option>
                                                    <option value="Not Cleared">Not Cleared</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="" class="form-label">NET/SET Certificate Upload</label>
                                                <div class="input-group">
                                                    <input type="file" class="form-control custom-file-input" name="net_set_cert"
                                                        id="uploadNetSetFile" onchange="return fileValidation2()" aria-describedby="inputGroupPrepend">
                                                </div>
                                                <p style="color:red;" id="netSetError"></p>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>

                <!-- tab3 -->
                <div class="tab-pane p-20" id="messages" role="tabpanel">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" style="border: none;">

                                <div class="card-header" style="border: none;">
                                    <h4> <button type="button" style="float: right;"
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
                                                    <th><b>Gender</b></th>
                                                    <th><b>Relationship</b></th>
                                                    <th><b>Mobile Number</b></th>
                                                    <th align="center"><b>Action</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php


                                                $query = "SELECT * FROM family where id='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    $sss = 1;
                                                    foreach ($query_run as $student) {

                                                ?>
                                                        <tr>
                                                            <td><?= $sss ?></td>
                                                            <td><?= $student['name'] ?></td>
                                                            <td><?= $student['gender'] ?></td>
                                                            <td><?= $student['relationship'] ?></td>
                                                            <td><?= $student['mobile'] ?></td>
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


                <!-- Medical Record Tab -->


                <div class="tab-pane p-20" id="medical" role="tabpanel">
                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-header" style="border: none;">

                            <h4 class="mb-0">Medical Record</h4>
                        </div>

                        <div class="card-body">

                            <?php
                            $query = "SELECT * FROM basic WHERE id='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) >= 0) {
                                $student = mysqli_fetch_array($query_run);
                            }
                            ?>


                            <div id="errorresearch" class="alert alert-warning d-none"></div>

                            <form id="medical" class="needs-validation" novalidate>
                                <div class="row g-4">

                                    <div class="col-md-6">
                                        <label for="validationCustom01" class="form-label">Major Surgery Undergone(if any)</label>
                                        <input type="text" name="sur" class="form-control" id="validationCustom01" placeholder="Surgery info"
                                            value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                        echo $student['surgery'];
                                                    } else {
                                                        echo "";
                                                    } ?>">
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom02" class="form-label">Medical Insurance(if any)</label>
                                        <input type="text" class="form-control" name="ins"
                                            id="validationCustom02" placeholder="Insurance info"
                                            value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                        echo $student['insurance'];
                                                    } else {
                                                        echo "";
                                                    } ?>">
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>

                                </div>
                                <div class="text-end mt-4">
                                    <button class="btn btn-primary " type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Nominee Tab -->


                <div class="tab-pane p-20" id="nominee" role="tabpanel">
                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-header" style="border: none;">
                            <h4> Nominee Details </h4>
                        </div>

                        <div class="card-body">

                            <?php
                            $query = "SELECT * FROM nominee WHERE id='$s'";
                            $query_run = mysqli_query($db, $query);

                            if (mysqli_num_rows($query_run) >= 0) {
                                $student5 = mysqli_fetch_array($query_run);
                            }


                            ?>
                            <div id="errornominee" class="alert alert-warning d-none"></div>
                            <form id="nominee" class="needs-validation" novalidate>
                                <div class="row g-4">

                                    <div class="col-md-4">
                                        <label for="" class="form-label">Choose Nominee * </label>

                                        <select class="form-control" name="name" id="student"
                                            value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                        echo $student5['name'];
                                                    } else {
                                                        echo "";
                                                    } ?>"
                                            required>
                                            <?php
                                            $query2 = "SELECT name FROM family WHERE id='$s'";
                                            $query_run2 = mysqli_query($db, $query2);

                                            if (mysqli_num_rows($query_run2) >= 0) {
                                                while ($optionData = $query_run2->fetch_assoc()) {
                                                    $option = $optionData['name'];


                                            ?>
                                                    <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>


                                    <div class="col-md-4">
                                        <label for="" class="form-label">Nomination for *</label>
                                        <select class="form-control" name="type" id="gender"
                                            value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                        echo $student5['type'];
                                                    } else {
                                                        echo "";
                                                    } ?>"
                                            required>
                                            <option value="">Select</option>
                                            <option value="Family Benefit">Family Benefit</option>
                                            <option value="PF">PF</option>
                                            <option value="Death cum retirement gratuity">Death cum retirement
                                                gratuity</option>
                                        </select>
                                    </div>


                                    <div class="col-md-4">
                                        <label for="" class="form-label">Amount of share of gratuity payable *</label>
                                        <select class="form-control" name="share" id="gender"
                                            value="<?php if (mysqli_num_rows($query_run) == 1) {
                                                        echo $student5['share'];
                                                    } else {
                                                        echo "";
                                                    } ?>"
                                            required>
                                            <option value="">Select</option>
                                            <option value="20%">20%</option>
                                            <option value="50%">50%</option>
                                            <option value="75%">75%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-end mt-4">
                                    <button class="btn btn-primary " type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <!-- Form Add Academic -->


    <div class="modal fade" id="studentAddModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Add Academic Details</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="saveStudent">
                    <div class="modal-body">

                        <div id="errorMessage" class="alert alert-warning d-none"></div>

                        <div class="mb-3">
                            <label for="" class="form-label">Course *</label>
                            <select class="select2 form-control form-select" name="course" id="course"

                                onchange="if(this.value!='PHD'){this.form['score'].style.visibility='visible'}else {this.form['score'].style.visibility='hidden'};"
                                required>
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
                            <label for="validationCustom03" class="form-label">Degree *</label>
                            <select class="form-control" name="degree" id="degree" required>
                                <option value="">Select Degree</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Specialization / Branch *</label>
                            <input type="text" name="branch" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Institution Name *</label>
                            <input type="text" name="name" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Board/University *</label>
                            <input type="text" name="univ" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">District of Schooling *</label>
                            <input type="text" name="district_schooling" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">State *</label>
                            <select class="form-select" name="state">
                                <option value="">Select State</option>
                                <option value="Tamil Nadu">Tamil Nadu</option>
                                <option value="Karnataka">Karnataka</option>
                                <option value="Andhra Pradesh">Andhra Pradesh</option>
                                <option value="Kerala">Kerala</option>
                                <option value="Maharashtra">Maharashtra</option>
                                <!-- Other states omitted for brevity -->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Mode of Study *</label>
                            <select class="form-select" name="ms" required>
                                <option value="">Select Mode</option>
                                <option value="Full Time">Full Time</option>
                                <option value="Part Time">Part Time</option>
                                <option value="Distance">Distance</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Medium of Study *</label>
                            <input type="text" name="mes" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Completion Status *</label>
                            <select class="form-select" name="cs"
                                onchange="if(this.value=='Completed'){this.form['yc'].style.visibility='visible',this.form['score'].style.visibility='visible'}else {this.form['yc'].style.visibility='hidden',this.form['score'].style.visibility='hidden'};"
                                required>
                                <option value="">Select</option>
                                <option value="Completed">Completed</option>
                                <option value="Pursuing">Pursuing</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Year of Completion *</label>
                            <input type="text" name="yc" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Month and Year of Completion *</label>
                            <input type="month" name="myc" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Score Obtained (%)*</label>
                            <input type="text" name="score" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Certification Number *</label><br>

                            <input type="text" name="cnum" class="form-control" />
                        </div>



                        <div class="mb-3">
                            <label for="" class="form-label">Certificate *</label>
                            <label for="">(Upload less than 2MB)</label><br>

                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="cert" id="uploadFile"
                                    onchange="return fileValidation2()" aria-describedby="inputGroupPrepend" required>
                                <label class="custom-file-label" for="customFile"></label>
                            </div>
                            <p style="color:red;" id="tutorial"></p>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Highest Qualification *</label>
                            <select class="form-select" name="highest_qualification" required>
                                <option value="">Select Qualification</option>
                                <option value="B.E.">B.E.</option>
                                <option value="M.E.">M.E.</option>
                                <option value="Ph.D.">Ph.D.</option>
                                <option value="Post Doctoral">Post Doctoral</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save details</button>
                    </div>
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
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Edit details</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="updateStudent">
                    <div class="modal-body">

                        <div id="errorMessageUpdate" class="alert alert-warning d-none">
                        </div>

                        <input type="hidden" name="student_id" id="student_id">

                        <div class="mb-3">
                            <label for="" class="form-label">Course *</label>
                            <select class="form-select" name="course" id="course2"
                                required>
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
                            <label for="validationCustom03" class="form-label">Degree *</label>
                            <select class="form-control" name="degree" id="degree2"
                                required>
                                <option value="">Select Degree</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Specialization / Branch *</label>
                            <input type="text" name="branch" id="branch"
                                class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Institution Name *</label>
                            <input type="text" name="name" id="name"
                                class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Board/University *</label>
                            <input type="text" name="univ" id="univ"
                                class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">State *</label>
                            <select class="form-select" name="state" id="state">
                                <option value="">Select State</option>
                                <option value="Andra Pradesh">Andra Pradesh</option>
                                <option value="Arunachal Pradesh">Arunachal Pradesh
                                </option>
                                <option value="Assam">Assam</option>
                                <option value="Bihar">Bihar</option>
                                <option value="Chhattisgarh">Chhattisgarh</option>
                                <option value="Goa">Goa</option>
                                <option value="Gujarat">Gujarat</option>
                                <option value="Haryana">Haryana</option>
                                <option value="Himachal Pradesh">Himachal Pradesh
                                </option>
                                <option value="Jammu and Kashmir">Jammu and Kashmir
                                </option>
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
                                <option disabled
                                    style="background-color:#aaa; color:#fff">UNION
                                    Territories</option>
                                <option value="Andaman and Nicobar Islands">Andaman and
                                    Nicobar Islands</option>
                                <option value="Chandigarh">Chandigarh</option>
                                <option value="Dadar and Nagar Haveli">Dadar and Nagar
                                    Haveli</option>
                                <option value="Daman and Diu">Daman and Diu</option>
                                <option value="Delhi">Delhi</option>
                                <option value="Lakshadeep">Lakshadeep</option>
                                <option value="Pondicherry">Pondicherry</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Mode of Study *</label>
                            <select class="form-select" name="ms" id="ms" required>
                                <option value="">Select Degree</option>
                                <option value="Full Time">Full Time</option>
                                <option value="Part time">Part time</option>
                                <option value="Distance">Distance</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Medium of Study *</label>
                            <input type="text" name="mes" id="mes"
                                class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Year of Completion *</label>
                            <input type="text" name="yc" id="yc" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Completion Status *</label>
                            <select class="form-select" name="cs" id="cs" required>
                                <option value="">Select</option>
                                <option value="Completed">Completed</option>
                                <option value="Pursuing">Pursuing</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Score Obtained (%)*</label>
                            <input type="text" name="score" id="score"
                                class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Certification Number *</label>
                            <input type="text" name="cnum" id="cnum"
                                class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Certificate*</label>
                            <label for="">(upload less than 2 mb)</label>
                            <div class="input-group">
                                <input type="file"
                                    class="form-control custom-file-input" name="cert"
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
                        <button type="submit" class="btn btn-primary">Update
                            details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!-- View Student Modal -->
    <div class="modal fade" id="studentViewModal2" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="image" src="" alt="Computer man" class="center"
                        style="width:80%;height:80%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- View Student Modal -->
    <div class="modal fade" id="studentViewModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="">Course</label>
                        <p id="view_Course" class="form-control"></p>
                    </div>
                    <div class="mb-3">
                        <label for="">Degree</label>
                        <p id="view_Degree" class="form-control"></p>
                    </div>
                    <div class="mb-3">
                        <label for="">Specialization / Branch</label>
                        <p id="view_branch" class="form-control"></p>
                    </div>

                    <div class="mb-3">
                        <label for="">Institution Name</label>
                        <p id="view_iname" class="form-control"></p>
                    </div>
                    <div class="mb-3">
                        <label for="">Board/University</label>
                        <p id="view_univ" class="form-control"></p>
                    </div>
                    <div class="mb-3">
                        <label for="">State</label>
                        <p id="view_state" class="form-control"></p>
                    </div>
                    <div class="mb-3">
                        <label for="">Mode of Study</label>
                        <p id="view_mos" class="form-control"></p>
                    </div>
                    <div class="mb-3">
                        <label for="">Medium of Study</label>
                        <p id="view_mes" class="form-control"></p>
                    </div>
                    <div class="mb-3">
                        <label for="">Year of Completion</label>
                        <p id="view_yc" class="form-control"></p>
                    </div>
                    <div class="mb-3">
                        <label for="">Completion Status</label>
                        <p id="view_cs" class="form-control"></p>
                    </div>
                    <div class="mb-3">
                        <label for="">Score Obtained</label>
                        <p id="view_score" class="form-control"></p>
                    </div>
                    <div class="mb-3">
                        <label for="">Certification Number</label>
                        <p id="view_cn" class="form-control"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="familyadd" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Add family Details</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="familyadd2">
                    <div class="modal-body">

                        <div id="errorMessage" class="alert alert-warning d-none"></div>


                        <div class="mb-3">
                            <label for="" class="form-label">Name *</label>
                            <input type="text" name="name" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Gender *</label>
                            <select class="form-select" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Transgender">Transgender</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="relationship" class="form-label">Relationship *</label>
                            <select class="form-select" name="relationship" id="relationship">
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
                            <label for="mobile" class="form-label">Mobile *</label>
                            <input type="text" name="mobile" id="mobile" class="form-control" required pattern="[0-9]{10}" maxlength="10" placeholder="Enter your mobile number" />
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


    <!-- Edit family Details -->
    <div class="modal fade" id="studentEditModal2" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Edit Student</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="updatefamily">
                    <div class="modal-body">

                        <div id="errorMessageUpdate" class="alert alert-warning d-none">
                        </div>

                        <input type="hidden" name="student_id2" id="student_id2">


                        <div class="mb-3">
                            <label for="" class="form-label">Name *</label>
                            <input type="text" name="name" id="name2"
                                class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Gender *</label>
                            <select class="form-select" name="gender" id="gender"
                                required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Transgender">Transgender</option>
                            </select>
                        </div>
                        <div class="mb-3">Relationship *</label>
                            <select class="form-select" class="form-label" name="relationship"
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
                            <label for="" class="form-label">Mobile *</label>
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









    <!-- Footer -->
    <?php include 'footer.php'; ?>

    </div>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    function toggleCertificateField() {
        let netStatus = document.getElementById("net_status").value;
        let netField = document.getElementById("net_pdf_upload");
        let netInput = document.getElementById("net_certificate");

        // Show/hide NET certificate upload field
        if (netStatus === "clear" || netField.dataset.hasFile === "true") {
            netField.style.display = "block";
            if (netField.dataset.hasFile !== "true") {
                netInput.setAttribute("required", "required");
            }
        } else {
            netField.style.display = "none";
            netInput.removeAttribute("required");
        }
    }

    // Set a data attribute if a file exists
    let netField = document.getElementById("net_pdf_upload");
    <?php if ($existing_netcer): ?>
        netField.dataset.hasFile = "true";
    <?php endif; ?>

    // Attach event listeners
    document.getElementById("net_status").addEventListener("change", toggleCertificateField);

    // Run on page load
    toggleCertificateField();
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    function toggleCertificateField() {
        let setStatus = document.getElementById("set_status").value;
        let setField = document.getElementById("set_pdf_upload");
        let setInput = document.getElementById("set_certificate");

        // Show/hide SET certificate upload field
        if (setStatus === "clear" || setField.dataset.hasFile === "true") {
            setField.style.display = "block";
            if (setField.dataset.hasFile !== "true") {
                setInput.setAttribute("required", "required");
            }
        } else {
            setField.style.display = "none";
            setInput.removeAttribute("required");
        }
    }

    // Set a data attribute if a file exists
    let setField = document.getElementById("set_pdf_upload");
    <?php if ($existing_setcer): ?>
        setField.dataset.hasFile = "true";
    <?php endif; ?>

    // Attach event listener
    document.getElementById("set_status").addEventListener("change", toggleCertificateField);

    // Run on page load
    toggleCertificateField();
});
</script>

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
        document.getElementById("dob").addEventListener("change", function() {
            let dob = this.value;
            if (dob) {
                let dobDate = new Date(dob);
                let today = new Date();

                let years = today.getFullYear() - dobDate.getFullYear();
                let months = today.getMonth() - dobDate.getMonth();

                if (months < 0) {
                    years--;
                    months += 12;
                }

                document.getElementById("age").value = years + " Years, " + months + " Months";
            } else {
                document.getElementById("age").value = "";
            }
        });
    </script>
    <script>
        $(document).on('submit', 'form', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_net_set", true);
            console.log(formData);

            $.ajax({
                type: "POST",
                url: "code.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    var res = jQuery.parseJSON(response);
                    console.log(res.status);

                    if (res.status == 422) {
                        $('#netSetError').text(res.message).css("color", "red");
                    } else if (res.status == 200) {
                        $('#netSetError').text("");
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    } else if (res.status == 500) {
                        alert(res.message);
                    }
                }
            });
        });


        $(document).on('submit', '#saveStudent', function(e) {
            e.preventDefault(); // Prevent form submission

            var formData = new FormData(this); // Get form data
            formData.append("save_student", true); // Add custom parameter to the data

            // Perform AJAX request
            $.ajax({
                type: "POST",
                url: "code.php", // Path to your PHP handler
                data: formData,
                processData: false, // Don't process the data
                contentType: false, // Don't set content type
                success: function(response) {
                    var res = jQuery.parseJSON(response); // Parse the JSON response
                    console.log(res.status);

                    // Handle the response based on status
                    if (res.status == 422) {
                        // Show error message if status is 422
                        $('#errorMessage').removeClass('d-none');
                        $('#errorMessage').text(res.message);
                    } else if (res.status == 200) {
                        // Hide error message and show success message if status is 200
                        $('#errorMessage').addClass('d-none');
                        $('#studentAddModal').modal('hide'); // Close the modal
                        alertify.set('notifier', 'position', 'top-right'); // Position of success message
                        alertify.success(res.message); // Display success message

                        // Reload the academic table content

                        $('#myTable').load(location.href + " #myTable");


                    } else if (res.status == 500) {
                        // Handle server error (500)
                        $('#errorMessage').addClass('d-none');
                        $('#studentAddModal').modal('hide'); // Close the modal
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.error(res.message); // Display error message
                    }
                }
            });
        });



        $(document).on('click', '.editStudentBtn', function() {

            var student_id = $(this).data('student-id');

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

        $(document).on('click', '.viewStudentAction', function() {

            var student_id = $(this).data('student-id');
            var action = $(this).data('action');
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

            var student_id = $(this).data('student-id');
            //var action = $(this).data('cert');
            $.ajax({
                type: "GET",
                url: "code.php?student_id=" + student_id,
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









        $(document).on('click', '.deleteStudentBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id = $(this).data('student-id');
                $.ajax({
                    type: "POST",
                    url: "code.php",
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
                            alertify.error(res.message);

                            $('#myTable').load(location.href + " #myTable");
                        }
                    }
                });
            }
        });

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

        function fileValidation(inputId) {
            var fileInput = document.getElementById(inputId);
            var fileSize = (fileInput.files[0].size) / 1024;
            var filePath = fileInput.value;

            // Allowing file type
            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

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
        $(document).on('submit', '#basic', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_basic", true);
            console.log(formData);
            $.ajax({
                type: "POST",
                url: "code.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    var res = jQuery.parseJSON(response);
                    console.log(res.status);
                    if (res.status == 422) {
                        $('#Abasic').removeClass('d-none');
                        $('#Abasic').text(res.message);

                    } else if (res.status == 200) {

                        $('#Abasic').addClass('d-none');

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);



                    } else if (res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });



        $(document).on('submit', '#medical', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_medical", true);

            console.log(formData);

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


        $(document).on('submit', '#nominee', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_nominee", true);

            console.log(formData);

            $.ajax({
                type: "POST",
                url: "code.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errornominee').removeClass('d-none');
                        $('#errornominee').text(res.message);

                    } else if (res.status == 200) {

                        $('#errornominee').addClass('d-none');

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);



                    } else if (res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });


        $(document).on('submit', '#familyadd2', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_family", true);

            $.ajax({
                type: "POST",
                url: "code.php",
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
                        $('#nominee').load(location.href + " #nominee");

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
                            $('#nominee').load(location.href + " #nominee");
                        }
                    }
                });
            }
        });
    </script>

    <script>
        // Fallback for browsers that don't support type="month"
        document.addEventListener("DOMContentLoaded", function() {
            var completionDate = document.getElementById("completion_date");

            // Check if the browser supports type="month"
            var testInput = document.createElement("input");
            testInput.setAttribute("type", "month");

            if (testInput.type !== "month") {
                // Fallback: Change input type to text and apply a date format
                completionDate.setAttribute("type", "text");

                // Use a simple placeholder to guide users
                completionDate.setAttribute("placeholder", "YYYY-MM");

                // Ensure correct input format
                completionDate.addEventListener("input", function() {
                    this.value = this.value.replace(/[^0-9\-]/g, "").slice(0, 7);
                });
            }
        });
    </script>

    <script>
        function toggleFields() {
            const status = document.getElementById('status').value;

            // Get all toggleable fields
            const transportField = document.getElementById('transportField');
            const boardingField = document.getElementById('boardingField');
            const hostelField = document.getElementById('hostelField');
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
                document.getElementById('bus_No').value = '';

            } else if (status === 'Hosteller') {
                hostelField.style.display = 'block';
                roomField.style.display = 'block';
                // Reset dayscholar fields
                document.getElementById('transport_mode').value = '';
                document.getElementById('boarding_point').value = '';
            }
        }

        // Call the function on page load in case there's a pre-selected value
        document.addEventListener('DOMContentLoaded', toggleFields);
    </script>
    <script>
        document.querySelectorAll('.custom-file-input').forEach(function(input) {
            input.addEventListener('change', function(e) {
                // Update the label with the new filename
                var fileName = e.target.files[0] ? e.target.files[0].name : '';
                var nextSibling = e.target.nextElementSibling;

                if (fileName) {
                    nextSibling.innerText = fileName;
                } else {
                    // If no file is selected, check if there's an existing file
                    var existingFile = input.closest('.col-md-4').querySelector('input[type="hidden"]');
                    if (existingFile) {
                        nextSibling.innerText = 'Choose new file';
                    } else {
                        nextSibling.innerText = 'Choose file';
                    }
                }
            });
        });

        function fileValidation(inputId) {
            const input = document.getElementById(inputId);
            const existingFile = input.closest('.col-md-4').querySelector('input[type="hidden"]');

            // If there's no file selected and no existing file, mark as required
            if (!input.files[0] && !existingFile) {
                input.setCustomValidity('Please choose a file');
                return false;
            }

            input.setCustomValidity('');
            return true;
        }
    </script>


</body>



</html>