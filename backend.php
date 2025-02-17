  <?php
    include("config.php");
    include("session.php");
    $action = $_GET['action'] ?? ($_POST['action'] ?? '');

    if (empty($action)) {
        $jsonInput = file_get_contents('php://input');
        if (!empty($jsonInput)) {
            $jsonData = json_decode($jsonInput, true);
            $action = $jsonData['action'] ?? '';
        }
    }




    switch ($action) {
        case 'save_conference':
            try {
                // Collect POST data
                $research_type = 'conference';
              
                $academic_year = mysqli_real_escape_string($conn, trim($_POST['academic_year']));
                $conference_title = mysqli_real_escape_string($conn, trim($_POST['conference_title']));
                $organizer = mysqli_real_escape_string($conn, trim($_POST['organizer']));
                $sponsor_name = mysqli_real_escape_string($conn, trim($_POST['sponsor_name']));
                $publisher_name = mysqli_real_escape_string($conn, trim($_POST['publisher_name']));
                $indexing_details = mysqli_real_escape_string($conn, trim($_POST['indexing_details']));
                $level = mysqli_real_escape_string($conn, trim($_POST['level']));
                $location = mysqli_real_escape_string($conn, trim($_POST['location']));
                $state = mysqli_real_escape_string($conn, trim($_POST['state']));
                $country = mysqli_real_escape_string($conn, trim($_POST['country']));
                $from_date = mysqli_real_escape_string($conn, trim($_POST['from_date']));
                $to_date = mysqli_real_escape_string($conn, trim($_POST['to_date']));
                $title_of_paper = mysqli_real_escape_string($conn, trim($_POST['title_of_paper']));
                $number_of_authors = mysqli_real_escape_string($conn, trim($_POST['number_of_authors']));
                $eisbn = mysqli_real_escape_string($conn, trim($_POST['eisbn']));
                $pisbn = mysqli_real_escape_string($conn, trim($_POST['pisbn']));
                $doi = mysqli_real_escape_string($conn, trim($_POST['doi']));
                $author_position = mysqli_real_escape_string($conn, trim($_POST['author_position']));
                $claim_acquired = mysqli_real_escape_string($conn, trim($_POST['claim_acquired']));

                $link = mysqli_real_escape_string($conn, trim($_POST['link']));
                $remarks = mysqli_real_escape_string($conn, trim($_POST['remarks']));
                $conference_pdf = NULL;
                $target_dir = "research/conference/";
                $research_type = "conference";
                if (!empty($_FILES['pdf1']['name'])) {

                    // Validate the file type
                    $file_type = strtolower(pathinfo($_FILES['pdf1']['name'], PATHINFO_EXTENSION));
                    $allowed_extensions = ['pdf'];
                    if (!in_array($file_type, $allowed_extensions)) {
                        die("Invalid file type. Only PDF files are allowed.");
                    }

                    // Generate the current date and time in the format 'YYYYMMDD_HHMMSS'
                    $date_with_time = date('Ymd_His');

                    // Construct a file name using applicant ID and date with time
                    $unique_name = $s . "_" . $date_with_time . '.' . $file_type;

                    // Set the full path for the file
                    $conference_pdf = $target_dir . $unique_name;

                    // Move the uploaded file to the target directory
                    if (!move_uploaded_file($_FILES['pdf1']['tmp_name'], $conference_pdf)) {
                        die("Error in uploading file.");
                    }
                }

                // Insert data using a prepared statement
                $query = "INSERT INTO conference_papers 
                        (staff_id, staff_name, department, academic_year, research_type, conference_title, organizer, sponsor_name, 
                         publisher_name, indexing_details, level, location, state, country, from_date, to_date, title_of_paper, 
                         number_of_authors, eisbn, pisbn, doi, claim_acquired, author_position, link, remarks, conference_pdf) 
                        VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?)";

                $stmt = $conn->prepare($query);

                $stmt->bind_param(
                    "ssssssssssssssssssssssisss",
                    $s,
                    $fname,
                    $fdept,
                    $academic_year,
                    $research_type,
                    $conference_title,
                    $organizer,
                    $sponsor_name,
                    $publisher_name,
                    $indexing_details,
                    $level,
                    $location,
                    $state,
                    $country,
                    $from_date,
                    $to_date,
                    $title_of_paper,
                    $number_of_authors,
                    $eisbn,
                    $pisbn,
                    $doi,
                    $claim_acquired,
                    $author_position,
                    $link,
                    $remarks,
                    $conference_pdf
                );

                // Execute the query
                if ($stmt->execute()) {

                    echo json_encode([
                        'status' => 200,
                        'message' => 'Details Saved Successfully'
                    ]);
                } else {
                    throw new Exception("Query Failed: " . $stmt->error);
                }

                $stmt->close();
            } catch (Exception $e) {

                echo json_encode([
                    'status' => 500,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
            break;


        case 'conferencedeleted':
            try {

                $conference_id = mysqli_real_escape_string($conn, trim($_POST['id']));

                // Prepare the DELETE query
                $query = "DELETE FROM conference_papers WHERE id = ?";
                $stmt = $conn->prepare($query);

                // Bind the parameter
                $stmt->bind_param("i", $conference_id); // Assuming `id` is an integer

                // Execute the prepared statement
                if ($stmt->execute()) {
                    $res = [
                        'status' => 200,
                        'message' => 'Details Deleted Successfully'
                    ];
                    echo json_encode($res);
                } else {
                    throw new Exception("Details Not Deleted: " . $stmt->error);
                }

                // Close the statement
                $stmt->close();
            } catch (Exception $e) {
                $res = [
                    'status' => 500,
                    'message' => $e->getMessage()
                ];
                echo json_encode($res);
            }
            break;

        case 'edit_conference':
            try {

                $user_id = mysqli_real_escape_string($conn, trim($_POST['id'])); // No need for escaping with prepared statements

                // Prepare the SELECT query
                $query = "SELECT * FROM conference_papers WHERE id = ?";
                $stmt = $conn->prepare($query);

                // Bind the parameter
                $stmt->bind_param("i", $user_id); // Assuming `id` is an integer

                // Execute the prepared statement
                $stmt->execute();

                // Fetch the result
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $data = $result->fetch_assoc();
                    echo json_encode(['status' => 200, 'data' => $data]);
                } else {
                    echo json_encode(['status' => 404, 'message' => 'Record not found.']);
                }

                // Close the statement
                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;

        case 'save_editconference':
            try {
                // Sanitize POST data
                $id = mysqli_real_escape_string($conn, trim($_POST['id']));              
                $research_type = 'conference';               
                $academic_year = mysqli_real_escape_string($conn, trim($_POST['academic_year']));
                $conference_title = mysqli_real_escape_string($conn, trim($_POST['conference_title']));
                $organizer = mysqli_real_escape_string($conn, trim($_POST['organizer']));
                $sponsor_name = mysqli_real_escape_string($conn, trim($_POST['sponsor_name']));
                $publisher_name = mysqli_real_escape_string($conn, trim($_POST['publisher_name']));
                $indexing_details = mysqli_real_escape_string($conn, trim($_POST['indexing_details']));
                $level = mysqli_real_escape_string($conn, trim($_POST['level']));
                $location = mysqli_real_escape_string($conn, trim($_POST['location']));
                $state = mysqli_real_escape_string($conn, trim($_POST['state']));
                $country = mysqli_real_escape_string($conn, trim($_POST['country']));
                $from_date = mysqli_real_escape_string($conn, trim($_POST['from_date']));
                $to_date = mysqli_real_escape_string($conn, trim($_POST['to_date']));
                $title_of_paper = mysqli_real_escape_string($conn, trim($_POST['title_of_paper']));
                $number_of_authors = mysqli_real_escape_string($conn, trim($_POST['number_of_authors']));
                $eisbn = mysqli_real_escape_string($conn, trim($_POST['eisbn']));
                $pisbn = mysqli_real_escape_string($conn, trim($_POST['pisbn']));
                $doi = mysqli_real_escape_string($conn, trim($_POST['doi']));
                $claim_acquired = mysqli_real_escape_string($conn, trim($_POST['claim_acquired']));
                $author_position = mysqli_real_escape_string($conn, trim($_POST['author_position']));
                $link = mysqli_real_escape_string($conn, trim($_POST['link']));
                $remarks = mysqli_real_escape_string($conn, trim($_POST['remarks']));

                $conference_pdf = NULL;
                $target_dir = "research/conference/";

                // Handle file upload (only if a new file is uploaded)
                if (!empty($_FILES['pdf1']['name'])) {


                    // Validate the file type
                    $file_type = strtolower(pathinfo($_FILES['pdf1']['name'], PATHINFO_EXTENSION));
                    $allowed_extensions = ['pdf'];
                    if (!in_array($file_type, $allowed_extensions)) {
                        die("Invalid file type. Only PDF files are allowed.");
                    }

                    // Generate the current date and time in the format 'YYYYMMDD_HHMMSS'
                    $date_with_time = date('Ymd_His');

                    // Construct a file name using applicant ID and date with time
                    $unique_name =  $s . "_" . $date_with_time . '.' . $file_type;

                    // Set the full path for the file
                    $conference_pdf = $target_dir . $unique_name;

                    // Check for file upload errors
                    if ($_FILES['pdf1']['error'] !== UPLOAD_ERR_OK) {
                        die("File upload error: " . $_FILES['pdf1']['error']);
                    }

                    // Move the uploaded file to the target directory
                    if (!move_uploaded_file($_FILES['pdf1']['tmp_name'], $conference_pdf)) {
                        die("Error in uploading file.");
                    }
                }


                // Prepare the SQL UPDATE query
                $update_query = "UPDATE conference_papers 
                                        SET staff_id = ?, staff_name = ?, department = ?, academic_year = ?, research_type = ?, conference_title = ?, 
                                            organizer = ?, sponsor_name = ?, publisher_name = ?, indexing_details = ?, level = ?, location = ?, 
                                            state = ?, country = ?, from_date = ?, to_date = ?, title_of_paper = ?, number_of_authors = ?, 
                                            eisbn = ?, pisbn = ?, doi = ?, claim_acquired = ?, author_position = ?, link = ?, remarks = ?, conference_pdf = ?, status_no = 0
                                        WHERE id = ?";

                // Prepare the statement
                $stmt = $conn->prepare($update_query);

                // Bind parameters
                $stmt->bind_param(
                    "ssssssssssssssssssssssisssi",
                    $s,
                    $fname,
                    $fdept,
                    $academic_year,
                    $research_type,
                    $conference_title,
                    $organizer,
                    $sponsor_name,
                    $publisher_name,
                    $indexing_details,
                    $level,
                    $location,
                    $state,
                    $country,
                    $from_date,
                    $to_date,
                    $title_of_paper,
                    $number_of_authors,
                    $eisbn,
                    $pisbn,
                    $doi,
                    $claim_acquired,
                    $author_position,
                    $link,
                    $remarks,
                    $conference_pdf,
                    $id
                );

                // Execute the query
                if ($stmt->execute()) {
                    $res = [
                        'status' => 200,
                        'message' => 'Details Updated Successfully'
                    ];
                    echo json_encode($res);
                } else {
                    throw new Exception('Query Failed: ' . $stmt->error);
                }

                // Close the statement
                $stmt->close();
            } catch (Exception $e) {
                $res = [
                    'status' => 500,
                    'message' => 'Error: ' . $e->getMessage()
                ];
                echo json_encode($res);
            }
            break;
        case 'save_book':
            try {
                // Collect POST data
                $research_type = 'book';               
                $academic_year = mysqli_real_escape_string($conn, trim($_POST['academic_year']));
                $book_category = mysqli_real_escape_string($conn, trim($_POST['book_category']));
                $book_title = mysqli_real_escape_string($conn, trim($_POST['book_title']));
                $chapter_title = mysqli_real_escape_string($conn, trim($_POST['chapter_title']));
                $publisher = mysqli_real_escape_string($conn, trim($_POST['publisher']));
                $indexing_details = mysqli_real_escape_string($conn, trim($_POST['indexing_details']));
                $published_date = mysqli_real_escape_string($conn, trim($_POST['published_date']));
                $number_of_authors = mysqli_real_escape_string($conn, trim($_POST['number_of_authors']));
                $volume = mysqli_real_escape_string($conn, trim($_POST['volume']));
                $edition = mysqli_real_escape_string($conn, trim($_POST['edition']));
                $eisbn = mysqli_real_escape_string($conn, trim($_POST['eisbn']));
                $pisbn = mysqli_real_escape_string($conn, trim($_POST['pisbn']));
                $author_position = mysqli_real_escape_string($conn, trim($_POST['author_position']));
                $claim_acquired = mysqli_real_escape_string($conn, trim($_POST['claim_acquired']));
                $link = mysqli_real_escape_string($conn, trim($_POST['link']));
                $remarks = mysqli_real_escape_string($conn, trim($_POST['remarks']));
                $book_pdf = NULL;
                $target_dir = "research/book/";

                if (!empty($_FILES['pdf1']['name'])) {

                    // Validate the file type
                    $file_type = strtolower(pathinfo($_FILES['pdf1']['name'], PATHINFO_EXTENSION));
                    $allowed_extensions = ['pdf'];
                    if (!in_array($file_type, $allowed_extensions)) {
                        die("Invalid file type. Only PDF files are allowed.");
                    }

                    // Generate the current date and time in the format 'YYYYMMDD_HHMMSS'
                    $date_with_time = date('Ymd_His');

                    // Construct a file name using applicant ID and date with time
                    $unique_name = $s . "_" . $date_with_time . '.' . $file_type;

                    // Set the full path for the file
                    $book_pdf = $target_dir . $unique_name;

                    // Move the uploaded file to the target directory
                    if (!move_uploaded_file($_FILES['pdf1']['tmp_name'], $book_pdf)) {
                        die("Error in uploading file.");
                    }
                }

                // Insert data using a prepared statement
                $query = "INSERT INTO `book`(`research_type`, `staff_id`, `staff_name`, `department`, `academic_year`, 
                    `book_category`,`book_title`,`chapter_title`, `publisher`, `indexing_details`, `published_month_year`,`no_of_authors`,`e_isbn`,
                     `p_isbn`, `volume`, `edition`,`claim_acquired`,`author_position`,`link`,`b_remarks`,`documents`)
                    VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($query);

                $stmt->bind_param(
                    "sssssssssssssssssisss",
                    $research_type,
                    $s,
                    $fname,
                    $fdept,
                    $academic_year,
                    $book_category,
                    $book_title,
                    $chapter_title,
                    $publisher,
                    $indexing_details,
                    $published_date,
                    $number_of_authors,
                    $eisbn,
                    $pisbn,
                    $volume,
                    $edition,
                    $claim_acquired,
                    $author_position,
                    $link,
                    $remarks,
                    $book_pdf
                );

                // Execute the query
                if ($stmt->execute()) {

                    echo json_encode([
                        'status' => 200,
                        'message' => 'Details Saved Successfully'
                    ]);
                } else {
                    throw new Exception("Query Failed: " . $stmt->error);
                }

                $stmt->close();
            } catch (Exception $e) {

                echo json_encode([
                    'status' => 500,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
            break;


        case 'bookdeleted':
            try {

                $book_id = mysqli_real_escape_string($conn, trim($_POST['id']));

                // Prepare the DELETE query
                $query = "DELETE FROM book WHERE id = ?";
                $stmt = $conn->prepare($query);

                // Bind the parameter
                $stmt->bind_param("i", $book_id); // Assuming `id` is an integer

                // Execute the prepared statement
                if ($stmt->execute()) {
                    $res = [
                        'status' => 200,
                        'message' => 'Details Deleted Successfully'
                    ];
                    echo json_encode($res);
                } else {
                    throw new Exception("Details Not Deleted: " . $stmt->error);
                }

                // Close the statement
                $stmt->close();
            } catch (Exception $e) {
                $res = [
                    'status' => 500,
                    'message' => $e->getMessage()
                ];
                echo json_encode($res);
            }
            break;

        case 'edit_book':
            try {

                $user_id = mysqli_real_escape_string($conn, trim($_POST['id'])); // No need for escaping with prepared statements

                // Prepare the SELECT query
                $query = "SELECT * FROM book WHERE id = ?";
                $stmt = $conn->prepare($query);

                // Bind the parameter
                $stmt->bind_param("i", $user_id); // Assuming `id` is an integer

                // Execute the prepared statement
                $stmt->execute();

                // Fetch the result
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $data = $result->fetch_assoc();
                    echo json_encode(['status' => 200, 'data' => $data]);
                } else {
                    echo json_encode(['status' => 404, 'message' => 'Record not found.']);
                }

                // Close the statement
                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;

        case 'save_editbook':
            try {
                // Sanitize POST data
                $id = mysqli_real_escape_string($conn, trim($_POST['id']));
                $research_type = 'book';               
                $academic_year = mysqli_real_escape_string($conn, trim($_POST['academic_year']));
                $book_category = mysqli_real_escape_string($conn, trim($_POST['book_category']));
                $book_title = mysqli_real_escape_string($conn, trim($_POST['book_title']));
                $chapter_title = mysqli_real_escape_string($conn, trim($_POST['chapter_title']));
                $publisher = mysqli_real_escape_string($conn, trim($_POST['publisher']));
                $indexing_details = mysqli_real_escape_string($conn, trim($_POST['indexing_details']));
                $published_date = mysqli_real_escape_string($conn, trim($_POST['published_date']));
                $number_of_authors = mysqli_real_escape_string($conn, trim($_POST['number_of_authors']));
                $volume = mysqli_real_escape_string($conn, trim($_POST['volume']));
                $edition = mysqli_real_escape_string($conn, trim($_POST['edition']));
                $eisbn = mysqli_real_escape_string($conn, trim($_POST['eisbn']));
                $pisbn = mysqli_real_escape_string($conn, trim($_POST['pisbn']));
                $author_position = mysqli_real_escape_string($conn, trim($_POST['author_position']));
                $claim_acquired = mysqli_real_escape_string($conn, trim($_POST['claim_acquired']));
                $link = mysqli_real_escape_string($conn, trim($_POST['link']));
                $remarks = mysqli_real_escape_string($conn, trim($_POST['remarks']));
                $book_pdf = NULL;
                $target_dir = "research/book/";




                // Handle file upload (only if a new file is uploaded)
                if (!empty($_FILES['pdf1']['name'])) {


                    // Validate the file type
                    $file_type = strtolower(pathinfo($_FILES['pdf1']['name'], PATHINFO_EXTENSION));
                    $allowed_extensions = ['pdf'];
                    if (!in_array($file_type, $allowed_extensions)) {
                        die("Invalid file type. Only PDF files are allowed.");
                    }

                    // Generate the current date and time in the format 'YYYYMMDD_HHMMSS'
                    $date_with_time = date('Ymd_His');

                    // Construct a file name using applicant ID and date with time
                    $unique_name =  $s . "_" . $date_with_time . '.' . $file_type;

                    // Set the full path for the file
                    $book_pdf = $target_dir . $unique_name;

                    // Check for file upload errors
                    if ($_FILES['pdf1']['error'] !== UPLOAD_ERR_OK) {
                        die("File upload error: " . $_FILES['pdf1']['error']);
                    }

                    // Move the uploaded file to the target directory
                    if (!move_uploaded_file($_FILES['pdf1']['tmp_name'], $book_pdf)) {
                        die("Error in uploading file.");
                    }
                }


                // Prepare the SQL UPDATE query
                $update_query = "UPDATE `book` SET `research_type`= ?,`staff_id`= ?,`staff_name`= ?,`department`= ?,`academic_year`= ?,
                                        `book_category`= ?,`book_title`= ?,`chapter_title`= ?,`publisher`= ?,`indexing_details`= ?,`published_month_year`= ?,
                                        `no_of_authors`= ?,`e_isbn`= ?,`p_isbn`= ?,`volume`= ?,`edition`= ?,`claim_acquired`= ?,`author_position`= ?,`link`= ?,
                                        `b_remarks`= ?,`documents`= ? WHERE id = ?";

                // Prepare the statement
                $stmt = $conn->prepare($update_query);

                // Bind parameters
                $stmt->bind_param(
                    "sssssssssssisssssisssi",
                    $research_type,
                    $s,
                    $fname,
                    $fdept,
                    $academic_year,
                    $book_category,
                    $book_title,
                    $chapter_title,
                    $publisher,
                    $indexing_details,
                    $published_date,
                    $number_of_authors,
                    $eisbn,
                    $pisbn,
                    $volume,
                    $edition,
                    $claim_acquired,
                    $author_position,
                    $link,
                    $remarks,
                    $book_pdf,
                    $id
                );

                // Execute the query
                if ($stmt->execute()) {
                    $res = [
                        'status' => 200,
                        'message' => 'Details Updated Successfully'
                    ];
                    echo json_encode($res);
                } else {
                    throw new Exception('Query Failed: ' . $stmt->error);
                }

                // Close the statement
                $stmt->close();
            } catch (Exception $e) {
                $res = [
                    'status' => 500,
                    'message' => 'Error: ' . $e->getMessage()
                ];
                echo json_encode($res);
            }
            break;




        case 'save_journal':
            try {
                // Collect POST data
                // Sanitize POST data

                $research_type = 'journal';               
                $academic_year = mysqli_real_escape_string($conn, trim($_POST['academic_year']));
                $indexing_type = mysqli_real_escape_string($conn, trim($_POST['indexing_type']));
                $journal_name = mysqli_real_escape_string($conn, trim($_POST['journal_name']));
                $scopus_id = mysqli_real_escape_string($conn, trim($_POST['scopus_id']));
                $j_publisher_name = mysqli_real_escape_string($conn, trim($_POST['j_publisher_name']));
                $journal_status = mysqli_real_escape_string($conn, trim($_POST['journal_status']));
                $impact_factor = mysqli_real_escape_string($conn, trim($_POST['impact_factor']));
                $eissn = mysqli_real_escape_string($conn, trim($_POST['eissn']));
                $j_country = mysqli_real_escape_string($conn, trim($_POST['j_country']));
                $j_level = mysqli_real_escape_string($conn, trim($_POST['j_level']));
                $j_paper_title = mysqli_real_escape_string($conn, trim($_POST['j_paper_title']));
                $month_year = mysqli_real_escape_string($conn, trim($_POST['month_year']));
                $j_authors_count = mysqli_real_escape_string($conn, trim($_POST['j_authors_count']));
                $volume = mysqli_real_escape_string($conn, trim($_POST['volume']));
                $issue = mysqli_real_escape_string($conn, trim($_POST['issue']));
                $page = mysqli_real_escape_string($conn, trim($_POST['page']));
                $journal_link = mysqli_real_escape_string($conn, trim($_POST['journal_link']));
                $doi_number = mysqli_real_escape_string($conn, trim($_POST['doi']));
                $claim_acquired = mysqli_real_escape_string($conn, trim($_POST['claim_acquired']));
                $author_position = mysqli_real_escape_string($conn, trim($_POST['author_position']));
                $j_remarks = mysqli_real_escape_string($conn, trim($_POST['j_remarks']));

                $journal_pdf = NULL;
                $target_dir = "research/journal/";

                // Handle file upload (only if a new file is uploaded)
                if (!empty($_FILES['pdf2']['name'])) {
                    // Generate the unique file name using staff_id and current timestamp
                    $file_type = strtolower(pathinfo($_FILES['pdf2']['name'], PATHINFO_EXTENSION));
                    $allowed_extensions = ['pdf'];
                    if (!in_array($file_type, $allowed_extensions)) {
                        die("Invalid file type. Only PDF files are allowed.");
                    }

                    // Validate staff_id exists and generate a unique file name
                    if (!empty($s)) {
                        $date_with_time = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
                        $unique_name = $s . "_" . $date_with_time . '.' . $file_type;
                    } else {
                        die("Staff ID is required for generating the file name.");
                    }

                    // Set the full path for the file
                    $journal_pdf = $target_dir . $unique_name;

                    // Check for file upload errors
                    if ($_FILES['pdf2']['error'] !== UPLOAD_ERR_OK) {
                        die("File upload error: " . $_FILES['pdf2']['error']);
                    }

                    // Move the uploaded file to the target directory
                    if (!move_uploaded_file($_FILES['pdf2']['tmp_name'], $journal_pdf)) {
                        die("Error in uploading file.");
                    }
                }


                $insert_query = "INSERT INTO journal_papers 
                (staff_id, staff_name, department, academic_year, research_type, indexing_type, journal_name, scopus_id, j_publisher_name, journal_status, 
                 impact_factor, eissn, j_country, j_level, j_paper_title, month_year, j_authors_count, volume, issue, page, 
                 journal_link, doi_number, claim_acquired, author_position, j_remarks, journal_pdf) 
                VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                // Prepare the statement
                $stmt = $conn->prepare($insert_query);

                if ($stmt === false) {
                    die("Error preparing statement: " . $conn->error);
                }


                // Bind parameters
                $stmt->bind_param(
                    "sssssssssssssssssssssssiss",
                    $s,
                    $fname,
                    $fdept,
                    $academic_year,
                    $research_type,
                    $indexing_type,
                    $journal_name,
                    $scopus_id,
                    $j_publisher_name,
                    $journal_status,
                    $impact_factor,
                    $eissn,
                    $j_country,
                    $j_level,
                    $j_paper_title,
                    $month_year,
                    $j_authors_count,
                    $volume,
                    $issue,
                    $page,
                    $journal_link,
                    $doi_number,
                    $claim_acquired,
                    $author_position, // Adjusted to integer type 'i'
                    $j_remarks,
                    $journal_pdf
                );
                // Execute the query
                if ($stmt->execute()) {
                    $res = [
                        'status' => 200,
                        'message' => 'Journal Details Saved Successfully'
                    ];
                    echo json_encode($res);
                } else {
                    throw new Exception('Query Failed: ' . $stmt->error);
                }

                // Close the statement
                $stmt->close();
            } catch (Exception $e) {
                $res = [
                    'status' => 500,
                    'message' => 'Error: ' . $e->getMessage()
                ];
                echo json_encode($res);
            }
            break;
        case 'journaldeleted':
            try {
                $journal_id = mysqli_real_escape_string($conn, trim($_POST['id']));

                // Prepare the SQL DELETE query
                $delete_query = "DELETE FROM journal_papers WHERE id = ?";

                // Prepare the statement
                $stmt = $conn->prepare($delete_query);

                // Bind parameters
                $stmt->bind_param("i", $journal_id);

                // Execute the query
                if ($stmt->execute()) {
                    $res = [
                        'status' => 200,
                        'message' => 'Details Deleted Successfully'
                    ];
                    echo json_encode($res);
                } else {
                    throw new Exception('Query Failed: ' . $stmt->error);
                }

                // Close the statement
                $stmt->close();
            } catch (Exception $e) {
                $res = [
                    'status' => 500,
                    'message' => 'Error: ' . $e->getMessage()
                ];
                echo json_encode($res);
            }
            break;

        case 'edit_journal':
            try {
                $user_id = mysqli_real_escape_string($conn, trim($_POST['user_id']));

                // Prepare the SQL SELECT query
                $select_query = "SELECT * FROM journal_papers WHERE id = ?";

                // Prepare the statement
                $stmt = $conn->prepare($select_query);

                // Bind parameters
                $stmt->bind_param("i", $user_id);  // "i" stands for integer, since id is assumed to be an integer

                // Execute the query
                $stmt->execute();

                // Get the result
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $data = $result->fetch_assoc();
                    $response = [
                        'status' => 200,
                        'data' => $data
                    ];
                } else {
                    $response = [
                        'status' => 500,
                        'message' => "Journal entry not found."
                    ];
                }

                // Close the statement
                $stmt->close();

                echo json_encode($response);
                exit();
            } catch (Exception $e) {
                $response = [
                    'status' => 500,
                    'message' => 'Error: ' . $e->getMessage()
                ];
                echo json_encode($response);
            }
            break;

        case 'save_editjournal':
            try {
                // Escaping input values to prevent SQL injection
                // Sanitize POST data
                $research_type = 'journal';
                $id = mysqli_real_escape_string($conn, trim($_POST['id']));              
                $academic_year = mysqli_real_escape_string($conn, trim($_POST['academic_year']));
                $journal_name = mysqli_real_escape_string($conn, trim($_POST['journal_name']));
                $scopus_id = mysqli_real_escape_string($conn, trim($_POST['scopus_id']));
                $j_publisher_name = mysqli_real_escape_string($conn, trim($_POST['j_publisher_name']));
                $journal_status = mysqli_real_escape_string($conn, trim($_POST['journal_status']));
                $impact_factor = mysqli_real_escape_string($conn, trim($_POST['impact_factor']));
                $eissn = mysqli_real_escape_string($conn, trim($_POST['eissn']));
                $j_country = mysqli_real_escape_string($conn, trim($_POST['j_country']));
                $j_level = mysqli_real_escape_string($conn, trim($_POST['j_level']));
                $j_paper_title = mysqli_real_escape_string($conn, trim($_POST['j_paper_title']));
                $month_year = mysqli_real_escape_string($conn, trim($_POST['month_year']));
                $j_authors_count = mysqli_real_escape_string($conn, trim($_POST['j_authors_count']));
                $volume = mysqli_real_escape_string($conn, trim($_POST['volume']));
                $issue = mysqli_real_escape_string($conn, trim($_POST['issue']));
                $page = mysqli_real_escape_string($conn, trim($_POST['page']));
                $journal_link = mysqli_real_escape_string($conn, trim($_POST['journal_link']));
                $doi_number = mysqli_real_escape_string($conn, trim($_POST['doi']));
                $indexing_type = mysqli_real_escape_string($conn, trim($_POST['indexing_type']));
                $author_position = mysqli_real_escape_string($conn, trim($_POST['author_position']));
                $claim_acquired = mysqli_real_escape_string($conn, trim($_POST['claim_acquired']));

                $j_remarks = mysqli_real_escape_string($conn, trim($_POST['j_remarks']));

                $journal_pdf = NULL;
                $target_dir = "research/journal/";
                date_default_timezone_set('Asia/Kolkata'); // Set the timezone

                // Handle file upload (only if a new file is uploaded)
                if (!empty($_FILES['pdf2']['name'])) {
                    // Get the file type and validate it
                    $fileType = strtolower(pathinfo($_FILES['pdf2']['name'], PATHINFO_EXTENSION));
                    $allowed_extensions = ['pdf'];
                    if (!in_array($fileType, $allowed_extensions)) {
                        die("Invalid file type. Only PDF files are allowed.");
                    }

                    // Sanitize and construct the unique file name
                    $timestamp = date("Ymd_His"); // Format: YYYYMMDD_HHMMSS
                    $sanitized_title = preg_replace('/[^A-Za-z0-9_\-]/', '_', $j_paper_title); // Replace invalid characters
                    $unique_name = $s . '_' . $timestamp . '.' . $fileType;

                    // Set the full path for the file
                    $journal_pdf = $target_dir . $unique_name;

                    // Check for file upload errors
                    if ($_FILES['pdf2']['error'] !== UPLOAD_ERR_OK) {
                        die("File upload error: " . $_FILES['pdf2']['error']);
                    }

                    // Move the uploaded file to the target directory
                    if (!move_uploaded_file($_FILES['pdf2']['tmp_name'], $journal_pdf)) {
                        die("Error in uploading file.");
                    }
                }

                // Prepare the SQL UPDATE query
                $update_query = "UPDATE journal_papers
                                                         SET staff_id = ?, 
                                                             staff_name = ?,                                                
                                                             department = ?, 
                                                             academic_year = ?,
                                                             research_type= ?,
                                                             indexing_type = ?,
                                                             journal_name = ?, 
                                                             scopus_id = ?, 
                                                             j_publisher_name = ?, 
                                                             journal_status = ?, 
                                                             impact_factor = ?, 
                                                             eissn = ?, 
                                                             j_country = ?, 
                                                             j_level = ?,                                                              
                                                             j_paper_title = ?, 
                                                             month_year = ?, 
                                                             j_authors_count = ?, 
                                                             volume = ?, 
                                                             issue = ?, 
                                                             page = ?, 
                                                             journal_link = ?, 
                                                             doi_number = ?, 
                                                             claim_acquired = ?,
                                                             j_remarks = ?, 
                                                             journal_pdf = ?, 
                                                             status_no = 0,
                                                             author_position = ?
                                                             
                                                         WHERE id = ?";

                // Prepare the statement
                $stmt = $conn->prepare($update_query);

                // Bind parameters
                $stmt->bind_param(
                    "sssssssssssssssssssssssssii",
                    $s,
                    $fname,
                    $fdept,
                    $academic_year,
                    $research_type,
                    $indexing_type,
                    $journal_name,
                    $scopus_id,
                    $j_publisher_name,
                    $journal_status,
                    $impact_factor,
                    $eissn,
                    $j_country,
                    $j_level,
                  
                    $j_paper_title,
                    $month_year,
                    $j_authors_count,
                    $volume,
                    $issue,
                    $page,
                    $journal_link,
                    $doi_number,
                    $claim_acqired,
                    $j_remarks,
                    $journal_pdf,
                    $author_position,
                    // For the condition part of the query
                    $id
                );

                // Execute the query
                if ($stmt->execute()) {
                    $res = [
                        'status' => 200,
                        'message' => 'Journal Details Updated Successfully'
                    ];
                    echo json_encode($res);
                } else {
                    throw new Exception('Query Failed: ' . $stmt->error);
                }

                // Close the statement
                $stmt->close();
            } catch (Exception $e) {
                $res = [
                    'status' => 500,
                    'message' => 'Error: ' . $e->getMessage()
                ];
                echo json_encode($res);
            }
            break;
        case 'save_patent':
            try {
                // Escape and sanitize input values
                $research_type = 'patent';
                
                $academic_year = mysqli_real_escape_string($conn, trim($_POST['academic_year']));
                $patent_title = mysqli_real_escape_string($conn, trim($_POST['patent_title']));
                $field_of_innovation = mysqli_real_escape_string($conn, trim($_POST['field_of_innovation']));
                $patent_particulars = mysqli_real_escape_string($conn, trim($_POST['patent_particulars']));
                $patent_category = mysqli_real_escape_string($conn, trim($_POST['patent_category']));
                $patent_country = mysqli_real_escape_string($conn, trim($_POST['patent_country']));
                $patent_date = mysqli_real_escape_string($conn, trim($_POST['patent_date']));
                $application_number = mysqli_real_escape_string($conn, trim($_POST['application_number']));
                $patent_status = mysqli_real_escape_string($conn, trim($_POST['p_status']));
                $number_of_authors = isset($_POST['p_no_authors']) ? mysqli_real_escape_string($conn, trim($_POST['p_no_authors'])) : NULL;
                $published_date = isset($_POST['p_published_date']) ? mysqli_real_escape_string($conn, trim($_POST['p_published_date'])) : NULL;
                $availability_date = isset($_POST['p_availability_date']) ? mysqli_real_escape_string($conn, trim($_POST['p_availability_date'])) : NULL;
                $valid_upto = isset($_POST['p_valid_upto']) ? mysqli_real_escape_string($conn, trim($_POST['p_valid_upto'])) : NULL;
                $journal_number = isset($_POST['p_journal_no']) ? mysqli_real_escape_string($conn, trim($_POST['p_journal_no'])) : NULL;
                $patent_number = isset($_POST['p_patent_no']) ? mysqli_real_escape_string($conn, trim($_POST['p_patent_no'])) : NULL;
                $remarks = isset($_POST['P_remarks']) ? mysqli_real_escape_string($conn, trim($_POST['P_remarks'])) : NULL;

                $patent_pdf = NULL;
                $target_dir = "research/patent/";
                date_default_timezone_set('Asia/Kolkata'); // Set timezone for consistent timestamps

                // Handle file upload (if a new file is uploaded)
                if (!empty($_FILES['patent_pdf']['name'])) {
                    // Get file type and validate it
                    $file_type = strtolower(pathinfo($_FILES['patent_pdf']['name'], PATHINFO_EXTENSION));
                    $allowed_extensions = ['pdf'];
                    if (!in_array($file_type, $allowed_extensions)) {
                        die("Invalid file type. Only PDF files are allowed.");
                    }

                    // Generate a sanitized and unique file name
                    $timestamp = date("Ymd_His"); // Format: YYYYMMDD_HHMMSS
                    $sanitized_title = preg_replace('/[^A-Za-z0-9_\-]/', '_', $patent_title); // Replace invalid characters in title
                    $unique_name = $s . '_' . $timestamp . '.' . $file_type;

                    // Set the full file path
                    $patent_pdf = $target_dir . $unique_name;

                    // Check for file upload errors
                    if ($_FILES['patent_pdf']['error'] !== UPLOAD_ERR_OK) {
                        die("File upload error: " . $_FILES['patent_pdf']['error']);
                    }

                    // Move the uploaded file to the target directory
                    if (!move_uploaded_file($_FILES['patent_pdf']['tmp_name'], $patent_pdf)) {
                        die("Error in uploading file.");
                    }
                }

                // Prepare the SQL INSERT query using prepared statements
                $insert_query = "INSERT INTO patents(staff_id, staff_name, department,academic_year,research_type, patent_title, field_of_innovation,
                 patent_particulars, patent_category, patent_country, patent_date, application_number, patent_status, number_of_authors, published_date, availability_date, valid_upto, journal_number, patent_number, remarks, patent_pdf) 
                                                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                // Prepare the statement
                $stmt = $conn->prepare($insert_query);

                // Bind parameters
                $stmt->bind_param(
                    "sssssssssssssssssssss",
                    $s,
                    $fname,
                    $fdept,
                    $academic_year,
                    $research_type,
                    $patent_title,
                    $field_of_innovation,
                    $patent_particulars,
                    $patent_category,
                    $patent_country,
                    $patent_date,
                    $application_number,
                    $patent_status,
                    $number_of_authors,
                    $published_date,
                    $availability_date,
                    $valid_upto,
                    $journal_number,
                    $patent_number,
                    $remarks,
                    $patent_pdf
                );

                // Execute the query
                if ($stmt->execute()) {
                    $res = [
                        'status' => 200,
                        'message' => 'Patent details saved successfully.'
                    ];
                    echo json_encode($res);
                } else {
                    throw new Exception('Query failed: ' . $stmt->error);
                }

                // Close the statement
                $stmt->close();
            } catch (Exception $e) {
                $res = [
                    'status' => 500,
                    'message' => 'Error: ' . $e->getMessage()
                ];
                echo json_encode($res);
            }
            break;


        case 'patentdeleted':
            try {
                // Escape and sanitize input
                $patent_id = mysqli_real_escape_string($conn, trim($_POST['id']));

                // Prepare the DELETE query using prepared statements
                $delete_query = "DELETE FROM patents WHERE id = ?";
                $stmt = $conn->prepare($delete_query);

                // Bind parameters
                $stmt->bind_param("i", $patent_id);

                // Execute the query
                if ($stmt->execute()) {
                    $res = [
                        'status' => 200,
                        'message' => 'Details Deleted Successfully'
                    ];
                    echo json_encode($res);
                } else {
                    throw new Exception('Failed to delete record');
                }

                // Close the statement
                $stmt->close();
            } catch (Exception $e) {
                $res = [
                    'status' => 500,
                    'message' => 'Error: ' . $e->getMessage()
                ];
                echo json_encode($res);
            }
            break;

        case 'edit_patent':
            try {
                $user_id = mysqli_real_escape_string($conn, trim($_POST['user_id']));

                // Prepare the SELECT query using prepared statements
                $select_query = "SELECT * FROM patents WHERE id = ?";
                $stmt = $conn->prepare($select_query);

                // Bind parameters
                $stmt->bind_param("i", $user_id);

                // Execute the query
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Fetch the data
                    $data = $result->fetch_assoc();
                    echo json_encode(['status' => 200, 'data' => $data]);
                } else {
                    echo json_encode(['status' => 500, 'message' => 'Patent not found.']);
                }

                // Close the statement
                $stmt->close();
            } catch (Exception $e) {
                $res = [
                    'status' => 500,
                    'message' => 'Error: ' . $e->getMessage()
                ];
                echo json_encode($res);
            }
            break;
        case 'save_editpatent':
            try {
                // Escape and sanitize input values
                $research_type = 'patent';
                $id = mysqli_real_escape_string($conn, $_POST['id']);
               

                $patent_title = mysqli_real_escape_string($conn, $_POST['patent_title']);
                $field_of_innovation = mysqli_real_escape_string($conn, $_POST['field_of_innovation']);
                $patent_particulars = mysqli_real_escape_string($conn, $_POST['patent_particulars']);
                $patent_category = mysqli_real_escape_string($conn, $_POST['patent_category']);
                $patent_country = mysqli_real_escape_string($conn, $_POST['patent_country']);
                $patent_date = mysqli_real_escape_string($conn, $_POST['patent_date']);
                $application_number = mysqli_real_escape_string($conn, $_POST['application_number']);
                $patent_status = mysqli_real_escape_string($conn, $_POST['p_status']);
                $number_of_authors = isset($_POST['p_no_authors']) ? mysqli_real_escape_string($conn, $_POST['p_no_authors']) : NULL;
                $published_date = isset($_POST['p_published_date']) ? mysqli_real_escape_string($conn, $_POST['p_published_date']) : NULL;
                $availability_date = isset($_POST['p_availability_date']) ? mysqli_real_escape_string($conn, $_POST['p_availability_date']) : NULL;
                $valid_upto = isset($_POST['p_valid_upto']) ? mysqli_real_escape_string($conn, $_POST['p_valid_upto']) : NULL;
                $journal_number = isset($_POST['p_journal_no']) ? mysqli_real_escape_string($conn, $_POST['p_journal_no']) : NULL;
                $patent_number = isset($_POST['p_patent_no']) ? mysqli_real_escape_string($conn, $_POST['p_patent_no']) : NULL;
                $remarks = isset($_POST['P_remarks']) ? mysqli_real_escape_string($conn, $_POST['P_remarks']) : NULL;
                $patent_pdf = NULL;

                $target_dir = "research/patent/";

                if (!empty($_FILES['patent_pdf']['name'])) {
                    // Get file type and validate it
                    $file_type = strtolower(pathinfo($_FILES['patent_pdf']['name'], PATHINFO_EXTENSION));
                    $allowed_extensions = ['pdf'];
                    if (!in_array($file_type, $allowed_extensions)) {
                        die("Invalid file type. Only PDF files are allowed.");
                    }

                    // Generate a sanitized and unique file name
                    $timestamp = date("Ymd_His"); // Format: YYYYMMDD_HHMMSS
                    $sanitized_title = preg_replace('/[^A-Za-z0-9_\-]/', '_', $patent_title); // Replace invalid characters in title
                    $unique_name = $s . '_' . $timestamp . '.' . $file_type;

                    // Set the full file path
                    $patent_pdf = $target_dir . $unique_name;

                    // Check for file upload errors
                    if ($_FILES['patent_pdf']['error'] !== UPLOAD_ERR_OK) {
                        die("File upload error: " . $_FILES['patent_pdf']['error']);
                    }

                    // Move the uploaded file to the target directory
                    if (!move_uploaded_file($_FILES['patent_pdf']['tmp_name'], $patent_pdf)) {
                        die("Error in uploading file.");
                    }
                }


                // Prepare the SQL statement with placeholders
                $query = "UPDATE patents SET

                staff_id = ?, 
                staff_name = ?, 
                department = ?,
                academic_year= ?,
                research_type= ?, 
                patent_title = ?, 
                field_of_innovation = ?, 
                patent_particulars = ?, 
                patent_category = ?, 
                patent_country = ?, 
                patent_date = ?, 
                application_number = ?, 
                patent_status = ?, 
                number_of_authors = ?, 
                published_date = ?, 
                availability_date = ?, 
                valid_upto = ?, 
                journal_number = ?, 
                patent_number = ?, 
                remarks = ?, 
                status_no = 0 
                WHERE id = ?";

                // Initialize the prepared statement
                $stmt = $conn->prepare($query);

                if ($stmt === false) {
                    throw new Exception('Prepare failed: ' . $conn->error);
                }

                // Bind parameters to the placeholders
                $stmt->bind_param(
                    'ssssssssssssssssssssi',

                    $s,
                    $fname,
                    $fdept,
                    $academic_year,
                    $research_type,
                    $patent_title,
                    $field_of_innovation,
                    $patent_particulars,
                    $patent_category,
                    $patent_country,
                    $patent_date,
                    $application_number,
                    $patent_status,
                    $number_of_authors,
                    $published_date,
                    $availability_date,
                    $valid_upto,
                    $journal_number,
                    $patent_number,
                    $remarks,
                    $id
                );

                // Execute the prepared statement
                if ($stmt->execute()) {
                    $res = [
                        'status' => 200,
                        'message' => 'Patent details updated successfully.'
                    ];
                    echo json_encode($res);
                } else {
                    throw new Exception('Query failed: ' . $stmt->error);
                }
            } catch (Exception $e) {
                $res = [
                    'status' => 500,
                    'message' => 'Error: ' . $e->getMessage()
                ];
                echo json_encode($res);
            }
            break;
        case "addproject":
            $research_type = "Project";
            $status = 0;
           
            $academic_year = mysqli_real_escape_string($conn, $_POST['prjt_academic_year']);
            $title = mysqli_real_escape_string($conn, $_POST['prjt_title']);
            $noofmem = mysqli_real_escape_string($conn, $_POST['prjt_member']);
            $domain  = mysqli_real_escape_string($conn, $_POST['prjt_domain']);
            $type = mysqli_real_escape_string($conn, $_POST['prjt_type']);
            $disc = mysqli_real_escape_string($conn, $_POST['prjt_disc']);
            $link = mysqli_real_escape_string($conn, $_POST['prjt_link']);
            $remarks = mysqli_real_escape_string($conn, $_POST['prjt_remarks']);
            $project_pdf = NULL;
            $target_dir = "research/project/";
            if (!empty($_FILES['prjt_pdf1']['name'])) {

                // Validate the file type
                $file_type = strtolower(pathinfo($_FILES['prjt_pdf1']['name'], PATHINFO_EXTENSION));
                $allowed_extensions = ['pdf'];
                if (!in_array($file_type, $allowed_extensions)) {
                    die("Invalid file type. Only PDF files are allowed.");
                }

                // Generate the current date and time in the format 'YYYYMMDD_HHMMSS'
                $date_with_time = date('Ymd_His');

                // Construct a file name using applicant ID and date with time
                $unique_name = $s . "_" . $date_with_time . '.' . $file_type;

                // Set the full path for the file
                $project_pdf = $target_dir . $unique_name;

                // Move the uploaded file to the target directory
                if (!move_uploaded_file($_FILES['prjt_pdf1']['tmp_name'], $project_pdf)) {
                    die("Error in uploading file.");
                }
            }

            $query = "INSERT INTO projects (staff_id,staff_name,department,academic_year,research_type,title,members,domain,disciplinary,link,type,remarks,project_pdf,status_no) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param(
                "ssssssssssssss",
                $s,
                $fname,
                $fdept,
                $academic_year,
                $research_type,
                $title,
                $noofmem,
                $domain,
                $disc,
                $link,
                $type,
                $remarks,
                $project_pdf,
                $status



            );
            // Execute the query
            if ($stmt->execute()) {

                echo json_encode([
                    'status' => 200,
                    'message' => 'Details Saved Successfully'
                ]);
            } else {
                echo json_encode([
                    'status' => 500,
                    'message' => 'Failed to save details'
                ]);
            }

            $stmt->close();


            break;


        case 'projectdeleted':
            try {

                $project_id = mysqli_real_escape_string($conn, trim($_POST['id']));

                // Prepare the DELETE query
                $query = "DELETE FROM projects WHERE id = ?";
                $stmt = $conn->prepare($query);

                // Bind the parameter
                $stmt->bind_param("i", $project_id); // Assuming `id` is an integer

                // Execute the prepared statement
                if ($stmt->execute()) {
                    $res = [
                        'status' => 200,
                        'message' => 'Details Deleted Successfully'
                    ];
                    echo json_encode($res);
                } else {
                    throw new Exception("Details Not Deleted: " . $stmt->error);
                }

                // Close the statement
                $stmt->close();
            } catch (Exception $e) {
                $res = [
                    'status' => 500,
                    'message' => $e->getMessage()
                ];
                echo json_encode($res);
            }
            break;

        case 'projectedit':
            $project_id = mysqli_real_escape_string($conn, $_POST['id']);
            $query = "SELECT * FROM projects WHERE id=?";
            $stmt = $conn->prepare($query);

            // Bind the parameter
            $stmt->bind_param("i", $project_id); // Assuming `id` is an integer
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $data = $result->fetch_assoc();
                echo json_encode(['status' => 200, 'data' => $data]);
            } else {
                echo json_encode(['status' => 500, 'message' => "error"]);
            }
            break;



        case 'saveditprjt':
            $status = 0;
            $id = mysqli_real_escape_string($conn, $_POST['id']);
           
            $academic_year = mysqli_real_escape_string($conn, $_POST['prjt_academic_year']);
            $title = mysqli_real_escape_string($conn, $_POST['prjt_title']);
            $noofmem = mysqli_real_escape_string($conn, $_POST['prjt_member']);
            $domain  = mysqli_real_escape_string($conn, $_POST['prjt_domain']);
            $type = mysqli_real_escape_string($conn, $_POST['prjt_type']);
            $disc = mysqli_real_escape_string($conn, $_POST['prjt_disc']);
            $link = mysqli_real_escape_string($conn, $_POST['prjt_link']);
            $remarks = mysqli_real_escape_string($conn, $_POST['prjt_remarks']);
            $project_pdf = NULL;
            $target_dir = "research/project/";
            if (!empty($_FILES['prjt_pdf1']['name'])) {

                // Validate the file type
                $file_type = strtolower(pathinfo($_FILES['prjt_pdf1']['name'], PATHINFO_EXTENSION));
                $allowed_extensions = ['pdf'];
                if (!in_array($file_type, $allowed_extensions)) {
                    die("Invalid file type. Only PDF files are allowed.");
                }

                // Generate the current date and time in the format 'YYYYMMDD_HHMMSS'
                $date_with_time = date('Ymd_His');

                // Construct a file name using applicant ID and date with time
                $unique_name = $s . "_" . $date_with_time . '.' . $file_type;

                // Set the full path for the file
                $project_pdf = $target_dir . $unique_name;

                // Move the uploaded file to the target directory
                if (!move_uploaded_file($_FILES['prjt_pdf1']['tmp_name'], $project_pdf)) {
                    die("Error in uploading file.");
                }
            }
            $query = "UPDATE projects SET staff_id='$s',staff_name='$staff_name',department='$department',academic_year='$academic_year',title='$title',members='$noofmem',domain='$domain',type='$type',disciplinary='$disc',link='$link',remarks='$remarks',project_pdf='$project_pdf' WHERE id='$id'";
            if ($stmt = $conn->prepare($query)) {
                echo json_encode(["status" => 200, "message" => "success"]);
            } else {
                echo json_encode(["status" => 500, "message" => "Failed"]);
            }
            break;

        case 'save_projectGuidance':
            try {
                $research_type = 'Project Guidance';               
                $academic_year1 = mysqli_real_escape_string($conn, trim($_POST['academic_year1']));
                $university_name = mysqli_real_escape_string($conn, $_POST['university_name']);
                $no_of_teams = mysqli_real_escape_string($conn, $_POST['noofteams']); // Assuming this is for the number of teams

                // Process the scholar details
                $titles = array_map(function ($title) use ($conn) {
                    return mysqli_real_escape_string($conn, $title);
                }, $_POST['title']);

                $domains = array_map(function ($domain) use ($conn) {
                    return mysqli_real_escape_string($conn, $domain);
                }, $_POST['domain']);

                $depts = array_map(function ($dept) use ($conn) {
                    return mysqli_real_escape_string($conn, $dept);
                }, $_POST['dept']);

                $project_dates = array_map(function ($project_date) use ($conn) {
                    return mysqli_real_escape_string($conn, $project_date);
                }, $_POST['date']);

                $categories = array_map(function ($category) use ($conn) {
                    return mysqli_real_escape_string($conn, $category);
                }, $_POST['project_category']);

                $disciplinaries = array_map(function ($disciplinary) use ($conn) {
                    return mysqli_real_escape_string($conn, $disciplinary);
                }, $_POST['disciplinary']);
                $academic_years = array_map(function ($academic_year) use ($conn) {
                    return mysqli_real_escape_string($conn, $academic_year);
                }, $_POST['project_academic_year']);
                
                $batches = array_map(function ($batch) use ($conn) {
                    return mysqli_real_escape_string($conn, $batch);
                }, $_POST['project_batch']);

                $team_members = array_map(function ($team_member) use ($conn) {
                    return mysqli_real_escape_string($conn, $team_member);
                }, $_POST['team_members']);

                // Handle the file upload
                $uploadDir = 'research/project_guidance/';
                $fileExtension = strtolower(pathinfo($_FILES['pdf1']['name'], PATHINFO_EXTENSION));
                $fileName = $s . '_' . date('Ymd_His') . '.' . $fileExtension;
                $filePath = $uploadDir . $fileName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (!empty($_FILES['pdf1']['name']) && move_uploaded_file($_FILES['pdf1']['tmp_name'], $filePath)) {

                    try {
                        // Insert project guidance details into the database
                        $stmt = $conn->prepare("INSERT INTO project_guidance (`staff_id`, `staff_name`, `department`, `academic_year`, `research_type`, `no_of_teams`, `documents`) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param(
                            "sssssis",
                            $s,
                            $fname,
                            $fdept,
                            $academic_year1,
                            $research_type,

                            $no_of_teams,
                            $filePath
                        );

                        if (!$stmt->execute()) {
                            throw new Exception('Database error: ' . $stmt->error);
                        }

                        $guidance_id = $conn->insert_id; // Get the inserted project's guidance ID
                        

                        // Insert scholar details into the scholar_details table
                        $stmt1 = $conn->prepare("INSERT INTO project_team_details (pguidance_id, project_category, project_title, project_department, project_batch, project_academic_year, project_date, team_members, disciplinary, domain) VALUES (?, ?, ?, ?, ?, ?, ?,?, ?, ?)");
                        for ($i = 0; $i < count($titles); $i++) {
                            $stmt1->bind_param(
                                "issssssiss",
                                $guidance_id,
                                $categories[$i],
                                $titles[$i],
                                $depts[$i],
                                $batches[$i],                                      
                                $academic_years[$i],
                                $project_dates[$i],
                                $team_members[$i],
                                $disciplinaries[$i],
                                $domains[$i],
                            );

                            if (!$stmt1->execute()) {
                                throw new Exception('Database error: ' . $stmt->error);
                            }
                        }
                        $stmt1->close();
                        $stmt->close();

                        echo json_encode(['status' => 200, 'message' => 'Project guidance details saved successfully.']);
                    } catch (Exception $e) {
                        throw $e;
                    }
                } else {
                    echo json_encode(['status' => 500, 'message' => 'File upload failed.']);
                }
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;

        case 'project_guidance_delete':
            try {
                // Get the project guidance ID
                $guidance_id = mysqli_real_escape_string($conn, trim($_POST['id']));

                // Prepare the DELETE query for the project guidance table
                $query = "DELETE FROM project_guidance WHERE id = ?";
                $stmt = $conn->prepare($query);

                // Bind the parameter
                $stmt->bind_param("i", $guidance_id); // Assuming `id` is an integer

                // Execute the prepared statement
                if ($stmt->execute()) {
                    // Also delete the related scholar details if needed
                    $query2 = "DELETE FROM project_team_details WHERE pguidance_id = ?";
                    $stmt2 = $conn->prepare($query2);
                    $stmt2->bind_param("i", $guidance_id);

                    if ($stmt2->execute()) {
                        $res = [
                            'status' => 200,
                            'message' => 'Project Guidance Deleted Successfully'
                        ];
                        echo json_encode($res);
                    } else {
                        throw new Exception("Related Scholar Details Not Deleted: " . $stmt2->error);
                    }

                    // Close the second statement
                    $stmt2->close();
                } else {
                    throw new Exception("Project Guidance Not Deleted: " . $stmt->error);
                }

                // Close the first statement
                $stmt->close();
            } catch (Exception $e) {
                $res = [
                    'status' => 500,
                    'message' => $e->getMessage()
                ];
                echo json_encode($res);
            }
            break;

        case 'edit_projectGuidance':
            try {
                $guidance_id = mysqli_real_escape_string($conn, trim($_POST['id']));

                // Fetch project guidance data
                $stmt = $conn->prepare("SELECT * FROM project_guidance WHERE id = ?");
                $stmt->bind_param("i", $guidance_id);
                $stmt->execute();
                $pguidance_data = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                // Fetch related scholars data
                $stmt = $conn->prepare("SELECT * FROM project_team_details WHERE pguidance_id = ?");
                $stmt->bind_param("i", $guidance_id);
                $stmt->execute();
                $pteam_data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                echo json_encode(['status' => 200, 'data' => ['project_guidance' => $pguidance_data, 'teams' => $pteam_data]]);
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;

        case 'save_edit_projectGuidance':
            try {
                // Sanitize input values
                $guidance_id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
                $research_type = 'Project Guidance';
               
                $academic_year1 = mysqli_real_escape_string($conn, trim($_POST['academic_year1']));
                $university_name = mysqli_real_escape_string($conn, $_POST['university_name']);
                $no_of_teams = mysqli_real_escape_string($conn, $_POST['noofteams']); // Assuming this is for the number of teams

                // Process the scholar details
                $titles = array_map(function ($title) use ($conn) {
                    return mysqli_real_escape_string($conn, $title);
                }, $_POST['title']);

                $domains = array_map(function ($domain) use ($conn) {
                    return mysqli_real_escape_string($conn, $domain);
                }, $_POST['domain']);

                $depts = array_map(function ($dept) use ($conn) {
                    return mysqli_real_escape_string($conn, $dept);
                }, $_POST['dept']);

                $project_dates = array_map(function ($project_date) use ($conn) {
                    return mysqli_real_escape_string($conn, $project_date);
                }, $_POST['date']);

                $categories = array_map(function ($category) use ($conn) {
                    return mysqli_real_escape_string($conn, $category);
                }, $_POST['project_category']);

                $disciplinaries = array_map(function ($disciplinary) use ($conn) {
                    return mysqli_real_escape_string($conn, $disciplinary);
                }, $_POST['disciplinary']);
                $academic_years = array_map(function ($academic_year) use ($conn) {
                    return mysqli_real_escape_string($conn, $academic_year);
                }, $_POST['project_academic_year']);
                
                $batches = array_map(function ($batch) use ($conn) {
                    return mysqli_real_escape_string($conn, $batch);
                }, $_POST['project_batch']);

                $team_members = array_map(function ($team_member) use ($conn) {
                    return mysqli_real_escape_string($conn, $team_member);
                }, $_POST['team_members']);

                // Handle the file upload
                $uploadDir = 'research/project_guidance/';
                $fileExtension = strtolower(pathinfo($_FILES['pdf1']['name'], PATHINFO_EXTENSION));
                $fileName = $s . '_' . date('Ymd_His') . '.' . $fileExtension;
                $filePath = $uploadDir . $fileName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (!empty($_FILES['pdf1']['name']) && move_uploaded_file($_FILES['pdf1']['tmp_name'], $filePath)) {

                    try {
                        // Insert project guidance details into the database
                        $stmt = $conn->prepare("INSERT INTO project_guidance (`staff_id`, `staff_name`, `department`, `academic_year`, `research_type`, `no_of_teams`, `documents`) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param(
                            "sssssis",
                            $s,
                            $fname,
                            $fdept,
                            $academic_year1,
                            $research_type,

                            $no_of_teams,
                            $filePath
                        );

                        if (!$stmt->execute()) {
                            throw new Exception('Database error: ' . $stmt->error);
                        }

                        $guidance_id = $conn->insert_id; // Get the inserted project's guidance ID
                        

                        // Insert scholar details into the scholar_details table
                        $stmt1 = $conn->prepare("INSERT INTO project_team_details (pguidance_id, project_category, project_title, project_department, project_batch, project_academic_year, project_date, team_members, disciplinary, domain) VALUES (?, ?, ?, ?, ?, ?, ?,?, ?, ?)");
                        for ($i = 0; $i < count($titles); $i++) {
                            $stmt1->bind_param(
                                "issssssiss",
                                $guidance_id,
                                $categories[$i],
                                $titles[$i],
                                $depts[$i],
                                $batches[$i],                                      
                                $academic_years[$i],
                                $project_dates[$i],
                                $team_members[$i],
                                $disciplinaries[$i],
                                $domains[$i],
                            );

                            if (!$stmt1->execute()) {
                                throw new Exception('Database error: ' . $stmt->error);
                            }
                        }
                        $stmt1->close();
                        $stmt->close();

                        echo json_encode(['status' => 200, 'message' => 'Project guidance updated successfully.']);
                    } catch (Exception $e) {
                        throw $e;
                    }
                } else {
                    echo json_encode(['status' => 500, 'message' => 'File upload failed.']);
                }
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;


        case 'save_consultancy':
            try {
                // Prepare the parameters
                // Prepare the parameters
                $research_type = 'consultancy';               
                $academic_year = mysqli_real_escape_string($conn, trim($_POST['academic_year']));
                $consultancy_type = mysqli_real_escape_string($conn, $_POST['consultancy_type']);
                $title = mysqli_real_escape_string($conn, $_POST['consultancy_title']);
                $project_id = mysqli_real_escape_string($conn, $_POST['project_id']);
                $funding_agency = mysqli_real_escape_string($conn, $_POST['funding_agency']);
                $project_particulars = mysqli_real_escape_string($conn, $_POST['project_particulars']);
                $web_link = mysqli_real_escape_string($conn, $_POST['web_link']);
                $requested_amount = mysqli_real_escape_string($conn, $_POST['requested_amount']);
                $status = mysqli_real_escape_string($conn, $_POST['status']);
                $filing_date = mysqli_real_escape_string($conn, $_POST['filing_date']);
                $granted_member = mysqli_real_escape_string($conn, $_POST['granted_number']);
                $granted_amount = mysqli_real_escape_string($conn, $_POST['granted_amount']);
                $from = mysqli_real_escape_string($conn, $_POST['from']);
                $to = mysqli_real_escape_string($conn, $_POST['to']);
                $funds_generated = mysqli_real_escape_string($conn, $_POST['funds_generated']);
                $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
                $no_of_members = mysqli_real_escape_string($conn, $_POST['no_of_members']);

                // File upload handling
                $uploadDir = 'research/consultancy/';
                $fileName = basename($_FILES['upload_files']['name']);
                $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Create a new file name using the staff ID and current date/time
                $timestamp = date("Y-m-d_H-i-s");
                $newFileName = $s . '_' . $timestamp . '.' . $fileType;
                $filePath = $uploadDir . $newFileName;

                // Ensure the upload directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Validate file type (only allow certain file types)
                if (!in_array($fileType, ['pdf', 'docx', 'jpg', 'jpeg', 'png'])) {
                    throw new Exception('Invalid file type. Only PDF, DOCX, JPG, JPEG, PNG files are allowed.');
                }

                // Move the uploaded file
                if (move_uploaded_file($_FILES['upload_files']['tmp_name'], $filePath)) {
                    // Prepare the SQL query with parameterized query to prevent SQL injection


                    $stmt = $conn->prepare("INSERT INTO `consultancy` 
                                        ( `staff_id`,`staff_name`, `department`, `academic_year`, `research_type`,`consultancy_type`, `title`, `project_id`, `funding_agency`, `project_particulars`, `web_link`, `requested_amount`, `status`, `number_of_members`, `documents`, `filing_date`, `granted_amount`, `granted_member`, `from`, `to`, `funds_generated`, `remarks`) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?, ?, ?)");

                    // Bind the parameters to the query
                    $stmt->bind_param(
                        "sssssssssssisissiissis",
                        $s,
                        $fname,
                        $fdept,
                        $academic_year,
                        $research_type,
                        $consultancy_type,
                        $title,
                        $project_id,
                        $funding_agency,
                        $project_particulars,
                        $web_link,
                        $requested_amount,
                        $status,
                        $no_of_members,
                        $filePath,
                        $filing_date,
                        $granted_amount,
                        $granted_member,
                        $from,
                        $to,
                        $funds_generated,
                        $remarks
                    );

                    // Execute the query and handle success/failure
                    if ($stmt->execute()) {
                        echo json_encode(['status' => 200, 'message' => 'Consultancy added successfully.']);
                    } else {
                        throw new Exception('Error: ' . $conn->error);
                    }

                    // Close the prepared statement
                    $stmt->close();
                } else {
                    throw new Exception('Error: File upload failed.');
                }
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;

        case 'edit_consultancy':
            try {
                $id = intval($_POST['id']);
                $stmt = $conn->prepare("SELECT * FROM consultancy WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $data = $result->fetch_assoc();
                    echo json_encode(['status' => 200, 'data' => $data]);
                } else {
                    echo json_encode(['status' => 500, 'message' => 'Consultancy not found.']);
                }

                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;

        case 'save_edit_consultancy':
            try {
                // Prepare the parameters
                $research_type = 'consultancy';
                $consultancy_id = mysqli_real_escape_string($conn, $_POST['edit_consultancy_id']);
                $consultancy_type = mysqli_real_escape_string($conn, $_POST['edit_consultancy_type']);
                $title = mysqli_real_escape_string($conn, $_POST['edit_consultancy_title']);
                $project_id = mysqli_real_escape_string($conn, $_POST['edit_project_id']);
                $funding_agency = mysqli_real_escape_string($conn, $_POST['edit_funding_agency']);
                $project_particulars = mysqli_real_escape_string($conn, $_POST['edit_project_particulars']);
                $web_link = mysqli_real_escape_string($conn, $_POST['edit_web_link']);
                $requested_amount = mysqli_real_escape_string($conn, $_POST['edit_requested_amount']);
                $status = mysqli_real_escape_string($conn, $_POST['edit_status']);
                $filing_date = mysqli_real_escape_string($conn, $_POST['edit_filing_date']);
                $granted_member = mysqli_real_escape_string($conn, $_POST['edit_granted_number']);
                $granted_amount = mysqli_real_escape_string($conn, $_POST['edit_granted_amount']);
                $from = mysqli_real_escape_string($conn, $_POST['edit_from']);
                $to = mysqli_real_escape_string($conn, $_POST['edit_to']);
                $funds_generated = mysqli_real_escape_string($conn, $_POST['edit_funds_generated']);
                $remarks = mysqli_real_escape_string($conn, $_POST['edit_remarks']);
                $no_of_members = mysqli_real_escape_string($conn, $_POST['edit_no_of_members']);
                
                $academic_year = mysqli_real_escape_string($conn, trim($_POST['academic_year']));

                // File upload handling
                $uploadDir = 'research/consultancy/';
                $fileName = basename($_FILES['edit_upload_files']['name']);
                $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Generate the new file name with staffid_datatime format
                $timestamp = date("Y-m-d_H-i-s");
                $newFileName = $s . '_' . $timestamp . '.' . $fileType;
                $filePath = $uploadDir . $newFileName;

                // Ensure the upload directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Validate file type (only allow certain file types)
                if (!in_array($fileType, ['pdf', 'docx', 'jpg', 'jpeg', 'png'])) {
                    throw new Exception('Invalid file type. Only PDF, DOCX, JPG, JPEG, PNG files are allowed.');
                }

                // Move the uploaded file
                if (move_uploaded_file($_FILES['edit_upload_files']['tmp_name'], $filePath)) {
                    // Prepare and bind the update query
                    $stmt = $conn->prepare("UPDATE `consultancy` SET  `staff_id` = ?, `staff_name` = ?, `department` = ?, `academic_year` = ?,`research_type` = ?,
                                        `consultancy_type` = ?, `title` = ?, `project_id` = ?, `funding_agency` = ?, `project_particulars` = ?, 
                                        `web_link` = ?, `requested_amount` = ?, `status` = ?, `number_of_members` = ?, `documents` = ?, 
                                        `filing_date` = ?, `granted_amount` = ?, `granted_member` = ?, `from` = ?, `to` = ?, 
                                        `funds_generated` = ?, `remarks` = ?, status1= 0 WHERE `id` = ?");

                    // Bind the parameters to the query
                    $stmt->bind_param(
                        "sssssssssssisissiissisi",

                        $s,
                        $fname,
                        $fdept,
                        $academic_year,
                        $research_type,

                        $consultancy_type,
                        $title,
                        $project_id,
                        $funding_agency,
                        $project_particulars,
                        $web_link,
                        $requested_amount,
                        $status,
                        $no_of_members,
                        $filePath,
                        $filing_date,
                        $granted_amount,
                        $granted_member,
                        $from,
                        $to,
                        $funds_generated,
                        $remarks,
                        $consultancy_id
                    );

                    // Execute the query and handle success/failure
                    if ($stmt->execute()) {
                        echo json_encode(['status' => 200, 'message' => 'Consultancy details updated successfully.']);
                    } else {
                        throw new Exception('Error: ' . $conn->error);
                    }

                    // Close the prepared statement
                    $stmt->close();
                } else {
                    throw new Exception('Error: File upload failed.');
                }
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;

        case 'delete_consultancy':
            try {
                $consultancy_id = mysqli_real_escape_string($conn, trim($_POST['id']));

                // Prepare and execute the DELETE query
                $stmt = $conn->prepare("DELETE FROM `consultancy` WHERE `id` = ?");
                $stmt->bind_param("i", $consultancy_id);

                if ($stmt->execute()) {
                    echo json_encode(['status' => 200, 'message' => 'Consultancy details deleted successfully.']);
                } else {
                    throw new Exception('Error: ' . $conn->error);
                }

                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;




        case 'save_iconsultancy':
            try {
                // Prepare the parameters
                $research_type = 'iconsultancy';
                
                $academic_year = mysqli_real_escape_string($conn, trim($_POST['academic_year']));
                $iconsultancy_type = mysqli_real_escape_string($conn, $_POST['iconsultancy_type']);
                $iconsultancy_title = mysqli_real_escape_string($conn, $_POST['iconsultancy_title']);
                $iconsultancy_particulars = mysqli_real_escape_string($conn, $_POST['iconsultancy_particulars']);
                $iconsultancy_particulars_work = mysqli_real_escape_string($conn, $_POST['iconsultancy_particulars_work']);
                $iconsultancy_web_link = mysqli_real_escape_string($conn, $_POST['iconsultancy_web_link']);
                $iconsultancy_mou = mysqli_real_escape_string($conn, $_POST['iconsultancy_mou']);
                $iconsultancy_author_count = mysqli_real_escape_string($conn, $_POST['iconsultancy_author_count']);
                $iconsultancy_requested_amount = mysqli_real_escape_string($conn, $_POST['iconsultancy_requested_amount']);
                $iconsultancy_status = mysqli_real_escape_string($conn, $_POST['iconsultancy_status']);
                $iconsultancy_filing_date = mysqli_real_escape_string($conn, $_POST['iconsultancy_filing_date']);
                $iconsultancy_granted_member = mysqli_real_escape_string($conn, $_POST['iconsultancy_granted_number']);
                $iconsultancy_granted_amount = mysqli_real_escape_string($conn, $_POST['iconsultancy_granted_amount']);
                $iconsultancy_from = mysqli_real_escape_string($conn, $_POST['iconsultancy_from']);
                $iconsultancy_to = mysqli_real_escape_string($conn, $_POST['iconsultancy_to']);
                $iconsultancy_funds_generated = mysqli_real_escape_string($conn, $_POST['iconsultancy_funds_generated']);
                $iconsultancy_remarks = mysqli_real_escape_string($conn, $_POST['iconsultancy_remarks']);


                // File upload handling
                $uploadDir = 'research/iconsultancy/';
                $fileName = basename($_FILES['iconsultancy_upload_files']['name']);
                $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Generate the new file name with staffid_datatime format
                $timestamp = date("Y-m-d_H-i-s");
                $newFileName = $s . '_' . $timestamp . '.' . $fileType;
                $filePath = $uploadDir . $newFileName;

                // Ensure the upload directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Validate file type (only allow certain file types)
                if (!in_array($fileType, ['pdf', 'docx', 'jpg', 'jpeg', 'png'])) {
                    throw new Exception('Invalid file type. Only PDF, DOCX, JPG, JPEG, PNG files are allowed.');
                }

                // Move the uploaded file
                if (move_uploaded_file($_FILES['iconsultancy_upload_files']['tmp_name'], $filePath)) {
                    // Prepare and bind the insert query

                    $stmt = $conn->prepare("INSERT INTO `industry_consultancy` 
                                            (`staff_id`, `staff_name`, `department`, `academic_year`, `research_type`,`iconsultancy_type`, `iconsultancy_title`, `iconsultancy_particulars`, 
                                            `iconsultancy_particulars_work`, `iconsultancy_web_link`, `iconsultancy_mou`,`iconsultancy_author_count`,`iconsultancy_documents`,
                                            `iconsultancy_requested_amount`, `iconsultancy_status`, `iconsultancy_filing_date`,`iconsultancy_granted_amount`, 
                                            `iconsultancy_granted_member`, `iconsultancy_from`, `iconsultancy_to`, `iconsultancy_funds_generated`, `iconsultancy_remarks`) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?, ?, ?)");



                    // Bind the parameters to the query
                    $stmt->bind_param(
                        "sssssssssssisississsis",
                        $s,
                        $fname,
                        $fdept,
                        $academic_year,
                        $research_type,
                        $iconsultancy_type,
                        $iconsultancy_title,
                        $iconsultancy_particulars,
                        $iconsultancy_particulars_work,
                        $iconsultancy_web_link,
                        $iconsultancy_mou,
                        $iconsultancy_author_count,
                        $filePath,
                        $iconsultancy_requested_amount,
                        $iconsultancy_status,
                        $iconsultancy_filing_date,
                        $iconsultancy_granted_amount,
                        $iconsultancy_granted_member,
                        $iconsultancy_from,
                        $iconsultancy_to,
                        $iconsultancy_funds_generated,
                        $iconsultancy_remarks

                    );

                    // Execute the query and handle success/failure
                    if ($stmt->execute()) {
                        echo json_encode(['status' => 200, 'message' => 'Industry Consultancy added successfully.']);
                    } else {
                        throw new Exception('Error: ' . $conn->error);
                    }

                    // Close the prepared statement
                    $stmt->close();
                } else {
                    throw new Exception('Error: File upload failed.');
                }
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;

        case 'edit_iconsultancy':
            try {
                $id = intval($_POST['id']);
                $stmt = $conn->prepare("SELECT * FROM `industry_consultancy` WHERE `id` = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $data = $result->fetch_assoc();
                    echo json_encode(['status' => 200, 'data' => $data]);
                } else {
                    throw new Exception('Record not found.');
                }
                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;

        case 'save_edit_iconsultancy':
            try {
                // Prepare the parameters
                $research_type = 'iconsultancy';
               
                $academic_year = mysqli_real_escape_string($conn, trim($_POST['academic_year']));

                $iconsultancy_id1 = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_id']);
                $iconsultancy_type1 = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_type']);
                $title1 = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_title']);
                $particulars1 = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_particulars']);
                $particulars_work1 = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_particulars_work']);
                $web_link1 = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_web_link']);
                $mou1 = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_mou']);
                $author_count = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_author_count']);
                $requested_amount = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_requested_amount']);
                $status = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_status']);
                $filing_date = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_filing_date']);
                $granted_member = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_granted_number']);
                $granted_amount = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_granted_amount']);
                $from = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_from']);
                $to = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_to']);
                $funds_generated = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_funds_generated']);
                $remarks = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_remarks']);
                $no_of_members = mysqli_real_escape_string($conn, $_POST['edit_iconsultancy_no_of_members']);

                // File upload handling
                $uploadDir = 'research/iconsultancy/';
                $fileName = basename($_FILES['edit_iconsultancy_upload_files']['name']);
                $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Generate the new file name with staffid_datatime format
                $timestamp = date("Y-m-d_H-i-s");
                $newFileName = $s . '_' . $timestamp . '.' . $fileType;
                $filePath1 = $uploadDir . $newFileName;

                // Ensure the upload directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Validate file type (only allow certain file types)
                if (!in_array($fileType, ['pdf', 'docx', 'jpg', 'jpeg', 'png'])) {
                    throw new Exception('Invalid file type. Only PDF, DOCX, JPG, JPEG, PNG files are allowed.');
                }

                // Move the uploaded file
                if (move_uploaded_file($_FILES['edit_iconsultancy_upload_files']['tmp_name'], $filePath1)) {
                    // Prepare and bind the update query
                    $stmt = $conn->prepare("UPDATE `industry_consultancy` SET 
                                                                `staff_id` = ?, `staff_name` = ?, `department` = ?, `academic_year` = ?, `research_type` = ?,`iconsultancy_type` = ?, `iconsultancy_title` = ?, `iconsultancy_particulars` = ?, 
                                                                `iconsultancy_particulars_work` = ?, `iconsultancy_web_link` = ?, `iconsultancy_mou` = ?, 
                                                                `iconsultancy_author_count` = ?, `iconsultancy_documents` = ?,  `iconsultancy_requested_amount` = ?, `iconsultancy_status` = ?,
                                        `iconsultancy_filing_date` = ?, `iconsultancy_granted_amount` = ?, `iconsultancy_granted_member` = ?, `iconsultancy_from` = ?, `iconsultancy_to` = ?, 
                                        `iconsultancy_funds_generated` = ?, `iconsultancy_remarks` = ?, istatus1 = 0
                                                                WHERE `id` = ?");

                    $stmt->bind_param(
                        "sssssssssisisisssisi",
                        $s,
                        $fname,
                        $fdept,
                        $academic_year,
                        $research_type,
                        $iconsultancy_type1,
                        $title1,
                        $particulars1,
                        $particulars_work1,
                        $web_link1,
                        $mou1,
                        $author_count,
                        $filePath1,
                        $iconsultancy_id1,
                        $requested_amount,
                        $status,
                        $filing_date,
                        $granted_amount,
                        $granted_member,
                        $from,
                        $to,
                        $funds_generated,
                        $remarks,
                        $iconsultancy_id

                    );

                    // Execute the query and handle success/failure
                    if ($stmt->execute()) {
                        echo json_encode(['status' => 200, 'message' => 'Industry Consultancy details updated successfully.']);
                    } else {
                        throw new Exception('Error: ' . $conn->error);
                    }

                    // Close the prepared statement
                    $stmt->close();
                } else {
                    throw new Exception('Error: File upload failed.');
                }
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }

            break;

        case 'delete_iconsultancy':
            try {
                $consultancy_id1 = mysqli_real_escape_string($conn, trim($_POST['id']));
                $stmt = $conn->prepare("DELETE FROM `industry_consultancy` WHERE `id` = ?");
                $stmt->bind_param("i", $consultancy_id1);

                if ($stmt->execute()) {
                    echo json_encode(['status' => 200, 'message' => 'Details deleted successfully.']);
                } else {
                    throw new Exception('Error: ' . $conn->error);
                }
                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;

        case 'save_r_guideship':
            try {
                $research_type = 'guideship';
               
                $academic_year = mysqli_real_escape_string($conn, trim($_POST['academic_year']));
                $universityname = mysqli_real_escape_string($conn, $_POST['universityname']);
                $faculty = mysqli_real_escape_string($conn, $_POST['faculty']);
                $supervisorstatus = mysqli_real_escape_string($conn, $_POST['supervisorstatus']);
                $supervisorapprovalno = mysqli_real_escape_string($conn, $_POST['supervisorapprovalno']);
                $referencenumber = mysqli_real_escape_string($conn, $_POST['referencenumber']);


                // File upload handling
                $uploadDir = 'research/rguideship/';
                $fileName = basename($_FILES['r_guideship_pdf']['name']);
                $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Generate the new file name with staffid_datatime format
                $timestamp = date("Y-m-d_H-i-s");
                $newFileName = $s . '_' . $timestamp . '.' . $fileType;
                $filePath = $uploadDir . $newFileName;

                // Ensure the upload directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Validate file type (only allow certain file types)
                if (!in_array($fileType, ['pdf', 'docx'])) {
                    throw new Exception('Invalid file type. Only PDF and DOCX files are allowed.');
                }

                // Move the uploaded file
                if (move_uploaded_file($_FILES['r_guideship_pdf']['tmp_name'], $filePath)) {
                    // Prepare and bind the insert query
                    $stmt = $conn->prepare("INSERT INTO `researchguideship` 
                                                        ( `staff_id`, `staff_name`, `department`, `academic_year`, `research_type`,`universityname`, `faculty`, `supervisorstatus`, 
                                                        `supervisorapprovalno`, `referencenumber`, `r_guideship_pdf`) 
                                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                    $stmt->bind_param(
                        "sssssssssss",
                        $s,
                        $fname,
                        $fdept,
                        $academic_year,
                        $research_type,
                        $universityname,
                        $faculty,
                        $supervisorstatus,
                        $supervisorapprovalno,
                        $referencenumber,
                        $filePath
                    );

                    // Execute the query and handle success/failure
                    if ($stmt->execute()) {
                        echo json_encode(['status' => 200, 'message' => 'Research guideship saved successfully.']);
                    } else {
                        throw new Exception('Database error: ' . $conn->error);
                    }

                    // Close the prepared statement
                    $stmt->close();
                } else {
                    throw new Exception('File upload failed.');
                }
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }

            break;
        case 'delete_r_guideship':
            try {
                $r_guideship_id = mysqli_real_escape_string($conn, trim($_POST['id']));
                $stmt = $conn->prepare("DELETE FROM researchguideship WHERE id = ?");
                $stmt->bind_param("i", $r_guideship_id);

                if ($stmt->execute()) {
                    echo json_encode(['status' => 200, 'message' => 'Details Deleted Successfully.']);
                } else {
                    throw new Exception('Database error: ' . $conn->error);
                }

                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;

        case 'edit_r_guideship':
            try {
                $user_id = mysqli_real_escape_string($conn, trim($_POST['id']));
                $stmt = $conn->prepare("SELECT * FROM researchguideship WHERE id = ?");
                $stmt->bind_param("i", $user_id);

                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($data = $result->fetch_assoc()) {
                        echo json_encode(['status' => 200, 'data' => $data]);
                    } else {
                        echo json_encode(['status' => 404, 'message' => 'No data found for the provided ID.']);
                    }
                } else {
                    throw new Exception('Database error: ' . $conn->error);
                }

                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;

        case 'save_edit_r_guideship':
            try {
                // Prepare the parameters
                $research_type = 'guideship';
                $id = $_POST['id'];
              
                $academic_year = mysqli_real_escape_string($conn, trim($_POST['academic_year']));
                $universityname = mysqli_real_escape_string($conn, $_POST['universityname']);
                $faculty = mysqli_real_escape_string($conn, $_POST['faculty']);
                $supervisorstatus = mysqli_real_escape_string($conn, $_POST['supervisorstatus']);
                $supervisorapprovalno = mysqli_real_escape_string($conn, $_POST['supervisorapprovalno']);
                $referencenumber = mysqli_real_escape_string($conn, $_POST['referencenumber']);
             

                // File upload handling
                $uploadDir = 'research/rguideship/';
                $filePath = null;

                // Check if the file is uploaded
                if (!empty($_FILES['r_guideship_pdf']['name'])) {
                    $fileName = basename($_FILES['r_guideship_pdf']['name']);
                    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                    // Generate the new file name with staffid_datatime format
                    $timestamp = date("Y-m-d_H-i-s");
                    $newFileName = $s . '_' . $timestamp . '.' . $fileType;
                    $filePath = $uploadDir . $newFileName;

                    // Ensure the upload directory exists
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    // Validate file type (only allow certain file types)
                    if (!in_array($fileType, ['pdf', 'docx'])) {
                        throw new Exception('Invalid file type. Only PDF and DOCX files are allowed.');
                    }

                    // Move the uploaded file
                    if (!move_uploaded_file($_FILES['r_guideship_pdf']['tmp_name'], $filePath)) {
                        throw new Exception('File upload failed.');
                    }
                }

                // Prepare the SQL query
                $query = "UPDATE researchguideship SET `staff_id` = ?, `staff_name` = ?, `department` = ?, `academic_year` = ?, `research_type`= ?, universityname = ?, faculty = ?, supervisorstatus = ?, supervisorapprovalno = ?, referencenumber = ? , status_no=0";

                // If a file was uploaded, add it to the query
                if ($filePath) {
                    $query .= ", r_guideship_pdf = ?";
                }

                $query .= " WHERE id = ?";

                // Prepare and bind the query
                $stmt = $conn->prepare($query);

                if ($filePath) {
                    $stmt->bind_param(
                        "sssssssssssi",
                        $s,
                        $fname,
                        $fdept,
                        $academic_year,
                        $research_type,
                        $universityname,
                        $faculty,
                        $supervisorstatus,
                        $supervisorapprovalno,
                        $referencenumber,
                        $filePath,
                        $id
                    );
                } else {
                    $stmt->bind_param(
                        "ssssssssssi",
                        $s,
                    $fname,
                    $fdept,
                        $academic_year,
                        $research_type,
                        $universityname,
                        $faculty,
                        $supervisorstatus,
                        $supervisorapprovalno,
                        $referencenumber,
                        $id
                    );
                }

                // Execute the query and handle success/failure
                if ($stmt->execute()) {
                    echo json_encode(['status' => 200, 'message' => 'Details updated successfully.']);
                } else {
                    throw new Exception('Database error: ' . $conn->error);
                }

                // Close the prepared statement
                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }

            break;

        case 'save_researchGuidance':
            try {
                $research_type = 'guidance';
               
                $academic_year = mysqli_real_escape_string($conn, trim($_POST['academic_year']));
                $university_name = mysqli_real_escape_string($conn, $_POST['university_name']);
                $no_of_scholars = mysqli_real_escape_string($conn, $_POST['noofscholars']);

                $names = array_map(function ($name) use ($conn) {
                    return mysqli_real_escape_string($conn, $name);
                }, $_POST['name']);

                $regnos = array_map(function ($regno) use ($conn) {
                    return mysqli_real_escape_string($conn, $regno);
                }, $_POST['regno']);

                $depts = array_map(function ($dept) use ($conn) {
                    return mysqli_real_escape_string($conn, $dept);
                }, $_POST['dept']);

                $colleges = array_map(function ($college) use ($conn) {
                    return mysqli_real_escape_string($conn, $college);
                }, $_POST['clg']);

                $domains = array_map(function ($domain) use ($conn) {
                    return mysqli_real_escape_string($conn, $domain);
                }, $_POST['domain']);

                $dates = array_map(function ($date) use ($conn) {
                    return mysqli_real_escape_string($conn, $date);
                }, $_POST['date']);

                $time_modes = array_map(function ($time_mode) use ($conn) {
                    return mysqli_real_escape_string($conn, $time_mode);
                }, $_POST['time_mode']);

                $roles = array_map(function ($role) use ($conn) {
                    return mysqli_real_escape_string($conn, $role);
                }, $_POST['role']);

                $statuses = array_map(function ($status) use ($conn) {
                    return mysqli_real_escape_string($conn, $status);
                }, $_POST['status']);

                $uploadDir = 'research/rguidance/';
              
                $fileExtension = strtolower(pathinfo($_FILES['pdf1']['name'], PATHINFO_EXTENSION));
                $fileName = $s . '_' . date('Ymd_His') . '.' . $fileExtension;
                $filePath = $uploadDir . $fileName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (!empty($_FILES['pdf1']['name']) && move_uploaded_file($_FILES['pdf1']['tmp_name'], $filePath)) {

                    try {
                        $stmt = $conn->prepare("INSERT INTO research_guidance (`staff_id`, `staff_name`, `department`, `academic_year`, `research_type`, university_name, no_of_scholars, research_pdf) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param(
                            "ssssssss",
                            $s,
                            $fname,
                            $fdept,
                            $academic_year,
                            $research_type,
                            $university_name,
                            $no_of_scholars,
                            $filePath
                        );

                        if (!$stmt->execute()) {
                            throw new Exception('Database error: ' . $stmt->error);
                        }

                        $guidance_id = $conn->insert_id;
                        $stmt->close();

                        $stmt = $conn->prepare("INSERT INTO scholar_details (guidance_id, name, regno, dept, college, domain, date, time_mode, role, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        for ($i = 0; $i < count($names); $i++) {
                            $stmt->bind_param(
                                "isssssssss",
                                $guidance_id,
                                $names[$i],
                                $regnos[$i],
                                $depts[$i],
                                $colleges[$i],
                                $domains[$i],
                                $dates[$i],
                                $time_modes[$i],
                                $roles[$i],
                                $statuses[$i]
                            );

                            if (!$stmt->execute()) {
                                throw new Exception('Database error: ' . $stmt->error);
                            }
                        }
                        $stmt->close();


                        echo json_encode(['status' => 200, 'message' => 'Research guidance details saved successfully.']);
                    } catch (Exception $e) {

                        throw $e;
                    }
                } else {
                    echo json_encode(['status' => 500, 'message' => 'File upload failed.']);
                }
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }

            break;

        case 'delete_researchGuidance':
            try {
                $guidance_id = mysqli_real_escape_string($conn, trim($_POST['id']));
                $stmt = $conn->prepare("DELETE FROM research_guidance WHERE guidance_id = ?");
                $stmt->bind_param("i", $guidance_id);

                if ($stmt->execute()) {
                    echo json_encode(['status' => 200, 'message' => 'Details deleted successfully.']);
                } else {
                    throw new Exception('Failed to delete details.');
                }
                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;

        case 'edit_researchGuidance':
            try {
                $user_id = mysqli_real_escape_string($conn, trim($_POST['id']));

                $stmt = $conn->prepare("SELECT * FROM research_guidance WHERE guidance_id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $guidance_data = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                $stmt = $conn->prepare("SELECT * FROM scholar_details WHERE guidance_id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $scholars_data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                echo json_encode(['status' => 200, 'data' => ['guidance' => $guidance_data, 'scholars' => $scholars_data]]);
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;

        case 'save_editResearchGuidance':
            try {
                // Sanitize guidance_id (assuming it's an integer)
                $research_type = 'guidance';
                $guidance_id = filter_var($_POST['guidance_id'], FILTER_VALIDATE_INT);

                // Sanitize university_name (string)
                $university_name = mysqli_real_escape_string($conn, $_POST['university_name']);

                // Sanitize no_of_scholars (integer)
                $no_of_scholars = filter_var($_POST['noofscholars'], FILTER_VALIDATE_INT);

                // Sanitize arrays with default empty array if not set
                $names = array_map(function ($name) use ($conn) {
                    return mysqli_real_escape_string($conn, $name);
                }, $_POST['name'] ?? []);

                $regnos = array_map(function ($regno) {
                    return filter_var($regno, FILTER_SANITIZE_STRING);
                }, $_POST['regno'] ?? []);

                $depts = array_map(function ($dept) use ($conn) {
                    return mysqli_real_escape_string($conn, $dept);
                }, $_POST['dept'] ?? []);

                $colleges = array_map(function ($college) use ($conn) {
                    return mysqli_real_escape_string($conn, $college);
                }, $_POST['clg'] ?? []);

                $domains = array_map(function ($domain) use ($conn) {
                    return mysqli_real_escape_string($conn, $domain);
                }, $_POST['domain'] ?? []);

                $dates = array_map(function ($date) {
                    // Assuming date format is 'Y-m-d' (e.g., 2024-12-30)
                    return DateTime::createFromFormat('Y-m-d', $date) ? $date : null;
                }, $_POST['date'] ?? []);

                $time_modes = array_map(function ($time_mode) use ($conn) {
                    return mysqli_real_escape_string($conn, $time_mode);
                }, $_POST['time_mode'] ?? []);

                $roles = array_map(function ($role) use ($conn) {
                    return mysqli_real_escape_string($conn, $role);
                }, $_POST['role'] ?? []);

                $statuses = array_map(function ($status) {
                    return filter_var($status, FILTER_SANITIZE_STRING);
                }, $_POST['status'] ?? []);


                $uploadDir = 'research/rguidance/';
             
                $fileExtension = strtolower(pathinfo($_FILES['pdf1']['name'], PATHINFO_EXTENSION));
                $fileName = $s . '_' . date('Ymd_His') . '.' . $fileExtension; // Generate file name with staffid_datewithtime format
                $filePath = $uploadDir . $fileName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Move the uploaded file
                if (!empty($_FILES['pdf1']['name']) && !move_uploaded_file($_FILES['pdf1']['tmp_name'], $filePath)) {
                    throw new Exception('File upload failed.');
                }


                try {
                    $stmt = $conn->prepare("UPDATE research_guidance SET `staff_id` = ?, `staff_name` = ?, `department` = ?, `academic_year` = ?, `research_type` = ?, university_name = ?, no_of_scholars = ?, research_pdf = ?, status_no=0 WHERE guidance_id = ?");
                    $stmt->bind_param(
                        "ssssssssi",
                        $s,
                    $fname,
                    $fdept,
                        $academic_year,
                        $research_type,
                        $university_name,
                        $no_of_scholars,
                        $filePath,
                        $guidance_id
                    );

                    if (!$stmt->execute()) {
                        throw new Exception('Database error: ' . $stmt->error);
                    }
                    $stmt->close();

                    $stmt = $conn->prepare("DELETE FROM scholar_details WHERE guidance_id = ?");
                    $stmt->bind_param("i", $guidance_id);
                    $stmt->execute();
                    $stmt->close();

                    $stmt = $conn->prepare("INSERT INTO scholar_details (guidance_id, name, regno, dept, college, domain, date, time_mode, role, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    for ($i = 0; $i < count($names); $i++) {
                        $stmt->bind_param(
                            "isssssssss",
                            $guidance_id,
                            $names[$i],
                            $regnos[$i],
                            $depts[$i],
                            $colleges[$i],
                            $domains[$i],
                            $dates[$i],
                            $time_modes[$i],
                            $roles[$i],
                            $statuses[$i]
                        );

                        if (!$stmt->execute()) {
                            throw new Exception('Database error: ' . $stmt->error);
                        }
                    }
                    $stmt->close();


                    echo json_encode(['status' => 200, 'message' => 'Research guidance updated successfully.']);
                } catch (Exception $e) {

                    throw $e;
                }
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;



        case 'save_certificate':
            try {
                // Sanitize input fields
                $research_type = 'certificate';
                
                $academic_year = mysqli_real_escape_string($conn, $_POST['academic_year']);
                $certification_type = mysqli_real_escape_string($conn, $_POST['event_type']);
                $certification_name = mysqli_real_escape_string($conn, $_POST['event_name']);
                $certification_duration = mysqli_real_escape_string($conn, $_POST['certification_duration']);
               

                $uploadDir = 'research/certification/';
                $certificate_document = null;

                // Handle file upload
                if (!empty($_FILES['certificate_document']['name'])) {
                    // Generate file name using staffid_datewithtime format
                    $fileExtension = strtolower(pathinfo($_FILES['certificate_document']['name'], PATHINFO_EXTENSION));
                    $fileName = $s . '_' . date('Ymd_His') . '.' . $fileExtension;
                    $filePath = $uploadDir . $fileName;

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    // Validate file type
                    if (!in_array($fileExtension, ['pdf', 'jpg', 'jpeg', 'png'])) {
                        throw new Exception('Invalid file type. Only PDF, JPG, JPEG, and PNG files are allowed.');
                    }

                    // Validate file size (2 MB limit)
                    if ($_FILES['certificate_document']['size'] > 2 * 1024 * 1024) {
                        throw new Exception('File size should be less than 2 MB.');
                    }

                    // Move uploaded file
                    if (!move_uploaded_file($_FILES['certificate_document']['tmp_name'], $filePath)) {
                        throw new Exception('File upload failed.');
                    }

                    $certificate_document = $filePath;
                }

                // Prepare the SQL query
                $stmt = $conn->prepare(
                    "INSERT INTO certifications 
                    (staff_id, staff_name, department, academic_year, research_type, event_type, event_name, certification_duration, certificate_document) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
                );
                $stmt->bind_param(
                    "sssssssss",
                    $s,
                    $fname,
                    $fdept,
                    $academic_year,
                    $research_type,
                    $certification_type,
                    $certification_name,
                    $certification_duration,
                    $certificate_document
                );

                if ($stmt->execute()) {
                    echo json_encode(['status' => 200, 'message' => 'Certification details saved successfully.']);
                } else {
                    throw new Exception('Database error: ' . $conn->error);
                }

                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }

            break;

        case 'delete_certificate':
            try {
                $certificate_id = mysqli_real_escape_string($conn, trim($_POST['id']));

                $stmt = $conn->prepare("DELETE FROM certifications WHERE id = ?");
                $stmt->bind_param("i", $certificate_id);

                if ($stmt->execute()) {
                    echo json_encode(['status' => 200, 'message' => 'Details deleted successfully.']);
                } else {
                    throw new Exception('Details not deleted: ' . $conn->error);
                }

                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;

        case 'edit_certificate':
            try {
                $id = mysqli_real_escape_string($conn, trim($_POST['id']));

                $stmt = $conn->prepare("SELECT * FROM certifications WHERE id = ?");
                $stmt->bind_param("i", $id);

                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    $data = $result->fetch_assoc();
                    echo json_encode(['status' => 200, 'data' => $data]);
                } else {
                    throw new Exception('Database query failed.');
                }

                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            break;

        case 'save_editcertificate':
            try {
                // Sanitize input fields
                $research_type = 'certificate';
                $id = mysqli_real_escape_string($conn, $_POST['id']);                
                $research_type = "certificate";
                $academic_year = mysqli_real_escape_string($conn, trim($_POST['academic_year']));
                $certification_type = mysqli_real_escape_string($conn, $_POST['event_type']);
                $certification_name = mysqli_real_escape_string($conn, $_POST['event_name']);
                $certification_duration = mysqli_real_escape_string($conn, $_POST['certification_duration']);
              
                $certificate_document = null;

                $uploadDir = 'research/certification/';
                if (!empty($_FILES['certificate_document']['name'])) {
                    // Generate file name using staffid_datewithtime format
                    $fileExtension = strtolower(pathinfo($_FILES['certificate_document']['name'], PATHINFO_EXTENSION));
                    $fileName = $s . '_' . date('Ymd_His') . '.' . $fileExtension;
                    $filePath = $uploadDir . $fileName;

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    // Validate file type
                    if (!in_array($fileExtension, ['pdf', 'jpg', 'jpeg', 'png'])) {
                        throw new Exception('Invalid file type. Only PDF, JPG, JPEG, and PNG files are allowed.');
                    }

                    // Validate file size (2 MB limit)
                    if ($_FILES['certificate_document']['size'] > 2 * 1024 * 1024) {
                        throw new Exception('File size should be less than 2 MB.');
                    }

                    // Move uploaded file
                    if (!move_uploaded_file($_FILES['certificate_document']['tmp_name'], $filePath)) {
                        throw new Exception('File upload failed.');
                    }

                    $certificate_document = $filePath;
                }

                // Prepare the SQL query
                $query = "UPDATE certifications SET staff_id = ?, 
                            staff_name = ?, 
                            department = ?, 
                            academic_year = ?,
                            research_type = ?,
                            event_type = ?, 
                            event_name = ?, 
                            certification_duration = ?, 
                            status = 0";

                if ($certificate_document) {
                    $query .= ", certificate_document = ?";
                }

                $query .= " WHERE id = ?";

                $stmt = $conn->prepare($query);

                if ($certificate_document) {
                    $stmt->bind_param(
                        "sssssssssi",
                        $s,
                        $fname,
                        $fdept,
                        $academic_year,
                        $research_type,
                        $certification_type,
                        $certification_name,
                        $certification_duration,
                        $certificate_document,
                        $id
                    );
                } else {
                    $stmt->bind_param(
                        "ssssssssi",
                        $s,
                        $fname,
                        $fdept,
                        $academic_year,
                        $research_type,
                        $certification_type,
                        $certification_name,
                        $certification_duration,
                        $id
                    );
                }

                if ($stmt->execute()) {
                    echo json_encode(['status' => 200, 'message' => 'Certification details updated successfully.']);
                } else {
                    throw new Exception('Database error: ' . $conn->error);
                }

                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }

            break;


        default:
            echo json_encode(['status' => 400, 'message' => 'Invalid action']);
            break;
    }



    ?>