<?php
include("config.php");
include("session.php");


// Inputs from POST
$research_type = $_POST['research_type'] ?? '';
$department = $_POST['department'] ?? '';
$status = $_POST['status'] ?? [];
$academic_year = $_POST['academic_year'] ?? '';

// Convert status to a comma-separated string for SQL IN clause
$status_list = implode(',', array_map('intval', $status));

// Initialize query
$query = '';
$tableHeaders = [];
$tableData = [];

// Prepare query based on research type
if ($research_type === 'Journal') {
    $query = "
        SELECT 
            research_type, journal_name, scopus_id, j_publisher_name, journal_status, 
            impact_factor, eissn, j_country, j_level, j_paper_title, 
             month_year, j_authors_count, volume, issue, page, 
            journal_link, doi_number, j_remarks, feedback
        FROM journal_papers 
        WHERE (department = '$department' OR '$department' = 'all')
        AND (academic_year = '$academic_year' OR '$academic_year' = '')
        AND (status_no IN ($status_list) OR '$status_list' = '')
    ";
    $tableHeaders = [
        'Research Type',
        'Journal Name',
        'Scopus ID',
        'Publisher Name',
        'Journal Status',
        'Impact Factor',
        'EISSN',
        'Country',
        'Level',
       
        'Paper Title',
        'Month/Year',
        'Authors Count',
        'Volume',
        'Issue',
        'Page',
        'Journal Link',
        'DOI Number',
        'Remarks',
        'Feedback'
    ];
} elseif ($research_type === 'Consultancy') {
    $query = "
        SELECT 
            research_type, consultancy_type, title, project_id, funding_agency, 
            project_particulars, web_link, requested_amount, status, number_of_members, 
            feedback 
        FROM consultancy 
        WHERE (department = '$department' OR '$department' = 'all')
        AND (academic_year = '$academic_year' OR '$academic_year' = '')
        AND (status IN ($status_list) OR '$status_list' = '')
    ";
    $tableHeaders = [
        'Research Type',
        'Consultancy Type',
        'Title',
        'Project ID',
        'Funding Agency',
        'Project Particulars',
        'Web Link',
        'Requested Amount',
        'Status',
        'Members Count',
        'Feedback'
    ];
} elseif ($research_type === 'Industry Consultancy') {
    $query = "
        SELECT 
            research_type, iconsultancy_type, iconsultancy_title, iconsultancy_particulars, 
            iconsultancy_particulars_work, iconsultancy_web_link, iconsultancy_mou, 
            iconsultancy_author_count, ifeedback 
        FROM industry_consultancy 
        WHERE (department = '$department' OR '$department' = 'all')
        AND (academic_year = '$academic_year' OR '$academic_year' = '')
        AND (istatus1 IN ($status_list) OR '$status_list' = '')
    ";
    $tableHeaders = [
        'Research Type',
        'Consultancy Type',
        'Title',
        'Particulars',
        'Work Details',
        'Web Link',
        'MOU',
        'Author Count',
        'Feedback'
    ];
} elseif ($research_type === 'Conference') {
    $query = "
        SELECT  `research_type`, `staff_name`,  `department`,
        `academic_year`, `conference_title`, `organizer`, `sponsor_name`, `publisher_name`, 
        `indexing_details`, `level`, `location`, `state`, `country`, `from_date`, `to_date`,
        `title_of_paper`, `status`, `month_year`, `number_of_authors`, `eisbn`, `pisbn`, `doi`,
        `link`, `remarks`,  `feedback` 
        FROM `conference_papers`
        WHERE (department = '$department' OR '$department' = 'all')
        AND (academic_year = '$academic_year' OR '$academic_year' = '')
        AND (status_no IN ($status_list) OR '$status_list' = '')
    ";
    $tableHeaders = [
        'Research Type',
        'Staff Name',
       
        'Department',
        'Academic Year',
        'Conference Title',
        'Organizer',
        'Sponsor Name',
        'Publisher Name',
        'Indexing Details',
        'Level',
        'Location',
        'State',
        'Country',
        'From Date',
        'To Date',
        'Title Of Paper',
        'Status',
        'Month Year',
        'Authors Count',
        'eisbn',
        'pisbn',
        'doi',
        'Link',
        'Remarks',
        'Feedback'
    ];
} elseif ($research_type === 'Patent') {
    $query = "
        SELECT  `research_type`, `staff_name`,  `department`, `academic_year`, `patent_title`, 
        `field_of_innovation`, `patent_particulars`, `patent_category`, `patent_country`, `patent_date`, 
        `application_number`, `patent_status`, `number_of_authors`, `published_date`, `availability_date`, 
        `valid_upto`, `journal_number`, `patent_number`, `remarks`,   `feedback`  FROM `patents` 
        WHERE (department = '$department' OR '$department' = 'all')
        AND (academic_year = '$academic_year' OR '$academic_year' = '')
        AND (status_no IN ($status_list) OR '$status_list' = '')
    ";
    $tableHeaders = [
        'Research Type',
        'Staff Name',
        'Department',
        'Academic Year',
        'Patent Title',
        'Innovation Fields',
        'Patent Particulars',
        'Patent Category',
        'Patent Country',
        'Patent Date',
        'Application Number',
        'Patent Status',
        'Number of Authors',
        'Published Date',
        'Availability Date',
        'Valid Upto',
        'Journal Number',
        'Patent Number',
        'Remarks',
        'Feedback',
    ];
} elseif ($research_type === 'Research Guideship') {
    $query = "
       SELECT  `universityname`, `faculty`, `supervisorstatus`, `supervisorapprovalno`, `referencenumber`, `feedback`  FROM `researchguideship`
        WHERE (department = '$department' OR '$department' = 'all')
        AND (academic_year = '$academic_year' OR '$academic_year' = '')
        AND (status_no IN ($status_list) OR '$status_list' = '')
    ";
    $tableHeaders = [
        'UniversityName',
        'Faculty',
        'SupervisorStatus',
        'SupervisorApprovalNo',
        'ReferenceNumber',
        'Feedback'
    ];
} elseif ($research_type === 'Research Guidance') {
    $query = "
       SELECT 
    rg.guidance_id, 
    rg.university_name, 
    rg.no_of_scholars, 
    sd.name, 
    sd.regno, 
    sd.dept, 
    sd.college, 
    sd.domain, 
    sd.date, 
    sd.time_mode, 
    sd.role, 
    sd.status
    FROM 
        research_guidance AS rg
    JOIN 
        scholar_details AS sd
    ON 
        rg.guidance_id = sd.guidance_id
    WHERE 
        (sd.dept = '$department' OR '$department' = 'all')
        AND (rg.academic_year = '$academic_year' OR '$academic_year' = '')
        AND (rg.status_no IN ($status_list) OR '$status_list' = '')";

        $tableHeaders = [
            'Guidance ID',
            'University Name',
            'No of Scholars',
            'Name',
            'Registration Number',
            'Department',
            'College',
            'Domain',
            'Date',
            'Time Mode',
            'Role',
            'Status'
        ];
}elseif ($research_type === 'Certificate') {
    $query = "
        SELECT  `research_type`, `staff_name`, `department`,  `event_type`, 
        `event_name`,  `academic_year`, `certification_duration`, 
         `feedback` FROM `certifications`
        WHERE (department = '$department' OR '$department' = 'all')
        AND (academic_year = '$academic_year' OR '$academic_year' = '')
        AND (status IN ($status_list) OR '$status_list' = '')
    ";
    $tableHeaders = [
        'Research Type',
        'Staff Name',
        'Department',
        
        'Certification Type',
        'Certification Name',
        'Academic Year',
        'Certification Duration',
        
        'Feedback'
    ];
}
// Execute query
$result = mysqli_query($conn, $query);

$output = '';
if (mysqli_num_rows($result) > 0) {
    // Create table headers
    $output .= "<table class='table table-striped table-bordered'><thead ><tr >";
    foreach ($tableHeaders as $header) {
        $output .= "<th  >{$header}</th>";
    }
    $output .= "</tr></thead><tbody>";

    // Populate table rows
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
        foreach ($row as $key => $value) {
            $output .= "<td>" . (!empty($value) ? htmlspecialchars($value) : 'nil') . "</td>";
        }
        $output .= "</tr>";
    }

    $output .= "</tbody></table>";
} else {
    $output = "<tr><td colspan='" . count($tableHeaders) . "'>No records found</td></tr>";
}

echo $output;
