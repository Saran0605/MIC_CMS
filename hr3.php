<?php
require 'config.php';
include("session.php");
$sql = "SELECT * FROM applicant_data";
$result = $conn->query($sql);

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

  <!-- DataTables Buttons extension -->
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JSZip for Excel export -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>


  <!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.print.min.js"></script> -->
  <script>
    $(document).ready(function() {
      var table = $('#applicantTable').DataTable({
        dom: 'Bfrtip',
        buttons: [{
          extend: 'excelHtml5',
          text: 'Download as Excel',
          className: 'btn btn-success', // Bootstrap 5 button styling
          filename: 'Applicant Data',
          exportOptions: {
            columns: ':visible'
          }
        }]
      });

      // Ensure buttons are added to the correct place in Bootstrap 5 layout
      table.buttons().container().appendTo('#applicantTable_wrapper .col-md-6:eq(0)');
    });
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
  <?php include 'Aside2.php'; ?>

  <!-- Main Content -->
  <div class="content">

    <div class="loader-container" id="loaderContainer">
      <div class="loader"></div>
    </div>

    <!-- Topbar -->
    <?php include 'hrtop.php'; ?>

    <!-- Breadcrumb -->
    <div class="breadcrumb-area">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="hr.php">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page"> Recruitment</li>
        </ol>
      </nav>
    </div>

    <div class="modal fade" id="enterRemarkModal" tabindex="-1" aria-labelledby="enterRemarkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enterRemarkModalLabel">Enter Remark</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="enterRemarkForm">
                <div class="modal-body">
                    <input type="hidden" id="applicantId" name="applicantId">
                    <div class="mb-3">
                        <label for="remark" class="form-label">Remark:</label>
                        <textarea class="form-control" id="remark" name="remark" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Remark</button>
                </div>
            </form>
        </div>
    </div>
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
            <i class="fas fa-user tab-icon"></i>Master Data
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link " id="basic-tab" data-bs-toggle="tab" href="#profile" role="tab">
            <i class="fas fa-user tab-icon"></i>Profile
          </a>
        </li>

      </ul>

      <div class="tab-content tabcontent-border">

        <!-- tab 1 -->


        <!-- tab2 -->
        <!-- Academic details Tab Starts -->

        <div class="tab-pane active  p-20" id="home" role="tabpanel">
          <div class="row">
            <div class="col-md-12">
              <div class="card" style="border: none;">
                <!-- <div class="card-header" style="border: none;">
                  <h4>
                    <button type="button" style="float: right;" class="btn btn-secondary" data-bs-toggle="modal"
                      data-bs-target="#facultyAdd">
                      Add Faculty
                    </button>
                  </h4>
                </div> -->
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="applicantTable" class="table table-striped table-bordered">
                      <thead class="gradient-header">
                        <tr>
                          <th>Post Applied For</th>
                          <th>Department</th>
                          <th>Name</th>
                          <th>DOB</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Father's Name</th>
                          <th>Mother's Name</th>
                          <th>Family Status</th>
                          <th>Father's Occupation</th>
                          <th>Mother's Occupation</th>
                          <th>Siblings' Occupation</th>
                          <th>Permanent Address</th>
                          <th>Religion</th>
                          <th>Community</th>
                          <th>Caste</th>
                          <th>Marital Status</th>
                          <th>Spouse Name</th>
                          <th>Spouse Qualification</th>
                          <th>Spouse Occupation</th>
                          <th>Children Info</th>
                          <th>X Std Institution</th>
                          <th>X Std Place</th>
                          <th>X Std Year</th>
                          <th>X Std Percentage</th>
                          <th>XII Std Institution</th>
                          <th>XII Std Place</th>
                          <th>XII Std Year</th>
                          <th>XII Std Percentage</th>
                          <th>Diploma Institution</th>
                          <th>Diploma Place</th>
                          <th>Diploma Year</th>
                          <th>Diploma Percentage</th>
                          <th>UG Institution</th>
                          <th>UG Place</th>
                          <th>UG Year</th>
                          <th>UG Percentage</th>
                          <th>PG Institution</th>
                          <th>PG Place</th>
                          <th>PG Year</th>
                          <th>PG Percentage</th>
                          <th>MPhil Institution</th>
                          <th>MPhil Place</th>
                          <th>MPhil Year</th>
                          <th>MPhil Percentage</th>
                          <th>PhD Institution</th>
                          <th>PhD Place</th>
                          <th>PhD Year</th>
                          <th>PhD Percentage</th>
                          <th>Additional Qualification</th>
                          <th>UG Experience</th>
                          <th>PG Experience</th>
                          <th>PhD Experience</th>
                          <th>Total Experience</th>
                          <th>Salary Expected</th>
                          <th>Application Date</th>
                          <th>Photo</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                          // Output data of each row
                          while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["post_applied_for"] . "</td>";
                            echo "<td>" . $row["department"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["dob"] . "</td>";
                            echo "<td>" . $row["phone"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["father_name"] . "</td>";
                            echo "<td>" . $row["mother_name"] . "</td>";
                            echo "<td>" . $row["family_status"] . "</td>";
                            echo "<td>" . $row["father_occupation"] . "</td>";
                            echo "<td>" . $row["mother_occupation"] . "</td>";
                            echo "<td>" . $row["siblings_occupation"] . "</td>";
                            echo "<td>" . $row["permanent_address"] . "</td>";
                            echo "<td>" . $row["religion"] . "</td>";
                            echo "<td>" . $row["community"] . "</td>";
                            echo "<td>" . $row["caste"] . "</td>";
                            echo "<td>" . $row["marital_status"] . "</td>";
                            echo "<td>" . $row["spouse_name"] . "</td>";
                            echo "<td>" . $row["spouse_qualification"] . "</td>";
                            echo "<td>" . $row["spouse_occupation"] . "</td>";
                            echo "<td>" . $row["children_info"] . "</td>";
                            echo "<td>" . $row["x_std_institution"] . "</td>";
                            echo "<td>" . $row["x_std_place"] . "</td>";
                            echo "<td>" . $row["x_std_year"] . "</td>";
                            echo "<td>" . $row["x_std_percentage"] . "</td>";
                            echo "<td>" . $row["xii_std_institution"] . "</td>";
                            echo "<td>" . $row["xii_std_place"] . "</td>";
                            echo "<td>" . $row["xii_std_year"] . "</td>";
                            echo "<td>" . $row["xii_std_percentage"] . "</td>";
                            echo "<td>" . $row["diploma_institution"] . "</td>";
                            echo "<td>" . $row["diploma_place"] . "</td>";
                            echo "<td>" . $row["diploma_year"] . "</td>";
                            echo "<td>" . $row["diploma_percentage"] . "</td>";
                            echo "<td>" . $row["ug_institution"] . "</td>";
                            echo "<td>" . $row["ug_place"] . "</td>";
                            echo "<td>" . $row["ug_year"] . "</td>";
                            echo "<td>" . $row["ug_percentage"] . "</td>";
                            echo "<td>" . $row["pg_institution"] . "</td>";
                            echo "<td>" . $row["pg_place"] . "</td>";
                            echo "<td>" . $row["pg_year"] . "</td>";
                            echo "<td>" . $row["pg_percentage"] . "</td>";
                            echo "<td>" . $row["mphil_institution"] . "</td>";
                            echo "<td>" . $row["mphil_place"] . "</td>";
                            echo "<td>" . $row["mphil_year"] . "</td>";
                            echo "<td>" . $row["mphil_percentage"] . "</td>";
                            echo "<td>" . $row["phd_institution"] . "</td>";
                            echo "<td>" . $row["phd_place"] . "</td>";
                            echo "<td>" . $row["phd_year"] . "</td>";
                            echo "<td>" . $row["phd_percentage"] . "</td>";
                            echo "<td>" . $row["additional_qualification"] . "</td>";
                            echo "<td>" . $row["ug_experience"] . "</td>";
                            echo "<td>" . $row["pg_experience"] . "</td>";
                            echo "<td>" . $row["phd_experience"] . "</td>";
                            echo "<td>" . $row["total_experience"] . "</td>";
                            echo "<td>" . $row["salary_expected"] . "</td>";
                            echo "<td>" . $row["application_date"] . "</td>";
                            echo "<td><img src='images/photo/" . $row["photo_file_path"] . "' alt='Photo' width='50' height='50'></td>";
                            echo "</tr>";
                          }
                        } else {
                          echo "<tr><td colspan='54'>No data available</td></tr>";
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
        <div class="tab-pane p-20" id="profile" role="tabpanel">

          <div class="row">
            <div class="col-md-12">
              <div class="card" style="border: none;">
                <!-- <div class="card-header" style="border: none;">
                  <h4>
                    <button type="button" style="float: right;" class="btn btn-secondary" data-bs-toggle="modal"
                      data-bs-target="#familyadd">
                      Add Family Members
                    </button>
                  </h4>
                </div> -->
                <div class="card-body">
                  <div class="table-responsive">

                    <table id="applicantTable1" class="table table-striped table-hover align-middle">
                      <thead class="gradient-header">
                        <tr>
                          <th>Name</th>
                          <th>Post Applied For</th>
                          <th>Department</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Photo</th>
                          <th>Remark</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = "SELECT * FROM applicant_data";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["post_applied_for"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["department"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                            echo "<td><img src='photo/" . htmlspecialchars($row["photo_file_path"]) . "' class='rounded' alt='Photo' width='50' height='50'></td>";
                            echo "<td>" . htmlspecialchars($row["remarks"]) . "</td>";

                            // Action buttons with Bootstrap 5 icons
                            echo "<td>
    <button class='btn btn-warning btn-sm enterRemarkBtn' data-id='" . $row["id"] . "'>
        <i class='fas fa-edit'></i> <!-- Edit Icon -->
    </button>
    <button class='btn btn-danger btn-sm deleteBtn' data-id='" . $row["id"] . "'>
        <i class='fas fa-trash-alt'></i> <!-- Delete Icon -->
    </button>
    <button class='btn btn-primary btn-sm printBtn' data-id='" . $row["id"] . "'>
        <i class='fas fa-print'></i> <!-- Print Icon -->
    </button>
</td>";
                            echo "</tr>";
                          }
                        } else {
                          echo "<tr><td colspan='8' class='text-center'>No data available</td></tr>";
                        }
                        $conn->close();
                        ?>
                      </tbody>
                    </table>
                    <script>
        $(document).ready(function () {
            $('#applicantTable1').DataTable();
        });
    </script>

                    <script>
                      $(document).ready(function() {
                        // Initialize DataTable
                        $('#applicantTable').DataTable();

                        // Handle click on "Enter" button for remarks
                        $(document).on('click', '.enterRemarkBtn', function() {
                          var applicantId = $(this).data('id');
                          $('#applicantId').val(applicantId);
                          $('#enterRemarkModal').modal('show');
                        });

                        // Handle click on "Delete" button
                        $(document).on('click', '.deleteBtn', function() {
                          var applicantId = $(this).data('id');
                          if (confirm("Are you sure you want to delete this applicant's data?")) {
                            // Perform AJAX delete request
                            $.ajax({
                              url: 'delete_applicant.php',
                              method: 'POST',
                              data: {
                                id: applicantId
                              },
                              success: function(response) {
                                // Reload DataTable after deletion
                                $('#applicantTable1').load(location.href + " #applicantTable1");
                              }
                            });
                          }
                        });

                        // Handle click on "Print" button (to be implemented)
                        $(document).on('click', '.printBtn', function() {
                          var applicantId = $(this).data('id');
                          // Open print.php in a new tab with the applicant ID as a query parameter
                          window.open('print.php?id=' + applicantId, '_blank');
                        });


                        // Handle form submission for entering remarks
                        $('#enterRemarkForm').submit(function(e) {
                          e.preventDefault();
                          var applicantId = $('#applicantId').val();
                          var remark = $('#remark').val();

                          // Perform AJAX request to save remark
                          $.ajax({
                            url: 'save_remark.php',
                            method: 'POST',
                            data: {
                              id: applicantId,
                              remark: remark
                            },
                            dataType: 'json',
                            success: function(response) {
                              if (response.status === 'success') {
                                // Close modal and reload DataTable after saving remark
                                $('#enterRemarkModal').modal('hide');
                                //$('#applicantTable').DataTable().ajax.reload();
                                $('#applicantTable').load(location.href + " #applicantTable");
                              } else {
                                alert('Error: ' + response.message);
                              }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                              console.error('AJAX Error:', textStatus, errorThrown);
                              alert('An error occurred while saving the remark. Please try again.');
                            }
                          });
                        });
                      });
                    </script>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- tab4 -->
      

        <!-- tab5 -->
     

        <!-- tab6 -->
      

        <!-- tab7 -->
   

      </div>

    </div>

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

  <!-- Add Faculty Details -->
  <div class="modal fade" id="facultyAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><strong> Add Faculty Information</strong> </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="saveexp">
          <div class="modal-body">
            <div id="errorMessage" class="alert alert-warning d-none"></div>

            <div class="mb-3">
              <label for="facultyId" class="form-label">Faculty ID *</label>
              <input type="text" name="id" id="facultyId" class="form-control" />
            </div>

            <div class="mb-3">
              <label for="facultyName" class="form-label">Faculty Name *</label>
              <input type="text" name="name" id="facultyName" class="form-control" />
            </div>

            <div class="mb-3">
              <label for="designation" class="form-label">Designation *</label>
              <select class="form-select" name="design" id="designation">
                <option value="">Select designation</option>
                <option value="Assistant Professor">Assistant Professor</option>
                <option value="Associate Professor">Associate Professor</option>
                <option value="Professor">Professor</option>
                <option value="Lab Instructor">Lab Instructor</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="role" class="form-label">Role *</label>
              <select class="form-select" name="role" id="role">
                <option value="">Select role</option>
                <option value="Faculty">Faculty</option>
                <option value="HOD">HOD</option>
                <option value="Principal">Principal</option>
                <option value="Lab Instructor">Lab Instructor</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="department" class="form-label">Department *</label>
              <select class="form-select" name="dept" id="department">
                <option value="">Select department</option>
                <option value="Artificial Intelligence and Data Science">Artificial Intelligence and Data Science
                </option>
                <option value="Artificial Intelligence and Machine Learning">Artificial Intelligence and Machine
                  Learning</option>
                <option value="Civil Engineering">Civil Engineering</option>
                <option value="Computer Science and Business Systems">Computer Science and Business Systems</option>
                <option value="Computer Science and Engineering">Computer Science and Engineering</option>
                <option value="Electrical and Electronics Engineering">Electrical and Electronics Engineering</option>
                <option value="Electronics Engineering (VLSI Design)">Electronics Engineering (VLSI Design)</option>
                <option value="Electronics and Communication Engineering">Electronics and Communication Engineering
                </option>
                <option value="Information Technology">Information Technology</option>
                <option value="Mechanical Engineering">Mechanical Engineering</option>
                <option value="Freshman Engineering">Freshman Engineering</option>
                <option value="Master of Business Administration">Master of Business Administration</option>
                <option value="Master of Computer Applications">Master of Computer Applications</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="ddepartment" class="form-label">Deputation Department *</label>
              <select class="form-select" name="ddept" id="ddepartment">
                <option value="">Select department</option>
                <option value="Artificial Intelligence and Data Science">Artificial Intelligence and Data Science
                </option>
                <option value="Artificial Intelligence and Machine Learning">Artificial Intelligence and Machine
                  Learning</option>
                <option value="Civil Engineering">Civil Engineering</option>
                <option value="Computer Science and Business Systems">Computer Science and Business Systems</option>
                <option value="Computer Science and Engineering">Computer Science and Engineering</option>
                <option value="Electrical and Electronics Engineering">Electrical and Electronics Engineering</option>
                <option value="Electronics Engineering (VLSI Design)">Electronics Engineering (VLSI Design)</option>
                <option value="Electronics and Communication Engineering">Electronics and Communication Engineering
                </option>
                <option value="Information Technology">Information Technology</option>
                <option value="Mechanical Engineering">Mechanical Engineering</option>
                <option value="Freshman Engineering">Freshman Engineering</option>
                <option value="Master of Business Administration">Master of Business Administration</option>
                <option value="Master of Computer Applications">Master of Computer Applications</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="doj" class="form-label">Date of Joining *</label>
              <input type="date" name="doj" id="doj" class="form-control" />
            </div>

            <div class="mb-3">
              <label for="uploadFile4" class="form-label">Appointment Order * (upload less than 2 MB)</label>
              <div class="input-group">
                <input type="file" class="form-control" name="cert" id="uploadFile4" onchange="return fileValidation4()"
                  required>
              </div>
              <p class="text-danger" id="tutorial4"></p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Faculty</button>
          </div>
        </form>
      </div>
    </div>
  </div>



  <!-- Edit Faculty Model -->
  <div class="modal fade" id="studentEditModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updatefaculty">
          <div class="modal-body">
            <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

            <input type="hidden" name="student_id3" id="student_id2">

            <div class="mb-3">
              <label for="id" class="form-label">Faculty ID *</label>
              <input type="text" name="id" id="e-id" class="form-control" />
            </div>

            <div class="mb-3">
              <label for="name" class="form-label">Faculty Name *</label>
              <input type="text" name="fname" id="e-name" class="form-control" />
            </div>

            <div class="mb-3">
              <label for="design" class="form-label">Designation *</label>
              <select class="form-select" name="design" id="e-design">
                <option value="">Select designation</option>
                <option value="Assistant Professor">Assistant Professor</option>
                <option value="Associate Professor">Associate Professor</option>
                <option value="Professor">Professor</option>
                <option value="Lab Instructor">Lab Instructor</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="role" class="form-label">Role *</label>
              <select class="form-select" name="role" id="e-role">
                <option value="">Select role</option>
                <option value="Faculty">Faculty</option>
                <option value="HOD">HOD</option>
                <option value="Principal">Principal</option>
                <option value="Lab Instructor">Lab Instructor</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="dept" class="form-label">Department *</label>
              <select class="form-select" name="dept" id="e-dept">
                <option value="">Select department</option>
                <option value="Artificial Intelligence and Data Science">Artificial Intelligence and Data Science
                </option>
                <option value="Artificial Intelligence and Machine Learning">Artificial Intelligence and Machine
                  Learning</option>
                <option value="Civil Engineering">Civil Engineering</option>
                <option value="Computer Science and Business Systems">Computer Science and Business Systems</option>
                <option value="Computer Science and Engineering">Computer Science and Engineering</option>
                <option value="Electrical and Electronics Engineering">Electrical and Electronics Engineering</option>
                <option value="Electronics Engineering (VLSI Design)">Electronics Engineering (VLSI Design)</option>
                <option value="Electronics and Communication Engineering">Electronics and Communication Engineering
                </option>
                <option value="Information Technology">Information Technology</option>
                <option value="Mechanical Engineering">Mechanical Engineering</option>
                <option value="Freshman Engineering">Freshman Engineering</option>
                <option value="Master of Business Administration">Master of Business Administration</option>
                <option value="Master of Computer Applications">Master of Computer Applications</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="ddept" class="form-label">Deputation Department *</label>
              <select class="form-select" name="ddept" id="e-ddept">
                <option value="">Select department</option>
                <option value="Artificial Intelligence and Data Science">Artificial Intelligence and Data Science
                </option>
                <option value="Artificial Intelligence and Machine Learning">Artificial Intelligence and Machine
                  Learning</option>
                <option value="Civil Engineering">Civil Engineering</option>
                <option value="Computer Science and Business Systems">Computer Science and Business Systems</option>
                <option value="Computer Science and Engineering">Computer Science and Engineering</option>
                <option value="Electrical and Electronics Engineering">Electrical and Electronics Engineering</option>
                <option value="Electronics Engineering (VLSI Design)">Electronics Engineering (VLSI Design)</option>
                <option value="Electronics and Communication Engineering">Electronics and Communication Engineering
                </option>
                <option value="Information Technology">Information Technology</option>
                <option value="Mechanical Engineering">Mechanical Engineering</option>
                <option value="Freshman Engineering">Freshman Engineering</option>
                <option value="Master of Business Administration">Master of Business Administration</option>
                <option value="Master of Computer Applications">Master of Computer Applications</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="doj" class="form-label">Date of Joining *</label>
              <input type="date" name="doj" id="e-doj" class="form-control" />
            </div>
            <div class="mb-3">
              <label for="uploadFile4" class="form-label">Appointment Order * (upload less than 2 MB)</label>
              <div id="existing-file" class="mb-2 text-primary"></div>
              <input type="file" class="form-control" name="cert" id="uploadFile4">
              <small class="text-muted">Only upload if you want to change the existing file</small>
              <p class="text-danger" id="tutorial4"></p>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update Faculty</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Update Faculty Status Modal -->
  <div class="modal fade" id="remarksModal" tabindex="-1" aria-labelledby="remarksModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="remarksModalLabel">Update Faculty Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="statusUpdateForm">
            <input type="hidden" id="faculty_uid" name="faculty_uid">
            <input type="hidden" id="new_status" name="new_status">
            <div class="mb-3">
              <label for="status_remarks" class="form-label">Remarks <span class="text-danger">*</span></label>
              <textarea class="form-control" name="remarks" id="status_remarks" rows="3" required
                placeholder="Enter reason for status change"></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Update Status</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- View Certificate Modal -->
  <div class="modal fade" id="studentViewModal3" tabindex="-1" aria-labelledby="studentViewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="studentViewModalLabel">View Certificate</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <img id="image2" src="" alt="Certificate Image" class="img-fluid">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



  <!-- Footer -->
  <?php include 'footer.php'; ?>
  </div>

  <script>
    $(document).on('submit', '#saveexp', function(e) {
      e.preventDefault();

      var formData = new FormData(this);
      formData.append("save_exp", true);

      $.ajax({
        type: "POST",
        url: "fcode.php",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json", // Expect JSON response
        success: function(res) {
          if (res.status === 422) {
            Swal.fire({
              icon: 'warning',
              title: 'Validation Error',
              text: res.message
            });
          } else if (res.status === 200 || res.status === 201) {
            $('#facultyAdd').modal('hide');

            setTimeout(() => {
              $('#saveexp')[0].reset();
            }, 500);

            Swal.fire({
              icon: res.status === 200 ? 'success' : 'error',
              title: res.message,
              showConfirmButton: true // Keeping default SweetAlert layout
            });

            // Reload table content without refreshing the whole page
            $('#myTable2').load(location.href + " #myTable2");
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Unexpected Response',
              text: 'Please try again later.',
              showConfirmButton: true
            });
          }
        },
        error: function() {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred. Please check your internet connection or try again.',
            showConfirmButton: true
          });
        }
      });
    });

    $('#myTable2').DataTable();

    $(document).on('click', '.deletepcBtn', function(e) {
      e.preventDefault();

      if (confirm('Are you sure you want to delete this data?')) {
        var student_id5 = $(this).val();
        $.ajax({
          type: "POST",
          url: "fcode.php",
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

              $('#myTable2').load(location.href + " #myTable2");
            }
          }
        });
      }
    });

    $(document).on('click', '.btnimg5', function() {

      var student_id4 = $(this).val();
      console.log(student_id4);
      $.ajax({
        type: "GET",
        url: "fcode.php?student_id4=" + student_id4,
        success: function(response) {

          var res = jQuery.parseJSON(response);
          if (res.status == 404) {

            alert(res.message);
          } else if (res.status == 200) {


            $("#image2").attr("src", res.data.cert);

            $('#studentViewModal3').modal('show');
          }
        }
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



    // Edit button click handler
    $(document).on('click', '.editfamilyBtn', function() {
      var student_id2 = $(this).val();
      $.ajax({
        type: "GET",
        url: "fcode.php?student_id2=" + student_id2,
        success: function(response) {
          var res = jQuery.parseJSON(response);
          if (res.status == 404) {
            alert(res.message);
          } else if (res.status == 200) {
            $('#student_id2').val(res.data.uid);
            $('#e-id').val(res.data.id);
            $('#e-name').val(res.data.name);
            $('#e-design').val(res.data.design);
            $('#e-role').val(res.data.role);
            $('#e-dept').val(res.data.dept);
            $('#e-ddept').val(res.data.ddept);
            $('#e-doj').val(res.data.doj);

            // Add this to show the existing certificate filename
            if (res.data.cert) {
              // Show the existing filename
              $('#existing-file').text('Current file: ' + res.data.cert);
              // Make the file input optional since there's already a file
              $('#uploadFile4').prop('required', false);
            }

            $('#studentEditModal2').modal('show');
          }
        }
      });
    });
    $(document).on('submit', '#updatefaculty', function(e) {
      e.preventDefault();

      var formData = new FormData(this);
      formData.append("update_faculty", true);

      $.ajax({
        type: "POST",
        url: "fcode.php",
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
            $('#studentEditModal2').modal('hide');
            $('#updatefaculty')[0].reset();
            // Refresh your table here
            // For example:
            location.reload();
          }
        }
      });
    });

    $(document).on('click', '.status-toggle', function() {
      var uid = $(this).data('id');
      var currentStatus = $(this).data('status');
      var buttonText = $(this).text().trim();

      // Always open modal for both active and inactive status changes
      $('#faculty_uid').val(uid);

      // Set the new status based on current status
      if (currentStatus == 1) {
        $('#new_status').val(0);
        $('.modal-title').text('Deactivate Faculty');
      } else {
        $('#new_status').val(1);
        $('.modal-title').text('Activate Faculty');
      }

      // Clear previous remarks
      $('#status_remarks').val('');

      // Open the modal
      $('#remarksModal').modal('show');
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
            $('#nominee').load(location.href + " #nominee");

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

    const fromDateInput = document.getElementById('fromDate');
    const toDateInput = document.getElementById('toDate');
    const totalDaysInput = document.getElementById('totalDays');

    fromDateInput.addEventListener('change', updateTotalDays);
    toDateInput.addEventListener('change', updateTotalDays);

    function updateTotalDays() {
      const fromDate = new Date(fromDateInput.value);
      const toDate = new Date(toDateInput.value);

      const timeDifference = toDate - fromDate;
      const daysDifference = timeDifference / (1000 * 3600 * 24);
      totalDaysInput.value = daysDifference;
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





</body>

</html>