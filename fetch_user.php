<?php
// Database connection
include("config.php");
include("session.php");

// Get the status_no and tab from the POST request
$status_no = isset($_POST['status_no']) ? intval($_POST['status_no']) : 0;
$tab = isset($_POST['tab']) ? $_POST['tab'] : '';

switch ($tab) {
        case 'journal':
                $sql = "SELECT * FROM journal_papers WHERE status_no = ?";
                break;
        case 'conference':
                $sql = "SELECT * FROM conference_papers WHERE status_no = ?";
                break;
        case 'book':
                $sql = "SELECT * FROM book WHERE status_no = ?";
                break;



        case 'patent':
                $sql = "SELECT * FROM patents WHERE status_no = ?";
                break;
        case 'copyright':
                $sql = "SELECT * FROM copyrights WHERE status_no = ?";
                break;
        case 'projects':
                $sql = "SELECT * FROM projects WHERE status_no = ?";
                break;
        case 'project_guidance':
                $sql = "SELECT * FROM project_guidance WHERE status_no = ?";
                break;
        case 'consultancy':
                $sql = "SELECT * FROM consultancy WHERE status1 = ?";
                break;
        case 'iconsultancy':
                $sql = "SELECT * FROM industry_consultancy WHERE istatus1 = ?";
                break;
        case 'r_guideship':
                $sql = "SELECT * FROM researchguideship WHERE status_no = ?";
                break;
        case 'r_guidance':
                $sql = "SELECT * FROM research_guidance WHERE status_no = ?";
                break;
        case 'certification':
                $sql = "SELECT * FROM certifications WHERE status = ?";
                break;
        default:
                // Return an error if the tab is invalid
                echo json_encode(['error' => 'Invalid tab specified']);
                exit;
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $status_no);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all results
$data = [];
while ($row = $result->fetch_assoc()) {
        $data[] = $row;
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode(['data' => $data]);

// Close the statement and connection
$stmt->close();
$conn->close();
