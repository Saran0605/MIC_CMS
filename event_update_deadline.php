<?php

$sql_updates = "UPDATE user  SET previous_status = status_no, status_no = ? 
WHERE status_no IN (0, 1, 2, 3, 4, 5, 6, 11, 12, 13)  
AND DATE_ADD(ending_date, INTERVAL 15 DAY) < CURDATE() AND  previous_status IS  NULL";
if ($stmt = $conn->prepare($sql_updates)) {
  $status_no = 14;
  $stmt->bind_param("i", $status_no);
  if ($stmt->execute()) {
    // echo "Deadline statuses updated successfully";
  } else {
    //echo "Error executing statement: " . $stmt->error;
  }
  $stmt->close();
} else {
  //echo "Error preparing statement: " . $conn->error;
}
