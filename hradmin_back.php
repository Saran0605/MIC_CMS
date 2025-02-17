<?php
require 'config.php';
require 'session.php';
date_default_timezone_set('Asia/Kolkata');
ini_set('error_log', 'error.log');

$sourceDBConfig = [
    "host" => "10.0.1.17",
    "port" => 3306,
    "user" => "john",
    "password" => "password",
    "database" => "epushserver"
];

//   $targetDBConfig = [
//     "host" => "localhost",
//     "port" => 3306,
//     "user" => "root",
//     "password" => "",
//     "database" => "erp_attendance"
//   ];

//   $micDBConfig = [
//     "host" => "localhost",
//     "port" => 3306,
//     "user" => "root",
//     "password" => "",
//     "database" => "mic"
//   ];

$sourceConnection = mysqli_connect(
    $sourceDBConfig["host"],
    $sourceDBConfig["user"],
    $sourceDBConfig["password"],
    $sourceDBConfig["database"],
    $sourceDBConfig["port"]
);

//   $targetConnection = mysqli_connect(
//     $targetDBConfig["host"],
//     $targetDBConfig["user"],
//     $targetDBConfig["password"],
//     $targetDBConfig["database"],
//     $targetDBConfig["port"]
//   );

//   $micConnection = mysqli_connect(
//     $micDBConfig["host"],
//     $micDBConfig["user"],
//     $micDBConfig["password"],
//     $micDBConfig["database"],
//     $micDBConfig["port"]
//   );

$action = $_GET['action'] ?? ($_POST['action'] ?? '');

switch ($action) {

    case 'get_dash_data':

        try {
            // Get total faculty count
            $query = "SELECT COUNT(*) as count FROM faculty";
            $result = mysqli_query($db, $query);
            $tf = mysqli_fetch_assoc($result)['count'] ?? 0;

            // Get department counts
            $departments = [
                'aids' => 'Artificial Intelligence and Data Science',
                'aiml' => 'Artificial Intelligence and Machine Learning',
                'civil' => 'Civil Engineering',
                'csbs' => 'Computer Science and Business Systems',
                'cse' => 'Computer Science and Engineering',
                'eee' => 'Electrical and Electronics Engineering',
                'eev' => 'Electronics Engineering (VLSI Design)',
                'ece' => 'Electronics and Communication Engineering',
                'it' => 'Information Technology',
                'mech' => 'Mechanical Engineering',
                'mba' => 'Master of Business Administration',
                'mca' => 'Master of Computer Applications',
                'sh' => 'Freshman Engineering'
            ];

            $dept_counts = [];
            foreach ($departments as $key => $dept) {
                $dept_counts[$key] = getDepartmentCount($db, $dept);
            }

            // Get gender counts
            $male = getGenderCount($db, 'Male');
            $female = getGenderCount($db, 'Female');

            $response = [
                'name' => $s,
                'total_faculty' => $tf,
                'departments' => $dept_counts,
                'gender' => [
                    'male' => $male,
                    'female' => $female,
                    'others' => 0
                ]
            ];

        } catch (Exception $e) {
            error_log("Error occurred during fetch: " . $e->getMessage());
            $response = [
                'status' => 500,
                'message' => 'Internal server error'
            ];
        } finally {
            $db->close();
        }
        echo json_encode($response);
        break;


    case 'get_leave_balance_details':

        try {
            // Now fetch the main data
            $stmt = $db->prepare("SELECT * FROM faculty WHERE status = ? ");
            $status = 1;
            $stmt->bind_param("i", $status);
            $stmt->execute();
            $result = $stmt->get_result();
            $userData = [];
            while ($row = $result->fetch_assoc()) {
                $userData[] = $row;
            }
            $stmt->close();

            if (count($userData) > 0) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Fetching successful',
                    'data' => $userData
                ];
            } else {
                error_log("Data fetching failed");
                $response = [
                    'status' => 401,
                    'message' => 'No Data Found..'
                ];
            }

        } catch (Exception $e) {
            error_log("Error occurred during fetch: " . $e->getMessage());
            $response = [
                'status' => 500,
                'message' => 'Internal server error'
            ];
        } finally {
            $db->close();
        }
        echo json_encode($response);
        break;


    case 'assign_all_leave_details':

        // $uid = $s;
        // $faculty = getFacultyInfo($uid);
        // $fdept = $faculty->ddept;
        $ltype = mysqli_real_escape_string($db, $_POST['ltype']);
        $days = mysqli_real_escape_string($db, $_POST['days']);
        try {
            // Start transaction
            $db->begin_transaction();

            // Update fleave table
            $stmt = $db->prepare("UPDATE faculty SET {$ltype} = ? WHERE status = ?");
            $status = 1;
            $stmt->bind_param("ii", $days, $status);
            $result = $stmt->execute();

            if ($result) {
                // Commit transaction
                $db->commit();
                $stmt->close();
                $db->close();

                $response = ["status" => 200, "message" => "Assigned successfully"];
            } else {
                // Rollback transaction
                $db->rollback();
                $stmt->close();
                $db->close();

                $response = ["status" => 401, "message" => "failed"];
            }
        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during approval: " . $e->getMessage());
            $response = array("status" => 500, "message" => "Internal server error");
        }

        echo json_encode($response);
        break;


    case 'assign_spec_leave_details':

        // $uid = $s;
        // $faculty = getFacultyInfo($uid);
        // $fdept = $faculty->ddept;
        $ltype = mysqli_real_escape_string($db, $_POST['ltype']);
        $uid = mysqli_real_escape_string($db, $_POST['uid']);
        $days = mysqli_real_escape_string($db, $_POST['days']);
        try {
            // Start transaction
            $db->begin_transaction();

            // Update fleave table
            $stmt = $db->prepare("UPDATE faculty SET {$ltype} = ? WHERE status = ? and id = ? ");
            $status = 1;
            $stmt->bind_param("iis", $days, $status, $uid);
            $result = $stmt->execute();

            if ($result) {
                // Commit transaction
                $db->commit();
                $stmt->close();
                $db->close();

                $response = ["status" => 200, "message" => "Assigned successfully"];
            } else {
                // Rollback transaction
                $db->rollback();
                $stmt->close();
                $db->close();

                $response = ["status" => 401, "message" => "failed"];
            }
        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during approval: " . $e->getMessage());
            $response = array("status" => 500, "message" => "Internal server error");
        }

        echo json_encode($response);
        break;

    case 'reset_leave_details':
        $adays = 0;
        // $uid = $s;
        // $faculty = getFacultyInfo($uid);
        // $fdept = $faculty->ddept;

        try {
            // Start transaction
            $db->begin_transaction();

            // Update fleave table
            $stmt = $db->prepare("UPDATE faculty SET 
                        cl = ?, 
                        col = ?, 
                        odb = ?, 
                        odr = ?, 
                        odp = ?, 
                        odo = ?, 
                        vl = ?, 
                        ml = ?, 
                        mal = ?, 
                        mtl = ?, 
                        ptl = ?, 
                        sl = ?, 
                        spl = ?, 
                        pm = ?, 
                        tenpm = ? where status = ? ");
            $status = 1;
            $stmt->bind_param("iiiiiiiiiiiiiiii", $adays, $adays, $adays, $adays, $adays, $adays, $adays, $adays, $adays, $adays, $adays, $adays, $adays, $adays, $adays, $status);
            $result = $stmt->execute();

            if ($result) {
                // Commit transaction
                $db->commit();
                $stmt->close();
                $db->close();

                $response = ["status" => 200, "message" => "Reset successfully"];
            } else {
                // Rollback transaction
                $db->rollback();
                $stmt->close();
                $db->close();

                $response = ["status" => 401, "message" => "failed"];
            }
        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during approval: " . $e->getMessage());
            $response = array("status" => 500, "message" => "Internal server error");
        }

        echo json_encode($response);
        break;

    case 'get_holiday_details':

        try {
            // Start transaction
            $db->begin_transaction();

            // Update fleave table
            $stmt = mysqli_prepare($db, "SELECT * FROM fholiday");
            mysqli_stmt_execute($stmt);

            // Get result
            $result = mysqli_stmt_get_result($stmt);
            $userData = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if (count($userData) > 0) {
                $response = array(
                    "status" => 200,
                    "message" => "Data Fetching successful",
                    "data" => $userData
                );
            } else {
                error_log("Data fetching failed");
                $response = array(
                    "status" => 401,
                    "message" => "Data Fetching failed"
                );
            }
        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during approval: " . $e->getMessage());
            $response = array("status" => 500, "message" => "Internal server error");
        }

        echo json_encode($response);
        break;


    case 'get_leave_details':

        try {
            // Start transaction
            $db->begin_transaction();

            // Update fleave table
            $stmt = mysqli_prepare($db, "SELECT * FROM fholiday ORDER BY id DESC");
            mysqli_stmt_execute($stmt);

            // Get result
            $result = mysqli_stmt_get_result($stmt);
            $userData = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if (count($userData) > 0) {
                $response = array(
                    "status" => 200,
                    "message" => "Data Fetching successful",
                    "data" => $userData
                );
            } else {
                error_log("Data fetching failed");
                $response = array(
                    "status" => 401,
                    "message" => "Data Fetching failed"
                );
            }
        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during approval: " . $e->getMessage());
            $response = array("status" => 500, "message" => "Internal server error");
        }

        echo json_encode($response);
        break;


    case 'assign_sunday_leave':
        try {
            // Start transaction
            $db->begin_transaction();

            // Get sunday dates from POST
            $sundayDates = isset($_POST['dates']) ? $_POST['dates'] : [];

            if (empty($sundayDates)) {
                throw new Exception("No dates provided");
            }

            // Function to convert date format
            function convertDateToISO($dateString)
            {
                $parts = explode("/", $dateString);
                return $parts[2] . "-" . $parts[1] . "-" . $parts[0];
            }

            // Insert into fholiday table
            $stmt = mysqli_prepare($db, "INSERT INTO fholiday (hdate, days, type, who) VALUES (?, ?, ?, ?)");

            // Define these variables outside the loop for binding
            $days = 'Sunday';
            $type = 'Week-Off';
            $who = 'ALL';

            foreach ($sundayDates as $date) {
                // URL decode the date if needed
                $dateValue = urldecode($date);

                mysqli_stmt_bind_param(
                    $stmt,
                    'ssss',
                    $dateValue,
                    $days,
                    $type,
                    $who
                );

                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Error inserting into fholiday: " . mysqli_error($db));
                }
            }

            // Update devicelogs tables
            foreach ($sundayDates as $date) {
                $dateValue = urldecode($date);
                $isoDate = convertDateToISO($dateValue);
                $dateParts = explode("-", $isoDate);
                $tableName = "devicelogs_" . $dateParts[1] . "_" . $dateParts[0];

                // Check if table exists
                $tableCheck = mysqli_query($erp_conn, "SHOW TABLES LIKE '$tableName'");
                if (mysqli_num_rows($tableCheck) > 0) {
                    $updateStmt = mysqli_prepare(
                        $erp_conn,
                        "UPDATE $tableName SET hday = 1, ltype = ?, who = ? WHERE tdate = ?"
                    );

                    // Define variables for binding
                    $leaveType = 'Week-Off';
                    $leaveWho = 'ALL';

                    mysqli_stmt_bind_param(
                        $updateStmt,
                        'sss',
                        $leaveType,
                        $leaveWho,
                        $isoDate
                    );

                    if (!mysqli_stmt_execute($updateStmt)) {
                        throw new Exception("Error updating $tableName: " . mysqli_error($db));
                    }

                    mysqli_stmt_close($updateStmt);
                }
            }

            // Commit transaction
            $db->commit();

            $response = array(
                "status" => 200,
                "message" => "Sunday Holidays Added"
            );

        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during Sunday leave assignment: " . $e->getMessage());

            $response = array(
                "status" => 401,
                "message" => "Sunday Holidays Already Added"
            );
        } finally {
            if (isset($stmt)) {
                mysqli_stmt_close($stmt);
            }
        }

        echo json_encode($response);
        break;



    case 'delete_leave_details':
        try {
            // Start transaction
            $db->begin_transaction();

            // Get parameters
            $uid = isset($_POST['uid']) ? $_POST['uid'] : null;
            $hdate = isset($_POST['hdate']) ? $_POST['hdate'] : null;

            if (!$uid || !$hdate) {
                throw new Exception("Missing required parameters");
            }

            // Function to convert date format
            function convertDateToISO($dateString)
            {
                $parts = explode("/", $dateString);
                return $parts[2] . "-" . $parts[1] . "-" . $parts[0];
            }

            $formattedDate = convertDateToISO($hdate);

            // Delete from fholiday table
            $stmt = mysqli_prepare($db, "DELETE FROM fholiday WHERE id = ?");

            mysqli_stmt_bind_param($stmt, 'i', $uid);

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Error deleting from fholiday: " . mysqli_error($db));
            }

            // Check if any rows were affected
            if (mysqli_affected_rows($db) > 0) {
                // Get month and year from the formatted date
                $dateObj = new DateTime($formattedDate);
                $month = $dateObj->format('m');
                $year = $dateObj->format('Y');

                $tableName = "devicelogs_" . $month . "_" . $year;

                // Check if table exists
                $tableCheck = mysqli_query($erp_conn, "SHOW TABLES LIKE '$tableName'");
                if (mysqli_num_rows($tableCheck) > 0) {
                    $updateStmt = mysqli_prepare(
                        $erp_conn,
                        "UPDATE $tableName SET hday = 0, ltype = NULL, who = NULL WHERE tdate = ?"
                    );

                    mysqli_stmt_bind_param($updateStmt, 's', $formattedDate);

                    if (!mysqli_stmt_execute($updateStmt)) {
                        throw new Exception("Error updating $tableName: " . mysqli_error($db));
                    }

                    mysqli_stmt_close($updateStmt);
                }

                // Commit transaction
                $db->commit();

                $response = array(
                    "status" => 200,
                    "message" => "Deleted successfully"
                );
            } else {
                throw new Exception("No records found to delete");
            }

        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during deletion: " . $e->getMessage());

            if ($e->getMessage() == "No records found to delete") {
                $response = array(
                    "status" => 401,
                    "message" => "Deletion failed"
                );
            } else {
                $response = array(
                    "status" => 500,
                    "message" => "Internal server error"
                );
            }
        } finally {
            if (isset($stmt)) {
                mysqli_stmt_close($stmt);
            }
        }

        echo json_encode($response);
        break;


    case 'assign_longleave':
        try {
            // Start transaction
            $db->begin_transaction();

            // Get form data
            $ltype = $_POST['ltype'] ?? null;
            $fDate = $_POST['fdate'] ?? null;
            $tDate = $_POST['tdate'] ?? null;
            $leaveFor = $_POST['leaveFor'] ?? null;

            if (!$ltype || !$fDate || !$tDate || !$leaveFor) {
                throw new Exception("Missing required parameters");
            }

            // Generate array of dates between start and end date
            $dates = [];
            $startDate = new DateTime($fDate);
            $endDate = new DateTime($tDate);
            $interval = new DateInterval('P1D'); // 1 day interval
            $dateRange = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

            foreach ($dateRange as $date) {
                // Format dates
                $formattedDate = $date->format('j/n/Y'); // d/m/yyyy without leading zeros
                $formattedDate2 = $date->format('Y-m-d'); // yyyy-mm-dd
                $dayOfWeek = $date->format('l'); // Full day name

                $dates[] = [
                    'date' => $formattedDate,
                    'mdate' => $formattedDate2,
                    'days' => $dayOfWeek,
                    'type' => $ltype,
                    'who' => $leaveFor
                ];
            }

            // Prepare statement for fholiday table
            $holidayStmt = mysqli_prepare(
                $db,
                "INSERT INTO fholiday (hdate, days, type, who) VALUES (?, ?, ?, ?)"
            );

            foreach ($dates as $date) {
                // Insert into fholiday table
                mysqli_stmt_bind_param(
                    $holidayStmt,
                    'ssss',
                    $date['date'],
                    $date['days'],
                    $date['type'],
                    $date['who']
                );

                if (!mysqli_stmt_execute($holidayStmt)) {
                    throw new Exception("Error inserting into fholiday: " . mysqli_error($db));
                }

                // Update devicelogs table
                $dateObj = new DateTime($date['mdate']);
                $month = $dateObj->format('m');
                $year = $dateObj->format('Y');
                $tableName = "devicelogs_" . $month . "_" . $year;

                // Check if table exists
                $tableCheck = mysqli_query($erp_conn, "SHOW TABLES LIKE '$tableName'");
                if (mysqli_num_rows($tableCheck) > 0) {
                    $updateStmt = mysqli_prepare(
                        $erp_conn,
                        "UPDATE $tableName SET hday = 1, ltype = ?, who = ? WHERE tdate = ?"
                    );

                    mysqli_stmt_bind_param(
                        $updateStmt,
                        'sss',
                        $date['type'],
                        $date['who'],
                        $date['mdate']
                    );

                    if (!mysqli_stmt_execute($updateStmt)) {
                        throw new Exception("Error updating $tableName: " . mysqli_error($db));
                    }

                    mysqli_stmt_close($updateStmt);
                }
            }

            // Commit transaction
            $db->commit();

            $response = array(
                "status" => 200,
                "message" => "Long Leave Added"
            );

        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during long leave assignment: " . $e->getMessage());

            $response = array(
                "status" => 500,
                "message" => "Error adding long leave"
            );
        } finally {
            if (isset($holidayStmt)) {
                mysqli_stmt_close($holidayStmt);
            }
        }

        echo json_encode($response);
        break;


    case 'assign_dateleave':
        try {
            // Start transaction
            $db->begin_transaction();

            // Get parameters
            $formattedClickedDate = $_POST['sdate'] ?? null;
            $leaveType = $_POST['leaveType'] ?? null;
            $leaveFor = $_POST['leaveFor'] ?? null;
            $dayOfWeek = $_POST['dayOfWeek'] ?? null;

            if (!$formattedClickedDate || !$leaveType || !$leaveFor || !$dayOfWeek) {
                throw new Exception("Missing required parameters");
            }

            // Function to convert date format
            function convertDateToISO($dateString)
            {
                $parts = explode("/", $dateString);
                return $parts[2] . "-" . $parts[1] . "-" . $parts[0];
            }

            $formattedDate = convertDateToISO($formattedClickedDate);

            // Insert into fholiday table
            $stmt = mysqli_prepare(
                $db,
                "INSERT INTO fholiday (hdate, days, type, who) VALUES (?, ?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                'ssss',
                $formattedClickedDate,
                $dayOfWeek,
                $leaveType,
                $leaveFor
            );

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Error inserting into fholiday: " . mysqli_error($db));
            }

            // Check if insert was successful
            if (mysqli_affected_rows($db) > 0) {
                // Get month and year for devicelogs table
                $dateObj = new DateTime($formattedDate);
                $month = $dateObj->format('m');
                $year = $dateObj->format('Y');

                $tableName = "devicelogs_" . $month . "_" . $year;

                // Check if table exists
                $tableCheck = mysqli_query($erp_conn, "SHOW TABLES LIKE '$tableName'");
                if (mysqli_num_rows($tableCheck) > 0) {
                    $updateStmt = mysqli_prepare(
                        $erp_conn,
                        "UPDATE $tableName SET hday = 1, ltype = ?, who = ? WHERE tdate = ?"
                    );

                    mysqli_stmt_bind_param(
                        $updateStmt,
                        'sss',
                        $leaveType,
                        $leaveFor,
                        $formattedDate
                    );

                    if (!mysqli_stmt_execute($updateStmt)) {
                        throw new Exception("Error updating $tableName: " . mysqli_error($db));
                    }

                    mysqli_stmt_close($updateStmt);
                }

                // Commit transaction
                $db->commit();

                $response = array(
                    "status" => 200,
                    "message" => "Leave Marked successfully."
                );
            } else {
                throw new Exception("Failed to insert leave record");
            }

        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error marking leave: " . $e->getMessage());

            if ($e->getMessage() == "Failed to insert leave record") {
                $response = array(
                    "status" => 401,
                    "message" => "Leave Marking Failed."
                );
            } else {
                $response = array(
                    "status" => 500,
                    "message" => "Internal server error"
                );
            }
        } finally {
            if (isset($stmt)) {
                mysqli_stmt_close($stmt);
            }
        }

        echo json_encode($response);
        break;

    case 'generate_report':

        $month = $_POST['month'] ?? '';
        $year = $_POST['year'] ?? '';

        try {

            $tableNameDeviceLog = "devicelogs_{$month}_{$year}";
            $reports = [];

            // Get distinct UIDs
            $distinctUidsQuery = "SELECT DISTINCT uid FROM `" . $erp_conn->real_escape_string($tableNameDeviceLog) . "`";
            $distinctUidsResult = $erp_conn->query($distinctUidsQuery);

            if (!$distinctUidsResult) {
                throw new Exception("Error fetching distinct UIDs: " . $erp_conn->error);
            }

            while ($row = $distinctUidsResult->fetch_assoc()) {
                $uname = $row['uid'];

                // Get device log data
                $deviceLogQuery = "SELECT * FROM `" . $erp_conn->real_escape_string($tableNameDeviceLog) . "` WHERE uid = ? AND hday = 0";
                $stmt = $erp_conn->prepare($deviceLogQuery);
                $stmt->bind_param("s", $uname);
                $stmt->execute();
                $deviceLogData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                // Get holiday data
                $holidayQuery = "SELECT * FROM `" . $erp_conn->real_escape_string($tableNameDeviceLog) . "` WHERE uid = ? AND hday = 1";
                $stmt = $erp_conn->prepare($holidayQuery);
                $stmt->bind_param("s", $uname);
                $stmt->execute();
                $holidayData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                // Get faculty name and role
                $fNameQuery = "SELECT fname, role FROM `" . $erp_conn->real_escape_string($tableNameDeviceLog) . "` WHERE uid = ? LIMIT 1";
                $stmt = $erp_conn->prepare($fNameQuery);
                $stmt->bind_param("s", $uname);
                $stmt->execute();
                $fNameResults = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                $facultyName = $fNameResults['fname'] ?? null;
                $facultyRole = $fNameResults['role'] ?? null;

                if (!$facultyName) {
                    error_log("No data found for the provided uid: " . $uname);
                }

                // Get LOP data
                $currentDate = date('Y-m-d');
                $lopQuery = "SELECT lc, status, COUNT(*) as count 
                                    FROM `" . $erp_conn->real_escape_string($tableNameDeviceLog) . "` 
                                    WHERE uid = ? 
                                    AND status IN (0, 2) 
                                    AND hday = 0 
                                    AND lc <= 0.5 
                                    AND mpu = 0
                                    AND tdate <= ?
                                    GROUP BY lc, status";

                $stmt = $erp_conn->prepare($lopQuery);
                $stmt->bind_param("ss", $uname, $currentDate);
                $stmt->execute();
                $lopData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                // Calculate LOP
                $totalLOP = 0;
                foreach ($lopData as $record) {
                    if ($record['status'] == 0 && $record['lc'] == 0) {
                        $totalLOP += $record['count']; // Full day absences
                    } else if ($record['status'] == 2 || ($record['status'] == 0 && $record['lc'] == 0.5)) {
                        $totalLOP += $record['count'] * 0.5; // Half day absences
                    }
                }

                // Get present data
                $presentQuery = "SELECT lc,mpu, status, COUNT(*) as count 
                                       FROM `" . $erp_conn->real_escape_string($tableNameDeviceLog) . "` 
                                       WHERE uid = ? 
                                       AND (status = 1 OR status = 2 OR lc > 0 OR mpu > 0)
                                       GROUP BY status";

                $stmt = $erp_conn->prepare($presentQuery);
                $stmt->bind_param("s", $uname);
                $stmt->execute();
                $presentData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                // Calculate total presence
                $totalPresence = 0;
                foreach ($presentData as $record) {
                    if ($record['status'] == 1 || $record['lc'] > 0.5 || $record['mpu'] > 0) {
                        $totalPresence += $record['count']; // Full day presence
                    } else if ($record['status'] == 2 || $record['lc'] == 0.5) {
                        $totalPresence += $record['count'] * 0.5; // Half day presence
                    }
                }

                $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $totalWorkingDays = count($deviceLogData);
                $totalHolidays = count($holidayData);
                $totalPresentdays = $totalPresence;
                $totalLopdays = $totalLOP;
                $salaryDay = $totalWorkingDays + $totalHolidays - $totalLopdays;

                $report = [
                    'uid' => $uname,
                    'facultyName' => $facultyName,
                    'facultyRole' => $facultyRole,
                    'totalDays' => $totalDays,
                    'totalWorkingDays' => $totalWorkingDays,
                    'totalHolidays' => $totalHolidays,
                    'totalPresentdays' => $totalPresentdays,
                    'totalLopdays' => $totalLopdays,
                    'salaryDay' => $salaryDay
                ];

                $reports[] = $report;
            }

            $response = [
                'status' => 200,
                'message' => 'Data Fetching successful',
                'data' => $reports
            ];

        } catch (Exception $error) {
            error_log("Error generating report: " . $error->getMessage());
            $response = [
                'status' => 500,
                'message' => 'Failed to generate report'
            ];
        } finally {
            if ($erp_conn) {
                $erp_conn->close();
            }
        }

        echo json_encode($response);
        break;

    case 'report_validation':

        $month = $_POST['month'] ?? '';
        $year = $_POST['year'] ?? '';

        try {
            if ($month) {

                fetchDataFromSource($month, $year, $sourceConnection, $erp_conn, $db);
                $response = ['status' => 200, 'message' => 'Validated'];
            } else {
                $response = ['status' => 401, 'message' => 'Validation failed.'];
            }

        } catch (Exception $error) {
            error_log("Error generating report: " . $error->getMessage());
            $response = [
                'status' => 500,
                'message' => 'Failed to generate report'
            ];
        }
        echo json_encode($response);
        break;


    case 'multipunch_data':

        $id = $_POST['uid'] ?? '';
        $mdate = $_POST['mdate'] ?? '';

        $year = explode("-", $mdate)[0];
        $month = explode("-", $mdate)[1];
        $formattedMonth = intval($month);
        $tableName = "devicelogs_" . $formattedMonth . "_" . $year;

        try {
            $sql = "SELECT LogDate FROM $tableName WHERE UserId = ? AND DATE(LogDate) = ?";
            $stmt = mysqli_prepare($sourceConnection, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $id, $mdate);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($results) > 0) {
                $punchTimings = [];
                while ($row = mysqli_fetch_assoc($results)) {
                    $punchTimings[] = $row["LogDate"];
                }
                $response = ["status" => 200, "message" => "Punch timings found", "data" => $punchTimings];
            } else {
                $response = ["status" => 404, "message" => "No punch timings found for the given date"];
            }
        } catch (Exception $e) {
            echo "Error fetching punch timings: " . $e->getMessage();
            throw $e;
        }

        echo json_encode($response);
        break;


    case 'shift_change':

        $mdate = $_POST['sdate'] ?? '';
        $sin = $_POST['sin'] ?? '';
        $sout = $_POST['sout'] ?? '';

        $year = explode("-", $mdate)[0];
        $month = explode("-", $mdate)[1];
        $formattedMonth = intval($month);
        $tableName = "devicelogs_" . $formattedMonth . "_" . $year;

        try {
            $sql = "UPDATE $tableName SET shiftin = ?, shiftout = ? WHERE tdate = ?";
            $stmt = mysqli_prepare($erp_conn, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $sin, $sout, $mdate);
            mysqli_stmt_execute($stmt);

            if (mysqli_affected_rows($erp_conn) > 0) {
                $response = ["status" => 200, "message" => "Manual Shift updated successfully"];
            } else {
                $response = ["status" => 401, "message" => "Failed to update manual shift"];
            }
        } catch (Exception $e) {
            echo "Error updating manual shift: " . $e->getMessage();
            throw $e;
        }

        echo json_encode($response);
        break;

    case 'manualpunch_data':

        $id = $_POST['uid'] ?? '';
        $mdate = $_POST['mdate'] ?? '';

        $year = explode("-", $mdate)[0];
        $month = explode("-", $mdate)[1];
        $formattedMonth = intval($month);
        $tableName = "devicelogs_" . $formattedMonth . "_" . $year;

        try {
            $sql = "UPDATE $tableName SET mpu = 1 WHERE uid = ? AND tdate = ?";
            $stmt = mysqli_prepare($erp_conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $id, $mdate);
            mysqli_stmt_execute($stmt);

            if (mysqli_affected_rows($erp_conn) > 0) {
                $response = ["status" => 200, "message" => "Manual punch updated successfully"];
            } else {
                $response = ["status" => 401, "message" => "Failed to update manual punch"];
            }
        } catch (Exception $e) {
            echo "Error updating manual punch: " . $e->getMessage();
            throw $e;
        }
        echo json_encode($response);
        break;


    case 'get_CL_leave_details':

        try {
            // Now fetch the main data
            $stmt = $db->prepare("SELECT * FROM fleave WHERE status = ? AND manager = ?");
            $status = 1;
            $manager = "HOD";
            $stmt->bind_param("is", $status, $manager);
            $stmt->execute();
            $result = $stmt->get_result();
            $userData = [];
            while ($row = $result->fetch_assoc()) {
                $userData[] = $row;
            }
            $stmt->close();

            if (count($userData) > 0) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Fetching successful',
                    'data' => $userData
                ];
            } else {
                error_log("Data fetching failed");
                $response = [
                    'status' => 401,
                    'message' => 'Data Fetching failed'
                ];
            }

        } catch (Exception $e) {
            error_log("Error occurred during fetch: " . $e->getMessage());
            $response = [
                'status' => 500,
                'message' => 'Internal server error'
            ];
        } finally {
            $db->close();
        }
        echo json_encode($response);
        break;


    case 'approve_leave':
        $leaveid = mysqli_real_escape_string($db, $_POST['id']);
        $uid = mysqli_real_escape_string($db, $_POST['uid']);
        $ltype = mysqli_real_escape_string($db, $_POST['ltype']);
        $fdate = mysqli_real_escape_string($db, $_POST['fdate']);
        $tdate = mysqli_real_escape_string($db, $_POST['tdate']);
        $fshift = mysqli_real_escape_string($db, $_POST['fshift']);
        $tshift = mysqli_real_escape_string($db, $_POST['tshift']);

        try {
            // Start transaction
            $db->begin_transaction();

            // Update fleave table
            $stmt = $db->prepare("UPDATE fleave SET status = 2 WHERE id = ?");
            $stmt->bind_param("i", $leaveid);
            $result = $stmt->execute();

            if ($result) {
                // If update successful, update attendance records
                updateAttendanceRecords($uid, $fdate, $tdate, $fshift, $tshift, $ltype);

                // Commit transaction
                $db->commit();
                $stmt->close();
                $db->close();

                $response = ["status" => 200, "message" => "Forwarded successfully"];
            } else {
                // Rollback transaction
                $db->rollback();
                $stmt->close();
                $db->close();

                $response = ["status" => 401, "message" => "failed"];
            }
        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during approval: " . $e->getMessage());
            $response = array("status" => 500, "message" => "Internal server error");
        }

        echo json_encode($response);
        break;

    case 'reject_leave':
        $leaveid = mysqli_real_escape_string($db, $_POST['id']);
        $uid = mysqli_real_escape_string($db, $_POST['uid']);
        $ltype = mysqli_real_escape_string($db, $_POST['ltype']);
        $fdate = mysqli_real_escape_string($db, $_POST['fdate']);
        $tdate = mysqli_real_escape_string($db, $_POST['tdate']);
        $fshift = mysqli_real_escape_string($db, $_POST['fshift']);
        $tshift = mysqli_real_escape_string($db, $_POST['tshift']);
        $tdays = mysqli_real_escape_string($db, $_POST['tdays']);

        try {
            // Start transaction
            $db->begin_transaction();
            $faculty = getFacultyInfo($uid);

            $leaveTypes = [
                "Casual Leave" => ["field" => "cl", "type" => "cl"],
                "Compensation Leave" => ["field" => "col", "type" => "col"],
                "Vacation Leave" => ["field" => "vl", "type" => "vl"],
                "Medical Leave" => ["field" => "ml", "type" => "ml"],
                "Marriage Leave" => ["field" => "mal", "type" => "mal"],
                "Maternity Leave" => ["field" => "mtl", "type" => "mtl"],
                "Paternity Leave" => ["field" => "ptl", "type" => "ptl"],
                "Study Leave" => ["field" => "sl", "type" => "sl"],
                "Special Leave" => ["field" => "spl", "type" => "spl"]
            ];

            $leaveInfo = $leaveTypes[$ltype];
            $field = $leaveInfo['field'];
            $currentLeaveBalance = $faculty->$field;
            $updatedLeaveBalance = $currentLeaveBalance + $tdays;
            // Update fleave table
            $stmt = $db->prepare("UPDATE fleave SET status = 3 WHERE id = ?");
            $stmt->bind_param("i", $leaveid);
            $result = $stmt->execute();

            if ($result) {

                $stmt = $db->prepare("UPDATE faculty SET {$leaveInfo['type']} = ? WHERE id = ?");
                $stmt->bind_param("ds", $updatedLeaveBalance, $uid);
                $stmt->execute();
                $stmt->close();
                // If update successful, update attendance records
                updateAttendanceRecords($uid, $fdate, $tdate, $fshift, $tshift, $ltype, true);

                // Commit transaction
                $db->commit();
                $stmt->close();
                $db->close();

                $response = ["status" => 200, "message" => "Rejected successfully"];
            } else {
                // Rollback transaction
                $db->rollback();
                $stmt->close();
                $db->close();

                $response = ["status" => 401, "message" => "failed"];
            }
        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during approval: " . $e->getMessage());
            $response = array("status" => 500, "message" => "Internal server error");
        }

        echo json_encode($response);
        break;

    case 'get_OD_details':

        try {
            // Now fetch the main data
            $stmt = $db->prepare("SELECT * FROM fonduty WHERE status = ? AND manager = ?");
            $status = 1;
            $manager = "HOD";
            $stmt->bind_param("is", $status, $manager);
            $stmt->execute();
            $result = $stmt->get_result();
            $userData = [];
            while ($row = $result->fetch_assoc()) {
                $userData[] = $row;
            }
            $stmt->close();

            if (count($userData) > 0) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Fetching successful',
                    'data' => $userData
                ];
            } else {
                error_log("Data fetching failed");
                $response = [
                    'status' => 401,
                    'message' => 'Data Fetching failed'
                ];
            }

        } catch (Exception $e) {
            error_log("Error occurred during fetch: " . $e->getMessage());
            $response = [
                'status' => 500,
                'message' => 'Internal server error'
            ];
        } finally {
            $db->close();
        }
        echo json_encode($response);
        break;



    case 'approve_OD':
        $leaveid = mysqli_real_escape_string($db, $_POST['id']);
        $uid = mysqli_real_escape_string($db, $_POST['uid']);
        $otype = mysqli_real_escape_string($db, $_POST['otype']);
        $fdate = mysqli_real_escape_string($db, $_POST['fdate']);
        $tdate = mysqli_real_escape_string($db, $_POST['tdate']);
        $fshift = mysqli_real_escape_string($db, $_POST['fshift']);
        $tshift = mysqli_real_escape_string($db, $_POST['tshift']);

        try {
            // Start transaction
            $db->begin_transaction();

            // Update fleave table
            $stmt = $db->prepare("UPDATE fonduty SET status = 2 WHERE id = ?");
            $stmt->bind_param("i", $leaveid);
            $result = $stmt->execute();

            if ($result) {
                // If update successful, update attendance records
                updateAttendanceRecords($uid, $fdate, $tdate, $fshift, $tshift, $otype);

                // Commit transaction
                $db->commit();
                $stmt->close();
                $db->close();

                $response = ["status" => 200, "message" => "Forwarded successfully"];
            } else {
                // Rollback transaction
                $db->rollback();
                $stmt->close();
                $db->close();

                $response = ["status" => 401, "message" => "failed"];
            }
        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during approval: " . $e->getMessage());
            $response = array("status" => 500, "message" => "Internal server error");
        }

        echo json_encode($response);
        break;

    case 'reject_OD':
        $leaveid = mysqli_real_escape_string($db, $_POST['id']);
        $uid = mysqli_real_escape_string($db, $_POST['uid']);
        $otype = mysqli_real_escape_string($db, $_POST['otype']);
        $fdate = mysqli_real_escape_string($db, $_POST['fdate']);
        $tdate = mysqli_real_escape_string($db, $_POST['tdate']);
        $fshift = mysqli_real_escape_string($db, $_POST['fshift']);
        $tshift = mysqli_real_escape_string($db, $_POST['tshift']);
        $tdays = mysqli_real_escape_string($db, $_POST['tdays']);

        try {
            // Start transaction
            $db->begin_transaction();
            $faculty = getFacultyInfo($uid);

            $leaveTypes = [
                "OnDuty Basic" => ["field" => "odb", "type" => "odb"],
                "On Duty Research" => ["field" => "odr", "type" => "odr"],
                "On Duty Professional" => ["field" => "odp", "type" => "odp"],
                "On Duty Outreach" => ["field" => "odo", "type" => "odo"]
            ];

            $leaveInfo = $leaveTypes[$otype];
            $field = $leaveInfo['field'];
            $currentLeaveBalance = $faculty->$field;
            $updatedLeaveBalance = $currentLeaveBalance + $tdays;
            // Update fleave table
            $stmt = $db->prepare("UPDATE fonduty SET status = 3 WHERE id = ?");
            $stmt->bind_param("i", $leaveid);
            $result = $stmt->execute();

            if ($result) {

                $stmt = $db->prepare("UPDATE faculty SET {$leaveInfo['type']} = ? WHERE id = ?");
                $stmt->bind_param("ds", $updatedLeaveBalance, $uid);
                $stmt->execute();
                $stmt->close();
                // If update successful, update attendance records
                updateAttendanceRecords($uid, $fdate, $tdate, $fshift, $tshift, $otype, true);

                // Commit transaction
                $db->commit();
                // $stmt->close();
                $db->close();

                $response = ["status" => 200, "message" => "Rejected successfully"];
            } else {
                // Rollback transaction
                $db->rollback();
                $stmt->close();
                $db->close();

                $response = ["status" => 401, "message" => "failed"];
            }
        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during approval: " . $e->getMessage());
            $response = array("status" => 500, "message" => "Internal server error");
        }

        echo json_encode($response);
        break;


    case 'get_PER_details':

        try {
            // Now fetch the main data
            $stmt = $db->prepare("SELECT * FROM fpermission WHERE status = ? AND manager = ?");
            $status = 1;
            $manager = "HOD";
            $stmt->bind_param("is", $status, $manager);
            $stmt->execute();
            $result = $stmt->get_result();
            $userData = [];
            while ($row = $result->fetch_assoc()) {
                $userData[] = $row;
            }
            $stmt->close();

            if (count($userData) > 0) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Fetching successful',
                    'data' => $userData
                ];
            } else {
                error_log("Data fetching failed");
                $response = [
                    'status' => 401,
                    'message' => 'Data Fetching failed'
                ];
            }

        } catch (Exception $e) {
            error_log("Error occurred during fetch: " . $e->getMessage());
            $response = [
                'status' => 500,
                'message' => 'Internal server error'
            ];
        } finally {
            $db->close();
        }
        echo json_encode($response);
        break;


    case 'approve_PER':
        $leaveid = mysqli_real_escape_string($db, $_POST['id']);
        $uid = mysqli_real_escape_string($db, $_POST['uid']);
        $ltype = mysqli_real_escape_string($db, $_POST['ltype']);
        $fdate = mysqli_real_escape_string($db, $_POST['fdate']);


        try {
            // Start transaction
            $db->begin_transaction();

            // Update fleave table
            $stmt = $db->prepare("UPDATE fpermission SET status = 2 WHERE id = ?");
            $stmt->bind_param("i", $leaveid);
            $result = $stmt->execute();

            if ($result) {
                // If update successful, update attendance records
                updatePermissionRecords($uid, $fdate, $ltype);

                // Commit transaction
                $db->commit();
                $stmt->close();
                $db->close();

                $response = ["status" => 200, "message" => "Forwarded successfully"];
            } else {
                // Rollback transaction
                $db->rollback();
                $stmt->close();
                $db->close();

                $response = ["status" => 401, "message" => "failed"];
            }
        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during approval: " . $e->getMessage());
            $response = array("status" => 500, "message" => "Internal server error");
        }

        echo json_encode($response);
        break;

    case 'reject_PER':
        $leaveid = mysqli_real_escape_string($db, $_POST['id']);
        $uid = mysqli_real_escape_string($db, $_POST['uid']);
        $ltype = mysqli_real_escape_string($db, $_POST['ltype']);
        $fdate = mysqli_real_escape_string($db, $_POST['fdate']);


        try {
            // Start transaction
            $db->begin_transaction();
            $faculty = getFacultyInfo($uid);

            $leaveTypes = [
                "Morning" => ["field" => "pm", "type" => "pm"],
                "Evening" => ["field" => "pm", "type" => "pm"],
                "10minM" => ["field" => "tenpm", "type" => "tenpm"],
                "10minE" => ["field" => "tenpm", "type" => "tenpm"]
            ];

            $leaveInfo = $leaveTypes[$ltype];
            $field = $leaveInfo['field'];
            $currentLeaveBalance = $faculty->$field;
            $updatedLeaveBalance = $currentLeaveBalance + 1;
            // Update fleave table
            $stmt = $db->prepare("UPDATE fpermission SET status = 3 WHERE id = ?");
            $stmt->bind_param("i", $leaveid);
            $result = $stmt->execute();

            if ($result) {

                $stmt = $db->prepare("UPDATE faculty SET {$leaveInfo['type']} = ? WHERE id = ?");
                $stmt->bind_param("ds", $updatedLeaveBalance, $uid);
                $stmt->execute();
                $stmt->close();
                // If update successful, update attendance records
                updatePermissionRecords($uid, $fdate, $ltype, true);

                // Commit transaction
                $db->commit();
                // $stmt->close();
                $db->close();

                $response = ["status" => 200, "message" => "Rejected successfully"];
            } else {
                // Rollback transaction
                $db->rollback();
                $stmt->close();
                $db->close();

                $response = ["status" => 401, "message" => "failed"];
            }
        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during approval: " . $e->getMessage());
            $response = array("status" => 500, "message" => "Internal server error");
        }

        echo json_encode($response);
        break;

    case 'get_Col_details':


        try {
            // Now fetch the main data
            $stmt = $db->prepare("SELECT * FROM fcolreq WHERE status = ? AND manager = ?");
            $status = 1;
            $manager = "HOD";
            $stmt->bind_param("is", $status, $manager);
            $stmt->execute();
            $result = $stmt->get_result();
            $userData = [];
            while ($row = $result->fetch_assoc()) {
                $userData[] = $row;
            }
            $stmt->close();

            if (count($userData) > 0) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Fetching successful',
                    'data' => $userData
                ];
            } else {
                error_log("Data fetching failed");
                $response = [
                    'status' => 401,
                    'message' => 'Data Fetching failed'
                ];
            }

        } catch (Exception $e) {
            error_log("Error occurred during fetch: " . $e->getMessage());
            $response = [
                'status' => 500,
                'message' => 'Internal server error'
            ];
        } finally {
            $db->close();
        }
        echo json_encode($response);
        break;

        case 'approve_COL':
            $leaveid = mysqli_real_escape_string($db, $_POST['id']);
            $uid = mysqli_real_escape_string($db, $_POST['uid']);
            
            try {
                // Start transaction
                $db->begin_transaction();
                
                // Update fcolreq table
                $stmt = $db->prepare("UPDATE fcolreq SET status = 2 WHERE id = ?");
                $stmt->bind_param("i", $leaveid);
                $result = $stmt->execute();
                $stmt->close();
                
                if ($result) {
                    // Get leave request details
                    $stmt = $db->prepare("SELECT days FROM fcolreq WHERE id = ?");
                    $stmt->bind_param("i", $leaveid);
                    $stmt->execute();
                    $leaveResult = $stmt->get_result();
                    $leaveData = $leaveResult->fetch_assoc();
                    $stmt->close();
                    
                    // Get faculty information using existing function
                    $faculty = getFacultyInfo($uid);
                    
                    // Calculate new COL balance
                    $newColDays = $faculty->col + $leaveData['days'];
                    
                    // Update faculty COL balance
                    $stmt = $db->prepare("UPDATE faculty SET col = ? WHERE id = ?");
                    $stmt->bind_param("ds", $newColDays, $uid);
                    $updateResult = $stmt->execute();
                    $stmt->close();
                    
                    if ($updateResult) {
                        // Commit transaction
                        $db->commit();
                        $response = ["status" => 200, "message" => "Accepted"];
                    } else {
                        // Rollback transaction
                        $db->rollback();
                        $response = ["status" => 401, "message" => "Failed to update faculty COL balance"];
                    }
                } else {
                    // Rollback transaction
                    $db->rollback();
                    $response = ["status" => 401, "message" => "Failed to update leave status"];
                }
                
            } catch (Exception $e) {
                // Rollback transaction
                $db->rollback();
                error_log("Error occurred during approval: " . $e->getMessage());
                $response = ["status" => 500, "message" => "Internal server error"];
            } finally {
                // Close database connection
                $db->close();
            }
            
            echo json_encode($response);
            break;

    case 'reject_COL':
        $leaveid = mysqli_real_escape_string($db, $_POST['id']);
        $uid = mysqli_real_escape_string($db, $_POST['uid']);
        try {
            // Start transaction
            $db->begin_transaction();

            // Update fleave table
            $stmt = $db->prepare("UPDATE fcolreq SET status = 3 WHERE id = ?");
            $stmt->bind_param("i", $leaveid);
            $result = $stmt->execute();

            if ($result) {
                // Commit transaction
                $db->commit();
                $stmt->close();
                $db->close();

                $response = ["status" => 200, "message" => "Rejected successfully"];
            } else {
                // Rollback transaction
                $db->rollback();
                $stmt->close();
                $db->close();

                $response = ["status" => 401, "message" => "failed"];
            }
        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during approval: " . $e->getMessage());
            $response = array("status" => 500, "message" => "Internal server error");
        }

        echo json_encode($response);
        break;

    case 'get_ODR_details':


        try {
            // Now fetch the main data
            $stmt = $db->prepare("SELECT * FROM fondutyreq WHERE status = ? AND manager = ?");
            $status = 1;
            $manager = "HOD";
            $stmt->bind_param("is", $status, $manager);
            $stmt->execute();
            $result = $stmt->get_result();
            $userData = [];
            while ($row = $result->fetch_assoc()) {
                $userData[] = $row;
            }
            $stmt->close();

            if (count($userData) > 0) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Fetching successful',
                    'data' => $userData
                ];
            } else {
                error_log("Data fetching failed");
                $response = [
                    'status' => 401,
                    'message' => 'Data Fetching failed'
                ];
            }

        } catch (Exception $e) {
            error_log("Error occurred during fetch: " . $e->getMessage());
            $response = [
                'status' => 500,
                'message' => 'Internal server error'
            ];
        } finally {
            $db->close();
        }
        echo json_encode($response);
        break;

    case 'approve_ODR':
        $leaveid = mysqli_real_escape_string($db, $_POST['id']);
        $uid = mysqli_real_escape_string($db, $_POST['uid']);
        try {
            // Start transaction
            $db->begin_transaction();

            // Update fleave table
            $stmt = $db->prepare("UPDATE fondutyreq SET status = 2 WHERE id = ?");
            $stmt->bind_param("i", $leaveid);
            $result = $stmt->execute();

            if ($result) {
                // Commit transaction
                $db->commit();
                $stmt->close();
                $db->close();

                $response = ["status" => 200, "message" => "Forwarded successfully"];
            } else {
                // Rollback transaction
                $db->rollback();
                $stmt->close();
                $db->close();

                $response = ["status" => 401, "message" => "failed"];
            }
        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during approval: " . $e->getMessage());
            $response = array("status" => 500, "message" => "Internal server error");
        }

        echo json_encode($response);
        break;

    case 'reject_ODR':
        $leaveid = mysqli_real_escape_string($db, $_POST['id']);
        $uid = mysqli_real_escape_string($db, $_POST['uid']);
        try {
            // Start transaction
            $db->begin_transaction();

            // Update fleave table
            $stmt = $db->prepare("UPDATE fondutyreq SET status = 3 WHERE id = ?");
            $stmt->bind_param("i", $leaveid);
            $result = $stmt->execute();

            if ($result) {
                // Commit transaction
                $db->commit();
                $stmt->close();
                $db->close();

                $response = ["status" => 200, "message" => "Rejected successfully"];
            } else {
                // Rollback transaction
                $db->rollback();
                $stmt->close();
                $db->close();

                $response = ["status" => 401, "message" => "failed"];
            }
        } catch (Exception $e) {
            // Rollback transaction
            $db->rollback();
            error_log("Error occurred during approval: " . $e->getMessage());
            $response = array("status" => 500, "message" => "Internal server error");
        }

        echo json_encode($response);
        break;

    case 'get_areport_details':
        $month = $_POST['month'] ?? '';
        $year = $_POST['year'] ?? '';

        $uname = $s; // Assuming this function exists
        if (!$uname) {
            return ["status" => 401, "message" => "Unauthorized"];
        }

        $tableName = "devicelogs_{$month}_{$year}";

        // Assuming this function exists and returns object with ddept property
        // $faculty = getFacultyInfo($uname);
        // $ddept = $faculty->ddept;

        // Create erp_conn
        //$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($erp_conn->connect_error) {
            return ["status" => 500, "message" => "Database erp_conn failed"];
        }

        try {
            $sql = "
                SELECT d.uid, d.fname, d.tdate, d.in_time, d.out_time, d.status, 
                       d.hday, d.lc, d.mp, d.mpu
                FROM " . $tableName . " d
                JOIN mic.faculty f ON d.uid = f.id
                WHERE f.manager = 'HOD'
                ORDER BY d.uid ASC, d.tdate ASC
            ";

            $stmt = $erp_conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $erp_conn->error);
            }

            // $stmt->bind_param("s", $ddept);

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $employeeAttendance = [];

                while ($log = $result->fetch_assoc()) {
                    $uid = $log['uid'];
                    $tdate = new DateTime($log['tdate']);
                    $day = (int) $tdate->format('d');

                    $status = getStatusAbbreviation(
                        $log['status'],
                        $log['hday'],
                        $log['lc'],
                        $log['mpu'],
                        $log['mp'],
                        $tdate,
                        $log['in_time'],
                        $log['out_time']
                    );

                    $employeeFound = false;
                    foreach ($employeeAttendance as &$employee) {
                        if ($employee['uid'] === $uid) {
                            $employee['attendance'][$day - 1] = [
                                'status' => $status,
                                'in_time' => $log['in_time'],
                                'out_time' => $log['out_time']
                            ];
                            $employeeFound = true;
                            break;
                        }
                    }

                    if (!$employeeFound) {
                        $newEmployee = [
                            'uid' => $uid,
                            'name' => $log['fname'],
                            'attendance' => array_fill(0, 31, [
                                'status' => '-',
                                'in_time' => null,
                                'out_time' => null
                            ])
                        ];
                        $newEmployee['attendance'][$day - 1] = [
                            'status' => $status,
                            'in_time' => $log['in_time'],
                            'out_time' => $log['out_time']
                        ];
                        $employeeAttendance[] = $newEmployee;
                    }
                }

                $response = [
                    "status" => 200,
                    "message" => "Data Fetching successful",
                    "data" => $employeeAttendance
                ];
            } else {
                $response = ["status" => 404, "message" => "No data found"];
            }
        } catch (Exception $e) {
            error_log('Error fetching attendance data: ' . $e->getMessage());
            $response = ["status" => 500, "message" => "Internal server error"];
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            $erp_conn->close();
        }
        echo json_encode($response);
        break;

    case 'get_sreport_details':
        $month = $_POST['month'] ?? '';
        $year = $_POST['year'] ?? '';

        $uname = $s; // Assuming this function exists
        if (!$uname) {
            $response = ["status" => 401, "message" => "Unauthorized"];
        }

        try {
            // Get faculty department
            $stmt = $db->prepare("SELECT ddept FROM faculty WHERE id = ?");
            $stmt->bind_param("s", $uname);
            $stmt->execute();
            $result = $stmt->get_result();
            $faculty = $result->fetch_assoc();
            $ddept = $faculty['ddept'];
            $stmt->close();

            // Get distinct UIDs
            $stmt = $db->prepare("SELECT id FROM faculty WHERE ddept = ? AND status = 1 AND manager = 'HOD'");
            $stmt->bind_param("s", $ddept);
            $stmt->execute();
            $result = $stmt->get_result();
            $distinctUids = array();
            while ($row = $result->fetch_assoc()) {
                $distinctUids[] = $row['id'];
            }
            $stmt->close();

            $tableNameDeviceLog = "devicelogs_{$month}_{$year}";
            $reports = array();
            $currentDate = date('Y-m-d');

            foreach ($distinctUids as $uid) {
                // Get working days data
                $stmt = $erp_conn->prepare("SELECT * FROM {$tableNameDeviceLog} WHERE uid = ? AND hday = 0");
                $stmt->bind_param("s", $uid);
                $stmt->execute();
                $deviceLogData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                // Get holiday data
                $stmt = $erp_conn->prepare("SELECT * FROM {$tableNameDeviceLog} WHERE uid = ? AND hday = 1");
                $stmt->bind_param("s", $uid);
                $stmt->execute();
                $holidayData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                // Get faculty info
                $stmt = $db->prepare("SELECT name, role FROM faculty WHERE id = ?");
                $stmt->bind_param("s", $uid);
                $stmt->execute();
                $facultyInfo = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                // Get LOP data
                $stmt = $erp_conn->prepare("
                    SELECT lc, status, COUNT(*) as count 
                    FROM {$tableNameDeviceLog} 
                    WHERE uid = ? 
                    AND status IN (0, 2) 
                    AND hday = 0 
                    AND lc NOT IN (1, 0.5)
                    AND mpu = 0
                    AND tdate <= ?
                    GROUP BY lc, status
                ");
                $stmt->bind_param("ss", $uid, $currentDate);
                $stmt->execute();
                $lopData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                // Calculate total LOP
                $totalLOP = 0;
                foreach ($lopData as $record) {
                    if ($record['status'] == 0 && ($record['lc'] == 0 || $record['lc'] != 1)) {
                        $totalLOP += $record['count'];
                    } else if ($record['status'] == 2 || ($record['status'] == 0 && ($record['lc'] == 0.5 || $record['lc'] == 7.5 || $record['lc'] == 8.5))) {
                        $totalLOP += $record['count'] * 0.5;
                    }
                }

                // Get presence data
                $stmt = $erp_conn->prepare("
                SELECT lc, status, mpu, COUNT(*) as count 
                FROM {$tableNameDeviceLog} 
                WHERE uid = ? 
                AND (status = 1 OR status = 2 OR lc IN(1, 0.5) OR mpu > 0)
                GROUP BY status, lc, mpu");

                $stmt->bind_param("s", $uid);
                $stmt->execute();
                $presentData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                // Calculate total presence
                $totalPresence = 0;
                foreach ($presentData as $record) {
                    if ($record['status'] == 1 || $record['lc'] == 1 || $record['mpu'] > 0) {
                        $totalPresence += $record['count'];
                    } else if ($record['status'] == 2 || $record['lc'] == 0.5) {
                        $totalPresence += $record['count'] * 0.5;
                    }
                }

                // Calculate final metrics
                $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $totalWorkingDays = count($deviceLogData);
                $totalHolidays = count($holidayData);
                $totalPresentdays = $totalPresence;
                $totalLopdays = $totalLOP;
                $salaryDay = $totalWorkingDays + $totalHolidays - $totalLopdays;

                // Create report object
                $report = array(
                    'uid' => $uid,
                    'facultyName' => $facultyInfo['name'],
                    'facultyRole' => $facultyInfo['role'],
                    'totalDays' => $totalDays,
                    'totalWorkingDays' => $totalWorkingDays,
                    'totalHolidays' => $totalHolidays,
                    'totalPresentdays' => $totalPresentdays,
                    'totalLopdays' => $totalLopdays,
                    'salaryDay' => $salaryDay
                );

                $reports[] = $report;
            }

            $response = array('status' => 200, 'message' => 'Data Fetching successful', 'data' => $reports);

        } catch (Exception $e) {
            error_log("Error generating report: " . $e->getMessage());
            $response = array('status' => 500, 'message' => 'Failed to generate report');
        } finally {
            $db->close();
        }

        echo json_encode($response);
        break;


    case 'get_lreport_details':
        $uname = $s;
        if (!$uname) {
            return ["status" => 401, "message" => "Unauthorized"];
        }

        $month = $_POST['month'] ?? '';
        $year = $_POST['year'] ?? '';
        $lt = $_POST['ltype'] ?? '';

        // Get faculty info
        $faculty = getFacultyInfo($uname);
        $ddept = $faculty->ddept;
        $manager = $faculty->manager;

        // Calculate dates
        $startDateString = "01-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" . $year;
        $endDate = date("t-m-Y", strtotime($year . "-" . $month . "-01"));
        $endDateString = str_replace("/", "-", $endDate);

        try {
            $userData = [];
            $query = "";

            switch ($lt) {
                case "CL":
                    $query = "SELECT * FROM fleave 
                         WHERE STR_TO_DATE(fdate, '%d-%m-%Y') >= STR_TO_DATE(?, '%d-%m-%Y')
                         AND STR_TO_DATE(tdate, '%d-%m-%Y') <= STR_TO_DATE(?, '%d-%m-%Y')
                         AND dept = ? AND manager = 'HOD'
                         ORDER BY id DESC";
                    break;

                case "OD":
                    $query = "SELECT * FROM fonduty 
                         WHERE STR_TO_DATE(fdate, '%d-%m-%Y') >= STR_TO_DATE(?, '%d-%m-%Y')
                         AND STR_TO_DATE(tdate, '%d-%m-%Y') <= STR_TO_DATE(?, '%d-%m-%Y')
                         AND dept = ? AND manager = 'HOD'
                         ORDER BY id DESC";
                    break;

                case "Permission":
                    $query = "SELECT * FROM fpermission 
                         WHERE STR_TO_DATE(fdate, '%d-%m-%Y') >= STR_TO_DATE(?, '%d-%m-%Y')
                         AND dept = ? AND manager = 'HOD'
                         ORDER BY id DESC";
                    break;

                case "COL Request":
                    $query = "SELECT * FROM fcolreq 
                         WHERE STR_TO_DATE(fdate, '%d-%m-%Y') >= STR_TO_DATE(?, '%d-%m-%Y')
                         AND dept = ? AND manager = 'HOD'
                         ORDER BY id DESC";
                    break;
            }

            $stmt = mysqli_prepare($db, $query);

            if ($lt == "Permission" || $lt == "COL Request") {
                mysqli_stmt_bind_param($stmt, "ss", $startDateString, $ddept);
            } else {
                mysqli_stmt_bind_param($stmt, "sss", $startDateString, $endDateString, $ddept);
            }

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($row = mysqli_fetch_assoc($result)) {
                $row['lt'] = $lt;  // Add leave type to each row
                $userData[] = $row;
            }

            mysqli_stmt_close($stmt);
            mysqli_close($db);

            if (count($userData) > 0) {
                $response = ["status" => 200, "data" => ["data" => $userData]];
            } else {
                error_log("No data found for the selected month and year");
                $response = ["status" => 200, "data" => ["data" => []]];
            }

        } catch (Exception $e) {
            error_log("Error occurred during fetching data: " . $e->getMessage());
            $response = ["status" => 500, "message" => "Internal server error"];
        }

        echo json_encode($response);
        break;






    default:
        echo json_encode(['error' => 'Invalid action']);
}




function getDepartmentCount($db, $dept)
{
    $query = "SELECT COUNT(*) as count FROM faculty WHERE dept=?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "s", $dept);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] ?? 0;
}

function getGenderCount($db, $gender)
{
    $query = "SELECT COUNT(*) as count FROM basic WHERE gender=?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "s", $gender);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] ?? 0;
}




function getFacultyInfo($uname)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM faculty WHERE id = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    $faculty = $result->fetch_object();
    $stmt->close();
    return $faculty;
}


function updateAttendanceRecords($sid, $fdate, $tdate, $fshift, $tshift, $leave, $isDeleting = false)
{
    global $erp_conn;
    try {
        // Convert dates
        $fromDate = new DateTime($fdate);
        $toDate = new DateTime($tdate);
        // Generate date range
        $dateRange = new DatePeriod(
            $fromDate,
            new DateInterval('P1D'),
            $toDate->modify('+1 day')
        );

        // Process each date
        foreach ($dateRange as $date) {
            $formattedDate = $date->format('Y-m-d');

            // Determine lc value
            if ($isDeleting) {
                $lcValue = 0;
                $lc2Value = null;
            } else {
                $lcValue = 1; // Default full day
                $lc2Value = null;
                if ($date->format('Y-m-d') === $fromDate->format('Y-m-d') && $fshift == 0.5) {
                    $lcValue = 0.5;
                } else if ($date->format('Y-m-d') === $toDate->format('Y-m-d') && $tshift == 0.5) {
                    $lcValue = 0.5;
                }
            }

            // Get year and month for table name
            $year = $date->format('Y');
            $month = $date->format('m');
            $leaveType = $isDeleting ? null : $leave;
            $tableName = "devicelogs_" . intval($month) . "_" . $year;

            // Check existing record for both lc and lc2
            $checkStmt = $erp_conn->prepare("SELECT lc, lc2 FROM `" . $tableName . "` WHERE uid = ? AND tdate = ?");
            $checkStmt->bind_param("ss", $sid, $formattedDate);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            $row = $result->fetch_assoc();
            $checkStmt->close();

            if ($row) {
                $existingLc = floatval($row['lc']);
                $existingLc2 = is_null($row['lc2']) ? 0 : floatval($row['lc2']);

                // Decision logic based on existing values
                if ($existingLc == 0.5 && $existingLc2 == 8.5) {
                    // Case: lc is 8.5 and lc2 is 7.5 - update lc2 and ltype2
                    $updateStmt = $erp_conn->prepare("UPDATE `" . $tableName . "` SET lc2 = ?, ltype2 = ? WHERE uid = ? AND tdate = ?");
                    $updateStmt->bind_param("dsis", $lcValue, $leaveType, $sid, $formattedDate);
                } else if (
                    ($existingLc == 8.5 && $existingLc2 == 0) ||
                    ($existingLc == 8.5 && $existingLc2 == 8.5)
                ) {
                    // Case: lc is 7.5 and (lc2 is 0 or 7.5) - update lc and ltype
                    $updateStmt = $erp_conn->prepare("UPDATE `" . $tableName . "` SET lc = ?, ltype = ? WHERE uid = ? AND tdate = ?");
                    $updateStmt->bind_param("dsis", $lcValue, $leaveType, $sid, $formattedDate);
                } else {
                    // Default case - update lc and ltype
                    $updateStmt = $erp_conn->prepare("UPDATE `" . $tableName . "` SET lc = ?, ltype = ? WHERE uid = ? AND tdate = ?");
                    $updateStmt->bind_param("dsis", $lcValue, $leaveType, $sid, $formattedDate);
                }
            } else {
                // No existing record - insert with lc and ltype
                $updateStmt = $erp_conn->prepare("INSERT INTO `" . $tableName . "` (uid, tdate, lc, ltype) VALUES (?, ?, ?, ?)");
                $updateStmt->bind_param("ssds", $sid, $formattedDate, $lcValue, $leaveType);
            }

            $updateStmt->execute();
            $updateStmt->close();
            error_log("Data updated in target database for " . $formattedDate);
        }
    } catch (Exception $e) {
        error_log("Error updating attendance records: " . $e->getMessage());
        throw $e;
    } finally {
        $erp_conn->close();
    }
}


function updatePermissionRecords($uid, $fdate, $leave, $isDeleting = false)
{
    global $erp_conn;
    error_log($fdate);

    list($year, $month, $day) = explode('-', $fdate);
    $fromDate = new DateTime($fdate);
    $formattedDate = $fromDate->format('Y-m-d');
    $tableName = "devicelogs_" . intval($month) . "_" . $day;
    error_log($tableName);

    $leaveTypes = [
        'Morning' => 'mp',
        'Evening' => 'ep',
        '10minM' => 'tmp',
        '10minE' => 'tep'
    ];

    $lt = isset($leaveTypes[$leave]) ? $leaveTypes[$leave] : '';
    $lcValue = $isDeleting ? 0 : 1;

    try {
        // Using prepared statement for the dynamic table name
        $stmt = $erp_conn->prepare("UPDATE `$tableName` SET `$lt` = ?, ltype = ? WHERE uid = ? AND tdate = ?");
        $ltype = $isDeleting ? null : $leave;
        $stmt->bind_param("isss", $lcValue, $ltype, $uid, $formattedDate);
        $stmt->execute();
        $stmt->close();

        error_log("Data updated in target database for " . $fdate);
    } catch (Exception $error) {
        error_log("Error updating attendance records: " . $error->getMessage());
        throw $error;
    }
}

function getStatusAbbreviation($status, $hday, $lc, $mpu, $mp, $tdate, $in_time, $out_time)
{
    $today = new DateTime();

    if ($mpu === 1) {
        return 'MP';
    }

    if ($tdate > $today) {
        return '-'; // Future date
    }

    if ($hday === 1) {
        return 'H';
    }

    if ($lc === 1) {
        return 'L';
    }

    // Check for absent first
    if ($in_time === null && $out_time === null) {
        return 'AB';
    }

    switch ($status) {
        case 1:
            return 'P';
        case 0:
        case 2:
            return 'S';
        default:
            return '-';
    }
}



function fetchDataFromSource($month, $year, $sourceConnection, $targetConnection, $micConnection)
{


    $tableName = "devicelogs_" . $month . "_" . $year;
    try {
        $stmt = mysqli_prepare($sourceConnection, "SELECT * FROM $tableName");
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);

        $dataByUserId = [];
        while ($row = mysqli_fetch_assoc($results)) {
            $userId = $row["UserId"];
            if (!isset($dataByUserId[$userId])) {
                $dataByUserId[$userId] = [];
            }
            $dataByUserId[$userId][] = $row;
        }

        foreach ($dataByUserId as $userId => $userData) {
            insertDataIntoTarget($tableName, $userData, $targetConnection, $micConnection);
        }
    } catch (Exception $e) {
        echo "Error fetching data from source database: " . $e->getMessage();
        throw $e;
    }
}

function insertDataIntoTarget($sourceTableName, $data, $targetConnection, $micConnection)
{
    //global $targetConnection, $micConnection;

    $logEntriesByDateAndUser = [];
    foreach ($data as $row) {
        $logDate = new DateTime($row["LogDate"]);
        $dateKey = $logDate->format("Y-m-d");
        $userId = $row["UserId"];
        if (!isset($logEntriesByDateAndUser[$dateKey])) {
            $logEntriesByDateAndUser[$dateKey] = [];
        }
        if (!isset($logEntriesByDateAndUser[$dateKey][$userId])) {
            $logEntriesByDateAndUser[$dateKey][$userId] = [];
        }
        $logEntriesByDateAndUser[$dateKey][$userId][] = $row;
    }

    $fetchFacultyQuery = "
      SELECT id, name AS fname, role
      FROM faculty
    ";

    try {
        $stmt = mysqli_prepare($micConnection, $fetchFacultyQuery);
        mysqli_stmt_execute($stmt);
        $facultyData = mysqli_stmt_get_result($stmt);

        $facultyInfo = [];
        while ($row = mysqli_fetch_assoc($facultyData)) {
            $facultyInfo[$row["id"]] = ["fname" => $row["fname"], "role" => $row["role"]];
        }

        foreach ($logEntriesByDateAndUser as $dateKey => $userEntries) {
            foreach ($userEntries as $userId => $logEntries) {
                $inTime = convertTo24HourFormat($logEntries[0]["LogDate"]);
                $outTime = convertTo24HourFormat($logEntries[count($logEntries) - 1]["LogDate"]);

                $facultyEntry = $facultyInfo[$userId] ?? ["fname" => "NA", "role" => "NA"];
                $fname = $facultyEntry["fname"];
                $role = $facultyEntry["role"];

                $checkQuery = "
            SELECT id, uid, in_time, out_time, mp, ep, tmp, tep, lc, shiftin, shiftout
            FROM $sourceTableName
            WHERE uid = ? AND tdate = ?
          ";
                $stmt = mysqli_prepare($targetConnection, $checkQuery);
                mysqli_stmt_bind_param($stmt, "ss", $userId, $dateKey);
                mysqli_stmt_execute($stmt);
                $checkResults = mysqli_stmt_get_result($stmt);
                $existingEntry = mysqli_fetch_assoc($checkResults);

                $id = $existingEntry["id"] ?? null;
                $uid = $existingEntry["uid"];
                $existingInTime = $existingEntry["in_time"];
                $existingOutTime = $existingEntry["out_time"];
                $mp = $existingEntry["mp"];
                $ep = $existingEntry["ep"];
                $tmp = $existingEntry["tmp"];
                $tep = $existingEntry["tep"];
                $lc = $existingEntry["lc"];
                $shiftin = $existingEntry["shiftin"] ?? "08:40:00";
                $shiftout = $existingEntry["shiftout"] ?? "17:00:00";

                $lateMorningThreshold = "09:40:00";
                $eveningPermissionThreshold = "16:00:00";
                $TMorningPermissionThreshold = "08:50:00";
                $TeveningPermissionThreshold = "16:50:00";

                if (isset($existingEntry["id"])) {
                    $updateOrInsertQuery = "
              UPDATE $sourceTableName
              SET in_time = ?, out_time = ?, status = ?, fname = ?, role = ?
              WHERE id = ?
            ";
                    $stmt = mysqli_prepare($targetConnection, $updateOrInsertQuery);
                    mysqli_stmt_bind_param($stmt, "sssssi", $inTime, $outTime, $status, $fname, $role, $id);
                } else {
                    $updateOrInsertQuery = "
              INSERT INTO $sourceTableName (uid, tdate, in_time, out_time, status, fname, role)
              VALUES (?, ?, ?, ?, ?, ?, ?)
            ";
                    $stmt = mysqli_prepare($targetConnection, $updateOrInsertQuery);
                    mysqli_stmt_bind_param($stmt, "sssssss", $userId, $dateKey, $inTime, $outTime, $status, $fname, $role);
                }

                $morningPermission = $mp === 1;
                $TmorningPermission = $tmp === 1;
                $eveningPermission = $ep === 1;
                $TeveningPermission = $tep === 1;
                $leaveValue = $existingEntry["lc"];

                // Combined morning and evening permission checks
                $inTimeValid =
                    $inTime <= $shiftin ||
                    ($inTime > $shiftin && $inTime <= $lateMorningThreshold && ($morningPermission || $TmorningPermission));

                $outTimeValid =
                    $outTime >= $shiftout ||
                    ($outTime >= $eveningPermissionThreshold && $outTime < $shiftout && ($eveningPermission || $TeveningPermission));

                if ($inTimeValid && $outTimeValid) {
                    $status = 1; // Present
                } elseif ($inTime === null && $outTime === null && $leaveValue > 0) {
                    $status = 1; // Present (Leave applied for the whole day)
                } elseif ($inTime > "12:40:00" && $leaveValue === 0.5) {
                    $status = 1; // Present (Leave applied for the morning)
                } elseif ($outTime > "12:40:00" && $leaveValue === 0.5) {
                    $status = 1; // Present (Leave applied for the afternoon)
                } elseif ($inTime > "12:40:00" && $leaveValue === 0) {
                    $status = 2; // Present (Leave applied for the morning)
                } elseif ($outTime > "12:40:00" && $leaveValue === 0) {
                    $status = 2; // Present (Leave applied for the afternoon)
                } else {
                    $status = 0; // Absent
                }

                mysqli_stmt_execute($stmt);
            }
        }
    } catch (Exception $e) {
        echo "Error in insertDataIntoTarget: " . $e->getMessage();
        throw $e;
    }
}

function convertTo24HourFormat($dateTime)
{
    $date = new DateTime($dateTime);
    return $date->format("H:i:s");
}

function updateManualPunch($formData)
{
    global $targetConnection;

    $id = $formData->get("id");
    $mdate = $formData->get("mdate");

    $year = explode("-", $mdate)[0];
    $month = explode("-", $mdate)[1];
    $formattedMonth = intval($month);
    $tableName = "devicelogs_" . $formattedMonth . "_" . $year;

    try {
        $sql = "UPDATE $tableName SET mpu = 1 WHERE uid = ? AND tdate = ?";
        $stmt = mysqli_prepare($targetConnection, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $id, $mdate);
        mysqli_stmt_execute($stmt);

        if (mysqli_affected_rows($targetConnection) > 0) {
            return ["status" => 200, "message" => "Manual punch updated successfully"];
        } else {
            return ["status" => 401, "message" => "Failed to update manual punch"];
        }
    } catch (Exception $e) {
        echo "Error updating manual punch: " . $e->getMessage();
        throw $e;
    }
}

function updateManualShift($formData)
{
    global $targetConnection;

    $mdate = $formData->get("sdate");
    $sin = $formData->get("sin");
    $sout = $formData->get("sout");

    $year = explode("-", $mdate)[0];
    $month = explode("-", $mdate)[1];
    $formattedMonth = intval($month);
    $tableName = "devicelogs_" . $formattedMonth . "_" . $year;

    try {
        $sql = "UPDATE $tableName SET shiftin = ?, shiftout = ? WHERE tdate = ?";
        $stmt = mysqli_prepare($targetConnection, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $sin, $sout, $mdate);
        mysqli_stmt_execute($stmt);

        if (mysqli_affected_rows($targetConnection) > 0) {
            return ["status" => 200, "message" => "Manual Shift updated successfully"];
        } else {
            return ["status" => 401, "message" => "Failed to update manual shift"];
        }
    } catch (Exception $e) {
        echo "Error updating manual shift: " . $e->getMessage();
        throw $e;
    }
}

//   function MultiPunch( $id,$mdate,$sourceConnection) {


//     $year = explode("-", $mdate)[0];
//     $month = explode("-", $mdate)[1];
//     $formattedMonth = intval($month);
//     $tableName = "devicelogs_" . $formattedMonth . "_" . $year;

//     try {
//       $sql = "SELECT LogDate FROM $tableName WHERE UserId = ? AND DATE(LogDate) = ?";
//       $stmt = mysqli_prepare($sourceConnection, $sql);
//       mysqli_stmt_bind_param($stmt, "ss", $id, $mdate);
//       mysqli_stmt_execute($stmt);
//       $results = mysqli_stmt_get_result($stmt);

//       if (mysqli_num_rows($results) > 0) {
//         $punchTimings = [];
//         while ($row = mysqli_fetch_assoc($results)) {
//           $punchTimings[] = $row["LogDate"];
//         }
//         return ["status" => 200, "message" => "Punch timings found", "data" => $punchTimings];
//       } else {
//         return ["status" => 404, "message" => "No punch timings found for the given date"];
//       }
//     } catch (Exception $e) {
//       echo "Error fetching punch timings: " . $e->getMessage();
//       throw $e;
//     }
//   }

?>