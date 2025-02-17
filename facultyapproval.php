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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   

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

        /* Table Styles */
        .gradient-header {
            --bs-table-bg: transparent;
            --bs-table-color: white;
            background: linear-gradient(135deg, #4CAF50, #2196F3) !important;

            text-align: center;
            font-size: 0.9em;
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
        <div class="breadcrumb-area">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="smain.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Faculty Approval </li>
                </ol>
            </nav>
        </div>


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


            <!-- Nav tabs -->
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="acad-tab"  data-bs-toggle="tab" href="#fresearch_approval" role="tab">
                        <i class="fa fa-user tab-icon"></i>Research
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="Projects-tab"  data-bs-toggle="tab" href="#fevent_approval" role="tab">
                        <i class="fa fa-graduation-cap tab-icon"></i>Events
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab"  data-bs-toggle="tab" href="#posting" role="tab">
                        <i class="fa fa-users tab-icon"></i>Posting
                    </a>
                </li>
               
            </ul>

            <div class="tab-content tabcontent-border">
                <div class="tab-pane active" id="fresearch_approval" role="tabpanel">
                <?php include 'fresearch_approval.php'; ?>
                </div>



                <div class="tab-pane p-20" id="fevent_approval" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" style="border: none;">
                                <div class="card-header" style="border: none;">
                                    <h4>

                                        <button type="button" style="float: right;" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#studentAddModal">
                                            Add details
                                        </button>
                                    </h4>
                                </div>
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table id="myTable2" class="table table-bordered table-striped">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>Type</b></th>
                                                    <th><b>Institution/Corporate Name</b></th>
                                                    <th><b>Designation</b></th>
                                                    <th><b>From</b></th>
                                                    <th><b>To</b></th>
                                                    <th><b>Duration</b></th>
                                                    <th align="center"><b>View</b></th>
                                                    <th align="center"><b>Action</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php




                                                $query = "SELECT * FROM exp where id='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    foreach ($query_run as $student) {

                                                        if ($student['tod'] == "0000-00-00") {
                                                            $ssss = "Current";
                                                        } else {
                                                            $ssss = $student['tod'];
                                                        }

                                                ?>
                                                        <tr>
                                                            <td><?= $student['type'] ?></td>
                                                            <td><?= $student['iname'] ?></td>
                                                            <td><?= $student['design'] ?></td>
                                                            <td><?= $student['fromd'] ?></td>
                                                            <td><?php echo $ssss; ?></td>
                                                            <td><?= $student['exp'] ?></td>
                                                            <td align="center"><button type="button" id="ledonof" value="<?= $student['uid']; ?>" class="btnimg btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#studentViewModal2">View</button></td>
                                                            <td>
                                                                <!--    <button type="button" value="<?= $student['uid']; ?>" class="viewStudentBtn btn btn-info btn-sm">View</button>
                                            <button type="button" value="<?= $student['uid']; ?>" class="editStudentBtn btn btn-success btn-sm">Edit</button>-->
                                                                <button type="button" value="<?= $student['uid']; ?>" class="deleteStudentBtn btn btn-danger btn-sm">Delete</button>
                                                            </td>
                                                        </tr>

                                                <?php
                                                    }
                                                }
                                                ?>

                                            </tbody>



                                            <thead>
                                                <?php
                                                $v = 0;
                                                $query = "select id, sum( datediff( ifnull(tod, now()) , fromd) +1 )AS value_sum from exp group by id having id='$s';";
                                                $query_run = mysqli_query($db, $query);
                                                if (mysqli_num_rows($query_run) > 0) {
                                                    $student = mysqli_fetch_assoc($query_run);
                                                    $sum = $student['value_sum'];

                                                    $years = floor($sum / 365);
                                                    $months = floor(($sum - ($years * 365)) / 30.5);
                                                    $days = floor($sum - ($years * 365) - ($months * 30.5));
                                                    //echo "Days received: " . $sum . " days <br />";
                                                    $v = $years . " years, " . $months . "months, " . $days . "days";
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="8" align="center"><b>Total Experience : <?= $v ?></b></td>
                                                </tr>
                                            </thead>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="tab-pane p-20" id="posting" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" style="border: none;">
                                <div class="card-header" style="border: none;">
                                    <h4> <?php "kalai"; ?>

                                        <button type="button" style="float: right;" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#postingadd">
                                            Add Posting
                                        </button>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="myTable5" class="table table-bordered table-striped">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th><b>S.NO</b></th>
                                                    <th><b>Level</b></th>
                                                    <th><b>Posting Name</b></th>
                                                    <th><b>From</b></th>
                                                    <th><b>To</b></th>

                                                    <th align="center"><b>Action</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT * FROM posting WHERE id='$s'";
                                                $query_run = mysqli_query($db, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    $sn = 1;
                                                    foreach ($query_run as $student) {
                                                        $isCurrent = ($student['tod'] == "0000-00-00");
                                                        $sss = $isCurrent ? "Current" : $student['tod'];

                                                        // Determine status text and class
                                                        $status = "Pending";
                                                        $statusClass = "warning"; // Default bootstrap class for Pending
                                                        $showRemarkButton = false;
                                                        $remark = $student['remark'];

                                                        if ($student['status'] == 3) {
                                                            $status = "Approved";
                                                            $statusClass = "success";
                                                        } elseif ($student['status'] == 4) {
                                                            $status = "Rejected";
                                                            $statusClass = "danger";
                                                            $showRemarkButton = true; // Show remark button if rejected
                                                        }
                                                ?>
                                                        <tr>
                                                            <td><?= $sn ?></td>
                                                            <td><?= htmlspecialchars($student['level']) ?></td>
                                                            <td><?= htmlspecialchars($student['pname']) ?></td>
                                                            <td><?= htmlspecialchars($student['fromd']) ?></td>
                                                            <td><?= htmlspecialchars($sss) ?></td>
                                                            <td>
                                                                <?php if ($isCurrent) : ?>
                                                                    <button type="button" value="<?= $student['uid']; ?>" class="posteditStudentBtn btn btn-success btn-sm">Edit</button>
                                                                <?php endif; ?>
                                                                <button type="button" value="<?= $student['uid']; ?>" class="deletepBtn btn btn-danger btn-sm">Delete</button>

                                                                <?php if ($isCurrent) : ?>
                                                                    <span class="badge bg-<?= $statusClass ?>"><?= $status ?></span>
                                                                <?php endif; ?>

                                                                <?php if ($showRemarkButton) : ?>
                                                                    <button type="button" class="btn btn-info btn-sm viewRemarkBtn" data-remark="<?= htmlspecialchars($remark) ?>">View Remark</button>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        $sn++;
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

                



            </div>
        </div>
    </div>





    <!-- tab2 form end -->

    <?php include 'event_tabs_model.php';?>
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
        

    <div class="modal fade" id="studentAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Add Experience Details</strong></h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="saveexp">
                    <div class="modal-body">

                        <div id="errorMessage" class="alert alert-warning d-none"></div>


                        <div class="mb-3">
                            <label for="" class="form-label">Current Job *</label>
                            <select class="form-control" name="cj" id="cj" onchange="if(this.value=='no'){this.form['tod'].style.visibility='visible'}else {this.form['tod'].style.visibility='hidden'};" required>
                                <option value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="" class="form-label">Type *</label>
                            <select class="form-control" name="type" id="type" required>
                                <option value="">Select type</option>
                                <option value="Teaching">Teaching</option>
                                <option value="Research">Research</option>
                                <option value="Industry">Industry</option>
                                <option value="Adminstrative">Adminstrative</option>
                                <option value="Support">Support</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Institution / Corporate Name *</label>
                            <input type="text" name="iname" id="iname" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Designation *</label>
                            <input type="text" name="design" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Role *</label>
                            <select class="form-control" name="role">
                                <option value="">Select role</option>
                                <option value="Full time">Full time</option>
                                <option value="Part Time">Part Time</option>
                                <option value="Visiting">Visiting</option>
                                <option value="Adjunt">Adjunt</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">From *</label>
                            <input type="date" name="fromd" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">To *</label>
                            <input type="date" name="tod" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Exp Certificate*</label>
                            <label for="">(upload less than 2 mb)</label> </br>
                            <p> (for Current job upload joining order)</p>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="cert" id="uploadFile" onchange="return fileValidation2()" aria-describedby="inputGroupPrepend" required>
                                <label class="custom-file-label" for="customFile">Choose file(Image)</label>
                            </div>
                            <p style="color:red;" id="tutorial"></p>
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
    <div class="modal fade" id="studentEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Edit Student</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateStudent">
                    <div class="modal-body">

                        <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

                        <input type="hidden" name="student_id" id="student_id">


                        <div class="mb-3">
                            <label for="">Current Job *</label>
                            <select class="form-control" name="cj" id="cj" onchange="if(this.value=='no'){this.form['tod'].style.visibility='visible'}else {this.form['tod'].style.visibility='hidden'};" required>
                                <option value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="">Course *</label>
                            <select class="form-control" name="course" id="course2" required>
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
                            <select class="form-control" name="degree" id="degree2" required>
                                <option value="">Select Degree</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="">Specialization / Branch *</label>
                            <input type="text" name="branch" id="branch" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="">Institution Name *</label>
                            <input type="text" name="name" id="name" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="">Board/University *</label>
                            <input type="text" name="univ" id="univ" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="">State *</label>
                            <select class="form-control" name="state" id="state">
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
                                <option disabled style="background-color:#aaa; color:#fff">UNION Territories</option>
                                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                <option value="Chandigarh">Chandigarh</option>
                                <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                                <option value="Daman and Diu">Daman and Diu</option>
                                <option value="Delhi">Delhi</option>
                                <option value="Lakshadeep">Lakshadeep</option>
                                <option value="Pondicherry">Pondicherry</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Mode of Study *</label>
                            <select class="form-control" name="ms" id="ms" required>
                                <option value="">Select Degree</option>
                                <option value="Full Time">Full Time</option>
                                <option value="Part time">Part time</option>
                                <option value="Distance">Distance</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Medium of Study *</label>
                            <input type="text" name="mes" id="mes" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="">Year of Completion *</label>
                            <input type="text" name="yc" id="yc" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="">Completion Status *</label>
                            <select class="form-control" name="cs" id="cs" required>
                                <option value="">Select</option>
                                <option value="Completed">Completed</option>
                                <option value="Pursuing">Pursuing</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="">Score Obtained (%)*</label>
                            <input type="text" name="score" id="score" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="">Certification Number *</label>
                            <input type="text" name="cnum" id="cnum" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="">Certificate*</label>
                            <label for="">(upload less than 2 mb)</label>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="cert" id="uploadFile" onchange="return fileValidation2()" aria-describedby="inputGroupPrepend" required>
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <p style="color:red;" id="tutorial"></p>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Student Modal -->
    <div class="modal fade" id="studentViewModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="image" src="" alt="Computer man" class="center" style="width:80%;height:80%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- View Student Modal -->
    <div class="modal fade" id="studentViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Add posting -->
    <div class="modal fade" id="postingadd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Add Posting Details</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="savepost">
                    <div class="modal-body">

                        <div id="errorMessagepost" class="alert alert-warning d-none"></div>


                        <div class="mb-3"><label for="" class="form-label">Current Posting *</label>
                            <select class="form-control" name="css" id="cs" onchange="if(this.value=='no'){this.form['tod'].style.visibility='visible'}else {this.form['tod'].style.visibility='hidden'};" required>
                                <option value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>


                        <div class="mb-3"><label for="" class="form-label">Level of Posting *</label>
                            <select class="form-control" name="lp" id="cs" required>
                                <option value="">Select</option>
                                <option value="Department Level">Department Level</option>
                                <option value="Institutional Level">Institutional Level</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="postingg" class="form-label">Name of the Posting *</label>
                            <input type="text" name="postingg" id="postingg" class="form-control" />
                        </div>

                        <!-- <div class="mb-3" id="other_posting_divv" style="display: none;">
                                                            <label for="other_postingg">Specify Posting Name *</label>
                                                            <input type="text" name="other_postingg" id="other_postingg" class="form-control" />
                                                        </div> -->



                        <div class="mb-3">
                            <label for="" class="form-label">From</label>
                            <input type="date" name="fod" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">To</label>
                            <input type="date" name="tod" class="form-control" />
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

    <div class="modal fade" id="postingedit" tabindex="-1" aria-labelledby="postingeditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postingeditLabel">Edit Posting Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editpost">
                    <div class="modal-body">
                        <div id="errorMessagepost" class="alert alert-warning d-none"></div>

                        <div class="mb-3">
                            <label for="cs" class="form-label">Current Posting *</label>
                            <select class="form-select" name="css" id="css" required>
                                <option value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="lp" class="form-label">Level of Posting *</label>
                            <select class="form-select" name="lp" id="lp" required>
                                <option value="">Select</option>
                                <option value="Department Level">Department Level</option>
                                <option value="Institutional Level">Institutional Level</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="postingg" class="form-label">Name of the Posting *</label>
                            <input type="text" name="postingg" id="postinggg" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label for="fod" class="form-label">From</label>
                            <input type="date" name="fod" id="fod" class="form-control" required />
                        </div>

                        <div class="mb-3" id="tod-container" class="d-none">
                            <label for="tod" class="form-label">To</label>
                            <input type="date" name="tod" id="tod" class="form-control" />
                        </div>

                        <input type="hidden" name="posting_id" id="posting_id" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>







    <!-- punish tab ending -->




    <div class="modal fade" id="pcadd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Add Training Details</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="pcadd2">
                    <div class="modal-body">

                        <div id="errorMessage" class="alert alert-warning d-none"></div>



                        <div class="mb-3">
                            <label for="" class="form-label">Type of Training *</label>
                            <select class="form-control" name="type" id="type" onchange="if(this.value=='other'){this.form['other'].style.visibility='visible'}else {this.form['other'].style.visibility='hidden'};" required>
                                <option value="">Select type</option>
                                <option value="FDP">FDP</option>
                                <option value="Workshop">Workshop</option>
                                <option value="other">Others</option>
                            </select>
                        </div>

                        <div class="mb-3">

                            <input type="text" name="other" Placeholder="Enter Other training type" class="form-control" />
                        </div>


                        <div class="mb-3">
                            <label for="" class="form-label">Name of the Organization *</label>
                            <input type="text" name="no" class="form-control" />
                        </div>



                        <div class="mb-3">
                            <label for="" class="form-label">Title *</label>
                            <input type="text" name="title" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">From *</label>
                            <input type="date" name="fd" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">To *</label>
                            <input type="date" name="td" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Proof*</label>
                            <label for="">(upload less than 2 mb)</label>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="cert" id="uploadFile4" onchange="return fileValidation4()" aria-describedby="inputGroupPrepend" required>
                                <label class="custom-file-label" for="customFile">Upload 1st page as image</label>
                            </div>
                            <p style="color:red;" id="tutorial4"></p>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Data</button>
                    </div>
                </form>
            </div>
        </div>

    </div>




    <div class="modal fade" id="studentViewModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Paper</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="image4" src="" alt="Computer man" class="center" style="width:80%;height:80%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Add punish-->
    <div class="modal fade" id="punishadd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Add Punishment Details</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="savepunish">
                    <div class="modal-body">

                        <div id="errorMessagepost9" class="alert alert-warning d-none"></div>




                        <div class="mb-3"><label for="" class="form-label">Type of Punishment *</label>
                            <select class="form-control" name="lp" id="cs" required>
                                <option value="">Select</option>
                                <option value="memo">Memo</option>
                                <option value="suspension">Suspension</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Reason *</label>
                            <input type="text" name="np" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">From</label>
                            <input type="date" name="fod" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">To</label>
                            <input type="date" name="tod" class="form-control" />
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




    <!-- Footer -->
    <?php include 'footer.php'; ?>
    </div>
    <?php include 'fresearch_approval_js.php'; ?>
    <script>
        document.addEventListener("click", function(event) {
            if (event.target.classList.contains("posteditStudentBtn")) {
                let posting_id = event.target.value;
                fetchPostingDetails(posting_id);
            }
        });

        function fetchPostingDetails(posting_id) {
            $.ajax({
                url: 'Acode.php',
                type: 'GET',
                data: {
                    id: posting_id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status !== 200) {
                        alert(response.message);
                        return;
                    }

                    const postingData = response.data;

                    $('#posting_id').val(posting_id);
                    $('#lp').val(postingData.level);
                    $('#postinggg').val(postingData.pname);
                    $('#fod').val(postingData.fromd);
                    $('#tod').val(postingData.tod !== "0000-00-00" ? postingData.tod : "");

                    // Handle Current Posting status
                    $('#css').val(postingData.cs);
                    toggleToDateField(postingData.cs);

                    $('#postingedit').modal('show');
                },
                error: function() {
                    alert("Failed to fetch posting details.");
                }
            });
        }

        function toggleToDateField(csValue) {
            if (csValue === "yes") {
                $('#tod').hide().val("");
            } else {
                $('#tod').show();
            }
        }

        // Handle change event to toggle To Date field
        $('#css').on('change', function() {
            toggleToDateField($(this).val());
        });

        $(document).ready(function() {
            $('#editpost').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                const formData = $(this).serialize() + '&update_posting=1'; // Ensure correct request flag

                $.ajax({
                    url: 'Acode.php', // Ensure this matches your PHP script handling updates
                    type: 'POST',
                    data: formData,
                    dataType: 'json', // Expect JSON response
                    success: function(result) {
                        if (result.status === 200) {
                            alert("Posting details updated successfully.");
                            $('#postingedit').modal('hide'); // Hide modal on success
                            location.reload(); // Reload page to reflect changes
                        } else {
                            $('#errorMessagepost').removeClass('d-none').text(result.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: ", error);
                        alert("Failed to update posting details.");
                    }
                });
            });
        });

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



        $(document).on('submit', '#pcadd2', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_pc", true);

            $.ajax({
                type: "POST",
                url: "Acode.php",
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

                        $('#myTable4').load(location.href + " #myTable4");


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

        $(document).on('click', '.btnimg4', function() {

            var student_id222 = $(this).val();
            $.ajax({
                type: "GET",
                url: "Acode.php?student_id222=" + student_id222,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {

                        alert(res.message);
                    } else if (res.status == 200) {


                        $("#image4").attr("src", res.data.cert);

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
        function editPosting(posting_id) {
            $.ajax({
                url: 'Acode.php',
                type: 'GET',
                data: {
                    id: posting_id
                },
                success: function(response) {
                    try {
                        const postingData = JSON.parse(response);

                        if (postingData.status === "error") {
                            alert(postingData.message);
                            return;
                        }

                        // Populate form fields
                        $('#posting_id').val(posting_id);
                        $('#lp').val(postingData.lp);
                        $('#postingg').val(postingData.postingg);
                        $('#fod').val(postingData.fod);
                        $('#tod').val(postingData.tod !== "0000-00-00" ? postingData.tod : "");

                        // Set Current Posting based on To Date
                        $('#cs').val(postingData.cs);
                        if (postingData.cs === "yes") {
                            $('#tod').hide().val(""); // Hide 'To Date' if "yes"
                        } else {
                            $('#tod').show();
                        }

                        $('#postingedit').modal('show'); // Show modal for editing
                    } catch (error) {
                        console.error("JSON Parse Error: ", error);
                    }
                },
                error: function() {
                    alert("Failed to fetch posting details.");
                }
            });
        }

        // Handle change event to toggle To Date visibility
        $('#cs').on('change', function() {
            if ($(this).val() === "no") {
                $('#tod').show();
            } else {
                $('#tod').hide().val(""); // Hide and clear the To Date
            }
        });

        $(document).ready(function() {
            $('#editpost').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                const formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    url: 'Acode.php', // Same file for both GET and POST
                    type: 'POST', // Ensure POST request is sent
                    data: formData,
                    success: function(response) {
                        try {
                            const result = JSON.parse(response);

                            if (result.status === 'success') {
                                alert("Posting details updated successfully.");
                                $('#postingedit').modal('hide'); // Hide the modal after success
                                location.reload(); // Reload the page to reflect changes (optional)
                            } else {
                                $('#errorMessagepost').removeClass('d-none').text(result.message);
                            }
                        } catch (error) {
                            console.error("JSON Parse Error: ", error);
                        }
                    },
                    error: function() {
                        alert("Failed to update posting details.");
                    }
                });
            });
        });
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

    <!-- JavaScript to Set Image Source Dynamically -->


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

        $(document).on('submit', '#research', function(e) {
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
                        $('#erroraprofile').removeClass('d-none');
                        $('#erroraprofile').text(res.message);
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

                        $('#myTable98').load(location.href + " #myTable98");

                    } else if (res.status == 500) {
                        $('#errorMessagepost9').addClass('d-none');
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

        $(document).on('click', '.deletepcBtn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var student_id5 = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "Acode.php",
                    data: {
                        'delete_pc': true,
                        'student_id5': student_id5
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(res.message);

                            $('#myTable4').load(location.href + " #myTable4");
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
                    url: "code.php",
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
                console .log(student_id6);
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

                            $('#myTable98').load(location.href + " #myTable98");
                        }
                    }
                });
            }
        });
    </script>


    <!-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            var postingDropdown = document.getElementById("postingg");
            var otherPostingDiv = document.getElementById("other_posting_divv");
            var otherPostingInput = document.getElementById("other_postingg");

            postingDropdown.addEventListener("change", function() {
                if (this.value === "Otherr") {
                    otherPostingDiv.style.display = "block";
                    otherPostingInput.setAttribute("required", "required");
                } else {
                    otherPostingDiv.style.display = "none";
                    otherPostingInput.removeAttribute("required");
                    otherPostingInput.value = ""; // Clear input when hidden
                }
            });
        });
    </script> -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Handle View Remark button click
            document.querySelectorAll(".viewRemarkBtn").forEach(button => {
                button.addEventListener("click", function() {
                    let remark = this.getAttribute("data-remark");

                    Swal.fire({
                        title: "Rejection Remark",
                        text: remark || "No remark provided",
                        icon: "info",
                        confirmButtonText: "OK"
                    });
                });
            });
        });
    </script>




</body>


</html>