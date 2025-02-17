<?php
include("config.php");
include("session.php");// Replace with your database connection file


$response = ['status' => false, 'message' => ''];



$action = $_GET['action'] ?? ($_POST['action'] ?? '');
$doi='';
$author_position='';
if (empty($action)) {
    $jsonInput = file_get_contents('php://input');
    if (!empty($jsonInput)) {
        $jsonData = json_decode($jsonInput, true);
        $action = $jsonData['action'] ?? '';

		 $doi=$jsonData['doi']?? '';
         $author_position=$jsonData['authorPosition']??'';
                      
		
    }
}

switch ($action) {

    case 'conference_details':
        if (!isset($_POST['id'])) {
            echo json_encode(['status' => false, 'message' => 'Invalid request. ID is missing.']);
            exit();
        }

        // Sanitize and validate ID
        $id = $_POST['id'];
        if (!is_numeric($id)) {
            echo json_encode(['status' => false, 'message' => 'Invalid ID format.']);
            exit();
        }

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM conference_papers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $details = '
            <table class="table table-bordered">
                <tr><th>Staff ID</th><td>' . htmlspecialchars($row['staff_id']) . '</td></tr>
                <tr><th>Staff Name</th><td>' . htmlspecialchars($row['staff_name']) . '</td></tr>
               
                <tr><th>Department</th><td>' . htmlspecialchars($row['department']) . '</td></tr>
                <tr><th>Academic Year</th><td>' . htmlspecialchars($row['academic_year']) . '</td></tr>
                <tr><th>Paper Title</th><td>' . htmlspecialchars($row['title_of_paper']) . '</td></tr>
                <tr><th>Conference Title</th><td>' . htmlspecialchars($row['conference_title']) . '</td></tr>
                <tr><th>Organizer</th><td>' . htmlspecialchars($row['organizer']) . '</td></tr>
                <tr><th>Sponsor Name</th><td>' . htmlspecialchars($row['sponsor_name']) . '</td></tr>
                <tr><th>Publisher Name</th><td>' . htmlspecialchars($row['publisher_name']) . '</td></tr>
                <tr><th>Indexing Details</th><td>' . htmlspecialchars($row['indexing_details']) . '</td></tr>
                <tr><th>Level</th><td>' . htmlspecialchars($row['level']) . '</td></tr>
                <tr><th>Location</th><td>' . htmlspecialchars($row['location']) . '</td></tr>
                <tr><th>State</th><td>' . htmlspecialchars($row['state']) . '</td></tr>
                <tr><th>Country</th><td>' . htmlspecialchars($row['country']) . '</td></tr>
                <tr><th>From Date</th><td>' . htmlspecialchars($row['from_date']) . '</td></tr>
                <tr><th>To Date</th><td>' . htmlspecialchars($row['to_date']) . '</td></tr>
               
                <tr><th>Number of Authors</th><td>' . htmlspecialchars($row['number_of_authors']) . '</td></tr>
                <tr><th>eISBN</th><td>' . htmlspecialchars($row['eisbn']) . '</td></tr>
                <tr><th>pISBN</th><td>' . htmlspecialchars($row['pisbn']) . '</td></tr>
                <tr><th>DOI</th><td>' . htmlspecialchars($row['doi']) . '</td></tr>
                <tr><th>Link</th><td><a href="' . htmlspecialchars($row['link']) . '" target="_blank">' . htmlspecialchars($row['link']) . '</a></td></tr>
                <tr><th>Remarks</th><td>' . htmlspecialchars($row['remarks']) . '</td></tr>
            </table>
        ';



            // Return the details in JSON format, including the HTML table
            echo  $details;
        } else {
            echo '<table class="table"><tr><td colspan="2">No records found.</td></tr></table>';
        }

        $stmt->close();
        break;


    case 'journal_details':
        if (!isset($_POST['id'])) {
            echo json_encode(['status' => false, 'message' => 'Invalid request. ID is missing.']);
            exit();
        }

        // Sanitize and validate ID
        $id = $_POST['id'];
        if (!is_numeric($id)) {
            echo json_encode(['status' => false, 'message' => 'Invalid ID format.']);
            exit();
        }

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM journal_papers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Manually create the HTML table with specific fields
            $details = '
                <table class="table table-bordered">
                    <tr><th>Staff ID</th><td>' . htmlspecialchars($row['staff_id']) . '</td></tr>
                    <tr><th>Staff Name</th><td>' . htmlspecialchars($row['staff_name']) . '</td></tr>                
                    <tr><th>Department</th><td>' . htmlspecialchars($row['department']) . '</td></tr>
                    <tr><th>Academic Year</th><td>' . htmlspecialchars($row['academic_year']) . '</td></tr>
                    <tr><th>Indexing Type</th><td>' . htmlspecialchars($row['indexing_type']) . '</td></tr>
                    <tr><th>Journal Name</th><td>' . htmlspecialchars($row['journal_name']) . '</td></tr>
                    <tr><th>Scopus ID</th><td>' . htmlspecialchars($row['scopus_id']) . '</td></tr>
                    <tr><th>Publisher Name</th><td>' . htmlspecialchars($row['j_publisher_name']) . '</td></tr>
                    <tr><th>Journal Status</th><td>' . htmlspecialchars($row['journal_status']) . '</td></tr>
                    <tr><th>Impact Factor</th><td>' . htmlspecialchars($row['impact_factor']) . '</td></tr>
                    <tr><th>E-ISSN</th><td>' . htmlspecialchars($row['eissn']) . '</td></tr>
                    <tr><th>Country</th><td>' . htmlspecialchars($row['j_country']) . '</td></tr>
                    <tr><th>Level</th><td>' . htmlspecialchars($row['j_level']) . '</td></tr>                   
                    <tr><th>Paper Title</th><td>' . htmlspecialchars($row['j_paper_title']) . '</td></tr>
                    <tr><th>Month & Year</th><td>' . htmlspecialchars($row['month_year']) . '</td></tr>
                    <tr><th>Number of Authors</th><td>' . htmlspecialchars($row['j_authors_count']) . '</td></tr>
                    <tr><th>Volume</th><td>' . htmlspecialchars($row['volume']) . '</td></tr>
                    <tr><th>Issue/Number</th><td>' . htmlspecialchars($row['issue']) . '</td></tr>
                    <tr><th>Page</th><td>' . htmlspecialchars($row['page']) . '</td></tr>
                    <tr><th>Journal Link</th><td><a href="' . htmlspecialchars($row['journal_link']) . '" target="_blank">' . htmlspecialchars($row['journal_link']) . '</a></td></tr>
                    <tr><th>DOI Number</th><td><a href="' . htmlspecialchars($row['doi_number']) . '" target="_blank">' . htmlspecialchars($row['doi_number']) . '</a></td></tr>
                    <tr><th>Author\'s Position</th><td>' . htmlspecialchars($row['author_position']) . '</td></tr>
                    <tr><th>Remarks</th><td>' . htmlspecialchars($row['j_remarks']) . '</td></tr>
                </table>';

            // Return the details in HTML format
            echo $details;
        } else {
            echo '<table class="table"><tr><td colspan="2">No records found.</td></tr></table>';
        }

        $stmt->close();
        break;

    case 'book_details':
            if (!isset($_POST['id'])) {
                echo json_encode(['status' => false, 'message' => 'Invalid request. ID is missing.']);
                exit();
            }
    
            // Sanitize and validate ID
            $id = $_POST['id'];
            if (!is_numeric($id)) {
                echo json_encode(['status' => false, 'message' => 'Invalid ID format.']);
                exit();
            }
    
            // Use prepared statement to prevent SQL injection
            $stmt = $conn->prepare("SELECT * FROM book WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
    
                // Manually create the HTML table with specific fields
                $details = '
                    <table class="table table-bordered">
                        <tr><th>Staff ID</th><td>' . htmlspecialchars($row['staff_id']) . '</td></tr>
                        <tr><th>Staff Name</th><td>' . htmlspecialchars($row['staff_name']) . '</td></tr>
                    
                        <tr><th>Department</th><td>' . htmlspecialchars($row['department']) . '</td></tr>
                        <tr><th>Academic Year</th><td>' . htmlspecialchars($row['academic_year']) . '</td></tr>
                        <tr><th>Category </th><td>' . htmlspecialchars($row['book_category']) . '</td></tr>
                        <tr><th>Book Title</th><td>' . htmlspecialchars($row['book_title']) . '</td></tr>
                        <tr><th>Chapter Title</th><td>' . htmlspecialchars($row['chapter_title']) . '</td></tr>
                        <tr><th>Publisher</th><td>' . htmlspecialchars($row['publisher']) . '</td></tr>                        
                        <tr><th>E-ISBN</th><td>' . htmlspecialchars($row['e_isbn']) . '</td></tr>
                        <tr><th>P-ISBN</th><td>' . htmlspecialchars($row['p_isbn']) . '</td></tr>
                        
                        <tr><th>Month & Year</th><td>' . htmlspecialchars($row['published_month_year']) . '</td></tr>
                        <tr><th>Number of Authors</th><td>' . htmlspecialchars($row['no_of_authors']) . '</td></tr>
                        <tr><th>Volume</th><td>' . htmlspecialchars($row['volume']) . '</td></tr>
                        <tr><th>Edition</th><td>' . htmlspecialchars($row['edition']) . '</td></tr>                      
                        <tr><th>Link</th><td><a href="' . htmlspecialchars($row['link']) . '" target="_blank">' . htmlspecialchars($row['link']) . '</a></td></tr>                       
                        <tr><th>Author\'s Position</th><td>' . htmlspecialchars($row['author_position']) . '</td></tr>
                        <tr><th>Remarks</th><td>' . htmlspecialchars($row['b_remarks']) . '</td></tr>
                    </table>';
    
                // Return the details in HTML format
                echo $details;
            } else {
                echo '<table class="table"><tr><td colspan="2">No records found.</td></tr></table>';
            }
    
            $stmt->close();
            break;
    

    case 'patent_details':
        if (!isset($_POST['id'])) {
            echo json_encode(['status' => false, 'message' => 'Invalid request. ID is missing.']);
            exit();
        }

        // Sanitize and validate ID
        $id = $_POST['id'];
        if (!is_numeric($id)) {
            echo json_encode(['status' => false, 'message' => 'Invalid ID format.']);
            exit();
        }

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM patents WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Manually create the HTML table with specific fields
            $details = '
                    <table class="table table-bordered">
                        <tr><th>Staff ID</th><td>' . htmlspecialchars($row['staff_id']) . '</td></tr>
                        <tr><th>Staff Name</th><td>' . htmlspecialchars($row['staff_name']) . '</td></tr>
                       
                        <tr><th>Patent Title</th><td>' . htmlspecialchars($row['patent_title']) . '</td></tr>
                        <tr><th>Field of Innovation</th><td>' . htmlspecialchars($row['field_of_innovation']) . '</td></tr>
                        <tr><th>Particulars</th><td>' . htmlspecialchars($row['patent_particulars']) . '</td></tr>
                        <tr><th>Category</th><td>' . htmlspecialchars($row['patent_category']) . '</td></tr>
                        <tr><th>Filing Country</th><td>' . htmlspecialchars($row['patent_country']) . '</td></tr>
                        <tr><th>Filing Date</th><td>' . htmlspecialchars($row['patent_date']) . '</td></tr>
                        <tr><th>Application Number</th><td>' . htmlspecialchars($row['application_number']) . '</td></tr>
                        <tr><th>Status</th><td>' . htmlspecialchars($row['patent_status']) . '</td></tr>
                    ';

            // Conditionally Add Rows Based on Status
            if ($row['patent_status'] === 'Provisional Registration' || $row['patent_status'] === 'Complete Registration') {
                $details .= '<tr><th>Number of Authors</th><td>' . htmlspecialchars($row['number_of_authors']) . '</td></tr>';
            } elseif (in_array($row['patent_status'], ['Published', 'Examination Process', 'Granted'])) {
                $details .= '
                            <tr><th>Number of Authors</th><td>' . htmlspecialchars($row['number_of_authors']) . '</td></tr>
                            <tr><th>Published Date</th><td>' . htmlspecialchars($row['published_date']) . '</td></tr>
                            <tr><th>Availability Date</th><td>' . htmlspecialchars($row['availability_date']) . '</td></tr>
                            <tr><th>Valid Upto</th><td>' . htmlspecialchars($row['valid_upto']) . '</td></tr>
                            <tr><th>Journal Number</th><td>' . htmlspecialchars($row['journal_number']) . '</td></tr>
                        ';
                if ($row['patent_status'] === 'Granted') {
                    $details .= '<tr><th>Patent Number</th><td>' . htmlspecialchars($row['patent_number']) . '</td></tr>';
                }
            } elseif ($row['patent_status'] === 'Rejected') {
                $details .= '
                            <tr><th>Number of Authors</th><td>' . htmlspecialchars($row['number_of_authors']) . '</td></tr>
                            <tr><th>Remarks</th><td>' . htmlspecialchars($row['remarks']) . '</td></tr>
                        ';
            }

            // Close the table tag
            $details .= '</table>';

            // Return the details in HTML format
            echo $details;
        } else {
            echo '<table class="table"><tr><td colspan="2">No records found.</td></tr></table>';
        }

        $stmt->close();
        break;

    case 'copyright_details':
            if (!isset($_POST['id'])) {
                echo json_encode(['status' => false, 'message' => 'Invalid request. ID is missing.']);
                exit();
            }
    
            // Sanitize and validate ID
            $id = $_POST['id'];
            if (!is_numeric($id)) {
                echo json_encode(['status' => false, 'message' => 'Invalid ID format.']);
                exit();
            }
    
            // Use prepared statement to prevent SQL injection
            $stmt = $conn->prepare("SELECT * FROM copyrights WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
    
                // Manually create the HTML table with specific fields
                $details = '
                            <table class="table table-bordered">
                                <tr><th>Staff ID</th><td>' . htmlspecialchars($row['staff_id']) . '</td></tr>
                                <tr><th>Staff Name</th><td>' . htmlspecialchars($row['staff_name']) . '</td></tr>
                                
                                <tr><th>Copyright Title</th><td>' . htmlspecialchars($row['copy_title']) . '</td></tr>
                                <tr><th>Field of Innovation</th><td>' . htmlspecialchars($row['field_of_innovation']) . '</td></tr>
                                <tr><th>Particulars</th><td>' . htmlspecialchars($row['copy_particulars']) . '</td></tr>
                                <tr><th>Category</th><td>' . htmlspecialchars($row['copy_category']) . '</td></tr>
                                <tr><th>Filing Country</th><td>' . htmlspecialchars($row['copy_country']) . '</td></tr>
                                <tr><th>Filing Date</th><td>' . htmlspecialchars($row['copy_date']) . '</td></tr>
                                <tr><th>Application Number</th><td>' . htmlspecialchars($row['application_number']) . '</td></tr>
                                <tr><th>Status</th><td>' . htmlspecialchars($row['copy_status']) . '</td></tr>
                            ';
    
                // Conditionally Add Rows Based on Status
                if ($row['copy_status'] === 'Provisional Registration' || $row['copy_status'] === 'Complete Registration') {
                    $details .= '<tr><th>Number of Authors</th><td>' . htmlspecialchars($row['number_of_authors']) . '</td></tr>';
                } elseif (in_array($row['copy_status'], ['Published', 'Examination Process', 'Granted'])) {
                    $details .= '
                                    <tr><th>Number of Authors</th><td>' . htmlspecialchars($row['number_of_authors']) . '</td></tr>
                                    <tr><th>Published Date</th><td>' . htmlspecialchars($row['published_date']) . '</td></tr>
                                    <tr><th>Availability Date</th><td>' . htmlspecialchars($row['availability_date']) . '</td></tr>
                                    <tr><th>Valid Upto</th><td>' . htmlspecialchars($row['valid_upto']) . '</td></tr>
                                    <tr><th>Journal Number</th><td>' . htmlspecialchars($row['journal_number']) . '</td></tr>
                                ';
                    if ($row['copy_status'] === 'Granted') {
                        $details .= '<tr><th>Copyright Number</th><td>' . htmlspecialchars($row['copy_number']) . '</td></tr>';
                    }
                } elseif ($row['copy_status'] === 'Rejected') {
                    $details .= '
                                    <tr><th>Number of Authors</th><td>' . htmlspecialchars($row['number_of_authors']) . '</td></tr>
                                    <tr><th>Remarks</th><td>' . htmlspecialchars($row['remarks']) . '</td></tr>
                                ';
                }
    
                // Close the table tag
                $details .= '</table>';
    
                // Return the details in HTML format
                echo $details;
            } else {
                echo '<table class="table"><tr><td colspan="2">No records found.</td></tr></table>';
            }
    
            $stmt->close();
            break;

   
        case 'project_details':
                if (!isset($_POST['id'])) {
                    echo json_encode(['status' => false, 'message' => 'Invalid request. ID is missing.']);
                    exit();
                }
        
                // Sanitize and validate ID
                $id = $_POST['id'];
                if (!is_numeric($id)) {
                    echo json_encode(['status' => false, 'message' => 'Invalid ID format.']);
                    exit();
                }
        
                // Use prepared statement to prevent SQL injection
                $stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
        
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
        
                    // Manually create the HTML table with specific fields
                    $details = '
                                <table class="table table-bordered">
                                    <tr><th>Staff ID</th><td>' . htmlspecialchars($row['staff_id']) . '</td></tr>
                                    <tr><th>Staff Name</th><td>' . htmlspecialchars($row['staff_name']) . '</td></tr>
                                    <tr><th>Project Title</th><td>' . htmlspecialchars($row['title']) . '</td></tr>
                                    <tr><th>Reasearch Type</th><td>' . htmlspecialchars($row['research_type']) . '</td></tr>
                                    <tr><th>Department</th><td>' . htmlspecialchars($row['department']) . '</td></tr>
                                    <tr><th>Academic Year</th><td>' . htmlspecialchars($row['academic_year']) . '</td></tr>
                                    <tr><th>No. of Members</th><td>' . htmlspecialchars($row['members']) . '</td></tr>
                                    <tr><th>Project Domain</th><td>' . htmlspecialchars($row['domain']) . '</td></tr>
                                    <tr><th>Project Disciplinary</th><td>' . htmlspecialchars($row['disciplinary']) . '</td></tr>
                                    <tr><th>Project Type </th><td>' . htmlspecialchars($row['type']) . '</td></tr>
                                    <tr><th>Project Link</th><td>' . htmlspecialchars($row['link']) . '</td></tr>
                                    <tr><th>Remarks</th><td>' . htmlspecialchars($row['remarks']) . '</td></tr>
                                ';
                    // Close the table tag
                    $details .= '</table>';
        
                    // Return the details in HTML format
                    echo $details;
                } else {
                    echo '<table class="table"><tr><td colspan="2">No records found.</td></tr></table>';
                }
        
                $stmt->close();
        break;

        case 'project_guidance_details':
            if (!isset($_POST['id'])) {
                echo json_encode(['status' => false, 'message' => 'Invalid request. ID is missing.']);
                exit();
            }
    
            // Sanitize and validate ID
            $id = $_POST['id'];
            if (!is_numeric($id)) {
                echo json_encode(['status' => false, 'message' => 'Invalid ID format.']);
                exit();
            }
    
            // Use prepared statement to fetch research guidance details
            $stmt_guidance = $conn->prepare("SELECT * FROM project_guidance WHERE id = ?");
            $stmt_guidance->bind_param("i", $id);
            $stmt_guidance->execute();
            $result_guidance = $stmt_guidance->get_result();
    
            if ($result_guidance && $result_guidance->num_rows > 0) {
                $guidance_row = $result_guidance->fetch_assoc();
    
                // Generate the HTML for Research Guidance Details
                $details = '
                        <div class="card mb-3">
                            <div class="card-header"><strong>Project Guidance Details</strong></div>
                            <div class="card-body">
                                <p><strong>Staff Id:</strong> ' . htmlspecialchars($guidance_row['staff_id']) . '</p>
                                <p><strong>Staff Name:</strong> ' . htmlspecialchars($guidance_row['staff_name']) . '</p>
                                <p><strong>Number of Teams:</strong> ' . htmlspecialchars($guidance_row['no_of_teams']) . '</p>
                            </div>
                        </div>';
    
                // Use prepared statement to fetch scholar details
                $stmt_teams = $conn->prepare("SELECT * FROM project_team_details WHERE pguidance_id = ?");
                $stmt_teams->bind_param("i", $id);
                $stmt_teams->execute();
                $result_teams = $stmt_teams->get_result();
    
                if ($result_teams && $result_teams->num_rows > 0) {
                    $details .= '<div class="card mb-3">
                            <div class="card-header"><strong>Scholar Details</strong></div>
                        </div>';
    
                    while ($teams_row = $result_teams->fetch_assoc()) {
                        $details .= '
                                <table class="table table-bordered">
                                    <tr><th>Project Title</th><td>' . htmlspecialchars($teams_row['project_title']) . '</td></tr>
                                    <tr><th>Project Batch</th><td>' . htmlspecialchars($teams_row['project_batch']) . '</td></tr>
                                    <tr><th>Department</th><td>' . htmlspecialchars($teams_row['project_department']) . '</td></tr>
                                    <tr><th>Academic Year</th><td>' . htmlspecialchars($teams_row['project_academic_year']) . '</td></tr>
                                    <tr><th>Domain</th><td>' . htmlspecialchars($teams_row['domain']) . '</td></tr>
                                    <tr><th>Disciplinary</th><td>' . htmlspecialchars($teams_row['disciplinary']) . '</td></tr>
                                    <tr><th>Date</th><td>' . htmlspecialchars($teams_row['project_date']) . '</td></tr>
                                    <tr><th>Team Members</th><td>' . htmlspecialchars($teams_row['team_members']) . '</td></tr>
                                    
                                 
                                </table>';
                    }
                } else {
                    $details .= '<p>No team details found for this project guidance.</p>';
                }
    
                // Return the complete details
                echo $details;
            } else {
                echo '<p>No details found for the selected research guidance.</p>';
            }
    
            // Close prepared statements
            $stmt_guidance->close();
            if (isset($stmt_scholars)) {
                $stmt_scholars->close();
            }
            break;
    

   
        case 'consultancy_viewdetails':
        if (!isset($_POST['id'])) {
            echo json_encode(['status' => false, 'message' => 'Invalid request. ID is missing.']);
            exit();
        }

        // Sanitize and validate ID
        $id = $_POST['id'];
        if (!is_numeric($id)) {
            echo json_encode(['status' => false, 'message' => 'Invalid ID format.']);
            exit();
        }

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM consultancy WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Manually create the HTML table with specific fields
            $details = '
                        <table class="table table-bordered">
                            <tr><th>Consultancy Type</th><td>' . (!empty($row['consultancy_type']) ? htmlspecialchars($row['consultancy_type']) : 'Nil') . '</td></tr>
                            <tr><th>Title</th><td>' . (!empty($row['title']) ? htmlspecialchars($row['title']) : 'Nil') . '</td></tr>
                            <tr><th>Project ID</th><td>' . (!empty($row['project_id']) ? htmlspecialchars($row['project_id']) : 'Nil') . '</td></tr>
                            <tr><th>Funding Agency</th><td>' . (!empty($row['funding_agency']) ? htmlspecialchars($row['funding_agency']) : 'Nil') . '</td></tr>
                            <tr><th>Project Particulars</th><td>' . (!empty($row['project_particulars']) ? htmlspecialchars($row['project_particulars']) : 'Nil') . '</td></tr>
                            <tr><th>Web Link</th><td>' . (!empty($row['web_link']) ? '<a href="' . htmlspecialchars($row['web_link']) . '" target="_blank">' . htmlspecialchars($row['web_link']) . '</a>' : 'Nil') . '</td></tr>
                            <tr><th>Requested Amount</th><td>' . (!empty($row['requested_amount']) ? htmlspecialchars($row['requested_amount']) : 'Nil') . '</td></tr>
                            <tr><th>Status</th><td>' . (!empty($row['status']) ? htmlspecialchars($row['status']) : 'Nil') . '</td></tr>
                            <tr><th>Number of Members</th><td>' . (!empty($row['number_of_members']) ? htmlspecialchars($row['number_of_members']) : 'Nil') . '</td></tr>
                            <tr><th>Filing Date</th><td>' . (!empty($row['filing_date']) ? htmlspecialchars($row['filing_date']) : 'Nil') . '</td></tr>
                            <tr><th>Granted Amount</th><td>' . (!empty($row['granted_amount']) ? htmlspecialchars($row['granted_amount']) : 'Nil') . '</td></tr>
                            <tr><th>Granted Member</th><td>' . (!empty($row['granted_member']) ? htmlspecialchars($row['granted_member']) : 'Nil') . '</td></tr>
                            <tr><th>From</th><td>' . (!empty($row['from']) ? htmlspecialchars($row['from']) : 'Nil') . '</td></tr>
                            <tr><th>To</th><td>' . (!empty($row['to']) ? htmlspecialchars($row['to']) : 'Nil') . '</td></tr>
                            <tr><th>Funds Generated</th><td>' . (!empty($row['funds_generated']) ? htmlspecialchars($row['funds_generated']) : 'Nil') . '</td></tr>
                            <tr><th>Remarks</th><td>' . (!empty($row['remarks']) ? htmlspecialchars($row['remarks']) : 'Nil') . '</td></tr>
                        </table>';

            // Return the details in HTML format
            echo $details;
        } else {
            echo '<table class="table"><tr><td colspan="2">No records found.</td></tr></table>';
        }

        $stmt->close();
        break;



    case 'iconsultancy_viewdetails1':
        if (!isset($_POST['id'])) {
            echo json_encode(['status' => false, 'message' => 'Invalid request. ID is missing.']);
            exit();
        }

        // Sanitize and validate ID
        $id = $_POST['id'];
        if (!is_numeric($id)) {
            echo json_encode(['status' => false, 'message' => 'Invalid ID format.']);
            exit();
        }

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM industry_consultancy WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Manually create the HTML table with specific fields
            $details = '
                            <table class="table table-bordered">
                                <tr><th>Consultancy Type</th><td>' . (!empty($row['iconsultancy_type']) ? htmlspecialchars($row['iconsultancy_type']) : 'Nil') . '</td></tr>
                                <tr><th>Consultancy Title</th><td>' . (!empty($row['iconsultancy_title']) ? htmlspecialchars($row['iconsultancy_title']) : 'Nil') . '</td></tr>
                                <tr><th>Particulars</th><td>' . (!empty($row['iconsultancy_particulars']) ? htmlspecialchars($row['iconsultancy_particulars']) : 'Nil') . '</td></tr>
                                <tr><th>Particulars of Work</th><td>' . (!empty($row['iconsultancy_particulars_work']) ? htmlspecialchars($row['iconsultancy_particulars_work']) : 'Nil') . '</td></tr>
                                <tr><th>Web Link</th><td>' . (!empty($row['iconsultancy_web_link'])
                ? '<a href="' . htmlspecialchars($row['iconsultancy_web_link']) . '" target="_blank">' . htmlspecialchars($row['iconsultancy_web_link']) . '</a>'
                : 'Nil') . '</td></tr>
                                <tr><th>MOU</th><td>' . (!empty($row['iconsultancy_mou']) ? htmlspecialchars($row['iconsultancy_mou']) : 'Nil') . '</td></tr>
                                <tr><th>Author Count</th><td>' . (!empty($row['iconsultancy_author_count']) ? htmlspecialchars($row['iconsultancy_author_count']) : 'Nil') . '</td></tr>
                                 <tr><th>Requested Amount</th><td>' . (!empty($row['iconsultancy_requested_amount']) ? htmlspecialchars($row['iconsultancy_requested_amount']) : 'Nil') . '</td></tr>
                            <tr><th>Status</th><td>' . (!empty($row['iconsultancy_status']) ? htmlspecialchars($row['iconsultancy_status']) : 'Nil') . '</td></tr>
                         
                            <tr><th>Filing Date</th><td>' . (!empty($row['iconsultancy_filing_date']) ? htmlspecialchars($row['iconsultancy_filing_date']) : 'Nil') . '</td></tr>
                            <tr><th>Granted Amount</th><td>' . (!empty($row['iconsultancy_granted_amount']) ? htmlspecialchars($row['iconsultancy_granted_amount']) : 'Nil') . '</td></tr>
                            <tr><th>Granted Member</th><td>' . (!empty($row['iconsultancy_granted_member']) ? htmlspecialchars($row['iconsultancy_granted_member']) : 'Nil') . '</td></tr>
                            <tr><th>From</th><td>' . (!empty($row['iconsultancy_from']) ? htmlspecialchars($row['iconsultancy_from']) : 'Nil') . '</td></tr>
                            <tr><th>To</th><td>' . (!empty($row['iconsultancy_to']) ? htmlspecialchars($row['iconsultancy_to']) : 'Nil') . '</td></tr>
                            <tr><th>Funds Generated</th><td>' . (!empty($row['iconsultancy_funds_generated']) ? htmlspecialchars($row['iconsultancy_funds_generated']) : 'Nil') . '</td></tr>
                            <tr><th>Remarks</th><td>' . (!empty($row['iconsultancy_remarks']) ? htmlspecialchars($row['iconsultancy_remarks']) : 'Nil') . '</td></tr>
                                </table>';

            // Return the details in HTML format
            echo $details;
        } else {
            echo '<table class="table"><tr><td colspan="2">No records found.</td></tr></table>';
        }

        $stmt->close();
        break;

    case 'r_guideship_details':
        if (!isset($_POST['id'])) {
            echo json_encode(['status' => false, 'message' => 'Invalid request. ID is missing.']);
            exit();
        }

        // Sanitize and validate ID
        $id = $_POST['id'];
        if (!is_numeric($id)) {
            echo json_encode(['status' => false, 'message' => 'Invalid ID format.']);
            exit();
        }

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM researchguideship WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Manually create the HTML table with specific fields
            $details = '
                                <table class="table table-bordered">
                                    <tr><th>University Name</th><td>' . htmlspecialchars($row['universityname']) . '</td></tr>
                                    <tr><th>Faculty</th><td>' . htmlspecialchars($row['faculty']) . '</td></tr>
                                    <tr><th>Supervisor Status</th><td>' . htmlspecialchars($row['supervisorstatus']) . '</td></tr>
                                ';

            // Conditional rows based on supervisor status
            if ($row['supervisorstatus'] === 'Recognized') {
                $details .= '
                                    <tr><th>Supervisor Approval Number</th><td>' . htmlspecialchars($row['supervisorapprovalno']) . '</td></tr>
                                    <tr><th>Reference Number</th><td>' . htmlspecialchars($row['referencenumber']) . '</td></tr>';
            } else {
                $details .= '
                                    <tr><th>Reference Number</th><td>' . htmlspecialchars($row['referencenumber']) . '</td></tr>';
            }

            $details .= '</table>';

            // Return the details in HTML format
            echo $details;
        } else {
            echo '<table class="table"><tr><td colspan="2">No records found.</td></tr></table>';
        }

        $stmt->close();
        break;

    case 'rguidance_details':
        if (!isset($_POST['id'])) {
            echo json_encode(['status' => false, 'message' => 'Invalid request. ID is missing.']);
            exit();
        }

        // Sanitize and validate ID
        $id = $_POST['id'];
        if (!is_numeric($id)) {
            echo json_encode(['status' => false, 'message' => 'Invalid ID format.']);
            exit();
        }

        // Use prepared statement to fetch research guidance details
        $stmt_guidance = $conn->prepare("SELECT university_name, no_of_scholars FROM research_guidance WHERE guidance_id = ?");
        $stmt_guidance->bind_param("i", $id);
        $stmt_guidance->execute();
        $result_guidance = $stmt_guidance->get_result();

        if ($result_guidance && $result_guidance->num_rows > 0) {
            $guidance_row = $result_guidance->fetch_assoc();

            // Generate the HTML for Research Guidance Details
            $details = '
                    <div class="card mb-3">
                        <div class="card-header"><strong>Research Guidance Details</strong></div>
                        <div class="card-body">
                            <p><strong>University Name:</strong> ' . htmlspecialchars($guidance_row['university_name']) . '</p>
                            <p><strong>Number of Scholars:</strong> ' . htmlspecialchars($guidance_row['no_of_scholars']) . '</p>
                        </div>
                    </div>';

            // Use prepared statement to fetch scholar details
            $stmt_scholars = $conn->prepare("SELECT name, regno, dept, college, domain, date, time_mode, role, status FROM scholar_details WHERE guidance_id = ?");
            $stmt_scholars->bind_param("i", $id);
            $stmt_scholars->execute();
            $result_scholars = $stmt_scholars->get_result();

            if ($result_scholars && $result_scholars->num_rows > 0) {
                $details .= '<div class="card mb-3">
                        <div class="card-header"><strong>Scholar Details</strong></div>
                    </div>';

                while ($scholar_row = $result_scholars->fetch_assoc()) {
                    $details .= '
                            <table class="table table-bordered">
                                <tr><th>Scholar Name</th><td>' . htmlspecialchars($scholar_row['name']) . '</td></tr>
                                <tr><th>Registration No</th><td>' . htmlspecialchars($scholar_row['regno']) . '</td></tr>
                                <tr><th>Department</th><td>' . htmlspecialchars($scholar_row['dept']) . '</td></tr>
                                <tr><th>College</th><td>' . htmlspecialchars($scholar_row['college']) . '</td></tr>
                                <tr><th>Domain</th><td>' . htmlspecialchars($scholar_row['domain']) . '</td></tr>
                                <tr><th>Date</th><td>' . htmlspecialchars($scholar_row['date']) . '</td></tr>
                                <tr><th>Time Mode</th><td>' . htmlspecialchars($scholar_row['time_mode']) . '</td></tr>
                                <tr><th>Role</th><td>' . htmlspecialchars($scholar_row['role']) . '</td></tr>
                                <tr><th>Status</th><td>' . htmlspecialchars($scholar_row['status']) . '</td></tr>
                            </table>';
                }
            } else {
                $details .= '<p>No scholar details found for this research guidance.</p>';
            }

            // Return the complete details
            echo $details;
        } else {
            echo '<p>No details found for the selected research guidance.</p>';
        }

        // Close prepared statements
        $stmt_guidance->close();
        if (isset($stmt_scholars)) {
            $stmt_scholars->close();
        }
        break;



    case 'certificate_details':
        if (!isset($_POST['id'])) {
            echo json_encode(['status' => false, 'message' => 'Invalid request. ID is missing.']);
            exit();
        }

        // Sanitize and validate ID
        $id = $_POST['id'];
        if (!is_numeric($id)) {
            echo json_encode(['status' => false, 'message' => 'Invalid ID format.']);
            exit();
        }

        // Use prepared statement to fetch certificate details
        $stmt = $conn->prepare("SELECT * FROM certifications WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Generate the HTML table
            $details = '
            <table class="table table-bordered">
                <tr><th>Staff Name</th><td>' . htmlspecialchars($row['staff_name']) . '</td></tr>
               
                <tr><th>Department</th><td>' . htmlspecialchars($row['department']) . '</td></tr>
                <tr><th>Academic Year</th><td>' . htmlspecialchars($row['academic_year']) . '</td></tr>
                <tr><th>Certification Type</th><td>' . htmlspecialchars($row['event_type']) . '</td></tr>
                <tr><th>Certification Name</th><td>' . htmlspecialchars($row['event_name']) . '</td></tr>
                <tr><th>Duration</th><td>' . htmlspecialchars($row['certification_duration']) . '</td></tr>
                <tr><th>Document</th><td>         
                <tr><th>Remarks</th><td>' . htmlspecialchars($row['remarks']) . '</td></tr>
            </table>';

            // Return the details
            echo $details;
        } else {
            echo '<table class="table"><tr><td colspan="2">No records found.</td></tr></table>';
        }

        $stmt->close();

        break;


case 'validate_doi':
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['doi']) || !isset($input['author_position'])) {
        echo json_encode(['status' => 'error', 'message' => 'DOI or Author Position is missing.']);
        exit();
    }

    // Sanitize input
    $doi = trim($input['doi']);
    $author_position = intval($input['author_position']); // Cast to integer
    
    // Check if DOI and author position combination exists
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM journal_papers WHERE doi_number = ? AND author_position = ?");
    $stmt->bind_param("si", $doi, $author_position);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    if ($result['count'] > 0) {
        echo json_encode([
            'status' => 'error', 
            'message' => 'This DOI and author position combination already exists. Please enter a valid DOI and author position.'
        ]);
        exit; // Stop further execution to prevent multiple responses
    }
    
    // Check if DOI has already acquired claim
    $stmt1 = $conn->prepare("SELECT claim_acquired FROM journal_papers WHERE doi_number = ?");
    $stmt1->bind_param("s", $doi);
    $stmt1->execute();
    $result = $stmt1->get_result()->fetch_assoc();
    
    if ($result) {
        if ($result['claim_acquired'] == 'yes') {
            echo json_encode([
                'status' => 'error',
                'message' => 'This DOI number already acquired claim.'
            ]);
        } else {
            echo json_encode(['status' => 'success']);
        }
    } else {
        echo json_encode(['status' => 'success']);
    }
    
  
    
    break;

    default:
        echo json_encode(['status' => false, 'message' => 'Invalid action.']);
        break;
}
