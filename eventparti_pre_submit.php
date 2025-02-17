<?php 
include("config.php");
include("session.php");
header('Content-Type: application/json');
ob_start();
$response = array('status' => '', 'message' => '', 'download_link' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staff_name = $_POST['staff_name'];
    $designation = $_POST['designation'];
    $department = $_POST['department'];
    $event_type = $_POST['event_type'];
    $event_name = $_POST['event_name'];
    $organizer_name = $_POST['organizer_name'];
    $academic_year = $_POST['academic_year'];
    $venue = $_POST['venue'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $no_of_days = $_POST['no_of_days'];
    //$status2="forwarded to HOD";

    

    // File upload handling
    $uploadDir = 'uploads/';
    $fileName = basename($_FILES['event_broucher']['name']);
    $filePath = $uploadDir . $fileName;

    // Ensure the upload directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($_FILES['event_broucher']['tmp_name'], $filePath)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO pre_event_form (staff_name, designation, department, academic_year, event_type, event_name, organizer_name, venue, start_date, end_date, event_broucher, no_of_days) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssi", $staff_name, $designation, $department, $academic_year, $event_type, $event_name, $organizer_name, $venue, $start_date, $end_date, $filePath, $no_of_days);

        if ($stmt->execute()) {
           // echo json_encode(array("status" => "success", "message" => "saved successfully"));

            $response['status'] = 'success';
            $response['message'] = 'Pre event added successfully!';
        } else {
           // echo json_encode(array("status" => "error", "message" => "Error: " . $conn->error));

            $response['status'] = 'error';
            $response['message'] = 'Error: ' . $conn->error;
          
        }

        $stmt->close();
    } else {
        

            $response['status'] = 'error';
            $response['message'] = 'Failed to upload file ' . $conn->error;
    }

    echo json_encode($response);
    $conn->close();
}
?>
