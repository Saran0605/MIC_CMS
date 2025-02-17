<?php
require 'config.php';
require 'session.php';

if (isset($_POST['save_stdname'])) {
    $fa = mysqli_real_escape_string($db, $_POST['faculty']);

    if (isset($_POST["selected_students"]) && is_array($_POST["selected_students"])) {
        $stmt = $db->prepare("UPDATE student SET mentor=? WHERE sid=?");

        foreach ($_POST["selected_students"] as $selected_student) {
            $stmt->bind_param("ss", $fa, $selected_student);
            $stmt->execute();
        }

        if ($stmt->affected_rows > 0) {
            $res = [
                'status' => 200,
                'message' => 'Mentor Added Successfully'
            ];
        } else {
            $res = [
                'status' => 500,
                'message' => 'Mentor Not Added'
            ];
        }

        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 502,
            'message' => 'No students selected'
        ];
        echo json_encode($res);
        return;
    }
}

if (isset($_POST['save_csv'])) {
    $ay = mysqli_real_escape_string($db, $_POST['ayear']);
    if (isset($_FILES["csvfile"]) && $_FILES["csvfile"]["error"] == 0) {
        $file = $_FILES["csvfile"]["tmp_name"];
        $handle = fopen($file, "r");
        $firstRow = true;
        $stmt1 = $db->prepare("INSERT INTO student (sid, sname, ayear, mail, dept, pass, section) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt2 = $db->prepare("INSERT INTO sbasic (sid, batch) VALUES (?, ?)");
        try {
            $currentRow = 1; // Track current row number
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($firstRow) {
                    $firstRow = false;
                    continue;
                }
                $currentRow++;
                try {
                    // First try student table insert
                    $stmt1->bind_param("sssssss", $data[0], $data[1], $ay, $data[2], $data[3], $data[0], $data[4]);
                    $stmt1->execute();
                    
                    // Then try sbasic table insert
                    $stmt2->bind_param("ss", $data[0], $ay);
                    $stmt2->execute();
                    
                } catch (mysqli_sql_exception $e) {
                    fclose($handle);
                    
                    // Check which table caused the error using the error code
                    $duplicateTable = "";
                    $duplicateValue = "";
                    
                    // Get the error code
                    if (strpos($e->getMessage(), 'student') !== false) {
                        $duplicateTable = "student";
                        $duplicateValue = "Student ID: " . $data[0];
                    } else if (strpos($e->getMessage(), 'sbasic') !== false) {
                        $duplicateTable = "sbasic";
                        $duplicateValue = "Student ID: " . $data[0];
                    }
                    
                    $res = [
                        'status' => 500,
                        'message' => "Duplicate Entry found",
                        'details' => [
                            'table' => $duplicateTable,
                            'value' => $duplicateValue,
                            'row' => $currentRow
                        ]
                    ];
                    echo json_encode($res);
                    return;
                }
            }
            fclose($handle);
            
            if ($stmt1->affected_rows > 0) {
                $res = [
                    'status' => 200,
                    'message' => 'Students added Successfully'
                ];
            } else {
                $res = [
                    'status' => 500,
                    'message' => 'Failed to add students'
                ];
            }
            echo json_encode($res);
            return;
        } catch (Exception $e) {
            $res = [
                'status' => 500,
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage()
            ];
            echo json_encode($res);
            return;
        }
    }
}
if (isset($_POST['save_stdname1'])) {
    $fa = mysqli_real_escape_string($db, $_POST['faculty']);

    if (isset($_POST["selected_students"]) && is_array($_POST["selected_students"])) {
        $stmt = $db->prepare("UPDATE student SET mentor='' WHERE sid=?");

        foreach ($_POST["selected_students"] as $selected_student) {
            $stmt->bind_param("s", $selected_student);
            $stmt->execute();
        }

        if ($stmt->affected_rows > 0) {
            $res = [
                'status' => 200,
                'message' => 'Mentees Deleted Successfully'
            ];
        } else {
            $res = [
                'status' => 500,
                'message' => 'Mentees Not Deleted'
            ];
        }

        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 502,
            'message' => 'No students selected'
        ];
        echo json_encode($res);
        return;
    }
}
?>
