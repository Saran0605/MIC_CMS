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
                    <li class="breadcrumb-item active" aria-current="page">Research</li>
                </ol>
            </nav>
        </div>
        <div class="modal fade" id="view_Modal" tabindex="-1"
            role="dialog" aria-labelledby="view_ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="view_ModalLabel">0</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body text-center" id="view_ModalBody">
                        <!-- Content will be loaded dynamically here -->
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="journalModal" tabindex="-1" aria-labelledby="journalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="journalModalLabel"><b>Journal Details</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="journal_form">

                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="academic_year" class="form-label">Academic Year *</label>
                                    <select class="form-select" name="academic_year" required>
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">No academic years available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="journal_name" class="form-label">Journal Name *</label>
                                    <input type="text" class="form-control" id="journal_name" name="journal_name" required>
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group  col-md-6">
                                    <label for="indexing_type" class="form-label">Indexing Type*</label>
                                    <select class="form-select" name="indexing_type" required>
                                        <option value="">Select Type</option>
                                        <option value="SCI">SCI</option>
                                        <option value="WOS">WOS</option>
                                        <option value="SCOPUS">SCOPUS</option>


                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="scopus_id" class="form-label">Journal Scopus ID *</label>
                                    <input type="text" class="form-control" id="scopus_id" name="scopus_id" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="publisher_name" class="form-label">Publisher Name *</label>
                                <input type="text" class="form-control" id="publisher_name" name="j_publisher_name" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="journal_status" class="form-label">Journal Status *</label>
                                    <select class="form-select" name="journal_status" required>
                                        <option value="Active">Active</option>
                                        <option value="In Active">In Active</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="impact_factor" class="form-label">Impact Factor *</label>
                                    <input type="text" class="form-control" id="impact_factor" name="impact_factor" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="eissn" class="form-label">E-ISSN *</label>
                                    <input type="text" class="form-control" id="eissn" name="eissn" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="country" class="form-label">Country *</label>
                                    <input type="text" class="form-control" id="country" name="j_country" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="level" class="form-label">Level *</label>
                                    <select class="form-select" id="level" name="j_level" required>
                                        <option value="National">National</option>
                                        <option value="International">International</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="paper_title" class="form-label">Title of the Paper *</label>
                                <input type="text" class="form-control" id="paper_title" name="j_paper_title" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="month_year" class="form-label">Month & Year *</label>
                                    <input type="month" class="form-control" id="month_year" name="month_year" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="authors_count" class="form-label">Number of Authors *</label>
                                    <input type="number" class="form-control" id="authors_count" name="j_authors_count" required min="1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="volume" class="form-label">Volume</label>
                                    <input type="text" class="form-control" name="volume">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="issue" class="form-label">Issue/Number</label>
                                    <input type="text" class="form-control" name="issue">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="page" class="form-label">Page</label>
                                    <input type="number" class="form-control" name="page" min="1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="journal_link" class="form-label">Link</label>
                                    <input type="url" class="form-control" name="journal_link">
                                </div>



                                <div class="form-group col-md-6">
                                    <label for="doi" class="form-label">DOI Number</label>
                                    <input type="text" class="form-control" name="doi" id="doi" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="author_position" class="form-label">Author's Position</label>
                                    <input type="number" class="form-control" name="author_position" id="author_position" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="claim_acquired" class="form-label">Claim acquired</label>
                                    <input type="text" class="form-control" name="claim_acquired" id="claim_acquired" required>
                                </div>

                            </div>
                            <div class="form-group col-md-12">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea class="form-control" name="j_remarks"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="pdf2" class="form-label"> Journal Paper * (Upload PDF less than 2 MB)</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="pdf2" accept=".pdf" onchange="fileValidation(this)" required>

                                </div>
                                <p id="descriptionError" class="text-danger"></p>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ed_journalModal" tabindex="-1" aria-labelledby="ed_journalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ed_journalModalLabel">Journal Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="ed_journal_form">

                            <div class="row">
                                <input type="hidden" name="id" id="ed_journal_id">

                                <!-- Academic Year -->
                                <div class="col-md-6 mb-3">
                                    <label for="ed_academic_year" class="form-label">Academic Year *</label>
                                    <select class="form-select" id="edj_academic_year" name="academic_year" required>
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">No academic years available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Journal Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="ed_journal_name" class="form-label">Journal Name *</label>
                                    <input type="text" class="form-control" id="edj_journal_name" name="journal_name" required>
                                </div>
                            </div>

                            <!-- Next Row -->
                            <div class="row">
                                <!-- Indexing Type -->
                                <div class="col-md-6">
                                    <label for="indexing_type" class="form-label">Indexing Type*</label>
                                    <select class="form-select" id="edj_indexing_type" name="indexing_type" required>
                                        <option value="">Select Type</option>
                                        <option value="SCI">SCI</option>
                                        <option value="WOS">WOS</option>
                                        <option value="SCOPUS">SCOPUS</option>
                                    </select>
                                </div>

                                <!-- Journal Scopus ID -->
                                <div class="col-md-6 mb-3">
                                    <label for="ed_scopus_id" class="form-label">Journal Scopus ID *</label>
                                    <input type="text" class="form-control" id="edj_scopus_id" name="scopus_id" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="ed_publisher_name" class="form-label">Publisher Name *</label>
                                    <input type="text" class="form-control" id="edj_publisher_name" name="j_publisher_name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ed_journal_status" class="form-label">Journal Status *</label>
                                    <select id="edj_journal_status" name="journal_status" class="form-select" required>
                                        <option value="Active">Active</option>
                                        <option value="In Active">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ed_impact_factor" class="form-label">Impact Factor *</label>
                                    <input type="text" class="form-control" id="edj_impact_factor" name="impact_factor" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="ed_eissn" class="form-label">E-ISSN *</label>
                                    <input type="text" class="form-control" id="edj_eissn" name="eissn" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="ed_country" class="form-label">Country *</label>
                                    <input type="text" class="form-control" id="edj_country" name="j_country" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="ed_level" class="form-label">Level *</label>
                                    <select class="form-select" id="edj_level" name="j_level" required>
                                        <option value="National">National</option>
                                        <option value="International">International</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="paper_title" class="form-label">Title of the Paper *</label>
                                <input type="text" class="form-control" id="edj_paper_title" name="j_paper_title" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ed_month_year" class="form-label">Month & Year *</label>
                                    <input type="month" class="form-control" id="edj_month_year" name="month_year" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ed_authors_count" class="form-label">Number of Authors *</label>
                                    <input type="number" class="form-control" id="edj_authors_count" name="j_authors_count" min="1" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="ed_volume" class="form-label">Volume</label>
                                    <input type="text" class="form-control" id="edj_volume" name="volume" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="ed_issue" class="form-label">Issue/Number</label>
                                    <input type="text" class="form-control" id="edj_issue" name="issue" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="ed_page" class="form-label">Page</label>
                                    <input type="text" class="form-control" id="edj_page" name="page" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ed_journal_link" class="form-label">Link</label>
                                    <input type="url" class="form-control" id="edj_journal_link" name="journal_link" required>
                                </div>


                                <div class="col-md-6">
                                    <label for="doi" class="form-label">DOI Number</label>
                                    <input type="text" class="form-control" name="doi" id="edj_doi_number" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="author_position" class="form-label">Author's Position</label>
                                    <input type="number" class="form-control" name="author_position" id="edj_author_position" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="claim_acquired" class="form-label">Claim acquired</label>
                                    <input type="text" class="form-control" name="claim_acquired" id="edj_claim_acquired" required>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="ed_remarks" class="form-label">Remarks</label>
                                    <textarea class="form-control" id="edj_remarks" name="j_remarks" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pdf2" class="form-label"> Journal Paper * (Upload PDF less than 2 MB)</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="pdf2" accept=".pdf" onchange="fileValidation(this)" required>

                                </div>
                                <p id="descriptionError" class="text-danger"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="conferenceModal" tabindex="-1" role="dialog" aria-labelledby="conferenceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="conferenceModalLabel"><b>Conference Details</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" id="conference_form">
                            <div class="row mb-2">


                                <div class="form-group col-6">
                                    <label for="Academia Year" class="form-label">Academic Year *</label>
                                    <select class="form-control" name="academic_year" required="">
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                // Replace 'id' and 'name' with the actual column names in your dept_table
                                            }
                                        } else {
                                            echo '<option value="">No departments available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="organizer" class="form-label">Organizer / College Name*</label>
                                    <input type="text" class="form-control" id="organizer" name="organizer" required>
                                </div>

                            </div>
                            <div class="row mb-2">
                                <div class="form-group col-md-12">
                                    <label for="conference_title" class="form-label">Conference Title*</label>
                                    <input type="text" class="form-control" id="conference_title" name="conference_title" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="sponsor_name" class="form-label">Sponsor Name</label>
                                    <input type="text" class="form-control" id="sponsor_name" name="sponsor_name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="publisher_name" class="form-label">Publisher Name</label>
                                    <input type="text" class="form-control" id="publisher_name" name="publisher_name">
                                </div>
                                <div class=" col-md-6">
                                    <label for="indexing_type" class="form-label">Indexing Type*</label>
                                    <select class="form-select" id="indexing_type" name="indexing_details" required>
                                        <option value="">Select Type</option>
                                        <option value="SCI">SCI</option>
                                        <option value="WOS">WOS</option>
                                        <option value="SCOPUS">SCOPUS</option>


                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="level">Level*</label>
                                    <select class="form-control" id="level" name="level" required>
                                        <option value="National">National</option>
                                        <option value="International">International</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="form-group col-md-4">
                                    <label for="location" class="form-label">Location / City*</label>
                                    <input type="text" class="form-control" id="location" name="location" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="state" class="form-label">State*</label>
                                    <input type="text" class="form-control" id="state" name="state" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="country" class="form-label">Country*</label>
                                    <input type="text" class="form-control" id="country" name="country" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="title" class="form-label">Title of the Paper*</label>
                                    <input type="text" class="form-control" id="title" name="title_of_paper" required>
                                </div>

                            </div>
                            <div class="row mb-2">
                                <div class="form-group col-md-4">
                                    <label for="from_date" class="form-label">From*</label>
                                    <input type="date" class="form-control" id="from_date" name="from_date" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="to_date" class="form-label">To*</label>
                                    <input type="date" class="form-control" id="to_date" name="to_date" required>
                                </div>
                                <div class="form-group col-md-4" id="authorsDetails">
                                    <label for="authors" class="form-label">Number of Authors*</label>
                                    <input type="number" class="form-control" id="authors" name="number_of_authors" min="1" required>
                                </div>
                                <div class="form-group col-md-6" id="isbnDetails">
                                    <label for="eisbn" class="form-label">eISBN</label>
                                    <input type="text" class="form-control" id="eisbn" name="eisbn">
                                </div>
                                <div class="form-group col-md-6" id="pisbnDetails">
                                    <label for="pisbn" class="form-label">pISBN</label>
                                    <input type="text" class="form-control" id="pisbn" name="pisbn">
                                </div>
                                <div class="form-group col-md-6" id="doiDetails">
                                    <label for="doi" class="form-label">DOI Number</label>
                                    <input type="text" class="form-control" id="doi" name="doi" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="author_position" class="form-label">Author's Position</label>
                                    <input type="number" class="form-control" name="author_position" id="author_position" required min="1">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="claim_acquired" class="form-label">Claim acquired</label>
                                    <input type="text" class="form-control" name="claim_acquired" id="claim_acquired" required>
                                </div>

                                <div class="form-group col-md-6" id="linkDetails">
                                    <label for="link" class="form-label">Link</label>
                                    <input type="url" class="form-control" id="link" name="link">
                                </div>
                                <div class="form-group col-md-12" id="remarksDetails">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea class="form-control" name="remarks"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="uploadDescription" class="form-label">Conference Paper * (Upload PDF less than 2 MB)</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" name="pdf1" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">

                                    </div>
                                    <p id="descriptionError" class="text-danger"></p>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ed_conferenceModal" tabindex="-1" role="dialog" aria-labelledby="ed_conferenceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ed_conferenceModalLabel">Conference Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" id="ed_conference_form">
                            <div class="row mb-2">
                                <input type="hidden" name="id" id="ed_conference_id">

                                <div class="form-group col-md-4">
                                    <label for="Academia Year">Academic Year *</label>
                                    <select class="form-control" id="edc_academic_year" name="academic_year" required="">
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                // Replace 'id' and 'name' with the actual column names in your dept_table
                                            }
                                        } else {
                                            echo '<option value="">No departments available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                            <div class="row mb-2">

                                <div class="form-group col-md-6">
                                    <label for="organizer" class="form-label">Organizer / College Name*</label>
                                    <input type="text" class="form-control" id="edc_organizer" name="organizer" required>
                                </div>

                            </div>
                            <div class="row mb-2">
                                <div class="form-group col-md-12">
                                    <label for="conference_title" class="form-label">Conference Title*</label>
                                    <input type="text" class="form-control" id="edc_conference_title" name="conference_title" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="sponsor_name" class="form-label">Sponsor Name</label>
                                    <input type="text" class="form-control" id="edc_sponsor_name" name="sponsor_name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="publisher_name" class="form-label">Publisher Name</label>
                                    <input type="text" class="form-control" id="edc_publisher_name" name="publisher_name">
                                </div>
                                <div class="col-md-6">
                                    <label for="indexing_details" class="form-label">Indexing Type*</label>
                                    <select class="form-select" id="edc_indexing_details" name="indexing_details" required>
                                        <option value="">Select Type</option>
                                        <option value="SCI">SCI</option>
                                        <option value="WOS">WOS</option>
                                        <option value="SCOPUS">SCOPUS</option>


                                    </select>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="level">Level*</label>
                                    <select class="form-control" id="edc_level" name="level" required>
                                        <option value="National">National</option>
                                        <option value="International">International</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="form-group col-md-4">
                                    <label for="location" class="form-label">Location / City*</label>
                                    <input type="text" class="form-control" id="edc_location" name="location" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="state" class="form-label">State*</label>
                                    <input type="text" class="form-control" id="edc_state" name="state" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="country" class="form-label">Country*</label>
                                    <input type="text" class="form-control" id="edc_country" name="country" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="form-group col-md-12">
                                    <label for="country" class="form-label">Country*</label>
                                    <label for="title">Title of the Paper*</label>
                                    <input type="text" class="form-control" id="edc_title" name="title_of_paper" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="form-group col-md-4">
                                    <label for="from_date" class="form-label">From*</label>
                                    <input type="date" class="form-control" id="edc_from_date" name="from_date" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="to_date" class="form-label">To*</label>
                                    <input type="date" class="form-control" id="edc_to_date" name="to_date" required>
                                </div>
                                <div class="form-group col-md-4" id="authorsDetails">
                                    <label for="authors" class="form-label">Number of Authors*</label>
                                    <input type="number" class="form-control" id="edc_authors" name="number_of_authors" min="1" required>
                                </div>
                                <div class="form-group col-md-6" id="isbnDetails">
                                    <label for="eisbn" class="form-label">eISBN</label>
                                    <input type="text" class="form-control" id="edc_eisbn" name="eisbn">
                                </div>
                                <div class="form-group col-md-6" id="pisbnDetails">
                                    <label for="pisbn" class="form-label">pISBN</label>
                                    <input type="text" class="form-control" id="edc_pisbn" name="pisbn">
                                </div>

                                <div class="form-group col-md-6" id="doiDetails">
                                    <label for="doi" class="form-label">DOI Number</label>
                                    <input type="text" class="form-control" id="edc_doi" name="doi" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="author_position" class="form-label">Author's Position</label>
                                    <input type="number" class="form-control" name="author_position" id="edc_author_position" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="claim_acquired" class="form-label">Claim acquired</label>
                                    <input type="text" class="form-control" name="claim_acquired" id="edc_claim_acquired" required>
                                </div>


                                <div class="form-group col-md-6" id="linkDetails">
                                    <label for="link" class="form-label">Link</label>
                                    <input type="url" class="form-control" id="edc_link" name="link">
                                </div>
                                <div class="form-group col-md-12" id="remarksDetails">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea class="form-control" id="edc_remarks" name="remarks"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="uploadDescription" class="form-label">Conference Paper * (Upload PDF less than 2 MB)</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" name="pdf1" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">

                                    </div>
                                    <p id="descriptionError" class="text-danger"></p>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="bookModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bookModalLabel"><b>Book Details</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" id="book_form">
                            <div class="row mb-2">


                                <div class="form-group col-md-6">
                                    <label for="Academia Year" class="form-label">Academic Year *</label>
                                    <select class="form-control" name="academic_year" required="">
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                // Replace 'id' and 'name' with the actual column names in your dept_table
                                            }
                                        } else {
                                            echo '<option value="">No departments available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="level" class="form-label">Category *</label>
                                    <select class="form-control" id="category" name="book_category" required>
                                        <option value="Book">Book</option>
                                        <option value="Book Chapter">Book Chapter
                                        </option>
                                    </select>
                                </div>

                            </div>

                            <div class="row mb-2">



                                <div class="row mb-2">

                                    <div class="form-group col-md-12">
                                        <label for="book_title" class="form-label">Book Title*</label>
                                        <input type="text" class="form-control" id="book_title" name="book_title" required>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="chapter_title" class="form-label">Chapter Title</label>
                                        <input type="text" class="form-control" id="chapter_title" name="chapter_title">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="publisher_name" class="form-label">Publisher Name</label>
                                        <input type="text" class="form-control" id="publisher" name="publisher">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="indexing_details" class="form-label">Indexing Details*</label>
                                        <select class="form-select" id="bindexing_details" name="indexing_details" required>
                                            <option value="">Select Type</option>
                                            <option value="SCI">SCI</option>
                                            <option value="WOS">WOS</option>
                                            <option value="SCOPUS">SCOPUS</option>


                                        </select>
                                    </div>


                                </div>

                                <div class="row mb-2">
                                    <div class="form-group col-md-4">
                                        <label for="month_year" class="form-label">Published Month & Year*</label>
                                        <input type="month" class="form-control" id="month_year" name="month_year" required>
                                    </div>

                                    <div class="form-group col-md-4" id="authorsDetails">
                                        <label for="authors" class="form-label">Number of Authors*</label>
                                        <input type="number" class="form-control" id="authors" name="number_of_authors" min="1" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="author_position" class="form-label">Author's Position</label>
                                        <input type="number" class="form-control" name="author_position" id="author_position" required min="1">
                                    </div>
                                    <div class="form-group col-md-6" id="isbnDetails">
                                        <label for="eisbn" class="form-label">eISBN</label>
                                        <input type="text" class="form-control" id="eisbn" name="eisbn">
                                    </div>
                                    <div class="form-group col-md-6" id="pisbnDetails">
                                        <label for="pisbn" class="form-label">pISBN</label>
                                        <input type="text" class="form-control" id="pisbn" name="pisbn">
                                    </div>
                                    <div class="form-group col-md-6" id="volume">
                                        <label for="volume" class="form-label">Volume</label>
                                        <input type="text" class="form-control" id="volume" name="volume">
                                    </div>
                                    <div class="form-group col-md-6" id="edition">
                                        <label for="edition" class="form-label">Edition</label>
                                        <input type="text" class="form-control" id="edition" name="edition">
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="claim_acquired" class="form-label">Claim acquired</label>
                                        <input type="text" class="form-control" name="claim_acquired" id="claim_acquired" required>
                                    </div>


                                    <div class="form-group col-md-6" id="linkDetails">
                                        <label for="link" class="form-label">Link</label>
                                        <input type="url" class="form-control" id="link" name="link">
                                    </div>
                                    <div class="form-group col-md-12" id="remarksDetails">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <textarea class="form-control" id="remarks" name="remarks"></textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="uploadDescription" class="form-label">Conference Paper * (Upload PDF less than 2 MB)</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control custom-file-input" name="pdf1" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">

                                        </div>
                                        <p id="descriptionError" class="text-danger"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ed_bookModal" tabindex="-1" role="dialog" aria-labelledby="ed_bookModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ed_bookModalLabel">Book Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" id="ed_book_form">
                            <div class="row mb-2">
                                <input type="hidden" name="id" id="ed_book_id">

                                <div class="form-group col-md-4">
                                    <label for="Academia Year">Academic Year *</label>
                                    <select class="form-control" id="edb_academic_year" name="academic_year" required="">
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                // Replace 'id' and 'name' with the actual column names in your dept_table
                                            }
                                        } else {
                                            echo '<option value="">No departments available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                            <div class="row mb-2">


                                <div class="form-group col-md-6">
                                    <label for="level">Category*</label>
                                    <select class="form-control" id="edb_category" name="book_category" required>
                                        <option value="Book">Book</option>
                                        <option value="Book Chapter">Book Chapter
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">

                                <div class="form-group col-md-12">
                                    <label for="book_title" class="form-label">Book Title*</label>
                                    <input type="text" class="form-control" id="edb_book_title" name="book_title" required>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="chapter_title" class="form-label">Chapter Title</label>
                                    <input type="text" class="form-control" id="edb_chapter_title" name="chapter_title">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="publisher_name" class="form-label">Publisher Name</label>
                                    <input type="text" class="form-control" id="edb_publisher" name="publisher">
                                </div>

                                <div class="col-md-6">
                                    <label for="indexing_details" class="form-label">Indexing Details*</label>
                                    <select class="form-select" id="edb_indexing_details" name="indexing_details" required>
                                        <option value="">Select Type</option>
                                        <option value="SCI">SCI</option>
                                        <option value="WOS">WOS</option>
                                        <option value="SCOPUS">SCOPUS</option>


                                    </select>
                                </div>


                            </div>

                            <div class="row mb-2">
                                <div class="form-group col-md-4">
                                    <label for="published_date" class="form-label">Published Month & Year*</label>
                                    <input type="date" class="form-control" id="edb_published_date" name="published_date" required>
                                </div>

                                <div class="form-group col-md-4" id="authorsDetails">
                                    <label for="authors" class="form-label">Number of Authors*</label>
                                    <input type="number" class="form-control" id="edb_authors" name="number_of_authors" min="1" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="author_position" class="form-label">Author's Position</label>
                                    <input type="number" class="form-control" name="author_position" id="edb_author_position" required>
                                </div>
                                <div class="form-group col-md-6" id="isbnDetails">
                                    <label for="eisbn" class="form-label">eISBN</label>
                                    <input type="text" class="form-control" id="edb_eisbn" name="eisbn">
                                </div>
                                <div class="form-group col-md-6" id="pisbnDetails">
                                    <label for="pisbn" class="form-label">pISBN</label>
                                    <input type="text" class="form-control" id="edb_pisbn" name="pisbn">
                                </div>
                                <div class="form-group col-md-6" id="volume">
                                    <label for="pisbn" class="form-label">Volume</label>
                                    <input type="text" class="form-control" id="edb_volume" name="volume">
                                </div>

                                <div class="form-group col-md-6" id="edition">
                                    <label for="edition" class="form-label">Edition</label>
                                    <input type="text" class="form-control" id="edb_edition" name="edition">
                                </div>





                                <div class="form-group col-md-6">
                                    <label for="claim_acquired" class="form-label">Claim acquired</label>
                                    <input type="text" class="form-control" name="claim_acquired" id="edb_claim_acquired" required>
                                </div>


                                <div class="form-group col-md-6" id="linkDetails">
                                    <label for="link" class="form-label">Link</label>
                                    <input type="url" class="form-control" id="edb_link" name="link">
                                </div>
                                <div class="form-group col-md-12" id="remarksDetails">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea class="form-control" id="edb_remarks" name="remarks"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="uploadDescription" class="form-label">Conference Paper * (Upload PDF less than 2 MB)</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" name="pdf1" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">

                                    </div>
                                    <p id="descriptionError" class="text-danger"></p>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="patentModal" tabindex="-1" role="dialog" aria-labelledby="patentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="patentModalLabel"><b>Patent Details</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="patent_form">

                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="Academia Year" class="form-label">Academic Year *</label>
                                    <select class="form-control" name="academic_year" required="">
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                // Replace 'id' and 'name' with the actual column names in your dept_table
                                            }
                                        } else {
                                            echo '<option value="">No departments available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="patent_title" class="form-label">Title *</label>
                                    <input type="text" class="form-control" name="patent_title" required>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="field_of_innovation" class="form-label">Field Of Innovation *</label>
                                    <input type="text" class="form-control" name="field_of_innovation" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="patent_particulars" class="form-label">Particulars *</label>
                                    <textarea class="form-control" name="patent_particulars"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="category" class="form-label">Category *</label>
                                    <select class="form-control" name="patent_category" required>
                                        <option value="Agricultural Sciences">Agricultural Sciences</option>
                                        <option value="Art And Humanities">Art And Humanities</option>
                                        <option value="Biological Sciences">Biological Sciences</option>
                                        <option value="Chemical Sciences">Chemical Sciences</option>
                                        <option value="Engineering And Technology">Engineering And Technology</option>
                                        <option value="Medical And Health Sciences">Medical And Health Sciences</option>
                                        <option value="Physical Sciences">Physical Sciences</option>
                                        <option value="Social Sciences">Social Sciences</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="patent_country" class="form-label">Filing Country *</label>
                                    <input type="text" class="form-control" name="patent_country" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ipatent_date" class="form-label">Filing Date *</label>
                                    <input type="date" class="form-control" name="patent_date" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="eissn" class="form-label">Application Number*</label>
                                    <input type="text" class="form-control" name="application_number" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-control" id="status_patent" name="p_status" required>
                                        <option value="">Select</option>
                                        <option value="Provisional Registration">Provisional Registration</option>
                                        <option value="Complete Registration">Complete Registration</option>
                                        <option value="Published">Published</option>
                                        <option value="Examination Process">Examination Process</option>
                                        <option value="Granted">Granted</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 no_authors" style="display:none;">
                                    <label for="patent_no_authors" class="form-label"> Number of Authors *</label>
                                    <input type="number" class="form-control" name="p_no_authors" required>
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-md-4 published_date" style="display:none;">
                                    <label for="published_date" class="form-label">Published Date *</label>
                                    <input type="date" class="form-control" name="p_published_date">
                                </div>
                                <div class="form-group col-md-4 availability_date" style="display:none;">
                                    <label for="patent_availability_date" class="form-label">Availability Date *</label>
                                    <input type="date" class="form-control" name="p_availability_date">
                                </div>
                                <div class="form-group col-md-4 valid_upto" style="display:none;">
                                    <label for="patent_valid_upto" class="form-label">Valid upto *</label>
                                    <input type="date" class="form-control" name="p_valid_upto">
                                </div>

                            </div>
                            <div class="row">

                                <div class="form-group col-md-6 journal_no" style="display:none;">
                                    <label for="journal_Number" class="form-label">Journal Number *</label>
                                    <input type="text" class="form-control" name="p_journal_no">
                                </div>
                                <div class="form-group col-md-6 patent_no" style="display:none;">
                                    <label for="journal_Number" class="form-label">Patent Number *</label>
                                    <input type="text" class="form-control" name="p_patent_no">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12 remarks" style="display:none;">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea class="form-control" name="P_remarks"></textarea>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="uploadDescription" class="form-label">Patent Paper * (Upload PDF less than 2 MB)</label>
                                <div class="input-group">
                                    <input type="file" class="form-control custom-file-input" name="patent_pdf" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">

                                </div>
                                <p id="descriptionError" class="text-danger"></p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="copyrightModal" tabindex="-1" role="dialog" aria-labelledby="copyrightModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="copyrightModalLabel"><b>Copyright Details</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="copyright_form">

                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="Academia Year" class="form-label">Academic Year *</label>
                                    <select class="form-control" name="academic_year" required="">
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                // Replace 'id' and 'name' with the actual column names in your dept_table
                                            }
                                        } else {
                                            echo '<option value="">No departments available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="patent_title" class="form-label">Title *</label>
                                    <input type="text" class="form-control" name="copyright_title" required>
                                </div>

                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="field_of_innovation" class="form-label">Field Of Innovation *</label>
                                    <input type="text" class="form-control" name="field_of_innovation" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="patent_particulars" class="form-label">Particulars *</label>
                                    <textarea class="form-control" name="copyright_particulars"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="category" class="form-label">Category *</label>
                                    <select class="form-control" name="patent_category" required>
                                        <option value="Agricultural Sciences">Agricultural Sciences</option>
                                        <option value="Art And Humanities">Art And Humanities</option>
                                        <option value="Biological Sciences">Biological Sciences</option>
                                        <option value="Chemical Sciences">Chemical Sciences</option>
                                        <option value="Engineering And Technology">Engineering And Technology</option>
                                        <option value="Medical And Health Sciences">Medical And Health Sciences</option>
                                        <option value="Physical Sciences">Physical Sciences</option>
                                        <option value="Social Sciences">Social Sciences</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="patent_country" class="form-label">Filing Country *</label>
                                    <input type="text" class="form-control" name="patent_country" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ipatent_date" class="form-label">Filing Date *</label>
                                    <input type="date" class="form-control" name="patent_date" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="eissn" class="form-label">Application Number*</label>
                                    <input type="text" class="form-control" name="application_number" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-control" id="status_patent" name="p_status" required>
                                        <option value="">Select</option>
                                        <option value="Provisional Registration">Provisional Registration</option>
                                        <option value="Complete Registration">Complete Registration</option>
                                        <option value="Published">Published</option>
                                        <option value="Examination Process">Examination Process</option>
                                        <option value="Granted">Granted</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 no_authors" style="display:none;">
                                    <label for="patent_no_authors" class="form-label"> Number of Authors *</label>
                                    <input type="number" class="form-control" name="p_no_authors" required>
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-md-4 published_date" style="display:none;">
                                    <label for="published_date" class="form-label">Published Date *</label>
                                    <input type="date" class="form-control" name="p_published_date">
                                </div>
                                <div class="form-group col-md-4 availability_date" style="display:none;">
                                    <label for="patent_availability_date" class="form-label">Availability Date *</label>
                                    <input type="date" class="form-control" name="p_availability_date">
                                </div>
                                <div class="form-group col-md-4 valid_upto" style="display:none;">
                                    <label for="patent_valid_upto" class="form-label">Valid upto *</label>
                                    <input type="date" class="form-control" name="p_valid_upto">
                                </div>

                            </div>
                            <div class="row">

                                <div class="form-group col-md-6 journal_no" style="display:none;">
                                    <label for="journal_Number" class="form-label">Journal Number *</label>
                                    <input type="text" class="form-control" name="p_journal_no">
                                </div>
                                <div class="form-group col-md-6 patent_no" style="display:none;">
                                    <label for="journal_Number" class="form-label">Patent Number *</label>
                                    <input type="text" class="form-control" name="p_patent_no">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12 remarks" style="display:none;">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea class="form-control" name="P_remarks"></textarea>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="uploadDescription" class="form-label">Patent Paper * (Upload PDF less than 2 MB)</label>
                                <div class="input-group">
                                    <input type="file" class="form-control custom-file-input" name="patent_pdf" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">

                                </div>
                                <p id="descriptionError" class="text-danger"></p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ed_patentModal" tabindex="-1" role="dialog" aria-labelledby="ed_patentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ed_patentModalLabel">Patent Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="ed_patent_form">
                            <div class="row">
                                <input type="hidden" name="id" id="ed_patent_id">


                            </div>
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="Academia Year" class="form-label">Academic Year *</label>
                                    <select class="form-control" id="edp_academic_year" name="academic_year" required="">
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                // Replace 'id' and 'name' with the actual column names in your dept_table
                                            }
                                        } else {
                                            echo '<option value="">No departments available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="patent_title" class="form-label">Title *</label>
                                    <input type="text" class="form-control" id="ed_patent_title" name="patent_title" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="field_of_innovation" class="form-label">Field Of Innovation *</label>
                                    <input type="text" class="form-control" id="ed_field_of_innovation" name="field_of_innovation" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="patent_particulars" class="form-label">Particulars *</label>
                                    <textarea class="form-control" id="ed_patent_particulars" name="patent_particulars"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="category" class="form-label">Category *</label>
                                    <select class="form-control" id="ed_patent_category" name="patent_category" required>
                                        <option value="Agricultural Sciences">Agricultural Sciences</option>
                                        <option value="Art And Humanities">Art And Humanities</option>
                                        <option value="Biological Sciences">Biological Sciences</option>
                                        <option value="Chemical Sciences">Chemical Sciences</option>
                                        <option value="Engineering And Technology">Engineering And Technology</option>
                                        <option value="Medical And Health Sciences">Medical And Health Sciences</option>
                                        <option value="Physical Sciences">Physical Sciences</option>
                                        <option value="Social Sciences">Social Sciences</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="patent_country" class="form-label">Filing Country *</label>
                                    <input type="text" class="form-control" id="ed_patent_country" name="patent_country" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ipatent_date" class="form-label">Filing Date *</label>
                                    <input type="date" class="form-control" id="ed_patent_date" name="patent_date" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="eissn" class="form-label">Application Number*</label>
                                    <input type="text" class="form-control" id="ed_application_number" name="application_number" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-control" id="ed_status_patent" name="p_status" required>
                                        <option value="">Select</option>
                                        <option value="Provisional Registration">Provisional Registration</option>
                                        <option value="Complete Registration">Complete Registration</option>
                                        <option value="Published">Published</option>
                                        <option value="Examination Process">Examination Process</option>
                                        <option value="Granted">Granted</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 ed_no_authors" style="display:none;">
                                    <label for="patent_no_authors" class="form-label"> Number of Authors *</label>
                                    <input type="number" class="form-control" id="ed_p_no_authors" name="p_no_authors" required>
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-md-4 ed_published_date" style="display:none;">
                                    <label for="published_date" class="form-label">Published Date *</label>
                                    <input type="date" class="form-control" id="ed_p_published_date" name="p_published_date">
                                </div>
                                <div class="form-group col-md-4 ed_availability_date" style="display:none;">
                                    <label for="patent_availability_date" class="form-label">Availability Date *</label>
                                    <input type="date" class="form-control" id="ed_p_availability_date" name="p_availability_date">
                                </div>
                                <div class="form-group col-md-4 ed_valid_upto" style="display:none;">
                                    <label for="patent_valid_upto" class="form-label">Valid upto *</label>
                                    <input type="date" class="form-control" id="ed_p_valid_upto" name="p_valid_upto">
                                </div>

                            </div>
                            <div class="row">

                                <div class="form-group col-md-6 ed_journal_no" style="display:none;">
                                    <label for="journal_Number" class="form-label">Journal Number *</label>
                                    <input type="text" class="form-control" id="ed_p_journal_no" name="p_journal_no">
                                </div>
                                <div class="form-group col-md-6 ed_patent_no" style="display:none;">
                                    <label for="journal_Number" class="form-label">Patent Number *</label>
                                    <input type="text" class="form-control" id="ed_p_patent_no" name="p_patent_no">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12 ed_remarks" style="display:none;">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea class="form-control" id="ed_P_remarks" name="P_remarks"></textarea>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="uploadDescription" class="form-label">Patent Paper * (Upload PDF less than 2 MB)</label>
                                <div class="input-group">
                                    <input type="file" class="form-control custom-file-input" name="patent_pdf" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">

                                </div>
                                <p id="descriptionError" class="text-danger"></p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectModalLabel"><b>Project Details</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" id="projectform">

                            <div class="row mb-2">

                                <div class="form-group col-md-6">
                                    <label for="Academia Year">Academic Year *</label>
                                    <select class="form-control" id="prjt_academic_year" name="prjt_academic_year" required="">
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                // Replace 'id' and 'name' with the actual column names in your dept_table
                                            }
                                        } else {
                                            echo '<option value="">No departments available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="level">Type*</label>
                                    <select class="form-control" id="prjt_type" name="prjt_type" required>
                                        <option value="Minnor Project">Minor Project</option>
                                        <option value="Major Project">Major Project</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="form-group col-md-12">
                                    <label for="conference_title" class="form-label">Project Title*</label>
                                    <input type="text" class="form-control" id="prjt_title" name="prjt_title" required>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="publisher_name" class="form-label">Domain</label>
                                    <input type="text" class="form-control" id="prjt_domain" name="prjt_domain">
                                </div>
                               
                                <div class="form-group col-md-6">
                                    <label for="level">Disciplinary*</label>
                                    <select class="form-control" id="prjt_disc" name="prjt_disc" required>
                                        <option value="Single disciplinary">Single disciplinary</option>
                                        <option value="Multi disciplinary">Multi disciplinary</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="sponsor_name" class="form-label">No of Member's</label>
                                    <input type="text" class="form-control" id="prjt_member" name="prjt_member">
                                </div>
                                <div class="form-group col-md-6" id="linkDetails">
                                    <label for="link" class="form-label">Link</label>
                                    <input type="url" class="form-control" id="prjt_link" name="prjt_link">
                                </div>
                            </div>

                            <div class="row mb-2">

                                
                                <div class="form-group col-md-12" id="remarksDetails">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea class="form-control" id="prjt_remarks" name="prjt_remarks"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="uploadDescription" class="form-label">project_pdf * (Upload PDF less than 2 MB)</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" name="prjt_pdf1" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">

                                    </div>
                                    <p id="descriptionError" class="text-danger"></p>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="eprojectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectModalLabel">Project Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="eprojectform">
                            <div class="row mb-2">
                                <input type="hidden" name="id" id="ep_id">



                            </div>
                            <div class="row mb-2">

                                <div class="form-group col-md-6">
                                    <label for="Academia Year">Academic Year *</label>
                                    <select class="form-control" id="eprjt_academic_year" name="prjt_academic_year" required="">
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                // Replace 'id' and 'name' with the actual column names in your dept_table
                                            }
                                        } else {
                                            echo '<option value="">No departments available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="form-group col-md-12">
                                    <label for="conference_title" class="form-label">Project Title*</label>
                                    <input type="text" class="form-control" id="eprjt_title" name="prjt_title" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="sponsor_name" class="form-label">No of Member's</label>
                                    <input type="text" class="form-control" id="eprjt_member" name="prjt_member">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="publisher_name" class="form-label">Domain</label>
                                    <input type="text" class="form-control" id="eprjt_domain" name="prjt_domain">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="level">Type*</label>
                                    <select class="form-control" id="eprjt_type" name="prjt_type" required>
                                        <option value="Minnor Project">Minor Project</option>
                                        <option value="Major Project">Major Project</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="level">disciplinary*</label>
                                    <select class="form-control" id="eprjt_disc" name="prjt_disc" required>
                                        <option value="Single disciplinary">Single disciplinary</option>
                                        <option value="Multi disciplinary">Multi disciplinary</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2">

                                <div class="form-group col-md-6" id="linkDetails">
                                    <label for="link" class="form-label">Link</label>
                                    <input type="url" class="form-control" id="eprjt_link" name="prjt_link">
                                </div>
                                <div class="form-group col-md-12" id="remarksDetails">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea class="form-control" id="eprjt_remarks" name="prjt_remarks"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="uploadDescription" class="form-label">project_pdf * (Upload PDF less than 2 MB)</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" name="eprjt_pdf1" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">

                                    </div>
                                    <p id="descriptionError" class="text-danger"></p>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="projectGuidanceModal" tabindex="-1" role="dialog" aria-labelledby="projectGuidanceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectGuidanceModalLabel"><b>Project Guidance</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <form id="projectGuidanceForm">
                        <div class="modal-body">
                            <div id="researchErrorMessage" class="alert alert-warning d-none"></div>
                            <div class="container">
                                <!-- University Name -->


                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="Academia Year" class="form-label">Academic Year *</label>
                                        <select class="form-control" name="academic_year1" required="">
                                            <option value="">Select Year</option>
                                            <?php
                                            $sql = "SELECT * FROM academic_year ";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                    // Replace 'id' and 'name' with the actual column names in your dept_table
                                                }
                                            } else {
                                                echo '<option value="">No departments available</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                    <label for="noOfScholars" class="form-label">No. of Team's</label>
                                    <input type="text" class="form-control" name="noofteams" id="noofteams" value="1" readonly>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label for="universityName" class="form-label">University Name *</label>
                                    <input type="text" class="form-control" name="university_name" id="universityName" placeholder="Enter University Name" required>
                                </div>
                                <!-- No of Scholars -->
                               
                                <!-- Scholar Details Table -->
                                <label for="" class="form-label">Team Details *</label>
                                <table class="table table-bordered">
                                    <tbody id="projectDetails">
                                        <tr>
                                            <th rowspan="2">1</th>

                                            <td><input type="text" class="form-control" name="domain[]" placeholder="Domain"></td>
                                            <td><input type="text" class="form-control" name="dept[]" placeholder="Dept"></td>
                                            <td>
                                                <select class="form-control" name="project_academic_year[]">
                                                    <option value="">Academic Year</option>
                                                    <option value="2024-2025">2024-2025</option>
                                                    <option value="2023-2024">2023-2024</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="project_batch[]">
                                                    <option value="">Batch</option>
                                                    <option value="2022-2026">2022-2026</option>
                                                    <option value="2021-2025">2021-2025</option>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" name="team_members[]" placeholder="Team Members"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="form-control" name="title[]" placeholder="Project Title"></td>
                                            <td><input type="date" class="form-control" name="date[]"></td>

                                            <td>
                                                <select class="form-control" name="project_category[]">
                                                    <option value="Project">Project</option>
                                                    <option value="Conference">Conference</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="disciplinary[]" required>
                                                    <option value="Single Disciplinary">Single Disciplinary</option>
                                                    <option value="Multi Disciplinary">Multi Disciplinary</option>

                                                </select>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                                <!-- Buttons -->
                                <button type="button" class="form-label btn btn-primary" onclick="addRowProjectGuidance()">+ New</button>
                                <button type="button" class="form-label btn btn-danger" onclick="removeRowProjectGuidance()">- Remove</button>

                            </div>
                            <div class="form-group">
                                <label for="uploadDescription">Project Pdf * (Upload PDF less than 2 MB)</label>
                                <div class="input-group">
                                    <input type="file" class="form-control custom-file-input" name="pdf1" accept=".pdf" onchange="fileValidation(this)" id="uploadDescription" required>
                                </div>
                                <p id="descriptionError" class="text-danger"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ed_ProjectGuidanceModal" tabindex="-1" role="dialog" aria-labelledby="editProjectGuidanceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProjectGuidanceModalLabel">Edit Project Guidance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="ed_ProjectGuidanceForm">
                        <div class="modal-body">
                            <div id="editResearchErrorMessage" class="alert alert-warning d-none"></div>
                            <div class="container">
                                <input type="hidden" name="project_id" id="ed_projectGuidance_id">


                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="edit_academic_year" class="form-label">Academic Year *</label>
                                        <select class="form-control" name="academic_year" id="edpg_academic_year" required>
                                            <option value="">Select Year</option>
                                            <?php
                                            $sql = "SELECT * FROM academic_year";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No years available</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="edit_university_name" class="form-label">University Name *</label>
                                    <input type="text" class="form-control" name="university_name" id="edpg_university_name" required>
                                </div>

                                <div class="form-group">
                                    <label for="edit_noofteams" class="form-label">No. of Teams</label>
                                    <input type="text" class="form-control" name="noofteams" id="edpg_noofteams" readonly>
                                </div>

                                <label for="" class="form-label">Team Details *</label>
                                <table class="table table-bordered">
                                    <tbody id="ed_projectDetails">
                                        <tr>
                                            <th rowspan="2">1</th>
                                            <td><input type="text" class="form-control" name="domain[]" id="edpg_domain" placeholder="Domain"></td>
                                            <td><input type="text" class="form-control" name="dept[]" id="edpg_dept" placeholder="Dept"></td>
                                            <td>
                                                <select class="form-control" name="academic_year[]" id="edpg_academic_year_select">
                                                    <option value="">Academic Year</option>
                                                    <option value="2024-2025">2024-2025</option>
                                                    <option value="2023-2024">2023-2024</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="batch[]" id="edpg_batch">
                                                    <option value="">Batch</option>
                                                    <option value="2022-2026">2022-2026</option>
                                                    <option value="2021-2025">2021-2025</option>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" name="team_members[]" id="edpg_teams" placeholder="Team Members"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="form-control" name="title[]" id="edpg_title" placeholder="Project Title"></td>
                                            <td><input type="date" class="form-control" name="date[]" id="edpg_date"></td>
                                            <td>
                                                <select class="form-control" name="project_category[]" id="edpg_project_category">
                                                    <option value="Project">Project</option>
                                                    <option value="Conference">Conference</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="disciplinary[]" id="edpg_disciplinary">
                                                    <option value="Single Disciplinary">Single Disciplinary</option>
                                                    <option value="Multi Disciplinary">Multi Disciplinary</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <button type="button" class="btn btn-primary" onclick="addRowEditProjectGuidance()">+ New</button>
                                <button type="button" class="btn btn-danger" onclick="removeRowEditProjectGuidance()">- Remove</button>

                                <div class="form-group">
                                    <label for="edit_uploadDescription">Project Pdf * (Upload PDF less than 2 MB)</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" name="pdf1" accept=".pdf" id="edit_uploadDescription" onchange="fileValidation(this)">
                                    </div>
                                    <p id="edit_descriptionError" class="text-danger"></p>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="add_consultancyModal" tabindex="-1" role="dialog" aria-labelledby="add_consultancyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="add_consultancyModalLabel"><b>Funded Projects / Sponsored Research / Grants</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="consultancy_form">


                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="Academia Year" class="form-label">Academic Year *</label>
                                    <select class="form-control" name="academic_year" required="">
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                // Replace 'id' and 'name' with the actual column names in your dept_table
                                            }
                                        } else {
                                            echo '<option value="">No departments available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="consultancy_type" class="form-label">Consultancy Type *</label>
                                    <select class="form-control" id="consultancy_type1" name="consultancy_type" required>
                                        <option value="Select">Select</option>
                                        <option value="Funded Projects">Funded Projects</option>
                                        <option value="Sponsored Research">Sponsored Research</option>
                                        <option value="Grants">Grants</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <input type="text" class="form-control" id="consultancy_rtype1" name="consultancy_rtype" value="Consultancy" hidden>
                                
                                <div class="form-group col-md-6">
                                    <label for="consultancy_title" class="form-label">Title *</label>
                                    <input type="text" class="form-control" id="consultancy_title1" name="consultancy_title" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="project_id" class="form-label">Project Id *</label>
                                    <input type="text" class="form-control" id="project_id1" name="project_id" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="funding_agency" class="form-label">Funding Agency *</label>
                                    <input type="text" class="form-control" id="funding_agency1" name="funding_agency">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="project_particulars" class="form-label">Project Particulars *</label>
                                    <input type="text" class="form-control" id="project_particulars1" name="project_particulars">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="web_link" class="form-label">Web Link *</label>
                                    <input type="text" class="form-control" id="web_link1" name="web_link" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="requested_amount" class="form-label">Requested Amount(Rs.) *</label>
                                    <input type="number" class="form-control" id="requested_amount1" name="requested_amount" required min="1">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-control" id="status1" name="status" required>
                                        <option value="Select">Select</option>
                                        <option value="Applied">Applied</option>
                                        <option value="Granted">Granted</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 applied_group" style="display:none;">
                                    <label for="filing_date" class="form-label">Filing Date *</label>
                                    <input type="date" class="form-control" id="filing_date1" name="filing_date">
                                </div>
                                <div class="form-group col-md-6 granted_group" style="display:none;">
                                    <label for="granted_number" class="form-label">Granted Number *</label>
                                    <input type="text" class="form-control" id="granted_number1" name="granted_number">
                                </div>
                                <div class="form-group col-md-6 granted_group" style="display:none;">
                                    <label for="granted_amount" class="form-label">Granted Amount *</label>
                                    <input type="text" class="form-control" id="granted_amount1" name="granted_amount" >
                                </div>
                                <div class="form-group col-md-6 granted_group" style="display:none;">
                                    <label for="from" class="form-label">From *</label>
                                    <input type="date" class="form-control" id="from1" name="from">
                                </div>
                                <div class="form-group col-md-6 granted_group" style="display:none;">
                                    <label for="to" class="form-label">To *</label>
                                    <input type="date" class="form-control" id="to1" name="to">
                                </div>
                                <div class="form-group col-md-6 completed_group" style="display:none;">
                                    <label for="funds_generated" class="form-label">Funds Generated *</label>
                                    <input type="text" class="form-control" id="funds_generated1" name="funds_generated">
                                </div>
                                <div class="form-group col-md-12 rejected_group" id="remarksDetails" style="display:none;">
                                    <label for="remarks" class="form-label">Remarks </label>
                                    <textarea class="form-control" id="remarks" name="remarks"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="no_of_members" class="form-label">Number of Members *</label>
                                    <input type="number" class="form-control" id="no_of_members1" name="no_of_members" required min="1">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="upload_files" class="form-label">Upload Files *</label>
                                    <label for="">(upload PDF less than 2 MB)</label> <br>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" name="upload_files" id="upload_files1" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">

                                    </div>
                                    <p id="upload_files_err" class="text-danger"></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit_consultancyModal" tabindex="-1" role="dialog" aria-labelledby="edit_consultancyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit_consultancyModalLabel">Funded Projects / Sponsored Research / Grants</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit_consultancy_form">


                            <div class="row">
                                <input type="text" class="form-control" id="edit_consultancy_id1" name="edit_consultancy_id" hidden>
                                <div class="form-group col-md-6">
                                    <label for="Academia Year" class="form-label">Academic Year *</label>
                                    <select class="form-control" name="academic_year" id="edco_academic_year" required="">
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                // Replace 'id' and 'name' with the actual column names in your dept_table
                                            }
                                        } else {
                                            echo '<option value="">No departments available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">

                                <input type="text" class="form-control" id="edit_consultancy_rtype1" name="edit_consultancy_rtype" value="Consultancy" hidden>
                                <div class="form-group col-md-6">
                                    <label for="edit_consultancy_type" class="form-label">Consultancy Type *</label>
                                    <select class="form-control" id="edit_consultancy_type1" name="edit_consultancy_type" required>
                                        <option value="Select">Select</option>
                                        <option value="Funded Projects">Funded Projects</option>
                                        <option value="Sponsored Research">Sponsored Research</option>
                                        <option value="Grants">Grants</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_consultancy_title" class="form-label">Title *</label>
                                    <input type="text" class="form-control" id="edit_consultancy_title1" name="edit_consultancy_title" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="project_id" class="form-label">Project Id *</label>
                                    <input type="text" class="form-control" id="edit_project_id1" name="edit_project_id" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_funding_agency" class="form-label">Funding Agency *</label>
                                    <input type="text" class="form-control" id="edit_funding_agency1" name="edit_funding_agency">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_project_particulars" class="form-label">Project Particulars *</label>
                                    <input type="text" class="form-control" id="edit_project_particulars1" name="edit_project_particulars">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_web_link" class="form-label">Web Link *</label>
                                    <input type="text" class="form-control" id="edit_web_link1" name="edit_web_link" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_requested_amount" class="form-label">Requested Amount(Rs.) *</label>
                                    <input type="number" class="form-control" id="edit_requested_amount1" name="edit_requested_amount" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_status" class="form-label">Status *</label>
                                    <select class="form-control" id="edit_status1" name="edit_status" required>
                                        <option value="Select">Select</option>
                                        <option value="Applied">Applied</option>
                                        <option value="Granted">Granted</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 applied_group1" style="display:none;">
                                    <label for="edit_filing_date" class="form-label">Filing Date *</label>
                                    <input type="date" class="form-control" id="edit_filing_date1" name="edit_filing_date">
                                </div>
                                <div class="form-group col-md-6 granted_group1" style="display:none;">
                                    <label for="edit_granted_number" class="form-label">Granted Number *</label>
                                    <input type="text" class="form-control" id="edit_granted_number1" name="edit_granted_number">
                                </div>
                                <div class="form-group col-md-6 granted_group1" style="display:none;">
                                    <label for="edit_granted_amount" class="form-label">Granted Amount *</label>
                                    <input type="text" class="form-control" id="edit_granted_amount1" name="edit_granted_amount">
                                </div>
                                <div class="form-group col-md-6 granted_group1" style="display:none;">
                                    <label for="edit_from" class="form-label">From *</label>
                                    <input type="date" class="form-control" id="edit_from1" name="edit_from">
                                </div>
                                <div class="form-group col-md-6 granted_group1" style="display:none;">
                                    <label for="edit_to" class="form-label">To *</label>
                                    <input type="date" class="form-control" id="edit_to1" name="edit_to">
                                </div>
                                <div class="form-group col-md-6 completed_group1" style="display:none;">
                                    <label for="edit_funds_generated" class="form-label">Funds Generated *</label>
                                    <input type="text" class="form-control" id="edit_funds_generated1" name="edit_funds_generated">
                                </div>
                                <div class="form-group col-md-12 rejected_group1" id="remarksDetails" style="display:none;">
                                    <label for="edit_remarks" class="form-label">Remarks </label>
                                    <textarea class="form-control" id="edit_remarks" name="edit_remarks"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_no_of_members" class="form-label">Number of Members *</label>
                                    <input type="number" class="form-control" id="edit_no_of_members1" name="edit_no_of_members" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_upload_files" class="form-label">Upload Files *</label>
                                    <label for="">(upload PDF less than 2 MB)</label> <br>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" name="edit_upload_files" id="edit_upload_files1" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">

                                    </div>
                                    <p id="upload_files_err" class="text-danger"></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add_iconsultancyModal" tabindex="-1" role="dialog" aria-labelledby="add_iconsultancyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="add_iconsultancyModalLabel"><b>Industry Consultancy</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="iconsultancy_form">

                            <input type="text" class="form-control" id="iconsultancy_rtype1" name="iconsultancy_rtype" value="Industry Consultancy" hidden>
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="Academia Year" class="form-label">Academic Year *</label>
                                    <select class="form-control" name="academic_year" required="">
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                // Replace 'id' and 'name' with the actual column names in your dept_table
                                            }
                                        } else {
                                            echo '<option value="">No departments available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="iconsultancy_title" class="form-label">Title Of Work *</label>
                                    <input type="text" class="form-control" id="iconsultancy_title1" name="iconsultancy_title" required>
                                </div>
                            </div>
                            <div class="row">

                               
                                <div class="form-group col-md-4">
                                    <label for="iconsultancy_type" class="form-label">Type *</label>
                                    <select class="form-control" id="iconsultancy_type1" name="iconsultancy_type" required>
                                        <option value="Firm">Firm</option>
                                        <option value="Institution">Institution</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="iconsultancy_particulars" class="form-label">Particulars of Institution / Firm *</label>
                                    <input type="text" class="form-control" id="iconsultancy_particulars1" name="iconsultancy_particulars">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="iconsultancy_particulars_work" class="form-label">Particulars of Work *</label>
                                    <input type="text" class="form-control" id="iconsultancy_particulars_work1" name="iconsultancy_particulars_work" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="iconsultancy_web_link" class="form-label">Web link *</label>
                                    <input type="link" class="form-control" id="iconsultancy_web_link1" name="iconsultancy_web_link">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="iconsultancy_requested_amount" class="form-label">Requested Amount(Rs.) *</label>
                                    <input type="number" class="form-control" id="iconsultancy_requested_amount1" name="iconsultancy_requested_amount" required min="1">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="iconsultancy_status" class="form-label">Status *</label>
                                    <select class="form-control" id="iconsultancy_status1" name="iconsultancy_status" required>
                                        <option value="Select">Select</option>
                                        <option value="Applied">Applied</option>
                                        <option value="Granted">Granted</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 applied_group_ic" style="display:none;">
                                    <label for="iconsultancy_filing_date" class="form-label">Filing Date *</label>
                                    <input type="date" class="form-control" id="iconsultancy_filing_date1" name="iconsultancy_filing_date">
                                </div>
                                <div class="form-group col-md-6 granted_group_ic" style="display:none;">
                                    <label for="iconsultancy_granted_number" class="form-label">Granted Number *</label>
                                    <input type="text" class="form-control" id="iconsultancy_granted_number1" name="iconsultancy_granted_number">
                                </div>
                                <div class="form-group col-md-6 granted_group_ic" style="display:none;">
                                    <label for="iconsultancy_granted_amount" class="form-label">Granted Amount *</label>
                                    <input type="text" class="form-control" id="iconsultancy_granted_amount1" name="iconsultancy_granted_amount">
                                </div>
                                <div class="form-group col-md-6 granted_group_ic" style="display:none;">
                                    <label for="iconsultancy_from" class="form-label">From *</label>
                                    <input type="date" class="form-control" id="iconsultancy_from1" name="iconsultancy_from">
                                </div>
                                <div class="form-group col-md-6 granted_group_ic" style="display:none;">
                                    <label for="iconsultancy_to" class="form-label">To *</label>
                                    <input type="date" class="form-control" id="iconsultancy_to1" name="iconsultancy_to">
                                </div>
                                <div class="form-group col-md-6 completed_group_ic" style="display:none;">
                                    <label for="iconsultancy_funds_generated" class="form-label">Funds Generated *</label>
                                    <input type="text" class="form-control" id="iconsultancy_funds_generated1" name="iconsultancy_funds_generated">
                                </div>
                                <div class="form-group col-md-12 rejected_group_ic" id="remarksDetails" style="display:none;">
                                    <label for="iconsultancy_remarks" class="form-label">Remarks </label>
                                    <textarea class="form-control" id="iconsultancy_remarks" name="iconsultancy_remarks"></textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="iconsultancy_mou" class="form-label">MOU Signed with Own Institution *</label>
                                    <select class="form-control" id="iconsultancy_mou1" name="iconsultancy_mou" required>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="iconsultancy_author_count" class="form-label">Author Count *</label>
                                    <input type="number" class="form-control" id="iconsultancy_author_count1" name="iconsultancy_author_count" required min="1">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="iconsultancy_upload_files" class="form-label">Upload Files *</label>
                                    <label for="">(upload PDF less than 2 MB)</label> <br>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" name="iconsultancy_upload_files" id="iconsultancy_upload_files1" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">

                                    </div>
                                    <p id="iconsultancy_upload_files_err" class="text-danger"></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Modal -->
        <div class="modal fade" id="edit_iconsultancyModal" tabindex="-1" role="dialog" aria-labelledby="edit_iconsultancyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit_iconsultancyModalLabel">Edit Industry Consultancy</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit_iconsultancy_form">


                            <div class="row">
                                <input type="hidden" class="form-control" id="edit_iconsultancy_id1" name="edit_iconsultancy_id">
                                <div class="form-group col-md-6">
                                    <label for="Academia Year" class="form-label">Academic Year *</label>
                                    <select class="form-control" name="academic_year" id="edic_academic_year" required="">
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                // Replace 'id' and 'name' with the actual column names in your dept_table
                                            }
                                        } else {
                                            echo '<option value="">No departments available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Hidden input to store the consultancy ID -->

                                <input type="text" class="form-control" id="edit_iconsultancy_rtype1" name="edit_iconsultancy_rtype" value="Industry Consultancy" hidden>


                                <div class="form-group col-md-12">
                                    <label for="edit_iconsultancy_title" class="form-label">Title Of Work *</label>
                                    <input type="text" class="form-control" id="edit_iconsultancy_title1" name="edit_iconsultancy_title" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="edit_iconsultancy_type" class="form-label">Type *</label>
                                    <select class="form-control" id="edit_iconsultancy_type1" name="edit_iconsultancy_type" required>
                                        <option value="Firm">Firm</option>
                                        <option value="Institution">Institution</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="edit_iconsultancy_particulars" class="form-label">Particulars of Institution / Firm *</label>
                                    <input type="text" class="form-control" id="edit_iconsultancy_particulars1" name="edit_iconsultancy_particulars">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_iconsultancy_particulars_work" class="form-label">Particulars of Work *</label>
                                    <input type="text" class="form-control" id="edit_iconsultancy_particulars_work1" name="edit_iconsultancy_particulars_work" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_iconsultancy_web_link" class="form-label">Web link *</label>
                                    <input type="url" class="form-control" id="edit_iconsultancy_web_link1" name="edit_iconsultancy_web_link">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_iconsultancy_mou" class="form-label">MOU Signed with Own Institution *</label>
                                    <select class="form-control" id="edit_iconsultancy_mou1" name="edit_iconsultancy_mou" required>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_iconsultancy_author_count" class="form-label">Author Count *</label>
                                    <input type="number" class="form-control" id="edit_iconsultancy_author_count1" name="edit_iconsultancy_author_count" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="edit_iconsultancy_requested_amount" class="form-label">Requested Amount(Rs.) *</label>
                                    <input type="number" class="form-control" id="edit_iconsultancy_requested_amount1" name="edit_iconsultancy_requested_amount" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_iconsultancy_status" class="form-label">Status *</label>
                                    <select class="form-control" id="edit_iconsultancy_status1" name="edit_iconsultancy_status" required>
                                        <option value="Select">Select</option>
                                        <option value="Applied">Applied</option>
                                        <option value="Granted">Granted</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 applied_group_ic1" style="display:none;">
                                    <label for="edit_iconsultancy_filing_date" class="form-label">Filing Date *</label>
                                    <input type="date" class="form-control" id="edit_iconsultancy_filing_date1" name="edit_iconsultancy_filing_date">
                                </div>
                                <div class="form-group col-md-6 granted_group_ic1" style="display:none;">
                                    <label for="edit_iconsultancy_granted_number" class="form-label">Granted Number *</label>
                                    <input type="text" class="form-control" id="edit_iconsultancy_granted_number1" name="edit_iconsultancy_granted_number">
                                </div>
                                <div class="form-group col-md-6 granted_group_ic1" style="display:none;">
                                    <label for="edit_iconsultancy_granted_amount" class="form-label">Granted Amount *</label>
                                    <input type="text" class="form-control" id="edit_iconsultancy_granted_amount1" name="edit_iconsultancy_granted_amount">
                                </div>
                                <div class="form-group col-md-6 granted_group_ic1" style="display:none;">
                                    <label for="edit_iconsultancy_from" class="form-label">From *</label>
                                    <input type="date" class="form-control" id="edit_iconsultancy_from1" name="edit_iconsultancy_from">
                                </div>
                                <div class="form-group col-md-6 granted_group_ic1" style="display:none;">
                                    <label for="edit_iconsultancy_to" class="form-label">To *</label>
                                    <input type="date" class="form-control" id="edit_iconsultancy_to1" name="edit_iconsultancy_to">
                                </div>
                                <div class="form-group col-md-6 completed_group_ic1" style="display:none;">
                                    <label for="edit_iconsultancy_funds_generated" class="form-label">Funds Generated *</label>
                                    <input type="text" class="form-control" id="edit_iconsultancy_funds_generated1" name="edit_iconsultancy_funds_generated">
                                </div>
                                <div class="form-group col-md-12 rejected_group_ic1" id="remarksDetails" style="display:none;">
                                    <label for="edit_iconsultancy_remarks" class="form-label">Remarks </label>
                                    <textarea class="form-control" id="edit_iconsultancy_remarks" name="edit_iconsultancy_remarks"></textarea>
                                </div>


                                <div class="form-group col-md-12">
                                    <label for="edit_iconsultancy_upload_files" class="form-label">Upload Files *</label>
                                    <label>(upload PDF less than 2 MB)</label><br>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" id="edit_iconsultancy_upload_files1" name="edit_iconsultancy_upload_files" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend">

                                    </div>
                                    <p id="edit_iconsultancy_upload_files_err" class="text-danger"></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="r_guideshipModal" tabindex="-1" role="dialog" aria-labelledby="r_guideshipModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="r_guideshipModalLabel"><b>Research Guideship Details</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="r_guideship_form">

                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="Academia Year" class="form-label">Academic Year *</label>
                                    <select class="form-control" name="academic_year" required="">
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                // Replace 'id' and 'name' with the actual column names in your dept_table
                                            }
                                        } else {
                                            echo '<option value="">No departments available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                <label for="" class="form-label">Faculty *</label>
                                <input type="text" name="faculty" class="form-control" required="">
                            </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="form-label">University Name *</label>
                                <input type="text" name="universityname" class="form-control" required="">
                            </div>
                           
                            <div class="form-group col-md-12">
                                <label for="" class="form-label">Supervisor Status *</label>
                                <select class="form-control" id="supervisor_status" name="supervisorstatus" required>
                                    <option value="">Select Status</option>
                                    <option value="Applied">APPLIED</option>
                                    <option value="Recognized">RECOGNIZED</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12 supervisorapproval" style="display:none;">
                                <label for="" class="form-label">Supervisor Approval Number *</label>
                                <input type="text" name="supervisorapprovalno" class="form-control">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="form-label">Reference Number *</label>
                                <input type="text" name="referencenumber" class="form-control" required="">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="uploadDescription" class="form-label">Research Guideship Paper * (Upload PDF less than 2 MB)</label>
                                <div class="input-group">
                                    <input type="file" class="form-control custom-file-input" name="r_guideship_pdf" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">

                                </div>
                                <p id="descriptionError" class="text-danger"></p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ed_r_guideshipModal" tabindex="-1" role="dialog" aria-labelledby="ed_r_guideshipModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ed_r_guideshipModalLabel">Research Guideship Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="ed_r_guideship_form">

                            <div class="row">
                                <input type="hidden" name="id" id="ed_r_guideship_id">
                                <div class="form-group col-md-6">
                                    <label for="Academia Year" class="form-label">Academic Year *</label>
                                    <select class="form-control" name="academic_year" required="">
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                // Replace 'id' and 'name' with the actual column names in your dept_table
                                            }
                                        } else {
                                            echo '<option value="">No departments available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="" class="form-label">University Name *</label>
                                <input type="text" id="ed_universityname" name="universityname" class="form-control" required="">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="form-label">Faculty *</label>
                                <input type="text" id="ed_faculty" name="faculty" class="form-control" required="">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="form-label">Supervisor Status *</label>
                                <select class="form-control" id="ed_supervisor_status" name="supervisorstatus" required>
                                    <option value="">Select Status</option>
                                    <option value="Applied">APPLIED</option>
                                    <option value="Recognized">RECOGNIZED</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12 ed_supervisorapproval" style="display:none;">
                                <label for="" class="form-label">Supervisor Approval Number *</label>
                                <input type="text" id="ed_supervisorapprovalno" name="supervisorapprovalno" class="form-control">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="form-label">Reference Number *</label>
                                <input type="text" id="ed_referencenumber" name="referencenumber" class="form-control" required="">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="uploadDescription" class="form-label">Research Guideship Paper * (Upload PDF less than 2 MB)</label>
                                <div class="input-group">
                                    <input type="file" class="form-control custom-file-input" name="r_guideship_pdf" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">

                                </div>
                                <p id="descriptionError" class="text-danger"></p>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Updata</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="researchguidancemodal" tabindex="-1" role="dialog" aria-labelledby="researchGuidanceLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="researchGuidanceLabel"><b>Research Guidance</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <form id="researchGuidanceForm">
                        <div class="modal-body">
                            <div id="researchErrorMessage" class="alert alert-warning d-none"></div>
                            <div class="container">
                                <!-- University Name -->


                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="Academia Year" class="form-label">Academic Year *</label>
                                        <select class="form-control" name="academic_year" required="">
                                            <option value="">Select Year</option>
                                            <?php
                                            $sql = "SELECT * FROM academic_year ";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                    // Replace 'id' and 'name' with the actual column names in your dept_table
                                                }
                                            } else {
                                                echo '<option value="">No departments available</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                <!-- No of Scholars -->
                                <div class="form-group col-md-6">
                                    <label for="noOfScholars" class="form-label">No. of Scholars</label>
                                    <input type="text" class="form-control" name="noofscholars" id="noOfScholars" value="1" readonly>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label for="universityName" class="form-label">University Name *</label>
                                    <input type="text" class="form-control" name="university_name" id="universityName" placeholder="Enter University Name" required>
                                </div>
                                <!-- Scholar Details Table -->
                                <label for="" class="form-label">Scholar Details *</label>
                                <table class="table table-bordered">
                                    <tbody id="scholarDetails">
                                        <tr>
                                            <th rowspan="2">1</th>
                                            <td><input type="text" class="form-control" name="name[]" placeholder="Name"></td>
                                            <td><input type="text" class="form-control" name="regno[]" placeholder="Reg No"></td>
                                            <td><input type="text" class="form-control" name="dept[]" placeholder="Dept"></td>
                                            <td><input type="text" class="form-control" name="clg[]" placeholder="College"></td>
                                            <td><input type="text" class="form-control" name="domain[]" placeholder="Domain"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="date" class="form-control" name="date[]"></td>
                                            <td>
                                                <select class="form-control" name="time_mode[]">
                                                    <option value="Full Time">Full Time</option>
                                                    <option value="Part Time">Part Time</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="role[]" required>
                                                    <option value="Supervisor">Supervisor</option>
                                                    <option value="Joint Supervisor">Joint Supervisor</option>
                                                    <option value="DC Member">DC Member</option>
                                                </select>
                                            </td>
                                            <td colspan="2">
                                                <select class="form-control" name="status[]">
                                                    <option value="Registered">Registered</option>
                                                    <option value="Course Work in Progress">Course Work in Progress</option>
                                                    <option value="Course Work Completed">Course Work Completed</option>
                                                    <option value="Confirmation Completed">Confirmation Completed</option>
                                                    <option value="Synopsis Submitted">Synopsis Submitted</option>
                                                    <option value="Thesis Submitted">Thesis Submitted</option>
                                                    <option value="Degree Awarded">Degree Awarded</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- Buttons -->
                                <button type="button" class="form-label btn btn-primary" onclick="addRowResearchGuidance()">+ New</button>
                                <button type="button" class="form-label btn btn-danger" onclick="removeRowResearchGuidance()">- Remove</button>

                            </div>
                            <div class="form-group">
                                <label for="uploadDescription">Research Guidance Paper * (Upload PDF less than 2 MB)</label>
                                <div class="input-group">
                                    <input type="file" class="form-control custom-file-input" name="pdf1" accept=".pdf" onchange="fileValidation(this)" id="uploadDescription" required>
                                </div>
                                <p id="descriptionError" class="text-danger"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ed_researchGuidanceModal" tabindex="-1" role="dialog" aria-labelledby="editResearchGuidanceLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editResearchGuidanceLabel">Edit Research Guidance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <form id="ed_researchGuidanceForm">
                        <div class="modal-body">

                            <div class="row">
                                <input type="hidden" id="ed_guidance_id" name="guidance_id">
                                <div class="form-group col-md-6">
                                    <label for="Academia Year" class="form-label">Academic Year *</label>
                                    <select class="form-control" name="academic_year" required="">
                                        <option value="">Select Year</option>
                                        <?php
                                        $sql = "SELECT * FROM academic_year ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                // Replace 'id' and 'name' with the actual column names in your dept_table
                                            }
                                        } else {
                                            echo '<option value="">No departments available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ed_university_name" class="form-label">University Name *</label>
                                <input type="text" class="form-control" id="ed_university_name" name="university_name" required>
                            </div>
                            <div class="form-group">
                                <label for="ed_no_of_scholars" class="form-label">No. of Scholars</label>
                                <input type="text" class="form-control" id="ed_no_of_scholars" name="noofscholars" readonly>
                            </div>
                            <label for="" class="form-label">Scholar Details *</label>
                            <table class="table table-bordered">
                                <tbody id="ed_scholarDetails"></tbody>
                            </table>
                            <button type="button" class="btn btn-primary form-label" onclick="addRowEditResearchGuidance()">+ New</button>
                            <button type="button" class="btn btn-danger form-label" onclick="removeRowEditResearchGuidance()">- Remove</button>


                            <div class="form-group">
                                <label for="uploadDescription" class="form-label">Research Guidance Paper * (Upload PDF less than 2 MB)</label>
                                <div class="input-group">
                                    <input type="file" class="form-control custom-file-input" name="pdf1" accept=".pdf" onchange="fileValidation(this)" id="uploadDescription" required>

                                </div>
                                <p id="descriptionError" class="text-danger"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="certificateModal" tabindex="-1" role="dialog" aria-labelledby="certificateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="certificateModalLabel"><b>Certification Details</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="certificate_form">
                            <div class="modal-body">
                                <div id="errorMessage" class="alert alert-warning d-none"></div>
                                <input type="hidden" name="id" id="certificate_id">


                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="Academia Year" class="form-label">Academic Year *</label>
                                        <select class="form-control" name="academic_year" required="">
                                            <option value="">Select Year</option>
                                            <?php
                                            $sql = "SELECT * FROM academic_year ";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                    // Replace 'id' and 'name' with the actual column names in your dept_table
                                                }
                                            } else {
                                                echo '<option value="">No departments available</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                    <label for="event_type" class="form-label">Certification Type *</label>
                                    <select class="form-control select-arrow" name="event_type" required>
                                        <option value="">Select</option>
                                        <option value="NPTL">NPTL</option>
                                        <option value="Coursiera">Coursera</option>
                                    </select>
                                </div>
                                </div>
                               
                                <div class="mb-3">
                                    <label for="certification_name" class="form-label">Certification Name *</label>
                                    <input type="text" name="event_name" class="form-control" required="">
                                </div>
                                <!-- <div class="mb-3">
                                                                            <label for="organizer_name">Certification Organizer</label>
                                                                            <input type="text" name="organizer_name" class="form-control" required="">
                                                                        </div> -->

                                <div class="mb-3">
                                    <label for="certification_duration" class="form-label">Certification Duration *</label>
                                    <select class="form-control" name="certification_duration" required>
                                        <option value="">Select Duration</option>
                                        <option value="8 Weeks">8 Weeks</option>
                                        <option value="12 Weeks">12 Weeks</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="uploadDescription" class="form-label">Document * (Upload PDF or Image less than 2 MB)</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" name="certificate_document"
                                            accept=".pdf,image/*" id="uploadFile" onchange="fileValidation1(this)"
                                            aria-describedby="inputGroupPrepend" required="">

                                    </div>
                                    <p id="descriptionError" class="text-danger"></p>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ed_certificateModal" tabindex="-1" role="dialog" aria-labelledby="ed_certificateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <h5 class="modal-title" id="ed_certificateLabel"> Certification Details</h5> -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="ed_certificate_form">
                            <div class="modal-body">
                                <div id="errorMessage" class="alert alert-warning d-none"></div>
                                <input type="hidden" name="id" id="ed_certificate_id">


                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="Academia Year" class="form-label">Academic Year *</label>
                                        <select class="form-control" name="academic_year" id="academic_year" required="">
                                            <option value="">Select Year</option>
                                            <?php
                                            $sql = "SELECT * FROM academic_year ";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . htmlspecialchars($row['academic_year']) . '">' . htmlspecialchars($row['academic_year']) . '</option>';
                                                    // Replace 'id' and 'name' with the actual column names in your dept_table
                                                }
                                            } else {
                                                echo '<option value="">No departments available</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="event_type" class="form-label">Certification Type *</label>
                                    <select class="form-control select-arrow" id="event_type" name="event_type" required>
                                        <option value="">Select</option>
                                        <option value="NPTL">NPTL</option>
                                        <option value="Coursiera">Coursiera</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="certification_name" class="form-label">Certification Name *</label>
                                    <input type="text" name="event_name" id="event_name" class="form-control" required="">
                                </div>
                                <!-- <div class="mb-3">
                                                                                <label for="organizer_name">Certification Organizer</label>
                                                                                <input type="text" name="organizer_name" class="form-control" required="">
                                                                            </div> -->

                                <div class="mb-3">
                                    <label for="certification_duration" class="form-label">Certification Duration *</label>
                                    <select class="form-control" name="certification_duration" id="certification_duration" required>
                                        <option value="">Select Duration</option>
                                        <option value="8 Weeks">8 Weeks</option>
                                        <option value="12 Weeks">12 Weeks</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="uploadDescription" class="form-label">Document * (Upload PDF or Image less than 2 MB)</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" name="certificate_document"
                                            accept=".pdf,image/*" id="uploadFile" onchange="fileValidation1(this)  "
                                            aria-describedby="inputGroupPrepend" required="">

                                    </div>
                                    <p id="descriptionError" class="text-danger"></p>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
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
                            <i class="fas fa-book tab-icon"></i> Publication </span>
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#main_patent" role="tab" aria-selected="false">
                            <i class="fas fa-clipboard tab-icon"></i> Patent</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#main_projects" role="tab" aria-selected="false">
                            <i class="fas fa-graduation-cap tab-icon"></i>
                            Projects</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#main_consultancy" role="tab" aria-selected="false">
                            <i class="fas fa-briefcase mr-2 tab-icon"></i> Consultancy</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#activity" role="tab" aria-selected="false">
                            <i class="fas fa-tasks tab-icon"></i> Activity</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" id="edit-bus-tab" href="#course_certificate" role="tab" aria-selected="false">
                            <i class="fas fa-graduation-cap tab-icon"></i>
                            Course Certification</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">

                    <div class="tab-pane fade show active" id="publication" role="tabpanel">
                        <!-- <div class="card"> -->
                        <!-- Nested Tabs for Publication -->
                        <ul class="nav navs-tabs justify-content-center ">
                            <li class="nav-item" style="margin-right: 10px;"> <!-- Add margin between tabs -->
                                <a class="nav-link active" style="font-size: 0.9em;" id="add-bus-tab" data-bs-toggle="tab" href="#journal" role="tab" aria-selected="true">
                                    Journal
                                </a>
                            </li>
                            <li class="nav-item" style="margin-right: 10px;"> <!-- Add margin between tabs -->
                                <a class="nav-link" id="add-bus-tab" data-bs-toggle="tab" style="font-size: 0.9em;"
                                    href="#conference" role="tab" aria-selected="false">
                                    Conference
                                </a>
                            </li>
                            <li class="nav-item " style="margin-right: 10px;"> <!-- Add margin between tabs -->
                                <a class="nav-link" id="add-bus-tab" data-bs-toggle="tab" style="font-size: 0.9em;"
                                    href="#book_chapter" role="tab" aria-selected="false">
                                    Book Chapter
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane p-20 active" id="journal" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- <div class="card"> -->
                                        <div class="card-header mb-3 " style="text-align: right;">
                                            <!-- <h5 class="mb-0">Journal Information</h5> -->
                                            <button id="open_journal" class="btn btn-sm btn btn-primary" data-bs-toggle="modal" data-bs-target="#journalModal">
                                                Add Journal
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="journal_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>Paper Title</th>
                                                            <th>Journal Name</th>
                                                            <th>J.Detail</th>
                                                            <th>Document</th>
                                                            <th style="width: 200px;">Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT * FROM  journal_papers ";
                                                        $result = mysqli_query($conn, $sql);

                                                        $s = 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $s; ?></td>
                                                                <td><?php echo $row['j_paper_title']; ?></td>
                                                                <td><?php echo $row['journal_name']; ?></td>
                                                                <td class="text-center"><button class=" btn btn-sm btn btn-info view-journal-details" data-id="<?php echo $row['id']; ?>">View</button>
                                                                </td>
                                                                <td class="text-center"><button type='button' class='btn btn-sm btn btn-info view_journal_paper' data-journal_paper_id="<?php echo $row['journal_pdf']; ?>">View</button></td>
                                                                <td>
                                                                    <?php if (in_array($row['status_no'], [0, 3, 4])): ?>
                                                                        <!-- Edit Button -->
                                                                        <button type="button"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            class=" btn btn-sm btn btn-warning journalbtnuseredit ">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>

                                                                        <!-- Delete Button -->
                                                                        <button type="button"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            class="btn btn-sm btn btn-danger journalbtnuserdelete ">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    <?php endif; ?>


                                                                    <!-- Status Button -->
                                                                    <button type="button"

                                                                        class=" btn btn-sm btn  
                                                                                        <?php
                                                                                        if (in_array($row['status_no'], [1, 2])) {
                                                                                            echo 'btn-success';
                                                                                        } elseif (in_array($row['status_no'], [3, 4])) {
                                                                                            echo 'btn-danger journalviewFeedback" data-feedback="' . htmlspecialchars($row['feedback']) . '"';
                                                                                        } elseif (in_array($row['status_no'], [0])) {
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
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- </div> -->
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane p-20" id="conference" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="card-header mb-3" style="text-align: right;">
                                            <!-- <h4 class="mb-0">Conference Information</h4> -->
                                            <button id="open_conference" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#conferenceModal">
                                                Add Conference</button>

                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="conference_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>Paper Title</th>
                                                            <th>Conference Name</th>
                                                            <th>Conference Details</th>
                                                            <th>Document</th>
                                                            <th style="width: 200px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT * FROM conference_papers";
                                                        $result = mysqli_query($conn, $sql);
                                                        $s = 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $s; ?></td>
                                                                <td><?php echo $row['title_of_paper']; ?></td>
                                                                <td><?php echo $row['conference_title']; ?></td>
                                                                <td class="text-center"><button class="btn btn-sm btn-info view-conference-details" data-id="<?php echo $row['id']; ?>">View</button>
                                                                </td>
                                                                <td class="text-center"><button type='button' class='btn btn-info btn-sm view_conference_paper' data-conference_paper_id="<?php echo $row['conference_pdf']; ?>">View</button></td>

                                                                <td>
                                                                    <?php if (in_array($row['status_no'], [0, 3, 4])): ?>
                                                                        <!-- Edit Button -->
                                                                        <button type="button"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            class="btn btn-sm  btn btn-warning conferencebtnuseredit">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>

                                                                        <!-- Delete Button -->
                                                                        <button type="button"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            class="btn btn-sm btn btn-danger conferencebtnuserdelete ">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    <?php endif; ?>

                                                                    <!-- Status Button -->
                                                                    <button type="button"
                                                                        class="btn btn-sm
                                                                                        <?php
                                                                                        if (in_array($row['status_no'], [1, 2])) {
                                                                                            echo 'btn-success';
                                                                                        } elseif (in_array($row['status_no'], [3, 4])) {
                                                                                            echo 'btn-danger viewconferenceFeedback" data-feedback="' . htmlspecialchars($row['feedback']) . '"';
                                                                                        } elseif (in_array($row['status_no'], [0])) {
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
                                                    </tbody>
                                                </table>


                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane p-20" id="book_chapter" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="card-header mb-3" style="text-align: right;">
                                            <!-- <h4 class="mb-0">Conference Information</h4> -->
                                            <button id="Add Book" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#bookModal">
                                                Add Book Chapter </button>

                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="book_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>Category</th>
                                                            <th>Book Title</th>
                                                            <th>Book Details</th>
                                                            <th>Documents</th>


                                                            <th style="width: 200px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT * FROM book";
                                                        $result = mysqli_query($conn, $sql);
                                                        $s = 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $s; ?></td>
                                                                <td><?php echo $row['book_category']; ?></td>
                                                                <td><?php echo $row['book_title']; ?></td>
                                                                <td class="text-center"><button class="btn btn-sm btn-info book_viewdetails" data-id="<?php echo $row['id']; ?>">View</button>
                                                                </td>
                                                                <td class="text-center"><button type='button' class='btn btn-info btn-sm book_viewdocuments' data-book_documents="<?php echo $row['documents']; ?>">View</button></td>

                                                                <td>
                                                                    <?php if (in_array($row['status_no'], [0, 3, 4])): ?>
                                                                        <!-- Edit Button -->
                                                                        <button type="button"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            class="btn btn-sm  btn btn-warning bookbtnuseredit">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>

                                                                        <!-- Delete Button -->
                                                                        <button type="button"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            class="btn btn-sm btn btn-danger bookebtnuserdelete ">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    <?php endif; ?>

                                                                    <!-- Status Button -->
                                                                    <button type="button"
                                                                        class="btn btn-sm
                                                                                        <?php
                                                                                        if (in_array($row['status_no'], [1, 2])) {
                                                                                            echo 'btn-success';
                                                                                        } elseif (in_array($row['status_no'], [3, 4])) {
                                                                                            echo 'btn-danger viewFeedback" data-feedback="' . htmlspecialchars($row['feedback']) . '"';
                                                                                        } elseif (in_array($row['status_no'], [0])) {
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
                                <a class="nav-link active" id="add-bus-tab" data-bs-toggle="tab" href="#patent" role="tab" aria-selected="true">
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
                            <div class="tab-pane p-20 active" id="patent" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- <div class="card"> -->
                                        <div class="card-header mb-3" style="text-align: right;">
                                            <!-- <h4 class="mb-0">Patent Information</h4> -->
                                            <button id="open_patent" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#patentModal">
                                                Open Patent Form
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="patent_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>Patent Title</th>
                                                            <th>P.Detail</th>
                                                            <th>Document</th>
                                                            <th style="width: 200px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT * FROM  patents ";

                                                        $result = mysqli_query($conn, $sql);
                                                        $s = 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $s; ?></td>
                                                                <td><?php echo $row['patent_title']; ?></td>
                                                                <td class="text-center"><button class="btn btn-info btn-sm view-patent-details " data-id="<?php echo $row['id']; ?>">View</button>
                                                                </td>
                                                                <td class="text-center"><button type='button' class='btn btn-info btn-sm view_patent_paper ' data-patent_paper_id="<?php echo $row['patent_pdf']; ?>">View</button></td>
                                                                <td>
                                                                    <?php if (in_array($row['status_no'], [0, 3, 4])): ?>
                                                                        <!-- Edit Button -->

                                                                        <button type="button"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            class="btn btn-sm  btn btn-warning patentbtnuseredit">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>

                                                                        <!-- Delete Button -->
                                                                        <button type="button"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            class="btn btn-sm  btn btn-danger patentbtnuserdelete">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>

                                                                    <?php endif; ?>

                                                                    <!-- Status Button -->
                                                                    <button type="button"

                                                                        class="btn btn-sm
                                                                             <?php
                                                                                if (in_array($row['status_no'], [1, 2])) {
                                                                                    echo 'btn-success';
                                                                                } elseif (in_array($row['status_no'], [3, 4])) {
                                                                                    echo 'btn-danger patentviewFeedback" data-feedback="' . htmlspecialchars($row['feedback']) . '"';
                                                                                } elseif (in_array($row['status_no'], [0])) {
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
                                        <!-- <div class="card"> -->
                                        <div class="card-header mb-3" style="text-align: right;">
                                            <!-- <h4 class="mb-0">Patent Information</h4> -->
                                            <button id="open_patent" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#copyrightModal">
                                                Open Copyrights Form
                                            </button>
                                        </div>


                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="copyrights" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                            <th> S.No </th>
                                                            <th> CopyRights Title </th>
                                                            <th> Details </th>
                                                            <th> Document </th>
                                                            <th> Action </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT * FROM  copyrights ";

                                                        $result = mysqli_query($conn, $sql);
                                                        $s = 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $s; ?></td>
                                                                <td><?php echo $row['copy_title']; ?></td>
                                                                <td class="text-center"><button class="btn btn-info btn-sm view_copyright_details " data-id="<?php echo $row['id']; ?>">View</button>
                                                                </td>
                                                                <td class="text-center"><button type='button' class='btn btn-info btn-sm view_copyright_paper ' data-copyright_id="<?php echo $row['copy_pdf']; ?>">View</button></td>
                                                                <td>
                                                                    <?php if (in_array($row['status_no'], [0, 3, 4])): ?>
                                                                        <!-- Edit Button -->

                                                                        <button type="button"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            class="btn btn-sm  btn btn-warning copybtnuseredit">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>

                                                                        <!-- Delete Button -->
                                                                        <button type="button"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            class="btn btn-sm  btn btn-danger copybtnuserdelete">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>

                                                                    <?php endif; ?>

                                                                    <!-- Status Button -->
                                                                    <button type="button"

                                                                        class="btn btn-sm
                                                                             <?php
                                                                                if (in_array($row['status_no'], [1, 2])) {
                                                                                    echo 'btn-success';
                                                                                } elseif (in_array($row['status_no'], [3, 4])) {
                                                                                    echo 'btn-danger copyviewFeedback" data-feedback="' . htmlspecialchars($row['feedback']) . '"';
                                                                                } elseif (in_array($row['status_no'], [0])) {
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
                                                    </tbody>

                                                </table>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane" id="main_projects" role="tabpanel">
                        <ul class="nav navs-tabs  justify-content-center" role="tablist">
                            <li class="nav-item" role="presentation" style="margin-right: 15px;"> <!-- Add margin between tabs -->
                                <a class="nav-link active" id="add-bus-tab" data-bs-toggle="tab" href="#projects" role="tab" aria-selected="true">
                                    <span class="hidden-xs-down tab-header"> Projects </span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation"> <!-- Add margin between tabs -->
                                <a class="nav-link" id="add-bus-tab" data-bs-toggle="tab" href="#projectguidance" role="tab" aria-selected="false">
                                    <span class="hidden-xs-down tab-header"> Project Guidance</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Project Tab -->
                        <div class="tab-content">

                            <div class="tab-pane p-20 active" id="projects" role="tabpanel">

                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="card-header mb-3" style="text-align:right">
                                            <!-- <h4 class="mb-0">Certificate Information</h4> -->
                                            <button id="open_certificate" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#projectModal">
                                                Add Project
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="project_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                            <th> S.No </th>
                                                            <th> Title </th>
                                                            <th> Project Details</th>
                                                            <th> Document </th>
                                                            <th> Action </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT * FROM  projects ";

                                                        $result = mysqli_query($conn, $sql);
                                                        $s = 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $s; ?></td>
                                                                <td><?php echo $row['title']; ?></td>
                                                                <td class="text-center"><button class="btn btn-info btn-sm view-project-details " data-id="<?php echo $row['id']; ?>">View</button>
                                                                </td>
                                                                <td class="text-center"><button type='button' class='btn btn-info btn-sm view_copy_paper ' data-copy_paper_id="<?php echo $row['project_pdf']; ?>">View</button></td>
                                                                <td>
                                                                    <?php if (in_array($row['status_no'], [0, 3, 4])): ?>
                                                                        <!-- Edit Button -->

                                                                        <button type="button"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            class="btn btn-sm  btn btn-warning projectbtnuseredit">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>

                                                                        <!-- Delete Button -->
                                                                        <button type="button"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            class="btn btn-sm  btn btn-danger projectbtnuserdelete">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>

                                                                    <?php endif; ?>

                                                                    <!-- Status Button -->
                                                                    <button type="button"

                                                                        class="btn btn-sm
                                                                             <?php
                                                                                if (in_array($row['status_no'], [1, 2])) {
                                                                                    echo 'btn-success';
                                                                                } elseif (in_array($row['status_no'], [3, 4])) {
                                                                                    echo 'btn-danger copyviewFeedback" data-feedback="' . htmlspecialchars($row['feedback']) . '"';
                                                                                } elseif (in_array($row['status_no'], [0])) {
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
                                                    </tbody>

                                                </table>



                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane p-20" id="projectguidance" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="card-header mb-3" style="text-align:right">
                                            <!-- <h4 class="mb-0">Certificate Information</h4> -->
                                            <button id="open_certificate" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#projectGuidanceModal">
                                                Add Project
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="projectGuidance_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                            <th> S.No </th>
                                                            <th> Title </th>
                                                            <th> Teams </th>
                                                            <th> Project Details </th>
                                                            <th> Document </th>
                                                            <th> Action </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT * FROM  project_guidance";

                                                        $result = mysqli_query($conn, $sql);
                                                        $s = 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $s; ?></td>
                                                                <td><?php echo $row['staff_name']; ?></td>
                                                                <td><?php echo $row['no_of_teams']; ?></td>
                                                                <td class="text-center"><button class=" btn btn-sm btn btn-info projectGuidance_viewDetails" data-id="<?php echo $row['id']; ?>">View</button>
                                                                </td>
                                                                <td class="text-center"><button type='button' class='btn btn-sm btn btn-info projectGuidance_viewBrouchre' data-journal_paper_id="<?php echo $row['documents']; ?>">View</button></td>
                                                                <td>
                                                                    <?php if (in_array($row['status_no'], [0, 3, 4])): ?>
                                                                        <!-- Edit Button -->
                                                                        <button type="button"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            class=" btn btn-sm btn btn-warning editProjectGuidanceBtn ">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>

                                                                        <!-- Delete Button -->
                                                                        <button type="button"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            class="btn btn-sm btn btn-danger projectGuidanceDeleteBtn ">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    <?php endif; ?>


                                                                    <!-- Status Button -->
                                                                    <button type="button"

                                                                        class=" btn btn-sm btn  
                                                                                        <?php
                                                                                        if (in_array($row['status_no'], [1, 2])) {
                                                                                            echo 'btn-success';
                                                                                        } elseif (in_array($row['status_no'], [3, 4])) {
                                                                                            echo 'btn-danger projectGuidance_viewFeedback" data-feedback="' . htmlspecialchars($row['feedback']) . '"';
                                                                                        } elseif (in_array($row['status_no'], [0])) {
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
                                <a class="nav-link active " id="add-bus-tab" data-bs-toggle="tab" href="#consultancy" role="tab" aria-selected="true">
                                    <span class="hidden-xs-down tab-header">Funded Projects</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation"> <!-- Add margin between tabs -->
                                <a class="nav-link" id="add-bus-tab" data-bs-toggle="tab" href="#industry_consultancy" role="tab" aria-selected="false">
                                    <span class="hidden-xs-down tab-header">Industry Consultancy</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane p-20 active" id="consultancy" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="card-header mb-3 " style="text-align: right;">
                                            <!-- <h4 class="mb-0">Consultancy Information</h4> -->
                                            <button id="open_consultancy" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add_consultancyModal"> Open Funded Projects </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="consultancy_table" class="table table-striped table-bordered ">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                            <th>S.No</th>

                                                            <th>Title</th>
                                                            <th>Consultancy Details</th>
                                                            <th>Document</th>
                                                            <th style="width:200px">Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php

                                                        $sql1 = "SELECT * FROM consultancy ORDER BY `id` DESC";
                                                        $result1 = $conn->query($sql1);
                                                        if ($result1->num_rows > 0) {
                                                            $i = 0;
                                                            while ($row = $result1->fetch_assoc()) {
                                                                $i++;
                                                                echo "<tr>";
                                                                echo "<td>" . $i . "</td>";

                                                                echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                                                                echo "<td class='text-center'><button type='button' class='btn btn-sm btn-info consultancy_viewdetails '                                                                          
                                                                        data-id='" . htmlspecialchars($row["id"]) . "'>View</button></td>";

                                                                echo "<td class='text-center'><button type='button' class='btn btn-sm btn-info consultancy_viewBrochure ' data-consultancy_documents='" . htmlspecialchars($row["documents"]) . "'>View</button></td>";

                                                                $status1 = $row["status1"];
                                                                $status_text = $status[$status1] ?? "Unknown Status";
                                                                $button_class = "btn-secondary";

                                                                if (in_array($status1, [1, 2])) {
                                                                    $button_class = "btn-success btn-sm";
                                                                } else if (in_array($status1, [3, 4])) {
                                                                    $button_class = "btn-danger consultancy_viewFeedback";
                                                                } else if ($status1 == 0) {
                                                                    $button_class = "btn-secondary btn-sm";
                                                                } else {
                                                                    $button_class = "btn-warning btn-sm";
                                                                }

                                                                echo "<td>";

                                                                // Conditionally display the Edit and Delete buttons
                                                                if (in_array($status1, [0, 3, 4])) {
                                                                    echo "<button type='button' value='" . $row['id'] . "' class='btn btn-sm btn btn-warning consultancyeditbtn me-1 '><i class='fas fa-edit'></i></button>";
                                                                    echo "<button type='button' value='" . $row['id'] . "' class='btn btn-sm btn btn-danger consultancydeletebtn me-1'>  <i class='fas fa-trash'></i></button>";
                                                                }

                                                                echo "<button type='button'class='btn $button_class' 
                                                                        " . ($button_class === "btn-danger consultancy_viewFeedback" ? "data-feedback='" . htmlspecialchars($row['feedback']) . "'" : "") . ">
                                                                        $status_text
                                                                        </button>";

                                                                echo "</td>";
                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='6' class='text-center'>No data available</td></tr>";
                                                        }
                                                        ?>

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
                                        <!-- <div class="card"> -->
                                        <div class="card-header mb-3 " style="text-align: right;">
                                            <!-- <h4 class="mb-0">Industry Consultancy</h4> -->
                                            <button id="open_consultancy" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add_iconsultancyModal"> Industry Consultancy Form </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="iconsultancy_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                            <th>S.No</th>

                                                            <th>Industry Consultancy Title</th>
                                                            <th>Industry Consultancy Details</th>
                                                            <th>Document</th>
                                                            <th style="width: 200px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php

                                                        $sql1 = "SELECT * FROM industry_consultancy ";
                                                        $result1 = $conn->query($sql1);
                                                        if ($result1->num_rows > 0) {
                                                            $i = 0;
                                                            while ($row = $result1->fetch_assoc()) {
                                                                $i++;
                                                                echo "<tr>";
                                                                echo "<td>" . $i . "</td>";

                                                                echo "<td>" . $row["iconsultancy_title"] . "</td>";
                                                                echo "<td class='text-center'><button type='button' class='btn btn-info btn-sm iconsultancy_viewdetails1' data-iconsultancy_type='" . $row["iconsultancy_type"] . "'
                                                                         data-id='" . $row["id"] . "'>View</button></td>";

                                                                // Event Brochure Button
                                                                echo "<td class='text-center'><button type='button' class='btn btn-info btn-sm iconsultancy_viewBrochure1' data-iconsultancy_documents='" . $row["iconsultancy_documents"] . "'>View</button></td>";


                                                                $status1 = $row["istatus1"];
                                                                $status_text = $status[$status1] ?? "Unknown Status";
                                                                $button_class = "btn-secondary";

                                                                if (in_array($status1, [1, 2])) {
                                                                    $button_class = "btn-success btn-sm";
                                                                } else if (in_array($status1, [3, 4])) {
                                                                    $button_class = "btn-danger btn-sm iconsultancy_viewFeedback1";
                                                                } else if ($status1 == 0) {
                                                                    $button_class = "btn-secondary btn-sm";
                                                                } else {
                                                                    $button_class = "btn-warning btn-sm";
                                                                }

                                                                echo "<td>";

                                                                // Conditionally display the Edit and Delete buttons
                                                                if (in_array($status1, [0, 3, 4])) {
                                                                    echo "<button type='button' value='" . $row['id'] . "' class='btn btn-sm btn-warning iconsultancyeditbtn me-1'><i class='fas fa-edit'></i></button>";
                                                                    echo "<button type='button' value='" . $row['id'] . "' class='btn btn-sm btn-danger iconsultancydeletebtn me-1'><i class='fas fa-trash'></i></button>";
                                                                }

                                                                // Status button with dynamic class and feedback data
                                                                echo "<button type='button' class='btn $button_class ' " .
                                                                    ($button_class === "btn-danger iconsultancy_viewFeedback1" ?
                                                                        "data-feedback='" . htmlspecialchars($row['ifeedback']) . "'" : "") . ">
                                                                        $status_text
                                                                    </button>";

                                                                echo "</td>";
                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='6' class='text-center'>No data available</td></tr>";
                                                        }
                                                        ?>

                                                        <!-- Modal for Event Brochure or Feedback -->
                                                        <div class="modal fade" id="iconsultancyModal1" tabindex="-1" role="dialog" aria-labelledby="iconsultancyModalLabel1" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="dynamicModalLabel1">Industry-Consultancy Details</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body text-center" id="iconsultancyModalBody1">
                                                                        <!-- Content will be loaded dynamically here -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>



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

                                        <div class="card-header mb-3" style="text-align: right;">
                                            <!-- <h4 class="mb-0">Research Guideship Information</h4> -->
                                            <button id="open_r_guideship" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#r_guideshipModal">
                                                Open Research Guideship Form
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="r_guideship_table" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>University Name</th>
                                                            <th>Research Guideship Details</th>
                                                            <th>Document</th>
                                                            <th style="width:200px">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT * FROM  researchguideship";

                                                        $result = mysqli_query($conn, $sql);
                                                        $s = 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $s; ?></td>
                                                                <td><?php echo $row['universityname']; ?></td>
                                                                <td class="text-center"><button class="btn btn-info btn-sm view_r_guideship_details" data-id="<?php echo $row['id']; ?>">View</button>
                                                                </td>
                                                                <td class="text-center"><button type='button' class='btn btn-info btn-sm view_r_guideship_paper' data-r_guideship_id="<?php echo $row['r_guideship_pdf']; ?>">View</button></td>
                                                                <td>
                                                                    <?php if (in_array($row['status_no'], [0, 3, 4])): ?>
                                                                        <!-- Edit Button -->

                                                                        <button type="button"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            class="btn btn-sm btn btn-warning r_guideshipbtnuseredit ">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>

                                                                        <!-- Delete Button -->
                                                                        <button type="button"
                                                                            value="<?php echo $row['id']; ?>"
                                                                            class="btn btn-sm btn btn-danger r_guideshipbtnuserdelete">
                                                                            <i class="fas fa-trash "></i>
                                                                        </button>

                                                                    <?php endif; ?>

                                                                    <!-- Status Button -->
                                                                    <button type="button"

                                                                        class="btn btn-sm
                                                                             <?php
                                                                                if (in_array($row['status_no'], [1, 2])) {
                                                                                    echo 'btn-success';
                                                                                } elseif (in_array($row['status_no'], [3, 4])) {
                                                                                    echo 'btn-danger r_guideshipviewFeedback" data-feedback="' . htmlspecialchars($row['feedback']) . '"';
                                                                                } elseif (in_array($row['status_no'], [0])) {
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

                                        <div class="card-header mb-3" style="text-align:right">
                                            <!-- <h4 class="mb-0">Research Guidance Information</h4> -->
                                            <button id="open_r_guidance" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#researchguidancemodal">
                                                Open Research Guidance Form
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">

                                                <table id="researchGuidanceTable" class="table table-striped table-bordered">
                                                    <thead class="gradient-header">
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>University Name</th>
                                                            <th>No Of Scholars</th>
                                                            <th>Details</th>
                                                            <th>Document</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT * FROM research_guidance";
                                                        $result = mysqli_query($conn, $sql);
                                                        $serial_number = 1;

                                                        // Define status mapping for status values

                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $serial_number; ?></td>
                                                                <td><?php echo htmlspecialchars($row['university_name']); ?></td>
                                                                <td class="text-center"><?php echo htmlspecialchars($row['no_of_scholars']); ?></td>

                                                                <td class="text-center"><button class="btn btn-info btn-sm view-rguidance-details"
                                                                        data-id="<?php echo $row['guidance_id']; ?>">View
                                                                        Details</button>
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-info btn-sm view_rguidance_paper "
                                                                        data-rguidance-paper-id="<?php echo $row['research_pdf']; ?>">
                                                                        View
                                                                    </button>
                                                                </td>
                                                                <td>
                                                                    <?php if (in_array($row['status_no'], [0, 3, 4])): ?>
                                                                        <!-- Edit Button -->
                                                                        <div style="display: block;">
                                                                            <button type="button" value="<?php echo $row['guidance_id']; ?>"
                                                                                class="btn btn-sm btn btn-warning editResearchGuidanceBtn mb-3">
                                                                                <i class="fas fa-edit"></i>
                                                                            </button>

                                                                            <!-- Delete Button -->
                                                                            <button type="button" value="<?php echo $row['guidance_id']; ?>"
                                                                                class="btn btn-sm btn btn-danger rguidancebtnuserdelete mb-3">
                                                                                <i class="fas fa-trash"></i> </button>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                    <!-- Status Button -->
                                                                    <button type="button" class="btn btn-sm 
                                                                                        <?php
                                                                                        if (in_array($row['status_no'], [1, 2])) {
                                                                                            echo 'btn-success';
                                                                                        } elseif (in_array($row['status_no'], [3, 4])) {
                                                                                            echo 'btn-danger rguidanceviewFeedback" data-feedback="' . htmlspecialchars($row['feedback']) . '"';
                                                                                        } elseif (in_array($row['status_no'], [0])) {
                                                                                            echo 'btn-secondary';
                                                                                        } else {
                                                                                            echo 'btn-warning';
                                                                                        }
                                                                                        ?>">
                                                                        <?php echo $status[$row['status_no']] ?? 'Unknown Status'; ?>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                            $serial_number++;
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

                    <!-- Certification Tab -->
                    <div class="tab-pane" id="course_certificate" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="card-header mb-3" style="text-align:right">
                                    <!-- <h4 class="mb-0">Certificate Information</h4> -->
                                    <button id="open_certificate" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#certificateModal">
                                        Open Certificate Form
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="certificate_table" class="table table-striped table-bordered">
                                            <thead class="gradient-header">
                                                <tr>
                                                    <th>Staff Name</th>
                                                    <!-- <th >Designation</th> -->
                                                    <th style="width:200px">Department</th>
                                                    <th>Certification Type</th>
                                                    <th>Certification Name</th>
                                                    <!-- <th>Certification Organizer</th> -->
                                                    <th>Academic Year</th>
                                                    <th>Certification Duration</th>
                                                    <th>Required Document</th>


                                                    <th style='width:350px;'>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM certifications ORDER BY id DESC";

                                                $result = mysqli_query($conn, $sql);
                                                $s = 1;

                                                while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                    <tr>

                                                        <td><?php echo htmlspecialchars($row['staff_name']); ?></td>

                                                        <td><?php echo htmlspecialchars($row['department']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['event_type']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['event_name']); ?></td>


                                                        <td><?php echo htmlspecialchars($row['academic_year']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['certification_duration']); ?></td>
                                                        <td class="text-center"><button type='button' class='btn btn-info btn-sm view_certificate' data-certificate_id="<?php echo $row['certificate_document']; ?>">View</button></td>

                                                        <td>

                                                            <?php if (in_array($row['status'], [0, 3, 4])): ?>
                                                                <!-- Edit Button -->

                                                                <button type="button" value="<?php echo $row['id']; ?>" class="btn btn-sm btn btn-warning certificatebtnuseredit "> <i class="fas fa-edit"></i></button>

                                                                <!-- Delete Button -->
                                                                <button type="button" value="<?php echo $row['id']; ?>" class="btn btn-sm btn btn-danger certificatebtnuserdelete"> <i class="fas fa-trash"></i></button>
                                                            <?php endif; ?>

                                                            <!-- Status Button -->
                                                            <button type="button" class="btn btn-sm
                                                                                <?php
                                                                                if (in_array($row['status'], [1, 2, 5])) {
                                                                                    echo 'btn-success';
                                                                                } elseif (in_array($row['status'], [3, 4, 6])) {
                                                                                    echo 'btn-danger certificateviewFeedback" data-feedback="' . htmlspecialchars($row['feedback']) . '"';
                                                                                } elseif ($row['status'] == 0) {
                                                                                    echo 'btn-secondary';
                                                                                } else {
                                                                                    echo 'btn-warning';
                                                                                }
                                                                                ?>">
                                                                <?php echo $status[$row['status']] ?? 'Unknown Status'; ?>
                                                            </button>
                                                        </td>
                                                    </tr>
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
            const fileSizeLimit = 2 * 1024 * 1024;
            const labelElement = inputElement.nextElementSibling;
            const errorElement = inputElement.parentElement.nextElementSibling;
            if (file) {
                const fileType = file.type;
                if (fileType !== 'application/pdf') {
                    errorElement.textContent = 'Only PDF files are allowed';
                    labelElement.textContent = 'Choose file';
                    inputElement.value = "";
                    return;
                }

                if (file.size > fileSizeLimit) {
                    errorElement.textContent = 'File size exceeds 2 MB';
                    labelElement.textContent = 'Choose file';
                    inputElement.value = "";
                } else {
                    errorElement.textContent = '';
                    labelElement.textContent = file.name;
                }
            }
        }

        function fileValidation1() {
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

        document.getElementById('impact_factor').addEventListener('blur', function() {
            let value = parseFloat(this.value);
            if (!isNaN(value)) {
                // Format to 4 decimal places
                this.value = value.toFixed(4);
            } else {
                this.value = ''; // Clear the field if the input is invalid
                alert('Please enter a valid number');
            }
        });



        $(document).on('click', '.view_conference_paper', function() {
            var conference_paper_id_Url = $(this).data('conference_paper_id');
            $('#view_ModalLabel').text('Conference Documents');
            $('#view_ModalBody').html('<iframe src="' + conference_paper_id_Url + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });
        $(document).on('click', '.view_journal_paper', function() {
            var journal_paper_id_Url = $(this).data('journal_paper_id');
            var journal_title = journal_paper_id_Url.substring(journal_paper_id_Url.indexOf('_') + 1, journal_paper_id_Url.lastIndexOf('.'))
            $('#view_ModalLabel').text('DOI : ' + journal_title);
            $('#view_ModalBody').html('<iframe src="' + journal_paper_id_Url + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });

        $(document).on('click', '.journalviewFeedback', function() {
            var feedback = $(this).data('feedback');

            $('#view_ModalLabel').text('Feedback');
            $('#view_ModalBody').html('<input type="text" class="form-control" value="' + feedback + '" readonly>');
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
                    $('#view_ModalLabel').text('Conference Details');
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
                    $('#view_ModalLabel').text('Journal Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });

        $(document).on('click', '.viewconferenceFeedback', function() {
            var feedback = $(this).data('feedback');

            $('#view_ModalLabel').text('Feedback');
            $('#view_ModalBody').html('<input type="text" class="form-control" value="' + feedback + '" readonly>');
            $('#view_Modal').modal('show');
        });

        $(document).on('click', '.book_viewdetails', function() {
            var id = $(this).data('id');
            var formData = new FormData();
            formData.append("action", "book_details");
            formData.append("id", id);
            $.ajax({
                url: 'fetch_details.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#view_ModalLabel').text('Book Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });

        $(document).on('click', '.book_viewdocuments', function() {
            var uploaded_files = $(this).data('book_documents');

            $('#view_Modalabel').text('View Documents');
            $('#view_ModalBody').html('<iframe src="' + uploaded_files + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });




        $('#status_patent').change(function() {
            const status = this.value;
            document.querySelectorAll('.no_authors, .published_date, .availability_date, .valid_upto, .availability_date, .journal_no, .remarks, .patent_no')
                .forEach(group => group.style.display = 'none');
            if (status === 'Provisional Registration') {
                document.querySelector('.no_authors').style.display = 'block';
            } else if (status === 'Complete Registration') {
                document.querySelector('.no_authors').style.display = 'block';
            } else if (status === 'Published') {
                document.querySelector('.no_authors').style.display = 'block';
                document.querySelector('.published_date').style.display = 'block';
                document.querySelector('.availability_date').style.display = 'block';
                document.querySelector('.valid_upto').style.display = 'block';
                document.querySelector('.journal_no').style.display = 'block';
            } else if (status === 'Examination Process') {
                document.querySelector('.no_authors').style.display = 'block';
                document.querySelector('.published_date').style.display = 'block';
                document.querySelector('.availability_date').style.display = 'block';
                document.querySelector('.valid_upto').style.display = 'block';
                document.querySelector('.journal_no').style.display = 'block';
            } else if (status === 'Granted') {
                document.querySelector('.no_authors').style.display = 'block';
                document.querySelector('.availability_date').style.display = 'block';
                document.querySelector('.published_date').style.display = 'block';
                document.querySelector('.valid_upto').style.display = 'block';
                document.querySelector('.journal_no').style.display = 'block';
                document.querySelector('.patent_no').style.display = 'block';
            } else if (status === 'Rejected') {
                document.querySelector('.no_authors').style.display = 'block';
                document.querySelector('.remarks').style.display = 'block';
            }
        });
        $('#status_patent').trigger('change');


        $('#ed_status_patent').change(function() {
            const status = this.value;
            document.querySelectorAll('.ed_no_authors, .ed_published_date, .ed_availability_date, .ed_valid_upto, .ed_availability_date, .ed_journal_no, .ed_remarks, .ed_patent_no')
                .forEach(group => group.style.display = 'none');
            if (status === 'Provisional Registration') {
                document.querySelector('.ed_no_authors').style.display = 'block';
            } else if (status === 'Complete Registration') {
                document.querySelector('.ed_no_authors').style.display = 'block';
            } else if (status === 'Published') {
                document.querySelector('.ed_no_authors').style.display = 'block';
                document.querySelector('.ed_published_date').style.display = 'block';
                document.querySelector('.ed_availability_date').style.display = 'block';
                document.querySelector('.ed_valid_upto').style.display = 'block';
                document.querySelector('.ed_journal_no').style.display = 'block';
            } else if (status === 'Examination Process') {
                document.querySelector('.ed_no_authors').style.display = 'block';
                document.querySelector('.ed_published_date').style.display = 'block';
                document.querySelector('.ed_availability_date').style.display = 'block';
                document.querySelector('.ed_valid_upto').style.display = 'block';
                document.querySelector('.ed_journal_no').style.display = 'block';
            } else if (status === 'Granted') {
                document.querySelector('.ed_no_authors').style.display = 'block';
                document.querySelector('.ed_availability_date').style.display = 'block';
                document.querySelector('.ed_published_date').style.display = 'block';
                document.querySelector('.ed_valid_upto').style.display = 'block';
                document.querySelector('.ed_journal_no').style.display = 'block';
                document.querySelector('.ed_patent_no').style.display = 'block';
            } else if (status === 'Rejected') {
                document.querySelector('.ed_no_authors').style.display = 'block';
                document.querySelector('.ed_remarks').style.display = 'block';
            }
        });
        $('#ed_status_patent').trigger('change');


        $(document).on('click', '.view_patent_paper', function() {
            var patent_paper_id_Url = $(this).data('patent_paper_id');
            $('#view_ModalLabel').text('Patent Documents');
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
                    $('#view_ModalLabel').text('Patent Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });

        $(document).on('click', '.patentviewFeedback', function() {
            var feedback = $(this).data('feedback');

            $('#view_ModalLabel').text('Feedback');
            $('#view_ModalBody').html('<input type="text" class="form-control" value="' + feedback + '" readonly>');
            $('#view_Modal_Modal').modal('show');
        });

        $(document).on('click', '.view_copyright_paper', function() {

            var copyright_id_Url = $(this).data('copyright_id');

            $('#view_ModalLabel').text('Copyright Documents');
            $('#view_ModalBody').html('<iframe src="' + copyright_id_Url + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });
        $(document).on('click', '.view_copyright_details', function() {
            var paperId = $(this).data('id'); // Assume each 'view' button has a data-id attribute
            // Create a FormData object
            var formData = new FormData();

            formData.append("action", "copyright_details");
            formData.append("id", paperId);
            $.ajax({
                url: 'fetch_details.php', // Backend script to fetch data
                type: 'POST',
                data: formData,
                contentType: false, // Required for FormData
                processData: false, // Required for FormData
                success: function(response) {
                    $('#view_ModalLabel').text('Copyrights Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });


        $('#status1').change(function() {
            const status = this.value;
            document.querySelectorAll('.applied_group, .granted_group, .completed_group, .rejected_group')
                .forEach(group => group.style.display = 'none');
            if (status === 'Applied') {
                document.querySelector('.applied_group').style.display = 'block';
            } else if (status === 'Granted') {
                document.querySelectorAll('.granted_group').forEach(group => group.style.display = 'block');
            } else if (status === 'Completed') {
                document.querySelectorAll('.granted_group').forEach(group => group.style.display = 'block');
                document.querySelector('.completed_group').style.display = 'block';
            } else if (status === 'Rejected') {
                document.querySelector('.rejected_group').style.display = 'block';
            }
        });

        $('#edit_status1').change(function() {
            const status = this.value;
            document.querySelectorAll('.applied_group1, .granted_group1, .completed_group1, .rejected_group1')
                .forEach(group => group.style.display = 'none');
            if (status === 'Applied') {
                document.querySelector('.applied_group1').style.display = 'block';
            } else if (status === 'Granted') {
                document.querySelectorAll('.granted_group1').forEach(group => group.style.display = 'block');
            } else if (status === 'Completed') {
                document.querySelectorAll('.granted_group1').forEach(group => group.style.display = 'block');
                document.querySelector('.completed_group1').style.display = 'block';
            } else if (status === 'Rejected') {
                document.querySelector('.rejected_group1').style.display = 'block';
            }
        });

        // Trigger change event on page load to apply initial state
        $('#status1').trigger('change');
        $('#edit_status1').trigger('change');


        $(document).on('click', '.view-project-details', function() {
            var copyId = $(this).data('id'); // Assume each 'view' button has a data-id attribute
            // Create a FormData object
            var formData = new FormData();

            formData.append("action", "project_details");
            formData.append("id", copyId);
            $.ajax({
                url: 'fetch_details.php', // Backend script to fetch data
                type: 'POST',
                data: formData,
                contentType: false, // Required for FormData
                processData: false, // Required for FormData
                success: function(response) {
                    $('#view_ModalLabel').text('Project Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });


        $(document).on('click', '.view_project_paper', function() {
            // Retrieve the research PDF URL from the button's data attribute
            var projectPaperUrl = $(this).data('project-paper-id');

            // Update the modal content dynamically
            $('#view_ModalLabel').text('Project Documents');
            $('#view_ModalBody').html('<iframe src="' + projectPaperUrl + '" frameborder="0" style="width:100%; height:500px;"></iframe>');

            // Show the modal
            $('#view_Modal').modal('show');
        });


        $(document).on('click', '.projectGuidance_viewDetails', function() {
            var id = $(this).data('id');
            var formData = new FormData();
            formData.append("action", "projectGuidance_viewDetails");
            formData.append("id", id);
            $.ajax({
                url: 'fetch_details.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#view_ModalLabel').text('Project Guidance Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });

        $(document).on('click', '.projectGuidance_viewBrochure', function() {
            var uploaded_files = $(this).data('projectGuidance_documents');

            $('#view_ModalLabel').text('Project Guidance Documents');
            $('#view_ModalBody').html('<iframe src="' + uploaded_files + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });

        $(document).on('click', '.projectGuidance_viewFeedback', function() {
            var feedback = $(this).data('feedback');

            $('#view_ModalLabel').text('Feedback');
            $('#view_ModalBody').html('<input type="text" class="form-control" value="' + feedback + '" readonly>');
            $('#view_Modal').modal('show');
        });




        $('#iconsultancy_status1').change(function() {
            const status = this.value;
            document.querySelectorAll('.applied_group_ic, .granted_group_ic, .completed_group_ic, .rejected_group_ic')
                .forEach(group => group.style.display = 'none');
            if (status === 'Applied') {
                document.querySelector('.applied_group_ic').style.display = 'block';
            } else if (status === 'Granted') {
                document.querySelectorAll('.granted_group_ic').forEach(group => group.style.display = 'block');
            } else if (status === 'Completed') {
                document.querySelectorAll('.granted_group_ic').forEach(group => group.style.display = 'block');
                document.querySelector('.completed_group_ic').style.display = 'block';
            } else if (status === 'Rejected') {
                document.querySelector('.rejected_group_ic').style.display = 'block';
            }
        });

        $('#edit_iconsultancy_status1').change(function() {
            const status = this.value;
            document.querySelectorAll('.applied_group_ic1, .granted_group_ic1, .completed_group_ic1, .rejected_group_ic1')
                .forEach(group => group.style.display = 'none');
            if (status === 'Applied') {
                document.querySelector('.applied_group_ic1').style.display = 'block';
            } else if (status === 'Granted') {
                document.querySelectorAll('.granted_group_ic1').forEach(group => group.style.display = 'block');
            } else if (status === 'Completed') {
                document.querySelectorAll('.granted_group_ic1').forEach(group => group.style.display = 'block');
                document.querySelector('.completed_group_ic1').style.display = 'block';
            } else if (status === 'Rejected') {
                document.querySelector('.rejected_group_ic1').style.display = 'block';
            }
        });

        // Trigger change event on page load to apply initial state
        $('#iconsultancy_status1').trigger('change');
        $('#edit_iconsultancy_status1').trigger('change');

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
                    $('#view_ModalLabel').text('Funded Project Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });

        $(document).on('click', '.consultancy_viewBrochure', function() {
            var uploaded_files = $(this).data('consultancy_documents');

            $('#view_ModalLabel').text('Funded Project Documents');
            $('#view_ModalBody').html('<iframe src="' + uploaded_files + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });

        $(document).on('click', '.consultancy_viewFeedback', function() {
            var feedback = $(this).data('feedback');

            $('#view_ModalLabel').text('Feedback');
            $('#view_ModalBody').html('<input type="text" class="form-control" value="' + feedback + '" readonly>');
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
                    $('#view_ModalLabel').text('Consultancy Details');
                    $('#view_ModalBody1').html(response);
                    $('#view_ModalModal1').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });

        $(document).on('click', '.iconsultancy_viewBrochure1', function() {
            var uploaded_files = $(this).data('iconsultancy_documents');

            $('#view_ModalLabel1').text('Consultancy Documents');
            $('#view_ModalBody1').html('<iframe src="' + uploaded_files + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal1').modal('show');
        });

        $(document).on('click', '.iconsultancy_viewFeedback1', function() {
            var feedback = $(this).data('feedback');

            $('#view_ModalLabel1').text('Feedback');
            $('#view_ModalBody1').html('<input type="text" class="form-control" value="' + feedback + '" readonly>');
            $('#view_Modal1').modal('show');
        });

        $('#supervisor_status').change(function() {
            const status = this.value;
            document.querySelectorAll('.supervisorapproval')
                .forEach(group => group.style.display = 'none');
            if (status === 'Recognized') {
                document.querySelector('.supervisorapproval').style.display = 'block';
            }
        });
        $('#supervisor_status').trigger('change');


        $('#ed_supervisor_status').change(function() {
            const status = this.value;
            document.querySelectorAll('.ed_supervisorapproval')
                .forEach(group => group.style.display = 'none');
            if (status === 'Recognized') {
                document.querySelector('.ed_supervisorapproval').style.display = 'block';
            }
        });

        $('#ed_supervisor_status').trigger('change');

        $(document).on('click', '.view_r_guideship_paper', function() {
            var r_guideship_id_Url = $(this).data('r_guideship_id');
            $('#view_ModalLabel').text('Research Guideship Documents');
            $('#view_ModalBody').html('<iframe src="' + r_guideship_id_Url + '" frameborder="0" style="width:100%; height:500px;"></iframe>');
            $('#view_Modal').modal('show');
        });

        $(document).on('click', '.view-r_guideship-details', function() {
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
                    $('#view_ModalLabel1').text('Research Guideship Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });

        $(document).on('click', '.r_guideshipviewFeedback', function() {
            var feedback = $(this).data('feedback');

            $('#view_ModalLabel').text('Feedback');
            $('#view_ModalBody').html('<input type="text" class="form-control" value="' + feedback + '" readonly>');
            $('#view_Modal').modal('show');
        });

        $(document).on('click', '.view_rguidance_paper', function() {
            // Retrieve the research PDF URL from the button's data attribute
            var researchPaperUrl = $(this).data('rguidance-paper-id');

            // Update the modal content dynamically
            $('#view_ModalLabel').text('Research Guidance Documents');
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
                    $('#view_ModalLabel1').text('Research Guidance Details');
                    $('#view_ModalBody').html(response);
                    $('#view_Modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });

        $(document).on('click', '.rguidanceviewFeedback', function() {
            var feedback = $(this).data('feedback');

            $('#view_ModalLabel').text('Feedback');
            $('#view_ModalBody').html('<input type="text" class="form-control" value="' + feedback + '" readonly>');
            $('#view_Modal').modal('show');
        });

        function addRowResearchGuidance() {
            const table = document.getElementById("scholarDetails");
            const rowCount = table.querySelectorAll("th").length + 1;

            // First row of the new scholar
            const firstRow = table.insertRow(-1);
            firstRow.innerHTML = `
            <th rowspan="2">${rowCount}</th>
            <td><input type="text" class="form-control" name="name[]" placeholder="Name"></td>
            <td><input type="text" class="form-control" name="regno[]" placeholder="Reg No"></td>
            <td><input type="text" class="form-control" name="dept[]" placeholder="Dept"></td>
            <td><input type="text" class="form-control" name="clg[]" placeholder="College"></td>
            <td><input type="text" class="form-control" name="domain[]" placeholder="Domain"></td>`;

            // Second row of the new scholar
            const secondRow = table.insertRow(-1);
            secondRow.innerHTML = `
            <td><input type="date" class="form-control" name="date[]"></td>
            <td>
                <select class="form-control" name="time_mode[]">
                    <option value="Full Time">Full Time</option>
                    <option value="Part Time">Part Time</option>
                </select>
            </td>
            <td>
                <select class="form-control" name="role[]" required>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Joint Supervisor">Joint Supervisor</option>
                    <option value="DC Member">DC Member</option>
                </select>
            </td>
            <td colspan="2">
                <select class="form-control" name="status[]">
                    <option value="Registered">Registered</option>
                    <option value="Course Work in Progress">Course Work in Progress</option>
                    <option value="Course Work Completed">Course Work Completed</option>
                    <option value="Confirmation Completed">Confirmation Completed</option>
                    <option value="Synopsis Submitted">Synopsis Submitted</option>
                    <option value="Thesis Submitted">Thesis Submitted</option>
                    <option value="Degree Awarded">Degree Awarded</option>
                </select>
            </td>`;
            document.getElementById("noOfScholars").value = rowCount;
        }

        function removeRowResearchGuidance() {
            const table = document.getElementById("scholarDetails");
            const rowCount = table.querySelectorAll("th").length;

            if (rowCount > 1) {
                table.deleteRow(-1); // Remove the second row of the last scholar
                table.deleteRow(-1); // Remove the first row of the last scholar
                document.getElementById("noOfScholars").value = rowCount - 1;
            } else {
                alert("At least one scholar must be present.");
            }
        }

        function addRowEditResearchGuidance() {
            const table = document.getElementById("ed_scholarDetails");
            const rowCount = table.querySelectorAll("th").length + 1;

            // First row of the new scholar
            const firstRow = table.insertRow(-1);
            firstRow.innerHTML = `
                <th rowspan="2">${rowCount}</th>
                <td><input type="text" class="form-control" name="name[]" placeholder="Name"></td>
                <td><input type="text" class="form-control" name="regno[]" placeholder="Reg No"></td>
                <td><input type="text" class="form-control" name="dept[]" placeholder="Dept"></td>
                <td><input type="text" class="form-control" name="clg[]" placeholder="College"></td>
                <td><input type="text" class="form-control" name="domain[]" placeholder="Domain"></td>`;

            // Second row of the new scholar
            const secondRow = table.insertRow(-1);
            secondRow.innerHTML = `
                <td><input type="date" class="form-control" name="date[]"></td>
                <td>
                    <select class="form-control" name="time_mode[]">
                        <option value="Full Time">Full Time</option>
                        <option value="Part Time">Part Time</option>
                    </select>
                </td>
                <td>
                    <select class="form-control" name="role[]" required>
                        <option value="Supervisor">Supervisor</option>
                        <option value="Joint Supervisor">Joint Supervisor</option>
                        <option value="DC Member">DC Member</option>
                    </select>
                </td>
                <td colspan="2">
                    <select class="form-control" name="status[]">
                        <option value="Registered">Registered</option>
                        <option value="Course Work in Progress">Course Work in Progress</option>
                        <option value="Course Work Completed">Course Work Completed</option>
                        <option value="Confirmation Completed">Confirmation Completed</option>
                        <option value="Synopsis Submitted">Synopsis Submitted</option>
                        <option value="Thesis Submitted">Thesis Submitted</option>
                        <option value="Degree Awarded">Degree Awarded</option>
                    </select>
                </td>`;
            document.getElementById("ed_no_of_scholars").value = rowCount;
        }

        function removeRowEditResearchGuidance() {
            const table = document.getElementById("ed_scholarDetails");
            const rowCount = table.querySelectorAll("th").length;

            if (rowCount > 1) {
                table.deleteRow(-1); // Remove the second row of the last scholar
                table.deleteRow(-1); // Remove the first row of the last scholar
                document.getElementById("ed_no_of_scholars").value = rowCount - 1;
            } else {
                alert("At least one scholar must be present.");
            }
        }

        function addRowProjectGuidance() {
            const table = document.getElementById("projectDetails");
            const rowCount = table.querySelectorAll("th").length + 1;

            // First row of the new team member
            const firstRow = table.insertRow(-1);
            firstRow.innerHTML = `
                    <th rowspan="2">${rowCount}</th>
                  

                                            <td><input type="text" class="form-control" name="domain[]" placeholder="Domain"></td>
                                            <td><input type="text" class="form-control" name="dept[]" placeholder="Dept"></td>
                                            <td>
                                                <select class="form-control" name="project_academic_year[]">
                                                    <option value="">Academic Year</option>
                                                    <option value="2024-2025">2024-2025</option>
                                                    <option value="2023-2024">2023-2024</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="project_batch[]">
                                                    <option value="">Batch</option>
                                                    <option value="2022-2026">2022-2026</option>
                                                    <option value="2021-2025">2021-2025</option>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" name="team_members[]" placeholder="Team Members"></td>
                                    
                    `;

            // Second row of the new team member
            const secondRow = table.insertRow(-1);
            secondRow.innerHTML = `
                   <td><input type="text" class="form-control" name="title[]" placeholder="Project Title"></td>
                    <td><input type="date" class="form-control" name="date[]"></td>

                                            <td>
                                                <select class="form-control" name="project_category[]">
                                                    <option value="Project">Project</option>
                                                    <option value="Conference">Conference</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="disciplinary[]" required>
                                                    <option value="Single Disciplinary">Single Disciplinary</option>
                                                    <option value="Multi Disciplinary">Multi Disciplinary</option>

                                                </select>
                                            </td>`;
        }

        function removeRowProjectGuidance() {
            const table = document.getElementById("projectDetails");
            const rowCount = table.querySelectorAll("th").length;

            if (rowCount > 1) {
                table.deleteRow(-1); // Remove the second row of the last team member
                table.deleteRow(-1); // Remove the first row of the last team member
                document.getElementById("noofteams").value = rowCount - 1;
            } else {
                alert("At least one scholar must be present.");
            }
        }

        function addRowEditProjectGuidance() {
            const table = document.getElementById("ed_projectDetails");
            const rowCount = table.querySelectorAll("th").length + 1;

            // First row of the new team member
            const firstRow = table.insertRow(-1);
            firstRow.innerHTML = `
                    <th rowspan="2">${rowCount}</th>
                    <td><input type="text" class="form-control" name="domain[]" placeholder="Domain"></td>
                    <td><input type="text" class="form-control" name="dept[]" placeholder="Dept"></td>
                    <td>
                        <select class="form-control" name="academic_year[]">
                            <option value="">Academic Year</option>
                            <option value="2024-2025">2024-2025</option>
                            <option value="2023-2024">2023-2024</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control" name="batch[]">
                            <option value="">Batch</option>
                            <option value="2022-2026">2022-2026</option>
                            <option value="2021-2025">2021-2025</option>
                        </select>
                    </td>
                     <td><input type="text" class="form-control" name="team_members[]" placeholder="Team Members"></td>`;

            // Second row of the new team member
            const secondRow = table.insertRow(-1);
            secondRow.innerHTML = `
                    <td><input type="text" class="form-control" name="title[]" placeholder="Project Title"></td>
                    <td><input type="date" class="form-control" name="date[]"></td>
                    <td>
                        <select class="form-control" name="project_category[]">
                            <option value="Project">Project</option>
                            <option value="Conference">Conference</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control" name="disciplinary[]" required>
                            <option value="Single Disciplinary">Single Disciplinary</option>
                            <option value="Multi Disciplinary">Multi Disciplinary</option>
                        </select>
                    </td>`;
        }

        function removeRowEditProjectGuidance() {
            const table = document.getElementById("ed_projectDetails");
            const rowCount = table.querySelectorAll("th").length;

            if (rowCount > 1) {
                table.deleteRow(-1); // Remove the second row of the last team member
                table.deleteRow(-1); // Remove the first row of the last team member
                document.getElementById("ed_noofteams").value = rowCount - 1;
            } else {
                alert("At least one scholar must be present.");
            }
        }





        $(document).on('click', '.view-certificate-details', function() {
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
            var modalBody = $('#viewcertificateModalBody');

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


        $(document).on('click', '.certificateviewFeedback', function() {
            var feedback = $(this).data('feedback');

            $('#view_ModalLabel').text('Feedback');
            $('#view_ModalBody').html('<input type="text" class="form-control" value="' + feedback + '" readonly>');
            $('#view_Modal').modal('show');
        });
    </script>
    <script>
        $(document).ready(function() {
            // conference Form submission event
            $(document).on('submit', '#conference_form', function(e) {
                e.preventDefault();
                // console.log("Form submitted");
                var formData = new FormData(this);
                formData.append("action", "save_conference");
                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $('#conferenceModal').modal('hide');
                            $('#conference_form')[0].reset();
                            $('#conference_table').load(location.href + " #conference_table");
                            Swal.fire({
                                title: 'Success',
                                text: 'Event Applied successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else if (res.status == 500) {
                            $('#conferenceModal').modal('hide');
                            $('#conference_form')[0].reset();
                            console.error("Error:", res.message);
                            alert("Something went wrong! Try again.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            });

            $(document).on('click', '.conferencebtnuserdelete', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to delete this data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var user_id = $(this).val();

                        $.ajax({
                            type: "POST",
                            url: "backend.php",
                            data: {
                                'action': 'conferencedeleted',
                                'id': user_id
                            },
                            success: function(response) {
                                var res = jQuery.parseJSON(response);
                                if (res.status == 500) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: res.message
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message
                                    }).then(() => {
                                        $('#conference_table').load(location.href + " #conference_table");
                                    });
                                }
                            }
                        });
                    }
                });
            });
            // Edit button click event
            $(document).on('click', '.conferencebtnuseredit', function(e) {
                e.preventDefault();
                var user_id = $(this).val(); // Get the user ID from the button
                console.log(user_id);

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: {
                        'action': 'edit_conference',
                        'id': user_id
                    },
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            // Populate form fields with retrieved data
                            $('#ed_conference_id').val(res.data.id);
                            $('#edc_staff_id').val(res.data.staff_id);
                            $('#edc_staff_name').val(res.data.staff_name);

                            $('#edc_department').val(res.data.department);
                            $('#edc_academic_year').val(res.data.academic_year);
                            $('#edc_conference_title').val(res.data.conference_title);
                            $('#edc_organizer').val(res.data.organizer);
                            $('#edc_sponsor_name').val(res.data.sponsor_name);
                            $('#edc_publisher_name').val(res.data.publisher_name);
                            $('#edc_indexing_details').val(res.data.indexing_details);
                            $('#edc_level').val(res.data.level);
                            $('#edc_location').val(res.data.location);
                            $('#edc_state').val(res.data.state);
                            $('#edc_country').val(res.data.country);
                            $('#edc_title').val(res.data.title_of_paper);
                            $('#edc_from_date').val(res.data.from_date);
                            $('#edc_to_date').val(res.data.to_date);
                            $('#edc_authors').val(res.data.number_of_authors);
                            $('#edc_eisbn').val(res.data.eisbn);
                            $('#edc_pisbn').val(res.data.pisbn);
                            $('#edc_doi').val(res.data.doi);
                            $('#edc_author_position').val(res.data.author_position);
                            $('#edc_claim_acquired').val(res.data.claim_acquired);
                            $('#edc_link').val(res.data.link);
                            $('#edc_remarks').val(res.data.remarks);

                            // Show the modal
                            $('#ed_conferenceModal').modal('show');
                        } else {
                            alert("Failed to fetch data.");
                        }
                    }
                });
            });
            // Form submission event
            $(document).on('submit', '#ed_conference_form', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append("action", "save_editconference");

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);

                        if (res.status == 200) {
                            $('#ed_conferenceModal').modal('hide');
                            $('#ed_conference_form')[0].reset();

                            // Reload the table dynamically
                            $('#conference_table').load(location.href + " #conference_table");

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Details updated successfully!',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Failed to update details.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to save changes.',
                        });
                    }
                });
            });


            // conference Form submission event
            $(document).on('submit', '#book_form', function(e) {
                e.preventDefault();
                // console.log("Form submitted");
                var formData = new FormData(this);
                formData.append("action", "save_book");
                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $('#bookModal').modal('hide');
                            $('#book_form')[0].reset();
                            $('#book_table').load(location.href + " #book_table");
                            Swal.fire({
                                title: 'Success',
                                text: 'Applied successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else if (res.status == 500) {
                            $('#bookModal').modal('hide');
                            $('#book_form')[0].reset();
                            console.error("Error:", res.message);
                            alert("Something went wrong! Try again.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            });

            $(document).on('click', '.bookbtnuserdelete', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to delete this data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var user_id = $(this).val();

                        $.ajax({
                            type: "POST",
                            url: "backend.php",
                            data: {
                                'action': 'bookdeleted',
                                'id': user_id
                            },
                            success: function(response) {
                                var res = jQuery.parseJSON(response);
                                if (res.status == 500) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: res.message
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message
                                    }).then(() => {
                                        $('#book_table').load(location.href + " #book_table");
                                    });
                                }
                            }
                        });
                    }
                });
            });
            // Edit button click event
            $(document).on('click', '.bookbtnuseredit', function(e) {
                e.preventDefault();
                var user_id = $(this).val(); // Get the user ID from the button
                console.log(user_id);

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: {
                        'action': 'edit_book',
                        'id': user_id
                    },
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {

                            // Populate form fields with retrieved data
                            $('#ed_book_id').val(res.data.id);
                            $('#edb_staff_id').val(res.data.staff_id);
                            $('#edb_staff_name').val(res.data.staff_name);

                            $('#edb_department').val(res.data.department);
                            $('#edb_academic_year').val(res.data.academic_year);
                            $('#edb_book_category').val(res.data.book_category);
                            $('#edb_book_title').val(res.data.book_title);
                            $('#edb_chapter_title').val(res.data.chapter_title);
                            $('#edb_publisher').val(res.data.publisher);
                            $('#edb_indexing_details').val(res.data.indexing_details);
                            $('#edb_published_date').val(res.data.published_month_year);
                            $('#edb_authors').val(res.data.no_of_authors);
                            $('#edb_eisbn').val(res.data.e_isbn);
                            $('#edb_pisbn').val(res.data.p_isbn);
                            $('#edb_volume').val(res.data.volume);
                            $('#edb_edition').val(res.data.edition);
                            $('#edb_author_position').val(res.data.author_position);
                            $('#edb_claim_acquired').val(res.data.claim_acquired);
                            $('#edb_link').val(res.data.link);
                            $('#edb_remarks').val(res.data.b_remarks);
                            $('#ed_bookModal').modal('show');
                            // Show the modal

                        } else {
                            alert("Failed to fetch data.");
                        }
                    }
                });
            });
            // Form submission event
            $(document).on('submit', '#ed_book_form', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append("action", "save_editbook");

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);

                        if (res.status == 200) {
                            $('#ed_bookModal').modal('hide');
                            $('#ed_book_form')[0].reset();

                            // Reload the table dynamically
                            $('#book_table').load(location.href + " #book_table");

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Details updated successfully!',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Failed to update details.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to save changes.',
                        });
                    }
                });
            });


            // journal Form submission event
            $(document).on('submit', '#journal_form', function(e) {
                e.preventDefault(); // Prevent default form submission

                let doi = document.getElementById('doi').value.trim();
                const authorPosition = document.getElementById('author_position').value.trim();

                // Normalize DOI if it contains "https://doi.org/"
                if (doi.startsWith('https://doi.org/')) {
                    doi = doi.replace('https://doi.org/', ''); // Remove the prefix
                }

                if (doi && authorPosition) {
                    // Perform AJAX request to validate DOI and Author Position
                    fetch('fetch_details.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                doi: doi,
                                author_position: authorPosition,
                                action: 'validate_doi'
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }
                            return response.json().catch(() => {
                                throw new Error("Failed to parse JSON response.");
                            });
                        })
                        .then(data => {
                            if (data.status === 'error') {
                                // Show SweetAlert error message
                                Swal.fire({
                                    title: 'Error',
                                    text: data.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                // If validation passes, save the data
                                const formData = new FormData(e.target);
                                formData.append("action", "save_journal");

                                fetch('backend.php', {
                                        method: 'POST',
                                        body: formData
                                    })
                                    .then(saveResponse => saveResponse.json())
                                    .then(saveData => {
                                        if (saveData.status === 200) {
                                            Swal.fire({
                                                title: 'Success',
                                                text: 'Data saved successfully!',
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            }).then(() => {
                                                $('#journalModal').modal('hide'); // Hide the modal
                                                $('#journal_form')[0].reset(); // Reset the form
                                            });
                                        } else {
                                            Swal.fire({
                                                title: 'Error',
                                                text: saveData.message || 'Failed to save data.',
                                                icon: 'error',
                                                confirmButtonText: 'OK'
                                            }).then(() => {
                                                $('#journalModal').modal('hide'); // Hide the modal even on error
                                                $('#journal_form')[0].reset(); // Optionally reset the form
                                                console.error("Error:", saveData.message);
                                            });
                                        }
                                    })
                                    .catch(saveError => {
                                        console.error('Save Error:', saveError);
                                        Swal.fire({
                                            title: 'Error',
                                            text: 'An error occurred while saving the data.',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        }).then(() => {
                                            $('#journalModal').modal('hide'); // Hide the modal
                                            $('#journal_form')[0].reset(); // Reset the form in case of error
                                        });
                                    });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred: ' + error.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                } else {
                    // Show SweetAlert validation error
                    Swal.fire({
                        title: 'Error',
                        text: 'Please fill in both the DOI number and Author Position.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

            $(document).on('click', '.journalbtnuserdelete', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to delete this data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var user_id = $(this).val();

                        $.ajax({
                            type: "POST",
                            url: "backend.php",
                            data: {
                                'action': 'journaldeleted',
                                'id': user_id
                            },
                            success: function(response) {
                                var res = jQuery.parseJSON(response);
                                if (res.status == 500) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: res.message
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message
                                    }).then(() => {
                                        $('#journal_table').load(location.href + " #journal_table");
                                    });
                                }
                            }
                        });
                    }
                });
            });
            // Edit button click event
            $(document).on('click', '.journalbtnuseredit', function(e) {
                e.preventDefault();
                var user_id = $(this).val(); // Get the user ID from the button
                console.log(user_id);
                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: {
                        'action': 'edit_journal',
                        'user_id': user_id
                    },
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            // Populate form fields with retrieved data
                            $('#edj_journal_id').val(res.data.id);
                            $('#edj_staff_id').val(res.data.staff_id);
                            $('#edj_staff_name').val(res.data.staff_name);

                            $('#edj_departement').val(res.data.departement);
                            $('#edj_academic_year').val(res.data.academic_year);
                            $('#edj_indexing_type').val(res.data.indexing_type);
                            $('#edj_journal_name').val(res.data.journal_name);
                            $('#edj_scopus_id').val(res.data.scopus_id);
                            $('#edj_publisher_name').val(res.data.j_publisher_name);
                            $('#edj_journal_status').val(res.data.journal_status);
                            $('#edj_impact_factor').val(res.data.impact_factor);
                            $('#edj_eissn').val(res.data.eissn);
                            $('#edj_country').val(res.data.j_country);
                            $('#edj_level').val(res.data.j_level);

                            $('#edj_paper_title').val(res.data.j_paper_title);
                            $('#edj_journal_paper_status').val(res.data.j_paper_status);
                            $('#edj_month_year').val(res.data.month_year);
                            $('#edj_authors_count').val(res.data.j_authors_count);
                            $('#edj_volume').val(res.data.volume);
                            $('#edj_issue').val(res.data.issue);
                            $('#edj_page').val(res.data.page);
                            $('#edj_journal_link').val(res.data.journal_link);
                            $('#edj_doi_number').val(res.data.doi_number);
                            $('#edj_author_position').val(res.data.author_position);
                            $('#edj_claim_acquired').val(res.data.claim_acquired);

                            $('#ed_remarks').val(res.data.j_remarks);
                            // Show the modal
                            $('#ed_journalModal').modal('show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Unable to retrieve journal details.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to fetch data from the server.',
                        });
                    }
                });
            });
            // Form submission event
            $(document).on('submit', '#ed_journal_form', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("action", "save_editjournal");
                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $('#ed_journalModal').modal('hide');
                            $('#ed_journal_form')[0].reset();

                            // Reload the table dynamically
                            $('#journal_table').load(location.href + " #journal_table");

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Details updated successfully!',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Failed to update details.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to save changes.',
                        });
                    }
                });
            });

            // patent Form submission event
            $(document).on('submit', '#patent_form', function(e) {
                e.preventDefault();
                // console.log("Form submitted");
                var formData = new FormData(this);
                formData.append("action", "save_patent");
                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $('#patentModal').modal('hide');
                            $('#patent_form')[0].reset();
                            $('#patent_table').load(location.href + " #patent_table");
                            Swal.fire({
                                title: 'Success',
                                text: 'Event Applied successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else if (res.status == 500) {
                            $('#patentModal').modal('hide');
                            $('#patent_form')[0].reset();
                            console.error("Error:", res.message);
                            alert("Something went wrong! Try again.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            });

            $(document).on('click', '.patentbtnuserdelete', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to delete this data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var user_id = $(this).val();

                        $.ajax({
                            type: "POST",
                            url: "backend.php",
                            data: {
                                'action': 'patentdeleted',
                                'id': user_id
                            },
                            success: function(response) {
                                var res = jQuery.parseJSON(response);
                                if (res.status == 500) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: res.message
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message
                                    }).then(() => {
                                        $('#patent_table').load(location.href + " #patent_table");
                                    });
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.patentbtnuseredit', function(e) {
                e.preventDefault();
                var user_id = $(this).val(); // Get the user ID from the button
                console.log(user_id);

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: {
                        'action': 'edit_patent',
                        'user_id': user_id
                    },
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            // Populate form fields with retrieved data
                            $('#ed_patent_id').val(res.data.id);
                            $('#edp_staff_id').val(res.data.staff_id);
                            $('#edp_staff_name').val(res.data.staff_name);

                            $('#edp_department').val(res.data.department);
                            $('#edp_academic_year').val(res.data.academic_year);
                            $('#ed_patent_title').val(res.data.patent_title);
                            $('#ed_field_of_innovation').val(res.data.field_of_innovation);
                            $('#ed_patent_particulars').val(res.data.patent_particulars);
                            $('#ed_patent_category').val(res.data.patent_category);
                            $('#ed_patent_country').val(res.data.patent_country);
                            $('#ed_patent_date').val(res.data.patent_date);
                            $('#ed_application_number').val(res.data.application_number);
                            $('#ed_status_patent').val(res.data.p_status);
                            if (res.data.p_status === "Published") {
                                $('.ed_published_date').show();
                                $('#ed_p_published_date').val(res.data.p_published_date);
                            } else {
                                $('.ed_published_date').hide();
                            }

                            if (res.data.p_status === "Granted") {
                                $('.ed_valid_upto').show();
                                $('#ed_p_valid_upto').val(res.data.p_valid_upto);
                            } else {
                                $('.ed_valid_upto').hide();
                            }

                            if (res.data.p_status === "Complete Registration") {
                                $('.ed_patent_no').show();
                                $('#ed_p_patent_no').val(res.data.p_patent_no);
                            } else {
                                $('.ed_patent_no').hide();
                            }

                            $('#ed_P_remarks').val(res.data.P_remarks);

                            // Show the modal
                            $('#ed_patentModal').modal('show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Failed to fetch data.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to fetch data.',
                        });
                    }
                });
            });

            $(document).on('submit', '#ed_patent_form', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append("action", "save_editpatent");

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);

                        if (res.status == 200) {
                            $('#ed_patentModal').modal('hide');
                            $('#ed_patent_form')[0].reset();

                            // Reload the table dynamically
                            $('#patent_table').load(location.href + " #patent_table");

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Details updated successfully!',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Failed to update details.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to save changes.',
                        });
                    }
                });
            });

            // copyright Form submission event
            $(document).on('submit', '#copyright_form', function(e) {
                e.preventDefault();
                // console.log("Form submitted");
                var formData = new FormData(this);
                formData.append("action", "save_patent");
                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $('#patentModal').modal('hide');
                            $('#patent_form')[0].reset();
                            $('#patent_table').load(location.href + " #patent_table");
                            Swal.fire({
                                title: 'Success',
                                text: 'Event Applied successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else if (res.status == 500) {
                            $('#patentModal').modal('hide');
                            $('#patent_form')[0].reset();
                            console.error("Error:", res.message);
                            alert("Something went wrong! Try again.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            });

            $(document).on('click', '.copyrightbtnuserdelete', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to delete this data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var user_id = $(this).val();

                        $.ajax({
                            type: "POST",
                            url: "backend.php",
                            data: {
                                'action': 'patentdeleted',
                                'id': user_id
                            },
                            success: function(response) {
                                var res = jQuery.parseJSON(response);
                                if (res.status == 500) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: res.message
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message
                                    }).then(() => {
                                        $('#patent_table').load(location.href + " #patent_table");
                                    });
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.copyrightbtnuseredit', function(e) {
                e.preventDefault();
                var user_id = $(this).val(); // Get the user ID from the button
                console.log(user_id);

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: {
                        'action': 'edit_copy',
                        'user_id': user_id
                    },
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            // Populate form fields with retrieved data
                            $('#ed_patent_id').val(res.data.id);
                            $('#edp_staff_id').val(res.data.staff_id);
                            $('#edp_staff_name').val(res.data.staff_name);

                            $('#edp_department').val(res.data.department);
                            $('#edp_academic_year').val(res.data.academic_year);
                            $('#ed_patent_title').val(res.data.patent_title);
                            $('#ed_field_of_innovation').val(res.data.field_of_innovation);
                            $('#ed_patent_particulars').val(res.data.patent_particulars);
                            $('#ed_patent_category').val(res.data.patent_category);
                            $('#ed_patent_country').val(res.data.patent_country);
                            $('#ed_patent_date').val(res.data.patent_date);
                            $('#ed_application_number').val(res.data.application_number);
                            $('#ed_status_patent').val(res.data.p_status);
                            if (res.data.p_status === "Published") {
                                $('.ed_published_date').show();
                                $('#ed_p_published_date').val(res.data.p_published_date);
                            } else {
                                $('.ed_published_date').hide();
                            }

                            if (res.data.p_status === "Granted") {
                                $('.ed_valid_upto').show();
                                $('#ed_p_valid_upto').val(res.data.p_valid_upto);
                            } else {
                                $('.ed_valid_upto').hide();
                            }

                            if (res.data.p_status === "Complete Registration") {
                                $('.ed_patent_no').show();
                                $('#ed_p_patent_no').val(res.data.p_patent_no);
                            } else {
                                $('.ed_patent_no').hide();
                            }

                            $('#ed_P_remarks').val(res.data.P_remarks);

                            // Show the modal
                            $('#ed_patentModal').modal('show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Failed to fetch data.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to fetch data.',
                        });
                    }
                });
            });

            $(document).on('submit', '#ed_copyright_form', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append("action", "save_editpatent");

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);

                        if (res.status == 200) {
                            $('#ed_patentModal').modal('hide');
                            $('#ed_patent_form')[0].reset();

                            // Reload the table dynamically
                            $('#patent_table').load(location.href + " #patent_table");

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Details updated successfully!',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Failed to update details.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to save changes.',
                        });
                    }
                });
            });



            $(document).on("submit", "#projectform", function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("action", "addproject");
                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $('#projectModal').modal('hide');
                            $('#projectform')[0].reset();
                            $('#project_table').load(location.href + " #project_table");
                            Swal.fire({
                                title: 'Success',
                                text: 'Project added successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            alert("something went wrong");

                        }
                    }
                })
            });


            $(document).on('click', '.projectbtnuserdelete', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to delete this data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var user_id = $(this).val();

                        $.ajax({
                            type: "POST",
                            url: "backend.php",
                            data: {
                                'action': 'projectdeleted',
                                'id': user_id
                            },
                            success: function(response) {
                                var res = jQuery.parseJSON(response);
                                if (res.status == 500) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: res.message
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message
                                    }).then(() => {
                                        $('#project_table').load(location.href + " #project_table");
                                    });
                                }
                            }
                        });
                    }
                });
            });



            $(document).on("click", ".projectbtnuseredit", function(e) {
                e.preventDefault();
                var id = $(this).val();
                console.log(id);
                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: {
                        "action": "projectedit",
                        "id": id,
                    },
                    success: function(response) {
                        console.log(response);
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $("#ep_id").val(res.data.id);
                            $("#eprjt_staff_id").val(res.data.staff_id);
                            $("#eprjt_staff_name").val(res.data.staff_name);
                            $("#eprjt_department").val(res.data.department);
                            $("#eprjt_academic_year").val(res.data.academic_year);
                            $("#eprjt_title").val(res.data.title);
                            $("#eprjt_member").val(res.data.members);
                            $("#eprjt_domain").val(res.data.domain);
                            $("#eprjt_type").val(res.data.type);
                            $("#eprjt_disc").val(res.data.disciplinary);
                            $("#eprjt_link").val(res.data.link);
                            $("#eprjt_remarks").val(res.data.remarks);
                            $("#eprojectModal").modal('show');


                        } else {
                            alert('failed to fecth details');

                        }
                    }
                })

            });

            $(document).on("submit", "#eprojectform", function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("action", "save_editprjt");
                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: 'Updated Successfully',
                            }).then(() => {
                                $('#eprojectModal').modal('hide');
                                $('#eprojectform')[0].reset();
                                $('#project_table').load(location.href + " #project_table");
                            });


                        } else {
                            alert("error");
                        }
                    }
                })


            });


            $(document).on("submit", "#projectGuidanceForm", function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("action", "save_projectGuidance");

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $('#projectGuidanceModal').modal('hide');
                            $('#projectGuidanceForm')[0].reset();
                            $('#projectGuidance_table').load(location.href + " #projectGuidance_table");
                            Swal.fire({
                                title: 'Success',
                                text: 'Project Guidance added successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Something went wrong',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
            $(document).on("submit", "#ed_ProjectGuidanceForm", function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("action", "save_edit_projectGuidance");

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: 'Project Guidance Updated Successfully',
                            }).then(() => {
                                $('#ed_ProjectGuidanceModal').modal('hide');
                                $('#ed_ProjectGuidanceForm')[0].reset();
                                $('#projectGuidance_table').load(location.href + " #projectGuidance_table");
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong, please try again!',
                            });
                        }
                    }
                });
            });

            $(document).on('click', '.projectGuidanceDeleteBtn', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to delete this data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var guidance_id = $(this).val();

                        $.ajax({
                            type: "POST",
                            url: "backend.php",
                            data: {
                                'action': 'projectGuidanceDeleted',
                                'id': guidance_id
                            },
                            success: function(response) {
                                var res = jQuery.parseJSON(response);
                                if (res.status == 500) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: res.message
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message
                                    }).then(() => {
                                        $('#projectGuidance_table').load(location.href + " #projectGuidance_table");
                                    });
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.editProjectGuidanceBtn', function(e) {
                e.preventDefault();
                const project_id = $(this).val(); // Get the project ID from the button
                console.log(project_id); // Check the ID in the console

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: {
                        'action': 'edit_projectGuidance',
                        'id': project_id
                    },
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.status == 200) {
                            const project = res.data.project_guidance;
                            const teams = res.data.teams;

                            // Populate the Project Guidance fields
                            $('#ed_projectGuidance_id').val(project.id);
                            $('#edpg_staff_id').val(project.staff_id);
                            $('#edpg_staff_name').val(project.staff_name);
                            $('#edpg_department').val(project.department);
                            $('#edpg_academic_year').val(project.academic_year);
                            //$('#edpg_university').val(project.university);
                            $('#edpg_noofteams').val(project.no_of_teams);

                            // Clear and repopulate team details dynamically
                            const teamTable = $('#ed_projectDetails');
                            teamTable.empty(); // Clear existing rows

                            if (teams.length > 0) {
                                teams.forEach((team, index) => {
                                    teamTable.append(` 
                            <tr>
                                <th rowspan="2">${index + 1}</th>
                                <td><input type="text" class="form-control" name="domain[]" value="${team.domain}" placeholder="Domain"></td>
                                <td><input type="text" class="form-control" name="dept[]" value="${team.project_department}" placeholder="Dept"></td>
                                <td>
                                    <select class="form-control" name="academic_year[]">
                                        <option value="">Academic Year</option>
                                        <option value="2024-2025" ${team.project_academic_year === "2024-2025" ? "selected" : ""}>2024-2025</option>
                                        <option value="2023-2024" ${team.project_academic_year === "2023-2024" ? "selected" : ""}>2023-2024</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="batch[]">
                                        <option value="">Batch</option>
                                        <option value="2022-2026" ${team.project_batch === "2022-2026" ? "selected" : ""}>2022-2026</option>
                                        <option value="2021-2025" ${team.project_batch === "2021-2025" ? "selected" : ""}>2021-2025</option>
                                    </select>
                                </td>
                                 <td><input type="text" class="form-control" name="team_members[]" value="${team.team_members}" placeholder="Team Members"></td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control" name="title[]" value="${team.project_title}" placeholder="Project Title"></td>
                                <td><input type="text" class="form-control" name="date[]" value="${team.project_date}"></td>
                                <td>
                                    <select class="form-control" name="project_category[]">
                                        <option value="Project" ${team.project_category === "Project" ? "selected" : ""}>Project</option>
                                        <option value="Conference" ${team.project_category === "Conference" ? "selected" : ""}>Conference</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="disciplinary[]" required>
                                        <option value="Single Disciplinary" ${team.disciplinary === "Single Disciplinary" ? "selected" : ""}>Single Disciplinary</option>
                                        <option value="Multi Disciplinary" ${team.disciplinary === "Multi Disciplinary" ? "selected" : ""}>Multi Disciplinary</option>
                                    </select>
                                </td>
                            </tr>
                        `);
                                });
                            } else {
                                teamTable.append('<tr><td colspan="6" class="text-center">No team details available.</td></tr>');
                            }

                            // Open the modal
                            $('#ed_ProjectGuidanceModal').modal('show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Unable to retrieve details.',
                            });
                        }
                    }
                });
            });


            // consultancy and industry consultancy Form submission event
            $(document).on('submit', '#consultancy_form', function(e) {
                e.preventDefault();
                console.log("Form submitted");

                var formData = new FormData(this);
                formData.append("action", "save_consultancy");
                console.log(formData);

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $('#add_consultancyModal').modal('hide');
                            $('#consultancy_form')[0].reset();
                            $('#consultancy_table').load(location.href + " #consultancy_table");
                            Swal.fire({
                                title: 'Success',
                                text: 'Form Applied successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else if (res.status == 500) {
                            $('#add_consultancyModal').modal('hide');
                            $('#consultancy_form')[0].reset();
                            console.error("Error:", res.message);
                            alert("Something went wrong! Try again.");
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

            $(document).on('submit', '#iconsultancy_form', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("action", "save_iconsultancy");
                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $('#add_iconsultancyModal').modal('hide');
                            $('#iconsultancy_form')[0].reset();
                            $('#iconsultancy_table').load(location.href + " #iconsultancy_table");
                            Swal.fire({
                                title: 'Success',
                                text: 'Form Applied successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else if (res.status == 500) {
                            $('#add_iconsultancyModal').modal('hide');
                            $('#iconsultancy_form')[0].reset();
                            console.error("Error:", res.message);
                            alert("Something went wrong! Try again.");
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

            // Handle Edit button click
            $(document).on('click', '.consultancyeditbtn', function() {
                var consultancyId = $(this).val();
                $('#edit_consultancy_id1').val(consultancyId);

                $.ajax({
                    url: 'backend.php',
                    type: 'POST',
                    data: {
                        id: consultancyId,
                        'action': 'edit_consultancy',
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $('#edco_staff_id').val(res.data.staff_id);
                            $('#edco_staff_name').val(res.data.staff_name);

                            $('#edco_dept').val(res.data.department);
                            $('#edco_academic_year').val(res.data.academic_year);
                            $('#edit_consultancy_type1').val(res.data.consultancy_type);
                            $('#edit_consultancy_title1').val(res.data.title);
                            $('#edit_project_id1').val(res.data.project_id);
                            $('#edit_funding_agency1').val(res.data.funding_agency);
                            $('#edit_project_particulars1').val(res.data.project_particulars);
                            $('#edit_web_link1').val(res.data.web_link);
                            $('#edit_requested_amount1').val(res.data.requested_amount);
                            $('#edit_status1').val(res.data.status);
                            $('#edit_filing_date1').val(res.data.filing_date);
                            $('#edit_granted_number1').val(res.data.granted_number);
                            $('#edit_granted_amount1').val(res.data.granted_amount);
                            $('#edit_from1').val(res.data.from);
                            $('#edit_to1').val(res.data.to);
                            $('#edit_funds_generated1').val(res.data.funds_generated);
                            $('#edit_remarks').val(res.data.remarks);
                            $('#edit_no_of_members1').val(res.data.number_of_members);

                            // $('#edit_upload_files1').val(data.upload_files); // File inputs can't be pre-filled for security reasons

                            // Show or hide dynamic fields based on status
                            if (res.data.status === 'Granted') {
                                $('.granted_group1').show();
                                $('.applied_group1, .completed_group1, .rejected_group1').hide();
                            } else if (res.data.status === 'Completed') {
                                $('.completed_group1').show();
                                $('.granted_group1, .applied_group, .rejected_group1').hide();
                            } else if (res.data.status === 'Rejected') {
                                $('.rejected_group1').show();
                                $('.granted_group1, .applied_group1, .completed_group1').hide();
                            } else {
                                $('.applied_group1').show();
                                $('.granted_group1, .completed_group1, .rejected_group1').hide();
                            }

                            $('#edit_consultancyModal').modal('show'); // Show the edit modal

                        }


                    },
                    error: function() {
                        alert('Failed to fetch consultancy details.');
                    }
                });
            });

            $(document).on('click', '.iconsultancyeditbtn', function() {
                var consultancyId = $(this).val();
                $('#edit_iconsultancy_id1').val(consultancyId);

                $.ajax({
                    url: 'backend.php',
                    type: 'POST',
                    data: {
                        id: consultancyId,
                        'action': 'edit_iconsultancy',

                    },
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $('#edic_staff_id').val(res.data.staff_id);
                            $('#edic_staff_name').val(res.data.staff_name);
                            $('#edic_dept').val(res.data.department);
                            $('#edic_academic_year').val(res.data.academic_year);
                            $('#edit_iconsultancy_title1').val(res.data.iconsultancy_title);
                            $('#edit_iconsultancy_type1').val(res.data.iconsultancy_type);
                            $('#edit_iconsultancy_particulars1').val(res.data.iconsultancy_particulars);
                            $('#edit_iconsultancy_particulars_work1').val(res.data.iconsultancy_particulars_work);
                            $('#edit_iconsultancy_web_link1').val(res.data.iconsultancy_web_link);
                            $('#edit_iconsultancy_mou1').val(res.data.iconsultancy_mou);
                            $('#edit_iconsultancy_author_count1').val(res.data.iconsultancy_author_count);
                            $('#edit_iconsultancy_requested_amount').val(res.data.iconsultancy_requested_amount);
                            $('#edit_iconsultancy_status1').val(res.data.iconsultancy_status);
                            $('#edit_iconsultancy_filing_date1').val(res.data.iconsultancy_filing_date);
                            $('#edit_iconsultancy_granted_number1').val(res.data.iconsultancy_granted_number);
                            $('#edit_iconsultancy_granted_amount1').val(res.data.iconsultancy_granted_amount);
                            $('#edit_iconsultancy_from1').val(res.data.iconsultancy_from);
                            $('#edit_iconsultancy_to1').val(res.data.iconsultancy_to);
                            $('#edit_iconsultancy_funds_generated1').val(res.data.iconsultancy_funds_generated);
                            $('#edit_iconsultancy_remarks').val(res.data.remarks);
                            $('#edit_iconsultancy_no_of_members1').val(res.data.number_of_members);

                            // $('#edit_upload_files1').val(data.upload_files); // File inputs can't be pre-filled for security reasons

                            // Show or hide dynamic fields based on status
                            if (res.data.iconsultancy_status === 'Granted') {
                                $('.granted_group_ic1').show();
                                $('.applied_group_ic1, .completed_group_ic1, .rejected_group_ic1').hide();
                            } else if (res.data.iconsultancy_status === 'Completed') {
                                $('.completed_group_ic1').show();
                                $('.granted_group_ic1, .applied_group_ic1, .rejected_group_ic1').hide();
                            } else if (res.data.iconsultancy_status === 'Rejected') {
                                $('.rejected_group_ic1').show();
                                $('.granted_group_ic1, .applied_group_ic1, .completed_group_ic1').hide();
                            } else {
                                $('.applied_group_ic1').show();
                                $('.granted_group_ic1, .completed_group_ic1, .rejected_group_ic1').hide();
                            }


                            $('#edit_iconsultancyModal').modal('show');
                        }
                    },
                    error: function() {
                        alert('Failed to fetch consultancy details.');
                    }
                });
            });

            // Handle Delete button click
            $(document).on('click', '.consultancydeletebtn', function() {
                var id = $(this).val(); // Get the consultancy ID from the button value

                // Show confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to delete this data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'

                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "backend.php", // Change to your delete PHP file
                            data: {
                                'action': 'delete_consultancy',
                                id: id
                            },



                            success: function(response) {
                                var res = jQuery.parseJSON(response);
                                if (res.status == 500) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: res.message
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message
                                    }).then(() => {
                                        $('#consultancy_table').load(location.href + " #consultancy_table");
                                    });
                                }
                            },



                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to delete the record: ' + error
                                });
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.iconsultancydeletebtn', function() {
                var id = $(this).val(); // Get the consultancy ID from the button value

                // Show confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to delete this data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "backend.php", // Change to your delete PHP file
                            data: {
                                'action': 'delete_iconsultancy',
                                id: id
                            },




                            success: function(response) {
                                var res = jQuery.parseJSON(response);
                                if (res.status == 500) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: res.message
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message
                                    }).then(() => {
                                        $('#iconsultancy_table').load(location.href + " #iconsultancy_table");
                                    });
                                }
                            },


                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to delete the record: ' + error
                                });
                            }
                        });
                    }
                });
            });

            // Handle Edit submit
            $(document).on('submit', '#edit_consultancy_form', function(e) {
                e.preventDefault();
                console.log("Form submitted");

                var formData = new FormData(this);
                formData.append("action", "save_edit_consultancy");
                console.log(formData);

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,


                    success: function(response) {
                        var res = jQuery.parseJSON(response);

                        if (res.status == 200) {
                            $('#edit_consultancyModal').modal('hide');
                            $('#edit_consultancy_form')[0].reset();

                            // Reload the table dynamically
                            $('#consultancy_table').load(location.href + " #consultancy_table");

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Details updated successfully!',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Failed to update details.',
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

            $(document).on('submit', '#edit_iconsultancy_form', function(e) {
                e.preventDefault();
                console.log("Form submitted");

                var formData = new FormData(this);
                formData.append("action", "save_edit_iconsultancy");
                console.log(formData);

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(response) {
                        var res = jQuery.parseJSON(response);

                        if (res.status == 200) {
                            $('#edit_iconsultancyModal').modal('hide');
                            $('#edit_iconsultancy_form')[0].reset();

                            // Reload the table dynamically
                            $('#iconsultancy_table').load(location.href + " #iconsultancy_table");

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Details updated successfully!',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Failed to update details.',
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


            // research_guideship Form submission event
            $(document).on('submit', '#r_guideship_form', function(e) {
                e.preventDefault();
                // console.log("Form submitted");
                var formData = new FormData(this);
                formData.append("action", "save_r_guideship");
                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $('#r_guideshipModal').modal('hide');
                            $('#r_guideship_form')[0].reset();
                            $('#r_guideship_table').load(location.href + " #r_guideship_table");
                            Swal.fire({
                                title: 'Success',
                                text: 'Event Applied successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else if (res.status == 500) {
                            $('#r_guideshipModal').modal('hide');
                            $('#r_guideship_form')[0].reset();
                            console.error("Error:", res.message);
                            alert("Something went wrong! Try again.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            });

            $(document).on('click', '.r_guideshipbtnuserdelete', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to delete this data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var user_id = $(this).val();

                        $.ajax({
                            type: "POST",
                            url: "backend.php",
                            data: {
                                'action': 'delete_r_guideship',
                                'id': user_id
                            },
                            success: function(response) {
                                var res = jQuery.parseJSON(response);
                                if (res.status == 500) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: res.message
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message
                                    }).then(() => {
                                        $('#r_guideship_table').load(location.href + " #r_guideship_table");
                                    });
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.r_guideshipbtnuseredit', function(e) {
                e.preventDefault();
                var user_id = $(this).val(); // Get the user ID from the button
                console.log(user_id);

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: {
                        'action': 'edit_r_guideship',
                        'id': user_id
                    },
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            // Populate form fields with retrieved data
                            $('#ed_r_guideship_id').val(res.data.id);
                            $('#ed_universityname').val(res.data.universityname);
                            $('#ed_faculty').val(res.data.faculty);
                            $('#ed_supervisor_status').val(res.data.supervisor_status);
                            if (res.data.supervisor_status === "Recognized") {
                                $('.ed_supervisorapproval').show();
                                $('#ed_supervisorapproval').val(res.data.supervisorapproval);
                            }

                            $('#ed_referencenumber').val(res.data.referencenumber);

                            // Show the modal
                            $('#ed_r_guideshipModal').modal('show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Failed to fetch data.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to fetch data.',
                        });
                    }
                });
            });
            // Form submission event
            $(document).on('submit', '#ed_r_guideship_form', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append("action", "save_edit_r_guideship");

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);

                        if (res.status == 200) {
                            $('#ed_r_guideshipModal').modal('hide');
                            $('#ed_r_guideship_form')[0].reset();

                            // Reload the table dynamically
                            $('#r_guideship_table').load(location.href + " #r_guideship_table");

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Details updated successfully!',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Failed to update details.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to save changes.',
                        });
                    }
                });
            });

            // research_guidance Form submission event
            $(document).on('submit', '#researchGuidanceForm', function(e) {
                e.preventDefault();
                // console.log("Form submitted");
                var formData = new FormData(this);
                formData.append("action", "save_researchGuidance");
                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $('#researchguidancemodal').modal('hide');
                            $('#researchGuidanceForm')[0].reset();
                            $('#researchGuidanceTable').load(location.href + " #researchGuidanceTable");
                            Swal.fire({
                                title: 'Success',
                                text: 'Event Applied successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else if (res.status == 500) {
                            $('#researchguidancemodal').modal('hide');
                            $('#researchGuidanceForm')[0].reset();
                            console.error("Error:", res.message);
                            alert("Something went wrong! Try again.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            });

            $(document).on('click', '.rguidancebtnuserdelete', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to delete this data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var user_id = $(this).val();

                        $.ajax({
                            type: "POST",
                            url: "backend.php",
                            data: {
                                'action': 'delete_researchGuidance',
                                'id': user_id
                            },
                            success: function(response) {
                                var res = jQuery.parseJSON(response);
                                if (res.status == 500) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: res.message
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message
                                    }).then(() => {
                                        $('#researchGuidanceTable').load(location.href + " #researchGuidanceTable");
                                    });
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.editResearchGuidanceBtn', function(e) {
                e.preventDefault();
                const user_id = $(this).val(); // Get the user ID from the button
                console.log(user_id); // Check the ID in the console

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: {
                        'action': 'edit_researchGuidance',
                        'id': user_id
                    },
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.status == 200) {
                            const guidance = res.data.guidance;
                            const scholars = res.data.scholars;

                            // Populate the Research Guidance fields
                            $('#ed_guidance_id').val(guidance.guidance_id);
                            $('#ed_university_name').val(guidance.university_name);
                            $('#ed_no_of_scholars').val(guidance.no_of_scholars);

                            // Clear and repopulate scholar details dynamically
                            const scholarTable = $('#ed_scholarDetails');
                            scholarTable.empty(); // Clear existing rows

                            if (scholars.length > 0) {
                                scholars.forEach((scholar, index) => {
                                    scholarTable.append(` <tr>
                                            <th rowspan="2">${index + 1}</th>
                                            <td><input type="text" class="form-control" name="name[]" value="${scholar.name}" placeholder="Name"></td>
                                            <td><input type="text" class="form-control" name="regno[]" value="${scholar.regno}" placeholder="Reg No"></td>
                                            <td><input type="text" class="form-control" name="dept[]" value="${scholar.dept}" placeholder="Dept"></td>
                                            <td><input type="text" class="form-control" name="clg[]" value="${scholar.college}" placeholder="College"></td>
                                            <td><input type="text" class="form-control" name="domain[]" value="${scholar.domain}" placeholder="Domain"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="date" class="form-control" name="date[]" value="${scholar.date}"></td>
                                            <td>
                                                <select class="form-control" name="time_mode[]">
                                                    <option value="Full Time" ${scholar.time_mode === "Full Time" ? "selected" : ""}>Full Time</option>
                                                    <option value="Part Time" ${scholar.time_mode === "Part Time" ? "selected" : ""}>Part Time</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="role[]">
                                                    <option value="Supervisor" ${scholar.role === "Supervisor" ? "selected" : ""}>Supervisor</option>
                                                    <option value="Joint Supervisor" ${scholar.role === "Joint Supervisor" ? "selected" : ""}>Joint Supervisor</option>
                                                    <option value="DC Member" ${scholar.role === "DC Member" ? "selected" : ""}>DC Member</option>
                                                </select>
                                            </td>
                                            <td colspan="2">
                                                <select class="form-control" name="status[]">
                                                    <option value="Registered" ${scholar.status === "Registered" ? "selected" : ""}>Registered</option>
                                                    <option value="Course Work in Progress" ${scholar.status === "Course Work in Progress" ? "selected" : ""}>Course Work in Progress</option>
                                                    <option value="Course Work Completed" ${scholar.status === "Course Work Completed" ? "selected" : ""}>Course Work Completed</option>
                                                    <option value="Confirmation Completed" ${scholar.status === "Confirmation Completed" ? "selected" : ""}>Confirmation Completed</option>
                                                    <option value="Synopsis Submitted" ${scholar.status === "Synopsis Submitted" ? "selected" : ""}>Synopsis Submitted</option>
                                                    <option value="Thesis Submitted" ${scholar.status === "Thesis Submitted" ? "selected" : ""}>Thesis Submitted</option>
                                                    <option value="Degree Awarded" ${scholar.status === "Degree Awarded" ? "selected" : ""}>Degree Awarded</option>
                                                </select>
                                            </td>
                                        </tr>
                                    `);
                                });
                            } else {
                                scholarTable.append('<tr><td colspan="6" class="text-center">No scholar details available.</td></tr>');
                            }

                            // Open the modal
                            $('#ed_researchGuidanceModal').modal('show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Unable to retrieve details.',
                            });
                        }
                    }

                });
            });

            $(document).on('submit', '#ed_researchGuidanceForm', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append("action", "save_editResearchGuidance");

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.status == 200) {
                            $('#ed_researchGuidanceModal').modal('hide');
                            $('#ed_researchGuidanceForm')[0].reset();

                            // Reload the table dynamically
                            $('#researchGuidanceTable').load(location.href + " #researchGuidanceTable");

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Details updated successfully!',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Failed to update details.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to save changes.',
                        });
                    }
                });
            });

            // certificate form submission event
            $(document).on('submit', '#certificate_form', function(e) {
                e.preventDefault();
                // console.log("Form submitted");
                var formData = new FormData(this);
                formData.append("action", "save_certificate");
                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $('#certificateModal').modal('hide');
                            $('#certificate_form')[0].reset();
                            $('#certificate_table').load(location.href + " #certificate_table");
                            Swal.fire({
                                title: 'Success',
                                text: 'Certificate added successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else if (res.status == 500) {
                            $('#certificateModal').modal('hide');
                            $('#certificate_form')[0].reset();
                            console.error("Error:", res.message);
                            alert("Something went wrong! Try again.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            });

            $(document).on('click', '.certificatebtnuserdelete', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to delete this data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var id = $(this).val();

                        $.ajax({
                            type: "POST",
                            url: "backend.php",
                            data: {
                                'action': 'delete_certificate',
                                'id': id
                            },
                            success: function(response) {
                                var res = jQuery.parseJSON(response);
                                if (res.status == 500) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: res.message
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message
                                    }).then(() => {
                                        $('#certificate_table').load(location.href + " #certificate_table");
                                    });
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.certificatebtnuseredit', function(e) {
                e.preventDefault();
                var id = $(this).val(); // Get the user ID from the button
                console.log(id);

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: {
                        'action': 'edit_certificate',
                        'id': id
                    },

                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            // Populate form fields with retrieved data

                            $('#ed_certificate_id').val(res.data.id);

                            $('#c_staff_name').val(res.data.staff_name);
                            $('#c_designation').val(res.data.designation);
                            $('#department').val(res.data.department);
                            $('#academic_year').val(res.data.academic_year);
                            $('#event_name').val(res.data.event_name);
                            $('#event_type').val(res.data.event_type);

                            $('#certification_duration').val(res.data.certification_duration);
                            // $('#certificate_document').val(res.data.certificate_document);
                            // Show the modal
                            $('#ed_certificateModal').modal('show');

                        }
                    }
                });
            });

            $(document).on('submit', '#ed_certificate_form', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append("action", "save_editcertificate");

                $.ajax({
                    type: "POST",
                    url: "backend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);

                        if (res.status == 200) {
                            $('#ed_certificateModal').modal('hide');
                            $('#ed_certificate_form')[0].reset();

                            // Reload the table dynamically
                            $('#certificate_table').load(location.href + " #certificate_table");

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Details updated successfully!',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Failed to update details.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to save changes.',
                        });
                    }
                });
            });

        });
    </script>
</body>

</html>