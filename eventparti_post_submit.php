<?php
include("../db.php"); // Include your database connection
header('Content-Type: application/json');
require_once('vendor/autoload.php');

use Clegginabox\PDFMerger\PDFMerger;

$response = array('status' => '', 'message' => '', 'download_link' => '');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
   

    
    $uploadDir = 'uploads/';
    $uploadedFiles = array();
    $mergedFileName = $uploadDir . 'merged_' . time() . '.pdf';


    // Ensure the upload directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $id = $_POST['id'];
   
    
    $status = 4;
    
    // Process each uploaded PDF file
    foreach ($_FILES['pdfs']['tmp_name'] as $index => $tmpName) {
        if ($tmpName) {
            $fileName = basename($_FILES['pdfs']['name'][$index]);
            $filePath = $uploadDir . $fileName;

            // Move the uploaded file to the upload directory
            if (move_uploaded_file($tmpName, $filePath)) {
                $uploadedFiles[] = $filePath;
            } else {
                $response['message'] = "Failed to move uploaded file: " . $fileName;
                echo json_encode($response);
                exit;
            }
        }
    }

    if (!empty($uploadedFiles)) {
        $pdfMerger = new PDFMerger();

        foreach ($uploadedFiles as $file) {
            $pdfMerger->addPDF($file);
        }

        // Save the merged PDF to a file
        $pdfMerger->merge('file', $mergedFileName);

        // Delete the original uploaded files
        foreach ($uploadedFiles as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }

    

    // Prepare to insert or update the file paths into the `pre_event_form` table
    $sql = "UPDATE `pre_event_form` SET 
                `merged_pdf`=?,                
                `status`=? 
            WHERE `s_no`=?";
    $stmt = $conn->prepare($sql);

    // Assign the file paths for each PDF
    $approvedCopy = isset($uploadedFiles[0]) ? $uploadedFiles[0] : '';
    $eventProof = isset($uploadedFiles[1]) ? $uploadedFiles[1] : '';
    $participationCertificate = isset($uploadedFiles[2]) ? $uploadedFiles[2] : '';
    $claimForm = isset($uploadedFiles[3]) ? $uploadedFiles[3] : '';
    $reportSummary = isset($uploadedFiles[4]) ? $uploadedFiles[4] : '';
    $kss_reportSummary = isset($uploadedFiles[5]) ? $uploadedFiles[5] : '';
   
   
    // Replace with the actual `s_no` value (you should retrieve this dynamically as needed)
    $sno = 5; // Example value, replace it with actual value

    $stmt->bind_param("sii",  $mergedFileName, $status, $id);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = "Files uploaded and database updated successfully!";
    } else {
        $response['message'] = "Database update failed: " . $stmt->error;
    }
    }


} 
else {
    $response['message'] = "No files were uploaded.";
}

echo json_encode($response);

?>
