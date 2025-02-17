<?php
include("config.php");
include("session.php");

include 'update_deadline.php';

// Add new User
if (isset($_POST['save_preEventOrg_Form'])) {
    try {
        $organizer = mysqli_real_escape_string($conn, $_POST['organizer']);
        $eventname = mysqli_real_escape_string($conn, $_POST['eventname']);
        $dept = mysqli_real_escape_string($conn, $_POST['dept']);
        $academia = mysqli_real_escape_string($conn, $_POST['academia']);
        $venue = mysqli_real_escape_string($conn, $_POST['venue']);
        $starting_date = mysqli_real_escape_string($conn, $_POST['starting_date']);
        $ending_date = mysqli_real_escape_string($conn, $_POST['ending_date']);
        $total = mysqli_real_escape_string($conn, $_POST['total']);
        $chief_guest = mysqli_real_escape_string($conn, $_POST['chief_guest']);
        $event_type = mysqli_real_escape_string($conn, $_POST['event_type']);

        $other_event = NULL; // Initialize other_event

        // Check if event_type is 'Other' and set other_event accordingly
        if ($event_type === 'Other') {
            $other_event = mysqli_real_escape_string($conn, $_POST['other_event']);
            $event_type = 'Other'; // You can set event_type as 'Other' to indicate that it is a custom input
        }

        $status_no = isset($_POST['status_no']) ? mysqli_real_escape_string($conn, $_POST['status_no']) : NULL;

        // Handle PDF upload for 'about_chief_guest'
        $about_chief_guest = $_FILES['pdf1']['name'] ? mysqli_real_escape_string($conn, $_FILES['pdf1']['name']) : NULL;
        $about_chief_guest_file = NULL;

        $target_dir = "uploads/";

        if ($about_chief_guest) {
            $target_name = pathinfo($_FILES['pdf1']['name'], PATHINFO_FILENAME);
            $fileType = strtolower(pathinfo($_FILES['pdf1']['name'], PATHINFO_EXTENSION));
            $about_chief_guest_file = $target_dir . $target_name . '.' . $fileType;

            // Validate file type for 'about_chief_guest'
            if ($fileType != "pdf") {
                throw new Exception("Only PDF files are allowed for 'About Chief Guest'.");
            }

            // Upload file for 'about_chief_guest'
            if (!move_uploaded_file($_FILES["pdf1"]["tmp_name"], $about_chief_guest_file)) {
                throw new Exception("File upload failed for 'About Chief Guest'.");
            }
        }

        // Handle PDF upload for 'fund_details' if provided
        $fund_details = NULL;
        if (!empty($_FILES['pdf2']['name'])) {
            $fund_target_name = pathinfo($_FILES['pdf2']['name'], PATHINFO_FILENAME);
            $fund_fileType = strtolower(pathinfo($_FILES['pdf2']['name'], PATHINFO_EXTENSION));
            $fund_target_file = $target_dir . $fund_target_name . '.' . $fund_fileType;

            // Validate file type for 'fund_details'
            if ($fund_fileType != "pdf") {
                throw new Exception("Only PDF files are allowed for 'Fund Details'.");
            }

            // Upload file for 'fund_details'
            if (!move_uploaded_file($_FILES["pdf2"]["tmp_name"], $fund_target_file)) {
                throw new Exception("File upload failed for 'Fund Details'.");
            }

            $fund_details = $fund_target_file; // Store the file path if uploaded
        }

        // Handle PDF upload for 'brochure'
        $brochure = $_FILES['pdf3']['name'] ? mysqli_real_escape_string($conn, $_FILES['pdf3']['name']) : NULL;
        $brochure_file = NULL;

        if ($brochure) {
            $target_name = pathinfo($_FILES['pdf3']['name'], PATHINFO_FILENAME);
            $fileType = strtolower(pathinfo($_FILES['pdf3']['name'], PATHINFO_EXTENSION));
            $brochure_file = $target_dir . $target_name . '.' . $fileType;

            // Validate file type for 'brochure'
            if ($fileType != "pdf") {
                throw new Exception("Only PDF files are allowed for 'Brochure'.");
            }

            // Upload file for 'brochure'
            if (!move_uploaded_file($_FILES["pdf3"]["tmp_name"], $brochure_file)) {
                throw new Exception("File upload failed for 'Brochure'.");
            }
        }
        $designation = mysqli_real_escape_string($conn, $_POST['designation']);
        // Insert data into the database
        $query = "INSERT INTO user (organizer, eventname, dept, academia, venue, starting_date, ending_date, total, chief_guest, about_chief_guest, fund_details, brochure, status_no,designation,event_type,other_event)
                  VALUES ('$organizer', '$eventname', '$dept', '$academia', '$venue', '$starting_date', '$ending_date', '$total', '$chief_guest', '$about_chief_guest_file', '$fund_details', '$brochure_file', '$status_no','$designation','$event_type','$other_event')";

        if (!mysqli_query($conn, $query)) {
            throw new Exception('Query Failed: ' . mysqli_error($conn));
        }
 
        $res = [
            'status' => 200,
            'message' => 'Details Updated Successfully'
        ];
        echo json_encode($res);
    } catch (Exception $e) {
        $res = [
            'status' => 500,
            'message' => 'Error: ' . $e->getMessage()
        ];
        echo json_encode($res);
    }
}
